<?php if($this->session->flashdata('flash_message') != ""):?>
    <script>
        jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
    </script>
<?php endif;?>
<style>.progress{display:none;}</style>
<div class="rightpanel">
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a><span class="divider">/</span>
        </li>
        <li>
            <a href="#">Reset Database Puskesmas</a><span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo $page_title; ?>
        </li>
    </ul>
</div>
<!--breadcrumbwidget-->
<div class="pagetitle">
    <h1>
        <?php echo $page_title; ?>
    </h1>

    <span>
      Halaman reset database puskesmas
    </span>
</div>
<!--pagetitle-->

<div class="maincontent">
<div class="contentinner content-dashboard">
    <div class="row-fluid">
        <div class="span12">
            <h4 class="widgettitle nomargin">..:: Reset Database Puskesmas ::..</h4>
            <div class="widgetcontent bordered">
                <div class="progress progress-striped active">
                    <div style="width: 0%;" class="bar" id="load"></div>
                </div>
                <div class="row-fluid">
                    <div class="span6  profile-left">
                        <h3>Data Dokter dan Staff </h3>
                    <table class="table">
                        <tr>
                            <td><input type="text" value="Hapus Data Dokter"></td>
                            <td><a class="btn btn-danger btn-rounded" href="#" id="btnDokter">
                                    <i class="iconsweets-trashcan iconsweets-white"></i>
                                    Hapus !
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" value="Hapus Data Petugas"></td>
                            <td><a class="btn btn-danger btn-rounded" href="#" id="btnPetugas">
                                    <i class="iconsweets-trashcan iconsweets-white"></i>
                                    Hapus !
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" value="Hapus Data Pasien"></td>
                            <td><a class="btn btn-danger btn-rounded" href="#" id="btnPasien">
                                    <i class="iconsweets-trashcan iconsweets-white"></i>
                                    Hapus !
                                </a>
                            </td>
                        </tr>

                    </table>

                        <h3> Data Gudang</h3>
                        <table class="table">
                            <tr>
                                <td><input type="text" value="Hapus Barang Masuk Gudang"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnBrgMskGudang">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Barang Keluar Gudang"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnBrgKeluarGudang">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Stok Gudang"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnStokGudang">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Stok Opname Gudang"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnStokOpnameGudang">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Reset Tgl Expired Obat Gudang / Hari ini"></td>
                                <td><a class="btn btn-primary btn-rounded" href="#" id="btnExpObatGudang">
                                        <i class="iconsweets-refresh iconsweets-white"></i>
                                        Ubah Tanggal !
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <h3> Data Apotek</h3>
                        <table class="table">
                            <tr>
                                <td><input type="text" value="Hapus Barang Masuk Apotek"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnBrgMskApotek">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Barang Keluar Apotek"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnBrgKeluarApotek">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Stok Apotek"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnStokApotek">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Hapus Stok Opname Apotek"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnStokOpnameApotek">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" value="Reset Tgl Expired Obat Apotek / Hari ini"></td>
                                <td><a class="btn btn-primary btn-rounded" href="#" id="btnExpObatApotek">
                                        <i class="iconsweets-refresh iconsweets-white"></i>
                                        Ubah Tanggal !
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <h3> Data Pembayaran</h3>
                        <table class="table">
                            <tr>
                                <td><input type="text" value="Hapus Transaksi Pembayaran Kasir"></td>
                                <td><a class="btn btn-danger btn-rounded" href="#" id="btnBayarKasir">
                                        <i class="iconsweets-trashcan iconsweets-white"></i>
                                        Hapus !
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div><!--span3-->
                </div>
            </div>
        </div>
        <!--contentinner-->
    </div>
    <!--maincontent-->
</div>
<!--mainright-->
</div>
</div>

<script>
	var $ = jQuery.noConflict();

	$(document).ready(function(){
        var progressElem = $('.progress');
        //progressElem.hide();

		function info(msg, title){
   			jAlert(msg, title);
		}

		$('#btnDokter').click(function() {
			jConfirm('Apakah anda ingin reset data master dokter?', 'Konfirmasi', function(r) {
				  if(r==true){
					  $.ajax({
                          cache: false,
                          type: "POST",
                          dataType: "json",
                          url: '<?php echo base_url().'reset/resetDokter'; ?>',
                          xhr: function () {
                              var xhr = new window.XMLHttpRequest();
                              //Download progress
                              xhr.addEventListener("progress", function (evt) {
                                  console.log(evt.lengthComputable);
                                  if (evt.lengthComputable) {
                                      var percentComplete = evt.loaded / evt.total;
                                      $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                  }
                              }, false);
                              return xhr;
                          },
                          beforeSend: function () {
                              $('#load').css('width', "0%");
                              progressElem.show();
                          },
                          complete: function () {
                              setTimeout(function(){ progressElem.hide();}, 1000);

                          },
                          success: function(res) {
                              setTimeout(function(){
                                  info(res.info, 'Informasi');
                              }, 1300);

                          }
						});
				  }
				  return false;
			});
		});

		$('#btnPetugas').click(function() {
			jConfirm('Apakah anda ingin reset data master petugas?', 'Konfirmasi', function(r) {
				  if(r==true){
					  $.ajax({
							cache: false,
							type: "POST",
							dataType: "json",
							url: '<?php echo base_url().'reset/resetPetugas'; ?>',
                            error: function (xhr, ajaxOptions, thrownError) {
                              alert(xhr.responseText);
                              alert(thrownError);
                          },
                          xhr: function () {
                              var xhr = new window.XMLHttpRequest();
                              //Download progress
                              xhr.addEventListener("progress", function (evt) {
                                  console.log(evt.lengthComputable);
                                  if (evt.lengthComputable) {
                                      var percentComplete = evt.loaded / evt.total;
                                      $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                  }
                              }, false);
                              return xhr;
                          },
                          beforeSend: function () {
                              $('#load').css('width', "0%");
                              progressElem.show();
                          },
                          complete: function () {
                              setTimeout(function(){ progressElem.hide();}, 1000);

                          },
                          success: function(res) {
                                setTimeout(function(){
                                    info(res.info, 'Informasi');
                                }, 1300);

                          }
						});
				  }
				  return false;
			});
		});

		$('#btnPasien').click(function() {
			jConfirm('Apakah anda ingin reset data master pasien?', 'Konfirmasi', function(r) {
				  if(r==true){
					  $.ajax({
                          cache: false,
                          type: "POST",
                          dataType: "json",
                          url: '<?php echo base_url().'reset/resetPasien'; ?>',
                          xhr: function () {
                              var xhr = new window.XMLHttpRequest();
                              //Download progress
                              xhr.addEventListener("progress", function (evt) {
                                  console.log(evt.lengthComputable);
                                  if (evt.lengthComputable) {
                                      var percentComplete = evt.loaded / evt.total;
                                      $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                  }
                              }, false);
                              return xhr;
                          },
                          beforeSend: function () {
                              $('#load').css('width', "0%");
                              progressElem.show();
                          },
                          complete: function () {
                              setTimeout(function(){ progressElem.hide();}, 1000);

                          },
                          success: function(res) {
                              setTimeout(function(){
                                  info(res.info, 'Informasi');
                              }, 1300);

                          }
						});
				  }
				  return false;
			});
		});

        $('#btnBrgMskGudang').click(function() {
            jConfirm('Apakah anda ingin reset data master barang masuk gudang?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetBarangMasukGudang'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnBrgKeluarGudang').click(function() {
            jConfirm('Apakah anda ingin reset data master barang keluar gudang?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetBarangKeluarGudang'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnStokGudang').click(function() {
            jConfirm('Apakah anda ingin reset data master stok gudang?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetStokGudang'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnStokOpnameGudang').click(function() {
            jConfirm('Apakah anda ingin reset data master stok opname gudang?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetStokOpnameGudang'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnExpObatGudang').click(function() {
            jConfirm('Apakah anda ingin reset data master tanggal expired obat gudang?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetExpObatGudang'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnBrgMskApotek').click(function() {
            jConfirm('Apakah anda ingin reset data master barang masuk apotek?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetBarangMasukApotek'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnBrgKeluarApotek').click(function() {
            jConfirm('Apakah anda ingin reset data master barang keluar apotek?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetBarangKeluarApotek'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnStokApotek').click(function() {
            jConfirm('Apakah anda ingin reset data master stok apotek?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetStokApotek'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnStokOpnameApotek').click(function() {
            jConfirm('Apakah anda ingin reset data master stok opname apotek?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetStokOpnameApotek'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnExpObatApotek').click(function() {
            jConfirm('Apakah anda ingin reset data master tanggal expired obat apotek?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetExpObatApotek'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

        $('#btnBayarKasir').click(function() {
            jConfirm('Apakah anda ingin reset data master transaksi pembayaran kasir (obat dan tindakan)?', 'Konfirmasi', function(r) {
                if(r==true){
                    $.ajax({
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        url: '<?php echo base_url().'reset/resetTransBayarKasir'; ?>',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            //Download progress
                            xhr.addEventListener("progress", function (evt) {
                                console.log(evt.lengthComputable);
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    $('#load').css('width', Math.round(percentComplete * 100) + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function () {
                            $('#load').css('width', "0%");
                            progressElem.show();
                        },
                        complete: function () {
                            setTimeout(function(){ progressElem.hide();}, 1000);

                        },
                        success: function(res) {
                            setTimeout(function(){
                                info(res.info, 'Informasi');
                            }, 1300);

                        }
                    });
                }
                return false;
            });
        });

	});
</script>