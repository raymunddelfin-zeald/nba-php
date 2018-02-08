<?php

/**
 * Action
 */
class Action extends Model {

	protected static $table = 'action';
	protected static $properties = ['GameId', 'TeamId', 'PlayerId', 'Minutes', 'FieldGoalsMade', 'FieldGoalAttempts', '3PointsMade', '3PointAttempts', 'FreeThrowsMade', 'FreeThrowAttempts', 'PlusMinus', 'OffensiveRebounds', 'DefensiveRebounds', 'TotalRebounds', 'Assists', 'PersonalFouls', 'Steals', 'Turnovers', 'BlockedShots', 'BlocksAgainst', 'Points', 'Starter'];
}
