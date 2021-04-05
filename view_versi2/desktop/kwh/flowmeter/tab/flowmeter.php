<?php 
$input_option = array();
$params_flow=array(
//'case'=>"presensi_lembur_spl_pdf_nonlogin",
'case'=>"nonlogin_ambil_kwh_flowmeter",
'batas'=>100,
'halaman'=>1,
'data_http'=>$_COOKIE['data_http'],
'input_option'=>$input_option,
);

$flow = $KPE->kpe_kwh($params_flow)->load->module;

?>
<style>

.loader {
  border: 7px solid #f3f3f3;
  border-radius: 50%;
  border-top: 7px solid #3498db;
  border-bottom: 7px solid #3498db;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* .backloader{
  background:rgba(250, 240, 202,0.4) !important;
} */
.Content {
  height:600px;
  overflow:auto;
  background:#fff;
}

table.table-bodered, .bordered{
  border:1px solid #ccc !important;
}

tr.trData:hover{
  background:rgba(250, 240, 202,0.5) !important;
}

a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>

<div class="box-body">
  <button type="button" class="btn btn-sm btn-success btnFlowmeter"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Flowmeter</button>
  <!-- <button type="button" class="btn btn-sm btn-info btnFlowmeterDept">Flowmeter Departemen</button> -->
  <!-- <div class="pull-right">
    <button type="button" class="btn btn-sm btn-primary" id="btn-reload"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
    <a href=""  type="button" id="cetakPdf" class="btn btn-sm btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a> 
  </div> -->
  <br><br>

  <!-- Pencarian -->
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="KPE_KWH_FLOWMETER_NAMA">Flowmeter :</label>
        <select id="KPE_KWH_FLOWMETER_NAMA" name="KPE_KWH_FLOWMETER_NAMA" class="form-control selectpicker" data-live-search="true" onchange="tampil('1');">
          <option value="">--Pilih--</option>
          <?php 
            foreach ($flow['result'] as $rf) {
              echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>"; 
            }
          ?>
        </select>
      </div>
    </div>
    <!-- <div class="col-md-4">
      <div class="form-group">
        <label for="subFlowmeter">Sub Flowmeter :</label>
        <select id="subFlowmeter" name="subFlowmeter" class="form-control selectpicker" data-live-search="true" onchange="tampil('1');">
          <option value="">--Pilih--</option>
          <?php 
            foreach ($sub['result'] as $s) {
              echo "<option value='$s[KPE_AIR_FLOWMETER_SUB_ID]'>$s[KPE_AIR_FLOWMETER_SUB_NAMA]</option>"; 
            }
          ?>
        </select>
      </div>
    </div> -->
    <!-- <div class="col-md-4">
      <div class="form-group">
        <label for="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE">Distribusi Type :</label>
        <select id="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" name="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" class="form-control" onchange="tampil('1');">
          <option value="">--Pilih--</option>
          <option value="PRE">PRE</option>
          <option value="RO">RO</option>
          <option value="REJECT">REJECT</option>
        </select>
      </div>
    </div> -->
  </div>
  <!-- end pencarian -->

  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive Content">
          <table class="table table-hover">
            <thead class="bordered">
                <tr class="bordered">
                  <th class="bordered">No.</th>
                  <th class="bordered text-center">Aksi</th>
                  <!-- <th class="bordered">Sub Flowmeter</th> -->
                  <th class="bordered">Flowmeter</th>
                  <th class="bordered">Lokasi</th>
                  <th class="bordered">Reading</th>
                </tr>
            </thead>
            <tbody id="zone_data" class="bordered">
              <tr class="bordered">
                <td class="backloader" colspan="6">
                  <center>
                    <div class="loader"></div>
                  </center>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
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
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="100">
    </div>
  </div>
</div>

<!-- Modal Tambah Flowmeter-->
<div class="modal fade" id="modalFlowmeter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Flowmeter</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:simpan();" class="fDataFlowmeter" id="fData" name="fDataFlowmeter">
            <div class="form-group">
              <label for="KPE_KWH_FLOWMETER_NAMA">Flowmeter</label>
              <input type="text" class="form-control" id="KPE_KWH_FLOWMETER_NAMA" name="KPE_KWH_FLOWMETER_NAMA" placeholder="KPE_KWH_FLOWMETER_NAMA">
              
              <input type="hidden" class="form-control" id="KPE_KWH_FLOWMETER_ID" name="KPE_KWH_FLOWMETER_ID">

            </div>
            <!-- <div class="input_fields_wrap">
              <div id="newRow">
                
              </div>
            </div> -->
            <!-- <div class="form-group">
              <label for="KPE_KWH_SUB_FLOWMETER_ID">Sub Flowmeter :</label>
              <select id="KPE_KWH_SUB_FLOWMETER_ID" name="KPE_KWH_SUB_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true">
                <option value="" selected="selected">--Pilih--</option>
                <?php
                  foreach($sub['result'] as $r){  
                    echo "<option value='$r[KPE_KWH_SUB_FLOWMETER_ID]'>$r[KPE_KWH_SUB_FLOWMETER_NAMA]</option>";  
                  }                  
                ?>
              </select>
            </div> -->
            <div class="form-group">
              <label for="KPE_KWH_FLOWMETER_LOKASI">Lokasi</label>
              <input type="text" class="form-control" id="KPE_KWH_FLOWMETER_LOKASI" name="KPE_KWH_FLOWMETER_LOKASI" placeholder="KPE_KWH_FLOWMETER_LOKASI" >
            </div>
            <div class="form-group">
              <label for="KPE_KWH_FLOWMETER_READING">Reading</label>
              <input type="number" class="form-control" id="KPE_KWH_FLOWMETER_READING" name="KPE_KWH_FLOWMETER_READING" placeholder="KPE_KWH_FLOWMETER_READING" autocomplete="off">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <!-- <button type="button" class="addFlowDept btn btn-primary" name="addFlowDept" id="addFlowDept" data-placement="top" title="Add">
                <span class="fa fa-plus"></span>
              </button> -->
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

$(function(){
  tampil('1');
});	

$('.btnFlowmeter').on('click', function(){
  $("#modalFlowmeter").modal('show');
  $('.selectpicker').selectpicker("val","");
  $('form#fData')[0].reset();
})

function simpan()
{
  const fData=$("#fData").serialize();
  const data = "&"+fData;
  // const data = "&KPE_KWH_SUB_FLOWMETER_NAMA="+btoa($("#KPE_KWH_SUB_FLOWMETER_ID").children("option:selected").text())+"&"+fData;
  // console.log(data);
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_flowmeter_kwh'+data,
    success:function(data)
    { 
      $('tfoot#zone_total').empty();
      if(data.respon.pesan=="sukses")
      {
        Swal.fire({
          timer: 1200,
          timerProgressBar: true,
          title: 'Berhasil!',
          text: ''+data.respon.text_msg+'',
          icon: 'success',
        })
        $("#modalFlowmeter").modal('hide');
        $('.selectpicker').selectpicker("val","");
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        Swal.fire({
          title: 'Gagal',
          text: ''+data.respon.text_msg+'',
          icon: 'error'
        })
      }
    },
    error:function(x,e){
      // error_handler_json(x,e,'=> hapus_catatan()');
      console.log('error')
    }//end error
  });
     
}


$('tbody').on('click', 'a.edit', function(){
  $("#newRow").empty();
  var KPE_KWH_FLOWMETER_ID = $(this).attr('KPE_KWH_FLOWMETER_ID');
  var KPE_KWH_FLOWMETER_NAMA = $(this).attr('KPE_KWH_FLOWMETER_NAMA');
  var KPE_KWH_FLOWMETER_LOKASI = $(this).attr('KPE_KWH_FLOWMETER_LOKASI');
  var KPE_KWH_FLOWMETER_READING = $(this).attr('KPE_KWH_FLOWMETER_READING');
  $("#modalFlowmeter").modal('show');
  $('input#KPE_KWH_FLOWMETER_NAMA').val(KPE_KWH_FLOWMETER_NAMA);
  $('input#KPE_KWH_FLOWMETER_LOKASI').val(KPE_KWH_FLOWMETER_LOKASI);
  $('input#KPE_KWH_FLOWMETER_ID').val(KPE_KWH_FLOWMETER_ID);
  $('input#KPE_KWH_FLOWMETER_READING').val(KPE_KWH_FLOWMETER_READING);
});

$(window).on('hashchange', function(e) {
  tampil('1');
});

$("input#REC_PER_HALAMAN").on('change', function() {
  tampil('1');
});

function tampil(curPage)
{
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
    data:'aplikasi=<?php echo $d0;?>&ref=list_kwh_flowmeter&keyword='+$("input#keyword").val()+'&KPE_KWH_FLOWMETER_NAMA='+$("select#KPE_KWH_FLOWMETER_NAMA").val()+'&KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='+$("select#KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
    success: function(data) {
			// console.log(data.tes);
			// console.log(data.result);
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_data").empty();
        $('#tujuan-light-pagination').pagination({
          pages: data.result_option.jml_halaman,
          cssStyle: 'light-theme',
          currentPage: curPage,
        });
          for (i = 0; i < data.result.length; i++) {
            $("tbody#zone_data").append(/*html*/
            `<tr class='bordered trData'>
              <td  class='bordered'>${data.result[i].NO}.</td> 
              <td class='bordered text-center'>
                <div class='btn-group'>
                  <button type='button' class='btn btn-success btn-xs'>
                    <i class='fa fa-eye'></i>
                  </button>
                  <button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>
                    <i class='caret'></i>
                  </button>
                  <ul class='dropdown-menu'>
                    <li><a class='edit' style='color:rgb(0, 48, 73);' KPE_KWH_FLOWMETER_ID='${data.result[i].KPE_KWH_FLOWMETER_ID}' KPE_KWH_FLOWMETER_NAMA='${data.result[i].KPE_KWH_FLOWMETER_NAMA}' KPE_KWH_FLOWMETER_LOKASI='${data.result[i].KPE_KWH_FLOWMETER_LOKASI}' KPE_KWH_FLOWMETER_READING='${data.result[i].KPE_KWH_FLOWMETER_READING}'><i class='fa fa-edit'></i>Edit</a></li>
                    <li><a class='hapus' style='color:brown;' KPE_KWH_FLOWMETER_ID='${data.result[i].KPE_KWH_FLOWMETER_ID}'><i class='fa fa-trash'></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
              <td class='bordered'>${data.result[i].KPE_KWH_FLOWMETER_NAMA}</td> 
              <td class='bordered'>${data.result[i].KPE_KWH_FLOWMETER_LOKASI}</td> 
              <td class='bordered'>${data.result[i].KPE_KWH_FLOWMETER_READING}</td> 
            </tr>`);
          }

      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_data").html("<tr><td colspan='6'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> list_kwh_flowmeter()');
    } //end error
  });
}

$('tbody').on('click', 'a.hapus', function(){
  let KPE_KWH_FLOWMETER_ID = $(this).attr('KPE_KWH_FLOWMETER_ID');

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
        data:'aplikasi=<?php echo $d0;?>&ref=hapus_kwh_flowmeter&KPE_KWH_FLOWMETER_ID='+KPE_KWH_FLOWMETER_ID,
        success:function(data)
        { 
          if(data.respon.pesan=="sukses")
          {
            Swal.fire({
              timer: 1000,
              timerProgressBar: true,
              title: 'Terhapus!',
              text: ''+data.respon.text_msg+'',
              icon: 'success',
            })
            tampil('1');
            
          }else if(data.respon.pesan=="gagal")
          {
            Swal.fire({
              timer: 1000,
              timerProgressBar: true,
              title: 'Gagal!',
              text: ''+data.respon.text_msg+'',
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
})

function search(){
	tampil('1');
}
</script>