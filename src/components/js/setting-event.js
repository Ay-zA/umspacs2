$(function() {
  $('#admin-tabs #account').on('click', changeAdminTab);
  $('#admin-tabs #inst-mod-info').on('click', changeAdminTab);
  $('#admin-tabs #user-manager').on('click', changeAdminTab);
  $('#edit-user-modal #edit-user-save').on('click', handelEditUserSave);
});
