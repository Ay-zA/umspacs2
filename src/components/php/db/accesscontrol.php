<?php
require_once 'common.php';
require_once 'db.php';
include 'access.config.php';

session_start();

function createUser($username, $password, $email, $role) {
  if (!canAccess(NULL, 'CREATE_USER'))
    return 403; // Can't Access

  if (isUserExist($username))
    return 405; // Existed

  $username = strtolower($username);
  $password = md5($password);

  $conn = connect("dicom");
  if ($conn == null)
    return 404; //Connection failed

  $query = "INSERT INTO `users`(`username`, `email`, `role`, `password`) VALUES(:username, :email, :role, :password);";
  $query = $conn->prepare($query);

  $query->bindParam(':username', $username);
  $query->bindParam(':email', $email);
  $query->bindParam(':role', $role);
  $query->bindParam(':password', $password);

  $query->execute();
  return 200; // OK
}

function updateUser($username = NULL, $password = NULL, $email = NULL, $role = NULL) {

  if (!is_valid($username))
    return 403; // Null Username

  $username = strtolower($username);
  $currentRole = getRole($username);

  if ($role == $currentRole){
      $role = NULL;
  }

  if (!isset($password) && !is_valid($email) && !is_valid($role))
    return 406; // No change needed

  if (!isUserExist($username))
    return 405; // Not Existed

  $conn = connect("dicom");
  if ($conn == null)
    return 404; //Connection failed

  $queryCommand = "UPDATE `users` SET";
  $queryParams = "`username` = :username";

  if (is_valid($password))
    $queryParams .= ", `password`=:password";

  if (is_valid($email))
    $queryParams .= ", `email`=:email";

  if (is_valid($role))
    $queryParams .= ", `role`=:role";

  $queryCondition = " WHERE `username`=:username;";
  $query = $queryCommand.$queryParams.$queryCondition;
  $query = $conn->prepare($query);

  if (is_valid($password)) {
    $password = md5($password);
    $query->bindParam(':password', $password);
  }

  if (is_valid($email))
    $query->bindParam(':email', $email);

  if (is_valid($role))
    $query->bindParam(':role', $role);

  $query->bindParam(':username', $username);
  $query->execute();

  return 200; // OK
}

function is_session_exist() {
  if (isset($_SESSION['dicom_username']) && isset($_SESSION['dicom_password']))
    return isValidUser($_SESSION['dicom_username'], $_SESSION['dicom_password']);

  return false;
}

function isUserExist($user) {
  $conn = connect("dicom");
  if ($conn == null)
    return;

  $query = "SELECT * FROM users WHERE username = :username;";
  $query = $conn->prepare($query);
  $query->bindParam(':username', $user);
  $query->execute();
  return $query->rowCount() === 1;
}

function isValidUser($username, $password) {
  $conn = connect("dicom");
  if ($conn == null)
    return;

  $password = md5($password);
  $query = "SELECT * FROM users WHERE username = :username && password = :password;";
  $query = $conn->prepare($query);
  $query->bindParam(':username', $username);
  $query->bindParam(':password', $password);
  $query->execute();
  return $query->rowCount() === 1;
}

function login($user, $pass, $location) {
  if (isValidUser($user, $pass)) {
    $_SESSION['dicom_username'] = $user;
    $_SESSION['dicom_password'] = $pass;
    $_SESSION['dicom_role'] = getRole($user);
    header("location: $location");
    return true;
  }
  return false;
}

function logout() {
  $_SESSION = array();
  session_destroy();
  header("location: ../../../index.php");
}

function getRole($username) {
  $conn = connect("dicom");

  if ($conn == null)
    return 404; //Connection failed

  $query = "SELECT `role` FROM `users` WHERE `username`=:username";
  $query = $conn->prepare($query);
  $query->bindParam(':username', $username);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);
  return $result['role']; // OK
}

function canAccess($username, $action) {
  global $accessList;

  if ($username == NULL) {
    $username = $_SESSION['dicom_username'];
    $role = $_SESSION['dicom_role'];
  }
  else
    $role = getRole($username);

  if (!is_valid($username) || !is_valid($action) || !is_valid($role))
    return false;

  if (!in_array($action, $accessList[$role]))
    return false;

  return true;
}

function deleteUser($username) {
  if (!canAccess(NULL, 'DELETE_USER'))
    return 403;

  if (!isUserExist($username))
    return 400; // NotExisted

  if ($username == $_SESSION['dicom_username'])
    return 406; // Can't remove yourself

  $conn = connect("dicom");
  if ($conn == NULL)
    return 404; //Connection failed

  $query = "DELETE FROM `users` WHERE `users`.`username` = :username;";
  $query = $conn->prepare($query);
  $query->bindParam(':username', $username);
  $query->execute();

  return 200; // OK
}

?>
