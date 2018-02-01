<?php

include 'Models/Player.php';

function test() {
	$data = [
		'id' => 1,
		'first_name' => 'Lebron',
		'last_name' => 'James',
		'team' => 'CLE',
		'height' => 123,
	];

	Player::add_fields('position', 'age');

	// $employee = Player::retrieve('1');
	// foreach ($data as $property => $value) {
	// 	$employee->$property = $value;
	// }
	// $employee->position = 'test 1234';
	// $employee->save();

	$james = Player::search(['last_name' => 'Thomas']);

	var_dump($james);
	// echo "First Name: $james[0]->first_name Town: $james[0]->position";
}
test();

?>