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

  // echo "<pre>".print_r($respon_ctt['result'],true)."</pre>";
//exit();
?>

<link rel="stylesheet" href="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

  table, .bodered{
    border-collapse: separate;
  }

  .fixed-top {
    background: white;
    top: 35px;
    position: sticky;
    z-index: 6;
  }

  .list-kosong {
    background-color:rgb(255, 204, 204);
  }

  .dropright {
    position: relative;
  }

  .dropright .dropdown-menu {
    top: 0;
    right: auto;
    left: 100%;
    margin-top: 0;
    margin-left: 0.125rem;
  }

  .dropright .dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid transparent;
    border-right: 0;
    border-bottom: 0.3em solid transparent;
    border-left: 0.3em solid;
  }

  .dropright .dropdown-toggle:empty::after {
    margin-left: 0;
  }

  .dropright .dropdown-toggle::after {
    vertical-align: 0;
  }

  table.table-bodered, .bordered{
    border:1px solid #ccc !important;
  }

  .swal2-container {
    z-index: 11000000;
  }

  .swal2-popup {
    font-size: 1.3rem !important; 
  }

  .daterangepicker.dropdown-menu {
    z-index: 99 !important;
  }

  .input-group.first {
    z-index: 99 !important;
  }
</style>
<div class="box-body">
  <button class="btn btn-success" id="btnTambahData"><i class="fa fa-plus-square"></i> Bahan Kimia Pre</button>
  <br><br>
  <!-- Pencarian -->
  <div class="box box-solid bg-teal-gradient collapsed-box">
    <div class="box-header">
      <i class="fa fa-calendar"></i>

      <h3 class="box-title">Akumulasi</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="box-body border-radius-none">
      
    <!-- Jenis Akumulasi -->
    <div class="row">
      <div class="col-md-2 form-group">
        <label for="JENIS_LAPORAN">Jenis Akumulasi</label>
        <select class="form-control col-sm-2" name="JENIS_LAPORAN" id="JENIS_LAPORAN" onchange="jenisAkumulasi()" required>
          <option value="0">--Pilih--</option>
          <!-- <option value="Harian">Harian</option> -->
          <!-- <option value="Mingguan">Mingguan</option> -->
          <option value="Bulanan">Bulanan</option>
          <option value="Custom">Custom</option>
        </select>
      </div>
      
      <div class="col-md-2 form-group tanggalawal"  id="divtanggalawal" hidden>
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
      <div class="col-md-4 " id="divDateRange" hidden>
        <div class="form-group">
          <label>Tanggal</label>
          <div class="input-group first custom-search-form">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="dateRange" name="dateRange" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <label>&nbsp;</label>
        <div class="input-group custom-search-form">
          <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
        </div>
      </div>
    </div>
    <!-- End akumulasi-->

    </div>
  </div>
  <!-- /.End Pencarian -->
  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive Content">
          <table class="table table-hover table-sticky">
            <thead>
                <tr>
                  <th class="bordered text-center" rowspan="3" colspan="2">#</th>
                  <th class="bordered text-center" rowspan="3">Codding</th>
                  <th class="bordered text-center" rowspan="3">Tanggal</th>
                  <th class="bordered text-center" colspan="15">Bahan Kimia</th>
                  <th class="bordered text-center" colspan="5" rowspan="2">Stock</th>
                  <th class="bordered text-center" rowspan="2">Effiensi Bahan Kimia (Caustic)</th>
                </tr>
                <tr>
                  <th class="bordered text-center" colspan="5" style="top:46px;">Terima</th>
                  <th class="bordered text-center" colspan="5" style="top:46px;">Pakai</th>
                  <th class="bordered text-center" colspan="5" style="top:46px;">Akumulasi Pakai</th>
                </tr>
                <tr>
                  <th class="bordered text-center" style="top:95px;">Hydro 4041</th>
                  <th class="bordered text-center" style="top:95px;">Tawas</th>
                  <th class="bordered text-center" style="top:95px;">Caustic</th>
                  <th class="bordered text-center" style="top:95px;">TCCA - kg</th>
                  <th class="bordered text-center" style="top:95px;">Polimer</th>
                  <th class="bordered text-center" style="top:95px;">Hydro 4041</th>
                  <th class="bordered text-center" style="top:95px;">Tawas</th>
                  <th class="bordered text-center" style="top:95px;">Caustic</th>
                  <th class="bordered text-center" style="top:95px;">TCCA - kg</th>
                  <th class="bordered text-center" style="top:95px;">Polimer</th>
                  <th class="bordered text-center" style="top:95px;">Akumulasi Hydro 4041</th>
                  <th class="bordered text-center" style="top:95px;">Akumulasi Tawas</th>
                  <th class="bordered text-center" style="top:95px;">Akumulasi Caustic</th>
                  <th class="bordered text-center" style="top:95px;">Akumulasi TCCA</th>
                  <th class="bordered text-center" style="top:95px;">Akumulasi Polimer</th>
                  <th class="bordered text-center" style="top:95px;">Stock Hydro 4041 (kg)</th>
                  <th class="bordered text-center" style="top:95px;">Stock Tawas (kg)</th>
                  <th class="bordered text-center" style="top:95px;">Stock Caustic (kg)</th>
                  <th class="bordered text-center" style="top:95px;">Stock TCCA</th>
                  <th class="bordered text-center" style="top:95px;">Stock Polimer</th>
                  <th class="bordered text-center" style="top:95px;">Effiensi Bahan Kimia (Caustic)</th>
                </tr>
            </thead>
            <tbody id="zone_data">
              <tr>
                <td class="backloader" colspan="17">
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

<!-- //? Modal Tambah Data OPN -->
<div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Bahan Kimia Pre</h4>
      </div>
      <div class="modal-body">
      <form action="javascript:simpanKimiaPre();" class="fData" id="fData" name="fData">
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL">Tanggal</label>
                  <input type="text" class="form-control datepicker" id="KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL" name="KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING">Codding</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING" name="KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING" autocomplete="off" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="text-danger"><i class="fa fa-cart-arrow-down"></i> BAHAN KIMIA TERIMA</h4>
                <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_ID" name="KPE_AIR_FLOWMETER_KIMIA_PRE_ID" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_ID" autocomplete="off">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_ID">Hydro 4041</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA">Tawas</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA">Caustic</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA">TCCA - kg</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA">Polimer</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <h4 class="text-success"><i class="fa fa-check"></i> BAHAN KIMIA PAKAI</h4>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI">Hydro 4041</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI">Tawas</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI">Caustic</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI">TCCA - kg</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI">Polimer</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success" id="btnSimpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  $(function() {
    $('a.sidebar-toggle').click();
    $('input[name="dateRange"]').daterangepicker();
    $("input#KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL").datepicker().on('changeDate', function(ev)
    {
      let now = new Date($("input#KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL").val());
      let start = new Date(now.getFullYear(), 0, 0);
      let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
      let oneDay = 1000 * 60 * 60 * 24;
      let day = Math.floor(diff / oneDay);
      $('input#KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING').val(depanKosong(day));
      $('.datepicker').datepicker('hide');
    });
    $('#dateRange').val('');
    listKimiaPre();
  })

  $('#btnTambahData').on('click',function() {
    $('#modalTambahData').modal('show');
    $('form#fData')[0].reset();
    $('#KPE_AIR_FLOWMETER_KIMIA_PRE_ID').val('');
  })

  function formatDate(date) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
  }

  function depanKosong(x){
    if (x<10) {
      y = '00'+x;
    } else if(x<100){
      y = '0'+x;
    } else {
      y = x;
    }
    return y;
  }

  function tambahKosong(x){
    y = (x>9) ? x : '0'+x;
    return y;
  }

  $('#btn-reload').click(function(){
    listKimiaPre();
  })

  //?======== AKUMULASI ===========?//
  function jenisAkumulasi(){
    var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val(); 
    if (JENIS_LAPORAN == "0") 
    {
    
      $('input#DATA_sDATE').removeAttr("disabled");
      $('input#DATA_sDATE').attr("required");
      $('div#divtanggalawal').attr("style", "display:none");
      $('label#labelsDate').html("Tanggal");
      $('input#DATA_sDATE').val("");
      
      $('input#DATA_eDATE').removeAttr("disabled");
      $('input#DATA_eDATE').attr("readonly","readonly");
      $('div#divtanggalakhir').attr("style", "display:none");
      
      $('select#BULAN_FILTER').attr("disabled","disabled");
      $('select#BULAN_FILTER').removeAttr("required");
      $('select#BULAN_FILTER').val("");
      $('div#divbulanfilter').attr("style", "display:none");
      
      $('select#TAHUN_FILTER').attr("disabled","disabled");
      $('select#TAHUN_FILTER').removeAttr("required");
      $('div#divtahunfilter').attr("style", "display:none");
      $('select#TAHUN_FILTER').val("");

      $('input#dateRange').attr("disabled","disabled");
      $('input#dateRange').removeAttr("required");
      $('div#divDateRange').attr("style", "display:none");
      $('input#dateRange').val("");
      
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

      $('input#dateRange').attr("disabled","disabled");
      $('input#dateRange').removeAttr("required");
      $('div#divDateRange').attr("style", "display:none");
      $('input#dateRange').val("");
    
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
      $('div#divtahunfilter').attr("style", "display:block");

      $('input#dateRange').attr("disabled","disabled");
      $('input#dateRange').removeAttr("required");
      $('div#divDateRange').attr("style", "display:none");
      $('input#dateRange').val("");
    
    }else if (JENIS_LAPORAN == "Custom")
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
      
      $('input#dateRange').removeAttr("disabled");
      $('input#dateRange').attr("required");
      $('input#dateRange').val("");
      $('div#divDateRange').attr("style", "display:block");

      $('select#TAHUN_FILTER').attr("disabled","disabled");
      $('select#TAHUN_FILTER').removeAttr("required");
      $('div#divtahunfilter').attr("style", "display:none");
      $('select#TAHUN_FILTER').val("");
    
    }else{
      $('input#DATA_eDATE').attr("readonly","readonly");}
    //search();
  }
  //?========= END AKUMULASI ===========?//

  //?========= SIMPAN KIMIA PRE ==============?//
  function simpanKimiaPre() {
    let fData = $('#fData').serialize();
    let date = new Date($("#KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL").val());
    let dateSebelumnya = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    let KPE_AIR_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA = dateSebelumnya.getFullYear() + '/' + tambahKosong(dateSebelumnya.getMonth()+1) + '/' + tambahKosong(dateSebelumnya.getDate());
    // console.log(fData);
    // return

    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_kimia_pre&KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL_SEBELUMNYA='+KPE_AIR_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA+'&'+fData,
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          Swal.fire({
            timer: 1000,
            timerProgressBar: true,
            title: 'Berhasil!',
            text: ''+data.respon.text_msg+'',
            icon: 'success',
          });
          $('#modalTambahData').modal('hide');
          console.log(data.result);
          listKimiaPre();
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
        error_handler_json(x,e,'=> simpan_kimia_pre()');
      }//end error
    });
  }
  //?=========== END SIMPAN KIMIA PRE ==============?//

  //?========= LIST KIMIA PRE ==============?//
  function listKimiaPre() {
    $('tbody#zone_data').empty();
    let fromDate = $("#dateRange").val().split("-");
    let dateRangeS = formatDate(fromDate[0]);
    let dateRangeE = formatDate(fromDate[1]);

    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_kimia_pre&dateRangeS='+dateRangeS+'&dateRangeSE='+dateRangeE+'&BULAN_FILTER='+$('#BULAN_FILTER').val()+'&TAHUN_FILTER='+$('#TAHUN_FILTER').val(),
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          console.log(data.result);
          for (let i = 0; i < data.result.length; i++) {
            let listData = '';
            if (data.result[i].KIMIA == "") {
              listData = /*html*/`<td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>`;
            } else {
              listData = /*html*/`<td class="bordered"><button class="btn btn-sm btn-danger" id="hapus" KPE_AIR_FLOWMETER_KIMIA_PRE_ID="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_ID}"><i class="fa fa-trash"></i></button></td>
                                  <td class="bordered"><button class="btn btn-sm btn-primary" id="edit" KPE_AIR_FLOWMETER_KIMIA_PRE_ID="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_ID}" KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING}" KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL}" KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI}"><i class="fa fa-edit"></i></button></td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_STOCK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_STOCK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_STOCK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_STOCK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_STOCK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_PRE_EFFIENSI_CAUSTIC}</td>`;
            }
            $('tbody#zone_data').append(/*html*/`<tr>
                                                  ${listData}
                                                 </tr>`);
          }
        }else if(data.respon.pesan=="gagal")
        {
          $("tbody#zone_data").html(/*html*/`<tr><td colspan="20" class="bordered"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> list_kimia_pre()');
      }//end error
    });
  }
  //?=========== END LIST KIMIA PRE ==============?//

  //?===== HAPUS KIMIA PRE =====?//
  $('tbody').on('click', 'button#hapus', function(){
    let KPE_AIR_FLOWMETER_KIMIA_PRE_ID = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_ID');
    
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_kimia_pre&KPE_AIR_FLOWMETER_KIMIA_PRE_ID='+KPE_AIR_FLOWMETER_KIMIA_PRE_ID,
          success:function(data)
          { 
            if(data.respon.pesan=="sukses")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Berhasil!',
                text: 'Data berhasil dihapus.',
                icon: 'success',
              })
              listKimiaPre();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              listKimiaPre();
            }
          },
          error:function(x,e){
            // error_handler_json(x,e,'=> hapus_catatan()');
            console.log('error');
          }//end error
        });
      }
    })
  })
  //?===== END HAPUS KIMIA PRE =====?//

  //?===== EDIT KIMIA PRE =====?//
  $('tbody').on('click', 'button#edit', function(){
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Ingin mengedit data ini?!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Tidak!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, yakin!'
    }).then((result) => {
      if (result.isConfirmed) {
        $('form#fData')[0].reset();
        let KPE_AIR_FLOWMETER_KIMIA_PRE_ID = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_ID');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI');

        // console.log(KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI);
        let date = new Date(KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL);
        let day = date.getDate();
        let month = date.getMonth()+1;
        let year = date.getFullYear();
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_ID').val(KPE_AIR_FLOWMETER_KIMIA_PRE_ID);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING').val(KPE_AIR_FLOWMETER_KIMIA_PRE_CODDING);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_TANGGAL').val(year+'/'+tambahKosong(month)+'/'+tambahKosong(day));
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_PRE_HYDRO_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_PRE_TAWAS_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_PRE_CAUSTIC_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_PRE_TCCA_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_PRE_POLIMER_PAKAI);
        $('#modalTambahData').modal('show');
      }
    })
  })
  //?===== END EDIT KIMIA PRE =====?//
</script>