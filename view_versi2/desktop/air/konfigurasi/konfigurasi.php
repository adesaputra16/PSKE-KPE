<?php
  $input_option=array();
  $params=array(
    //'case'=>"presensi_lembur_spl_pdf_nonlogin",
    'case'=>"nonlogin_ambil_daftar_flowmeter",
    'batas'=>10,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option,
  );
  //$respon=$WO_MASTER->wo($params)->load->module;
  $respon_flow = $KPE->kpe_modules($params)->load->module;

  $input_option_personil=array();
  $params_personil=array(
    //'case'=>"presensi_lembur_spl_pdf_nonlogin",
    'case'=>"nonlogin_list_personil_departemen",
    'batas'=>10,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option_personil,
  );
  //$respon=$WO_MASTER->wo($params)->load->module;
  $respon_flow_personil = $KPE->kpe_modules($params_personil)->load->module;
?>  

<link rel="stylesheet" href="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.css">
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

.swal2-container {
  z-index: 100005;
}

.swal2-popup {
  font-size: 1.3rem !important; 
}
</style>
  
  <!-- List data Flowmeter departemen dan Form -->
  <div class="row">
    <!-- Flowmeter departemen -->
    <div class="col-md-7">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-code-fork" aria-hidden="true"></i> Flowmeter Departemen</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                    <th width="" class="text-center">No</th>
                    <th width="" class="text-center">#</th>
                    <th width="" class="text-center">Flowmeter Nama</th>
                    <th width="" class="text-center">Departemen Nama</th>
                  </tr>
              </thead>
              <tbody id="zoneDataDept">
                <tr> 
                  <td class="backloader" colspan="20">
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
    <!-- End flowmeter departemen -->

    <!-- Form departemen -->
    <div class="col-md-5">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> Form departemen</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <form action="javascript:simpanDepartemen();" class="fDataDept" id="fDataDept" name="fDataDept" >
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
                  <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
                    <option value="">--Pilih--</option>
                    <?php 
                      foreach ($respon_flow['result'] as $rf) {
                        echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>";  
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN" name="KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN" step="any">
                </div>
                <div class="form-group input_fields_wrap">
                  <div id="newRow"></div>
                </div>
                <div class="pull-right">
                  <button id="resetDept" type="button" class="btn btn-danger">Reset</button>
                  <button type="button" class="addFlowDept btn btn-primary" name="addFlowDept" id="addFlowDept" data-placement="top" title="Add">
                    <span class="fa fa-plus"></span>
                  </button>
                  <button id="simpan" type="submit" class="btn btn-success">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End form departemen -->
  </div>
  <!-- End flowmeter & form -->

  <!-- List data personil departemen dan form personil -->
  <div class="row">
    <!-- personil departemen -->
    <div class="col-md-7">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-users" aria-hidden="true"></i> Personil Departemen</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <!-- <th class="text-center">#</th> -->
                    <th class="text-center">Flowmeter Nama</th>
                    <th class="text-center">Departemen Nama</th>
                    <th class="text-center">Personil Departemen</th>
                    <th class="text-center">Total Personil</th>
                    <th class="text-center">(%)</th>
                    <th class="text-center">Hasil</th>
                    <th class="text-center">Aksi</th>
                  </tr>
              </thead>
              <tbody id="zoneDataPersonil">
                <tr> 
                  <td class="backloader" colspan="20">
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
    <!-- End personal departemen -->

    <!-- Form personil -->
    <div class="col-md-5">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-user-plus" aria-hidden="true"></i> Form personil</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
        <div class="row">
            <div class="col-md-12">
              <form action="javascript:simpanPersonil();" class="fDataPersonil" id="fDataPersonil" name="fDataPersonil">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_ID_PERSONIL">Flowmeter</label>
                  <select id="KPE_AIR_FLOWMETER_ID_PERSONIL" name="KPE_AIR_FLOWMETER_ID_PERSONIL" class="form-control selectpicker" data-live-search="true" onchange="listDept()" required width="100%">
                    <option value="" >--Pilih--</option>
                    <?php 
                      foreach ($respon_flow_personil['result'] as $rf) {
                        echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_DEPARTEMEN_ID">Departemen</label>
                  <select id="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" name="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" class="form-control" required>
                  <option value="" >--Pilih--</option>
                  </select>
                </div>
                <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID" name="KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID">
                <div class="row formulaFlowDept"> 
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="PERSONIL_DEPARTEMEN">Personil</label>
                      <input type="number" class="form-control" id="PERSONIL_DEPARTEMEN" name="PERSONIL_DEPARTEMEN" autocomplete="off" placeholder="PERSONIL_DEPARTEMEN" step="any">
                    </div>
                  </div>
                  <!-- <div class="col-sm-1">
                    <span class="text-center"><h2>/</h2></span>
                  </div> -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="TOTAL_PERSONIL">Total Personil</label>
                      <input type="number" class="form-control" id="TOTAL_PERSONIL" name="TOTAL_PERSONIL" autocomplete="off" placeholder="TOTAL_PERSONIL" step="any">
                    </div>
                  </div>
                  <!-- <div class="col-sm-1">
                    <span class="text-center"><h2>*</h2></span>
                  </div> -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="PERSEN">Persen(%)</label>
                      <input type="number" class="form-control" id="PERSEN" name="PERSEN" autocomplete="off" placeholder="PERSEN(%)" step="any" value="100" readonly="on">
                    </div>
                  </div>
                </div>
                <div class="pull-right">
                  <button id="resetPersonil" type="button" class="btn btn-danger">Reset</button>
                  <button type="submit" class="btn btn-success" id="btnSimpanCatatan">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End form personil -->
  </div>
  <!-- End form personil -->

  <!-- List data kalibrasi -->
  <div class="row">
    <!-- kalibrasi flowmeter -->
    <div class="col-md-7">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-wrench" aria-hidden="true"></i> Kalibrasi Flowmeter</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Flowmeter Nama</th>
                    <th class="text-center">Tanggal Kalibrasi</th>
                    <th class="text-center">Real</th>
                    <th class="text-center">Selisih</th>
                    <th class="text-center">Persen</th>
                    <th class="text-center">Aksi</th>
                  </tr>
              </thead>
              <tbody id="zoneDataKalibrasi">
                <tr> 
                  <td class="backloader" colspan="20">
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
    <!-- End kalibrasi flowmeter -->

    <!-- Form kalibrasi -->
    <div class="col-md-5">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> Form kalibrasi</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <form action="javascript:simpanFlowKalibrasi();" class="fDataFlowKal" id="fDataFlowKal" name="fDataFlowKal" >
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_ID_KALIBRASI">Flowmeter</label>
                  <select id="KPE_AIR_FLOWMETER_ID_KALIBRASI" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
                  <option value="">--Pilih--</option>
                  <?php 
                    foreach ($respon_flow['result'] as $rf) {
                      echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
                    }
                  ?>
                  </select>

                  <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_ID" name="KPE_AIR_FLOWMETER_KALIBRASI_ID">

                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL">Tanggal</label>
                  <input type="text" class="form-control datepicker KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL" id="KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL" name="KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="KPE_AIR_FLOWMETER_KALIBRASI_REAL">Real</label>
                      <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_REAL" name="KPE_AIR_FLOWMETER_KALIBRASI_REAL" autocomplete="off" placeholder="ANGKA_REAL" step="any">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH">Selisih Std</label>
                      <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH" name="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH" autocomplete="off" placeholder="ANGKA_SELISIH" step="any">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN">Persen(%)</label>
                      <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN" name="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN" autocomplete="off" placeholder="PERSEN(%)" step="any">
                    </div>
                  </div>
                </div>
                <div class="pull-right">
                  <button id="resetKalibrasi" type="button" class="btn btn-danger">Reset</button>
                  <button id="simpanFlowKal" type="submit" class="btn btn-success">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End form kalibrasi -->
  </div>
  <!-- End kalibrasi dan form kalibrasi -->

<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.js"></script>
<script>

  $(function() {
    // $('a.sidebar-toggle').click();
    listFlowDept();
    listFlowDeptPersonil();
    listFlowmeterKalibrasi();
    $("input#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL").datepicker().on('changeDate', function(ev)
    {  
      $('.datepicker').datepicker('hide');
    });
  });

  function tambahNol(x){
    y=(x>9)?+x:'0'+x;
    return y;
  }

  function tambahKosong(x){
    // x.substr(2);
    var a = x.replace('.','');
    y=(x>9)?'0.'+a.substr(0,3): x < 9 ? '0.0'+a.substr(0,2) : '0.00'+x.substr(2);
    return y;
  }
  //?======================== SCRIPT FLOWMETER DEPARTEMEN =============================//
  //!===== Function list flowmeter departemen =====//
  function listFlowDept() {
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_flowmeter_departemen&KPE_AIR_FLOWMETER_ID=kosong',
      success: function(data) {
        // console.log(data.result);
        if (data.respon.pesan == "sukses") 
        {
          // console.log(data.result);
          $("tbody#zoneDataDept").empty();
          for (let i = 0; i < data.result.length; i++) {
            let listDataDept = '';
            let listDataDeptNama = '';
            let arr = JSON.parse(data.result[i].DEPT.KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
            for (let j = 0; j < arr.length; j++) {
              var rowspan = 1;
              rowspan += arr.length;
              listDataDeptNama += /*html*/`<tr>
                                            <td >${arr[j]}</td>
                                          </tr>`;
            }
            listDataDept += /*html*/`<tr>
                                      <td rowspan="${rowspan}">${data.result[i].NO}.</td>
                                      <td class="text-center" rowspan="${rowspan}">
                                        <button type="button" class="btn btn-sm btn-danger btnHapusFlowDept" data-toggle="tooltip" data-placement="top" title="Hapus Departemen" KPE_AIR_FLOWMETER_DEPARTEMEN_ID="${data.result[i].DEPT.KPE_AIR_FLOWMETER_DEPARTEMEN_ID}" KPE_AIR_FLOWMETER_ID="${data.result[i].DEPT.KPE_AIR_FLOWMETER_ID}" ><i class="fa fa-trash"> Hapus</i></button>
                                        <button type="button" class="btn btn-sm btn-primary btnEditFlowDept" data-toggle="tooltip" data-placement="top" title="Edit Departemen" KPE_AIR_FLOWMETER_DEPARTEMEN_ID="${data.result[i].DEPT.KPE_AIR_FLOWMETER_DEPARTEMEN_ID}" KPE_AIR_FLOWMETER_ID="${data.result[i].DEPT.KPE_AIR_FLOWMETER_ID}" KPE_AIR_FLOWMETER_NAMA="${data.result[i].DEPT.KPE_AIR_FLOWMETER_NAMA}" KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="${arr}"><i class="fa fa-edit"></i> Edit</button>
                                      </td>
                                      <td rowspan="${rowspan}">${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                    </tr>`;
            $("tbody#zoneDataDept").append(/*html*/`<tr>${listDataDept} ${listDataDeptNama}</tr>`);
          } 
        }else
        {
          $("tbody#zoneDataDept").html(/*html*/`<tr><td colspan="4"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      }
    })
  }
  /*===== End list flowmeter departemen =====*/

  /*===== Add row form departemen =====*/
  $('button#addFlowDept').click(function () {
      $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group">
                                      <label>Departemen</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" name="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA[]" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" step="any">
                                        <span class="input-group-btn">
                                        <button attrid="1" type="button" class="removeFlowDept btn btn-danger" name="removeFlowDept" id="removeFlowDept" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button>
                                        </span>
                                      </div>
                                    </div>`);
  })


  // remove row
  $(document).on('click', 'button#removeFlowDept', function () {
      $(this).closest('#inputFormRow').remove();
  });
  /*===== End row form departemen =====*/

  /*===== Button reset Form =====*/
  $('button#resetDept').click(function () {
      $('#newRow').empty();
      $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN').val('');
      $('#KPE_AIR_FLOWMETER_ID').selectpicker('val','');
  });
  /*===== End button reset Form =====*/

  /*===== Simpan Flowmeter Departemen =====*/
  function simpanDepartemen(){
    var fData = $("#fDataDept").serialize();
    var data = "&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID").children("option:selected").text())+"&"+fData
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
          Swal.fire({
            timer: 1500,
            timerProgressBar: true,
            title: 'Berhasil!',
            text: ''+data.respon.text_msg+'',
            icon: 'success',
          })
          $('#newRow').empty();
          $('#KPE_AIR_FLOWMETER_ID').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN').val("");
          listFlowDept();
          listFlowDeptPersonil();
          
        }else if(data.respon.pesan=="gagal")
        {
          Swal.fire({
            title: 'Gagal!',
            text: ''+data.respon.text_msg+'',
            icon: 'error',
          })
          $('#newRow').empty();
          $('#KPE_AIR_FLOWMETER_ID').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN').val("");
          listFlowDept();
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> simpan_flowmeter_departemen()');
      }//end error
    });
  }
  /*===== End Simpan Flowmeter Departemen =====*/

  /*===== Edit Flowmeter Departemen =====*/
  $('tbody').on('click', 'button.btnEditFlowDept', function(){
    $('#newRow').empty()
    let KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
    let KPE_AIR_FLOWMETER_DEPARTEMEN_ID = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_ID');
    let KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
    let KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA');
    // console.log(KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
    let arrDept = KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA.split(",");
    for (let d = 0; d < arrDept.length; d++) {
      $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group">
                                      <label>Departemen</label>
                                      <div class="input-group">
                                      <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" name="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA[]" autocomplete="off" placeholder="KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA" step="any" value="${arrDept[d]}">
                                        <span class="input-group-btn">
                                        <button attrid="1" type="button" class="removeFlowDept btn btn-danger" name="removeFlowDept" id="removeFlowDept" data-placement="top" title="Remove"><i class="fa fa-minus"></i></button>
                                        </span>
                                      </div>
                                    </div>`);
    }

    $('select#KPE_AIR_FLOWMETER_ID').selectpicker("val",KPE_AIR_FLOWMETER_ID);
    $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_ID_HIDDEN').val(KPE_AIR_FLOWMETER_DEPARTEMEN_ID);
  });
  /*===== End Edit Flowmeter Departemen =====*/

  /*===== Hapus Flowmeter Departemen =====*/
  $('tbody').on('click', 'button.btnHapusFlowDept', function(){
    let KPE_AIR_FLOWMETER_DEPARTEMEN_ID = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_ID');
    let KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_flowmeter_departemen&KPE_AIR_FLOWMETER_DEPARTEMEN_ID='+KPE_AIR_FLOWMETER_DEPARTEMEN_ID+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID,
          success:function(data)
          { 
            if(data.respon.pesan=="sukses")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Terhapus!',
                text: 'Data Berhasil Dihapus.',
                icon: 'success',
              })
              listFlowDept();
              listFlowDeptPersonil();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data Gagal Dihapus.',
                icon: 'error'
              })
              listFlowDept();
            }
          },
          error:function(x,e){
            error_handler_json(x,e,'=> hapus_flowmeter_departemen()');
            // alert('error')
          }//end error
        });
      }
    })
  })
  /*===== End Hapus Flowmeter Departemen =====*/
  //======================== END SCRIPT FLOWMETER DEPARTEMEN =============================//

  //======================== SCRIPT FLOWMETER DEPARTEMEN PERSONIL =============================//
  /*===== Function list flowmeter departemen personil =====*/
  function listFlowDeptPersonil() {
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_personil_departemen',
      success: function(data) {
        if (data.respon.pesan == "sukses") 
        {
          // console.log(data.result);
          $("tbody#zoneDataPersonil").empty();
          for (let i = 0; i < data.result.length; i++) {
            let listDataPersonil = '';
            let listDataPersonilNama = '';
            if (data.result[i].DEPT_FLOW == "") {
              var rowspan = 2;
              listDataPersonilNama += /*html*/`<tr>
                                                  <td >--</td>
                                                  <td >--</td>
                                                  <td >--</td>
                                                  <td >--</td>
                                                  <td >--</td>
                                                  <td >--</td>
                                                </tr>`;
            } else {
              rowspan =1 + data.result[i].DEPT_FLOW.length;
            }
            // var rowspan = 1 + rowCols;
            for (let j = 0; j < data.result[i].DEPT_FLOW.length; j++) {
              listDataPersonilNama += /*html*/`<tr>
                                                  <td >${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA}</td>
                                                  <td >${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL}</td>
                                                  <td >${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL}</td>
                                                  <td >${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN}</td>
                                                  <td >${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL}</td>
                                                  <td ><button type="button" class="btn btn-sm btn-primary btnEditPersonilDept" data-toggle="tooltip" data-placement="top" title="Edit Personil" KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID="${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID}" KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA="${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA}" KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL="${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL}" KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL="${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL}" KPE_AIR_FLOWMETER_ID="${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_ID}"><i class="fa fa-edit"></i></button></td>
                                                </tr>`;
            }
            listDataPersonil += /*html*/`<tr>
                                            <td rowspan="${rowspan}">${data.result[i].NO}.</td>
                                            <td rowspan="${rowspan}">${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                          </tr>`;
            $("tbody#zoneDataPersonil").append(/*html*/`<tr>${listDataPersonil} ${listDataPersonilNama}</tr>`);
          } 
        }else
        {
          $("tbody#zoneDataPersonil").html(/*html*/`<tr><td colspan="4"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      }
    })
  }
  /*===== End list flowmeter departemen personil =====*/

  /*===== Function list flowmeter departemen personil =====*/
  function listDept(flowmeter = $('#KPE_AIR_FLOWMETER_ID_PERSONIL').val()) {
    // flowmeter = $('#KPE_AIR_FLOWMETER_ID_PERSONIL').val();
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_departemen&KPE_AIR_FLOWMETER_ID='+flowmeter,
      success: function(data) {
        if (data.respon.pesan == "sukses") 
        {
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').empty()
          let deptNama = JSON.parse(data.result[0].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
          let nama = '';
          for (let i = 0; i < deptNama.length; i++) {
            nama += /*html*/`<option value="${deptNama[i]}">${deptNama[i]}</option>`;
          }
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').append(/*html*/`<option value="">--Pilih--</option>${nama}`);
        }
      }
    })
  }
  /*===== End list flowmeter departemen personil =====*/

  /*===== Function simpan flowmeter departemen personil =====*/
  function simpanPersonil() {
    let fData = $('#fDataPersonil').serialize();
    let persen = '';
    // if ($("#PERSONIL_DEPARTEMEN").val()/$("#TOTAL_PERSONIL").val()*$("#PERSEN").val() < 1) {
    //   persen = ($("#PERSONIL_DEPARTEMEN").val()/$("#TOTAL_PERSONIL").val()*$("#PERSEN").val()).toFixed(2);
    // } else {
      persen = tambahKosong(($("#PERSONIL_DEPARTEMEN").val()/$("#TOTAL_PERSONIL").val()*$("#PERSEN").val()).toFixed(2));
    // }
    // console.log(persen);
    // return
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:"aplikasi=<?php echo $d0;?>&ref=simpan_flow_dept&KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL="+persen+"&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID_PERSONIL").children("option:selected"). text())+"&KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="+btoa($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected"). text())+"&"+fData,
      success: function(data) {
        if(data.respon.pesan=="sukses")
        {
          Swal.fire({
            timer: 1500,
            timerProgressBar: true,
            title: 'Berhasil!',
            text: ''+data.respon.text_msg+'',
            icon: 'success',
          })
          $('#KPE_AIR_FLOWMETER_ID_PERSONIL').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val("");
          $("#PERSONIL_DEPARTEMEN").val('');
          $("#TOTAL_PERSONIL").val('');
          $("#KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID").val('');
          listFlowDeptPersonil();
          // console.log(data.result);
          
        }else if(data.respon.pesan=="gagal")
        {
          Swal.fire({
            title: 'Gagal!',
            text: ''+data.respon.text_msg+'',
            icon: 'error',
          })
          $('#KPE_AIR_FLOWMETER_ID_PERSONIL').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val("");
          $("#PERSONIL_DEPARTEMEN").val('');
          $("#TOTAL_PERSONIL").val('');
          $("#KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID").val('');
          listFlowDeptPersonil();
        }
      }
    })
  }
  /*===== End simpan flowmeter departemen personil =====*/

  /*===== Edit flowmeter departemen personil =====*/
  $('tbody').on('click', 'button.btnEditPersonilDept', function(){
    let KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID');
    let KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA');
    let KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL');
    let KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL = $(this).attr('KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL');
    let KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
    listDept(KPE_AIR_FLOWMETER_ID)
    // console.log(KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA);
    $('select#KPE_AIR_FLOWMETER_ID_PERSONIL').selectpicker("val",KPE_AIR_FLOWMETER_ID);
    $('input#KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID').val(KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID);
    $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val(KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA);
    $("#PERSONIL_DEPARTEMEN").val(KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL);
    $("#TOTAL_PERSONIL").val(KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL);
  });
  /*===== End Edit flowmeter departemen personil =====*/

  /*===== Button reset Form =====*/
  $('button#resetPersonil').click(function () {
      $('#PERSONIL_DEPARTEMEN').val('');
      $('#TOTAL_PERSONIL').val('');
      $('#KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID').val('');
      $('#KPE_AIR_FLOWMETER_DEPARTEMEN_ID').val('');
      $('#KPE_AIR_FLOWMETER_ID_PERSONIL').selectpicker('val','');
  });
  /*===== End button reset Form =====*/
  //======================== END SCRIPT FLOWMETER DEPARTEMEN PERSONIL =============================//

  //======================== SCRIPT FLOWMETER KALIBRASI =============================//
  /*===== List Flowmeter Kalibrasi =====*/
  function listFlowmeterKalibrasi() 
  {
    var KPE_AIR_FLOWMETER_NAMA = $("#KPE_AIR_FLOWMETER_KALIBRASI").children("option:selected").text();
    var KPE_AIR_FLOWMETER_ID = $("#KPE_AIR_FLOWMETER_KALIBRASI").val();
    var KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL = $("#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL").val();
    // alert(KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL)
    // return;
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_angka_flowmeter_kalibrasi&KPE_AIR_FLOWMETER_ID=0',
      success:function(data)
      { 
        // console.log(data.result);
        let listFlow = '';
        $('tbody#zoneDataKalibrasi').empty();
        for (let i = 0; i < data.result.length; i++) {
          $('tbody#zoneDataKalibrasi').append(/*html*/`<tr class="">
                                                        <td class="">${data.result[i].NO}</td>
                                                        <td class="">${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                                        <td class=" text-center">${data.result[i].TANGGAL}</td>
                                                        <td class=" text-center">${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_REAL}</td>
                                                        <td class=" text-center">${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_SELISIH}</td>
                                                        <td class=" text-center">${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_PERSEN}</td>
                                                        <td class=" text-center">
                                                          <a id="editFlowKal" type="button" class="btn btn-sm btn-primary" KPE_AIR_FLOWMETER_ID_KALIBRASI="${data.result[i].KPE_AIR_FLOWMETER_ID}" KPE_AIR_FLOWMETER_KALIBRASI_ID="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_ID}" KPE_AIR_FLOWMETER_KALIBRASI_PERSEN="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_PERSEN}" KPE_AIR_FLOWMETER_KALIBRASI_REAL="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_REAL}" KPE_AIR_FLOWMETER_KALIBRASI_SELISIH="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_SELISIH}" KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL}" KPE_AIR_FLOWMETER_NAMA="${data.result[i].KPE_AIR_FLOWMETER_NAMA}"><i class="fa fa-edit"></i></a>
                                                          <a id="hapusFlowKal" type="button" class="btn btn-sm btn-danger" KPE_AIR_FLOWMETER_KALIBRASI_ID="${data.result[i].KPE_AIR_FLOWMETER_KALIBRASI_ID}"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                      </tr>`);    
        }
      },
      error:function(x,e){
        console.log('Error PHP');
      }//end error
    });
  }
  /*===== End List Flowmeter Kalibrasi =====*/

  /*===== Simpan Flowmeter Kalibrasi =====*/
  function simpanFlowKalibrasi()
  {
    let fDataFlowKal=$("#fDataFlowKal").serialize(); 
    let dataFlowKal = "&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID_KALIBRASI").children("option:selected").text())+"&"+fDataFlowKal
    // alert(fDataFlowKal);
    // return;
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      //data:'ref=simpan_catatan&'+data,
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_angka_flowmeter_kalibrasi&'+dataFlowKal,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        {
          Swal.fire({
            timer: 1500,
            timerProgressBar: true,
            title: 'Berhasil!',
            text: ''+data.respon.text_msg+'',
            icon: 'success',
          })
          $('#KPE_AIR_FLOWMETER_ID_KALIBRASI').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL').val("");
          $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_ID").val('');
          listFlowmeterKalibrasi();
          
        }else if(data.respon.pesan=="gagal")
        {
          Swal.fire({
            title: 'Gagal!',
            text: ''+data.respon.text_msg+'',
            icon: 'error',
          })
          $('#KPE_AIR_FLOWMETER_ID_KALIBRASI').selectpicker("val",'');
          $('#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL').val("");
          $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val('');
          $("#KPE_AIR_FLOWMETER_KALIBRASI_ID").val('');
          listFlowmeterKalibrasi();
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> simpan_angka_flowmeter_kalibrasi()');
      }//end error
    });
  }
  /*===== End Simpan Flowmeter Kalibrasi =====*/

  /*===== Edit Flowmeter Kalibrasi =====*/
  $('tbody').on('click', 'a#editFlowKal', function(){
    var KPE_AIR_FLOWMETER_ID_KALIBRASI = $(this).attr('KPE_AIR_FLOWMETER_ID_KALIBRASI');
    var KPE_AIR_FLOWMETER_KALIBRASI_ID = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_ID');
    var KPE_AIR_FLOWMETER_KALIBRASI_PERSEN = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_PERSEN');
    var KPE_AIR_FLOWMETER_KALIBRASI_REAL = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_REAL');
    var KPE_AIR_FLOWMETER_KALIBRASI_SELISIH = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_SELISIH');
    var KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL');
    var KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
    // console.log(KPE_AIR_FLOWMETER_ID_KALIBRASI);
    $('#KPE_AIR_FLOWMETER_ID_KALIBRASI').selectpicker("val",KPE_AIR_FLOWMETER_ID_KALIBRASI);
    $('#KPE_AIR_FLOWMETER_KALIBRASI_ID').val(KPE_AIR_FLOWMETER_KALIBRASI_ID);
    var d = new Date(KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL);
    var t = d.getFullYear();
    var b = tambahNol(d.getMonth()+1);
    var h = tambahNol(d.getDate());
    $('#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL').val(t+"/"+b+"/"+h);
    $('#KPE_AIR_FLOWMETER_KALIBRASI_REAL').val(KPE_AIR_FLOWMETER_KALIBRASI_REAL);
    $('#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH').val(KPE_AIR_FLOWMETER_KALIBRASI_SELISIH);
    $('#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN').val(KPE_AIR_FLOWMETER_KALIBRASI_PERSEN);
  });
  /*===== End Edit Flowmeter Kalibrasi =====*/

  /*===== Hapus Flowmeter Kalibrasi =====*/
  $('tbody').on('click', 'a#hapusFlowKal', function(){
    var KPE_AIR_FLOWMETER_KALIBRASI_ID = $(this).attr('KPE_AIR_FLOWMETER_KALIBRASI_ID');
    // alert(KPE_AIR_FLOWMETER_KALIBRASI_ID);
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_angka_flowmeter_kalibrasi&KPE_AIR_FLOWMETER_KALIBRASI_ID='+KPE_AIR_FLOWMETER_KALIBRASI_ID,
          success:function(data)
          { 
            $('tfoot#zone_total').empty();
            if(data.respon.pesan=="sukses")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Terhapus!',
                text: 'Data Berhasil Dihapus.',
                icon: 'success',
              })
              listFlowmeterKalibrasi();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data Gagal Dihapus.',
                icon: 'error',
              })
              listFlowmeterKalibrasi();
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
  /*===== End Hapus Flowmeter Kalibrasi =====*/

  /*===== Button reset Form =====*/
  $('button#resetKalibrasi').click(function () {
      $('#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN').val('');
      $('#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH').val('');
      $('#KPE_AIR_FLOWMETER_KALIBRASI_REAL').val('');
      $('#KPE_AIR_FLOWMETER_KALIBRASI_TANGGAL').val('');
      $('#KPE_AIR_FLOWMETER_KALIBRASI_ID').val('');
      $('#KPE_AIR_FLOWMETER_ID_KALIBRASI').selectpicker('val','');
  });
  /*===== End button reset Form =====*/
  //======================== END SCRIPT FLOWMETER KALIBRASI =============================//
</script>