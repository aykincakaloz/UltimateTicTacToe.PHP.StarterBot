<?php
namespace AIGames\PHPBot;
// __main__ for some reason

//@todo Use autoloader
require_once('AIGames/PHPBot/Game.php');
require_once('AIGames/PHPBot/Map.php');
require_once('AIGames/PHPBot/AI.php');
require_once('AIGames/PHPBot/Move.php');

$game = new Game();
$game->run();
