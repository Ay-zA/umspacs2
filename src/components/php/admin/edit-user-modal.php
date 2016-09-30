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
        <form class="form-flex">

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
                  <input id="edit-user-password" type="text" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="input-group">
                  <span class="input-group-addon">Confirm</span>
                  <input id="edit-user-confirm" type="text" class="form-control" placeholder="Confirm">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon">Email</span>
                  <input id="edit-user-email" type="text" class="form-control" placeholder="Email">
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <label class="col-md-2 control-label">Role</label>
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

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="edit-user-save" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- /.modal -->
