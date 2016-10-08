<div class="modal " id="edit-user-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title">Edit User</h4>
      </div>

      <div class="modal-body">
        <form id="edit-user-form" class="form-flex">

          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon">Username</span>
                  <input id="edit-user-username" type="text" class="form-control" placeholder="Username" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon">Password</span>
                  <input id="edit-user-password" type="password" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon">Confirm</span>
                  <input id="edit-user-confirm" type="password" data-match="#edit-user-password" data-match-error="Passwords don't match" class="form-control" placeholder="Confirm">
                </div>
                <div class="help-block with-errors"></div>
                </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon">Email</span>
                  <input id="edit-user-email" type="email" class="form-control" placeholder="Email">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-2 radio-label">Role</label>
              <div class="col-xs-10">
                <div class="radio-inline">
                  <label><input type="radio" name="role" id="edit-user-viewer" value="viewer">Viewer</label>
                </div>
                <div class="radio-inline">
                  <label><input type="radio" name="role" id="edit-user-admin" value="admin">Admin</label>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="edit-user-save" type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>
  $('#edit-user-form').on('submit', function (e) {
    e.preventDefault();
  });
  $editFormValidator = $('#edit-user-form').validator();
</script>


<!-- /.modal -->
