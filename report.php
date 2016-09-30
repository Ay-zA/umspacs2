<?php
  require_once 'src/components/php/db/db.php';
  require_once 'src/components/php/db/accesscontrol.php';
  require_once 'src/components/php/admin/admin.php';

  if (!is_session_exist()) {
      header('location: index.php');
  }

  $studyId = $_GET['study_id'];
  $reportInfo = getReportInfo($studyId);
  function printBodyParts($reportInfo){
  foreach ($reportInfo['body_parts'] as $key => $bodyPart) {
      echo "$bodyPart\\";
    }
  }
  // var_dump($reportInfo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Report</title>

  <link rel="shortcut icon" type="image/x-icon" href="src/images/favicon.ico">
  <link href="bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
  <link href="bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
  <link href="node_modules/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
  <link href="src/css/style.css" rel="stylesheet">
  <link href="src/css/report.css" rel="stylesheet">
</head>

<body>
  <?php include('src/components/php/header-admin.php'); ?>
  <div class="flex-container">
    <div id="template-section">
      <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingTwo">
            <h3 class="panel-title tabs-header">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              Templates
            </a>
          </h3>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#">Template 1</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div id="report-section">

      <form class="form-flex">
        <legend>Patient Info</legend>

        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Patient Id</span>
                <input type="text" class="form-control" placeholder="Patient Id" value="<?php echo $reportInfo['pat_id']; ?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Name</span>
                <input type="text" class="form-control" placeholder="Name" value="<?php echo $reportInfo['pat_name']; ?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">DOB</span>
                <input type="text" class="form-control" placeholder="DOB" value="<?php echo $reportInfo['pat_birthdate'];?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Age</span>
                <input type="text" class="form-control" placeholder="Age" value="<?php echo get_age($reportInfo['pat_birthdate']);?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Sex</span>
                <input type="text" class="form-control" placeholder="Sex" value="<?php echo $reportInfo['pat_sex'];?>">
              </div>
            </div>
          </div>
        </div>

        <legend>Exam Info</legend>

        <div class="container">
          <div class="row">

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Modality</span>
                <input type="text" class="form-control" placeholder="Modality" value="<?php echo $reportInfo['mods_in_study'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Body Part</span>
                <input type="text" class="form-control" placeholder="Body Part" value="<?php printBodyParts($reportInfo);?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Study Date</span>
                <input type="text" class="form-control" placeholder="Study Date" value="<?php echo $reportInfo['study_datetime'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Accession No</span>
                <input type="text" class="form-control" placeholder="Accession No" value="<?php echo $reportInfo['accession_no'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Study Discription</span>
                <input type="text" class="form-control" placeholder="Study Discription" value="<?php echo $reportInfo['study_desc'];?>">
              </div>
            </div>

          </div>
        </div>


        <legend>Findings</legend>
        <div class="input">
          <textarea name="name" rows="8"></textarea>
        </div>
        <legend>Impression</legend>
        <div class="input">
          <textarea name="name" rows="8"></textarea>
        </div>
        <legend>Comments</legend>
        <div class="input">
          <textarea name="name" rows="8"></textarea>
        </div>

        <legend>Report Info</legend>
        <div class="input-group inline">
          <span class="input-group-addon">Doctor Id</span>
          <input type="text" class="form-control" placeholder="Doctor Id">
        </div>

        <div class="input-group inline">
          <span class="input-group-addon">Doctor Name</span>
          <input type="text" class="form-control" placeholder="Doctor Name">
        </div>

        <div class="input-group inline">
          <span class="input-group-addon">Report Date</span>
          <input type="text" class="form-control" placeholder="Report Date">
        </div>

      </form>
    </div>
  </div>
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
