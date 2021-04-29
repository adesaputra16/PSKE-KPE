<?php

if(empty($d3))
{
  $d3 = "opn";
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
        <li class="active" id="opn" role="tab">
          <a href="?show=kpe/air/operasional_ro/opn">OPN</a>
        </li>
        <li class="active" id="kimia" role="tab">
          <a href="?show=kpe/air/operasional_ro/kimia">Kimia</a>
        </li>
        <li class="active" id="rekap" role="tab">
          <a href="?show=kpe/air/operasional_ro/rekap">Rekap Pemakaian</a>
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
      if($d3=='opn') {
        require_once("tab_ro/opn.php");
      } else if ($d3 == 'kimia') {
        require_once("tab_ro/kimia.php");
      } else if ($d3 == 'rekap'){
        require_once("tab_ro/rekap_used.php");
      }else {
        require_once("tab_ro/opn.php");
      }
    ?>
  </div>
</div>
</div>