<?php
require_once('menu_sidebar.php');
?>

<div class="content-wrapper">
  
  <?php
	 if(!isset($d2) or $d2=="")
	  {
		 $adminLTE->breadcrumb(array(
			 'title'=>"KPE",
			 'title_sub'=>"1.0",
			 'breadcrumb'=>array(
				 array('title'=>"KPE",'link'=>"#"),
				 //array('title'=>"Wiget",'link'=>"#"),
				 //array('title'=>"more title",'link'=>"#"),
			 ),
		 ));
	  }else if($d2=="catatan")
    {
      if ($d3=="catatan") {
        $adminLTE->breadcrumb(array(
          'title'=>"KPE Air Pre-Treatment & RO",
          'breadcrumb'=>array(
            array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
            array('title'=>"<a href='?show=kpe/air/catatan'>KPE Air Pre-Treatment & RO</a>",'link'=>"?show=kpe/air/catatan"),
            //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
            //array('title'=>"more title",'link'=>"#"),
          ),
        ));
      } else {
        if($d3=="")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-tint'></i> Catatan Air Pre-Treatment & RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/catatan'>Catatan Air Pre-Treatment & RO</a>",'link'=>"?show=kpe/air/catatan"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="air")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-tint'></i> Catatan Air Pre-Treatment & RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/catatan'>Catatan Air Pre-Treatment & RO</a>",'link'=>"?show=kpe/air/catatan"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="beban_harian")
        {
  
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='glyphicon glyphicon-scale'></i> Beban Harian",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/catatan/beban_harian'>Beban Harian</a>",'link'=>"?show=kpe/air/catatan/beban_harian"),
              // array('title'=>"Air Pre & RO",'link'=>"?show=kpe/air/catatan/beban_harian/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="per_dept")
        {
  
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-university'></i> Per Departement",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/catatan/per_dept'>Per Dept</a>",'link'=>"?show=kpe/air/catatan/per_dept"),
              // array('title'=>"Air Pre & RO",'link'=>"?show=kpe/air/catatan/beban_harian/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }
      }
	  } elseif ($d2=="tambah_flowmeter") {
        if ($d3=="flowmeter") {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='glyphicon glyphicon-scale'></i> Daftar Flowmeter",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/tambah_flowmeter'>Daftar Flowmeter</a>",'link'=>"?show=kpe/air/tambah_flowmeter"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        } else {
          if($d3=="")
          {
            $adminLTE->breadcrumb(array(
              'title'=>"<i class='glyphicon glyphicon-scale'></i> Daftar Flowmeter",
              'breadcrumb'=>array(
                array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
                array('title'=>"<a href='?show=kpe/air/tambah_flowmeter'>Daftar Flowmeter</a>",'link'=>"?show=kpe/air/tambah_flowmeter"),
                //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
                //array('title'=>"more title",'link'=>"#"),
              ),
            ));
          }else if($d3=="flowmeter")
          {
            $adminLTE->breadcrumb(array(
              'title'=>"<i class='glyphicon glyphicon-scale'></i> Daftar Flowmeter",
              'breadcrumb'=>array(
                array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
                array('title'=>"<a href='?show=kpe/air/tambah_flowmeter/flowmeter'>Daftar Flowmeter</a>",'link'=>"?show=kpe/air/tambah_flowmeter/flowmeter"),
                //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
                //array('title'=>"more title",'link'=>"#"),
              ),
            ));
          }else if($d3=="subflowmeter")
          {
            $adminLTE->breadcrumb(array(
              'title'=>"<i class='fa fa-tachometer'></i> Daftar Sub Flowmeter",
              'breadcrumb'=>array(
                array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
                array('title'=>"<a href='?show=kpe/air/tambah_flowmeter/subflowmeter'>Daftar Sub Flowmeter</a>",'link'=>"?show=kpe/air/tambah_flowmeter/subflowmeter"),
                //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
                //array('title'=>"more title",'link'=>"#"),
              ),
            ));
          }
        }
    } elseif ($d2=="konfigurasi") {
      $adminLTE->breadcrumb(array(
        'title'=>"<i class='fa fa-cogs'></i> Konfigurasi",
        'breadcrumb'=>array(
          array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
          array('title'=>"<a href='?show=kpe/air/konfigurasi'>Konfigurasi</a>",'link'=>"?show=kpe/air/konfigurasi"),
          //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
          //array('title'=>"more title",'link'=>"#"),
        ),
      ));
    } elseif ($d2=="operasional_pre") {
      if ($d3=="operasional_pre") {
        $adminLTE->breadcrumb(array(
          'title'=>"<i class='fa fa-file-text-o'></i> Operasional Pre-Treatment",
          'breadcrumb'=>array(
            array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
            array('title'=>"<a href='?show=kpe/air/operasional_pre/opn'>Operasional Pre-Treatment</a>",'link'=>"?show=kpe/air/operasional_pre/opn"),
            //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
            //array('title'=>"more title",'link'=>"#"),
          ),
        ));
      } else {
        if($d3=="")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-file-text-o'></i> Operasional Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_pre/opn'>Operasional Pre-Treatment</a>",'link'=>"?show=kpe/air/operasional_pre/opn"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="opn")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-file-text-o'></i> Operasional Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_pre/opn'>Operasional Pre-Treatment</a>",'link'=>"?show=kpe/air/operasional_pre/opn"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="kimia")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='glyphicon glyphicon-oil'></i> Kimia Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_pre/kimia'>Kimia Pre-Treatment</a>",'link'=>"?show=kpe/air/operasional_pre/kimia"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="rekap")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-copy'></i> Rekap Used Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_pre/rekap'>Rekap Used Pre-Treatment</a>",'link'=>"?show=kpe/air/operasional_pre/rekap"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }
      }
    } elseif ($d2=="operasional_ro") {
      if ($d3=="operasional_ro") {
        $adminLTE->breadcrumb(array(
          'title'=>"<i class='fa fa-file-text-o'></i> Operasional RO",
          'breadcrumb'=>array(
            array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
            array('title'=>"<a href='?show=kpe/air/operasional_ro/opn'>Operasional RO</a>",'link'=>"?show=kpe/air/operasional_ro/opn"),
            //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
            //array('title'=>"more title",'link'=>"#"),
          ),
        ));
      } else {
        if($d3=="")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-file-text-o'></i> Operasional RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_ro/opn'>Operasional RO</a>",'link'=>"?show=kpe/air/operasional_ro/opn"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="opn")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-file-text-o'></i> Operasional RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_ro/opn'>Operasional RO</a>",'link'=>"?show=kpe/air/operasional_ro/opn"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="kimia")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='glyphicon glyphicon-oil'></i> Kimia RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_ro/kimia'>Kimia RO</a>",'link'=>"?show=kpe/air/operasional_ro/kimia"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }else if($d3=="rekap")
        {
          $adminLTE->breadcrumb(array(
            'title'=>"<i class='fa fa-copy'></i> Rekap Used RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/air/operasional_ro/rekap'>Rekap Used RO</a>",'link'=>"?show=kpe/air/operasional_ro/rekap"),
              //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        }
      }
    }
		
		
	 ?>
  <section class="content">
    <div class="row box1" id="PlatformWiget">
      <?php
      foreach ($user_wiget['result']['items']['box1'] as $wd) {
        $APP_DASHBOARD = new APP_DASHBOARD();
        $APP_DASHBOARD->wiget(array('case' => $wd['USER_DASHBOARD_CASE_NAME'], 'dir_versi' => $aplikasi_user_aktif['aktif'][0]['USER_APLIKASI_UI_DIR'], 'USER_APLIKASI_ID' => $wd['USER_APLIKASI_ID']));
      }
      ?>
    </div>
    <!--------------------------------- KONTEN  --------------------------------->
    <div class="row">
      <div class="col-md-12">
        <?php
        switch (strtoupper($d2)) {
          case 'CATATAN':
            require_once("air/kpe_air/catatan.php");
            break;
          case 'TAMBAH_FLOWMETER':
            require_once("air/kpe_flowmeter/tambah_flowmeter.php");
            break;
          case 'MULTIPLE_ADD':
            require_once("air/kpe_air/multiple_add.php");
            break;
          case 'KONFIGURASI':
            require_once("air/konfigurasi/konfigurasi.php");
            break;
          case 'OPERASIONAL_PRE':
            require_once("air/operasional/operasional_pre.php");
            break;
          case 'OPERASIONAL_RO':
            require_once("air/operasional/operasional_ro.php");
            break;
            //----------------- END CASE
          default:
            require_once("kpe_air/catatan.php");
            break;
        }
        ?>
      </div>
    </div>
    <!--------------------------------- END KONTEN  --------------------------------->

  </section>
</div>

<script>
  $(function() {
    $("div[class^='notification-version']").hide();
  });
  var tour = new Tour({
    backdrop: true,
    storage: false
  });
  // Add your steps. Not too many, you don't really want to get your users sleepy
  tour.addSteps([{
    element: "#PlatformHeader", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Header Bar", // string - title of the popover
    content: "Bagian ini merupakan ", // string - content of the popover
    placement: "bottom",
  }, {
    element: "#PlatformMenu", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Kotak Pencarian", // string - title of the popover
    content: "Bagian ini merupakan kotak untuk memasukan kata kunci pencarian", // string - content of the popover
    placement: "right",
  }, {
    element: "#PlatformWiget", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Kotak Pencarian", // string - title of the popover
    content: "Bagian ini merupakan kotak untuk memasukan kata kunci pencarian", // string - content of the popover
    placement: "top",
  }, {
    element: "#PlatformHitoriAplikasi", // string (jQuery selector) - html element next to which the step popover should be shown
    title: "Notifikasi", // string - title of the popover
    content: "Bagian ini adalah fitur notifikasi, setiap ada pemberitahuan akan muncul disini", // string - content of the popover
    placement: "top",
  }]);
  // Initialize the tour
  tour.init();
  $('.PlatformTourStart').on('click', function() {
    // Start the tour
    if (tour.start()) {
      tour.restart();
    }
  });
</script>