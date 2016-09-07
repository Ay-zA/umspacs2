<?php
function loadAllModalities(){
  $allMoladities = getAllModalities(true);
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
?>
