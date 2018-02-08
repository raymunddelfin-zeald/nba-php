<?php

/**
 * Team
 */
class Team extends Model {

	protected static $tableId = 'TeamId';
	protected static $table = 'team';
	protected static $properties = ['TeamId', 'TeamName'];


	public function describe() {
		echo "Team name: " . $this->TeamName . "\n";
	}
}