<?php
  include '../db/db.php';
  include '../db/accesscontrol.php';

  if(!isset($_SESSION['dicom_username']))
    exit;
  if( isset($_POST['password'])){
    echo "string";
    $email = $_POST['email'];
    $username = $_SESSION['dicom_username'];
    $password = $_POST['password'];
    $result = updateUser($username, $password, $email, $role);
    switch ($result) {
      case 400:
        $_SESSION['user_success'] = "Information successfuly updated.";
        break;
      case 403:
        $_SESSION['user_error'] = "Wrong parameters.";
        break;
      case 404:
        $_SESSION['user_error'] = "Connection error!";
        break;
      default:
        break;
    }
  }

  header('location: ../../../../setting.php')
?>
