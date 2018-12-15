 <?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * How to use:
 * php seed.php
 */
class Seed {
    /**
     * SQL TABLE FOR MOST POPULAR UEFA championship
     *
     * @var array
     * @access protected
     */
  protected $tables = array(
        'odds_ligue1' => "CREATE TABLE IF NOT EXISTS odds_ligue1 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_ligue2' => "CREATE TABLE IF NOT EXISTS odds_ligue2 (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_premierleague' => "CREATE TABLE IF NOT EXISTS odds_premierleague (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_bundesliga' => "CREATE TABLE IF NOT EXISTS odds_bundesliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_laliga' => "CREATE TABLE IF NOT EXISTS odds_laliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_primeiraliga' => "CREATE TABLE IF NOT EXISTS odds_primeiraliga (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'odds_seriea' => "CREATE TABLE IF NOT EXISTS odds_seriea (
                                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                                teamA VARCHAR(50) NOT NULL,
                                teamB VARCHAR(50) NOT NULL,
                                odds_name VARCHAR(50) NOT NULL,
                                winA NUMERIC(11) NOT NULL,
                                draw NUMERIC(11) NOT NULL,
                                winB NUMERIC(11) NOT NULL,
                                get_stat TINYINT(1) NOT NULL,
                                game_day DATETIME,
                                created DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_ligue1' => "CREATE TABLE IF NOT EXISTS last_update_ligue1 (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_ligue2' => "CREATE TABLE IF NOT EXISTS last_update_ligue2 (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_premierleague' => "CREATE TABLE IF NOT EXISTS last_update_premierleague (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_bundesliga' => "CREATE TABLE IF NOT EXISTS last_update_bundesliga (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_laliga' => "CREATE TABLE IF NOT EXISTS last_update_laliga (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_primeiraliga' => "CREATE TABLE IF NOT EXISTS last_update_primeiraliga (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
                              ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
        'last_update_seriea' => "CREATE TABLE IF NOT EXISTS last_update_seriea (
                                id INT(11), 
                                manual DATETIME,
                                cron DATETIME
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
      die("Connection failed: " . $mysqli->connect_error."\r\n");
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
new Seed();
?>