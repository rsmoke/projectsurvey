<?php
  require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configProjSurvey.php';
  require_once($_SERVER["DOCUMENT_ROOT"] . "/../Support/basicLib.php");

  if ($login_name === "ahlgrenl" || $login_name === "mdbacon" || $login_name === "rsmoke") {
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="./admincss/admincss.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready( function(){
    $( ".btn-big-red" ).click(function() {
    $("#animbtn").hide("fast");
    $( "#ballFactory" ).slideDown( 5000, function() {
    $( "#doneDiv" ).fadeIn( 100 );
    $( "#doneMessage" ).fadeIn( 100 );
    });
    //return false;
    });
    });
    </script>
  </head>
  <body>
    <div id="animbtn">
      <a href="fileDownload.php" class="btn-big-red">easy</a>
    </div>
    <div id="container">
      <div id="ballFactory"><img src="./adminimg/1zP7tHO.gif" width="500" height="500" alt="Ball Factory"></div>
      <div id="doneDiv"><span id="doneMessage">Yippee, your file is downloaded!</span></div>
    </div>
  </body>
</html>
<?php
} else {
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">

    <title>LSA You are Not Authorized</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Not_Authorized, UniversityofMichigan">
    <meta name="author" content="LSA-MIS_rsmoke">
    <link rel="icon" href="http://umich.edu/favicon.ico">

    <style>
    body {
      position: relative;
    }
    .page-header {
   width: 400px;
  height: 100px;
  padding: 20px;

  position: absolute;
  top: 50%;
  left: 30%;
      }

    </style>
  </head>

  <body>

      <div class="page-header">
      <a href="http://www.umich.edu"><img src="../img/banner.png" class="img-responsive" alt="LSA Banner"></a><br>
        <h3>Got nuttin' for you to see here</h3>
        Try going back to the <a href="http://www.umich.edu">University of Michigan</a> portal

      </div>
  </body>
  </html>
<?php
}