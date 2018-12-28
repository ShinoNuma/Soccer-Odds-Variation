<?php 
   include 'functions.php';
   $soccer = new Soccer();
   $base_url = $soccer->base_url();
   if(!empty($_GET['id'])):
      $allGames = $soccer->get_all_games($_GET['id']);
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
            <div class="container">
               <h2>Bordered Table</h2>
               <p>The .table-bordered class adds borders to a table:</p>
               <table class="table table-bordered" id="soccer-games">
                  <thead>
                     <tr>
                        <th>Team A (Host)</th>
                        <th>Score</th>
                        <th>Team B</th>
                        <th>Game Day</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($allGames)): 
                        foreach ($allGames as $key => $game) :
                          var_dump($soccer->get_games_score($_GET['id'],$game['teamA'], $game['teamB'], $game['game_day']));?>
                     <tr>
                        <td><?= $game['teamA'];?></td>
                        <td> - </td>
                        <td><?= $game['teamB'];?></td>
                        <td><?= $game['game_day'];?></td>
                        <td><a href="<?= $base_url.'variation.php?championship='.$_GET['id'].'&teamA='.urlencode($game['teamA']).'&teamB='.urlencode($game['teamB']).'&game_day='.urlencode($game['game_day']);?>" class="btn btn-primary"> Chart</a></td>
                     </tr>
                     <?php endforeach; else: ?>
                      No data for the championchip selected ! Please extract some data.
                     <?php endif; ?>
                  </tbody>
               </table>
            </div>
         </div>
         <!-- /#page-content-wrapper -->
      </div>
      <!-- jQuery -->
      <script src="<?= $base_url;?>js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="<?= $base_url;?>js/bootstrap.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
      <script type="text/javascript">
         $(document).ready( function () {
           $('#soccer-games').DataTable();
         });
      </script>
   </body>
</html>