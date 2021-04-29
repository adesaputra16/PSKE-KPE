<div class="nav-tabs-custom">
  <ul class="nav nav-tabs pull-right">
    <li class="pull-left header"><i class="fa fa-calculator" aria-hidden="true"></i></i> CONTOH</li>
  </ul>
  <div class="tab-content no-padding">
    
  </div>
</div>

<script>
function tampil()
{
  $.ajax({
        type:'POST',
        url:refseeAPI,
        dataType:'json',
        data:'aplikasi=<?php echo $d0;?>&ref=kwh_contoh',
        success:function(data)
        { 
          if(data.respon.pesan=="sukses")
          {
            console.log(data.result);
            alert(data.respon.text_msg);
            
            
          }else if(data.respon.pesan=="gagal")
          {
            alert(data.respon.text_msg);
          }
        },
        error:function(x,e){
          // error_handler_json(x,e,'=> hapus_catatan()');
          alert('error')
        }//end error
      });

}
$(function () {
  tampil();
});
</script>
