<script>
var oTable = jQuery('#stok').dataTable({
                                      "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": 'http://202.46.1.83/simpus/simpus-bogortimur/datatable_master/obat',
                                        "bJQueryUI": false,
                                        "sPaginationType": "full_numbers",
                                        //"aaSortingFixed": [[0,'asc']],
                                        "fnDrawCallback": function(oSettings) {
                                            jQuery.uniform.update();
                                        },
                                        "iDisplayStart ": 10,
                                        "oLanguage": {
                                            "sProcessing": "<center><img src='http://202.46.1.83/simpus-beta/assets/img/loaders/loader_blue.gif' /></center>"
                                        },
                                        "fnInitComplete": function () {
                                            //oTable.fnAdjustColumnSizing();
                                        },
                                        'fnServerData': function (sSource, aoData, fnCallback) {
                                            jQuery.ajax
                                            ({
                                                'dataType': 'json',
                                                'type': 'POST',
                                                'url': sSource,
                                                'data': aoData,
                                                'success': fnCallback
                                            });
                                        }
                                    });
</script>

<table id="stok" class="table table-bordered">
            <thead>
            <tr>
            <th>Kode Obat</th><th>Nama Obat</th><th>Stok</th></tr>
            </thead>
</table>