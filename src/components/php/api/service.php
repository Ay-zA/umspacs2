<?php
  // header('Content-Type: application/json');
  require_once "../db/db.php";
  require_once "../db/common.php";
  $response = "";

  function returnAllStudies(){
    $result = getAllPatient();
    return $result;
  }

  function returnAllSeries($study_pk) {
    $result = getAllSeries($study_pk);
    return $result;
  }

  function returnAllInstances($serie_pk){
    $result = getAllInstances($serie_pk);
    return $result;
  }

  function returnInstitutionName($study_pk){
    $result = getInstitutionName($study_pk);
    return $result;
  }

  if(isset($_GET['action'])){
    $action = strtolower($_GET['action']);
    switch($action){
      case 'getinstitutionname':
        $response = returnInstitutionName($_GET['study_pk']);
        break;
      case 'getallseries':
        $response = returnAllSeries($_GET['study_pk']);
        break;
      case 'getallinstances':
        $response = returnAllInstances($_GET['serie_pk']);
        break;
      case 'getallstudies':
        $response = returnAllStudies();
        break;
      case 'searchstudies':
        // echo  $_GET['id'] . "<br>" . $_GET['name']. '<br> ' . $_GET['modality']. '<br> ' . $_GET['from']. '<br> ' . $_GET['to'];
        $id           = is_valid($_GET['id'])           ? $_GET['id']                 : NULL;
        $name         = is_valid($_GET['name'])         ? $_GET['name']               : NULL;
        $modality     = is_valid($_GET['modality'])     ? $_GET['modality']           : NULL;
        $from         = is_valid($_GET['from'])         ? $_GET['from'] . ' 00:00:00' : NULL;
        $to           = is_valid($_GET['to'])           ? $_GET['to'] . ' 23:59:59'   : NULL;
        $institution  = is_valid($_GET['institution'])  ? $_GET['institution']        : NULL;
        // $modality     = explode("\\", $modality);
        // $arr = [];
        // var_dump($modality);
        // for ($i=0; $i < count($modality); $i++) {
          // $arr["modality$i"] = $modality[$i];
        // }
        // var_dump($arr);
        $response = searchStudies($id, $name, $modality, $from, $to, $institution);
        break;
    }
  }

 exit(json_encode($response));
 ?>
