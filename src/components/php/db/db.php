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

function searchStudies($patient_id = null, $name = null, $modality = null, $from = null, $to = null, $institution = null)
{
    global $char_set;
    $conn = connect('pacsdb');

      $query = 'SELECT patient.pk, patient.pat_id , patient.pat_name, patient.pat_sex, study.num_series,
                            study.pk AS study_pk, study.mods_in_study, study.num_instances, study.study_iuid,
                            patient.pat_birthdate ,study.study_id, study.study_datetime, study.study_desc, study.study_status
                            FROM patient INNER JOIN study ON patient.pk = study.patient_fk WHERE 1 = 1';

    $query = 'SELECT
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
              LEFT JOIN series ON series.study_fk = study.pk
              WHERE 1 = 1';

    if (isset($patient_id)) {
        $patient_id = strtolower($patient_id);
        $query = $query.' AND LOWER(patient.pat_id) LIKE CONCAT (:id,"%")';
    }
    if (isset($name)) {
        $name = strtolower($name);
        $query = $query.' AND LOWER(patient.pat_name) LIKE CONCAT ("%",:name,"%")';
    }
    if (isset($modality)) {
        $modality = strtolower($modality);
        $query = $query.' AND LOWER(study.mods_in_study) LIKE CONCAT ("%",:modality,"%")';
    }
    if (isset($from)) {
        $query = $query.' AND study.study_datetime >= :from';
    }
    if (isset($to)) {
        $query = $query.' AND study.study_datetime <= :to';
    }
    if (isset($institution)) {
        $query = $query.' AND LOWER(series.institution) LIKE CONCAT ("%",:institution,"%")';
    }

    $query = $query.' GROUP BY
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
                      study.study_status
                    ORDER BY study.study_datetime DESC;';

    $query = $conn->prepare($query);
    if (isset($patient_id)) {
        $query->bindParam(':id', $patient_id);
    }
    if (isset($name)) {
        $query->bindParam(':name', $name);
    }
    if (isset($modality)) {
        $query->bindParam(':modality', $modality);
    }
    if (isset($from)) {
        $query->bindParam(':from', $from);
    }
    if (isset($to)) {
        $query->bindParam(':to', $to);
    }
    if (isset($institution)) {
          $institution = strtolower($institution);
          $query->bindParam(':institution', $institution);
    }
    // var_dump($query);
    $query->execute();
    $result = $query->fetchAll();

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

?>
