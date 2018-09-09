<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model {
	protected $table = 'maps';
	protected $fillable = [
							'name',
							'structure',
							'background',
							'width', 
							'height'
						];

	public static function createMaps()
	{
		Map::create(array(
			"name"=>"Stalingrad",
			"structure"=>json_encode(array("maxWidth"=>600, "vBorders"=>[100,502], "hBorders"=>[152,310,450])),
			"background"=>"/images/bg1.png",
			"width"=>600,
			"height"=>600
			));
		Map::create(array(
			"name"=>"Berlin",
			"structure"=>json_encode(array("maxWidth"=>600, "vBorders"=>[502,502], "hBorders"=>[180,190,450])),
			"background"=>"/images/bg2.png",
			"width"=>600,
			"height"=>600
			));
	}

	public static function getMapById($map_id)
	{
		$map = Map::find($map_id);
		return $map;
	}
}