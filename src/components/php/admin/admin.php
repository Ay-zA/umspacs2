<?php
$ignoreInsts = [''];
$ignoreMods = ["","OT","SR"];

function loadAllModalities(){
  global $ignoreMods;
  $allModalities = getAllModalities();
  foreach ($allModalities as $key => $value) {
    if(in_array($value['modality'], $ignoreMods)) continue;
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
  global $ignoreInsts;
  $allInstitution = getAllInstitutions();
  foreach ($allInstitution as $key => $value) {
    if(in_array( $value['name'], $ignoreInsts)) continue;
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
  return '<tr>
            <td data-type="username">'.$name.'</td>
            <td data-type="email">'.$email.'</td>
            <td data-type="role">'.$role.'</td>
            <td>
              <button class="btn btn-default edit-user" data-username="'. strtolower($name) .'" >Edit</button>
              <button class="btn btn-default delete-user" data-username="'. strtolower($name) .'" >Remove</button>
            </td>
          <tr>';
}
?>
