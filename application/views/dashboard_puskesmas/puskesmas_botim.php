<div class="rightpanel">

<div class="breadcrumbwidget">
    <!--
            <ul class="info">
            	<li class="active"><?php echo ucwords($this->session->userdata('akses')); ?></li>
            </ul>
            -->
    <ul class="breadcrumb">
        <li>Home <span class="divider">/</span></li>
        <li class="active">Dashboard</li>

    </ul>
</div><!--breadcrumbwidget-->
<div class="pagetitle">
    <h1>Dashboard</h1> <span></span>
</div><!--pagetitle-->

<div class="maincontent">
<div class="contentinner content-dashboard">
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <script language="JavaScript">
        var text="Selamat Datang di PUSKESMAS BOGOR TIMUR";
        var delay=30;
        var currentChar=1;
        var destination="[none]";
        function type()
        {
//if (document.all)
            {
                var dest=document.getElementById(destination);
                if (dest)// && dest.innerHTML)
                {
                    dest.innerHTML=text.substr(0, currentChar)+"<blink>_</blink>";
                    currentChar++;
                    if (currentChar>text.length)
                    {
                        currentChar=1;
                        setTimeout("type()", 5000);
                    }
                    else
                    {
                        setTimeout("type()", delay);
                    }
                }
            }
        }
        function startTyping(textParam, delayParam, destinationParam)
        {
            text=textParam;
            delay=delayParam;
            currentChar=1;
            destination=destinationParam;
            type();
        }
    </script>
    <b><div id="textDestination" style="font-size: 14px;" ></div></b>

    <script language="JavaScript">
        javascript:startTyping(text, 50, "textDestination");
    </script>
    Berikut ini adalah data-data Pelayanan Kesehatan Masyarakat dari Puskesmas <?php echo $nm_puskesmas; ?> <b><?php echo $nm_kota; ?></b>.
</div><!--alert-->



<div class="row-fluid">
    <div class="span3">
        <h4 class="widgettitle nomargin">Statistik Hari ini</h4>
        <div class="widgetcontent bordered" style="text-align: center;">
            <h1><?php echo $total_kunjungan_date['total_kunjungan']; ?></h1><br/>
            Kunjungan loket
        </div><!--widgetcontent-->
    </div>
    <div class="span3">
        <h4 class="widgettitle nomargin">Statistik Minggu ini</h4>
        <div class="widgetcontent bordered" style="text-align: center;">
            <h1><?php echo $total_kunjungan_week['total_kunjungan']; ?></h1><br/>
            Kunjungan loket
        </div><!--widgetcontent-->
    </div>
    <div class="span3">
        <h4 class="widgettitle nomargin">Statistik Bulan ini</h4>
        <div class="widgetcontent bordered" style="text-align: center;">
            <h1><?php echo $total_kunjungan_month['total_kunjungan']; ?></h1><br/>
            Kunjungan loket
        </div><!--widgetcontent-->
    </div>
    <div class="span3">
        <h4 class="widgettitle nomargin">Variable Unit Kerja</h4>
        <div class="widgetcontent bordered">
            <table style="font-size: 12px;">
                <tr>
                    <td>N I P</td><td>&nbsp;:</td><td>&nbsp;<b>19600117 198711 2 002</b></td>
                </tr>
                <tr>
                    <td>Kepala Dinkes</td><td>&nbsp;:</td><td>&nbsp;<b>dr. RUBAEAH, MKM</b></td>
                </tr>
                <tr>
                    <td>Propinsi</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_propinsi; ?></td>
                </tr>
                <tr>
                    <td>Kota/Kab</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_kota; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td><td>&nbsp;:</td><td>&nbsp;JL. Kesehatan No.3, Kecamatan Tanah Sareal</td>
                </tr>
            </table>
        </div><!--widgetcontent-->
    </div>
</div>


<div class="row-fluid">
<div class="span12">
<div class="span6">
	<!--    GRAFIK PENYAKIT TERBANYAK   -->
    <h4 class="widgettitle">Penyakit Terbanyak</h4>
    <div class="widgetcontent">
        <script type="text/javascript">
            jQuery(function () {
                jQuery('#container3').highcharts({
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: 'Tren Penyakit Terbanyak'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                style: {
                                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                }
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Persentase Jumlah Penyakit',
                        data: [
                            <?php $i=1; foreach($top_desease['data'] as $td): ?>
                            <?php $persen = ($td['total'] / $top_desease['total_data']) * 100; ?>
                            <?php if($i == 1): ?>
                            {
                                name: '<?php echo $td['kd_penyakit']; ?>',
                                y: <?php echo $persen; ?>,
                                sliced: true,
                                selected: true
                            },
                            <?php else: ?>
                            ['<?php echo $td['kd_penyakit']; ?>',  <?php echo $persen; ?>],
                            <?php endif; ?>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                            /*
                             {
                             name: 'DBD',
                             y: 12.8,
                             sliced: true,
                             selected: true
                             },
                             */
                        ]
                    }]
                });
            });


        </script>
        <div id="container3" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
    	
    </div><!--widgetcontent-->
</div>
<div class="span6">
<h4 class="widgettitle">5 Penyakit Terbanyak</h4>
    <div class="widgetcontent"">
    <table style="font-size: 12px;" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Penyakit</th>
                <th>Penyakit</th>
            </tr>
        </thead>
        <tbody>
        <?php $no=1; foreach($top_desease['data'] as $de): ?>
        <tr>
            <td><?php echo $no;?></td><td><?php echo $de['kd_penyakit'];?></td><td><?php echo $de['penyakit'];?></td>
        </tr>
        <?php $no++; endforeach;?>
        </tbody>
    </table>
	</div>
</div>
</div>
</div>


<div class="row-fluid">
<div class="span6">
    <h4 class="widgettitle">Jumlah Pasien Berdasarkan Jenis Kelamin</h4>
    <div class="widgetcontent">
        <script type="text/javascript">
            jQuery(function () {
                jQuery('#container1').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Jumlah Pasien Berdasarkan Jenis Kelamin'
                    },
                    subtitle: {
                        text: 'Tahun <?php echo date('Y'); ?>'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Pasien'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.f} Orang</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Pasien Pria',
                        data:
                            [
                                <?php foreach($pria as $pr): ?>
                                <?php echo $pr['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 92, 2, 0, 0, 0, 0, 0, 3,]
                    }, {
                        name: 'Pasien Wanita',
                        data:
                            [
                                <?php foreach($wanita as $wn): ?>
                                <?php echo $wn['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 103, 8, 0, 0, 0, 0, 0, 4,]

                    }]
                });
            });

        </script>
        <div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    </div><!--widgetcontent-->
	<h4 class="widgettitle nomargin">Grafik Jumlah Kunjungan Per Kasus</h4>
    	<div class="widgetcontent">
        <script type="text/javascript">
            jQuery(function () {
                jQuery('#container4').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Jumlah Kunjungan Berdasarkan Jenis Kasus'
                    },
                    subtitle: {
                        text: 'Tahun <?php echo date('Y'); ?>'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Kunjungan'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.f} Kunjungan</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Kasus Lama',
                        data:
                            [
                                <?php foreach($kasus_lama as $kl): ?>
                                <?php echo $kl['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 92, 2, 0, 0, 0, 0, 0, 3,]
                    }, {
                        name: 'Kasus Baru',
                        data:
                            [
                                <?php foreach($kasus_baru as $kb): ?>
                                <?php echo $kb['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 103, 8, 0, 0, 0, 0, 0, 4,]

                    }]
                });
            });
        </script>
        <div id="container4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
</div><!--span6-->
<div class="span6">
    <h4 class="widgettitle">Jumlah Kunjungan Pasien / Bulan</h4>
    <div class="widgetcontent">
        <script type="text/javascript">
            jQuery(function () {
                jQuery('#container').highcharts({
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Jumlah Kunjungan Pasien per Bulan'
                    },
                    subtitle: {
                        text: 'Tahun <?php echo date('Y'); ?>'
                    },
                    xAxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah Kunjungan'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: [{
                        name: 'Kunjungan',
                        data:
                            [
                                <?php foreach($kunjungan as $k): ?>
                                <?php echo $k['total_kunjungan'].', '; ?>
                                <?php endforeach; ?>
                            ]
                    }]
                });
            });
        </script>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    
	<h4 class="widgettitle nomargin">Grafik Jumlah Kunjungan Rawat Inap dan Rawat Jalan</h4>
    	<div class="widgetcontent">
        <script type="text/javascript">
            jQuery(function () {
                jQuery('#container5').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Jumlah Kunjungan Rawat Inap dan Rawat Jalan'
                    },
                    subtitle: {
                        text: 'Tahun <?php echo date('Y'); ?>'
                    },
                    xAxis: {
                        categories: [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec'
                        ]
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Kunjungan'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.f} Kunjungan</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Rawat Inap',
                        data:
                            [
                                <?php foreach($rawat_inap as $ri): ?>
                                <?php echo $ri['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 92, 2, 0, 0, 0, 0, 0, 3,]
                    }, {
                        name: 'Rawat Jalan',
                        data:
                            [
                                <?php foreach($rawat_jalan as $rj): ?>
                                <?php echo $rj['jumlah'].', '; ?>
                                <?php endforeach; ?>
                            ]
                        //[0, 0, 0, 0, 103, 8, 0, 0, 0, 0, 0, 4,]

                    }]
                });
            });
        </script>
        <div id="container5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>

</div><!--span6-->
</div><!--row-fluid-->
<div class="row-fluid">
<div class="span12">
<h4 class="widgettitle nomargin">Grafik Jumlah Pasien Per Poli</h4>
        <div class="widgetcontent">
        <?php $arrBulan = array('Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'); ?>
        	<script type="text/javascript">
        jQuery(function () {
            jQuery('#container7').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Jumlah Kunjungan per Poli'
                },
                subtitle: {
                    text: 'Bulan <?php echo $arrBulan[date('m')-1].' '.date('Y'); ?> '
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -70,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah (Kunjungan)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Jumlah kunjungan: <b>{point.y:.f}</b>'
                },
                series: [{
                    name: 'Poli',
                    data: 	[
                    			<?php $i=0; 
								foreach($poli['nm_unit'] as $unit): 
								?>
                                ['<?php echo $unit; ?>', <?php echo $poli['jumlah'][$i]['jumlah']; ?>],
                                <?
								$i++;
								endforeach;
								?>
								
                        	],
                    dataLabels: {
                        enabled: true,
                        rotation: 0,
                        color: '#000000',
                        align: 'left',
                        x: 4,
                        y: 10,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif',
                            textShadow: '0 0 3px black'
                        }
                    }
                }]
            });
        });
        </script>
        <div id="container7" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
</div>
</div>
</div><!--contentinner-->
</div><!--maincontent-->

</div><!--mainright-->

<!--highcharts-->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>