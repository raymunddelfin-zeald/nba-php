<?php

/**
 * Player
 */
class Player extends Model {

	protected static $tableId = 'PlayerId';
	protected static $table = 'player';
	protected static $properties = ['PlayerId', 'PlayerName'];

	public function describe() {
		echo "Player name: " . $this->PlayerName . "\n";
	}
}