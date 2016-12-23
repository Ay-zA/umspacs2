<?php
  require_once 'src/components/php/db/common.php';
  require_once 'src/components/php/db/db.php';
  require_once 'src/components/php/db/accesscontrol.php';
  require_once 'src/components/php/admin/admin.php';

  if (!is_session_exist() || !isset($_GET['study_id']) ) {
      header('location: index.php');
  }

  $studyId = $_GET['study_id'];
  $existed = false;
  if(isReportExistFor($studyId)) {
    $existedReport = getReportInfo($studyId);
    $existed = true;
  }
  $studyInfo = getStudyInfoForReport($studyId);
  function printBodyParts($studyInfo){
  foreach ($studyInfo['body_parts'] as $key => $bodyPart) {
      echo "$bodyPart\\";
    }
  }

  // TODO:10 Editor component
  // TODO:30 Template
  // TODO:0 Attach file
  // TODO:20 Print
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

  <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="bower_components/froala-wysiwyg-editor/css/froala_editor.min.css" rel="stylesheet">
  <link href="bower_components/froala-wysiwyg-editor/css/froala_style.min.css" rel="stylesheet">
  <link href="node_modules/codemirror/lib/codemirror.css" rel="stylesheet">

  <link rel="stylesheet" href="bower_components/froala-wysiwyg-editor/css/plugins/char_counter.css">
  <link rel="stylesheet" href="bower_components/froala-wysiwyg-editor/css/plugins/file.css">
  <link rel="stylesheet" href="bower_components/froala-wysiwyg-editor/css/plugins/fullscreen.css">
  <link rel="stylesheet" href="bower_components/froala-wysiwyg-editor/css/plugins/line_breaker.css">

  <link href="node_modules/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
  <link href="src/css/style.css" rel="stylesheet">
  <link href="src/css/report.css" rel="stylesheet">
</head>

<body>
  <?php include('src/components/php/header-report.php'); ?>
  <div class="flex-container">
    <div id="template-section">
      <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="headingOne">
            <h3 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">Global Templates</a>
            </h3>
          </div>
          <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#">Global Template 1</a></li>
              <li><a href="#">Global Template 2</a></li>
            </ul>
          </div>
          <div class="panel-heading" role="tab" id="headingTwo">
            <h3 class="panel-title">
              <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsGlobal" aria-expanded="true" aria-controls="collapsGlobal">My Templates</a>
            </h3>
          </div>
          <div id="collapsGlobal" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <ul class="nav nav-pills nav-stacked">
              <li><a href="#">My Template 1</a></li>
              <li><a href="#">My Template 2</a></li>
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
                <input id="patient-id" type="text" class="form-control" placeholder="Patient Id" readonly value="<?php echo $studyInfo['pat_id']; ?>" data-studyPk="<?php echo $studyId; ?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Name</span>
                <input id="patient-name" type="text" class="form-control" placeholder="Name" value="<?php  echo ($existed ? $existedReport['farsi_name'] : $studyInfo['pat_name']); ?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">DOB</span>
                <input id="patient-dob" type="text" class="form-control" placeholder="DOB" readonly value="<?php echo $studyInfo['pat_birthdate'];?>">
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Age</span>
                <input id="patient-age" type="text" class="form-control" placeholder="Age" readonly>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Sex</span>
                <input id="patient-sex" type="text" class="form-control" placeholder="Sex" readonly value="<?php echo $studyInfo['pat_sex'];?>">
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
                <input id="study-mod" type="text" class="form-control" placeholder="Modality" readonly value="<?php echo $studyInfo['mods_in_study'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Body Part</span>
                <input id="study-part" type="text" class="form-control" placeholder="Body Part" readonly value="<?php printBodyParts($studyInfo);?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Study Date</span>
                <input id="study-datetime" type="text" class="form-control" placeholder="Study Date" readonly value="<?php echo $studyInfo['study_datetime'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Accession No</span>
                <input type="text" class="form-control" placeholder="Accession No" readonly value="<?php echo $studyInfo['accession_no'];?>">
              </div>
            </div>

            <div class="col-lg-4 col-md-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon">Study Description</span>
                <input id="study-desc" type="text" class="form-control" placeholder="Study Description" readonly value="<?php echo $studyInfo['study_desc'];?>">
              </div>
            </div>

          </div>
        </div>


        <legend>Findings</legend>
        <div class="input">
          <textarea id="findings" name="name" rows="8"><?php if($existed) echo $existedReport['findings'];?></textarea>
        </div>
        <legend>Impression</legend>
        <div class="input">
          <textarea id="impression" name="name" rows="8"><?php if($existed) echo $existedReport['impression'];?></textarea>
        </div>
        <legend>Comments</legend>
        <div class="input">
          <textarea id="comments" name="name" rows="8"><?php if($existed) echo $existedReport['comments'];?></textarea>
        </div>

        <legend>Report Info</legend>

        <div class="input-group inline">
          <span class="input-group-addon">Doctor Name</span>
          <input id="doctor-name" type="text" class="form-control" placeholder="Doctor Name" value="<?php if($existed) echo $existedReport['dr_name']; ?>">
        </div>

        <div class="input-group inline">
          <span class="input-group-addon">Report Date</span>
          <input id="report-date" type="text" class="form-control" placeholder="Report Date" value="<?php if($existed) echo $existedReport['report_date']; ?>">
        </div>

        <div class="input-group inline">
          <input id="submit-report" type="button" class="btn btn-block" value="Submit">
        </div>
      </form>
    </div>
  </div>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/codemirror/lib/codemirror.js"></script>
  <script src="bower_components/froala-wysiwyg-editor/js/froala_editor.min.js"></script>
  <script src="node_modules/persian-date/dist/0.1.8b/persian-date-0.1.8b.min.js"></script>

  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="bower_components/froala-wysiwyg-editor/js/plugins/save.min.js"></script>




  <script>
    $(function() {
      var changeDirection = function (dir, align) {
        this.selection.save();
        var elements = this.selection.blocks();
        for (var i = 0; i < elements.length; i++) {
          var element = elements[i];
          if (element != this.$el.get(0)) {
           $(element)
             .css('direction', dir)
             .css('text-align', align);
          }
        }
        this.selection.restore();
      }

      $.FroalaEditor.DefineIcon('rightToLeft', {NAME: 'caret-left'});
      $.FroalaEditor.RegisterCommand('rightToLeft', {
        title: 'RTL',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {
          changeDirection.apply(this, ['rtl', 'right']);
        }
      });

      $.FroalaEditor.DefineIcon('leftToRight', {NAME: 'caret-right'});
      $.FroalaEditor.RegisterCommand('leftToRight', {
        title: 'LTR',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {
          changeDirection.apply(this, ['ltr', 'left']);
        }
      })

    });
  </script>


  <script type="text/javascript">
    $(function () {
      initForm();
      $("#findings").froalaEditor({toolbarButtons: ['undo', 'redo' , '|' , 'bold', 'italic', 'underline', 'strikeThrough', '|', 'leftToRight', 'rightToLeft', '|', 'formatUL', 'outdent', 'indent', '|', 'insertFile', 'fullscreen','selectAll'],
            placeholderText: 'Findings...'});
      $("#impression").froalaEditor({toolbarButtons: 	['undo', 'redo' , '|' , 'bold', 'italic', 'underline', 'strikeThrough', '|', 'leftToRight', 'rightToLeft', '|', 'formatUL', 'outdent', 'indent', '|', 'insertFile', 'fullscreen','selectAll'],
             placeholderText: 'impression...'});
      $("#comments").froalaEditor({toolbarButtons: ['undo', 'redo' , '|' , 'bold', 'italic', 'underline', 'strikeThrough', '|', 'leftToRight', 'rightToLeft', '|', 'formatUL', 'outdent', 'indent', '|', 'insertFile', 'fullscreen','selectAll'],
             placeholderText: 'Comments...',});

       $('textarea').on('froalaEditor.focus', function (e, editor) {
         var target = $(e.target);
         target.closest('.input').addClass('active');
       });

       $('textarea').on('froalaEditor.blur', function (e, editor) {
         var target = $(e.target);
         target.closest('.input').removeClass('active');
       });

      validateInputs();
    })
  </script>
  <script src="src/js/common.js"></script>
  <script src="src/components/js/report.js"></script>

</body>

</html>
