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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
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

  .daterangepicker.dropdown-menu {
    z-index: 99 !important;
  }

  .input-group.first {
    z-index: 99 !important;
  }
</style>
<div class="box-body">
  <button class="btn btn-success" id="btnTambahData"><i class="fa fa-plus-square"></i> Bahan Kimia RO</button>
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
      <div class="sk-wave text-center" id="loader">
        <div class="sk-rect sk-rect1"></div>
        <div class="sk-rect sk-rect2"></div>
        <div class="sk-rect sk-rect3"></div>
        <div class="sk-rect sk-rect4"></div>
        <div class="sk-rect sk-rect5"></div>
      </div>
      <div class="col-md-12 animasi-table" id="divTable">
        <div class="table-responsive Content">
          <table class="table table-hover table-sticky">
            <thead>
                <tr>
                  <th class="bordered text-center" rowspan="3" colspan="2">#</th>
                  <th class="bordered text-center" rowspan="3">Codding</th>
                  <th class="bordered text-center" rowspan="3">Tanggal</th>
                  <th class="bordered text-center" colspan="25">Bahan Kimia - PROSES RO</th>
                </tr>
                <tr>
                  <th class="bordered text-center" colspan="6" style="top:35px;">Terima</th>
                  <th class="bordered text-center" colspan="7" style="top:35px;">Pakai</th>
                  <th class="bordered text-center" colspan="6" style="top:35px;">Akumulasi Pakai</th>
                  <th class="bordered text-center" colspan="6" style="top:35px;">Stock</th>
                </tr>
                <tr>
                  <th class="bordered text-center" style="top:73px;">Hydro 590 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 277 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 566 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 259 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 575 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Garam (kg)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 590 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 277 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 566 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 259 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 575 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Garam (kg)</th>
                  <th class="bordered text-center" style="top:73px;">Caustick (kg)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 590 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 277 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 566 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 259 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 575 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Garam (kg)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 590 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 277 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 566 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 259 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Hydro 575 (lt)</th>
                  <th class="bordered text-center" style="top:73px;">Garam (kg)</th>
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
        <h4 class="modal-title" id="exampleModalLabel">Bahan Kimia RO</h4>
      </div>
      <div class="modal-body">
      <form action="javascript:simpanKimiaRo();" class="fData" id="fData" name="fData">
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL">Tanggal</label>
                  <input type="text" class="form-control datepicker" id="KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL" name="KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_CODDING">Codding</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_CODDING" name="KPE_AIR_FLOWMETER_KIMIA_RO_CODDING" autocomplete="off" readonly>
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
                <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_ID" name="KPE_AIR_FLOWMETER_KIMIA_RO_ID" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_ID" autocomplete="off">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA">Hydro 590</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA">Hydro 277</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA">Hydro 566</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA">Hydro 259</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA">Hydro 575</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA">Garam</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA" name="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <h4 class="text-success"><i class="fa fa-check"></i> BAHAN KIMIA PAKAI</h4>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI">Hydro 590</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI">Hydro 277</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI">Hydro 566</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI">Hydro 259</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI">Hydro 575</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI">Garam</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI">Caustic</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI" name="KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI" placeholder="KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI" autocomplete="off">
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
  function loader() {
    let myLoader = setTimeout(listKimiaRo, 2000);
  }

  $(function() {
    $('input[name="dateRange"]').daterangepicker();
    $("input#KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL").datepicker().on('changeDate', function(ev)
    {
      let now = new Date($("input#KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL").val());
      let start = new Date(now.getFullYear(), 0, 0);
      let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
      let oneDay = 1000 * 60 * 60 * 24;
      let day = Math.floor(diff / oneDay);
      $('input#KPE_AIR_FLOWMETER_KIMIA_RO_CODDING').val(codding(day));
      $('.datepicker').datepicker('hide');
    });
    $('#dateRange').val('');
    loader();
  })

  $('#btnTambahData').on('click',function() {
    $('#modalTambahData').modal('show');
    $('form#fData')[0].reset();
    $('#KPE_AIR_FLOWMETER_KIMIA_RO_ID').val('');
  })

  $('#btn-reload').click(function(){
    preLoader();
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

  //?========= SIMPAN KIMIA RO ==============?//
  function simpanKimiaRo() {
    let fData = $('#fData').serialize();
    let date = new Date($("#KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL").val());
    let dateSebelumnya = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    let KPE_AIR_OPERASIONAL_RO_TANGGAL_SEBELUMNYA = dateSebelumnya.getFullYear() + '/' + satuNolDiDepan(dateSebelumnya.getMonth()+1) + '/' + satuNolDiDepan(dateSebelumnya.getDate());
    // console.log(fData);
    // return

    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_kimia_ro&KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL_SEBELUMNYA='+KPE_AIR_OPERASIONAL_RO_TANGGAL_SEBELUMNYA+'&'+fData,
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
          listKimiaRo();
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
        error_handler_json(x,e,'=> simpan_kimia_ro()');
      }//end error
    });
  }
  //?=========== END SIMPAN KIMIA RO ==============?//

  //?========= LIST KIMIA RO ==============?//
  function listKimiaRo() {
    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');
    $('tbody#zone_data').empty();
    let fromDate = $("#dateRange").val().split("-");
    let dateRangeS = formatDate(fromDate[0]);
    let dateRangeE = formatDate(fromDate[1]);

    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_kimia_ro&dateRangeS='+dateRangeS+'&dateRangeSE='+dateRangeE+'&BULAN_FILTER='+$('#BULAN_FILTER').val()+'&TAHUN_FILTER='+$('#TAHUN_FILTER').val(),
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
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>
                                  <td class="bordered">-</td>`;
            } else {
              listData = /*html*/`<td class="bordered"><button class="btn btn-sm btn-danger" id="hapus" KPE_AIR_FLOWMETER_KIMIA_RO_ID="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_ID}"><i class="fa fa-trash"></i></button></td>
                                  <td class="bordered"><button class="btn btn-sm btn-primary" id="edit" KPE_AIR_FLOWMETER_KIMIA_RO_ID="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_ID}" KPE_AIR_FLOWMETER_KIMIA_RO_CODDING="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_CODDING}" KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI}" KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI="${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI}"><i class="fa fa-edit"></i></button></td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_CODDING}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_AKUMULASI}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_STOK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_STOK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_STOK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_STOK}</td>
                                  <td class="bordered">${data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_STOK}</td>
                                  <td class="bordered">${formatNumber(data.result[i].KIMIA.KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_STOK)}</td>`;
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
        error_handler_json(x,e,'=> list_kimia_ro()');
      }//end error
    });
  }
  //?=========== END LIST KIMIA RO ==============?//

  //?===== HAPUS KIMIA RO =====?//
  $('tbody').on('click', 'button#hapus', function(){
    let KPE_AIR_FLOWMETER_KIMIA_RO_ID = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_ID');
    
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_kimia_ro&KPE_AIR_FLOWMETER_KIMIA_RO_ID='+KPE_AIR_FLOWMETER_KIMIA_RO_ID,
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
              listKimiaRo();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              listKimiaRo();
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
  //?===== END HAPUS KIMIA RO =====?//

  //?===== EDIT KIMIA RO =====?//
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
        let KPE_AIR_FLOWMETER_KIMIA_RO_ID = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_ID');
        let KPE_AIR_FLOWMETER_KIMIA_RO_CODDING = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_CODDING');
        let KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI');
        let KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI = $(this).attr('KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI');

        // console.log(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI);
        let date = new Date(KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL);
        let day = date.getDate();
        let month = date.getMonth()+1;
        let year = date.getFullYear();
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_ID').val(KPE_AIR_FLOWMETER_KIMIA_RO_ID);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_CODDING').val(KPE_AIR_FLOWMETER_KIMIA_RO_CODDING);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_TANGGAL').val(year+'/'+satuNolDiDepan(month)+'/'+satuNolDiDepan(day));
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA').val(KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_TERIMA);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_590_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_277_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_566_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_259_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_HYDRO_575_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_GARAM_PAKAI);
        $('#KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI').val(KPE_AIR_FLOWMETER_KIMIA_RO_CAUSTIC_PAKAI);
        $('#modalTambahData').modal('show');
      }
    })
  })
  //?===== END EDIT KIMIA RO =====?//
</script>