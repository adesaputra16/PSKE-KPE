<!-- Case Tabs -->
<?php

	if(empty($d3))
	{
		$d3 = "pre";
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
            <li class="active" id="pre" role="tab">
              <a href="?show=kpe/dailyreport/air/pre">PRE</a>
            </li>
            <li class="active" id="ro" role="tab">
              <a href="?show=kpe/dailyreport/air/ro">RO</a>
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
        if($d3=='pre')
        {
            require_once("tab/air_pre.php");
        }
        elseif($d3=='ro')
        {
            require_once("tab/air_ro.php");
        }
        else
        {
            require_once("tab/air_pre.php");
        }
      ?>
    </div>
  </div>
</div>
<!-- case tabs -->

