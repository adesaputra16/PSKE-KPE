<!-- Case Tabs -->
<?php

	if(empty($d3))
	{
		$d3 = "flowmeter";
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
            <li class="active" id="flowmeter" role="tab">
              <a href="?show=kpe/air/tambah_flowmeter/flowmeter">Flowmeter</a>
            </li>
            <li class="active" id="subflowmeter" role="tab">
              <a href="?show=kpe/air/tambah_flowmeter/subflowmeter">Sub Flowmeter</a>
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
        if($d3=='flowmeter')
        {
            require_once("tab/flowmeter.php");
        }
        elseif($d3=='subflowmeter')
        {
            require_once("tab/sub_flowmeter.php");
        }
        else
        {
            require_once("tab/flowmeter.php");
        }
      ?>
    </div>
  </div>
</div>
<!-- case tabs -->

