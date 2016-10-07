<?php
  header('Content-Type: application/json');
  require_once "../db/db.php";
  require_once "../db/common.php";
  require_once "../db/accesscontrol.php";
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

  function returnUpdateUser() {

    $username = (isset($_GET['username']) && is_valid($_GET['username'])) ?  $_GET['username']  : NULL;
    $password = (isset($_GET['password']) && is_valid($_GET['password'])) ?  $_GET['password']  : NULL;
    $email = (isset($_GET['email']) && is_valid($_GET['email'])) ?  $_GET['email']   : NULL;
    $role =  (isset($_GET['role']) && is_valid($_GET['role'])) ?  $_GET['role']   : NULL;

    $reuslt = updateUser($username, $password, $email, $role);
    return $reuslt;
  }

  function returnAllUsers() {
    return getAllUsers();
  }

  function returnSetModalityVisibility() {
    $visibility = (isset($_GET['visibility']) && is_valid($_GET['visibility'])) ?  $_GET['visibility']  : NULL;
    $id = (isset($_GET['id']) && is_valid($_GET['id'])) ?  $_GET['id']  : NULL;
    $result = setModalityVisibility($visibility, $id);
    return $result;
  }

  function returnSetInstitutionVisibility() {
    $visibility = (isset($_GET['visibility']) && is_valid($_GET['visibility'])) ?  $_GET['visibility']  : NULL;
    $id = (isset($_GET['id']) && is_valid($_GET['id'])) ?  $_GET['id']  : NULL;
    $result = setInstitutionVisibility($visibility, $id);
    return $result;
  }

  function returnAllIgnoredModalities() {
    $result = getAllIgnoredModalities();
    return $result;
  }
  function returnAllIgnoredInstitution() {
    $result = getAllIgnoredInstitution();
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
      case 'getalldynamicmods':
        $response = getAllModalities(true);
        break;
      case 'getalldynamicinsts':
        $response = getAllInstitutions(true);
        break;
      case 'getstudycount':
        $response = getStudyCount();
        break;
      case 'getpatientinfo':
        $response = getPatientInfo($_GET['pat_id']);
        break;
      case 'deleteuser':
        $response = deleteUser($_GET['username']);
        break;
      case 'getallusers':
        $response = returnAllUsers();
        break;
      case 'updateuser':
        $response = returnUpdateUser();
        break;
      case 'setmodalityvisibility':
        $response = returnSetModalityVisibility();
        break;
      case 'setinstitutionvisibility':
        $response = returnSetInstitutionVisibility();
        break;
      case 'getignoredmodalities':
        $response = returnAllIgnoredModalities();
      case 'getignoredinstitutions':
        $response = returnAllIgnoredInstitution();
      case 'searchstudies':
        // echo  $_GET['id'] . "<br>" . $_GET['name']. '<br> ' . $_GET['modality']. '<br> ' . $_GET['from']. '<br> ' . $_GET['to'];
        $id           = is_valid($_GET['id'])          ? $_GET['id']                 : NULL;
        $name         = is_valid($_GET['name'])        ? $_GET['name']               : NULL;
        $accession    = is_valid($_GET['accession'])   ? $_GET['accession']          : NULL;
        $modality     = is_valid($_GET['modality'])    ? $_GET['modality']           : NULL;
        $from         = is_valid($_GET['from'])        ? $_GET['from'] . ' 00:00:00' : NULL;
        $to           = is_valid($_GET['to'])          ? $_GET['to'] . ' 23:59:59'   : NULL;
        $institution  = is_valid($_GET['institution']) ? $_GET['institution']        : NULL;
        $page_index   = is_valid($_GET['page_index'])  ? $_GET['page_index']         : 0;
        $page_size    = is_valid($_GET['page_size'])   ? $_GET['page_size']          : 20;

        $response = searchStudies($id, $name, $accession, $modality, $from, $to, $institution, $page_index, $page_size);
        break;
    }
  }

 exit(json_encode($response));
 ?>
