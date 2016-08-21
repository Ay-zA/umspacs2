<?php
//  include_once "db.php";
  require_once 'common.php';

  session_start();

  function is_session_exist(){
    if(isset($_SESSION['dicom_username']) && isset($_SESSION['dicom_password']) )
     return is_user_exist($_SESSION['dicom_username'], $_SESSION['dicom_password']);

    return false;
  }

  function is_user_exist($user, $pass)
  {
    $conn = connect("dicom");
    if($conn === null)
      return;
    $query = "SELECT * FROM users WHERE username = :username AND password = :password;";
    $query = $conn->prepare($query);
    $query->bindParam(':username', $user);
    $query->bindParam(':password', $pass);
    $query->execute();
    return $query->rowCount() === 1;
  }

  function login($user, $pass, $location){
    if(is_user_exist($user, $pass)){
      $_SESSION['dicom_username'] = $user;
      $_SESSION['dicom_password'] = $pass;
      header("location: $location");
      return true;
    }
    return false;
  }

  function logout(){
    $_SESSION = array();
    session_destroy();
    header("location: ../../../index.php");
  }

?>
