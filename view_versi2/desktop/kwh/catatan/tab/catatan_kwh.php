<?php
  $input_option=array();
  $params=array(
    //'case'=>"presensi_lembur_spl_pdf_nonlogin",
    'case'=>"nonlogin_ambil_kwh_flowmeter",
    'batas'=>200,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option,
  );
  //$respon=$WO_MASTER->wo($params)->load->module;
  $respon_flow = $KPE->kpe_kwh($params)->load->module;

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

  // echo "<pre>".print_r($respon_flow['result'],true)."</pre>";
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

.Content {
  height:600px;
  overflow:auto;
  background:#fff;
}

.table-sticky>thead>tr>th {
  background: #fff;
  /* color: #000; */
  top: -3px;
  position: sticky;
  z-index: 10;
}

table, .table-bodered{
  border-collapse: separate;
}

.table-sticky>thead>tr>th.fixsudut {
	background: #fff;
	top: -3px;
	left: 0px;
	position: sticky;
  z-index: 20;
}

.fixed {
	background: white;
	left: 0px;
	position: sticky;
  z-index: 6;
}

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
  <button type="button" class="btn btn-success modalCatatan"><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Catatan</button>
  <!-- <div class="pull-right">
    <a type="button" id="multipleAdd" class="btn btn-danger"><strong><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Multiple Add</strong></a> 
    <a type="button" id="rekapCatatan" class="btn btn-default"><strong><i class="fa fa-save" aria-hidden="true"></i> Rekap Catatan</strong></a> 
    <a type="button" id="cetakPdf" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a>
  </div> -->
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
            <!-- <option value="Tahunan">Tahunan</option> -->
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
        <!-- <div class="col-md-4">
          <div class="form-group">
            <label for="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE">Distribusi Type :</label>
            <select id="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" name="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" class="form-control" onchange="listKWh();">
              <option value="">--Pilih--</option>
              <option value="PRE">PRE</option>
              <option value="RO">RO</option>
              <option value="REJECT">REJECT</option>
            </select>
          </div>
        </div> -->
        <div class="col-md-2">
          <label>&nbsp;</label>
          <div class="input-group custom-search-form">
            <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.End Pencarian -->

  <!-- Tabel -->
  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="sk-wave text-center" id="loader">
          <div class="sk-rect sk-rect1"></div>
          <div class="sk-rect sk-rect2"></div>
          <div class="sk-rect sk-rect3"></div>
          <div class="sk-rect sk-rect4"></div>
          <div class="sk-rect sk-rect5"></div>
        </div>
        <div class="table-responsive Content animasi-table" id="divTable">
          <table class="table table-hover table-bordered table-sticky">
            <thead>
                <tr>
                  <th class="bordered fixsudut" rowspan="2" width="40">NO.</th>
                  <th class="bordered fixsudut" rowspan="2" style="left:40px;"><center><b>FLOWMETER</b></center></th>
                  <th class="bordered" id="tglCatatan"><center><b>TANGGAL</b></center></th>
                  <th class="bordered catatanBeban" rowspan="2"><center><b>BEBAN</b></center></th>
                  <th class="bordered" rowspan="2"><center><b>LOKASI</b></center></th>
                  <th class="bordered" rowspan="2" id="action-btn" width="60"><center><b>AKSI</b></center></th>
                </tr>
                <tr id="colTgl">
                </tr>
            </thead>
            <tbody id="zone_data">
              <!-- <tr> 
                <td class="backloader" colspan="20">
                  <center>
                    <div class="loader"></div>
                  </center>
                </td>
              </tr> -->
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

<!-- //?======= Modal tes -->
<div class="modal fade" id="modalMultipleAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:10000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus" aria-hidden="true"></i> Generate</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form action="https://isea.sambu.co.id/?show=kpe/air/multiple_add" method='post'>
              <div class="form-group">
                <label for="JUMLAH">Jumlah</label>
                <input type="number" class="form-control" id="JUMLAH" name="JUMLAH" autocomplete="off" placeholder="10" step="any" required min='1' max='100'>
                <small class="help-block">Masukkan jumlah catatan flowmeter yang ingin di input</small>
              </div>
              <div class="form-group">
                <label for="TANGGAL">Tanggal</label>
                <input type="text" class="form-control datepicker TANGGAL" id="TANGGAL" name="TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success" id="">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- //?======= end -->

<!-- Modal -->
<div class="modal fade" id="modalCatatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:10000;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Catatan</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:cekSimpan();" class="fDataWilayah" id="fData" name="fDataWilayah">
            <div class="form-group">
              <label for="KPE_KWH_FLOWMETER_ID">Flowmeter</label>
              <select id="KPE_KWH_FLOWMETER_ID" name="KPE_KWH_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" onchange="listCatatanSebelumnya()" required width="100%">
                <option value="" >--Pilih--</option>
                <?php 
                  foreach ($respon_flow['result'] as $rf) {
                    echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>"; 
                  }
                ?>
              </select>
            </div>
            <div class="form-group KPE_KWH_CATATAN_ANGKA">
              <label for="KPE_KWH_CATATAN_ANGKA">Counter</label>
              <input type="number" class="form-control" id="KPE_KWH_CATATAN_ANGKA" name="KPE_KWH_CATATAN_ANGKA" autocomplete="off" placeholder="123.456" step="any" required>
              <input type="hidden" class="form-control" id="KPE_KWH_CATATAN_ANGKA_HIDDEN" name="KPE_KWH_CATATAN_ANGKA_HIDDEN">
              
              <input type="hidden" class="form-control" id="KPE_KWH_CATATAN_ID" name="KPE_KWH_CATATAN_ID" value="">
            </div>
            <div class="form-group KPE_KWH_CATATAN_PAKAI">
              <label for="KPE_KWH_CATATAN_PAKAI">Pakai</label>
              <input type="text" name="KPE_KWH_CATATAN_PAKAI" id="KPE_KWH_CATATAN_PAKAI" class="form-control" required readonly>
            </div>
            <div style="display:none;" id="divPengkondisian">
              <div class="form-group KPE_KWH_CATATAN_PENGKONDISIAN">
                <label for="KPE_KWH_CATATAN_PENGKONDISIAN">Pengkondisian</label>
                <input type="text" name="KPE_KWH_CATATAN_PENGKONDISIAN" id="KPE_KWH_CATATAN_PENGKONDISIAN" class="form-control">
              </div>
              <div class="form-group KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN">
                <label for="KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN">Beban</label>
                <input type="text" name="KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN" id="KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="KPE_KWH_CATATAN_TANGGAL">Tanggal</label>
              <input type="text" class="form-control datepicker KPE_KWH_CATATAN_TANGGAL" id="KPE_KWH_CATATAN_TANGGAL" name="KPE_KWH_CATATAN_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
            </div>
            <div class="form-group">
              <label for="KPE_KWH_CATATAN_NOTE">Note</label>
              <textarea rows='4' class="form-control" id="KPE_KWH_CATATAN_NOTE" name="KPE_KWH_CATATAN_NOTE" placeholder="KPE_KWH_CATATAN_NOTE" autocomplete="off"></textarea>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="PENGKONDISIAN_BEBAN_CHECKBOX" name="PENGKONDISIAN_BEBAN_CHECKBOX">
              <label class="form-check-label"for="PENGKONDISIAN_BEBAN_CHECKBOX">Pengkondisian Beban</label>
            </div>
            <div class="modal-footer">
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

  function loader() {
    let myVar = setTimeout(listKWh, 1000);
  }

  $(function(){
    loader();
    $('[data-toggle="popover"]').popover();
    $(".selectpicker").selectpicker();
    $("input#KPE_KWH_CATATAN_TANGGAL").datepicker().on('changeDate', function(ev)
    {  
      listCatatanSebelumnya();
      $('.datepicker').datepicker('hide');
    });
    $("input#TANGGAL").datepicker().on('changeDate', function(ev)
    { 
      $('.datepicker').datepicker('hide');
    });
    // listKWh();
    $('tr#colTgl').append(/*html*/`<th class="bordered text-center" style="top:35px;">${format_tanggal($('input#DATA_sDATE').val())}</th>`)
  });	

  /*===== Filter Harian,Mingguan,Bulanan dan Tahunan  =====*/
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

      $('#rekapCatatan').removeAttr('style');
      
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

      $('#rekapCatatan').attr("style", "display:none");
    
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

      $('#rekapCatatan').attr("style", "display:none");
    
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

      $('#rekapCatatan').attr("style", "display:none");
    
    }else{
      $('input#DATA_eDATE').attr("readonly","readonly");}
    //search();
  }
  /*===== End filter =====*/

  /*===== Modal tambah catatan =====*/
  $('.modalCatatan').on('click', function(){
    $('form#fData')[0].reset();
    $(".selectpicker").selectpicker("val","");
    $("#modalCatatan").modal('show');
    $("#divPengkondisian").attr("style","display:none;");
    $('#KPE_KWH_CATATAN_ID').val('');
    $('#KPE_KWH_CATATAN_TANGGAL').val("<?php $tanggalAwals = Date('Y/m/d'); echo Date('Y/m/d',strtotime($tanggalAwals.'-1 day'));?>");
    $(".KPE_KWH_CATATAN_ANGKA").removeClass("has-error");
    $(".KPE_KWH_CATATAN_ANGKA").removeClass("has-success");
    $("label#KPE_KWH_CATATAN_ANGKA").removeClass("control-label");
    $("small.angkaSebelumnya").remove();
    $(".KPE_KWH_CATATAN_PAKAI").removeClass("has-error");
    $(".KPE_KWH_CATATAN_PAKAI").removeClass("has-success");
    $("label#KPE_KWH_CATATAN_PAKAI").removeClass("control-label");
  })
  /*===== End modal =====*/

  $("#multipleAdd").click(function(){
    $("#JUMLAH").val()
    $("#TANGGAL").val("<?php $tanggalAwals = Date('Y/m/d'); echo Date('Y/m/d',strtotime($tanggalAwals.'-1 day'));?>")
    $("#modalMultipleAdd").modal('show')
  });

  /*===== Function Cek untuk menyimpan Catatan Keliling =====*/
  function cekSimpan()
  {
    if ($('#KPE_KWH_CATATAN_ANGKA').val() - $('#KPE_KWH_CATATAN_ANGKA_HIDDEN').val() < 0) {
      Swal.fire({
        title: 'Hasil beban minus (-)!',
        text: "Yakin ingin melanjutkan?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, yakin!'
    }).then((result) => {
      if (result.isConfirmed) {
        simpan();
      }
    })
    } else {
      simpan()
    }
  }
  /*===== End cek function simpan Catatan =====*/

  /*===== Function untuk menyimpan Catatan Keliling =====*/
  function simpan()
  {
    $("#btnSimpanCatatan").attr("disabled","disabled");
    var fData=$("#fData").serialize();
    var data = "&KPE_KWH_FLOWMETER_NAMA="+btoa($("#KPE_KWH_FLOWMETER_ID").children("option:selected"). text())+"&"+fData;
    // console.log(data);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      //data:'ref=simpan_catatan&'+data,
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_catatan_kwh&'+data,
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          $("#modalCatatan").modal('hide');
          $(".selectpicker").selectpicker("val","");
          listKWh();
          
        }else if(data.respon.pesan=="gagal")
        {
          Swal.fire({
            title: 'Gagal!',
            text: ''+data.respon.text_msg+'',
            icon: 'error'
          })
          $("#btnSimpanCatatan").removeAttr("disabled");
          listKWh();
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> simpan_catatan()');
      }//end error
    });
  }
  /*===== End function simpan Catatan =====*/

  /*===== Edit catatan keliling =====*/
  $('tbody').on('click', 'a.edit', function(){
    $("#btnSimpanCatatan").removeAttr("disabled");
    const KPE_KWH_CATATAN_ANGKA = $(this).attr('KPE_KWH_CATATAN_ANGKA');
    const KPE_KWH_CATATAN_ID = $(this).attr('KPE_KWH_CATATAN_ID');
    const KPE_KWH_FLOWMETER_NAMA = $(this).attr('KPE_KWH_FLOWMETER_NAMA');
    const KPE_KWH_FLOWMETER_ID = $(this).attr('KPE_KWH_FLOWMETER_ID');
    const KPE_KWH_CATATAN_TANGGAL = $(this).attr('KPE_KWH_CATATAN_TANGGAL');
    const KPE_KWH_CATATAN_NOTE = $(this).attr('KPE_KWH_CATATAN_NOTE');
    const KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN = $(this).attr('KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN');
    const KPE_KWH_CATATAN_PENGKONDISIAN = $(this).attr('KPE_KWH_CATATAN_PENGKONDISIAN');
    // console.log(KPE_KWH_CATATAN_TANGGAL);
    const d = new Date(KPE_KWH_CATATAN_TANGGAL);
    const t = d.getFullYear();
    const b = satuNolDiDepan(d.getMonth()+1);
    const h = satuNolDiDepan(d.getDate());
    $('input#KPE_KWH_CATATAN_ANGKA').val(KPE_KWH_CATATAN_ANGKA);
    $('input#KPE_KWH_CATATAN_ID').val(KPE_KWH_CATATAN_ID);
    $('input#KPE_KWH_CATATAN_TANGGAL').val(t+"/"+b+"/"+h);
    $('input#KPE_KWH_FLOWMETER_NAMA').val(KPE_KWH_FLOWMETER_NAMA);
    if (KPE_KWH_CATATAN_PENGKONDISIAN != "0.00") {
      $("#divPengkondisian").removeAttr("style");
      $("#PENGKONDISIAN_BEBAN_CHECKBOX").prop("checked", true);
      $('input#KPE_KWH_CATATAN_PENGKONDISIAN').val(KPE_KWH_CATATAN_PENGKONDISIAN);
      $('input#KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN').val(KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN);
    } else {
      $("#divPengkondisian").attr("style","display:none;");
      $("#PENGKONDISIAN_BEBAN_CHECKBOX").prop("checked", false);
      $('input#KPE_KWH_CATATAN_PENGKONDISIAN').val("");
      $('input#KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN').val("");
    }
    if (KPE_KWH_CATATAN_NOTE == 'kosong') {
      $('#KPE_KWH_CATATAN_NOTE').val('');
    } else {
      $('#KPE_KWH_CATATAN_NOTE').val(KPE_KWH_CATATAN_NOTE);
    }
    // $('select#KPE_KWH_FLOWMETER_ID').val(KPE_KWH_FLOWMETER_ID);
    $(".selectpicker").selectpicker("val",KPE_KWH_FLOWMETER_ID);

    $("#modalCatatan").modal('show');
    listCatatanSebelumnya();
  });
  /*===== End edit catatan keliling =====*/

  /*===== Function list data catatan =====*/
  function listKWh()
  {

    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');
    // var data = 'tampil_catatan&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage;
    // console.log(data);
    var url = window.location.href;
    var pageA = url.split("#");
    if (pageA[1] == undefined) {var curPage = '1'} else {
      var pageB = pageA[1].split("page-");
      if (pageB[1] == '') {
        var curPage = '1';
      } else {
        var curPage = pageB[1];
      }
    }
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_catatan_kwh&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&TAHUN_FILTER2='+$("select#TAHUN_FILTER2").val()+'&KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE='+$("select#KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        if (data.respon.pesan == "sukses") 
        {
          $("tbody#zone_data").empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });

          console.log(data.respon.text_msg);
              var tableContent = "";
              for (var j = 0; j < data.result.length; j++) 
              {
                // console.log(data.result[j].FLOWMETER);
                var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val();
                if (data.result[j].FLOWMETER == "") {
                  var JFLOWMETER = 0;
                  if (JENIS_LAPORAN == "Harian") {
                    var cols = 7;
                  }else if (JENIS_LAPORAN == "Mingguan") {
                    cols = 11;
                  } else if (JENIS_LAPORAN == "Bulanan"){
                    var fromdate = new Date();
                    var lastDay = new Date(fromdate.getFullYear(), fromdate.getMonth(), 0);
                    cols = lastDay.getDate();
                  }
                } else {
                  JFLOWMETER = data.result[j].FLOWMETER.length;
                  cols = 0;
                }
							// calculate rowspan for first cell
                var rowspan = 1;
                
                rowspan += JFLOWMETER;
                // create rows
                tableContent += /*html*/`<tr class="trData">
                                          <td class="bordered fixed" rowspan="${rowspan}">${data.result[j].NO}.</td>
                                          <td class="bordered fixed" style="left:40px;" rowspan="${rowspan}" colspan="${cols}">${data.result[j].KPE_KWH_FLOWMETER_NAMA}</td>
                                        </tr>`;

                /*===== Button disable setelah 2 hari penginputan =====*/
                var d = new Date();
                var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + (d.getDate()-2) + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                  
                
                for (var i = 0; i < data.result[j].FLOWMETER.length; i++) 
                {
                  var date = new Date(data.result[j].FLOWMETER[i].ENTRI_WAKTU);
                  var tanggal = date.getFullYear() +"/" + (date.getMonth()+1) + "/" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds(); 
                  if (new Date(tanggal) < new Date(strDate)) {
                    var disabled = 'disableda';
                  }
                  else{
                    var disabled = '';
                  }
                  /*===== End button disable =====*/
                  
                  /*===== Pengkondisian menampilkan button edit dan delete =====*/
                  const object = data.result[j].FLOWMETER[i];
                  var listData = '';
                  var property;
                 
                  if (JENIS_LAPORAN == "Harian") 
                  {

                    $("th.catatanBeban").after('<th class="bordered bebanXreading" rowspan="2" width="50"><center><b>BEBAN*READING</b></center></th>')
                    var listData =  /*html*/`<td class="bordered text-right"> ${formatNumber(data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_ANGKA)} </td>
                                    <td class="bordered text-right"> ${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_BEBAN} </td>
                                    <td class="bordered text-right"> ${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_BEBAN_X_READING} </td>
                                    <td class="bordered"> ${data.result[j].FLOWMETER[i].KPE_KWH_FLOWMETER_LOKASI} </td>`;
                    var btnEdit = /*html*/`<td class="bordered text-center">
                                            <div class="dropleft">
                                              <button type="button" class="btn btn-sm btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ${disabled}>
                                                <strong><i class="fa fa-ellipsis-v"></i></strong>
                                              </button>
                                              <div class="dropdown-menu">
                                                <li><a class="edit" style='color:rgb(0, 48, 73);' KPE_KWH_FLOWMETER_ID="${data.result[j].FLOWMETER[i].KPE_KWH_FLOWMETER_ID}" KPE_KWH_CATATAN_NOTE="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_NOTE}" KPE_KWH_CATATAN_ANGKA="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_ANGKA}" KPE_KWH_CATATAN_TANGGAL="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_TANGGAL}" KPE_KWH_FLOWMETER_NAMA="${data.result[j].FLOWMETER[i].KPE_KWH_FLOWMETER_NAMA}" KPE_KWH_CATATAN_ID="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_ID}" KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN}" KPE_KWH_CATATAN_PENGKONDISIAN="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_PENGKONDISIAN}" ><i class="fa fa-edit"></i>Edit </a></li>
                                                <li><a class="hapus" style='color:brown;' KPE_KWH_CATATAN_ID="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_ID}" KPE_KWH_FLOWMETER_ID="${data.result[j].FLOWMETER[i].KPE_KWH_FLOWMETER_ID}" KPE_KWH_CATATAN_TANGGAL="${data.result[j].FLOWMETER[i].KPE_KWH_CATATAN_TANGGAL}"><i class="fa fa-trash"></i> Hapus </a></li>
                                              </div>
                                            </div>
                                          </td>`;
                  }
                  else if (JENIS_LAPORAN == "Mingguan")
                  {
                    $("th.bebanXreading").remove()
                    for (property in object) {
                      var x = object[property];
                      if (x == object['KPE_KWH_FLOWMETER_LOKASI'] || x == object['KPE_KWH_FLOWMETER_NAMA']) {
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
                    $("th.bebanXreading").remove()
                    for (property in object) {
                      const x = object[property];
                      if (x == object['KPE_KWH_FLOWMETER_LOKASI'] || x == object['KPE_KWH_FLOWMETER_NAMA']) {
                        var align = 'text-left';
                      } else {
                        align = 'text-right';
                      }
                      if (x == object['KPE_KWH_FLOWMETER_NAMA']) {
                        var freze = "style='left:136px;'";
                      } else {
                        freze = "style='z-index:1;'";
                      }
                      listData +=  /*html*/`<td class="bordered ${align} fixed" ${freze} >${formatNumber(object[property])}</td>`;
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
                  /*===== End pengkondisian =====*/

                  tableContent += /*html*/`<tr class="trData">${listData+btnEdit}</tr>`;
                                
                }
              }
              $("tbody#zone_data").append(tableContent);//append list catatan

              // $('a.sidebar-toggle').click()

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
  /*===== End function list catatan keliling =====*/

  $(window).on('hashchange', function(e) {
    preLoader()
  });
  $("input#REC_PER_HALAMAN").on('change', function() {
    preLoader();
  });

  /*===== Hapus catatan keliling =====*/
  $('tbody').on('click', 'a.hapus', function(){
    const KPE_KWH_CATATAN_ID = $(this).attr('KPE_KWH_CATATAN_ID');
    const KPE_KWH_FLOWMETER_ID = $(this).attr('KPE_KWH_FLOWMETER_ID');
    const KPE_KWH_CATATAN_TANGGAL = $(this).attr('KPE_KWH_CATATAN_TANGGAL');
    // alert('&KPE_AIR_FLOWMETER_CATATAN_ID='+KPE_AIR_FLOWMETER_CATATAN_ID+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+KPE_AIR_FLOWMETER_CATATAN_TANGGAL);

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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_catatan_kwh&KPE_KWH_CATATAN_ID='+KPE_KWH_CATATAN_ID+'&KPE_KWH_FLOWMETER_ID='+KPE_KWH_FLOWMETER_ID+'&KPE_KWH_CATATAN_TANGGAL='+KPE_KWH_CATATAN_TANGGAL,
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
              listKWh();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              listKWh();
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
  /*===== End hapus catatan =====*/

  /*===== Function list catatan hari sebelumnya =====*/
  function listCatatanSebelumnya() {
    
    var KPE_KWH_FLOWMETER_ID = $("#KPE_KWH_FLOWMETER_ID").val();
    var date = new Date($("#KPE_KWH_CATATAN_TANGGAL").val());
    date = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    var KPE_KWH_CATATAN_TANGGAL = date.getFullYear() + '/' + satuNolDiDepan(date.getMonth()+1) + '/' + satuNolDiDepan(date.getDate());   

    $("small.angkaSebelumnya").remove();
    // list_flowmeter_kalibrasi()

    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_catatan_kwh_sebelumnya&KPE_KWH_FLOWMETER_ID='+KPE_KWH_FLOWMETER_ID+'&KPE_KWH_CATATAN_TANGGAL='+KPE_KWH_CATATAN_TANGGAL,
      success: function(data) {
        // console.log(data.result);
        if (data.respon.pesan == "sukses" && data.result[0].CATATAN != null) 
        {
          for (var i = 0; i < data.result.length; i++) {
            if (data.result[i].CATATAN == null) {
              $("#KPE_KWH_CATATAN_ANGKA").removeAttr("onkeyup");
              $("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val(""); 
            } else {
              $("#KPE_KWH_CATATAN_ANGKA").attr("onkeyup","cekCatatanCounter();"); 
              $("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val(data.result[i].CATATAN.KPE_KWH_CATATAN_ANGKA);
              $(".KPE_KWH_CATATAN_ANGKA").append('<small class="angkaSebelumnya" style="color:#666"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Catatan counter sebelumnya : <b>'+$("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val()+'</b> => Beban sebelumnya : <b>'+formatNumber(data.result[i].CATATAN.KPE_KWH_CATATAN_BEBAN)+'</b></small>');
              
            }
          }
          cekCatatanCounter();
        }else
        {
          let month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
          let dateKosong = new Date(data.result[0].CATATAN_TERAKHIR.KPE_KWH_CATATAN_TANGGAL);
          dateKosong = new Date((new Date(dateKosong)).valueOf() + 1000*60*60*24);
          let KPE_KWH_CATATAN_TANGGAL_KOSONG = satuNolDiDepan(dateKosong.getDate()) + " " + month[dateKosong.getMonth()] + " " + dateKosong.getFullYear();
          let KPE_KWH_CATATAN_TANGGAL_KOSONGS = dateKosong.getFullYear() + '/' + satuNolDiDepan(dateKosong.getMonth()+1) + '/' + satuNolDiDepan(dateKosong.getDate());   
          Swal.fire({
            title: ""+KPE_KWH_CATATAN_TANGGAL_KOSONG+"",
            text: "Catatan angka tanggal "+KPE_KWH_CATATAN_TANGGAL_KOSONGS+" belum terisi!",
            icon: 'error',
          })
        }
      },
      error:function(x,e){
        // error_handler_json(x,e,'=> hapus_catatan()');
        console.log("error")
      }
    })
  }
  /*===== End list catatan sebelumnya =====*/

  /*===== Cek catatan yg diinput lebih besar atau lebih kecil dari angka sebelumnya =====*/
  function cekCatatanCounter() {
    if ($("#KPE_KWH_CATATAN_ANGKA").val() == "") {
      
    } else {
      const catatanKSebelum = ($("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val())*0.80;
      const catatanKSebelumnya = catatanKSebelum.toFixed(2);
      const catatanLSebelum = ($("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val())/0.50;
      const catatanLSebelumnya = catatanLSebelum.toFixed(2);
      const catatanSekarang = parseFloat($("#KPE_KWH_CATATAN_ANGKA").val());
      $("small.help-block").remove();
      
      if(catatanSekarang == $("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val()){
        $(".KPE_KWH_CATATAN_ANGKA").removeClass("has-error");
        $(".KPE_KWH_CATATAN_ANGKA").addClass("has-success");
        $("label#KPE_KWH_CATATAN_ANGKA").addClass("control-label");
        $(".KPE_KWH_CATATAN_ANGKA").append('<small class="help-block">Angka yang dimasukkan sama dengan angka sebelumnya.</small>');
        $("#btnSimpanCatatan").removeAttr("disabled");
      } else if (catatanLSebelumnya == 0.000 && catatanSekarang > $("#KPE_KWH_CATATAN_ANGKA_HIDDEN").val()){
        $(".KPE_KWH_CATATAN_ANGKA").removeClass("has-error");
        $(".KPE_KWH_CATATAN_ANGKA").addClass("has-success");
        $("label#KPE_KWH_CATATAN_ANGKA").addClass("control-label");
        $("#btnSimpanCatatan").removeAttr("disabled");
      } else if (catatanSekarang < catatanKSebelumnya) {
        $(".KPE_KWH_CATATAN_ANGKA").addClass("has-error");
        $("label#KPE_KWH_CATATAN_ANGKA").addClass("control-label");
        $(".KPE_KWH_CATATAN_ANGKA").append('<small class="help-block">Angka yang dimasukkan terlalu kecil dari angka sebelumnya.</small>');
        $("#btnSimpanCatatan").attr("disabled","disabled");
      } else {
        $(".KPE_KWH_CATATAN_ANGKA").removeClass("has-error");
        $(".KPE_KWH_CATATAN_ANGKA").addClass("has-success");
        $("label#KPE_KWH_CATATAN_ANGKA").addClass("control-label");
        $("#btnSimpanCatatan").removeAttr("disabled");
      }


      const bebanSekarang = (parseFloat($('#KPE_KWH_CATATAN_ANGKA').val()) - parseFloat($('#KPE_KWH_CATATAN_ANGKA_HIDDEN').val())).toFixed(2);
      
      if (parseFloat(bebanSekarang) >= 0 ) {
        $('#KPE_KWH_CATATAN_PAKAI').val(bebanSekarang);
        $('.KPE_KWH_CATATAN_PAKAI').removeClass("has-error");
        $('.KPE_KWH_CATATAN_PAKAI').addClass("has-success");
        $('label#KPE_KWH_CATATAN_PAKAI').addClass("control-label");
        // $('#KPE_KWH_CATATAN_PAKAI').attr("style","border-color:#3c763d; color:#3c763d;");
      } else {
        $('#KPE_KWH_CATATAN_PAKAI').val(bebanSekarang);
        $('.KPE_KWH_CATATAN_PAKAI').addClass("has-success");
        $('.KPE_KWH_CATATAN_PAKAI').addClass("has-error");
        $('label#KPE_KWH_CATATAN_PAKAI').addClass("control-label");
        // $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA').attr("style","border-color:#a94442; color:#a94442;");
      }
    }
  }
  /*===== End cek catatan =====*/

  function cekPengkondisian() {
    const pengkondisian = (parseFloat($('#KPE_KWH_CATATAN_PAKAI').val()) + parseFloat($('#KPE_KWH_CATATAN_PENGKONDISIAN').val())).toFixed(2)
    if (pengkondisian.toString() == "NaN") {
      $("#KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN").val("");   
    } else {
      $("#KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN").val(pengkondisian);    
    }
  }

  $("input#PENGKONDISIAN_BEBAN_CHECKBOX").on('change', function() {
    if ($('input#PENGKONDISIAN_BEBAN_CHECKBOX').is(':checked')) {
      $("#divPengkondisian").removeAttr("style");
      $("#KPE_KWH_CATATAN_PENGKONDISIAN").attr("onkeyup","cekPengkondisian()");
    } else {
      // console.log("nocek");
      $("#divPengkondisian").attr("style","display:none;");
      $("#KPE_KWH_CATATAN_PENGKONDISIAN").removeAttr("onkeyup");
      $("#KPE_KWH_CATATAN_PENGKONDISIAN_BEBAN").val("");
      $('#KPE_KWH_CATATAN_PENGKONDISIAN').val("")
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

  /*===== Append colom tanggal (<th>) =====*/
  $('#btn-reload').click(function(){
    preLoader();
    var JENIS_LAPORAN = $('select#JENIS_LAPORAN').val();
    $('tr#colTgl').empty();
    if (JENIS_LAPORAN == "Harian") 
    {
      $('th#action-btn').removeAttr("style");
      $('th.catatanBeban').removeAttr("style");
      $('th#tglCatatan').attr("colspan",1);
      $('tr#colTgl').append(/*html*/`<th class="bordered" style="top:35px;">${format_tanggal($('input#DATA_sDATE').val())}</th>`)
    } else if (JENIS_LAPORAN == "Mingguan")
    {	
      $('th#action-btn').attr("style","display:none");
      $('th.catatanBeban').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",7);
      for (var j = 0; j < GetDays().length; j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered" style="top:35px;">${GetDays()[j]}</th>`)
      }
    } else if (JENIS_LAPORAN == "Bulanan")
    {	
      var nowmonth = new Date($('select#BULAN_FILTER').val());
      var nowyear = new Date($('select#TAHUN_FILTER2').val());
      var monthEndDay = new Date(nowyear.getFullYear(), nowmonth.getMonth() + 1, 0);
      $('th#action-btn').attr("style","display:none");
      $('th.catatanBeban').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",parseInt(monthEndDay.getDate()));
      for (var j = 0; j < monthEndDay.getDate(); j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered" style="top:35px;">${GetMonth(parseInt(monthEndDay.getDate()))[j]}</th>`)
      }
    
    }else if (JENIS_LAPORAN == "Tahunan")
    {
      $('th#action-btn').attr("style","display:none");
      $('th.catatanBeban').attr("style","display:none");
      $('th#tglCatatan').attr("colspan",12);
      for (var j = 0; j < GetYear().length; j++) 
      {
        $('tr#colTgl').append(/*html*/`<th class="bordered" style="top:35px;">${GetYear()[j]}</th>`)
      }
    } else {

    }
  })
  /*===== End append colom tanggal (<th>) =====*/

  function search() {
    listKWh();
  }

  $('#cetakPdf').on('click', function(){
    //listKWh();
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

  $("#rekapCatatan").click(function () {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Pastikan semua flowmeter sudah terisi sebelum merekapnya!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, yakin!'
    }).then((result) => {
      if (result.isConfirmed) {
        if ($('#KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE').val() == '') {
          Swal.fire({
            title: 'Gagal!',
            text: 'Silahkan pilih distribusi type terlebih dahulu sebelum rekap catatan',
            icon: 'error'
          })
        } else {
          let now = new Date($('#DATA_sDATE').val());
          let start = new Date(now.getFullYear(), 0, 0);
          let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
          let oneDay = 1000 * 60 * 60 * 24;
          let day = Math.floor(diff / oneDay);
          if ($('#KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE').val() == 'PRE') {
            var rekapUsed = 'simpan_rekap_used_pre';
            var tanggal = 'KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL=';
            var codding = 'KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING=';
          } else {
            rekapUsed = 'simpan_rekap_used_ro';
            tanggal = 'KPE_AIR_FLOWMETER_REKAP_USED_RO_TANGGAL=';
            codding = 'KPE_AIR_FLOWMETER_REKAP_USED_RO_CODDING=';
          }
          // return
          $.ajax({
            type:'POST',
            url:refseeAPI,
            dataType:'json',
            data:'aplikasi=<?php echo $d0;?>&ref='+rekapUsed+'&'+tanggal+$('#DATA_sDATE').val()+'&'+codding+day,
            success:function(data)
            { 
              if(data.respon.pesan=="sukses")
              {
                Swal.fire({
                  title: 'Berhasil!',
                  text: ''+data.respon.text_msg+'',
                  icon: 'success',
                })
              }else if(data.respon.pesan=="gagal")
              {
                Swal.fire({
                  title: 'Gagal!',
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
      }
    })
  })

</script>
