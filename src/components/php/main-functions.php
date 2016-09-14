<?php
function loadAllModalities($cb){
  $allMoladities = getAllModalities();
  foreach ($allMoladities as $key => $value) {
    $cb($value['modality'],'info', $value['id']);
  }
}

function loadAllInstitution($cb){
  $allInstitution = getAllInstitutions();
  foreach ($allInstitution as $key => $value) {
    if($value['name'] == '') continue;
    $cb($bar = ucwords(strtolower($value['name'])), $value['id']);
  }
}

$pritnModOption = function ($name='', $info = '', $id = '') {
  echo "<option>$name</option>";
};

$printInstOption = function ($name='', $id = '') {
  echo "<option>$name</option>";
};
?>
