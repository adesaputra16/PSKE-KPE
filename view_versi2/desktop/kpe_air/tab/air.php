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

  // $input_option=array(
  // );
  // $params=array(
  //   //'case'=>"presensi_lembur_spl_pdf_nonlogin",
  //   'case'=>"nonlogin_tampil_catatan",
  //   'batas'=>100,
  //   'halaman'=>1,
  //   'data_http'=>$_COOKIE['data_http'],
  //   'input_option'=>$input_option,
  // );
  // //$respon=$WO_MASTER->wo($params)->load->module;
  // $respon_ctt = $KPE->kpe_modules($params)->load->module;

  // echo "<pre>".print_r($respon_ctt['result'],true)."</pre>";
//exit();
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

.dropleft {
  position: relative;
}

.dropleft .dropdown-menu {
  top: 0;
  right: 100%;
  left: auto;
  margin-top: 0;
  margin-right: 0.125rem;
}

.dropleft .dropdown-toggle::after {
  display: inline-block;
  margin-left: 0.255em;
  vertical-align: 0.255em;
  content: "";
}

.dropleft .dropdown-toggle::after {
  display: none;
}

.dropleft .dropdown-toggle::before {
  display: inline-block;
  margin-right: 0.255em;
  vertical-align: 0.255em;
  content: "";
  border-top: 0.3em solid transparent;
  border-right: 0.3em solid;
  border-bottom: 0.3em solid transparent;
}

.dropleft .dropdown-toggle:empty::after {
  margin-left: 0;
}

.dropleft .dropdown-toggle::before {
  vertical-align: 0;
}

.dropleft .dropdown-toggle-split::before {
  margin-right: 0;
}

table.table-bodered, .bordered{
  border:1px solid #ccc !important;
}

tr.trData:hover{
  background:rgba(250, 240, 202,0.5) !important;
}

</style>


<div class="box-body">
  <button type="button" class="btn btn-sm btn-success modalCatatan" ><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Catatan</button> 
  <div class="pull-right">
    <button type="button" class="btn btn-sm btn-primary" id="btn-reload"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
    <a type="button" id="cetakPdf" class="btn btn-sm btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a> 
  </div>
  <br><br>
  
  <!-- Pencarian -->
  <div class="box box-solid bg-teal-gradient">
    <div class="box-header">
      <i class="fa fa-calendar"></i>

      <h3 class="box-title">Akumulasi</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="box-body border-radius-none">
      
    <div class="row">
      <div class="col-md-2 form-group">
        <label for="JENIS_LAPORAN">Jenis Akumulasi</label>
        <select class="form-control col-sm-2" name="JENIS_LAPORAN" id="JENIS_LAPORAN" onchange="jenisAkumulasi()" required>
          <!--<option value="0">--Pilih--</option>-->
          <option value="Harian" selected>Harian</option>
          <option value="Mingguan">Mingguan</option>
          <option value="Bulanan">Bulanan</option>
          <option value="Tahunan">Tahunan</option>
        </select>
      </div>
      
      <div class="col-md-2 form-group tanggalawal"  id="divtanggalawal">
        <label for="DATA_sDATE" id="labelsDate">Tanggal</label>
        <input id="DATA_sDATE" name="DATA_sDATE"  type="text" class="datepicker col-sm-2 form-control" placeholder="<?= Date("Y/m/d"); ?>" value="<?= Date("Y/m/d"); ?>" autocomplete="off">
      </div>
      <div class="col-md-2 form-group tanggalakhir" id="divtanggalakhir" hidden>
        <label for="DATA_eDATE" id="eDate">Tanggal akhir</label>
        <input id="DATA_eDATE" name="DATA_eDATE"  type="text" class="col-sm-2 form-control"  placeholder="<?= Date("Y/m/d"); ?>" value="" autocomplete="off">
      </div>
      <div class="col-md-2 form-group" id="divbulanfilter" hidden>
        <label for="BULAN_FILTER">Bulan</label>
          <select class="form-control col-sm-2" name="BULAN_FILTER" id="BULAN_FILTER">
            <option value="">--Pilih bulan--</option>
            <?php 
              $array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober', 'November','Desember');
              for($bln=1;$bln<=12;$bln++){
                if($bln<=9)
                {
                  echo"<option value='0$bln'>$array_bulan[$bln]</option>";
                }else
                {
                  echo"<option value='$bln'>$array_bulan[$bln]</option>";
                }
              }
            ?>
          </select>
      </div>
      
      <div class="col-md-2  form-group" id="divtahunfilter" hidden>
        <label for="TAHUN_FILTER" >Tahun</label>
        <select class="form-control col-sm-2" name="TAHUN_FILTER" id="TAHUN_FILTER">
          <option value="">--Pilih tahun--</option>
          <?php
            $thnsekarang=Date('Y');
            $thnsebelumnya=$thnsekarang-7;
            for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
              echo"<option value='$thn'>$thn</option>";
            } ?>
        </select>
      </div>
      <div class="col-md-2  form-group" id="divtahunfilter2" hidden>
        <label for="TAHUN_FILTER2" >Tahun</label>
        <select class="form-control col-sm-2" name="TAHUN_FILTER2" id="TAHUN_FILTER2">
          <option value="">--Pilih tahun--</option>
          <?php
            $thnsekarang=Date('Y');
            $thnsebelumnya=$thnsekarang-7;
            for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
              echo"<option value='$thn'>$thn</option>";
            } ?>
        </select>
      </div>
    </div>

    </div>
  </div>
  <!-- /.End Pencarian -->

  <!-- Tabel -->
  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
                <tr>
                  <th class="bordered" rowspan="2" width="40">NO.</th>
                  <th class="bordered" colspan="2" rowspan="2"><center><b>DEPARTEMENT</b></center></th>
                  <th class="bordered" id="tglCatatan"><center><b>TANGGAL</b></center></th>
                  <th class="bordered" rowspan="2"><center><b>LOKASI</b></center></th>
                  <th class="bordered" rowspan="2"><center><b>DISTRIBUSI</b></center></th>
                  <th class="bordered" rowspan="2" id="action-btn" width="60"><center><b>AKSI</b></center></th>
                </tr>
                <tr id="colTgl">
                </tr>
            </thead>
            <tbody id="zone_data">
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
  <!-- end tabel -->

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
    <!-- <span class="coba">dsfadsf</span> -->
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCatatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Catatan</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:simpan();" class="fDataWilayah" id="fData" name="fDataWilayah">
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
              <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" onchange="listFlowDept()" required width="100%">
                <option value="" >--Pilih--</option>
                <?php 
                  foreach ($respon_flow['result'] as $rf) {
                    echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
                  }
                ?>
              </select>
            </div>
            <div class="form-group KPE_AIR_FLOWMETER_DEPARTEMEN_ID" style="display:none;">
              <label for="KPE_AIR_FLOWMETER_DEPARTEMEN_ID">Departemen</label>
              <select id="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" name="KPE_AIR_FLOWMETER_DEPARTEMEN_ID" class="form-control" >
              </select>
            </div>
            <div class="row formulaFlowDept"> 
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="PERSONIL_DEPARTEMEN">Personil Departemen</label>
                  <input type="number" class="form-control" id="PERSONIL_DEPARTEMEN" name="PERSONIL_DEPARTEMEN" autocomplete="off" placeholder="PERSONIL_DEPARTEMEN" step="any">
                </div>
              </div>
              <div class="col-sm-1">
                <!-- <label>&nbsp;</label> -->
                <span class="text-center"><h2>/</h2></span>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="TOTAL_PERSONIL">Total Personil</label>
                  <input type="number" class="form-control" id="TOTAL_PERSONIL" name="TOTAL_PERSONIL" autocomplete="off" placeholder="TOTAL_PERSONIL" step="any">
                </div>
              </div>
              <div class="col-sm-1">
                <!-- <label>&nbsp;</label> -->
                <span class="text-center"><h2>*</h2></span>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="PERSEN">Persen(%)</label>
                  <input type="number" class="form-control" id="PERSEN" name="PERSEN" autocomplete="off" placeholder="PERSEN(%)" step="any">
                </div>
              </div>
            </div>
            <div class="form-group KPE_AIR_FLOWMETER_CATATAN_ANGKA">
              <label for="KPE_AIR_FLOWMETER_CATATAN_ANGKA">Catatan Angka</label>
              <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_ANGKA" name="KPE_AIR_FLOWMETER_CATATAN_ANGKA" autocomplete="off" placeholder="123.456" step="any" required>
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN" name="KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN">
              
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_ID" name="KPE_AIR_FLOWMETER_CATATAN_ID" value="">
            </div>
            <div class="form-group KPE_AIR_FLOWMETER_CATATAN_TANGGAL">
              <label for="KPE_AIR_FLOWMETER_CATATAN_TANGGAL">Tanggal</label>
              <input type="text" class="form-control datepicker" id="KPE_AIR_FLOWMETER_CATATAN_TANGGAL" name="KPE_AIR_FLOWMETER_CATATAN_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
            </div>
            <div class="row rumusCatatan"> 
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KALIBRASI_REAL">Real</label>
                  <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_REAL" name="KPE_AIR_FLOWMETER_KALIBRASI_REAL" autocomplete="off" placeholder="ANGKA_REAL" step="any">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH">Selisih Std</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH" name="KPE_AIR_FLOWMETER_KALIBRASI_SELISIH" autocomplete="off" placeholder="ANGKA_SELISIH" step="any">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN">Persen(%)</label>
                  <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN" name="KPE_AIR_FLOWMETER_KALIBRASI_PERSEN" autocomplete="off" placeholder="PERSEN(%)" step="any">
                </div>
              </div>
            </div>
            <div class="form-group">
              <input class="form-control" value="<?= Date('Y/m');?>" type="hidden" id="KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE" name="KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE">

              <input class="form-control" value="off" type="hidden" id="KPE_AIR_FLOWMETER_CATATAN_KALIBRASI" name="KPE_AIR_FLOWMETER_CATATAN_KALIBRASI">
            </div>
            <div class="form-check KPE_AIR_FLOWMETER_KALIBRASI">
              <input type="checkbox" class="form-check-input" id="KPE_AIR_FLOWMETER_KALIBRASI" name="KPE_AIR_FLOWMETER_KALIBRASI">
              <label class="form-check-label"for="KPE_AIR_FLOWMETER_KALIBRASI">Kalibrasi</label>
            </div>
            <div class="form-check form-check-inline GUNAKAN_PERSONIL_SEBELUMNYA">
              <input class="form-check-input" type="checkbox" id="GUNAKAN_PERSONIL_SEBELUMNYA" name="GUNAKAN_PERSONIL_SEBELUMNYA">
              <label class="form-check-label" for="GUNAKAN_PERSONIL_SEBELUMNYA">Gunakan personil(%) sebelumnya</label>
            </div>
            <div class="form-check form-check-inline GUNAKAN_KALIBRASI_SEBELUMNYA">
              <input class="form-check-input" type="checkbox" id="GUNAKAN_KALIBRASI_SEBELUMNYA" name="GUNAKAN_KALIBRASI_SEBELUMNYA">
              <label class="form-check-label" for="GUNAKAN_KALIBRASI_SEBELUMNYA">Gunakan angka kalibrasi sebelumnya</label>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-danger" id="btnKalibrasi">Kalibrasi</button> -->
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success" id="btnSimpanCatatan">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var months = {'01':'January', '02':'Februari', '03':'Maret', '04':'April', '05':'Mei', '06':'Juni', '07':'Juli', '08':'Agustus', '09':'September', '10':'Oktober', '11': 'November', '12':'Desember'};

  $(function(){
    $(".selectpicker").selectpicker();
    $("input#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").datepicker().on('changeDate', function(ev)
    {  
      $('.datepicker').datepicker('hide');
    });
  });	

  $(function(){
    $('input#DATA_eDATE').attr("readonly","readonly");
    $("input#DATA_sDATE").datepicker().on('changeDate', function(ev)
    {  
      var TANGGAL_AWAL=$("input#DATA_sDATE").val();   
      // alert(TANGGAL_AWAL);          
      //MENENTUKAN TANGGAL AKHIRNYA SEMINGGU DARI TANGGAL AWAL
      var myDate = new Date(TANGGAL_AWAL);
      myDate.setDate(myDate.getDate() + 6);
      
      var month = '' + (myDate.getMonth() + 1),day = '' + myDate.getDate(),year = myDate.getFullYear();
      if (month.length < 2) 
        month = '0' + month;
      if (day.length < 2) 
        day = '0' + day;
      var TANGGAL_AKHIR=year+"/"+month+"/"+day;
      //END MENETUKAN TANGGAL AKHIRNYA
      // alert(TANGGAL_AKHIR);
      var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val();
      if (JENIS_LAPORAN == "Harian") 
      {
        $('input#DATA_eDATE').val('');
      } else {
        $("input#DATA_eDATE").val(TANGGAL_AKHIR);
      }
      $('.datepicker').datepicker('hide');
      });
  });	

  function jenisAkumulasi(){
    var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val(); 
    if (JENIS_LAPORAN == "Harian") 
    {
    
      $('input#DATA_sDATE').removeAttr("disabled");
      $('input#DATA_sDATE').attr("required");
      $('div#divtanggalawal').attr("style", "display:block");
      $('label#labelsDate').html("Tanggal");
      $('input#DATA_sDATE').val("");
      
      $('input#DATA_eDATE').attr("disabled","disabled");
      $('div#divtanggalakhir').attr("style", "display:none");      
      
      $('select#BULAN_FILTER').attr("disabled","disabled");
      $('select#BULAN_FILTER').removeAttr("required");
      $('select#BULAN_FILTER').val("");
      $('div#divbulanfilter').attr("style", "display:none");
      
      $('select#TAHUN_FILTER').attr("disabled","disabled");
      $('select#TAHUN_FILTER').removeAttr("required");
      $('div#divtahunfilter').attr("style", "display:none");
      $('select#TAHUN_FILTER').val("");

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
      
    } else if (JENIS_LAPORAN == "Mingguan")
    {	
      $('input#DATA_sDATE').removeAttr("disabled");
      $('input#DATA_sDATE').attr("required");
      $('div#divtanggalawal').attr("style", "display:block");
      $('label#labelsDate').html("Tanggal Awal");
      $('input#DATA_sDATE').val("");
    
      $('input#DATA_eDATE').removeAttr("disabled");
      $('input#DATA_eDATE').attr("readonly","readonly");
      $('div#divtanggalakhir').attr("style", "display:block");
    
      $('select#BULAN_FILTER').attr("disabled","disabled");
      $('select#BULAN_FILTER').removeAttr("required");
      $('select#BULAN_FILTER').val("");
      $('div#divbulanfilter').attr("style", "display:none");
      
      $('select#TAHUN_FILTER').attr("disabled","disabled");
      $('select#TAHUN_FILTER').removeAttr("required");
      $('div#divtahunfilter').attr("style", "display:none");

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
    
    }else if (JENIS_LAPORAN == "Bulanan")
    {	
      $('input#DATA_sDATE').attr("disabled","disabled");
      $('input#DATA_sDATE').removeAttr("required");
      $('input#DATA_sDATE').val("");
      $('div#divtanggalawal').attr("style", "display:none");
    
      $('input#DATA_eDATE').attr("disabled","disabled");
      $('input#DATA_eDATE').removeAttr("required");
      $('input#DATA_eDATE').val("");
      $('div#divtanggalakhir').attr("style", "display:none");
    
      $('select#BULAN_FILTER').removeAttr("disabled");
      $('select#BULAN_FILTER').attr("required");
      $('div#divbulanfilter').attr("style", "display:block");
      
      $('select#TAHUN_FILTER').removeAttr("disabled");
      $('select#TAHUN_FILTER').attr("required");
      $('select#TAHUN_FILTER').val("");
      $('div#divtahunfilter').attr("style", "display:none");

      $('select#TAHUN_FILTER2').removeAttr("disabled");
      $('select#TAHUN_FILTER2').attr("required");
      $('div#divtahunfilter2').attr("style", "display:block");
      $('select#TAHUN_FILTER2').val("");
    
    }else if (JENIS_LAPORAN == "Tahunan")
    {
      $('input#DATA_sDATE').attr("disabled","disabled");
      $('input#DATA_sDATE').removeAttr("required");
      $('input#DATA_sDATE').val("");
      $('div#divtanggalawal').attr("style", "display:none");
    
      $('input#DATA_eDATE').attr("disabled","disabled");
      $('input#DATA_eDATE').removeAttr("required");
      $('input#DATA_eDATE').val("");
      $('div#divtanggalakhir').attr("style", "display:none");
    
      $('select#BULAN_FILTER').attr("disabled","disabled");
      $('select#BULAN_FILTER').removeAttr("required");
      $('select#BULAN_FILTER').val("");
      $('div#divbulanfilter').attr("style", "display:none");
      
      $('select#TAHUN_FILTER').removeAttr("disabled");
      $('select#TAHUN_FILTER').attr("required");
      $('select#TAHUN_FILTER').val("");
      $('div#divtahunfilter').attr("style", "display:block");

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
    
    }else{
      $('input#DATA_eDATE').attr("readonly","readonly");}
    //search();
  }

  $('.modalCatatan').on('click', function(){
    $(".selectpicker").selectpicker("val","");
    $("small.angkaSebelumnya").remove();
    $("#fData").attr("action","javascript:simpan()")
    $("#modalCatatan").modal('show');
    $('#KPE_AIR_FLOWMETER_ID').val('');
    $('#KPE_AIR_FLOWMETER_SUB_ID').val('');
    $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA').val('');
    $('#KPE_AIR_FLOWMETER_CATATAN_ID').val('');
    $("#PERSONIL_DEPARTEMEN").val("");
    $("#TOTAL_PERSONIL").val("");
    $("#PERSEN").val("");
    $("#KPE_AIR_FLOWMETER_KALIBRASI").prop("checked",false)
    $(".KPE_AIR_FLOWMETER_KALIBRASI").attr("style","display:none");
    $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val("");
    $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val("");
    $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val("");
    $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("has-error");
    $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("has-success");
    $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("control-label");
    $("#btnSimpanCatatan").removeAttr("disabled");
    $("small.help-block").remove();
    $('.KPE_AIR_FLOWMETER_CATATAN_ANGKA').removeAttr('style');
    $(".KPE_AIR_FLOWMETER_CATATAN_TANGGAL").removeAttr("style");
    $("#btnKalibrasi").attr("style", "display:none;");
    $('.KPE_AIR_FLOWMETER_DEPARTEMEN_ID').attr("style","display:none;");
    $('.formulaFlowDept').attr("style","display:none;");
    $('.rumusCatatan').attr("style","display:none;");
    $('.GUNAKAN_KALIBRASI_SEBELUMNYA').attr("style","display:none;");
    $('.GUNAKAN_PERSONIL_SEBELUMNYA').attr("style","display:none;");
    $('#KPE_AIR_FLOWMETER_CATATAN_TANGGAL').val("<?= Date('Y/m/d');?>");
  })

  $("#btnKalibrasi").click(function(){
    $("#KPE_AIR_FLOWMETER_CATATAN_KALIBRASI").val("on")
  });

  function simpan()
  {
  $("#btnSimpanCatatan").attr("disabled","disabled");
  var fData=$("#fData").serialize(); 
  if ($("#PERSEN").val() == "") {
    var persen = "";
  } else {
    persen = tambahNol(($("#PERSONIL_DEPARTEMEN").val()/$("#TOTAL_PERSONIL").val()*$("#PERSEN").val()).toFixed());
  }
  var date = new Date($("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val());
  var dates = $("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val();
  dateSebelumnya = new Date((new Date(date)).valueOf() - 1000*60*60*24);
  var KPE_AIR_FLOWMETER_CATATAN_TANGGAL_SEBELUMNYA = dateSebelumnya.getFullYear() + '/' + tambahKosong(dateSebelumnya.getMonth()+1) + '/' + tambahKosong(dateSebelumnya.getDate());   
  var data = "&KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL="+persen+"&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID").children("option:selected"). text())+"&KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="+btoa($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected"). text())+"&KPE_AIR_FLOWMETER_CATATAN_TANGGAL_SEBELUMNYA="+KPE_AIR_FLOWMETER_CATATAN_TANGGAL_SEBELUMNYA+"&"+fData;
  // console.log(data);
  // alert(data)
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    //data:'ref=simpan_catatan&'+data,
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_catatan&'+data,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        $("#modalCatatan").modal('hide');
        // alert(data.respon.text_msg);
        // console.log(data.respon.text_msg);
        $(".selectpicker").selectpicker("val","");
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        tampil('1');
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_catatan()');
    }//end error
  });
  }

  function tambahNol(x){
    y=(x>9)?'0.'+x:'0.0'+x;
    return y;
  }

  function listCatatanFlowDept()
  {
  var KPE_AIR_FLOWMETER_ID = $("#KPE_AIR_FLOWMETER_ID").val();
  var KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = btoa($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected").text());
  var dates = $("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val();
  var data = '&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA='+KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA+'&KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE='+dates
  // alert(data)
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    //data:'ref=simpan_catatan&'+data,
    data:'aplikasi=<?php echo $d0;?>&ref=list_catatan_departemen&'+data,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        // console.log(data.result);
        $("#PERSONIL_DEPARTEMEN").val(data.result[0].KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL);
        $("#TOTAL_PERSONIL").val(data.result[0].KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL);
        $("#PERSEN").val(data.result[0].KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN);
        $(".GUNAKAN_PERSONIL_SEBELUMNYA").removeAttr("style");
        $("#GUNAKAN_PERSONIL_SEBELUMNYA").prop("checked", true);
      }else if(data.respon.pesan=="gagal")
      {
        // console.log("gagal");
        $(".formulaFlowDept").removeAttr("style");
        $("#GUNAKAN_PERSONIL_SEBELUMNYA").prop("checked", false);
        $(".GUNAKAN_PERSONIL_SEBELUMNYA").attr("style","display:none");
        $("#PERSONIL_DEPARTEMEN").val("");
        $("#TOTAL_PERSONIL").val("");
        $("#PERSEN").val("");
      }
    },
    error:function(x,e){
      // error_handler_json(x,e,'=> simpan_catatan()');
      console.log("error");
    }//end error
  });
  }

  function tambahKosong(x){
    y=(x>9)?x:'0'+x;
    return y;
  }

  $('tbody').on('click', 'a.edit', function(){
    $("#btnSimpanCatatan").removeAttr("disabled");
    var KPE_AIR_FLOWMETER_CATATAN_ANGKA = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ANGKA');
    var KPE_AIR_FLOWMETER_CATATAN_ID = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ID');
    var KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
    var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
    var KPE_AIR_FLOWMETER_CATATAN_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_TANGGAL');
    var KPE_AIR_FLOWMETER_CATATAN_KALIBRASI = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_KALIBRASI');
    var KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL');
    var KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH');
    var KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN');
    var d = new Date(KPE_AIR_FLOWMETER_CATATAN_TANGGAL);
    var t = d.getFullYear();
    var b = tambahKosong(d.getMonth()+1);
    var h = tambahKosong(d.getDate());
    $('.KPE_AIR_FLOWMETER_DEPARTEMEN_ID').attr("style","display:none;");
    $('.formulaFlowDept').attr("style","display:none;");
    if (KPE_AIR_FLOWMETER_CATATAN_KALIBRASI=="on" || KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL != "" || KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH != "" || KPE_AIR_FLOWMETER_CATATAN_KALIBRASI != "") {
      $('.rumusCatatan').removeAttr("style");
      $('.GUNAKAN_ANGKA_SEBELUMNYA').attr("style","display:none;");
    } else {
      $('.rumusCatatan').attr("style","display:none;");
      $('.GUNAKAN_ANGKA_SEBELUMNYA').removeAttr("style");
    }

    $("#modalCatatan").modal('show');
    $('input#KPE_AIR_FLOWMETER_CATATAN_ANGKA').val(KPE_AIR_FLOWMETER_CATATAN_ANGKA);
    $('input#KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL').val(KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL);
    $('input#KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH').val(KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH);
    $('input#KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN').val(KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN);
    $('input#KPE_AIR_FLOWMETER_CATATAN_ID').val(KPE_AIR_FLOWMETER_CATATAN_ID);
    $('input#KPE_AIR_FLOWMETER_CATATAN_TANGGAL').val(t+"/"+b+"/"+h);
    $('input#KPE_AIR_FLOWMETER_NAMA').val(KPE_AIR_FLOWMETER_NAMA);
    // $('select#KPE_AIR_FLOWMETER_ID').val(KPE_AIR_FLOWMETER_ID);
    $(".selectpicker").selectpicker("val",KPE_AIR_FLOWMETER_ID);
  });

  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }

  function tampil(curPage)
  {
    // var data = 'tampil_catatan&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage;
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
      data:'aplikasi=<?php echo $d0;?>&ref=tampil_catatan&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&TAHUN_FILTER2='+$("select#TAHUN_FILTER2").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        if (data.respon.pesan == "sukses") 
        {
          // console.log(data.result);
          //alert(data.respon.text_msg);
          // $("span.coba").html(data.respon.boaboa);
          $("tbody#zone_data").empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });
              var tableContent = "";  
              for (var j = 0; j < data.result.length; j++) 
              {
                // console.log(data.result[j].FLOWMETER);
              if (data.result[j].FLOWMETER == "") {
                var JFLOWMETER = 0;
                var cols = 7;
              } else {
                JFLOWMETER = data.result[j].FLOWMETER.length;
                cols = 0;
              }
							// calculate rowspan for first cell
                var rowspan = 1;
                
                rowspan += JFLOWMETER;
                // create rows
                tableContent += /*html*/`<tr class="trData">
                                <td class="bordered" rowspan="${rowspan}">${data.result[j].NO}.</td>
                                <td class="bordered" rowspan="${rowspan}" colspan="${cols}">${data.result[j].KPE_AIR_FLOWMETER_SUB_NAMA}</td></tr>`;
                var d = new Date();
                var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + (d.getDate()-2) + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                  
                var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val();
                for (var i = 0; i < data.result[j].FLOWMETER.length; i++) 
                {
                  var date = new Date(data.result[j].FLOWMETER[i].ENTRI_WAKTU);
                  var tanggal = date.getFullYear() +"/" + (date.getMonth()+1) + "/" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds(); 
                  // console.log(date);
                  // console.log(tanggal);
                  if (new Date(tanggal) < new Date(strDate)) {
                    var disabled = 'disableda';
                  }
                  else{
                    var disabled = '';
                  }
                  
                  const object = data.result[j].FLOWMETER[i];
                  var listData = '';
                  var property;
                  if (JENIS_LAPORAN == "Harian") 
                  {
                    var listData =  /*html*/`<td class="bordered"> ${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_NAMA} </td>
                                    <td class="bordered text-right"> ${formatNumber(data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ANGKA)} </td>
                                    <td class="bordered"> ${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_LOKASI} </td>
                                    <td class="bordered"> ${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_DISTRIBUSI} </td>` ;
                    var btnEdit = /*html*/`<td class="bordered">
                                    <div class="btn-group" >
                                      <div class="btn-group dropleft" role="group">
                                        <button type="button" class="btn btn-xs btn-default dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ${disabled}>
                                          <span class="sr-only">Toggle Dropleft</span>
                                        </button>
                                        <div class="dropdown-menu">
                                          <li><a class="edit" KPE_AIR_FLOWMETER_ID="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_ID}" KPE_AIR_FLOWMETER_CATATAN_ANGKA="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ANGKA}" KPE_AIR_FLOWMETER_CATATAN_TANGGAL="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_TANGGAL}" KPE_AIR_FLOWMETER_NAMA="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_NAMA}" KPE_AIR_FLOWMETER_CATATAN_ID="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ID}" KPE_AIR_FLOWMETER_CATATAN_KALIBRASI="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_KALIBRASI}" KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL}" KPE_AIR_FLOWMETER_CATATAN_SELISIH="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_SELISIH}" KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN}"><i class="fa fa-edit"></i>Edit </a></li>
                                          <li><a class="hapus" KPE_AIR_FLOWMETER_CATATAN_ID="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ID}" KPE_AIR_FLOWMETER_ID="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_ID}" KPE_AIR_FLOWMETER_CATATAN_TANGGAL="${data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_TANGGAL}"><i class="fa fa-trash"></i> Hapus </a></li>
                                        </div>
                                      </div>
                                      <button type="button" class="btn btn-xs btn-success" ${disabled}>
                                        <i class="fa fa-eye"></i>
                                      </button>
                                    </div>
                                  </td>`;
                  }
                  else if (JENIS_LAPORAN == "Mingguan")
                  {
                    for (property in object) {
                      var x = object[property];
                      if (x == object['KPE_AIR_FLOWMETER_DISTRIBUSI'] || x == object['KPE_AIR_FLOWMETER_LOKASI'] || x == object['KPE_AIR_FLOWMETER_NAMA']) {
                        var align = 'text-left';
                      } else {
                        align = 'text-right';
                      }
                      listData +=  /*html*/`<td class="bordered ${align}">${formatNumber(object[property])}</td>`;
                      // console.log(object);
                    }
                  }
                  else if (JENIS_LAPORAN == "Bulanan")
                  {	
                    for (property in object) {
                      var x = object[property];
                      if (x == object['KPE_AIR_FLOWMETER_DISTRIBUSI'] || x == object['KPE_AIR_FLOWMETER_LOKASI'] || x == object['KPE_AIR_FLOWMETER_NAMA']) {
                        var align = 'text-left';
                      } else {
                        align = 'text-right';
                      }
                      listData +=  /*html*/`<td class="bordered ${align}">${formatNumber(object[property])}</td>`;
                    }
                  }
                  else if (JENIS_LAPORAN == "Tahunan")
                  {
                    for (property in object) {
                      var x = object[property];
                      if (x == object['KPE_AIR_FLOWMETER_DISTRIBUSI'] || x == object['KPE_AIR_FLOWMETER_LOKASI'] || x == object['KPE_AIR_FLOWMETER_NAMA']) {
                        var align = 'text-left';
                      } else {
                        align = 'text-right';
                      }
                      listData +=  /*html*/`<td class="bordered ${align}">${formatNumber(object[property])}</td>`;
                    }
                  }
                  else{
                  }

                  tableContent += /*html*/`<tr class="trData">${listData+btnEdit}</tr>`;
                                
                }
              }
              $("tbody#zone_data").append(tableContent);
            

        } else if (data.respon.pesan == "gagal") {
          // alert(data.respon.text_msg);
          $("tbody#zone_data").html(/*html*/`<tr><td colspan="7"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      }, //end success
      error: function(x, e) {
        // error_handler_json(x, e, '=> tampil_catatan()');
        console.log('error');
      } //end error
    });
  }

  $(function() {
  $('a.sidebar-toggle').click()
  });

  $(window).on('hashchange', function(e) {
  tampil('1');
  });
  $("input#REC_PER_HALAMAN").on('change', function() {
  tampil('1');
  });
  // $("input#DATA_sDATE").on('change', function() {
  // tampil('1');
  // });

  $('tbody').on('click', 'a.hapus', function(){
  var KPE_AIR_FLOWMETER_CATATAN_ID = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ID');
  var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
  var KPE_AIR_FLOWMETER_CATATAN_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_TANGGAL');
  // alert('&KPE_AIR_FLOWMETER_CATATAN_ID='+KPE_AIR_FLOWMETER_CATATAN_ID+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+KPE_AIR_FLOWMETER_CATATAN_TANGGAL);
  if (confirm('Yakin akan menghapus data ini??')){
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=hapus_catatan&KPE_AIR_FLOWMETER_CATATAN_ID='+KPE_AIR_FLOWMETER_CATATAN_ID+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+KPE_AIR_FLOWMETER_CATATAN_TANGGAL,
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
        error_handler_json(x,e,'=> hapus_catatan()');
      }//end error
    });
  }
  })

  function ambil_flowmeter()
  {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=ambil_daftar_flowmeter',
    success: function(data) {
      // console.log(data.result);
      if (data.respon.pesan == "sukses") 
      {
        for (i = 0; i < data.result.length; i++) {
          // $("select#KPE_AIR_FLOWMETER_ID").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "</option>");
          var x = data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA;
          var z = "";
          var y = "";
          if (x == "") {
            y += "";
            z = "";
          } else {
            y += JSON.parse(x);
            z = y.split(",");
          }
          // console.log(z);
        }
        
      }else
      {}
    }
  })
  }

  function tambahKosong(x){
    y=(x>9)?x:'0'+x;
    return y;
  }

  function listFlowDept() {
    
    var KPE_AIR_FLOWMETER_ID = $("#KPE_AIR_FLOWMETER_ID").val();
    var KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = $("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected").text();
    // console.log(KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA)
    var date = new Date($("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val());
    var dates = $("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val();
    date = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    var KPE_AIR_FLOWMETER_CATATAN_TANGGAL = date.getFullYear() + '/' + tambahKosong(date.getMonth()+1) + '/' + tambahKosong(date.getDate());   

    $("select#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").empty();
    $(".GUNAKAN_PERSONIL_SEBELUMNYA").attr("style","display:none");
    $(".GUNAKAN_KALIBRASI_SEBELUMNYA").attr("style","display:none");
    $(".rumusCatatan").attr("style","display:none");
    $(".formulaFlowDept").attr("style","display:none");
    list_flowmeter_kalibrasi()

  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=list_flowmeter_departemen&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+KPE_AIR_FLOWMETER_CATATAN_TANGGAL+'&KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA='+KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA+'&KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE='+dates,
    success: function(data) {
      // console.log(data.result);
      if (data.respon.pesan == "sukses" && data.result[0].CATATAN != null) 
      {
        // console.log(data.result);
        // $("#btnKalibrasi").removeAttr("style");
        for (var i = 0; i < data.result.length; i++) {
          var x = data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA;
          if (data.result[i].CATATAN == null) {
            var q = "";
            // $("#PERSONIL_DEPARTEMEN").val("");
            // $("#TOTAL_PERSONIL").val("");
            // $("#PERSEN").val("");
            // $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val("");
            // $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val("");
            // $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val("");
            $("#btnKalibrasi").removeAttr("style");
            $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeAttr("onkeyup");
            $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val(""); 
          } else {
            q = data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH; 
            $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA").attr("onkeyup","cekAngkaCatatan();"); 
            $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_ANGKA);
            $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").append('<small class="angkaSebelumnya" style="color:#666"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Angka sebelumnya adalah : '+$("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val()+'</small>');
            if (q == null || q == "") {
              // $(".formulaFlowDept").attr("style","display:none");
              // $(".rumusCatatan").attr("style","display:none");
              $(".GUNAKAN_KALIBRASI_SEBELUMNYA").attr("style","display:none");
              $("#GUNAKAN_KALIBRASI_SEBELUMNYA").prop("checked",false);
              $(".KPE_AIR_FLOWMETER_KALIBRASI").attr("style","display:none");
            } else {
              $(".KPE_AIR_FLOWMETER_KALIBRASI").removeAttr("style");
              // $("#GUNAKAN_KALIBRASI_SEBELUMNYA").prop("checked",true);
              // $(".GUNAKAN_KALIBRASI_SEBELUMNYA").removeAttr("style");
              // $(".formulaFlowDept").removeAttr("style");
              // $(".rumusCatatan").removeAttr("style");
              // $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL);
              // $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH);
              // $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN);
              // $("#KPE_AIR_FLOWMETER_CATATAN_KALIBRASI").val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_KALIBRASI);
            }
          }

          var z = "",y = "",v="";
          if (x == "") {
            y += "";
            z = "";
            // $(".KPE_AIR_FLOWMETER_DEPARTEMEN_ID").attr("style","display:none");
            $(".formulaFlowDept").attr("style","display:none");
          } else {
            $(".KPE_AIR_FLOWMETER_DEPARTEMEN_ID").removeAttr("style");
            // $(".formulaFlowDept").removeAttr("style");
            y += JSON.parse(x);
            z = y.split(",");
          }          
          // console.log(z);
          for (var j = 0; j < z.length; j++) {
            v += "<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + z[j] + "</option>";
          }
        }
        $("select#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").append("<option value=''>--Pilih--</option>"+v);
        
      }else
      {
        // if(confirm("Catatan angka tanggal "+KPE_AIR_FLOWMETER_CATATAN_TANGGAL+" belum terisi")){
          alert("Catatan angka tanggal "+KPE_AIR_FLOWMETER_CATATAN_TANGGAL+" belum terisi");
          $("#modalCatatan").modal('hide');
        // };
      }
    }
  })
  }

  function cekAngkaCatatan() {
    var catatanKSebelum = ($("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val())*0.80;
    var catatanKSebelumnya = catatanKSebelum.toFixed(2);
    var catatanLSebelum = ($("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val())/0.50;
    var catatanLSebelumnya = catatanLSebelum.toFixed(2);
    var catatanSekarang = parseFloat($("#KPE_AIR_FLOWMETER_CATATAN_ANGKA").val());
    $("small.help-block").remove();
    if(catatanSekarang == $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val()){
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("has-error");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("has-success");
      $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("control-label");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").append('<small class="help-block">Angka yang dimasukkan sama dengan angka sebelumnya.</small>');
      $("#btnSimpanCatatan").removeAttr("disabled");
    } else if (catatanLSebelumnya == 0.000 && catatanSekarang > $("#KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN").val()){
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("has-error");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("has-success");
      $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("control-label");
      $("#btnSimpanCatatan").removeAttr("disabled");
    } else if (catatanSekarang < catatanKSebelumnya) {
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("has-error");
      $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("control-label");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").append('<small class="help-block">Angka yang dimasukkan terlalu kecil dari angka sebelumnya.</small>');
      $("#btnSimpanCatatan").attr("disabled","disabled");
    } else if(catatanSekarang > catatanLSebelumnya){
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("has-error");
      $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("control-label");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").append('<small class="help-block">Angka yang dimasukkan terlalu besar dari angka sebelumnya.</small>');
      $("#btnSimpanCatatan").attr("disabled","disabled");
    } else {
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeClass("has-error");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("has-success");
      $("label#KPE_AIR_FLOWMETER_CATATAN_ANGKA").addClass("control-label");
      $("#btnSimpanCatatan").removeAttr("disabled");
    }
  }

  function simpanFlowDept(){
    var fData = $('#fData').serialize();
    var persen = tambahNol(($("#PERSONIL_DEPARTEMEN").val()/$("#TOTAL_PERSONIL").val()*$("#PERSEN").val()).toFixed());
    // alert(fData+'&'+persen);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:"aplikasi=<?php echo $d0;?>&ref=simpan_flow_dept&KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL="+persen+"&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID").children("option:selected"). text())+"&KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA="+btoa($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected"). text())+"&"+fData,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        {
          alert(data.respon.text_msg);
          $("#modalCatatan").modal('hide');
          tampil('1');
          
        }else if(data.respon.pesan=="gagal")
        {
          alert(data.respon.text_msg);
          tampil('1');
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> hapus_catatan()');
      }//end error
    });
  }

  function list_flowmeter_kalibrasi() 
  {
    var KPE_AIR_FLOWMETER_ID = $("#KPE_AIR_FLOWMETER_ID").val();
    // return;
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_angka_flowmeter_kalibrasi&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID,
      success:function(data)
      { 
        // console.log(data.result);
        if(data.respon.pesan=="sukses")
        {
          $(".rumusCatatan").removeAttr("style");
          $("#KPE_AIR_FLOWMETER_KALIBRASI").prop("checked",true)
          $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val(data.result[0].KPE_AIR_FLOWMETER_KALIBRASI_REAL);
          $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val(data.result[0].KPE_AIR_FLOWMETER_KALIBRASI_SELISIH);
          $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val(data.result[0].KPE_AIR_FLOWMETER_KALIBRASI_PERSEN);
        }else if(data.respon.pesan=="gagal")
        {
          $(".rumusCatatan").attr("style","display:none;");
          $("#KPE_AIR_FLOWMETER_KALIBRASI").prop("checked",false)
        }
      },
      error:function(x,e){
        alert('error');
      }//end error
    });
  }

  $("input#GUNAKAN_KALIBRASI_SEBELUMNYA").on('change', function() {
    if ($('input.GUNAKAN_KALIBRASI_SEBELUMNYA').is(':checked')) {
      listFlowDept();
      // if ($("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val() == "") {
        $(".rumusCatatan").attr("style","display:none");
      // } else {
        // $(".rumusCatatan").removeAttr("style");
      // }
      $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val("");
      $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val("");
      $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val("");
      $("#btnKalibrasi").removeAttr("style");
    } else {
      // listFlowDept();
      $(".rumusCatatan").removeAttr("style");
      $(".GUNAKAN_KALIBRASI_SEBELUMNYA").attr("style","display:none");
    }
  })

  $("input#KPE_AIR_FLOWMETER_KALIBRASI").on('change', function() {
    if ($('input#KPE_AIR_FLOWMETER_KALIBRASI').is(':checked')) {
      list_flowmeter_kalibrasi();
      // console.log("cek");
    } else {
      // console.log("nocek");
      $(".rumusCatatan").attr("style","display:none;");
      $("#KPE_AIR_FLOWMETER_KALIBRASI_REAL").val("");
      $("#KPE_AIR_FLOWMETER_KALIBRASI_SELISIH").val("");
      $("#KPE_AIR_FLOWMETER_KALIBRASI_PERSEN").val("");
    }
  })

  $("input#GUNAKAN_PERSONIL_SEBELUMNYA").on('change', function() {
    if ($('input.GUNAKAN_KALIBRASI_SEBELUMNYA').is(':checked')) {
      listCatatanFlowDept();
      if ($("#TOTAL_PERSONIL").val() == "") {
        $(".formulaFlowDept").attr("style","display:none");
      } else {
        // $(".formulaFlowDept").removeAttr("style");
      }
      $("#PERSONIL_DEPARTEMEN").val("");
      $("#TOTAL_PERSONIL").val("");
      $("#PERSEN").val("");
    } else {
      $(".formulaFlowDept").removeAttr("style");
      $(".GUNAKAN_PERSONIL_SEBELUMNYA").attr("style","display:none");
    }
  })

  $("select#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").on('change', function() {
    listCatatanFlowDept();
    // console.log($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").val());
    if ($("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").val() == "") {
      $("#fData").attr("action","javascript:simpan()")
      $(".formulaFlowDept").attr("style","display:none");
      $(".rumusCatatan").attr("style","display:none");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").removeAttr("style");
      $(".KPE_AIR_FLOWMETER_CATATAN_TANGGAL").removeAttr("style");
      $(".KPE_AIR_FLOWMETER_KALIBRASI").removeAttr("style");
    } else {
      $("#fData").attr("action","javascript:simpanFlowDept()")
      // listFlowDept();
      $(".formulaFlowDept").attr("style","display:none");
      $(".rumusCatatan").attr("style","display:none");
      $(".KPE_AIR_FLOWMETER_CATATAN_ANGKA").attr("style","display:none");
      $("#btnKalibrasi").attr("style","display:none");
      $(".KPE_AIR_FLOWMETER_CATATAN_TANGGAL").attr("style","display:none");
      $("#KPE_AIR_FLOWMETER_KALIBRASI").prop("checked",false);
      $(".KPE_AIR_FLOWMETER_KALIBRASI").attr("style","display:none");
    }
  })

  // --------------------Format Tanggal-------------------- //
  function format_tanggal(fulld){
    var sdate = fulld;
    var dt = new Date(sdate);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var tanggal = dt.getDate() + "-" + months[dt.getMonth()] + "-" + dt.getFullYear().toString().substr(-2);
    return tanggal;
  }

  function format_tahun(fully){
    var sdate = fully;
    var dt = new Date(sdate);
    var months = {'0':'Jan','1':'Feb','2':'Mar','3':'Apr','4':'May','5':'Jun','6':'Jul','7':'Aug','8':'Sep','9':'Oct','10':'Nov','11':'Dec'};
    var tahun = months[dt.getMonth()] + "-" + dt.getFullYear().toString().substr(-2);
    return tahun;
  }

  const GetDays = (Mention_today=false)=>{
    var DateArray = [];
    var days=6;
    for(var i=0;i<=days;i++){
    if(!Mention_today && i==0){i=1;days+=1}
    var date = new Date($('input#DATA_sDATE').val());
    var last = new Date(date.getTime() + ((i - 1) * 24 * 60 * 60 * 1000));
    var day =(last.getDate());
    var month=last.getMonth()+1;
    var year=last.getFullYear();
    const fulld = (Number(year)+'-'+Number(month)+'-'+Number(day));
    DateArray.push(format_tanggal(fulld));
    }
    return DateArray;
  }

  const GetMonth = (d,Mention_today=false)=>{
    var DateArray = [];
    var days=d;
    // console.log(days);
    for(var i=1;i<=days;i++){
    if(!Mention_today && i==0){i=0;days+=1}
    var date = new Date($('select#BULAN_FILTER').val());
    var year = new Date($('select#TAHUN_FILTER2').val());
    var day = i;
    var month= date.getMonth()+1;
    var year=year.getFullYear();
    const fulld = (Number(year)+'-'+Number(month)+'-'+Number(day))
    DateArray.push(format_tanggal(fulld));
    }
    return DateArray;
  }

  const GetYear = (Mention_today=false)=>{
    var DateArray = [];
    var days=12;
    for(var i=1;i<=days;i++){
    if(!Mention_today && i==0){i=1;days+=1}
    var date = new Date($('select#TAHUN_FILTER').val());
    var month=i;
    var year=date.getFullYear();
    const fully = (Number(year)+'-'+Number(month))
    DateArray.push(format_tahun(fully));
    }
    return DateArray;
  }
  // ------------------End Format Tanggal ------------------//

  $('#btn-reload').click(function(){
    var JENIS_LAPORAN = $('select#JENIS_LAPORAN').val();
    $('tr#colTgl').empty();
    if (JENIS_LAPORAN == "Harian") 
    {
      $('th#action-btn').removeAttr("style");
      $('th#tglCatatan').attr("colspan",1);
      $('tr#colTgl').append(/*html*/`<th class="bordered">${format_tanggal($('input#DATA_sDATE').val())}</th>`)
    } else if (JENIS_LAPORAN == "Mingguan")
    {	
      $('th#action-btn').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",7);
      for (var j = 0; j < GetDays().length; j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered">${GetDays()[j]}</th>`)
      }
    } else if (JENIS_LAPORAN == "Bulanan")
    {	
      var nowmonth = new Date($('select#BULAN_FILTER').val());
      var nowyear = new Date($('select#TAHUN_FILTER2').val());
      var monthEndDay = new Date(nowyear.getFullYear(), nowmonth.getMonth() + 1, 0);
      $('th#action-btn').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",parseInt(monthEndDay.getDate()));
      for (var j = 0; j < monthEndDay.getDate(); j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered">${GetMonth(parseInt(monthEndDay.getDate()))[j]}</th>`)
      }
    
    }else if (JENIS_LAPORAN == "Tahunan")
    {
      $('th#action-btn').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",12);
      for (var j = 0; j < GetYear().length; j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered">${GetYear()[j]}</th>`)
      }
    } else {

    }
    tampil('1');
    })

  function search() {
    tampil('1');
  }

  $(function() {
    ambil_flowmeter();
    tampil('1');
    $('tr#colTgl').append(/*html*/`<th class="bordered">${format_tanggal($('input#DATA_sDATE').val())}</th>`)
  });


  $('#cetakPdf').on('click', function(){
    //tampil();
    var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val(); 
    var se,sd,DATA_sDATE="",DATA_eDATE="",BULAN_FILTER="",TAHUN_FILTER2="",TAHUN_FILTER="";
    if (JENIS_LAPORAN == "Harian") {
      se = new Date($('input#DATA_sDATE').val());
      sd = new Date($('input#DATA_sDATE').val());
      DATA_sDATE = sd.getFullYear() + "-" + (sd.getMonth()+1) + "-" + sd.getDate();
    } else if(JENIS_LAPORAN == "Mingguan") {
      sd = new Date($('input#DATA_sDATE').val());
      se = new Date($('input#DATA_eDATE').val());
      DATA_sDATE = sd.getFullYear() + "-" + (sd.getMonth()+1) + "-" + sd.getDate();
      DATA_eDATE = se.getFullYear() + "-" + (se.getMonth()+1) + "-" + se.getDate();
    }else if (JENIS_LAPORAN == "Bulanan") {
      BULAN_FILTER = $("#BULAN_FILTER").val();
      TAHUN_FILTER2 = $("#TAHUN_FILTER2").val();
    } else {
      TAHUN_FILTER = $("#TAHUN_FILTER").val();
    }
    window.open('?show=kpe/pdf/cetak_pemakaian_air/'+DATA_sDATE+'/'+DATA_eDATE+'/'+BULAN_FILTER+'/'+TAHUN_FILTER2+'/'+TAHUN_FILTER+'', '_blank');
  })

  $("#btnKalibrasi").click(function () {
    $(".rumusCatatan").removeAttr("style")
  })

</script>
