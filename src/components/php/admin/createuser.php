<?php
  include '../db/db.php';
  include '../db/accesscontrol.php';

  if(isset($_POST['newuser'])){
  if( isset($_POST['newuser_username']) && isset($_POST['newuser_password']) && isset($_POST['newuser_role'])){
    $email = isset($_POST['newuser_email']) ? $_POST['newuser_email'] : 'N/A';
    $username = $_POST['newuser_username'];
    $password = $_POST['newuser_password'];
    $role = $_POST['newuser_role'];
    $result = createUser($username, $password, $email, $role);
    switch ($result) {
      case 400:
        $_SESSION['newuser_success'] = '"' . $username . '"' . " successfuly registered.";
        break;
      case 403:
        $_SESSION['newuser_error'] = '"'. $username .'"' . " wrong parameter.";
        break;
      case 405:
        $_SESSION['newuser_error'] = 'User "'. $username . '"'. " allrady existed.";
        break;
      case 404:
        $_SESSION['newuser_error'] = "Connection error!";
        break;
      default:
        break;
    }
  }
}
  $_SESSION['adminTab'] = 'user-manager';
  header('location: ../../../../setting.php')
?>
