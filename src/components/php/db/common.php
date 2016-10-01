<?php

function get_date($datetime){
  return substr($datetime, 0, 10);
}

function get_time($datetime){
  return substr($datetime, 10, 8);
}

function get_age($dob){
  $year = substr($dob, 0, 4);

  if(!$year)
    return 'N/A';

  return (int)date('Y') - (int)$year;
}

function is_valid($var){
  return isset($var) && !empty(trim($var));
}

function fixDICOMName($name) {
  //TODO:30 Regex to fix name invalid character
}
?>
