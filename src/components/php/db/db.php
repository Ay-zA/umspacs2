<?php
static $char_set;
function connect($dbname)
{
    global $char_set;
    $servername = 'localhost';
    $username = 'root';
    $password = 'A1l2i3 !@#';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
        return;
    }
}

function getAllPatient()
{
    $conn = connect('pacsdb');
    $query = $conn->prepare('SELECT patient.pk, patient.pat_id , patient.pat_name, patient.pat_sex, study.num_series,
                          study.pk AS study_pk, study.mods_in_study, study.num_instances, study.study_iuid,
                          patient.pat_birthdate ,study.study_id, study.study_datetime, study.study_desc, study.study_status
                          FROM patient INNER JOIN study ON patient.pk = study.patient_fk ORDER BY study.study_datetime DESC;');
    $query->execute();
    $result = $query->fetchAll();

    return $result;
}

function searchByStudyId($studyId)
{
    $conn = connect('pacsdb');
    $query = $conn->prepare('SELECT patient.pk AS pat_pk, patient.pat_id, patient.pat_name, patient.pat_sex, study.pk AS study_pk,
                  study.study_id, study.study_datetime, study.study_desc, study.study_status
                  FROM patient INNER JOIN study ON patient.pk = study.patient_fk
                  WHERE  study.study_id = :study_id;');
    $query->bindParam(':study_id', $studyId);
    $query->execute();

    $result = $query->fetchAll();

    return $result;
}

function getStudyId($studyPk)
{
    $conn = connect('pacsdb');
    $query = $conn->prepare('SELECT study_iuid FROM study WHERE pk = :studyPk;');
    $query->bindParam(':studyPk', $studyPk);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getAllSeries($study_pk)
{
    $conn = connect('pacsdb');
    $query = $conn->prepare('SELECT series.pk, series.modality, series.body_part,
                                    series.num_instances, series.series_no, series.series_desc,
                                    series.study_fk, series.series_iuid
                           FROM series WHERE series.study_fk = :study_pk ORDER BY series.series_no;');
    $query->bindParam(':study_pk', $study_pk);
    $query->execute();
    $result = $query->fetchAll();

    return $result;
}

function getAllInstances($serie_pk)
{
    $conn = connect('pacsdb');
    $query = $conn->prepare('SELECT instance.sop_iuid, instance.sop_cuid
                           FROM instance WHERE series_fk = :serie_pk ORDER BY instance.sop_iuid DESC;');
    $query->bindParam(':serie_pk', $serie_pk);
    $query->execute();
    $result = $query->fetchAll();

    return $result;
}

function searchStudies($patient_id = null, $name = null, $modality = null, $from = null, $to = null, $institution = null, $page_index = 1, $page_size = 20)
{
    global $char_set;
    $inQuery = null;
    $modalities = null;

    $start_index = $page_index * $page_size;
    $start_index = (int)$start_index;
    $page_size = (int)$page_size;

    if (isset($modality)) {
      $modality = strtolower($modality);
      $modalities = explode('\\\\',$modality);
      $inQuery = implode(',', array_fill(0, count($modalities), '?'));
    }
    $conn = connect('pacsdb');

    $querySelect = 'SELECT
                patient.pk,
                patient.pat_id,
                patient.pat_name,
                patient.pat_sex,
                patient.pat_birthdate,
                study.num_series,
                study.pk AS study_pk,
                study.mods_in_study,
                study.num_instances,
                study.study_iuid,
                study.study_id,
                study.study_datetime,
                study.study_desc,
                study.study_status,
                series.institution
              FROM study
              LEFT JOIN patient ON patient.pk = study.patient_fk
              LEFT JOIN series ON series.study_fk = study.pk';

      $queryBase = ' WHERE 1 = 1';

      if (isset($patient_id)) {
          $patient_id = strtolower($patient_id);
          $queryBase .= ' AND LOWER(patient.pat_id) LIKE CONCAT (?,"%")';
      }
      if (isset($name)) {
          $name = strtolower($name);
          $queryBase .= ' AND LOWER(patient.pat_name) LIKE CONCAT ("%",?,"%")';
      }
      if (isset($inQuery)) {
          $queryBase .= ' AND LOWER(study.mods_in_study) IN(' . $inQuery . ')';
      }
      if (isset($from)) {
          $queryBase .= ' AND study.study_datetime >= ?';
      }
      if (isset($to)) {
          $queryBase .= ' AND study.study_datetime <= ?';
      }
      if (isset($institution)) {
          $queryBase .= ' AND LOWER(series.institution) LIKE CONCAT ("%",?,"%")';
      }

      $queryGroup = ' GROUP BY
              patient.pk,
              patient.pat_id,
              patient.pat_name,
              patient.pat_sex,
              patient.pat_birthdate,
              study.num_series,
              study_pk,
              study.mods_in_study,
              study.num_instances,
              study.study_iuid,
              study.study_id,
              study.study_datetime,
              study.study_desc,
              study.study_status';

    $queryOrder = ' ORDER BY study.study_datetime DESC';

    $query = $querySelect . $queryBase . $queryGroup . $queryOrder;
    $query = $conn->prepare($query);
    $i = 1;

    if (isset($patient_id)) {
        $query->bindValue($i, $patient_id);
        $i++;
    }

    if (isset($name)) {
        $query->bindValue($i, $name);
        $i++;
    }

    if (isset($modalities)) {
      foreach ($modalities as $k => $modality)
      {
        $query->bindValue($i, $modality);
        $i++;
      }
    }

    if (isset($from)) {
      $query->bindValue($i, $from);
      $i++;
    }

    if (isset($to)) {
      $query->bindValue($i, $to);
      $i++;
    }

    if (isset($institution)) {
      $institution = strtolower($institution);
      $query->bindValue($i, $institution);
      $i++;
    }

    $query->execute();
    $result = $query->fetchAll();
    $studyCount = sizeof($result);

    $serieCount = getSerieCount($result);
    $instanceCount = getInstanceCount($result);

    $result = array_slice($result, $start_index , $page_size);
    $result['studyCount'] = $studyCount;
    $result['serieCount'] = $serieCount;
    $result['instanceCount'] = $instanceCount;
    return $result;
}

function getSerieCount($data){
  $result = 0;
  foreach ($data as $key => $value) {
    $result += $value['num_series'];
  }
  return $result;
}

function getInstanceCount($data) {
  $result = 0;
  foreach ($data as $key => $value) {
    $result += $value['num_instances'];
  }

  return $result;
}

function getInstitutionName($study_pk){
    $conn = connect('pacsdb');
    $query = "SELECT series.institution FROM series WHERE series.study_fk = :study_pk ;";
    $query = $conn->prepare($query);

    $query->bindParam(':study_pk', $study_pk);

    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function getAllModalities($dynamic=false){
  if ($dynamic) {
    updateAllModalities();
  }
  $conn = connect('dicom');
  $query = "SELECT * FROM modalities";
  $query = $conn->prepare($query);

  $query->execute();
  $result = $query->fetchAll();
  return $result;
}

function getAllInstitutions($dynamic=false){
  if ($dynamic) {
    updateInstituations();
  }
  $conn = connect('dicom');
  $query = "SELECT * FROM institutions";
  $query = $conn->prepare($query);

  $query->execute();
  $result = $query->fetchAll();
  return $result;
}

function updateInstituations(){
  // Get All Dynamic Insts
  $conn = connect('pacsdb');
  $query = "SELECT DISTINCT series.institution FROM `series`;";
  $query = $conn->prepare($query);

  $query->execute();
  $allDynamicInsts = $query->fetchAll(PDO::FETCH_COLUMN, 0);

  // Get All Static Inst
  $conn = connect('dicom');
  $query = "SELECT `name` FROM `institutions`;";
  $query = $conn->prepare($query);

  $query->execute();
  $allStaticInsts = $query->fetchAll(PDO::FETCH_COLUMN, 0);

  // Check if exixts
  foreach ($allDynamicInsts as $key => $value) {
    $instName = $value;
    if(in_array($instName, $allStaticInsts)) continue;

    $query = "INSERT INTO `institutions` (`name`) VALUES ('$instName');";

    $query = $conn->prepare($query);
    $query->execute();
  }
}

function updateAllModalities(){
  // Get All Dynamic Modalities
  $conn = connect('pacsdb');
  $query = "SELECT DISTINCT study.mods_in_study FROM `study`;";
  $query = $conn->prepare($query);

  $query->execute();
  $allDynamicMods = $query->fetchAll(PDO::FETCH_COLUMN, 0);
  // var_dump($allDynamicMods);
  $allMods = [];
  foreach ($allDynamicMods as $key => $value) {
    $values = explode( '\\',$value);
    foreach ($values as $key2 => $value2) {
      if (!in_array($value2, $allMods)) {
        $allMods[] = $value2;
      }
    }
  }
  $allDynamicMods = $allMods;

  // Get All Static Inst
  $conn = connect('dicom');
  $query = "SELECT `modality` FROM `modalities`;";
  $query = $conn->prepare($query);

  $query->execute();
  $allStaticMods = $query->fetchAll(PDO::FETCH_COLUMN, 0);

  // Check if exixts
  foreach ($allDynamicMods as $key => $value) {
    $modName = $value;
    if(in_array($modName, $allStaticMods)) continue;

    $query = "INSERT INTO `modalities` (`modality`) VALUES ('$modName');";

    $query = $conn->prepare($query);
    $query->execute();
  }
}

function getAllUsers()
{
  $conn = connect('dicom');
  $query = "SELECT username, role, email FROM users";
  $query = $conn->prepare($query);

  $query->execute();
  $result = $query->fetchAll();
  return $result;
}
?>
