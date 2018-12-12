<?php
/**
 * Created by PhpStorm.
 * User: lakirobert
 * Date: 2018-11-30
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin\Claim;

use App\User;
use Claim\Claim;
use Zone\Zone;
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
        $tblAllZone = Zone::with('user')->with('site')->/*where('id', '!=' , $user->id)->*/get();
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
            ->select('users.*', 'zones.*', 'claims.*')
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
            ->select('users.*', 'zones.*', 'claims.*', 'claims.id as claim_id')
            //->where('zones.user_id', '=', $user->id)
            ->get();

        //dd($zones);

        return $this->view('claim/approval', ["zones" => $zones]);
    }

    public function delete()
    {
        return $this->view('claim/deletion');
    }

    public function submit(Request $request)
    {
        $data = $request->all();
        if($data["claimer_id"] == "") return Response::json("Missing claimer user id", 404);
        if($data["targer_user_id"] == "") return Response::json("Missing target user id", 404);
        if($data["job_type"] == "") return Response::json("Missing job type id", 404);
        if($data["claim_date"] == "") return Response::json("Missing job type id", 404);
        if(empty($data["zones"])) return Response::json("Missing job type id", 404);
        if($data["time_limit_from"] == "") return Response::json("Missing job type id", 404);
        if($data["time_limit_to"] == "") return Response::json("Missing job type id", 404);

        foreach($data["zones"] as $key => $zone){
            $claim = new Claim();
            $claim->claimer_user_id = $data["claimer_id"];
            $claim->target_user_id = $data["targer_user_id"];
            $claim->zone_id = $zone;
            $claim->authorized_from = $data["time_limit_from"];
            $claim->authorized_to = $data["time_limit_to"];
            $claim->job_type = $data["job_type"];
            $claim->claimed_at = $data["claim_date"];

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
        $user = Auth::user();
        $claim = Claim::where('id', '=', $data["claim_id"])->first();

        return Response::json(['success' => "Claim approved!", "user" => $user, "claim" => $claim], 200);
    }
}