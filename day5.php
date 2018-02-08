<?php

include 'include/utils.php';
include 'Models/Model.php';

include 'Models/Player.php';
include 'Models/Team.php';
include 'Models/Game.php';
include 'Models/Action.php';

function test() {

	$team = Team::get(1);
	echo "<pre>";
	var_dump($team);
	echo "</pre>";

	$team2 = Team::get(1)->describe();

	$data = [
		'PlayerName' => 'James Ruppert 2',
	];
	$player = Player::get(1)
		->set($data)
		->save()
		->describe();
}

test();

?>