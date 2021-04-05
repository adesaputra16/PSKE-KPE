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
  }else if($d2=="flowmeter")
  {
    $adminLTE->breadcrumb(array(
      'title'=>"<i class='glyphicon glyphicon-scale'></i> Daftar Flowmeter",
      'breadcrumb'=>array(
        array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
        array('title'=>"<a href='?show=kpe/kwh/flowmeter'>Flowmeter</a>",'link'=>"?show=kpe/kwh/flowmeter"),
        //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
        //array('title'=>"more title",'link'=>"#"),
      ),
    ));
  }else if($d2=="catatan")
  {
    $adminLTE->breadcrumb(array(
      'title'=>"<i class='fa fa-file-text-o'></i> Catatan KWh",
      'breadcrumb'=>array(
        array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
        array('title'=>"<a href='?show=kpe/kwh/catatan'>Catatan KWh</a>",'link'=>"?show=kpe/kwh/catatan"),
        //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
        //array('title'=>"more title",'link'=>"#"),
      ),
    ));
  }else if($d2=="harian_solar")
  {
    $adminLTE->breadcrumb(array(
      'title'=>"<i class='fa fa-file-text'></i> Harian Solar & KWh",
      'breadcrumb'=>array(
        array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
        array('title'=>"<a href='?show=kpe/kwh/harian_solar'>Harian Solar & KWh</a>",'link'=>"?show=kpe/kwh/harian_solar"),
        //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
        //array('title'=>"more title",'link'=>"#"),
      ),
    ));
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
            require_once("kwh/catatan/catatan.php");
            break;

          case 'FLOWMETER':
            require_once("kwh/flowmeter/flowmeter.php");
            break;

          case 'HARIAN_SOLAR':
            require_once("kwh/harian/solar_kwh.php");
            break;
            //----------------- END CASE
          default:
            require_once("kwh/catatan/catatan.php");
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