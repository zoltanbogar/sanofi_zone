<?php
/**
 * Created by PhpStorm.
 * User: lakirobert
 * Date: 2018-11-30
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin\Claim;

use App\User;
use App\Claim;
use App\Zone;
use App\ApprovedClaim;
use App\RejectedClaim;
//use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Titan\Controllers\TitanAdminController;
use Illuminate\Support\Facades\Auth;
//use DB;

class ClaimController extends TitanAdminController
{

    public function newclaim()
    {
        $user = Auth::user();
        $tblAllUser = User::select('id', 'firstname', 'lastname')->/*where('id', '!=' , $user->id)->*/get();
        $tblAllZone = Zone::with('userManyRelation')->with('site')->/*where('id', '!=' , $user->id)->*/get();
        //$actualTime = Carbon::now()->format('F d, Y h:i A');

        return $this->view('claim/new_claim', ["user" => $user, "tblAllUser" => $tblAllUser, "tblAllZone" => $tblAllZone/*, "time" => $actualTime*/]);
    }

    public function index()
    {
        $user = Auth::user();
        $claim = Claim::where('claimer_user_id', $user->id)->get();
        $claim = \DB::table('claims')
            ->join('zones', 'zones.id', '=', 'claims.zone_id')
            ->join('users', 'claims.target_user_id', '=', 'users.id')
            ->leftjoin('approved_claims', 'claims.id', '=', 'approved_claims.claim_id')
            ->leftjoin('rejected_claims', 'claims.id', '=', 'rejected_claims.claim_id')
            ->select('users.*', 'zones.*', 'claims.*', 'rejected_claims.created_at as rejected_claims_created_at', 'approved_claims.created_at as approved_claims_created_at')
            ->where('claims.claimer_user_id', '=', $user->id)
            ->get();

        return $this->view('claim/claim', ["tblClaim" => $claim]);
    }

    public function approval()
    {
        $user = Auth::user();
        $claim = Claim::where('claimer_user_id', $user->id)->get();
        $zones = \DB::table('zones')
            ->join('claims', 'zones.id', '=', 'claims.zone_id')
            ->join('users', 'claims.target_user_id', '=', 'users.id')
            ->leftjoin('approved_claims', 'claims.id', '=', 'approved_claims.claim_id')
            ->leftjoin('rejected_claims', 'claims.id', '=', 'rejected_claims.claim_id')
            ->select('users.*', 'zones.*', 'claims.*', 'claims.id as claim_id', 'rejected_claims.created_at as rejected_claims_created_at', 'approved_claims.created_at as approved_claims_created_at')
            //->where('zones.user_id', '=', $user->id)
            ->orderBy('claims.claim_date', 'ASC')
            ->get();

        //dd($zones);

        return $this->view('claim/approval', ["zones" => $zones]);
    }

    public function delete()
    {
        $user = Auth::user();
        $myClaims = $zones = \DB::table('claims')
            ->join('zones', 'zones.id', '=', 'claims.zone_id')
            ->join('sites', 'zones.site_id', '=', 'sites.id')
            ->join('users', 'claims.target_user_id', '=', 'users.id')
            ->where('claims.claimer_user_id', '=', $user->id)
            ->select('zones.name as zone_name', 'claims.*', 'sites.name as site_name', 'claims.claim_date as claim_date', 'users.firstname', 'users.lastname')
            ->orderBy('claims.claim_date', 'DESC')
            ->get();

        $targetClaims = $zones = \DB::table('claims')
            ->join('zones', 'zones.id', '=', 'claims.zone_id')
            ->join('sites', 'zones.site_id', '=', 'sites.id')
            ->where('claims.target_user_id', '=', $user->id)
            ->orderBy('claims.claim_date', 'DESC')
            ->get();

        return $this->view('claim/deletion', ["myClaims" => $myClaims, "targetClaims" => $targetClaims]);
    }

    public function submit(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'claimer_id' => 'required|numeric',
            'targer_user_id' => 'required|numeric',
            'job_type' => 'required',
            'claim_date' => 'required|date',
            'time_limit' => 'required|present',
            'zones' => 'present|array',

        ]);

        foreach($data["zones"] as $key => $zone){
            $claim = new Claim();
            $claim->claimer_user_id = $data["claimer_id"];
            $claim->target_user_id = $data["targer_user_id"];
            $claim->zone_id = $zone;
            $claim->authorized_from = $data["time_limit"][$zone]["time_limit_from"];
            $claim->authorized_to = $data["time_limit"][$zone]["time_limit_to"];
            $claim->job_type = $data["job_type"];
            $claim->claim_date = $data["claim_date"];

            $claim->save();
        }

        return Response::json(['success' => "Claim submitted!", "data" => $claim], 201);
    }

    public function approveClaim(Request $request)
    {
        $this->validate($request, [
            'claim_id' => 'required|numeric'
        ]);

        $data = $request->all();

        $approvedClaim = new ApprovedClaim();
        $approvedClaim->claim_id = $data["claim_id"];
        $approvedClaim->save();

        $rejectedClaim = RejectedClaim::where('claim_id', '=', $data["claim_id"])->first();
        if($rejectedClaim != NULL)
            $rejectedClaim->delete();

        return Response::json(['success' => "Claim approved!", "text" => "Approved"], 200);
    }

    public function rejectClaim(Request $request)
    {
        $this->validate($request, [
            'claim_id' => 'required|numeric'
        ]);

        $data = $request->all();

        $rejectedClaim = new RejectedClaim();
        $rejectedClaim->claim_id = $data["claim_id"];
        $rejectedClaim->save();

        $approvedClaim = ApprovedClaim::where('claim_id', '=', $data["claim_id"])->first();
        if($approvedClaim != NULL)
            $approvedClaim->delete();

        return Response::json(['success' => "Claim rejected!", "text" => "Rejected"], 200);
    }

    public function deleteClaim(Request $request)
    {
        $this->validate($request, [
            'claim_id' => 'required|numeric'
        ]);

        $data = $request->all();

        $rejectedClaim = RejectedClaim::where('claim_id', '=', $data["claim_id"])->first();
        if($rejectedClaim != NULL)
            $rejectedClaim->delete();

        $approvedClaim = ApprovedClaim::where('claim_id', '=', $data["claim_id"])->first();
        if($approvedClaim != NULL)
            $approvedClaim->delete();

        $claim = Claim::find($data["claim_id"]);
        if($claim != NULL)
            $claim->delete();

        return Response::json(['success' => "Claim deleted!"], 200);
    }
}