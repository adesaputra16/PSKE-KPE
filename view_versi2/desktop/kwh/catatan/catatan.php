<?php

	if(empty($d3))
	{
		$d3 = "kwh";
	}
	else
	{
		$d3 = $d3;
	}

?>
<div class="col-12">
    <div class="box box-primary box-outline box-outline-tabs">
      <div class="box-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist">
          <li class="active" id="kwh" role="tab">
            <a href="?show=kpe/kwh/catatan/kwh">Catatan Keliling</a>
          </li>
          <!-- <li class="active" id="beban_harian" role="tab">
            <a href="?show=kpe/kwh/catatan/beban_harian">Beban Harian</a>
          </li>
          <li class="active" id="per_dept" role="tab">
            <a href="?show=kpe/kwh/catatan/per_dept">Per Dept</a>
          </li> -->
				</ul>
        <script>
          $(function(){
            $(".nav-tabs li").removeClass('active');
            $(".nav-tabs li#<?= $d3; ?>").addClass('active');
          });
        </script>
      </div>
      <?php
        if($d3=='kwh')
        {
          require_once("tab/catatan_kwh.php");
        } else if ($d3 == 'beban_harian') {
          require_once("tab/beban_harian.php");
        } else if($d3 == 'per_dept') {
          require_once("tab/per_dept.php");
        } else
        {
          require_once("tab/catatan_kwh.php");
        }
      ?>
    </div>
  </div>
</div>