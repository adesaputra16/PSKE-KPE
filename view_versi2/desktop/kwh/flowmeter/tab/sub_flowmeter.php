<div class="box-body">
  <button type="button" class="btn btn-sm btn-success modalSubFlowmeter"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Sub Flowmeter
  </button>
  <!-- <div class="pull-right">
    <a href=""  type="button" id="cetakPdf" class="btn btn-sm btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a> 
  </div> -->
  <br><br>

  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover">
          <thead>
              <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Sub Flowmeter</th>
                <!-- <th>Divisi</th> -->
              </tr>
          </thead>
          <tbody id="zone_data">

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="pagination-holder clearfix">
        <div class="pagination" id="tujuan-light-pagination"></div>
      </div>
    </div>
    <div class="col-md-3 text-right">
      <label>Jumlah Baris Per Halaman</label>
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSubFlowmeter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Sub Flowmeter</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:simpan();" class="fDataFlowmeter" id="fData" name="fDataFlowmeter">
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_SUB_NAMA">Sub Flowmeter</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_SUB_NAMA" name="KPE_AIR_FLOWMETER_SUB_NAMA" placeholder="KPE_AIR_FLOWMETER_SUB_NAMA">
              
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_SUB_ID" name="KPE_AIR_FLOWMETER_SUB_ID">

            </div>
            <!-- <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_SUB_NAMA">Divisi</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_SUB_NAMA" name="KPE_AIR_FLOWMETER_SUB_NAMA" placeholder="KPE_AIR_FLOWMETER_SUB_NAMA">
              
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_SUB_ID" name="KPE_AIR_FLOWMETER_SUB_ID">

            </div> -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
<script>
$('.modalSubFlowmeter').on('click', function(){
  $("#modalSubFlowmeter").modal('show');
  $('#KPE_AIR_FLOWMETER_SUB_NAMA').val('');
  $('#KPE_AIR_FLOWMETER_SUB_ID').val('');
})

function simpan()
{
  var fData=$("#fData").serialize(); 
  // alert(fData);
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_sub_flowmeter&'+fData,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        $("#modalSubFlowmeter").modal('hide');
        alert(data.respon.text_msg);
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        tampil('1');
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_sub_flowmeter()');
    }//end error
  });
}


$('tbody').on('click', 'a.edit', function(){
  var KPE_AIR_FLOWMETER_SUB_ID = $(this).attr('KPE_AIR_FLOWMETER_SUB_ID');
  var KPE_AIR_FLOWMETER_SUB_NAMA = $(this).attr('KPE_AIR_FLOWMETER_SUB_NAMA');
  $("#modalSubFlowmeter").modal('show');
  $('input#KPE_AIR_FLOWMETER_SUB_ID').val(KPE_AIR_FLOWMETER_SUB_ID);
  $('input#KPE_AIR_FLOWMETER_SUB_NAMA').val(KPE_AIR_FLOWMETER_SUB_NAMA);
});

$(window).on('hashchange', function(e) {
  tampil('1');
});
$("input#REC_PER_HALAMAN").on('change', function() {
  tampil('1');
});
$("select#subNama").on('change', function() {
  tampil('1');
});

function tampil(curPage)
{
  // var data = 'tampil_flowmeter&keyword='+$("input#keyword").val()+'&idFlowmeter='+$("select#namaFlowmeter").val()+'&lokasiFlowmeter='+$("select#lokasiFlowmeter").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage;
  // console.log(data);
  var url = window.location.href;
  var pageA = url.split("#");
  if (pageA[1] == undefined) {} else {
    var pageB = pageA[1].split("page-");
    if (pageB[1] == '') {
      var curPage = curPage;
    } else {
      var curPage = pageB[1];
    }
  }
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=tampil_sub_flowmeter&keyword='+$("input#keyword").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
    success: function(data) {
			//console.log("List");
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_data").empty();
        $('#tujuan-light-pagination').pagination({
          pages: data.result_option.jml_halaman,
          cssStyle: 'light-theme',
          currentPage: curPage,
        });
          for (i = 0; i < data.result.length; i++) {
            $("tbody#zone_data").append("<tr>" + "<td >" + data.result[i].NO + ".</td>" +
            "<td>"+
              "<div class='btn-group'>"+
                "<button type='button' class='btn btn-success btn-xs'>"+
                  "<i class='fa fa-eye'></i>"+
                "</button>"+
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>"+
                  "<i class='caret'></i>"+
                "</button>"+
                "<ul class='dropdown-menu'>"+
                  "<li><a class='edit' KPE_AIR_FLOWMETER_SUB_ID='" + data.result[i].KPE_AIR_FLOWMETER_SUB_ID + "' KPE_AIR_FLOWMETER_SUB_NAMA='" + data.result[i].KPE_AIR_FLOWMETER_SUB_NAMA + "'><i class='fa fa-edit'></i>Edit</a></li>"+
                  "<li><a class='hapus' KPE_AIR_FLOWMETER_SUB_ID='" + data.result[i].KPE_AIR_FLOWMETER_SUB_ID + "' KPE_AIR_FLOWMETER_SUB_STATUS='" + data.result[i].KPE_AIR_FLOWMETER_SUB_STATUS + "'><i class='fa fa-trash'></i>Hapus</a></li>"+
                "</ul>"+
              "</div>"+
            "</td>"+
            "<td>" + data.result[i].KPE_AIR_FLOWMETER_SUB_NAMA + "</td>" +
            "</tr>");
          }

      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_data").html("<tr><td colspan='4'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> tampil_sub_flowmeter()');
    } //end error
  });
}

$('tbody').on('click', 'a.hapus', function(){
  var KPE_AIR_FLOWMETER_SUB_ID = $(this).attr('KPE_AIR_FLOWMETER_SUB_ID');
  var KPE_AIR_FLOWMETER_SUB_STATUS = $(this).attr('KPE_AIR_FLOWMETER_SUB_STATUS');
  // alert(KPE_AIR_FLOWMETER_SUB_ID);
  if (KPE_AIR_FLOWMETER_SUB_STATUS == "PERMANEN") {
    Swal.fire({
      title: 'Gagal!',
      text: 'Sub Flowmeter ini tidak bisa dihapus, Hubungi IT',
      icon: 'error',
    })
  }else {
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Setelah dihapus data tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Tidak!',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, yakin!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type:'POST',
          url:refseeAPI,
          dataType:'json',
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_sub_flowmeter&KPE_AIR_FLOWMETER_SUB_ID='+KPE_AIR_FLOWMETER_SUB_ID,
          success:function(data)
          { 
            if(data.respon.pesan=="sukses")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Terhapus!',
                text: 'Data berhasil dihapus.',
                icon: 'success',
              })
              tampil('1');
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              tampil('1');
            }
          },
          error:function(x,e){
            // error_handler_json(x,e,'=> hapus_catatan()');
            alert('error')
          }//end error
        });
      }
    })
  }
})

$('#cetakPdf').on('click', function(){
  window.open('?show=kpe/pdf/cetak_sub_flowmeter/', '_blank');
})

$('#btn-reload').on('click', function(){
  $('select#subNama').val('');
  tampil('1');
})

$(function() {
  tampil('1');
});

function search(){
	tampil('1');
}

</script>