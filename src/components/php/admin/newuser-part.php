<h3>Create account:</h3>
<hr/>
<form id="newuser-form" class="form-horizontal" data-toggle="validator" action="src/components/php/admin/createuser.php" method="post" autocomplete="off">
  <fieldset>
    <!-- Success message -->
  <?php if(isset($_SESSION['newuser_success'])): ?>
    <div class="alert alert-success col-md-12" role="alert" id="newuser_success_message"><?php echo $_SESSION['newuser_success'] ?> <i class="glyphicon glyphicon-thumbs-up"></i></div>
    <div class="clearfix"></div>
    <?php unset($_SESSION['newuser_success']); ?>
  <?php endif ?>

  <?php if(isset($_SESSION['newuser_error'])): ?>
    <div class="alert alert-danger col-md-12" role="alert" id="newuser_error_message"><?php echo $_SESSION['newuser_error'] ?> <i class="glyphicon glyphicon-thumbs-up"></i></div>
    <div class="clearfix"></div>
    <?php unset($_SESSION['newuser_error']); ?>
  <?php endif ?>

    <!-- Username-->
    <div class="form-group">
      <label class="col-md-2 control-label">Username</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input name="newuser_username" placeholder="Username" class="form-control" type="text" autocomplete="dontfillitdearchrome2" required >
        </div>
      </div>
    </div>
    <!-- Text input-->

    <!-- Passwords -->
    <div class="form-group">
      <label class="col-md-2 control-label">Password</label>
      <div class="col-md-5 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input id="newuser_password" name="newuser_password" placeholder="Password" class="form-control"  type="password" required>
        </div>
        <div class="help-block with-errors"></div>
      </div>

      <div class="col-md-5 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input name="newuser_confirm" data-match="#newuser_password" data-match-error="Passwords don't match" placeholder="Confirm" required class="form-control" type="password">
      </div>
      <div class="help-block with-errors"></div>
      </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">E-mail</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
          <input name="newuser_email" placeholder="E-Mail Address" class="form-control" type="email">
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-2 control-label">Role</label>
      <div class="col-md-10 ">
        <label class="radio-inline"><input type="radio" name="newuser_role" value="viewer" checked required>Viewer</label>
        <label class="radio-inline"><input type="radio" name="newuser_role" value="admin" required>Admin</label>
      </div>
    </div>

    <!-- Button -->
    <div class="form-group">
      <label class="col-md-8 control-label"></label>
      <div class="col-md-4">
        <button type="submit" name="newuser" class="btn btn-block btn-warning">Create <span class="glyphicon glyphicon-send"></span></button>
      </div>
    </div>

  </fieldset>
</form>
<script type="text/javascript">
  $('#newuser-form').validator();

  $('input[name="newuser_password"]').on('blur', function (e) {
    if($(this).val() === ''){
      console.log('e');
      resetValidator('#newuser-form');
    }
  });
  $('input[name="newuser_username"]').on('blur', function (e) {
    if($(this).val() === ''){
      resetValidator('#newuser-form');
    }
  });
</script>
