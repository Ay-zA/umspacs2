<?php
$ignoreInsts = [''];
$ignoreMods = ["","OT","SR"];

function loadAllModalities($cb){
  global $ignoreMods;
  $allMoladities = getAllModalities();
  foreach ($allMoladities as $key => $value) {
    if(in_array($value['modality'], $ignoreMods)) continue;
    $cb($value['modality'],'info', $value['id']);
  }
}

function loadAllInstitution($cb){
  global $ignoreInsts;
  $allInstitution = getAllInstitutions();
  foreach ($allInstitution as $key => $value) {
    if(in_array( $value['name'], $ignoreInsts)) continue;
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
