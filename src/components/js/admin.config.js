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
        for (var i = 0, ien = json.length; i < ien; i++) {
          if (ignoreInsts.includes(json[i].name)) continue;
          data.push({
            '0': fix_name(json[i].name),
            '1': 'Remove'
          });
        }
        return data;
      }
    },
    "bFilter": false,
    "bAutoWidth": false,
    "bInfo": true,
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
        for (var i = 0, ien = json.length; i < ien; i++) {
          if (ignoreMods.includes(json[i].modality)) continue;
          data.push({
            '0': json[i].modality,
            '1': 'Info',
            '2': 'Remove'
          });
        }
        return data;
      }
    },
    "bFilter": false,
    "bAutoWidth": false,
    "bInfo": true,
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
