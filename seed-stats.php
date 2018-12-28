 <?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * How to use:
 * php seed.php
 */
class Seed_Stats {
    /**
     * SQL TABLE FOR MOST POPULAR UEFA championship
     *
     * @var array
     * @access protected
     */
  protected $tables = array(
        'stats_ligue1' => "CREATE TABLE IF NOT EXISTS stats_ligue1 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_ligue1_teamA_id INT(11) NOT NULL,
                                club_ligue1_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_ligue2' => "CREATE TABLE IF NOT EXISTS stats_ligue2 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_ligue2_teamA_id INT(11) NOT NULL,
                                club_ligue2_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_premierleague' => "CREATE TABLE IF NOT EXISTS stats_premierleague (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_premierleague_teamA_id INT(11) NOT NULL,
                                club_premierleague_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_bundesliga' => "CREATE TABLE IF NOT EXISTS stats_bundesliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_bundesliga_teamA_id INT(11) NOT NULL,
                                club_bundesliga_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_laliga' => "CREATE TABLE IF NOT EXISTS stats_laliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_laliga_teamA_id INT(11) NOT NULL,
                                club_laliga_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_primeiraliga' => "CREATE TABLE IF NOT EXISTS stats_primeiraliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_primeiraliga_teamA_id INT(11) NOT NULL,
                                club_primeiraliga_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'stats_seriea' => "CREATE TABLE IF NOT EXISTS stats_seriea (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                club_seriea_teamA_id INT(11) NOT NULL,
                                club_seriea_teamB_id INT(11) NOT NULL,
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                nb_spectators VARCHAR(50) NOT NULL,
                                referee VARCHAR(50) NOT NULL,
                                score_teamA INT(11) NOT NULL,
                                score_teamB INT(11) NOT NULL,
                                score_half_teamA INT(11) NOT NULL,
                                score_half_teamB INT(11) NOT NULL,
                                scorers_teamA TEXT NOT NULL,
                                scorers_teamB TEXT NOT NULL,
                                cards_teamA TEXT NOT NULL,
                                cards_teamB TEXT NOT NULL,
                                possession_percent_teamA VARCHAR(50) NULL,
                                possession_percent_teamB VARCHAR(50) NULL,
                                passes_nb_teamA VARCHAR(50) NULL,
                                passes_nb_teamB VARCHAR(50) NULL,
                                passes_percent_teamA VARCHAR(50) NULL,
                                passes_percent_teamB VARCHAR(50) NULL,
                                shot_teamA VARCHAR(50) NULL,
                                shot_teamB VARCHAR(50) NULL,
                                shot_framed_teamA VARCHAR(50) NULL,
                                shot_framed_teamB VARCHAR(50) NULL,
                                fault_nb_teamA VARCHAR(50) NULL,
                                fault_nb_teamB VARCHAR(50) NULL,
                                trainer_teamA VARCHAR(50) NULL,
                                trainer_teamB VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_ligue1' => "CREATE TABLE IF NOT EXISTS club_ligue1 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_ligue2' => "CREATE TABLE IF NOT EXISTS club_ligue2 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_premierleague' => "CREATE TABLE IF NOT EXISTS club_premierleague (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_bundesliga' => "CREATE TABLE IF NOT EXISTS club_bundesliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_laliga' => "CREATE TABLE IF NOT EXISTS club_laliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_primeiraliga' => "CREATE TABLE IF NOT EXISTS club_primeiraliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'club_seriea' => "CREATE TABLE IF NOT EXISTS club_seriea (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(50) NOT NULL,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_ligue1' => "CREATE TABLE IF NOT EXISTS players_ligue1 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_ligue1_id VARCHAR(50) NOT NULL,
                                stats_ligue1_id VARCHAR(50) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_ligue2' => "CREATE TABLE IF NOT EXISTS players_ligue2 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_ligue2_id INT(11) NOT NULL,
                                stats_ligue2_id VARCHAR(50) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_premierleague' => "CREATE TABLE IF NOT EXISTS players_premierleague (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_premierleague_id INT(11) NOT NULL,
                                stats_premierleague_id VARCHAR(50) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_bundesliga' => "CREATE TABLE IF NOT EXISTS players_bundesliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_bundesliga_id INT(11) NOT NULL,
                                stats_bundesliga_id INT(11) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_laliga' => "CREATE TABLE IF NOT EXISTS players_laliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_laliga_id INT(11) NOT NULL,
                                stats_laliga_id INT(11) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_primeiraliga' => "CREATE TABLE IF NOT EXISTS players_primeiraliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_primeiraliga_id INT(11) NOT NULL,
                                stats_primeiraliga_id INT(11) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'players_seriea' => "CREATE TABLE IF NOT EXISTS players_seriea (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                club_seriea_id INT(11) NOT NULL,
                                stats_seriea_id INT(11) NOT NULL,
                                club_name VARCHAR(50) NOT NULL,
                                name VARCHAR(50) NOT NULL,
                                nationality VARCHAR(50) NULL,
                                age VARCHAR(50) NULL,
                                height VARCHAR(50) NULL,
                                weight VARCHAR(50) NULL,
                                date_game DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin"

  );

  public function __construct() {
    include 'config.php';
    $config = new Config();
    $default = $config->default;
    $mysqli = $this->connect_mysql($default);
    if (empty($mysqli)) { die('Problem for create database');}
    $DB = $this->create_database($default, $mysqli);
    if ($DB !== true) { die('Problem for create database');}   
    return $this->create_tables($default);
  }

  public function connect_mysql($default = array()) {
    $mysqli = new mysqli($default['host'], $default['login'], $default['password']);
    if ($mysqli->connect_error) {
      die('Connection failed: ' . $mysqli->connect_error."\r\n");
    } 
    return $mysqli;
  }

  public function create_database($default = array(), $mysqli) {
    $sql = "CREATE DATABASE IF NOT EXISTS ". $default['database'];
    if (!$mysqli->query($sql) === TRUE) {
      die('Error creating database: ' . $mysqli->error."\r\n");
    }
    $mysqli->close();
    return true;
  }

  public function create_tables($default = array()) {
    $mysqli = new mysqli($default['host'], $default['login'], $default['password'], $default['database']);
    $mysqli->set_charset('utf8');
    if (!$mysqli){
      die('ERROR: Could not connect. ' . $mysqli->error."\r\n");
    }
    // Create tables and columns
    foreach ($this->tables as $key => $table) {
      $query = $mysqli->query($table);
      if(!$query){
        die('Table '.$key.': Creation failed ('.$mysqli->error.')'."\r\n");
      }else{
        echo 'Table '.$key.': Creation done'."\r\n";
      }
    }
    echo 'All tables are created! Enjoy scraping :)'."\r\n";
    $mysqli->close();
  }
}
new Seed_Stats();
?>