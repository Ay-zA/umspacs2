<?php
  require_once 'common.php';

  session_start();
  function createUser($username, $password, $email, $role){
    if(!is_valid($username) || !is_valid($password) || !is_valid($role)) return 403; // Null Param
    if(is_user_exist($username)) return 405; // Existed

    $conn = connect("dicom");
    if($conn == null)
      return 404; //Connection failed

    $query = "INSERT INTO `users`(`username`, `email`, `role`, `password`) VALUES(:username, :email, :role, :password);";
    $query = $conn->prepare($query);

    $query->bindParam(':username', $username);
    $query->bindParam(':email', $email);
    $query->bindParam(':role', $role);
    $query->bindParam(':password', $password);

    $query->execute();
    return 400; // OK
  }

  function is_session_exist(){
    if(isset($_SESSION['dicom_username']) && isset($_SESSION['dicom_password']) )
     return is_user_exist($_SESSION['dicom_username'], $_SESSION['dicom_password']);

    return false;
  }

  function is_user_exist($user)
  {
    $conn = connect("dicom");
    if($conn == null)
      return;
    $query = "SELECT * FROM users WHERE username = :username;";
    $query = $conn->prepare($query);
    $query->bindParam(':username', $user);
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

  function canAccess($username, $action){
    if(!is_valid($username) || !is_valid($action))
      return false;
  }

?>
