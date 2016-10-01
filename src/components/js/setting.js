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

function handelDeleteUser() {
  var _this = event.target;
  var $user = $(_this).attr('data-username');
  deleteUser($user, updateTable);

  function updateTable(data) {
    if (data === 406) {
      alert('You can\'t remove yourself');
      return;
    }
    $(_this).closest('tr').remove();
  }
}

function deleteUser($user, cb) {
  var url = 'src/components/php/api/service.php?action=deleteuser&username=' + $user;
  console.log(url);
  $.getJSON(url, cb);
}
var selectedUser = {};

function handelEditUser() {
  var _this = event.target;
  var $row = $(_this).closest('tr');
  selectedUser.username = $row.children('td:nth-child(1)').text();
  selectedUser.email = $row.children('td:nth-child(2)').text();
  selectedUser.role = $row.children('td:nth-child(3)').text();
  $('#edit-user-modal').modal('show');
  console.log(selectedUser);
  $editUserUsername.val(selectedUser.username);
  $editUserEmail.val(selectedUser.email);
  $editUserPassword.val('');

  if (selectedUser.role === 'admin')
    $($editUserRole[1]).attr('checked', 'checked');
  else
    $($editUserRole[0]).attr('checked', 'checked');
}

function onUserUpdated(data) {
  //TODO:40 Responde to other data
  console.log(data);
  switch (data) {
    case 407:
      showEditMessage('Invalid Email Address.', 0);
      break;
    case 406:
      $editUserModal.modal('hide');
      showEditMessage('Nothing Changed.', 0);
      break;
    case 200:
      $editUserModal.modal('hide');
      showEditMessage('User successfuly Updated', 1);
      break;
    default:
  }

}
var $editUserMessage = $('#edit-user-message');

function showEditMessage(message, success) {
  if (success) {
    $editUserMessage.removeClass('alert-warning');
    $editUserMessage.addClass('alert-success');
    $editUserMessage.text(message);
    $editUserMessage.show();
    hideMessageAfter($editUserMessage, 3000);
  } else {
    $editUserMessage.removeClass('alert-success');
    $editUserMessage.addClass('alert-warning');
    $editUserMessage.text(message);
    $editUserMessage.show();
    hideMessageAfter($editUserMessage, 3000);
  }
}


function handelEditUserSave() {
  var userInfo = {};
  userInfo.username = selectedUser.username;
  userInfo.password = $editUserPassword.val();
  userInfo.email = $editUserEmail.val();
  //TODO:10 CHECKED AND ROLE
  //TODO:20 How determine checked ?
  userInfo.role = $('#edit-user-modal input[name="role"]').val();

  updateUser(userInfo, onUserUpdated);
  //TODO:50 Update Data-Table
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
