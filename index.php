<?php
  require_once 'src/components/php/db/db.php';
  require_once 'src/components/php/db/accesscontrol.php';

  if (is_session_exist()) {
      header('location: main.php');
  }

  if (isset($_POST['dicom_login'])) {
      $username = $_POST['dicom_username'];
      $password = $_POST['dicom_password'];
      login($username, $password, 'main.php');
  }

?>
  <!DOCTYPE html>

  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UMSPACS - Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="src/images/favicon.ico" />`
    <link href="src/css/login.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
  </head>

  <body>

    <hgroup>
      <h1>سامانه پکس متمرکز دانشگاه <br/><span style="color:#00ffde;">علوم پزشکی</span> استان گلستان</h1>
    </hgroup>
    <form id="login-form" method="post" action="<?=$_SERVER['PHP_SELF']?>">
      <div class="group">
        <input type="text" name="dicom_username"><span class="highlight" value=""></span><span class="bar"></span>
        <label>Username</label>
      </div>
      <div class="group">
        <input type="password" name="dicom_password"><span class="highlight" value=""></span><span class="bar"></span>
        <label>Password</label>
      </div>
      <button type="submit" class="button buttonBlue" name="dicom_login">Login
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
      </button>
    </form>
    <footer>
    </footer>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="css/index.js"></script>

    <script>
      $("form").slideDown(1000);
    </script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>

  </html>
