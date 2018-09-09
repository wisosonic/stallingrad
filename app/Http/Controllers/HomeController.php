<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Map;

class HomeController extends Controller {

	public function checkInstallation()
	{
		$installed = env("INSTALLED");
		if ($installed == "0") {
			return false;
		} else {
			return true;
		}
	}

	public function index()
	{
		if (self::checkInstallation()) {
			return view("homepage");
		} else {
			return view("installation");
		}
		
	}

	public function getMaps()
	{
		$maps = Map::all();
		return view("maps", ["maps"=>$maps]);
	}

	public function startMap($map_id)
	{
		$map = Map::getMapById($map_id);
		$map->structure = json_decode($map->structure,true);
		return view("game", ["map"=>$map]);
	}

	public function getReport()
	{
		$pdfname = "rapport_rani_totonji.pdf" ;
		$content = file_get_contents($pdfname);
		return Response::make($content, 200, array('content-type'=>'application/pdf'));
	}
}
