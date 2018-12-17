 <?php
/**
 * @author Samy Younsi <samyyounsi@hotmail.fr>
 * How to use:
 * php bot-odds.php $championship_name
 * Example:
 * php bot-odds.php league1
 */
class Odds {
    /**
     * Valid UEFA championship
     *
     * @var array
     * @access protected
     */
    protected $uefa = array(
        'ligue1' => 'http://www.cotes.fr/football/France-Ligue-1-ed3', 
        'ligue2' => 'http://www.cotes.fr/football/France-Ligue-2-ed9', 
        'premierleague' => 'http://www.cotes.fr/football/Angleterre-Premier-League-ed2', 
        'bundesliga' => 'http://www.cotes.fr/football/Allemagne-Bundesliga-ed4', 
        'laliga' => 'http://www.cotes.fr/football/Espagne-LaLiga-ed6', 
        'primeiraliga' => 'http://www.cotes.fr/football/Portugal-Liga-NOS-ed15', 
        'seriea' => 'http://www.cotes.fr/football/Italie-Serie-A-ed5'
    );
    
    public function __construct($argv) {
        $championship = (isset($argv[1])) ? $argv[1] : null;
        $mode = (isset($argv[2])) ? $argv[2] : null;
        $link = $this->get_championship_link($championship);
        if (empty($link)) {
            die('Unknown championship'. "\r\n");
        }
        
        $html = $this->get_html_page($link);
        if (!$html) {
            die(date("Y-m-d H:i:s") . ' - unavailable page' . "\r\n");
        }
        
        $games = $this->get_odds_values($html);
        if (empty($games)) {
            die('Problem encountered during extraction' . "\r\n");
        }
        return $this->save($games,$championship, $mode);
    }
    
    public function get_championship_link($championship) {
        foreach ($this->uefa as $key => $link) {
            if ($key == $championship) {
                return $link;
            }
        }
    }
    
    public function get_html_page($link) {
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
    
    public function get_odds_values($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath     = new DOMXPath($dom);
        //we target the entire game table
        $tableRows = $xpath->query("//table[@class='bettable']");
        
        foreach ($tableRows as $row) {
            //we count the number of td tags associated to the class "maincol" that correspond to the number of games  
            $tabGames       = $xpath->query("//td[@class='maincol ']", $row);
            $count_tabGames = $tabGames->length;
            
            //number of odds per maincol block (which corresponds to 1 game)
            $nb_oddsPerMatch = array();
            foreach ($tabGames as $tabGame) {
                array_push($nb_oddsPerMatch, $tabGame->getAttribute('rowspan') - 1);
            }
            
            //game dates
            $gameDay = array();
            foreach ($xpath->query("//td[@class='maincol ']/h2[@class='matchname']/following-sibling::text()[normalize-space()][1]") as $node) {
                $getDateLetter = str_replace('Dimanc:e', 'Dimanche', str_replace('h', ':', str_replace('à', '', trim($node->nodeValue))));
                date_default_timezone_set("UTC");
                setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                $fmt      = new IntlDateFormatter("fr-FR", IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Etc/UTC', IntlDateFormatter::GREGORIAN, 'EEEE dd MMMM y hh:mm');
                //strtotime
                $unixtime = $fmt->parse($getDateLetter);
                $datetime = date("Y-m-d H:i:s", $unixtime);
                array_push($gameDay, $datetime);
            }
            //end date trix
            
            //games loop
            $teamA       = array();
            $teamB       = array();
            $all_games   = $xpath->query("//a[@class='otn']", $row);
            $count_games = $all_games->length;
            for ($i = 0; $i < $count_games; $i++) {
                if ($i % 2 == 1) {
                    array_push($teamB, strtolower($xpath->query("//a[@class='otn']", $row)->item($i)->textContent));
                }
                if ($i % 2 == 0) {
                    array_push($teamA, strtolower($xpath->query("//a[@class='otn']", $row)->item($i)->textContent));
                }
            }
            //we get the url of the picture to obtain the odds name
            $all_UrlImgName = array();
            $imgs           = $xpath->query("//td[@width='125']/img[@border='0']", $row);
            foreach ($imgs as $img) {
                array_push($all_UrlImgName, $img->getAttribute('src'));
            }
            //we explod the urls for get the odds name
            $delete_extention = str_replace('.gif', '', $all_UrlImgName);
            $odds_name        = str_replace('images/logop-', '', $delete_extention);
            $all_odds        = $xpath->query("*//td[@class='bet highlight'] | *//td[@class='bet ']", $row);
            $count_odds      = $all_odds->length;
            $all_odds_name   = $xpath->query("//td[@width='125']", $row);
            $count_odds_name = $all_odds_name->length;
            $cotes           = array();
            $odds_teamA      = array();
            $odds_draw       = array();
            $odds_teamB      = array();
            
            for ($c = 0; $c < $count_odds; $c++) {
                array_push($cotes, $xpath->query("//td[@class='bet '] | //td[@class='bet highlight']", $row)->item($c)->textContent);
            }
            //We get all odds from the team 1
            for ($bet = 0; $bet < $count_odds; $bet += 3) {
                array_push($odds_teamA, str_replace(' ', '', $xpath->query("//td[@class='bet '] | //td[@class='bet highlight']", $row)->item($bet)->textContent));
            }
            //We get all odds draw case
            for ($bet = 1; $bet < $count_odds; $bet += 3) {
                array_push($odds_draw, str_replace(' ', '', $xpath->query("//td[@class='bet '] | //td[@class='bet highlight']", $row)->item($bet)->textContent));
            }
            //We get all odds from the team 2
            for ($bet = 2; $bet < $count_odds; $bet += 3) {
                array_push($odds_teamB, str_replace(' ', '', $xpath->query("//td[@class='bet '] | //td[@class='bet highlight']", $row)->item($bet)->textContent));
            } 
        }
        
        //we get all result
        $games = array();
        for ($i = 0; $i < count($teamA); $i++) {
            $result['teamA']    = $teamA[$i];
            $result['teamB']    = $teamB[$i];
            $result['game_day'] = $gameDay[$i];
            $result['nb_odds']  = $nb_oddsPerMatch[$i];
            array_push($games, $result);
        }
        $nb_games = count($games);
        
        $result1   = array();
        $sort_odds = array();
        
        for ($r = 0; $r < count($odds_name); $r++) {
            $result1['odds_name'] = trim($odds_name[$r]);
            $result1['winA']      = trim($odds_teamA[$r]);
            $result1['draw']      = trim($odds_draw[$r]);
            $result1['winB']      = trim($odds_teamB[$r]);
            
            array_push($sort_odds, $result1);
        }
        //merge tab of tab games and tab odds
        for ($i = 0; $i < $nb_games; $i++) {
            for ($a = 0; $a < $games[$i]['nb_odds']; $a++) {
                $tri_elem[$i][$a] = array_shift($sort_odds);
                array_push($games[$i], $tri_elem[$i][$a]);
            }
        }
        
        return $games;
    }
    public function save($games, $championship, $mode) {
        include 'functions.php';
        $soccer = new Soccer();
        $mysqli = $soccer->connect_mysql();

        $stmt = $mysqli->stmt_init();
        for ($y = 0; $y < count($games); $y++) {
            for ($z = 0; $z < count($games[$y]) - 4; $z++) {
                $sqlteamA     = $games[$y]['teamA'];
                $sqlteamB     = $games[$y]['teamB'];
                $sqlgame_day  = $games[$y]['game_day'];
                $sqlodds_name = $games[$y][$z]['odds_name'];
                $sqlWinA      = $games[$y][$z]['winA'];
                $sqldraw      = $games[$y][$z]['draw'];
                $sqlWinB      = $games[$y][$z]['winB'];
                $stmt->prepare("INSERT INTO odds_$championship (teamA, teamB, game_day, odds_name, winA, draw, winB, get_stat, created) 
                                VALUES ('$sqlteamA', '$sqlteamB', '$sqlgame_day', '$sqlodds_name', '$sqlWinA', '$sqldraw', '$sqlWinB', 0, now())") or die($mysqli->error."\r\n");
                $stmt->execute();
            }
        }
        
        //If we run the script from the dashboard (index.php)
        if (isset($mode) && $mode === 'manual') {
            $stmt->prepare("UPDATE last_update_$championship SET manual = now() WHERE id = 1;") or die($mysqli->error."\r\n");
            $stmt->execute();
            $response = array(
                'ajax' => 'success',
                'message' => $championship.' odds scraping carried out successfully.'
            );
            echo json_encode($response);
            exit;
        } else {
            $stmt->prepare("UPDATE last_update_$championship SET cron = now() WHERE id = 1;") or die($mysqli->error."\r\n");
            $stmt->execute();
            echo $championship.' odds scraping carried out successfully.'."\r\n";
        }
        $stmt->close();
        $mysqli->close();
    }
}
$argv = (!empty($_POST)) ? $_POST : $argv;
new Odds($_POST);
?> 