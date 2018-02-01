<?php

include 'Model.php';

/**
 * Player
 */
class Player extends Model {

	protected static $table = 'player';
	protected static $properties = ['id', 'first_name', 'last_name'];
}