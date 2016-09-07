<?php
function loadAllModalities(){
  $allMoladities = getAllModalities();
  foreach ($allMoladities as $key => $value) {
    echo modalityRow($value['modality'],'info', $value['id']);
  }
}
function modalityRow($name='', $info='', $id=''){
  return "<tr>
    <td>$name</td>
    <td>$info</td>
    <td>Remove</td>
  </tr>";
}

function loadAllInstitution(){
  $allInstitution = getAllInstitutions();
  // var_dump($allInstitution);
  foreach ($allInstitution as $key => $value) {
    if($value['name'] == '') continue;
    echo institutionRow($bar = ucwords(strtolower($value['name'])), $value['id']);
  }
}

function institutionRow($name='', $id=''){
  return "<tr>
            <td>$name</td>
            <td>remove</td>
          <tr>";
}

function loadAllUsers()
{
  $allInstitution = getAllUsers();
  foreach ($allInstitution as $key => $value) {
    if($value['username'] == '') continue;
    echo userRow($bar = ucwords(strtolower($value['username'])), $value['email'], $value['role']);
  }
}

function userRow($name='',$email='N/A',$role=''){
  if($email == '') $email = 'N/A';
  return "<tr>
            <td>$name</td>
            <td>$email</td>
            <td>$role</td>
            <td>Remove</td>
          <tr>";
}
?>
