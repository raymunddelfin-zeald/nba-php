<?php

include 'include/utils.php';
include 'Models/Model.php';

include 'Models/Player.php';
include 'Models/Team.php';
include 'Models/Game.php';
include 'Models/Action.php';

function test() {

	$player = Player::search(['PlayerName' => 'Nicolas Batum']);
	var_dump($player);

	$team = Team::search(2);
	// echo "<pre>";
	// var_dump($team);
	// echo "<pre>";

	$updateTeam = new Team($team[0]);
	$updateTeam->TeamName = 'new team';
	$updateTeam->save();
	echo "<pre>";
	var_dump($updateTeam);
	echo "</pre>";

	$newTeam = new Team([
		'TeamName' => 'new team - generated',
	]);

	$newTeam->save();
	echo "<pre>";
	var_dump($newTeam);
	echo "</pre>";
}

test();

?>