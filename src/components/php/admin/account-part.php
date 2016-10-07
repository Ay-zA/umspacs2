<form id="account-form" class="form-horizontal form-flex" data-toggle="validator" action="src/components/php/admin/updateuser.php" method="post" style="margin-top: 2em;">
  <fieldset>
    <!-- Form Name -->
    <legend>Change Password</legend>
    <!-- Success message -->
    <?php if(isset($_SESSION['user_success'])): ?>
      <div class="alert alert-success col-md-12" role="alert" id="user_success_message"><?php echo $_SESSION['user_success'] ?></div>
      <div class="clearfix"></div>
      <?php unset($_SESSION['user_success']); ?>
    <?php endif ?>

    <?php if(isset($_SESSION['user_error'])): ?>
      <div class="alert alert-danger col-md-12" role="alert" id="user_error_message"><?php echo $_SESSION['user_error'] ?></div>
      <div class="clearfix"></div>
      <?php unset($_SESSION['user_error']); ?>
    <?php endif ?>


    <div class="form-group">
      <div class="col-xs-12">
        <div class="input-group">
          <span class="input-group-addon">Username</span>
          <input name="username" readonly placeholder="Username" class="form-control" type="text" value="<?php echo $_SESSION['dicom_username']; ?>">
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-xs-6">
        <div class="input-group">
            <span class="input-group-addon">Password</span>
            <input id="account-password" name="password" placeholder="Password" class="form-control"  type="password" required>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="input-group">
          <span class="input-group-addon">Confirm</span>
          <input name="repeat_password" data-match="#account-password" data-match-error="Passwords don't match" placeholder="Confirm" required class="form-control" type="password">
        </div>
        <div class="help-block with-errors" style="margin-bottom:0;"></div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-xs-12">
        <div class="input-group">
          <span class="input-group-addon">Email</span>
          <input name="email" placeholder="E-Mail Address" class="form-control" type="text">
        </div>
      </div>
    </div>

    <!-- Button -->
    <div class="form-group">
      <div class="col-md-12">
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
