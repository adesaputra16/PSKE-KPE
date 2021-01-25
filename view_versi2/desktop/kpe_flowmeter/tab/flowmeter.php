<?php 
$input_option=array();
$params_sub=array(
//'case'=>"presensi_lembur_spl_pdf_nonlogin",
'case'=>"nonlogin_ambil_sub_flowmeter",
'batas'=>100,
'halaman'=>1,
'data_http'=>$_COOKIE['data_http'],
'input_option'=>$input_option,
);
$params_flow=array(
//'case'=>"presensi_lembur_spl_pdf_nonlogin",
'case'=>"nonlogin_ambil_daftar_flowmeter",
'batas'=>100,
'halaman'=>1,
'data_http'=>$_COOKIE['data_http'],
'input_option'=>$input_option,
);
//$respon=$WO_MASTER->wo($params)->load->module;
$sub = $KPE->kpe_modules($params_sub)->load->module;
$flow = $KPE->kpe_modules($params_flow)->load->module;
//print json_encode($respon);
// $no=1;
// foreach($respon['result'] as $r){
// $detail_records .='<tr height="'.$height.'">
//             <td valign="top" align="right"  height="'.$height.'">'.$no.'.</td>
//             <td valign="top" >'.$r['KPE_AIR_FLOWMETER_NAMA'].'</td>
//             <td valign="top" >'.$r['KPE_AIR_FLOWMETER_LOKASI'].'</td>
//                       </tr>';
//                       $no++;
// }


// echo "<pre>".print_r($respon,true)."</pre>";
// exit();

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

table.table-bodered, .bordered{
  border:1px solid #ccc !important;
}

tr.trData:hover{
  background:rgba(250, 240, 202,0.5) !important;
}

</style>

<div class="box-body">
  <button type="button" class="btn btn-sm btn-success btnFlowmeter"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Flowmeter</button>
  <button type="button" class="btn btn-sm btn-info btnFlowmeterDept">Flowmeter Departemen</button>
  <!-- <div class="pull-right">
    <button type="button" class="btn btn-sm btn-primary" id="btn-reload"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
    <a href=""  type="button" id="cetakPdf" class="btn btn-sm btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a> 
  </div> -->
  <br><br>

  <!-- Pencarian -->
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="KPE_AIR_FLOWMETER_NAMA">Flowmeter :</label>
        <select id="KPE_AIR_FLOWMETER_NAMA" name="KPE_AIR_FLOWMETER_NAMA" class="form-control">
          <option value="">--Pilih--</option>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="subFlowmeter">Sub Flowmeter :</label>
        <select id="subFlowmeter" name="subFlowmeter" class="form-control">
          <option value="">--Pilih--</option>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="lokasiFlowmeter">Lokasi :</label>
        <select id="lokasiFlowmeter" name="lokasiFlowmeter" class="form-control">
          <option value="">--Pilih--</option>
        </select>
      </div>
    </div>
  </div>
  <!-- end pencarian -->

  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="bordered">
                <tr class="bordered">
                  <th class="bordered">No.</th>
                  <th class="bordered text-center">Aksi</th>
                  <th class="bordered">Flowmeter</th>
                  <th class="bordered">Sub Flowmeter</th>
                  <th class="bordered">Lokasi</th>
                  <th class="bordered">Distribusi</th>
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
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
    </div>
  </div>
</div>

<!-- Modal Flow Departemen-->
<div class="modal fade" id="modalFlowDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="judulFlowDept"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" id="formTambahFlowDept">
            <form action="javascript:simpanFlowDept();" class="fDataFlowDept" id="fDataFlowDept" name="fDataFlowDept" >
              <div class="form-group">
                <label for="KPE_AIR_FLOWMETER_NAMA_DEPT">Flowmeter</label>
                <select id="KPE_AIR_FLOWMETER_NAMA_DEPT" name="KPE_AIR_FLOWMETER_NAMA" class="form-control selectpicker" data-live-search="true" required>
                  <option value="">--Pilih--</option>
                  <?php 
                    foreach ($flow['result'] as $rf) {
                      echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>";  
                    }
                  ?>
                </select>

                <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" name="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" value="">

              </div>
              <div class="form-group input_fields_wrap">
                <div id="newRow"></div>
              </div>
              <div class="form-group">
                <label for="KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE">Periode</label>
                <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE" name="KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE" placeholder="<?= Date('Y-m')?>" autocomplete="off" value="<?= Date('Y-m')?>">
              </div>
              <div class="modal-footer" id="divFlowDept">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="addFlowDept btn btn-primary" name="addFlowDept" id="addFlowDept" data-placement="top" title="Add">
                  <span class="fa fa-plus"></span>
                </button>
                <button id="simpan" type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
            <div class="modal-footer" id="divFlowDepts">
              <button id="tambahFlowDept" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Baru</button>
              <button id="editFlowDept" type="button" class="btn btn-success" onclick="list_flowmeter_departemen();"><i class="fa fa-edit"></i> Edit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit Flow Dept -->
<div class="modal fade" id="modalEditFlowDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:110000;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="">Edit Flowmeter Departemen</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                  <tr class="bordered">
                    <th class="bordered text-center" width="30">NO</th>
                    <th class="bordered text-center">Flowmeter</th>
                    <th class="bordered text-center">Tanggal</th>
                    <th class="bordered text-center">#</th>
                  </tr>
                </thead>
                <tbody id="ZONE_DATA_EDIT_FLOW_DEPT">
                  <tr>
                    <td class="backloader" colspan="4">
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
    </div>
  </div>
</div>
<!-- End Modal -->

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
              <label for="KPE_AIR_FLOWMETER_NAMA">Flowmeter</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_NAMA_ID" name="KPE_AIR_FLOWMETER_NAMA" placeholder="KPE_AIR_FLOWMETER_NAMA">
              
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID">

            </div>
            <!-- <div class="input_fields_wrap">
              <div id="newRow">
                
              </div>
            </div> -->
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_SUB_ID">Sub Flowmeter :</label>
              <select id="KPE_AIR_FLOWMETER_SUB_ID" name="KPE_AIR_FLOWMETER_SUB_ID" class="form-control selectpicker" data-live-search="true">
                <option value="" selected="selected">--Pilih--</option>
                <?php
                  foreach($sub['result'] as $r){  
                    echo "<option value='$r[KPE_AIR_FLOWMETER_SUB_ID]'>$r[KPE_AIR_FLOWMETER_SUB_NAMA]</option>";  
                  }                  
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_LOKASI">Lokasi</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_LOKASI" name="KPE_AIR_FLOWMETER_LOKASI" placeholder="KPE_AIR_FLOWMETER_LOKASI" >
            </div>
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_DISTRIBUSI">Distribusi</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DISTRIBUSI" name="KPE_AIR_FLOWMETER_DISTRIBUSI" placeholder="KPE_AIR_FLOWMETER_DISTRIBUSI">
            </div>
            <div class="form-group KPE_AIR_FLOWMETER_PERIODE" style="display:none;">
              <label for="KPE_AIR_FLOWMETER_PERIODE">Periode</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_PERIODE" name="KPE_AIR_FLOWMETER_PERIODE" value="<?= Date("Y-m"); ?>">
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
  $('.selectpicker').selectpicker();
  $("input#KPE_AIR_FLOWMETER_DEPARTEMEN_TANGGAL").datepicker().on('changeDate', function(ev)
  {  
    $('.datepicker').datepicker('hide');
  });
});	

$('.btnFlowmeter').on('click', function(){
  $("#modalFlowmeter").modal('show');
  $('.selectpicker').selectpicker("val","")
  $('#newRow').empty();
  $('#KPE_AIR_FLOWMETER_NAMA_ID').val('');
  $('#KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA').val('');
  $('#KPE_AIR_FLOWMETER_SUB_NAMA').val('');
  $('#KPE_AIR_FLOWMETER_SUB_ID').val('');
  $('#KPE_AIR_FLOWMETER_LOKASI').val('');
  $('#KPE_AIR_FLOWMETER_ID').val('');
  $('#KPE_AIR_FLOWMETER_DISTRIBUSI').val('');
})

function simpan()
{
  var fData=$("#fData").serialize();
  var data = "&KPE_AIR_FLOWMETER_SUB_NAMA="+btoa($("#KPE_AIR_FLOWMETER_SUB_ID").children("option:selected").text())+"&"+fData
  // alert(KPE_AIR_FLOWMETER_SUB_NAMA);
  // alert(data)
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_flowmeter'+data,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        $("#modalFlowmeter").modal('hide');
        $('.selectpicker').selectpicker("val","");
        alert(data.respon.text_msg);
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        tampil('1');
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_flowmeter()');
    }//end error
  });
}


$('tbody').on('click', 'a.edit', function(){
  $("#newRow").empty();
  var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
  var KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
  var KPE_AIR_FLOWMETER_LOKASI = $(this).attr('KPE_AIR_FLOWMETER_LOKASI');
  var KPE_AIR_FLOWMETER_DISTRIBUSI = $(this).attr('KPE_AIR_FLOWMETER_DISTRIBUSI');
  var KPE_AIR_FLOWMETER_SUB_ID = $(this).attr('KPE_AIR_FLOWMETER_SUB_ID');
  var KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA');
  // console.log(KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
  var arr = KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA.split(",");
  // console.log(arr);
  if (arr == "") {
    $("#newRow").empty();
  } else {
    for (var d = 0; d < arr.length; d++) {
      $('#newRow').append( /*html*/`<div id="inputFormRow" class="form-group">
                                      <label>Departemen</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" name="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA[]" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" step="any" value="${arr[d]}">
                                        <span class="input-group-btn">
                                        <button attrid="1" type="button" class="removeFlowDept btn btn-danger" name="removeFlowDept" id="removeFlowDept" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button>
                                        </span>
                                      </div>
                                    </div>`);
    }
  }
  $("#modalFlowmeter").modal('show');
  $('input#KPE_AIR_FLOWMETER_NAMA_ID').val(KPE_AIR_FLOWMETER_NAMA);
  $('input#KPE_AIR_FLOWMETER_LOKASI').val(KPE_AIR_FLOWMETER_LOKASI);
  $('input#KPE_AIR_FLOWMETER_ID').val(KPE_AIR_FLOWMETER_ID);
  $('select#KPE_AIR_FLOWMETER_SUB_ID').selectpicker("val",KPE_AIR_FLOWMETER_SUB_ID);
  $('input#KPE_AIR_FLOWMETER_DISTRIBUSI').val(KPE_AIR_FLOWMETER_DISTRIBUSI);
});

$(window).on('hashchange', function(e) {
  tampil('1');
});
$("input#REC_PER_HALAMAN").on('change', function() {
  tampil('1');
});
$("select#KPE_AIR_FLOWMETER_NAMA_ID").on('change', function() {
  tampil('1');
});
$("select#lokasiFlowmeter").on('change', function() {
  tampil('1');
});
$("select#subFlowmeter").on('change', function() {
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
    data:'aplikasi=<?php echo $d0;?>&ref=tampil_flowmeter&keyword='+$("input#keyword").val()+'&idFlowmeter='+$("select#KPE_AIR_FLOWMETER_NAMA").val()+'&lokasiFlowmeter='+$("select#lokasiFlowmeter").val()+'&subFlowmeter='+$("select#subFlowmeter").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
    success: function(data) {
			// console.log(data.result);
      if (data.respon.pesan == "sukses") {
        $("tbody#zone_data").empty();
        $('#tujuan-light-pagination').pagination({
          pages: data.result_option.jml_halaman,
          cssStyle: 'light-theme',
          currentPage: curPage,
        });
          for (i = 0; i < data.result.length; i++) {
            if (data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA == '') {
              var KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = '';
            } else {
              KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA += JSON.parse(data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
            }
            $("tbody#zone_data").append("<tr class='bordered trData'>" + "<td  class='bordered'>" + data.result[i].NO + ".</td>" +
            "<td class='bordered text-center'>"+
              "<div class='btn-group'>"+
                "<button type='button' class='btn btn-success btn-xs'>"+
                  "<i class='fa fa-eye'></i>"+
                "</button>"+
                "<button type='button' class='btn btn-default btn-xs dropdown-toggle' data-toggle='dropdown'>"+
                  "<i class='caret'></i>"+
                "</button>"+
                "<ul class='dropdown-menu'>"+
                  "<li><a class='edit' KPE_AIR_FLOWMETER_ID='" + data.result[i].KPE_AIR_FLOWMETER_ID + "' KPE_AIR_FLOWMETER_NAMA='" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "' KPE_AIR_FLOWMETER_DISTRIBUSI='" + data.result[i].KPE_AIR_FLOWMETER_DISTRIBUSI + "' KPE_AIR_FLOWMETER_SUB_ID='" + data.result[i].KPE_AIR_FLOWMETER_SUB_ID + "' KPE_AIR_FLOWMETER_LOKASI='" + data.result[i].KPE_AIR_FLOWMETER_LOKASI + "' KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA='" + KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA +"'><i class='fa fa-edit'></i>Edit</a></li>"+
                  "<li><a class='hapus' KPE_AIR_FLOWMETER_ID='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'><i class='fa fa-trash'></i>Hapus</a></li>"+
                "</ul>"+
              "</div>"+
            "</td>"+
            "<td class='bordered'>" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "</td>" +
            "<td class='bordered'>" + data.result[i].KPE_AIR_FLOWMETER_SUB_NAMA + "</td>" +
            "<td class='bordered'>" + data.result[i].KPE_AIR_FLOWMETER_LOKASI + "</td>" +
            "<td class='bordered'>" + data.result[i].KPE_AIR_FLOWMETER_DISTRIBUSI + "</td>" +
            "</tr>");
          }

      } else if (data.respon.pesan == "gagal") {
        $("tbody#zone_data").html("<tr><td colspan='6'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
      }
    }, //end success
    error: function(x, e) {
      error_handler_json(x, e, '=> tampil_flowmeter()');
    } //end error
  });
}

function ambil_flowmeter()
{
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=ambil_daftar_flowmeter',
    success: function(data) {
			//console.log("List");
      if (data.respon.pesan == "sukses") 
      {
        for (i = 0; i < data.result.length; i++) {
          $("select#KPE_AIR_FLOWMETER_NAMA").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "</option>");
          // $("select#KPE_AIR_FLOWMETER_NAMA_DEPT").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "</option>");
          $("select#lokasiFlowmeter").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_LOKASI + "</option>");
          $("select#subFlowmeter").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_SUB_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_SUB_NAMA + "</option>");
        }
      }else
      {}
    }
  })
}

function ambil_subflowmeter()
{
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=ambil_sub_flowmeter',
    success: function(data) {
			//console.log("List");
      if (data.respon.pesan == "sukses") 
      {
        // for (i = 0; i < data.result.length; i++) {
        //   $("select#KPE_AIR_FLOWMETER_SUB_ID").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_SUB_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_SUB_NAMA + "</option>");
        // }
      }else
      {
      }
    }
  })
}

$('tbody').on('click', 'a.hapus', function(){
  var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
  if (confirm('Yakin akan menghapus data ini??')){
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=hapus_flowmeter&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        {
          alert(data.respon.text_msg);
          tampil('1');
          
        }else if(data.respon.pesan=="gagal")
        {
          alert(data.respon.text_msg);
          tampil('1');
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> hapus_flowmeter()');
      }//end error
    });
  }
})

$('#cetakPdf').on('click', function(){
  //tampil();
  // var tanggalMulai = $('input#tanggalMulai').val();
  // var tanggalAkhir = $('input#tanggalAkhir').val();
  var KPE_AIR_FLOWMETER_NAMA = $("#KPE_AIR_FLOWMETER_NAMA").children("option:selected").val();
  var lokasiFlowmeter = $("#lokasiFlowmeter").children("option:selected").val();
  // //alert(tanggalMulai);
  window.open('?show=kpe/pdf/cetak_flowmeter/'+KPE_AIR_FLOWMETER_NAMA+'/'+lokasiFlowmeter+'', '_blank');
  //window.open('?show=kpe/pdf/cetak_flowmeter/', '_blank');
})

$('#btn-reload').on('click', function(){
  $('select#KPE_AIR_FLOWMETER_NAMA').val('')
  $('select#lokasiFlowmeter').val('')
  $('select#subFlowmeter').val('')
  tampil('1');
})

$(function() {
  ambil_flowmeter();
  tampil('1');
  ambil_subflowmeter();
});

function search(){
	tampil('1');
}

$('.btnFlowmeterDept').on('click', function(){
  $(".selectpicker").selectpicker("val","");
  $("#modalFlowDept").modal('show');
  $("#judulFlowDept").empty();
  $("#judulFlowDept").append('<h4 class="modal-title" id="judulFlowDept">Flowmeter Departemen</h4>');
  $('#fDataFlowDept').attr("style", "display:none");
  $('#divFlowDept').attr("style", "display:none");
  $('#divFlowDepts').removeAttr("style");
})

$('#tambahFlowDept').on('click', function(){
  $(".selectpicker").selectpicker("val","");
  $("#judulFlowDept").empty();
  $("#judulFlowDept").append('<h4 class="modal-title" id="judulFlowDept">Tambah Flowmeter Departemen</h4>');
  $('#divFlowDepts').attr("style", "display:none");
  $('#fDataFlowDept').removeAttr("style");
  $('#divFlowDept').removeAttr("style");
  $('#newRow').empty();
  $('select#KPE_AIR_FLOWMETER_NAMA_DEPT').val('');
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val('');
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA').val('');
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_TANGGAL').val('');
  $('select#KPE_AIR_FLOWMETER_NAMA').removeAttr("disabled");
})

$('#editFlowDept').on('click', function(){
  $('#modalEditFlowDept').modal('show')
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA').val('');
  $('#newRow').empty();
})

$('tbody').on('click', 'a#pilihFlowDept', function(){
  list_flowmeter_departemen();
  var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
  var KPE_AIR_FLOWMETER_DEPARTEMEN_ID = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_ID');
  var KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE');
  var KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
  var KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA');
  // console.log(KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
  var arr = KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA.split(",");

  for (let d = 0; d < arr.length; d++) {
    $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group">
                                    <label>Departemen</label>
                                    <div class="input-group">
                                    <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" name="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA[]" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" step="any" value="${arr[d]}">
                                      <span class="input-group-btn">
                                      <button attrid="1" type="button" class="removeFlowDept btn btn-danger" name="removeFlowDept" id="removeFlowDept" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button>
                                      </span>
                                    </div>
                                  </div>`);
  }

  $("#judulFlowDept").empty();
  $("#judulFlowDept").append('<h4 class="modal-title" id="judulFlowDept">Edit Flowmeter Departemen</h4>');
  $("#modalEditFlowDept").modal('hide');
  $('#fDataFlowDept').removeAttr("style");
  $('#divFlowDept').removeAttr("style");
  $('#divFlowDepts').attr("style", "display:none");
  $('select#KPE_AIR_FLOWMETER_NAMA_DEPT').val(KPE_AIR_FLOWMETER_ID);
  // $("select#KPE_AIR_FLOWMETER_NAMA").children("option:selected").text(KPE_AIR_FLOWMETER_NAMA);
  // console.log(KPE_AIR_FLOWMETER_ID+'---'+KPE_AIR_FLOWMETER_NAMA);
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val(KPE_AIR_FLOWMETER_DEPARTEMEN_ID);
  $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE').val(KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE);
  // $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA').val(KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
  // $('select#KPE_AIR_FLOWMETER_NAMA').attr('disabled','disabled');
  // $('option:not(:selected)').attr('disabled', true);
});

function tambahNol(x){
   y=(x>9)?x:'0'+x;
   return y;
}


  var max_fields      = 100;
  var x = 1;
  $('button#addFlowDept').click(function () {
    // console.log('ada');
    if(x < max_fields){
      x++;
      $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group">
                                      <label>Departemen</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" name="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA[]" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" step="any">
                                        <span class="input-group-btn">
                                        <button attrid="1" type="button" class="removeFlowDept btn btn-danger" name="removeFlowDept" id="removeFlowDept" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button>
                                        </span>
                                      </div>
                                    </div>`);
    } 
  })


// remove row
$(document).on('click', 'button#removeFlowDept', function () {
    $(this).closest('#inputFormRow').remove();
});

function simpanFlowDept(){
  var fData = $("#fDataFlowDept").serialize();
  var data = "&KPE_AIR_FLOWMETER_NAMAS="+btoa($("#KPE_AIR_FLOWMETER_NAMA_DEPT").children("option:selected").text())+"&"+fData
  // alert(data)
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_flowmeter_departemen'+data,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        $("#modalFlowDept").modal('hide');
        alert(data.respon.text_msg);
        $(".selectpicker").selectpicker("val","");
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        tampil('1');
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_flowmeter()');
    }//end error
  });
}

function list_flowmeter_departemen() 
  {
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_flowmeter_departemen',
      success:function(data)
      { 
        console.log(data.result);
        $('tbody#ZONE_DATA_EDIT_FLOW_DEPT').empty();
        for (var i = 0; i < data.result.length; i++) {
          $('tbody#ZONE_DATA_EDIT_FLOW_DEPT').append(/*html*/`<tr class="bordered trData">
                                                              <td class="bordered">${data.result[i].NO}</td>
                                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                                              <td class="bordered text-center">${data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE}</td>
                                                              <td class="bordered text-center">
                                                                <a id="pilihFlowDept" type="button" class="btn btn-xs btn-info" KPE_AIR_FLOWMETER_ID="${data.result[i].KPE_AIR_FLOWMETER_ID}" KPE_AIR_FLOWMETER_DEPARTEMEN_ID="${data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_ID}" KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="${JSON.parse(data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA)}" KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE="${data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE}" KPE_AIR_FLOWMETER_NAMA="${data.result[i].KPE_AIR_FLOWMETER_NAMA}">Pilih</a>
                                                                <a id="hapusFlowDept" type="button" class="btn btn-xs btn-danger" KPE_AIR_FLOWMETER_DEPARTEMEN_ID="${data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_ID}">Hapus</a>
                                                              </td>
                                                             </tr>`);    
        }
        
      },
      error:function(x,e){
        alert('error');
      }//end error
    });
  }

  $('tbody').on('click', 'a#hapusFlowDept', function(){
    var KPE_AIR_FLOWMETER_DEPARTEMEN_ID = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_ID');
  // alert(KPE_AIR_FLOWMETER_KALIBRASI_ID);
  if (confirm('Yakin akan menghapus data ini??')){
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=hapus_flowmeter_departemen&KPE_AIR_FLOWMETER_DEPARTEMEN_ID='+KPE_AIR_FLOWMETER_DEPARTEMEN_ID,
      success:function(data)
      { 
        $('tfoot#zone_total').empty();
        if(data.respon.pesan=="sukses")
        {
          $("#modalEditFlowDept").modal('hide');
          alert(data.respon.text_msg);  
          tampil('1');
          
        }else if(data.respon.pesan=="gagal")
        {
          alert(data.respon.text_msg);
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

</script>