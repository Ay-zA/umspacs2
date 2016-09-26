var ignoreInsts = [''];
var ignoreMods = ['','OT','SR'];

var adminConfig = {
  instTableOptions: {
    "searching": false,
    "info": false,
    "ajax": {
      "url": "src/components/php/api/service.php?action=getalldynamicinsts",
      "dataSrc": function ( json ) {
        var data = [];
        for ( var i=0, ien=json.length ; i<ien ; i++ ) {
          if(ignoreInsts.includes(json[i].name)) continue;
          data.push({'0': fix_name(json[i].name), '1': 'Remove'});
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
        $('#inst-table_paginate.dataTables_paginate').css("display", "block");
        $('#inst-table_paginate.dataTables_length').css("display", "block");
        $('#inst-table_paginate.dataTables_filter').css("display", "block");
      } else {
        $('#inst-table_paginate.dataTables_paginate').css("display", "none");
        $('#inst-table_paginate.dataTables_length').css("display", "none");
        $('#inst-table_paginate.dataTables_filter').css("display", "none");
      }
    },
    "iDisplayLength": 5
  },
  modTableOptions: {
      "searching": false,
      "info": false,
      "ajax": {
        "url": "src/components/php/api/service.php?action=getalldynamicmods",
        "dataSrc": function ( json ) {
          var data = [];
          for ( var i=0, ien=json.length ; i<ien ; i++ ) {
            if(ignoreMods.includes(json[i].modality)) continue;
            data.push({'0': json[i].modality, '1': 'Info', '2': 'Remove'});
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
          $('#mod-table_paginate.dataTables_paginate').css("display", "block");
          $('#mod-table_paginate.dataTables_length').css("display", "block");
          $('#mod-table_paginate.dataTables_filter').css("display", "block");
        } else {
          $('#mod-table_paginate.dataTables_paginate').css("display", "none");
          $('#mod-table_paginate.dataTables_length').css("display", "none");
          $('#mod-table_paginate.dataTables_filter').css("display", "none");
        }
      },
      "iDisplayLength": 5
  }
};
