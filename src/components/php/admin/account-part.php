<hr />
<form class="form-horizontal" action="#" method="post">
  <fieldset>
    <!-- Form Name -->
    <legend>Change Password</legend>
    <!-- Success message -->
    <div class="alert alert-success col-md-7" role="alert" id="success_message">Your information has been updated. <i class="glyphicon glyphicon-thumbs-up"></i></div>
    <div class="clearfix"></div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-2 control-label">Username</label>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input name="usernname" readonly placeholder="Username" class="form-control" type="text">
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
          <input name="repeat_password" placeholder="Repeat Password" class="form-control" type="text">
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
