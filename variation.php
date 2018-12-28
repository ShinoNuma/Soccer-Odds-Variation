<?php 
   include 'functions.php';
   $soccer = new Soccer();
   $base_url = $soccer->base_url();
   if(!empty($_GET['championship']) && !empty($_GET['teamA']) && !empty($_GET['teamB']) && !empty($_GET['game_day'])):
      $odds_by_games = $soccer->get_odds_by_game($_GET);
   endif;?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Shino Corp'">
      <title>Soccer Bot Crwaler</title>
      <!-- Bootstrap Core CSS -->
      <link href="<?= $base_url;?>css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?= $base_url;?>css/simple-sidebar.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div id="wrapper">
         <!-- Sidebar -->
         <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
               <li class="sidebar-brand">
                  <a href="#">
                  Soccer Bot Crwaler
                  </a>
               </li>
               <li>
                  <a href="<?= $base_url;?>">Dashboard</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=ligue1">Ligue1</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=premierleague">Premier League</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=bundesliga">Bundesliga</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=laliga">Laliga</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=seriea">Serie A</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=primeiraliga">Primeira Liga</a>
               </li>
               <li>
                  <a href="<?= $base_url;?>league.php?id=ligue2">Ligue2</a>
               </li>
            </ul>
         </div>
         <!-- /#sidebar-wrapper -->
         <!-- Page Content -->
         <div id="page-content-wrapper">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg-12">
                     <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Menu</a>
                  </div>
               </div>
            </div>
            <?php if(!empty($odds_by_games)): ?>
            <?php foreach ($odds_by_games as $key => $odds_by_game):?>
            <div class="container">
               <canvas id="canvas-<?= $key;?>" width="1416" height="708" class="chartjs-render-monitor"></canvas>
            </div>
            <?php endforeach; endif;?>
         </div>
      </div>
      <!-- jQuery -->
      <script src="<?= $base_url;?>js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="<?= $base_url;?>js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
      <?php if(!empty($odds_by_games)): ?>
      <?php foreach ($odds_by_games as $odds_name => $odds_by_game):?>
      <script>
         var config_<?= $odds_name;?> = {
            type: 'line',
            data: {
               labels: [<?php foreach ($odds_by_game as $key => $odds):?><?php end($odds_by_game); if ($key === key($odds_by_game)):?>'<?= $odds["created"]; ?>'<?php else: ?><?= "'".$odds["created"]."',"; ?><?php endif; endforeach;?>],
               datasets: [
         
               {
                  label: '<?= $odds["teamA"]; ?> Host',
                  backgroundColor: 'red',
                  borderColor: 'red',
                  data: [<?php foreach ($odds_by_game as $key => $odds):?><?php end($odds_by_game); if ($key === key($odds_by_game)):?>'<?= $odds["winA"]; ?>'<?php else: ?><?= "'".$odds["winA"]."',"; ?><?php endif; endforeach;?>],
                  fill: false,
               }, 
         
               {
                  label: '<?= $odds["teamB"]; ?>',
                  backgroundColor: 'blue',
                  borderColor: 'blue',
                  data: [<?php foreach ($odds_by_game as $key => $odds):?><?php end($odds_by_game); if ($key === key($odds_by_game)):?>'<?= $odds["winB"]; ?>'<?php else: ?><?= "'".$odds["winB"]."',"; ?><?php endif; endforeach;?>],
                  fill: false,
               }, 
               {
                  label: 'Draw',
                  backgroundColor: 'green',
                  borderColor: 'green',
                  data: [<?php foreach ($odds_by_game as $key => $odds):?><?php end($odds_by_game); if ($key === key($odds_by_game)):?>'<?= $odds["draw"]; ?>'<?php else: ?><?= "'".$odds["draw"]."',"; ?><?php endif; endforeach;?>],
                  fill: false,
               },
               ]
            },
            options: {
               responsive: true,
               title: {
                  display: true,
                  text: '<?= $odds_name?>'
               },
               scales: {
                  yAxes: [{
                     ticks: {
                        // the data minimum used for determining the ticks is Math.min(dataMin, suggestedMin)
                        suggestedMin: 1,
                        // the data maximum used for determining the ticks is Math.max(dataMax, suggestedMax)
                        suggestedMax: 20
                     }
                  }]
               }
            }
         };
         var ctx_<?= $odds_name;?> = document.getElementById(`canvas-<?= $odds_name;?>`).getContext('2d');
         window.myLine = new Chart(ctx_<?= $odds_name;?>, config_<?= $odds_name;?>);
      </script>
      <?php endforeach; endif;?>
   </body>
</html>