function changeAdminTab(e) {
  var id = e.target.id;
  changeAdminTabById(id, true);
}

function changeAdminTabById(id, messages) {
  id = '#' + id;
  $('#admin-tabs li').each(function() {
    $(this).removeClass('active');
  });
  $(id).parent('li').addClass('active');

  $("div[id$=panel]").each(function() {
    $(this).hide();
  });

  var panelId = id + '-panel';
  $(panelId).show();
  clearInputs();
  if (messages)
    removeMessages();
}

function removeMessages() {
  $('.alert').each(function() {
    $(this).hide();
  });
}

function clearInputs() {
  $('input[type="text"]').val("");
  $('input[type="password"]').val("");
  $('#account-form input[name="username"]').val(username);
}

function handelDeleteUser(e) {
  var _this = this;
  var $user = $(this).attr('data-username');
  deleteUser($user, updateTable);

  function updateTable(data) {
    console.log(data);
    if (data == 406) {
      alert('You can\'t remove yourself');
      return;
    }
    $(_this).closest('tr').remove();
  }
}

function deleteUser($user, cb) {
  var url = 'src/components/php/api/service.php?action=deleteuser&username=' + $user;
  $.getJSON(url, cb);
}
var selectedUser = {};

function handelEditUser(e) {
  var $row = $(this).closest('tr');
  selectedUser.username = $row.children('td[data-type="username"]').text();
  selectedUser.email = $row.children('td[data-type="email"]').text();
  selectedUser.role = $row.children('td[data-type="role"]').text();
  $('#edit-user-modal').modal('show');
  $editUserUsername.val(selectedUser.username);
  if (selectedUser.role === 'admin')
    $($editUserRole[1]).attr('checked', 'checked');
  else
    $($editUserRole[0]).attr('checked', 'checked');
}

function onUserUpdated(data) {
  //TODO: Responde to other data
  console.log(data);
  if(data == 200){
    $editUserModal.modal('hide');
    showEditMessage('User successfuly Updated',1);
  }
}
var $editUserMessage = $('#edit-user-message');
function showEditMessage(message, success) {
  $editUserMessage.text(message);
  console.log($editUserMessage);
  $editUserMessage.show();
  hideMessageAfter($editUserMessage, 3000);
}


function handelEditUserSave() {
  var userInfo = {};
  userInfo.username = selectedUser.username;
  userInfo.password = $editUserPassword.val();
  userInfo.email = $editUserEmail.val();
  //TODO: CHECKED AND ROLE
  //TODO: How determine checked ?
  userInfo.role = $('#edit-user-modal input[name="role"]').val();

  updateUser(userInfo,onUserUpdated);

}

function updateUser(userInfo, cb) {
  var url = 'src/components/php/api/service.php?action=updateuser' +
    '&username=' + userInfo.username +
    '&password=' + userInfo.password +
    '&email=' + userInfo.email +
    '&role=' + userInfo.role;
    console.log(url);
  $.getJSON(url, cb);
}
