<?php

	if(empty($d3))
	{
		$d3 = "air";
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
          <li class="active" id="air" role="tab">
            <a href="?show=kpe/air/catatan/air">Catatan Keliling</a>
          </li>
          <li class="active" id="beban_harian" role="tab">
            <a href="?show=kpe/air/catatan/beban_harian">Beban Harian</a>
          </li>
          <li class="active" id="per_dept" role="tab">
            <a href="?show=kpe/air/catatan/per_dept">Per Dept</a>
          </li>
				</ul>
        <script>
          $(function(){
            $(".nav-tabs li").removeClass('active');
            $(".nav-tabs li#<?= $d3; ?>").addClass('active');
          });
        </script>
      </div>
      <?php
        if($d3=='air')
        {
          require_once("tab/air.php");
        } else if ($d3 == 'beban_harian') {
          require_once("tab/beban_harian.php");
        } else if($d3 == 'per_dept') {
          require_once("tab/per_dept.php");
        } else
        {
          require_once("tab/air.php");
        }
      ?>
    </div>
  </div>
</div>