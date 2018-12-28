<?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * Contain all functions for interact with the database
 */
class Soccer {

  public $teamNames = array(
        'ligue1' => array(
                'paris sg' => 'paris',
                'saint-etienne' => 'etienne'      
        )
  );
  
  protected $base_url_stat = 'http://www.maxifoot.fr/match/'; 

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

  public function get_past_games($championship){
    $mysqli = $this->connect_mysql();
    //basicly an sql query for get all past game where the statistics are still not extratcted
    if (!$mysqli_result = mysqli_query($mysqli, "SELECT * FROM odds_{$championship} WHERE game_day <= NOW() AND get_stat = 0 GROUP BY teamA, teamB, game_day")){
      printf("Error: %s\n", $mysqli->error);
    }
    
    $past_games = array();
    while ($row = $mysqli_result->fetch_array(MYSQLI_ASSOC)) {
        array_push($past_games, $row); 
    }
    $mysqli->close();
    return $past_games;   
  }

  public function get_all_games($championship){
    $mysqli = $this->connect_mysql();
    //basicly an sql query for get all past game where the statistics are still not extratcted
    if (!$mysqli_result = mysqli_query($mysqli, "SELECT * FROM odds_{$championship} GROUP BY teamA, teamB ORDER BY game_day DESC")){
      printf("Error: %s\n", $mysqli->error);
    }
    
    $past_games = array();
    while ($row = $mysqli_result->fetch_array(MYSQLI_ASSOC)) {
        array_push($past_games, $row); 
    }
    $mysqli->close();
    return $past_games;   
  }

  public function get_games_score($championship, $teamA, $teamB, $date_game){
    $mysqli = $this->connect_mysql();
    //$teamA  = $this->get_correct_team_name($teamA, $championship);
    //$teamB  = $this->get_correct_team_name($teamB, $championship);
    if (!$mysqli_result = mysqli_query($mysqli, "SELECT score_teamA, score_teamB FROM stats_{$championship} WHERE teamA LIKE '{$teamA}' AND teamB LIKE '{$teamB}' AND date_game = '{$date_game}' GROUP BY id")){
      printf("Error: %s\n", $mysqli->error);
    }
    // var_dump("SELECT score_teamA, score_teamB FROM stats_{$championship} WHERE teamA = '{$teamA}' AND teamB = '{$teamB}' AND date_game = '{$date_game}'");
    // die;
    var_dump($mysqli_result->fetch_array(MYSQLI_ASSOC));
    $game_score = array();
    while ($row = $mysqli_result->fetch_array(MYSQLI_ASSOC)) {
        //var_dump($row); die;
        array_push($game_score, $row); 
    }
    $mysqli->close();
    return $game_score;
  }

  public function get_odds_by_game($game_data){
    $mysqli = $this->connect_mysql();
    $championship = $game_data['championship'];
    $teamA = urldecode($game_data['teamA']);
    $teamB = urldecode($game_data['teamB']);
    $game_day = urldecode($game_data['game_day']);
    //basicly an sql query for get all past game where the statistics are still not extratcted
    if (!$odds_names_row = mysqli_query($mysqli, "SELECT odds_name FROM odds_{$championship} WHERE teamA LIKE '{$teamA}' AND teamB LIKE '{$teamB}' AND game_day = '{$game_day}' GROUP BY odds_name")){
      printf("Error: %s\n", $mysqli->error);

    }

    $odds_names = array();
     while ($odds_name_row = $odds_names_row->fetch_array(MYSQLI_NUM)) {
      array_push($odds_names, $odds_name_row[0]);
    }

    if (!empty($odds_names)) {
      foreach ($odds_names as $key => $odds_name) {
        $variations[$odds_name] = array();
        if (!$results = mysqli_query($mysqli, "SELECT * FROM odds_{$championship} WHERE teamA LIKE '{$teamA}' AND teamB LIKE '{$teamB}' AND game_day = '{$game_day}' AND odds_name = '{$odds_name}' ORDER BY created ASC")){
          printf("Error: %s\n", $mysqli->error);
        }
        while ($result = $results->fetch_array(MYSQLI_ASSOC)) {
          array_push($variations[$odds_name], $result); 
        }
      }
    }
    return $variations;
  }

  public function create_past_game_url($past_games, $championship){
    $links = array();
    foreach ($past_games as $key => $past_game) {
      $unix_game_day = date('Ymd',  strtotime($past_game['game_day']));
      $past_game['teamA'] = $this->get_correct_team_name($past_game['teamA'], $championship);
      $past_game['teamB'] = $this->get_correct_team_name($past_game['teamB'], $championship);
      $link = $this->base_url_stat.$past_game['teamA'].'-'.$past_game['teamB'].'-'.$unix_game_day.'.htm';
      array_push($links, $link);  
    }
    return $links; 
  }

  public function get_correct_team_name($team, $championship){
    if(isset($this->teamNames[$championship][$team])){
      return $this->teamNames[$championship][$team];
    }else{
      return $team;
    }
  }

  public function curl_links($links){
    $pages = array();
    foreach ($links as $link) {
      array_push($pages, $this->get_html_page($link));
      sleep(7);
    }
    return array_filter($pages);;
  }

  public function get_html_page($link){
    //echo 'try link: ' .$link. "\n";
    $curl = curl_init($link);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
    $html = curl_exec($curl);
    curl_close($curl);

    if ($html) {
      return $this->check_valid_page($html, $link);
    }
  }

  //function for check if the page requested does not exist 
  public function check_valid_page($html, $link) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $tableRows = $xpath->query("//div[@id='main']");
    foreach ($tableRows as $row) {
      $xpath_response = (isset($xpath->query("//font[@face='Verdana']", $row)->item(0)->textContent)) ? trim($xpath->query("//font[@face='Verdana']", $row)->item(0)->textContent) : null;
    }
    //The page you requested does not exist
    $undefined_msg = "La page que vous avez demandé n'existe pas";
    $page = array();
    if(substr($xpath_response, 0, 43) == $undefined_msg){
      $date_game = preg_replace('/\D/', '', $link);
      if (substr($date_game, -2) <= 30) {
        $new_link = str_replace($date_game,$date_game+1,$link);
        return $this->get_html_page($new_link);
      }else{
        return null;
      }  
    }else{
      echo 'Data in the page '.$link. ' will be extract'."\r\n";
      $page['link'] = $link;
      $page['html'] = $html;
      return $page;
    }
  }

  public function scrapping_stats($pages) {
    $data = array();
    foreach ($pages as $key => $page) {
      $data[$key] = $this->extract_data($page);
    }
    return $data;
  }

  public function extract_data($page){
    $dom = new DOMDocument();
    @$dom->loadHTML($page['html']);
    $xpath = new DOMXPath($dom);
    $teamName = str_replace('.htm', '', str_replace($this->base_url_stat, '', $page['link']));
    $teamName = explode('-', $teamName);
    $nameTeamA = $teamName[0];
    $nameTeamB = $teamName[1];
    $date_game = date('Y-m-d', strtotime($teamName[2]));
    //IMPORTANT VARIABLE
    //on cible l'ensemble du tableau des resultats matchs
    $tableRows = $xpath->query("//div[@id='fichemat']");
    $game = array();
    foreach ($tableRows as $row) {
      //Query GET ADDTIONAL INFORMATIONS
      $AD = $xpath->query("//div[@class='rdcc']", $row)->item(0)->textContent;
      //ADDTIONAL INFORMATIONS data
      $AD = $xpath->query("//div[@class='rdcc']", $row)->item(0)->textContent;
      if(!empty($AD)){
        $AD = explode('|', trim($AD));  
          //Get nb Spectateurs : 47287
        if(!empty($AD[1])){ 
            $nb_spectators = str_replace(' Spectateurs :', '', $AD[1]);
            $nb_spectators = htmlentities($nb_spectators, null, 'utf-8');
            $nb_spectators = trim(str_replace("&nbsp;", "", $nb_spectators));
        }
        //Get referee : M. Lesage
        if(!empty($AD[2])){
          $referee = str_replace(' Arbitre : ', '', $AD[2]);
          $referee = htmlentities($referee, null, 'utf-8');
          $referee = trim(str_replace("&nbsp;", "", $referee));
        }
      }
      //Query GET SCORE 1-0
      $score = $xpath->query("//table[@class='equi']", $row)->item(0)->textContent;
      if(!empty($score)){
        $score = preg_replace('`[^0-9]`', '', $score);
        $score_teamA = substr($score, 0, 1);
        $score_teamB = substr($score, -1);
      }

      //Query GET SCORE half-time 1-0
      $score_half = $xpath->query("//table[@class='equi']/following-sibling::*[2]", $row)->item(0)->textContent;
      if(!empty($score_half)){
        $score_half = preg_replace('`[^0-9]`', '', $score_half);
        $score_half_teamA = substr($score, 0, 1);
        $score_half_teamB = substr($score, -1);
      }
      
      //Query Get scorers teamA (host)
      $scorersTeamA = $xpath->query("//div[@class='top'][1]/table/tbody/tr/td[@class='d1']", $row)->item(0)->textContent;
      if(!empty($scorersTeamA)){
        $scorersTeamA = htmlentities($scorersTeamA, null, 'utf-8');
        $scorersTeamA = trim(str_replace("&nbsp;", "", $scorersTeamA));
        $scorersTeamA = array_filter(array_map('trim', explode('e)',str_replace(" (", "", $scorersTeamA))));
        $scorersTeamA_array = array();
        for ($i=0; $i < count($scorersTeamA); $i++) { 
          array_push($scorersTeamA_array, array_filter(array_map('trim',preg_split('/(?<=\D)(?=\d)|\d+\K/', htmlspecialchars($scorersTeamA[$i], ENT_QUOTES)))));
        }
        $scorersTeamA_array = json_encode($scorersTeamA_array);
      }

      //Query Get scorers team B
      $scorersTeamB = $xpath->query("//div[@class='top'][1]/table/tbody/tr/td[@class='g1']", $row)->item(0)->textContent;
      if(!empty($scorersTeamB)){
        $scorersTeamB = htmlentities($scorersTeamB, null, 'utf-8');
        $scorersTeamB = trim(str_replace("&nbsp;", "", $scorersTeamB));
        $scorersTeamB = array_filter(array_map('trim', explode('e)',str_replace(" (", "", $scorersTeamB))));
        $scorersTeamB_array = array();
        for ($i=0; $i < count($scorersTeamB) ; $i++) { 
          array_push($scorersTeamB_array, array_filter(array_map('trim',preg_split('/(?<=\D)(?=\d)|\d+\K/', htmlspecialchars($scorersTeamB[$i], ENT_QUOTES)))));
        }
        //["player name", "goal time", "pen"]
        $scorersTeamB_array = json_encode($scorersTeamB_array);
      }
      /////GET CARD TEAM A /////
      //Query Get yellow card and red card  team A 
      //[0]=> array(3) { [0]=> string(10) "Dani Alves" [1]=> string(2) "24" [2]=> string(6) "yellow" }
      $cards_teamA = $xpath->query("//div[@class='top'][2]/table/tbody/tr/td[@class='d1']", $row)->item(0)->textContent;
      if(!empty($cards_teamA)){
        $cards_teamA = htmlentities($cards_teamA, null, 'utf-8');
        $cards_teamA = trim(str_replace("&nbsp;", "", $cards_teamA));
        $cards_teamA = array_filter(array_map('trim', explode('e)',str_replace(" (", "", $cards_teamA))));
        $cards_teamA_array = array();
        for ($i=0; $i < count($cards_teamA) ; $i++) { 
          array_push($cards_teamA_array, array_filter(array_map('trim',preg_split('/(?<=\D)(?=\d)|\d+\K/', htmlspecialchars($cards_teamA[$i], ENT_QUOTES)))));
        }
        //Query geet color card
        $cards_color_teamA = $xpath->query("//div[@class='top'][2]/table/tbody/tr/td[@class='d1']//img/@src", $row);
          //$equipeA_avertissements_count = $cards_color_teamA['lenght'];
          if($cards_color_teamA != NULL){
            $cards_color_teamA_array = array();
            foreach ($cards_color_teamA as $card_TeamA) {
              $color = str_replace('.gif', '', str_replace('http://www.maxifoot.fr/0_images/cart', '', $card_TeamA->textContent));
              if($color == 'rou'){
                array_push($cards_color_teamA_array, 'red');
              }elseif ($color == 'jau') {
                array_push($cards_color_teamA_array, 'yellow');
              }else{
                array_push($cards_color_teamA_array, NULL);
              }
            }
          }
          for ($a=0; $a < count($cards_teamA_array); $a++) { 
            if (!empty($cards_teamA_array[$a])) {
              array_push($cards_teamA_array[$a], $cards_color_teamA_array[$a]);
            }
          }
          $cards_teamA_array = json_encode($cards_teamA_array);
       }
       /////END GET CARD TEAM A /////
       ////GET CARD TEAM B /////
      $cards_teamB = $xpath->query("//div[@class='top'][2]/table/tbody/tr/td[@class='g1']", $row)->item(0)->textContent;
      if(!empty($cards_teamB)){
        $cards_teamB = htmlentities($cards_teamB, null, 'utf-8');
        $cards_teamB = trim(str_replace("&nbsp;", "", $cards_teamB));
        $cards_teamB = array_filter(array_map('trim', explode('e)',str_replace(" (", "", $cards_teamB))));
        $cards_teamB_array = array();
        for ($i=0; $i < count($cards_teamB); $i++) { 
          array_push($cards_teamB_array, array_filter(array_map('trim',preg_split('/(?<=\D)(?=\d)|\d+\K/', htmlspecialchars($cards_teamB[$i], ENT_QUOTES)))));
        }

        //Query geet color card
        $cards_color_teamB = $xpath->query("//div[@class='top'][2]/table/tbody/tr/td[@class='d1']//img/@src", $row);
          //$equipeB_avertissements_count = $cards_color_teamB['lenght'];
          if($cards_color_teamB != NULL){
            $cards_color_teamB_array = array();
            foreach ($cards_color_teamB as $card_TeamB) {
              $color = str_replace('.gif', '', str_replace('http://www.maxifoot.fr/0_images/cart', '', $card_TeamB->textContent));
              if($color == 'rou'){
                array_push($cards_color_teamB_array, 'red');
              }elseif ($color == 'jau') {
                array_push($cards_color_teamB_array, 'yellow');
              }else{
                array_push($cards_color_teamB_array, NULL);
              }
            }
          }

          for ($a=0; $a < count($cards_teamB_array); $a++) { 
            if (!empty($cards_color_teamB_array[$a])) {
              array_push($cards_teamB_array[$a], $cards_color_teamB_array[$a]);
            }
          }
          $cards_teamB_array = json_encode($cards_teamB_array);
       }
       //END GET CARD TEAM B ///
        //match statistics 
        $block_title = $xpath->query("//div[@class='top'][3]/h4", $row)->item(0)->textContent;
        if($block_title == 'STATS DU MATCH'){
          $nb_block = 3;
          //possession
          $possession_teamA = str_replace(' %', '%', $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[2]/td/div[@class='d2']", $row)->item(0)->textContent);
          $possession_teamB = str_replace(' %', '%', $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[2]/td/div[@class='d3']", $row)->item(0)->textContent);
          // number of passes 
          $passes_teamA = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[3]/td/div[@class='d2']", $row)->item(0)->textContent;
          $passes_teamA = explode(' (', $passes_teamA);
          
          $passes_teamA['nb'] = $passes_teamA[0];
          $passes_teamA['percent'] = str_replace(' %)', '%', $passes_teamA[1]); 

          $passes_teamB = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[3]/td/div[@class='d3']", $row)->item(0)->textContent;
          $passes_teamB = explode(' (', $passes_teamB);
          
          $passes_teamB['nb'] = $passes_teamB[0];
          $passes_teamB['percent'] = str_replace(' %)', '%', $passes_teamB[1]);

          //goal shot
          $shot_teamA = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[4]/td/div[@class='d2']", $row)->item(0)->textContent;
          $shot_teamA = explode(' (', $shot_teamA);
          
          $shot_teamA['total'] = $shot_teamA[0];
          //tire cadrer
          $shot_teamA['framed'] = str_replace(')', '', $shot_teamA[1]);

          $shot_teamB = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[4]/td/div[@class='d3']", $row)->item(0)->textContent;
          $shot_teamB = explode(' (', $shot_teamB);
          
          $shot_teamB['total'] = $shot_teamB[0];
          $shot_teamB['framed'] = str_replace(')', '', $shot_teamB[1]);

          //fault
          $fault_teamA = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[5]/td/div[@class='d2']", $row)->item(0)->textContent;
          $fault_teamB = $xpath->query("//div[@class='top'][3]/center/table/tbody/tr[5]/td/div[@class='d3']", $row)->item(0)->textContent;
         }else{
          $possession_teamA = null;
          $possession_teamB = null;
          $passes_teamA = null;
          $passes_teamB = null;
          $passes_teamA['nb'] = null;
          $passes_teamA['percent'] = null;
          $passes_teamB['nb'] = null;
          $passes_teamB['percent'] = null;
          $shot_teamA['total'] = null;
          $shot_teamA['framed'] = null;
          $shot_teamB['total'] = null;
          $shot_teamB['framed'] = null;
          $fault_teamA = null;
          $fault_teamB = null;
          $nb_block = 2;
         }
    }

    //teamA compostions
    $compostions_teamA = $xpath->query("//div[@class='top'][$nb_block+1]/table/tbody/tr/td[@class='d1']/table/*", $row);
    $teamA = array();
    foreach ($compostions_teamA as $key => $player) {
      $player_infos = explode(',',trim($xpath->query("//div[@class='top'][$nb_block+1]/table/tbody/tr/td[@class='d1']/table//img/@title")->item(0)->textContent));
      $player->textContent = htmlentities($player->textContent, null, 'utf-8');
      $player->textContent =  trim(str_replace('&nbsp;', '', $player->textContent));
      $teamA[$key]['club_name'] = $nameTeamA; 
      $teamA[$key]['name'] = htmlspecialchars($player->textContent, ENT_QUOTES);
      if(!empty($player_infos[0])){ 
        $teamA[$key]['nationality'] = htmlentities(strtolower($player_infos[0]), null, 'utf-8');
        $teamA[$key]['nationality'] = htmlspecialchars(trim(str_replace('&nbsp;', '', $teamA[$key]['nationality'])), ENT_QUOTES);
      }else{
        $teamA[$key]['nationality'] = null;
      }

      if(!empty($player_infos[1])){ 
        $teamA[$key]['age'] = htmlentities($player_infos[1], null, 'utf-8');
        $teamA[$key]['age'] = trim(str_replace('&nbsp;', '', $teamA[$key]['age']));
      }else{
        $teamA[$key]['age'] = null;
      }
      if(!empty($player_infos[2])){
      //taille
      $teamA[$key]['height'] = htmlentities($player_infos[2], null, 'utf-8');
      $teamA[$key]['height'] = trim(str_replace('&nbsp;', '', $teamA[$key]['height']));
      }else{
        $teamA[$key]['height'] = null;
      }

      if(!empty($player_infos[3])){
        //poids
        $teamA[$key]['weight'] = htmlentities($player_infos[3], null, 'utf-8');
        $teamA[$key]['weight'] = trim(str_replace('&nbsp;', '', $teamA[$key]['weight']));
      }else{
        $teamA[$key]['weight'] = null;
      }

      $teamA[$key]['date_game'] = $date_game;
    }
    //END teamA compostions
    
    //teamB compostions
    $compostions_teamB = $xpath->query("//div[@class='top'][$nb_block+1]/table/tbody/tr/td[@class='g1']/table/*", $row);
    $teamB = array();
    foreach ($compostions_teamB as $key => $player) {
      $player_infos = explode(',',trim($xpath->query("//div[@class='top'][$nb_block+1]/table/tbody/tr/td[@class='g1']/table//img/@title")->item(0)->textContent));
      $player->textContent = htmlentities($player->textContent, null, 'utf-8');
      $player->textContent =  trim(str_replace('&nbsp;', '', $player->textContent));
      $teamB[$key]['club_name'] = $nameTeamB; 

      $teamB[$key]['name'] = htmlspecialchars($player->textContent, ENT_QUOTES); 
      if(!empty($player_infos[0])){
        $teamB[$key]['nationality'] = htmlentities(strtolower($player_infos[0]), null, 'utf-8');
        $teamB[$key]['nationality'] = htmlspecialchars(trim(str_replace('&nbsp;', '', $teamB[$key]['nationality'])), ENT_QUOTES);
      }else{
        $teamB[$key]['nationality'] = null;
      }
      if(!empty($player_infos[1])){
        $teamB[$key]['age'] = htmlentities($player_infos[1], null, 'utf-8');
        $teamB[$key]['age'] = trim(str_replace('&nbsp;', '', $teamB[$key]['age']));
      }else{
        $teamB[$key]['age'] = null;
      }

      if(!empty($player_infos[2])){
        $teamB[$key]['height'] = htmlentities($player_infos[2], null, 'utf-8');
        $teamB[$key]['height'] = trim(str_replace('&nbsp;', '', $teamB[$key]['height']));
      }else{
        $teamB[$key]['height'] = null;
      }

      if(!empty($player_infos[3])){
        $teamB[$key]['weight'] = htmlentities($player_infos[3], null, 'utf-8');
        $teamB[$key]['weight'] = trim(str_replace('&nbsp;', '', $teamB[$key]['weight']));
      }else{
        $teamB[$key]['weight'] = null;
      }
      $teamA[$key]['date_game'] = $date_game;
    }
    //END teamB compostions
    
    //Team trainer
    $trainer_teamA = $xpath->query("//div[@class='top'][$nb_block+2]/table/tbody/tr/td[@class='d1']", $row)->item(0)->textContent;
    $trainer_teamA = htmlentities($trainer_teamA, null, 'utf-8');
    $trainer_teamA = trim(str_replace("&nbsp;", "", $trainer_teamA));
      
    $trainer_teamB = $xpath->query("//div[@class='top'][$nb_block+2]/table/tbody/tr/td[@class='g1']", $row)->item(0)->textContent;
    $trainer_teamB = htmlentities($trainer_teamB, null, 'utf-8');
    $trainer_teamB = trim(str_replace("&nbsp;", "", $trainer_teamB));

    $game['stats'] = array(
      'teamA' => htmlspecialchars($nameTeamA, ENT_QUOTES),
      'teamB' => htmlspecialchars($nameTeamB, ENT_QUOTES),
      'nb_spectators' => $nb_spectators,
      'referee' => htmlspecialchars($referee, ENT_QUOTES),
      'score_teamA' => $score_teamA,
      'score_teamB' => $score_teamB,
      'score_half_teamA' => $score_half_teamA,
      'score_half_teamB' => $score_half_teamB,
      'scorers_teamA' => $scorersTeamA_array, //response In json (maybe create a table ?)
      'scorers_teamB' => $scorersTeamB_array, //response In json (maybe create a table ?)
      'cards_teamA' => $cards_teamA_array, //response In json (maybe create a table ?)
      'cards_teamB' => $cards_teamB_array, //response In json (maybe create a table ?)
      'possession_percent_teamA' => $possession_teamA,
      'possession_percent_teamB' => $possession_teamB,
      'passes_nb_teamA' => $passes_teamA['nb'],
      'passes_nb_teamB' => $passes_teamB['nb'],
      'passes_percent_teamA' => $passes_teamA['percent'],
      'passes_percent_teamB' => $passes_teamB['percent'],
      'shot_teamA' => $shot_teamA['total'],
      'shot_teamB' => $shot_teamB['total'],
      'shot_framed_teamA' => $shot_teamA['framed'],
      'shot_framed_teamB' => $shot_teamB['framed'],
      'fault_nb_teamA' => $fault_teamA,
      'fault_nb_teamB' => $fault_teamB,
      'trainer_teamA' => htmlspecialchars($trainer_teamA, ENT_QUOTES),
      'trainer_teamB' => htmlspecialchars($trainer_teamB, ENT_QUOTES),
      'date_game' => $date_game
    );

    $game['stats']['players_teamA'] = $teamA;
    $game['stats']['players_teamB'] = $teamB;
    return $game; 
  }

  public function get_club_id($mysqli, $club_name, $championship){
    if (!$results = mysqli_query($mysqli, "SELECT * FROM club_{$championship} WHERE name LIKE '{$club_name}'")){
      printf("Error: %s\n", $mysqli->error);
    }
    
    if(mysqli_num_rows($results) === 0){
       $stmt = $mysqli->stmt_init();
      //If club don't exist we create the table
      $stmt->prepare("INSERT INTO club_{$championship} (name, created) VALUES ('{$club_name}', now())") or die($mysqli->error."\r\n");
      $stmt->execute();
      return $stmt->insert_id;
    }else{
      return $results->fetch_array(MYSQLI_ASSOC)['id'];
    }
  }

  public function save_stats($games, $championship) {
    $mysqli = $this->connect_mysql();
    $stmt = $mysqli->stmt_init();
    foreach ($games as $game) {
      //first we create the club
      $club_id_teamA = $this->get_club_id($mysqli, $game['stats']['teamA'], $championship);
      $club_id_teamB = $this->get_club_id($mysqli, $game['stats']['teamB'], $championship);
      //then we insert the stat
      $stmt->prepare("INSERT INTO stats_{$championship} (club_{$championship}_teamA_id, club_{$championship}_teamB_id, teamA, teamB, nb_spectators, referee, score_teamA, score_teamB, score_half_teamA, score_half_teamB, scorers_teamA, scorers_teamB, cards_teamA, cards_teamB, possession_percent_teamA, possession_percent_teamB, passes_nb_teamA, passes_nb_teamB, passes_percent_teamA, passes_percent_teamB, shot_teamA, shot_teamB, shot_framed_teamA, shot_framed_teamB, fault_nb_teamA, fault_nb_teamB, trainer_teamA, trainer_teamB, date_game, created) 
        VALUES ('{$club_id_teamA}', '{$club_id_teamB}','".$game['stats']['teamA']."' , '".$game['stats']['teamB']."', '".$game['stats']['nb_spectators']."', '".$game['stats']['referee']."', '".$game['stats']['score_teamA']."', '".$game['stats']['score_teamB']."', '".$game['stats']['score_half_teamA']."', '".$game['stats']['score_half_teamB']."', '".$game['stats']['scorers_teamA']."', '".$game['stats']['scorers_teamB']."', '".$game['stats']['cards_teamA']."', '".$game['stats']['cards_teamB']."', '".$game['stats']['possession_percent_teamA']."', '".$game['stats']['possession_percent_teamB']."', '".$game['stats']['passes_nb_teamA']."', '".$game['stats']['passes_nb_teamB']."', '".$game['stats']['passes_percent_teamA']."', '".$game['stats']['passes_percent_teamB']."', '".$game['stats']['shot_teamA']."', '".$game['stats']['shot_teamB']."', '".$game['stats']['shot_framed_teamA']."', '".$game['stats']['shot_framed_teamB']."', '".$game['stats']['fault_nb_teamA']."', '".$game['stats']['fault_nb_teamB']."', '".$game['stats']['trainer_teamA']."', '".$game['stats']['trainer_teamB']."', '".$game['stats']['date_game']."', now())") or die($mysqli->error."\r\n");
      $stmt->execute();
      $stats_id = $stmt->insert_id;
      //and for finish we create the players team A
      foreach ($game['stats']['players_teamA'] as $player_teamA) {
        $stmt->prepare("INSERT INTO players_{$championship} (club_{$championship}_id, stats_{$championship}_id, club_name, name, nationality, age, height, weight, date_game, created) 
        VALUES ('{$club_id_teamA}', '{$stats_id}', '".$player_teamA['club_name']."', '".$player_teamA['name']."','".$player_teamA['nationality']."','".$player_teamA['age']."','".$player_teamA['height']."','".$player_teamA['weight']."','".$game['stats']['date_game']."', now())") or die($mysqli->error."\r\n");
          $stmt->execute();
      }
      //and for finish we create the players team B
      foreach ($game['stats']['players_teamB'] as $player_teamB) {
        $stmt->prepare("INSERT INTO players_{$championship} (club_{$championship}_id, stats_{$championship}_id, club_name, name, nationality, age, height, weight, date_game, created) 
        VALUES ('{$club_id_teamB}', '{$stats_id}', '".$player_teamB['club_name']."', '".$player_teamB['name']."','".$player_teamB['nationality']."','".$player_teamB['age']."','".$player_teamB['height']."','".$player_teamB['weight']."','".$game['stats']['date_game']."', now())") or die($mysqli->error."\r\n");
        $stmt->execute();
      }
      echo date("Y-m-d H:i:s") .': '.$game['stats']['teamA'].' (host) VS '. $game['stats']['teamB'] .' stats are succefully sccraped.'."\r\n";
    }
    $this->update_scraped_game($mysqli, $championship);
    echo date("Y-m-d H:i:s") .': scrapping '.$championship.' are succefully completed.'."\r\n";
    $stmt->close();
    $mysqli->close();
  }

  public function update_scraped_game($mysqli, $championship){
   $past_games = $this->get_past_games($championship);
   if(!empty($past_games)){
    foreach ($past_games as $key => $past_game) {
      $teamA = $past_game['teamA'];
      $teamB = $past_game['teamB'];
      $game_day = $past_game['game_day'];
      //updated previous game after we extract last game
      if (!$mysqli_result = mysqli_query($mysqli, "UPDATE odds_{$championship} SET get_stat = 1 WHERE teamA = '{$teamA}' AND teamB = '{$teamB}' AND game_day = '{$game_day}'")){
        printf("Error: %s\n", $mysqli->error);
      }
    }
    return true;
   }
  }
}
?>