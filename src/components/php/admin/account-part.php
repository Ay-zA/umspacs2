<hr />
<form id="account-form" class="form-horizontal" action="src/components/php/admin/updateuser.php" method="post">
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
    <!-- Text input-->

    <div class="form-group">
      <label class="col-md-2 control-label">Password</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input name="password" placeholder="Password" class="form-control" type="password">
        </div>
      </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">Confirm Passowrd</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input name="repeat_password" placeholder="Repeat Password" class="form-control" type="password">
        </div>
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
