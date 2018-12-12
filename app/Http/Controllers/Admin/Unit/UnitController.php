<?php
/**
 * Created by PhpStorm.
 * User: lakirobert
 * Date: 2018-12-03
 * Time: 17:48
 */

namespace App\Http\Controllers\Admin\Unit;

use App\Site;
use App\Zone;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Titan\Controllers\TitanAdminController;
use Illuminate\Support\Facades\Auth;

class UnitController extends TitanAdminController
{
    public function site()
    {
        $tblSites = Site::orderBy('parent_id', 'ASC')->get();

        $menuData = array(
            'items' => array(),
            'parents' => array()
        );

        foreach($tblSites as $menuItem)
        {
            $menuData['items'][$menuItem->id] = $menuItem;
            $menuData['parents'][$menuItem->parent_id][] = $menuItem->id;
        }

        $html = $this->createSiteStructure(0, $menuData);

        return $this->view('unit/site', ["data" => $html, 'sites' => $tblSites]);
    }

    public function zone()
    {
        $tblZones = Zone::with('userManyRelation')->with('site')->orderBy('site_id', 'ASC')->get();
        $tblSites = Site::orderBy('id', 'ASC')->get();
        $tblUsers = User::orderBy('id', 'ASC')->get();
        //dd($tblZones);
        return $this->view('unit/zone', ["zones" => $tblZones, "sites" => $tblSites, "users" => $tblUsers]);
    }

    public function createSiteStructure($parentId, $menuData)
    {
        $html = '';

        if (isset($menuData['parents'][$parentId]))
        {
            $html = '<ul>';
            foreach ($menuData['parents'][$parentId] as $itemId)
            {
                $html .= '<li class="' . ($parentId == 0 ? '' : "hidden") . '"><button class="btn btn-default toggleButton" onclick="toggleUnitHandler(this)"><i class="glyphicon glyphicon-arrow-down"></i></button><span site_id="' . $menuData['items'][$itemId]['id'] . '">' . $menuData['items'][$itemId]['name'] . '</span><button class="btn btn-default" onclick="deleteUnitHandler(this)">Delete</button>';

                $html .= $this->createSiteStructure($itemId, $menuData);

                $html .= '</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    public function newSite(Request $request)
    {
        $this->validate($request, [
            'site_name' => 'required'
        ]);

        $data = $request->all();

        $site = new Site();
        $site->name = $data["site_name"];
        $site->parent_id = $data["parent_id"];
        if(!$site->save()){
            return Response::json(['error' => "Unknown error"], 500);
        }

        return Response::json(['success' => "Site saved!"], 201);
    }

    public function newZone(Request $request)
    {
        $this->validate($request, [
            'zone_name' => 'required',
            'person_id' => 'required',
            'parent_id' => 'required'
        ]);

        $data = $request->all();
        $site = Site::find($data["parent_id"]);
        $user = Auth::user();

        $zone = new Zone();
        $zone->name = $data["zone_name"];
        $zone->created_by = $user->id;


        $zone->site()->associate($site);

        $zone->save();

        $userZoneRightholder = User::find($data["person_id"]);
        //dd($zone);

        if(!$zone->userManyRelation()->toggle($userZoneRightholder)){
            return Response::json(['error' => "Saving error"], 500);
        }

        return Response::json(['success' => "Zone saved!"], 201);
    }

    public function removeSite(Request $request)
    {
        $this->validate($request, [
            'site_id' => 'required|numeric'
        ]);

        $data = $request->all();

        $site = Site::where('parent_id', '=', $data["site_id"])->first();
        if($site || !Site::where('id', '=', $data["site_id"])->delete()){
            return Response::json("Cannot be deleted", 400);
        }

        return Response::json(['success' => "Site deleted!"], 200);
    }

    public function removeZone(Request $request)
    {
        $this->validate($request, [
            'zone_id' => 'required|numeric'
        ]);

        $data = $request->all();

        //$site = Site::where('parent_id', '=', $data["site_id"])->first();
        if(!Zone::where('id', '=', $data["zone_id"])->delete()){
            return Response::json("Cannot be deleted", 400);
        }

        return Response::json(['success' => "Zone deleted!"], 200);
    }
}