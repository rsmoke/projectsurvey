<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configProjSurvey.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php';
$_SESSION['message'] = "<h4>&nbsp;</h4>";

if (isset($_POST["logout"])) {
    header("Location: https://weblogin.umich.edu/cgi-bin/logout");
    exit;
}

if (isset($_POST["submit"])) {
// the form collects the input as a multi-dimensional array. i can loop through the items in $_POST['foo'] like this:
    foreach ($_POST['id'] as $key => $value) {
        $recID = $key;
        $projType = "";
        $assistcomments = "";
        $howusedcomments = "";
        $blog = 0;
        $chatroom = 0;
        $communications = 0;
        $coursework = 0;
        $filesharing = 0;
        $filestorage = 0;
        $informational = 0;
        $otherusage = 0;
        //now i can loop throught the subitems
        foreach ($value as $itemkey => $item) {
            if (($itemkey == 'projType') && (strlen($item) > 0)) {
                $projType = $db->real_escape_string(test_input($item));
            }
            if (($itemkey == 'howusedcomments') && (strlen($item) > 0)) {
                $howusedcomments = $db->real_escape_string(test_input($item));
            }
            if (($itemkey == 'assistcomments') && (strlen($item) > 0)) {
                $assistcomments = $db->real_escape_string(test_input($item));
            }
            if ($itemkey == 'blog') {
                $blog = 1;
            }
            if ($itemkey == 'chatroom') {
                $chatroom = 1;
            }
            if ($itemkey == 'communications') {
                $communications = 1;
            }
            if ($itemkey == 'coursework') {
                $coursework = 1;
            }
            if ($itemkey == 'filesharing') {
                $filesharing = 1;
            }
            if ($itemkey == 'filestorage') {
                $filestorage = 1;
            }
            if ($itemkey == 'informational') {
                $informational = 1;
            }
            if ($itemkey == 'otherusage') {
                $otherusage = 1;
            }
        }

        $sqlUpdate = <<<SQL
        UPDATE tbl_surveylist
        SET
        `projType` = '{$projType}',
        `assistcomments` = '{$assistcomments}',
        `howusedcomments` = '{$howusedcomments}',
        `editedby` = '{$login_name}',
        `blog`     = $blog,
        `chatroom` = $chatroom,
        `communications` = $communications,
        `coursework` = $coursework,
        `filesharing` = $filesharing,
        `filestorage` = $filestorage,
        `informational` = $informational,
        `otherusage` = $otherusage
        WHERE `id` = $key
SQL;
        if (!$result = $db->query($sqlUpdate)) {
            db_fatal_error($db->error, $siteTitle, "data insert issue", $sqlUpdate);
            $_SESSION['message'] = "<h4 style='color: #FF0066;'>There was an error please try again</h4>";
            exit;
        }
        $_SESSION['message'] = "<h4 style='color: #00CC00;'>The items you edited have been submitted</h4>";
    }

    unset($_POST["submit"]);
}

$sqlSelectSites = <<<SQL
SELECT `id`,
    `dept`,
    `deptContactUniqname`,
    `projSiteName`,
    `projSiteRole`,
    `projSiteURL`,
    `projType`,
    `assistcomments`,
    `howusedcomments`,
    `blog`,
    `chatroom`,
    `communications`,
    `coursework`,
    `filesharing`,
    `filestorage`,
    `informational`,
    `otherusage`
FROM tbl_surveylist
WHERE deptContactUniqname = '$login_name'
SQL;

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title><?php echo $siteTitle;?></title>
  <meta name="description" content="<?php echo $siteTitle;?>">
  <meta name="rsmoke" content="LSA_MIS">

  <link rel="shortcut icon" href="http://umich.edu/favicon.ico">

  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/myStyles.css" type="text/css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv-printshiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
   <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><?php echo $siteTitle?></a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home</a></li>
        </ul>
        <div class="navbar-right">
        <span style="color:#333;"><small>You are logged in as <?php echo $login_name;?></small></span><br>
          <form class="navbar-form" role="logout" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <button type="logout" name="logout" class="btn btn-default btn-xs">LogOut</button>
          </form>
        </div>
      </div><!--/.nav-collapse -->
    </div>
  </div>



  <div class="container">
    <div class="jumbotron">
      <div class="centerfy"><img src="img/banner.png" class="img-responsive" alt="LSA Logo" /></div>
      <h3>LSA CTools Project Survey</h3>
      <h4>Below are the CTools Project sites that you are listed as the contact person. Please help us identify the usage for each site.</h4>
      <p>Although, no immediate plans have been made for the retirement of CTools, LSA would like to have a better understanding on how the
       CTools Project sites are being used within the college; this will help in our efforts to properly identify alternative solutions.</p>
        <p>Below are the CTools Project sites that you are listed as the contact person. Please help us identify the usage for each site.</p>
    </div>
  </div>
  <div class="container">
    <div class="col-xs-9 col-xs-offset-3">
      <div id="notify"><?php echo $_SESSION['message'];?></div>
    </div>
  </div>
      <form id="recordForm" name="recordForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
        <!-- append form questions from database -->

<?php
if (!$result = $db->query($sqlSelectSites)) {
    db_fatal_error("data selection issue", $db->error);
    exit;
}

$i = 0;
while ($row = $result->fetch_assoc()) {
    if (strlen($row['projType']) > 1) {
        $checkType = $row['projType'];
    } else {
        $checkType = "";
    }
    if (strlen($row['howusedcomments']) > 1) {
        $checkHowusedComment = $row['howusedcomments'];
    } else {
        $checkHowusedComment = "";
    }
    if (strlen($row['assistcomments']) > 1) {
        $checkAssistComment = $row['assistcomments'];
    } else {
        $checkAssistComment = "";
    }
    $i = $i + 1;
    echo '<div class="container">';
    echo '<div class="col-xs-10 col-xs-offset-2"> ';
    echo "<hr><span class='siteNum'>Site# " . $i . "</span>  - Department: " . $row['dept'] . "<br>Site Name: " . $row['projSiteName'] . "<br>URL: <a href='" . $row['projSiteURL'] . "' target='_blank'>" . $row['projSiteURL'] . "</a><h4>How is this project site being used? (Check all that apply)</h4>";
    //echo '<div class="row clearfix">';
    echo '<input type="hidden" name = "id[' . $row['id'] . ']" value="' . $row['id'] . '">';

        echo '<div class="form-group required"> ';

            echo '<div class="checkbox"> ';
            echo '<label> ';
            echo '<input type="checkbox" name="id[' . $row['id'] . '][blog]"  value="1" ';if ($row['blog'] == 1) {echo 'checked';};
            echo '> ';
            echo ' Blog ';
            echo '</label> ';
            echo '</div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][chatroom]"  value="1" ';if ($row['chatroom'] == 1) {echo "checked";};
            echo '> ';
            echo ' Chat Room ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][communications]"  value="1" ';if ($row['communications'] == 1) {echo "checked";};
            echo '> ';
            echo '  Communications ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][coursework]"  value="1" ';if ($row['coursework'] == 1) {echo "checked";};
            echo '> ';
            echo ' Coursework ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][filesharing]"  value="1" ';if ($row['filesharing'] == 1) {echo "checked";};
            echo '> ';
            echo '  File Sharing - Collaboration ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][filestorage]"  value="1" ';if ($row['filestorage'] == 1) {echo "checked";};
            echo '> ';
            echo '  File Storage - Archiving ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="checkbox"> ';
            echo '<label> ';
            echo '<input type="checkbox" name="id[' . $row['id'] . '][informational]"  value="1" ';if ($row['informational'] == 1) {echo "checked";};
            echo '> ';
            echo ' Informational (HowTo?) ';
            echo '</label> ';
            echo '</div> ';

            echo '<div class="checkbox"> ';
            echo ' <label> ';
            echo ' <input type="checkbox" name="id[' . $row['id'] . '][otherusage]"  value="1" ';if ($row['otherusage'] == 1) {echo "checked";};
            echo '> ';
            echo '  Other';
            echo ' </label> ';
            echo ' </div> ';

        echo '</div> '; // end of required form-group (radio buttons)
        echo '</div>'; // end of row offset

            echo '<div class="col-xs-6 col-xs-offset-2"> ';
          echo '<div class="form-group"> ';
          echo '<label for="comments">Comment(s)</label> ';
          echo '<textarea class="form-control" rows="3" tabindex="130" id="howusedcomments" name = "id[' . $row['id'] . '][howusedcomments]">' . $checkHowusedComment . '</textarea> ';
          echo '</div> ';
        echo '</div> '; //end of offset row

        echo '<div class="col-xs-10 col-xs-offset-2"> ';
        echo '<h4>Please identify the type of assistance you would need for this site?</h4>';
        echo '<div class="form-group required"> ';

            echo '<div class="radio"> ';
            echo '<label> ';
            echo '<input type="radio" name="id[' . $row['id'] . '][projType]"  value="StillUsingHelpMove" ';if (strtolower($checkType) == 'stillusinghelpmove') {echo 'checked';};
            echo '> ';
            echo ' Site is still in use and would like help moving to a different platform. ';
            echo '</label> ';
            echo '</div> ';

            echo '<div class="radio"> ';
            echo ' <label> ';
            echo ' <input type="radio" name="id[' . $row['id'] . '][projType]"  value="StorageOnly" ';if (strtolower($checkType) == "storageonly") {echo "checked";};
            echo '> ';
            echo ' Site is only being used for storage and could be deleted if an alternative storage solution was provided. ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="radio"> ';
            echo ' <label> ';
            echo ' <input type="radio" name="id[' . $row['id'] . '][projType]"  value="CanDelete" ';if (strtolower($checkType) == "candelete") {echo "checked";};
            echo '> ';
            echo '  This site is no longer active and can be deleted ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="radio"> ';
            echo ' <label> ';
            echo ' <input type="radio" name="id[' . $row['id'] . '][projType]"  value="None" ';if (strtolower($checkType) == "none") {echo "checked";};
            echo '> ';
            echo ' None ';
            echo ' </label> ';
            echo ' </div> ';

            echo '<div class="radio"> ';
            echo ' <label> ';
            echo ' <input type="radio" name="id[' . $row['id'] . '][projType]"  value="Other" ';if (strtolower($checkType) == "other") {echo "checked";};
            echo '> ';
            echo '  Other';
            echo ' </label> ';
            echo ' </div> ';

        echo '</div> '; // end of required form-group (radio buttons)

    echo '</div>'; // end of row offset


    echo '<div class="col-xs-6 col-xs-offset-2"> ';
      echo '<div class="form-group"> ';
      echo '<label for="comments">Comment(s)</label> ';
      echo '<textarea class="form-control" rows="3" tabindex="130" id="assistcomments" name = "id[' . $row['id'] . '][assistcomments]">' . $checkAssistComment . '</textarea> ';
      echo '</div> ';
    echo '</div> '; //end of offset row
    echo '</div>'; //end of container
    //echo '</div>';
}
?>
  <div class= "container">
    <div class="col-xs-12">
        <div class="text-center">
         <button class="btn btn-info" tab-index="200" type="submit" name="submit" id="submit">Submit</button>
        </div>
      </form>
    </div>
  </div> <!--close container -->

  <footer class="container">
    <div id="contentBlock" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="col-xs-5 col-xs-offset-1">
        <address>
          LSA Dean's Office - Budget and Finance<br>
          500 South State Street<br>
          Ann Arbor, MI 48109-1382
        </address>
      </div>
      <div class="col-xs-4 col-xs-offset-2" >
        <img src="img/lsa_mis.png" class="img-responsive" alt="MIS Logo">
      </div>
    </div>
    <div class="row clearfix">
        <p class="text-center"><small>Copyright &copy; 2014 by The Regents of the University of Michigan<br />
        All Rights Reserved.</small><br></p>
    </div>
  </footer>

  <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>
<?php ;
$db->close();