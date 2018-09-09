<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;
use App\Gamesession;
use Log;
use Auth;

class UserController extends Controller {

	public function checkEmailAvailability()
	{
		$data = Request::all();
		$availability = User::checkEmailAvailability($data["email"]);
		if ($availability) {
			return 'false';
		} else {
			return 'true';
		}
	}

	public function savedGames()
	{
		$user = Auth::user();
		$res = $user->gamesessions()->get();
		for ($i=0; $i < count($res); $i++) {
			$seconds = (int)$res[$i]->timer;
			$hours = floor($seconds / 3600);
			$mins = floor($seconds / 60 % 60);
			$secs = floor($seconds % 60);
			$time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			$res[$i]->timer = $time;
		}
		// dd($res);
		return view('savedgames', ["savedgames"=>$res]);
	}

	public function saveGame()
	{
		$data = Request::all();
		array_shift($data);
		$gamesession_id = Gamesession::saveGame($data["data"]);
		return $gamesession_id;
	}

	public function continueGame($game_id)
	{
		$gamesession = Gamesession::find($game_id);
		$map = $gamesession->map()->first();
		$map->structure = json_decode($map->structure,true);

		$seconds = (int)$gamesession->timer;
		$hours = floor($seconds / 3600);
		$mins = floor($seconds / 60 % 60);
		$secs = floor($seconds % 60);
		$time = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
		$gamesession->timerString = $time;

		return view("savedgame", ["savedgame"=>$gamesession, "map"=>$map]);
	}

	public function deleteGame($game_id)
	{
		Gamesession::deleteGame($game_id);
		return redirect("/saved-games")->with(["message"=>"deleted"]);
	}

}