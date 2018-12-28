<?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * How to use:
 * php bot-stats.php $championship
 * Example:
 * php bot-stats.php ligue1
 */
class Stats {
  public function __construct($argv) {
    include 'functions.php';
    $championship = (isset($argv[1])) ? $argv[1] : die('Please choose a championship'."\n");
    $soccer = new Soccer();
    //SQL retrieve all games group by match date
    $past_games = $soccer->get_past_games($championship);
    if (empty($past_games)) { die('Unknown championship'. "\r\n");}
    //prepare and create all link for extract all games 
    $past_games_links = $soccer->create_past_game_url($past_games, $championship);

    if(empty($past_games_links)){ die('Cannot get previous games'. "\r\n"); }
    $pages = $soccer->curl_links($past_games_links);

    if(empty($pages)){ die('Cannot get html of each links'. "\r\n"); }
    $stats = $soccer->scrapping_stats($pages);
    
    if(empty($stats)){ die('Problem during the sccraping process'. "\r\n"); }
    return $soccer->save_stats($stats, $championship);
  }

  public function connect_mysql() {
    $config = new Config();
    $default = $config->default;
    $mysqli = new mysqli($default['host'], $default['login'], $default['password'], $default['database']);
    if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error."\r\n");
    } 
    return $mysqli;
  }
}
$argv = (!empty($_POST)) ? $_POST : $argv;
new Stats($argv);
?>