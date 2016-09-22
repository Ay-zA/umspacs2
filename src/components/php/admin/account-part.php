<hr />
<form id="account-form" class="form-horizontal" data-toggle="validator" action="src/components/php/admin/updateuser.php" method="post">
  <fieldset>
    <!-- Form Name -->
    <legend>Change Password</legend>
    <!-- Success message -->
    <?php if(isset($_SESSION['user_success'])): ?>
      <div class="alert alert-success col-md-12" role="alert" id="user_success_message"><?php echo $_SESSION['user_success'] ?> <i class="glyphicon glyphicon-thumbs-up"></i></div>
      <div class="clearfix"></div>
      <?php unset($_SESSION['user_success']); ?>
    <?php endif ?>

    <?php if(isset($_SESSION['user_error'])): ?>
      <div class="alert alert-danger col-md-12" role="alert" id="user_error_message"><?php echo $_SESSION['user_error'] ?> <i class="glyphicon glyphicon-thumbs-up"></i></div>
      <div class="clearfix"></div>
      <?php unset($_SESSION['user_error']); ?>
    <?php endif ?>


    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">Username</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input name="username" readonly placeholder="Username" class="form-control" type="text" value="<?php echo $_SESSION['dicom_username']; ?>">
        </div>
      </div>
    </div>

    <!-- Passwords -->
    <div class="form-group">
      <label class="col-md-2 control-label">Password</label>
      <div class="col-md-5 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="account-password" name="password" placeholder="Password" class="form-control"  type="password" required>
        </div>
        <div class="help-block with-errors"></div>
      </div>

      <div class="col-md-5 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input name="repeat_password" data-match="#account-password" data-match-error="Passwords don't match" placeholder="Confirm" required class="form-control" type="password">
      </div>
      <div class="help-block with-errors"></div>
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">Email</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
          <input name="email" placeholder="E-Mail Address" class="form-control" type="text">
        </div>
      </div>
    </div>

    <!-- Button -->
    <div class="form-group">
      <label class="col-md-2 control-label"></label>
      <div class="col-md-10">
        <button type="submit" class="btn btn-block btn-warning">Update <span class="glyphicon glyphicon-send"></span></button>
      </div>
    </div>

  </fieldset>
</form>
<script src="bower_components/bootstrap-validator/dist/validator.min.js" charset="utf-8"></script>
<script type="text/javascript">
  $('#account-form').validator();

  function resetValidator(el) {
    $(el).validator('destroy');
    $(el).validator();
  }
  $('input[name="password"]').on('blur', function (e) {
    if($(this).val() === ''){
      resetValidator('#account-form');
    }
  });
  $('input[name="repeat_password"]').on('blur', function (e) {
    if($(this).val() === ''){
      resetValidator('#account-form');
    }
  });
</script>
