<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Map;
use Log;

class Gamesession extends Model {
	protected $table = 'gamesessions';
	protected $fillable = [
						"enemies",
						"enemiesProto",
            			"towers",
            			"towersProto",
            			"addedLife",
            			"timer",
            			"money",
            			"stopped",
            			"attackerPoints",
            			"addEnemyTimer",
            			"user_id",
            			"map_id"
						];


	public function user()
	{
		return $this->belongsTo("App\User");
	}
	public function map()
	{
		return $this->belongsTo("App\Map");
	}

	public static function saveGame($data)
	{
		$user=User::find($data["user_id"]);
		$map=Map::find($data["map_id"]);

		$enemies = "";
		$towers = "";
		if (isset($data["enemies"])) {
			$enemies = $data["enemies"];
			$enemiesProto = $data["enemiesProto"];
		}
		if (isset($data["towers"])) {
			$towers = $data["towers"];
			$towersProto = $data["towersProto"];
		}

		Log::info($enemies);

		if ($data["update"] == "false") {
			$gamesession = new Gamesession();
			$gamesession->enemies = $enemies;
			$gamesession->enemiesProto = $enemiesProto;
			$gamesession->towers = $towers;
			$gamesession->towersProto = $towersProto;
			$gamesession->addedLife = $data["addedLife"];
			$gamesession->timer = $data["timer"];
			$gamesession->money = $data["money"];
			$gamesession->stopped = $data["stopped"];
			$gamesession->attackerPoints = $data["attackerPoints"];
			$gamesession->addEnemyTimer = $data["addEnemyTimer"];
			$gamesession->user()->associate($user);
			$gamesession->map()->associate($map);
			$gamesession->save();
			return $gamesession->id;
		} else {
			$gamesession = Gamesession::find((int)$data["game_id"]);
			$gamesession->enemies = $enemies;
			$gamesession->enemiesProto = $enemiesProto;
			$gamesession->towers = $towers;
			$gamesession->towersProto = $towersProto;
			$gamesession->addedLife = $data["addedLife"];
			$gamesession->timer = $data["timer"];
			$gamesession->money = $data["money"];
			$gamesession->stopped = $data["stopped"];
			$gamesession->attackerPoints = $data["attackerPoints"];
			$gamesession->addEnemyTimer = $data["addEnemyTimer"];
			$gamesession->save();
			return $data["game_id"];
		}
		
	}

	public static function deleteGame($game_id)
	{
		$gamesession = Gamesession::find($game_id);
		$gamesession->delete();
	}

}