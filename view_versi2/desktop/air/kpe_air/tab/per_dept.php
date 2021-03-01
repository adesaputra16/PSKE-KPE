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
.Content
{
  height:600px;
   overflow:auto;
    background:#fff;
}

thead>tr#kalibrasitext>td
{
	background:rgba(202, 255, 191,1) !important;
	/* color: #fff; */
	top: 128px;
	position: sticky;
  z-index: 10;
}
thead>tr#kalibrasinull>td
{
	background:rgba(202, 255, 191,1) !important;
	/* color: #fff; */
	top: 161px;
	position: sticky;
  z-index: 10;
}
thead>tr#kalibrasiangka>td
{
	background:rgba(202, 255, 191,1) !important;
	/* color: #fff; */
	top: 197px;
	position: sticky;
  z-index: 10;
}

thead>tr#kalibrasiangka>td.kalkosong,
thead>tr#kalibrasinull>td.kalkosong,
thead>tr#kalibrasitext>td.kalkosong
{
	background: white;
	left: 0px;
	position: sticky;
  z-index: 22;
}

.table-sticky>thead>tr>th.fixsudut {
	background: #fff;
	top: -3px;
	left: 0px;
	position: sticky;
  z-index: 20;
}

.table-sticky>thead>tr>th {
	background: #fff;
	/* color: #000; */
	top: -3px;
	position: sticky;
  z-index: 10;
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

th.cBeban {
  background-color:rgb(255, 224, 233);
  color:rgb(247, 37, 133);
}

td.cBeban {
  color:rgb(247, 37, 133);
}

/* table, th, td{
  border:1px solid #ccc !important;
} */
table, table.table-bodered, .bordered{
  border:1px solid #ccc !important;
  border-collapse: separate;
}

/* .kalibrasi{
  background:rgba(202, 255, 191,0.4) !important;
} */

td.kalibrasii {
  color:rgba(220, 47, 2,0.8) !important;
}

tr.trData:hover{
  background:rgba(250, 240, 202,0.5) !important;
}

tr.total{
  background:rgba(202, 255, 191,0.4) !important;
}
tr.average{
  background : rgba(235, 235, 235, 0.5) !important;
}
tr.drum{
  background : rgba(255, 224, 233, 0.5) !important;
}
tr.liter{
  background : rgba(235, 235, 235, 0.5) !important;
}
tr.drum2{
  background:rgba(205, 243, 234, 0.5) !important;
}

</style>


<div class="box-body">
  <!-- <div class="pull-right">
    <button type="button" class="btn btn-sm btn-primary" id="btn-reload"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
  </div>
  <br><br> -->
  
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
        <div class="col-md-4" id="divDateRange" hidden>
          <div class="form-group">
            <label>Tanggal</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="dateRange" name="dateRange" autocomplete="off" value="">
            </div>
          </div>
        </div>
        <div class="col-md-6  form-group" id="">
          <label for="multiSearchFilter" >Flowmeter</label>
          <select class="form-control col-sm-2 selectpicker" name="multiSearchFilter" id="multiSearchFilter" multiple data-live-search="true" data-selected-text-format="count > 4" data-max-options="10">
            <?php 
              foreach ($respon_flow['result'] as $rf) {
                echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
              }
            ?>
          </select>
          <input type="hidden" name="multiSearchFlowmeter" id="multiSearchFlowmeter">
        </div>
      </div>

      <div class="row">
        
        <div class="col-md-4">
          <!-- <label>&nbsp;</label> -->
          <div class="input-group custom-search-form">
              <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button></button>&nbsp;
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
        <!-- <div class="Content"> -->
          <div class="table-responsive Content animasi-table" id="divTable">
            <table class="table table-hover table-bordered table-sticky" id="sum_table">
              <thead>
                  <tr id="nFlowmeter">
                    
                  </tr>
                  <tr id="colAngka">

                  </tr>
                  <tr id='kalibrasitext' class='kalibrasi bordered text-center'>

                  </tr>
                  <tr id='kalibrasinull' class='kalibrasi bordered text-center'>

                  </tr>
                  <tr id='kalibrasiangka' class='kalibrasi bordered text-center' >

                  </tr>
                  <tr id="tdAngka">

                  </tr>
              </thead>
              <tbody id="zone_data" class="animasi-tbody tbodyId">
              </tbody>
              <tfoot class="total" id="zone_total">
              </tfoot>
            </table>
          </div>
        <!-- </div> -->
      </div>
    </div>
  </div>
  <!-- end tabel -->

  <br><br>
  <div class="row ">
    <div class="col-md-9">
      <div class="pagination-holder clearfix">
        <div class="pagination" id="tujuan-light-pagination"></div>
      </div>
    </div>
    <div class="col-md-3 text-right">
      <label>Jumlah Baris Per Halaman</label>
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
    </div>
    <span class="sum_pakai"></span>
    <span class="sum_beban"></span>
    <span class="hasil_pakai"></span>
    <span class="hasil_beban"></span>
  </div>
</div>

<!-- //?==== Modal Catatan Note ==== -->
<div class="modal fade" id="modalCatatanNote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title"><i class="fa fa-sticky-note" aria-hidden="true"></i> Note Catatan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" id='note'>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- //?==== End Modal ==== -->

<!-- Modal Angka Pakai-->
<div class="modal fade" id="modalPerDept" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="modalJudul"></h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:simpanRumusPakaiBeban();" class="fDataRumus" id="fData" name="fDataRumus">
            <div class="form-group">

              <input type="hidden" class="form-control" id="TANGGAL_RUMUS" name="TANGGAL_RUMUS" value="">

              <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
              <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" onchange="tampilCatatanRumus()" required>
              <option value="">--Pilih--</option>
                <?php 
                  foreach ($respon_flow['result'] as $rf) {
                    echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
                  }
                ?>
              </select>
            </div>
            <div class="form-group input_fields_wrap">
              <div id="newRow"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="button" class="add_rumus btn btn-primary" name="add_rumus" id="add_rumus" data-toggle="tooltip" data-placement="top" title="Tambah form">
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
<!-- end Modal -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  $(function(){
    $('.information').popover();
    $('input[name="dateRange"]').daterangepicker();
    $(".selectpicker").selectpicker();
    loader();
  });

  function loader() {
    let listDept = setTimeout(listPerDept, 1000);
  }

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

  function list_rumus()
  {
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
  

  $('#multiSearchFlowmeter').val($('#multiSearchFilter').val());
  let multiFilter = $('#multiSearchFlowmeter').val();
  let fromDate = $("#dateRange").val().split("-");
  let dateRangeS = formatDate((new Date(fromDate[0])).valueOf() - 1000*60*60*24);
  let dateRangeE = formatDate(fromDate[1]);

  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    data:'aplikasi=<?php echo $d0;?>&ref=list_rumus_per_dept&MULTI_FILTER='+multiFilter+'&dateRangeS='+dateRangeS+'&dateRangeE='+dateRangeE+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
    success:function(data)
    { 
      {
        var nFlowmeter = '';
        $("tr#nFlowmeter").empty();
        $("tr#colAngka").empty();
        $("tr#tdAngka").empty();
        $('tr#kalibrasitext').empty();
        $('tr#kalibrasinull').empty();
        $('tr#kalibrasiangka').empty();
        for (i = 0; i < data.result.length; i++) {
          if (i==0) {
            var tdKosong = /*html*/`<td class="bordered kalkosong fixed"></td>
                                    <td class="bordered kalkosong fixed" style='left: 66px;'></td>`;
          }else {
            tdKosong = "";
          }
          let namaFlow = data.result[i].KPE_AIR_FLOWMETER_NAMA;
          let rr = '';
          let td ='',kalibrasitext='',kalibrasinull='',kalibrasiangka='',kalkosong="";  
          if (data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA == '') {
            rr = '';  
            var arr = '';
          } else {
            rr += JSON.parse(data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
            arr = rr.split(",");
            var len = arr.length;
          }

          if (namaFlow != "" && data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA != ""){
            colspan = 3+len;
            // beban = /*html*/`<th class="cBeban bordered">Beban</th>`;
            for (var j = 0; j < arr.sort().length; j++) {
              kalkosong += /*html*/`<td class="bordered">&nbsp;</td>`;
              th += /*html*/`<th class="bordered" style='top: 52px;'>${arr[j]}</th>`;
              td += /*html*/`<td class="bordered text-right">${data.result[i].DEPT_FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL}</td>`;
            }             
          } else {
            // for (var k = 0; k < arr.length; k++) {
            //   kalkosong += /*html*/`<td class="bordered">&nbsp;2</td>`;
            // }  
            colspan = 3;
            th = '';
          }
          if (data.result[i].KAL == ''){
            $('tr#kalibrasitext').append(/*html*/`${tdKosong}<td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td>${kalkosong}`);
            $('tr#kalibrasinull').append(/*html*/` ${tdKosong}<td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td>${kalkosong}`);
            $('tr#kalibrasiangka').append(/*html*/`${tdKosong}<td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td><td class="bordered">&nbsp;</td>${kalkosong}`); 
          } else {
            $('tr#kalibrasitext').append(/*html*/`${tdKosong}<td class="bordered kalibrasii">Real</td><td class="bordered kalibrasii">Selisih</td><td class="bordered kalibrasii">%</td>${kalkosong}`);
            $('tr#kalibrasinull').append(/*html*/`${tdKosong}<td class="bordered kalibrasii">&nbsp;</td><td class="bordered kalibrasii">&nbsp;</td><td class="bordered kalibrasii">&nbsp;</td>${kalkosong}`);
            $('tr#kalibrasiangka').append(/*html*/`${tdKosong}<td class="bordered kalibrasii">${data.result[i].KAL.KPE_AIR_FLOWMETER_KALIBRASI_REAL}</td><td class="bordered kalibrasii">${data.result[i].KAL.KPE_AIR_FLOWMETER_KALIBRASI_SELISIH}</td><td class="bordered kalibrasii">${data.result[i].KAL.KPE_AIR_FLOWMETER_KALIBRASI_PERSEN}</td>${kalkosong}`);
          }

          nFlowmeter += /*html*/`<th class="bordered" height="57" colspan="${colspan}"><center>${data.result[i].KPE_AIR_FLOWMETER_NAMA}</center></th>`;
          $("tr#colAngka").append(/*html*/`<th class="bordered" id="listAngka" style='top: 52px;' height="77">Angka</th>
                                          <th class="bordered" style='top: 52px;' height="77">Pakai</th>
                                          <th class="cBeban bordered" style='top: 52px;' height="77">Beban</th>
                                          ${th}`);

          if (data.result[i].ANGKA == "") {
            var cAngka = '0.00';
          } else {
            cAngka = parseFloat(data.result[i].ANGKA.KPE_AIR_FLOWMETER_CATATAN_ANGKA).toFixed(2);
          }
          
          $("tr#tdAngka").append(/*html*/`${tdKosong}
                                          <td class="bordered text-right" style='top: 52px;'>${cAngka}</td>
                                          <td class="bordered" style='top: 52px;'></td>
                                          <td class="bordered" style='top: 52px;'></td>
                                          ${td}`);
        }

        var th = /*html*/`<th rowspan="2" width="68" class="text-center bordered fixsudut">Tanggal</th>
                          <th rowspan="2" width="30" class="text-center bordered fixsudut" style="left:66px;">#</th>`;
        $("tr#nFlowmeter").append(th+nFlowmeter);
      }
    },
    error:function(x,e){
      console.log('error');
    }//end error
  });
  }

  function listPerDept()
  {
    list_rumus();
    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');

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

    $('#multiSearchFlowmeter').val($('#multiSearchFilter').val());
    let multiFilter = $('#multiSearchFlowmeter').val();

    let fromDate = $("#dateRange").val().split("-");
    let dateRangeS = formatDate(fromDate[0]);
    // let dateRangeS = formatDate((new Date(fromDate[0])).valueOf() - 1000*60*60*24);
    let dateRangeE = formatDate(fromDate[1]);
    // console.log(dateRangeS);
    // return
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_per_dept&keyword='+$("input#keyword").val()+'&dateRange='+$("#dateRange").val()+'&dateRangeS='+dateRangeS+'&dateRangeE='+dateRangeE+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&MULTI_FILTER='+multiFilter+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        
        if (data.respon.pesan == "sukses") 
        {
          $("tbody#zone_data").empty();
          // $("tbody#zone_data").append("<tr id='kalibrasitext' class='kalibrasi bordered text-center'></tr><tr id='kalibrasinull' class='kalibrasi bordered text-center'></tr><tr id='kalibrasiangka' class='kalibrasi bordered text-center' ></tr>")
          $('tfoot#zone_total').empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });
              // console.log(data.tes);
              var listData ="";
              for (var i = 0; i < data.result.length; i++) 
              {
                var tanggal = data.result[i].TANGGAL;
                var kolom=i,listTotal='',angkabelumformat,angkaPakaiBeban,len = data.result[i].FLOW.length,actionButton = '',kalibrasitext='',kalibrasinull='',kalibrasiangka='';
               
                for (var j = 0; j < len; j++) 
                {
                  if (data.result[i].FLOW[j].ANGKA == '') {
                    var angka = "0.00";
                    var angkaNol = "";
                  } else {
                    angka = parseFloat(data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_ANGKA).toFixed(2);
                    angkaNol = "cBeban";
                  }

                  if (data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_NOTE != 'kosong' && data.result[i].FLOW[j].ANGKA != '') {
                    var note = /*html*/`<a style='color:red; font-size:18px; cursor:pointer;' id='catatanNote' KPE_AIR_FLOWMETER_CATATAN_NOTE='${data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_NOTE}'><strong><b>*</b></strong></a>`;
                  } else {
                    note = ''
                  }

                  if(data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_PAKAI == null || data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_BEBAN == null){
                    angkaPakai = "0.00";
                    angkaBeban = "0.00";
                  }else {
                    angkaPakai = parseFloat(data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_PAKAI).toFixed(2);
                    angkaBeban = parseFloat(data.result[i].FLOW[j].ANGKA.KPE_AIR_FLOWMETER_CATATAN_BEBAN).toFixed(2);
                  }

                  var dept = "",angkapersonil="",kalkosong="";      
                  if (data.result[i].FLOW[j].DEPARTEMEN == '' && data.result[i].FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA != '' && data.result[i].FLOW[j].ANGKA == '') {
                    let rr = JSON.parse(data.result[i].FLOW[j].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA);
                    for (let f = 0; f < rr.length; f++) {
                      angka += /*html*/`<td class="text-right bordered">0.00</td>`;
                      kalkosong += /*html*/`<td class="bordered">&nbsp;</td>`;
                    }
                  } else {
                    for (let e = 0; e < data.result[i].FLOW[j].DEPARTEMEN.length; e++) {
                      kalkosong += /*html*/`<td class="bordered" style="top:100px;">&nbsp;</td>`;
                      depts = parseFloat(data.result[i].FLOW[j].DEPARTEMEN[e].KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN).toFixed(3);
                      deptss = data.result[i].FLOW[j].DEPARTEMEN[e].KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL;
                      // if (i == 0) {
                      //   dept +=/*html*/`<td class="text-right bordered">${deptss}</td>`;
                      // }else {
                        dept +=/*html*/`<td class="text-right bordered">${depts}</td>`;
                      // }
                    }
                  }

                  kolom += /*html*/`<td id="tdAngka" class="text-right bordered">${formatNumber(angka)}${note}</td>
                                    <td  class="text-right bordered">${angkaPakai}</td>
                                    <td class="${angkaNol} text-right bordered">${angkaBeban}</td>
                                    ${dept}`;
                }

                
                listData += /*html*/`<tr class="trData bordered">
                                      <td class="bordered fixed">${tanggal}</td>
                                      <td class="bordered fixed" style="left:66px;"><button class="btn btn-xs btn-success btnTambah" id="btnTambah" onclick="addRumus('${tanggal}')" data-toggle="tooltip" data-placement="top" title="Tambah pengkondisian"><span class="fa fa-plus-circle"></span></button></td>
                                      ${kolom}
                                     </tr>`; 
              
            }

            var totalCatatan='',totalPakai='',totalBeban='',average='',drum='',liter='',drum2='',haverage='',hdrum='',hliter='',hdrum2='';
            for (var t = 0; t < data.CATATAN.length; t++) {
              if (data.TOTAL_DEPT[t] == "") {
                var totalDept='',avgDept='',drumDept='',literDept='',drum2Dept='';
              } else {
                for (var o=0; o < data.TOTAL_DEPT[t].length; o++) {
                  // console.log(parseFloat(data.TOTAL_DEPT[t][o].TOTAL).toFixed(2));
                  totalDept += /*html*/`<td class="bordered">${parseFloat(data.TOTAL_DEPT[t][o].TOTAL).toFixed(2)}</td>`;
                  avgDept += /*html*/`<td class="bordered cBeban">${parseFloat(data.TOTAL_DEPT[t][o].AVRG).toFixed(2)}</td>`;
                  drumDept += /*html*/`<td class="bordered cBeban">${parseFloat(data.TOTAL_DEPT[t][o].DRUM).toFixed(2)}</td>`;
                  literDept += /*html*/`<td class="bordered cBeban">${formatNumber(parseFloat(data.TOTAL_DEPT[t][o].LITER).toFixed())}</td>`;
                  drum2Dept += /*html*/`<td class="bordered cBeban">${parseFloat(data.TOTAL_DEPT[t][o].DRUM2).toFixed(2)}</td>`;
                }
              }
                totalCatatan +=/*html*/`<td class="bordered">${data.CATATAN[t]}</td><td class="bordered">${data.PAKAI[t]}</td><td class="bordered cBeban">${data.BEBAN[t]}</td>${totalDept}`;
                average +=/*html*/`</td><td class="bordered">AVG:</td><td class="bordered"><td class="bordered cBeban">${data.AVERAGE[t]}</td>${avgDept}`;
                drum +=   /*html*/`</td><td class="bordered">Drum:</td><td class="bordered"><td class="bordered cBeban">${data.DRUM[t]}</td>${drumDept}`;
                liter +=  /*html*/`</td><td class="bordered">Liter:</td><td class="bordered"><td class="bordered cBeban">${data.LITER[t]}</td>${literDept}`;
                drum2 +=  /*html*/`</td><td class="bordered">Drum:</td><td class="bordered"><td class="bordered cBeban">${data.DRUM2[t]}</td>${drum2Dept}`;
            }

            listTotal = /*html*/`<tr class="total">
                                    <td colspan="2" class="text-center bordered"><b>Total:</b></td>
                                    ${totalCatatan}
                                  </tr>`;
              haverage = /*html*/`<tr class="average">
                                    <td colspan="2" class="text-center bordered"></td>
                                    ${average}
                                  </tr>`;
              hdrum = /*html*/`<tr class="drum">
                                <td colspan="2" class="text-center bordered"></td>
                                ${drum}
                              </tr>`;
              hliter = /*html*/`<tr class="liter">
                                  <td colspan="2" class="text-center bordered"></td>
                                  ${liter}
                                </tr>`;
              hdrum2 = /*html*/`<tr class="drum2">
                                  <td colspan="2" class="text-center bordered"></td>
                                  ${drum2}
                                </tr>`;
            
            $("tbody#zone_data").append(listData);
            if ($('#JENIS_LAPORAN').val() != "Custom") {
              $("tfoot#zone_total").append(listTotal+haverage+hdrum+hliter+hdrum2);
            }

            $('tbody.tbodyId').removeClass('tbodyId');
            // $('a.sidebar-toggle').click();
        } else if (data.respon.pesan == "gagal") {
          // alert(data.respon.text_msg);
          // console.log(data.respon.text_msg);
          $("tbody#zone_data").html("<tr><td colspan='7'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
        }
      }, //end success
      error: function(x, e) {
        // error_handler_json(x, e, '=> list_per_dept()');
        alert('error');
      } //end error
    });
  }

  var months = {'01':'Januari', '02':'Februari', '03':'Maret', '04':'April', '05':'Mei', '06':'Juni', '07':'Juli', '08':'Agustus', '09':'September', '10':'Oktober', '11': 'November', '12':'Desember'};

  function notNumber(pakai,angka) {
    if (isNaN(pakai)) {
      return parseFloat(angka).toFixed(2);
    } 
    return parseFloat(pakai).toFixed(2) ;
  }

  function notFormatNumber(pakai,angka) {
    if (isNaN(pakai)) {
      return parseFloat(angka).toFixed(2);
    }
    return parseFloat(pakai).toFixed(2) ;
  }


  function tampilCatatanRumus(){
    var KPE_AIR_FLOWMETER_ID=$('select#KPE_AIR_FLOWMETER_ID').val();
    var TANGGAL_RUMUS=$('input#TANGGAL_RUMUS').val();
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=tampil_angka_pakai_rumus_per_dept&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+TANGGAL_RUMUS,
      
      success: function(data) {

        //alert(KPE_AIR_FLOWMETER_ID+'-'+TANGGAL_RUMUS);
        if (data.respon.pesan == "sukses") 
        {
          var xxy=JSON.parse(data.result[0].KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS);
          // console.log(xxy);
          $('#newRow').empty();
          $('.PAKAI_RUMUS').remove();
          $('.PAKAI_RUMUS').remove();
          for(var z=0;z<xxy.length;z++)
          {
              $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group"><label>+/- Pakai</label><div class="input-group">
                                          <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS" name="KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS[]" autocomplete="off" placeholder="123.456" step="any" value="${xxy[z]}">
                                            <span class="input-group-btn">
                                            <button attrid="1" type="button" class="remove_rumus btn btn-danger" name="remove_rumus" id="remove_rumus" data-placement="top" title="remove">
                                              <span class="fa fa-minus"></span>
                                            </button>
                                            </span>
                                          </div></div>`);
          }
        }else{
          var kosong = $('select#KPE_AIR_FLOWMETER_ID').val();
          if (kosong == '') {
            $('#newRow').empty();
          } else {
            alert('Belum ada angka di tanggal ini, silahkan isi terlebih dahulu');
            $('#newRow').empty();
          }
        }
      }, //end success
      error: function(x, e) {
        // error_handler_json(x, e, '=> list_per_dept()');
        alert('error');
      } //end error
    });
  }

  function simpanRumusPakaiBeban()
  {
  var fData=$("#fData").serialize(); 
  // alert(fData);
  // return
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    //data:'ref=simpan_catatan&'+data,
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_rumus_per_dept&'+fData,
    success:function(data)
    { 
      $('tfoot#zone_total').empty();
      if(data.respon.pesan=="sukses")
      {
        $("#modalPerDept").modal('hide');
        // console.log(data.respon.text_msg1);
        listPerDept();
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        listPerDept();
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_rumus_per_dept()');
    }//end error
  });
  }

  function simpanRumusFlowKal()
  {
  var fDataFlowKal=$("#fDataFlowKal").serialize(); 
  var dataFlowKal = "&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_KALIBRASI").children("option:selected").text())+"&"+fDataFlowKal
  // alert(dataFlowKal);
  // return false;
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    //data:'ref=simpan_catatan&'+data,
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_angka_flowmeter_kalibrasi&'+dataFlowKal,
    success:function(data)
    { 
      $('tfoot#zone_total').empty();
      if(data.respon.pesan=="sukses")
      {
        $("#modalRumusFlowKalibrasi").modal('hide');
        // alert(data.respon.text_msg);
        listPerDept();
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        listPerDept();
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_angka_flowmeter_kalibrasi()');
    }//end error
  });
  }

  $('#btn-reload').click(function(){
    preLoader();
  })

  $(window).on('hashchange', function(e) {
    preLoader();
  });
  $("input#REC_PER_HALAMAN").on('change', function() {
    preLoader();
  });

  function addRumus (tanggal){
    // alert(tanggal);
    // $('tfoot#zone_total').empty();
    var b = '';
    var bulan = $('#BULAN_FILTER').val()
    var tahun = $('#TAHUN_FILTER').val()
    var date = new Date()
    if(bulan == ''){
      b = {'1':'Januari', '2':'Februari', '3':'Maret', '4':'April', '5':'Mei', '6':'Juni', '7':'Juli', '8':'Agustus', '9':'September', '10':'Oktober', '11': 'November', '12':'Desember'};
      bulan = date.getMonth()+1;
    }
    else{
      b = {'01':'Januari', '02':'Februari', '03':'Maret', '04':'April', '05':'Mei', '06':'Juni', '07':'Juli', '08':'Agustus', '09':'September', '10':'Oktober', '11': 'November', '12':'Desember'};
      bulan = bulan;
    }
    if(tahun == ''){
      tahun = date.getFullYear();
    }
    else{
      tahun = tahun;
    }
    $(".selectpicker").selectpicker("val","");
    $("#modalJudul").empty();
    $("#modalPerDept").modal('show');
    $("#modalJudul").append('<h4 class="modal-title" id="modalJudul">+/- Angka Pakai Tanggal <b>' + tanggal + " " + b[bulan] + " " + tahun +'</b></h4>');
    $("#KPE_AIR_FLOWMETER_ID").val('');
    $("#TANGGAL_RUMUS").val(tahun+"-"+bulan+"-"+tanggal);
    $("#KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS").val('');
    $("#KPE_AIR_FLOWMETER_CATATAN_BEBAN_RUMUS").val('');
    $('div#inputFormRow').attr("style", "display:none");
  }

  $("button#add_rumus").click(function () {
      $('#newRow').append(/*html*/`<div id="inputFormRow" class="form-group"><label>+/- Pakai</label><div class="input-group">
                                    <input type="number" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS" name="KPE_AIR_FLOWMETER_CATATAN_PAKAI_RUMUS[]" autocomplete="off" placeholder="123.456" step="any">
                                      <span class="input-group-btn">
                                      <button attrid="1" type="button" class="remove_rumus btn btn-danger" name="remove_rumus" id="remove_rumus" data-placement="top" title="remove">
                                        <span class="fa fa-minus"></span>
                                      </button>
                                      </span>
                                    </div></div>`);
  });

  // remove row
  $(document).on('click', 'button#remove_rumus', function () {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          timer: 1000,
          timerProgressBar: true,
          title: 'Deleted!',
          text: 'Your file has been deleted.',
          icon: 'success'
        })
        $(this).closest('#inputFormRow').remove()
      }
    })
    
  });

  $('tbody').on('click','a#catatanNote' ,function(){
    $('div#note').empty();
    let KPE_AIR_FLOWMETER_CATATAN_NOTE = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_NOTE');
    $('div#note').append(/*html*/`<p style='font-size:18px;'>&#9900; ${KPE_AIR_FLOWMETER_CATATAN_NOTE}</p>`);
    $('#modalCatatanNote').modal('show');
  })

</script>
