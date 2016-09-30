$(function() {
  $('#admin-tabs #account').on('click', changeAdminTab);
  $('#admin-tabs #inst-mod-info').on('click', changeAdminTab);
  $('#admin-tabs #user-manager').on('click', changeAdminTab);
  $('.delete-user').on('click', handelDeleteUser);
  $('.edit-user').on('click', handelEditUser);
  $('#edit-user-modal #edit-user-save').on('click', handelEditUserSave);
});
