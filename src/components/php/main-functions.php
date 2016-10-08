<?php
$ignoreInsts = [''];
$ignoreMods = ["","OT","SR"];

function loadAllVisibleModalities($cb){
  global $ignoreMods;
  $allMoladities = getAllModalities();
  foreach ($allMoladities as $key => $value) {
    if(in_array($value['modality'], $ignoreMods) || $value['visibility'] == 0) continue;
    $cb($value['modality'],'info', $value['id']);
  }
}

function loadAllVisibleInstitution($cb){
  global $ignoreInsts;
  $allInstitution = getAllInstitutions();
  foreach ($allInstitution as $key => $value) {
    if(in_array( $value['name'], $ignoreInsts) || $value['visibility'] == 0) continue;
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
