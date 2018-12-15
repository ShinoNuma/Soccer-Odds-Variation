<?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * Contain all functions for interact with the database
 */
class Soccer {

  public function __construct() {
    include 'config.php';
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

  public function base_url() {
     $config = new Config();
     return $config->base_url;
  }

  public function get_last_auto_extraction_ligue1(){
    $mysqli = $this->connect_mysql();
    if (!$mysqli_result = mysqli_query($mysqli, "SELECT cron FROM last_update_ligue1 WHERE id = 1")){
      printf("Error: %s\n", $mysqli->error);
      }
    $lastUpdateCron = mysqli_fetch_row($mysqli_result);
    $mysqli->close();
    return $lastUpdateCron;   
  }
}
?>