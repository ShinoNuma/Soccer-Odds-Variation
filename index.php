<?php 
   include 'functions.php';
   $Soccer = new Soccer();
   $base_url = $Soccer->base_url();
   $lastUpdates = array();
   $lastUpdates['ligue1'] = $Soccer->get_last_auto_extraction_ligue1();
?>
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
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="css/simple-sidebar.css" rel="stylesheet">
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
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-ligue1"></div>
                        <h1>Ligue 1 🇫🇷</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for Ligue 1 for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="ligue1" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download Ligue 1 odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for Ligue 1 for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=ligue1">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-premierleague"></div>
                        <h1>Premier League 🇬🇧</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for Premier League for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="premierleague" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download Premier League odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for Premier League for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=premierleague">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-bundesliga"></div>
                        <h1>Bundesliga 🇩🇪</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for Bundesliga for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="bundesliga" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download Bundesliga odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for Bundesliga for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=bundesliga">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-laliga"></div>
                        <h1>La Liga 🇪🇸</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for La Liga for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="laliga" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download La Liga odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for laliga for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=laliga">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-primeiraliga"></div>
                        <h1>Primeira Liga 🇵🇹</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for Primeira Liga for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="primeiraliga" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download Primeira Liga odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for the Primeira Liga for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=primeiraliga">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="jumbotron well" style="float:left;">
                        <div id="notification-ligue2"></div>
                        <h1>Ligue 2 🇫🇷</h1>
                        <div class="col-md-6">
                           <h2>
                              Manual Scraping
                           </h2>
                           <p>
                              Get the last odds by match.
                              <small>Next Auto Scraping in: <code id="nextExtraction"><?php 
                                 if(!empty($lastUpdate[0])):
                                     $datetime1 = new DateTime('now');
                                     $datetime2 = new DateTime(date('H:i:s',  strtotime($lastUpdate[0]."+4 hour")));
                                     $interval = $datetime1->diff($datetime2);
                                     echo $interval->format('%H:%I:%S').' secondes'; 
                                 else:
                                     echo 'Please configure the cron job for Ligue 2 for be able to see the next auto scraping.';
                                 endif;
                                 ?></code></small>
                           </p>
                           <p>
                              <button class="btn btn-primary btn-large manualScraping" data-championship="ligue2" type="button">Scraping Odds! </button>
                           </p>
                        </div>
                        <div class="col-md-6">
                           <h2>
                              Download Ligue 2 odds database
                           </h2>
                           <p>
                              <small>Latest database update: <code><?php 
                                 if(!empty($lastUpdate[0])):
                                     $lastUpdate[0].' secondes';
                                 else:
                                     echo 'Please configure the cron job for the Ligue 2 for be able to see the next auto scraping.';
                                 endif;?></code></small>
                           </p>
                           <p>
                              <a class="btn btn-success btn-large" href="<?= $base_url;?>exportCSV.php?export=ligue2">CSV file</a>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /#page-content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <div id="loader" style="z-index:10;position:fixed;width:100%;height:100%;top:0%;bottom:0%;left:0%;right:0%;background-color:rgba(0, 0, 255, 0.5);display:none;">
         <div class="lds-css ng-scope" style="position:absolute;top:20%;bottom: 50%;left: 40%;right: 50%;width: 50%;">
            <div class="lds-pacman">
               <div>
                  <div></div>
                  <div></div>
                  <div></div>
               </div>
               <div>
                  <div></div>
                  <div></div>
               </div>
            </div>
            <h1>Scraping in progress. Be patient...</h1>
            <style type="text/css">@keyframes lds-pacman-1 {
               0% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               50% {
               -webkit-transform: rotate(-45deg);
               transform: rotate(-45deg);
               }
               100% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               }
               @-webkit-keyframes lds-pacman-1 {
               0% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               50% {
               -webkit-transform: rotate(-45deg);
               transform: rotate(-45deg);
               }
               100% {
               -webkit-transform: rotate(0deg);
               transform: rotate(0deg);
               }
               }
               @keyframes lds-pacman-2 {
               0% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               50% {
               -webkit-transform: rotate(225deg);
               transform: rotate(225deg);
               }
               100% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               }
               @-webkit-keyframes lds-pacman-2 {
               0% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               50% {
               -webkit-transform: rotate(225deg);
               transform: rotate(225deg);
               }
               100% {
               -webkit-transform: rotate(180deg);
               transform: rotate(180deg);
               }
               }
               @keyframes lds-pacman-3 {
               0% {
               -webkit-transform: translate(190px, 0);
               transform: translate(190px, 0);
               opacity: 0;
               }
               20% {
               opacity: 1;
               }
               100% {
               -webkit-transform: translate(70px, 0);
               transform: translate(70px, 0);
               opacity: 1;
               }
               }
               @-webkit-keyframes lds-pacman-3 {
               0% {
               -webkit-transform: translate(190px, 0);
               transform: translate(190px, 0);
               opacity: 0;
               }
               20% {
               opacity: 1;
               }
               100% {
               -webkit-transform: translate(70px, 0);
               transform: translate(70px, 0);
               opacity: 1;
               }
               }
               .lds-pacman {
               position: relative;
               }
               .lds-pacman > div:nth-child(2) div {
               position: absolute;
               top: 40px;
               left: 40px;
               width: 120px;
               height: 60px;
               border-radius: 120px 120px 0 0;
               background: #f6b93b;
               -webkit-animation: lds-pacman-1 1s linear infinite;
               animation: lds-pacman-1 1s linear infinite;
               -webkit-transform-origin: 60px 60px;
               transform-origin: 60px 60px;
               }
               .lds-pacman > div:nth-child(2) div:nth-child(2) {
               -webkit-animation: lds-pacman-2 1s linear infinite;
               animation: lds-pacman-2 1s linear infinite;
               }
               .lds-pacman > div:nth-child(1) div {
               position: absolute;
               top: 92px;
               left: -8px;
               width: 16px;
               height: 16px;
               border-radius: 50%;
               background: #f8c291;
               -webkit-animation: lds-pacman-3 1s linear infinite;
               animation: lds-pacman-3 1s linear infinite;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(1) {
               -webkit-animation-delay: -0.67s;
               animation-delay: -0.67s;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(2) {
               -webkit-animation-delay: -0.33s;
               animation-delay: -0.33s;
               }
               .lds-pacman > div:nth-child(1) div:nth-child(3) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               }
               .lds-pacman {
               width: 200px !important;
               height: 200px !important;
               -webkit-transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
               transform: translate(-100px, -100px) scale(1) translate(100px, 100px);
               }
            </style>
         </div>
      </div>
      <!-- jQuery -->
      <script src="js/jquery.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script src="js/bootstrap.min.js"></script>
      <!-- Menu Toggle Script -->
      <script>
         $("#menu-toggle").click(function(e) {
             e.preventDefault();
             $("#wrapper").toggleClass("toggled");
         });
      </script>
      <script type="text/javascript">
         $(function(){
         $('.manualScraping').on('click', function(e){
             $('#loader').fadeIn(1200);
              let formData = new FormData();
              let championship = $(this).data("championship")
              formData.append(1, championship);
              formData.append(2, 'manual');
              $.ajax({
                type: "post",
                url: "<?= $base_url;?>bot-odds.php",
                data: formData,
                dataType : "json",
                processData: false,
                contentType: false,
                 success: function(data, status){
                    if(data.ajax == 'error'){
                      $(`#notification-${championship}`).empty();
                      $(`#notification-${championship}`).html(`<div class="alert alert-danger"><strong>Danger!</strong> ${data.message}.</div>`);
                      $('#loader').hide();
                    }else{
                      $(`#notification-${championship}`).empty();
                      $(`#notification-${championship}`).html(`<div class="alert alert-success"><strong>Success!</strong> ${data.message}.</div>`);
                      $('#loader').hide();
                    }
                 },
                 error : function(result, status, errors){
                    alert('Ajax error');
                    $('#loader').hide();
                 },
             });
             return false;
             });
         });
         
         /* fix well same size */
         let elements = document.querySelectorAll(".well"),
         heights = [];
         [].forEach.call(elements, function(each) {
         heights[heights.length] = getComputedStyle(each, null).getPropertyValue("height");
         });
         heights.sort(function(a, b) {
         return parseFloat(b) - parseFloat(a);
         });
         [].forEach.call(elements, function(each) {
         each.style.height = heights[0];
         });
      </script>
   </body>
</html>