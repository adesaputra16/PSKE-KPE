<?php
require_once('menu_sidebar.php');
?>

<div class="content-wrapper">
<?php
	 if(!isset($d1) or $d1=="")
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
	  }else if($d1=="dailyreport")
    {
      if(!isset($d2) or $d2=="")
      {
        $adminLTE->breadcrumb(array(
          'title'=>"Daily Report",
          'breadcrumb'=>array(
            array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
            array('title'=>"<a href='?show=kpe/dailyreport/'>Daily Report</a>",'link'=>"?show=kpe/dailyreport"),
            //array('title'=>"Pribadi",'link'=>"?show=laporan/kerja/personel/"),
            //array('title'=>"more title",'link'=>"#"),
          ),
        ));
      }else if($d2=="ksb")
      {

        $adminLTE->breadcrumb(array(
          'title'=>"Laporan Harian kWH, Solar dan Batubara",
          'breadcrumb'=>array(
            array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
            array('title'=>"<a href='?show=kpe/dailyreport/'>Daily Report</a>",'link'=>"?show=kpe/dailyreport"),
            array('title'=>"kWH, Solar & Batubara",'link'=>"?show=kpe/dailyreport/ksb/"),
            //array('title'=>"more title",'link'=>"#"),
          ),
        ));
      }else if($d2=="air")
      {
        if ($d3=="") {
          $adminLTE->breadcrumb(array(
            'title'=>"Laporan Harian Air Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/dailyreport/air'>Air Pre & RO</a>",'link'=>"?show=kpe/dailyreport/air/pre"),
              array('title'=>"Air Pre",'link'=>"?show=kpe/dailyreport/air/pre/"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        } else if ($d3=="pre") {
          $adminLTE->breadcrumb(array(
            'title'=>"Laporan Harian Air Pre-Treatment",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/dailyreport/air/pre'>Air Pre & RO</a>",'link'=>"?show=kpe/dailyreport/air/pre"),
              array('title'=>"Air Pre",'link'=>"?show=kpe/dailyreport/air/pre"),
              //array('title'=>"more title",'link'=>"#"),
            ),
          ));
        } else if ($d3=="ro") {
          $adminLTE->breadcrumb(array(
            'title'=>"Laporan Harian Air RO",
            'breadcrumb'=>array(
              array('title'=>"<a href='?show=kpe'>KPE</a>",'link'=>"?show=kpe"),
              array('title'=>"<a href='?show=kpe/dailyreport/air/ro'>Air Pre & RO</a>",'link'=>"?show=kpe/dailyreport/air/ro"),
              array('title'=>"Air RO",'link'=>"?show=kpe/dailyreport/air/ro"),
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
          case 'KSB':
            require_once("air/dailyreport/ksb.php");
          break;
          case 'AIR':
            require_once("air/dailyreport/air.php");
          break;
          default:
            //require_once("beranda.php");
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