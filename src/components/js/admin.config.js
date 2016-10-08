var ignoreInsts = [''];
var ignoreUsers = [''];
var ignoreMods = ['', 'OT', 'SR'];

var adminConfig = {
  instTableOptions: {
    "searching": false,
    "info": false,
    "ajax": {
      "url": "src/components/php/api/service.php?action=getalldynamicinsts",
      "dataSrc": function(json) {
        var data = [];
        var showButton;
        var name;

        for (var i = 0, ien = json.length; i < ien; i++) {
          if (ignoreInsts.includes(json[i].name)) continue;

          showButton = '<button class="table-option-button small" onclick="handelToggleVisibility(); return false;"><span class="glyphicon glyphicon-eye-'+ (json[i].visibility == 1 ? 'open' : 'close') + '" data-type="institution" data-id="' + json[i].id + '"></span></button>';
          name = '<span style="padding-top:5px;">' + fix_name(json[i].name) + '</span>';

          data.push({
            '0': showButton,
            '1': name
          });
        }
        return data;
      }
    },
    "bFilter": false,
    "bAutoWidth": false,
    "bInfo": true,
    "bSort": false,
    "bLengthChange": false,
    "sPaginationType": "full_numbers",
    "fnDrawCallback": function() {
      if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
        $('#inst-table_paginate.dataTables_paginate').css("display", "block");
        $('#inst-table_paginate.dataTables_length').css("display", "block");
        $('#inst-table_paginate.dataTables_filter').css("display", "block");
      } else {
        $('#inst-table_paginate.dataTables_paginate').css("display", "none");
        $('#inst-table_paginate.dataTables_length').css("display", "none");
        $('#inst-table_paginate.dataTables_filter').css("display", "none");
      }
    },
    "initComplete": function(settings, json) {
      var refreshInstButton = '<button class="btn" onclick="refreshInsts();">Refresh</button>';
      $('#inst-table_info').html(refreshInstButton);
    },
    "iDisplayLength": 5
  },
  modTableOptions: {
    "searching": false,
    "info": false,
    "ajax": {
      "url": "src/components/php/api/service.php?action=getalldynamicmods",
      "dataSrc": function(json) {
        var data = [];
        var showButton;
        var name;

        for (var i = 0, ien = json.length; i < ien; i++) {
          if (ignoreMods.includes(json[i].modality)) continue;
          showButton = '<button class="table-option-button small" onclick="handelToggleVisibility(); return false;"><span class="glyphicon glyphicon-eye-'+ (json[i].visibility == 1 ? 'open' : 'close') + '" data-type="modality" data-id="' + json[i].id + '"></span></button>';
          name = '<span style="padding-top:5px;">' + json[i].modality + '</span>';

          data.push({
            '0': showButton,
            '1': name,
            '2': 'Info'
              // '2':
          });
        }
        return data;
      }
    },
    "bFilter": false,
    "bAutoWidth": false,
    "bInfo": true,
    "bSort": false,
    "bLengthChange": false,
    "sPaginationType": "full_numbers",
    "fnDrawCallback": function() {
      if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
        $('#mod-table_paginate.dataTables_paginate').css("display", "block");
        $('#mod-table_paginate.dataTables_length').css("display", "block");
        $('#mod-table_paginate.dataTables_filter').css("display", "block");
      } else {
        $('#mod-table_paginate.dataTables_paginate').css("display", "none");
        $('#mod-table_paginate.dataTables_length').css("display", "none");
        $('#mod-table_paginate.dataTables_filter').css("display", "none");
      }
    },
    "initComplete": function(settings, json) {
      var refreshInstButton = '<button class="btn" onclick="refreshMods();">Refresh</button>';
      $('#mod-table_info').html(refreshInstButton);
    },
    "iDisplayLength": 5
  },
  userTableOption: {
    'searching': false,
    'info': false,
    'ajax': {
      'url': 'src/components/php/api/service.php?action=getallusers',
      'dataSrc': function(json) {
        var data = [];
        for (var i = 0, ien = json.length; i < ien; i++) {
          if (ignoreUsers.includes(json[i].username)) continue;
          data.push({
            '0': json[i].username,
            '1': json[i].email,
            '2': json[i].role,
            '3': '<button class="weasis-btn flat-btn edit-user" onclick="handelEditUser(); return false;" data-username="' + json[i].username + '" ><i class="glyphicon glyphicon-pencil"></i></button><button class="weasis-btn flat-btn delete-user"  onclick="handelDeleteUser(); return false;" data-username="' + json[i].username + '" ><i class="glyphicon glyphicon-trash"></i></button>'
          });
        }

        return data;
      }
    },
    "bFilter": false,
    "bAutoWidth": false,
    "bInfo": false,
    "bLengthChange": false,
    "sPaginationType": "full_numbers",
    "fnDrawCallback": function() {
      if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
        $('#users-table_paginate.dataTables_paginate').css("display", "block");
        $('#users-table_paginate.dataTables_length').css("display", "block");
        $('#users-table_paginate.dataTables_filter').css("display", "block");
      } else {
        $('#users-table_paginate.dataTables_paginate').css("display", "none");
        $('#users-table_paginate.dataTables_length').css("display", "none");
        $('#users-table_paginate.dataTables_filter').css("display", "none");
      }
    },
    "iDisplayLength": 5
  }
};
