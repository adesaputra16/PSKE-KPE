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
      <div class="col-md-4" id="divDateRange" hidden>
        <div class="form-group">
          <label>Tanggal</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="dateRange" name="dateRange" autocomplete="off">
          </div>
        </div>
      </div>
      <div class="col-md-6  form-group" id="">
        <label for="multiSearchFilter" >Flowmeter</label>
        <div class="input-group first custom-search-form">
          <select class="form-control col-sm-2 selectpicker" name="multiSearchFilter" id="multiSearchFilter" multiple data-live-search="true" data-selected-text-format="count > 4" data-max-options="10">
            <?php 
              foreach ($respon_flow['result'] as $rf) {
                echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
              }
            ?>
          </select>
          <span class="input-group-btn">
            <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
          </span>
          <input type="hidden" name="multiSearchFlowmeter" id="multiSearchFlowmeter">
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
                  <th class="bordered text-center" width="10%">#</th>
                  <th class="bordered text-center" width="7%">Codding</th>
                  <th class="bordered text-center" width="13%">Tanggal</th>
                  <th class="bordered text-center" width="7%">Total</th>
                  <th class="bordered text-center" width="8%">Rata-Rata</th>
                  <th class="bordered text-center" width="40%">Flowmeter</th>
                  <th class="bordered text-center" width="10%">Beban</th>
                </tr>
            </thead>
            <tbody id="zone_data">
              <tr>
                <td class="backloader" colspan="8">
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

<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
  $(function() {
    $('a.sidebar-toggle').click();
    $('input[name="dateRange"]').daterangepicker();
    $('.selectpicker').selectpicker();
    $('#dateRange').val('');
    listRekap();
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

  $('#btn-reload').click(function(){
    listRekap();
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

  //? =========== LIST REKAP ===============?//
  function listRekap() {
    $('#multiSearchFlowmeter').val($('#multiSearchFilter').val());
    let multiFilter = $('#multiSearchFlowmeter').val();

    let fromDate = $("#dateRange").val().split("-");
    let dateRangeS = formatDate(fromDate[0]);
    // let dateRangeS = formatDate((new Date(fromDate[0])).valueOf() - 1000*60*60*24);
    let dateRangeE = formatDate(fromDate[1]);
    // console.log(dateRangeS);
    // console.log(dateRangeE);

    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_rekap_used_pre&dateRangeS='+dateRangeS+'&dateRangeSE='+dateRangeE+'&MULTI_FILTER='+multiFilter+'&BULAN_FILTER='+$('#BULAN_FILTER').val()+'&TAHUN_FILTER='+$('#TAHUN_FILTER').val(),
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          $('tbody#zone_data').empty();
          console.log(data.result);
          // console.log(data.sql);
          let listData = '';
          let listFlowBeban = '';
          let rowspan = 1;
          for (let i = 0; i < data.result.length; i++) {
            if (data.result[i].REKAP == "") {
              var codding = '-';
              var flowBeban = /*html*/`<td class="bordered list-kosong">-</td><td class="bordered list-kosong">-</td>`;
              var flowTotal = '';
              var flowRataRata = '';
              var listKosong = 'list-kosong';
            } else {
              codding = data.result[i].REKAP[0].KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING;
              flowBeban = '';
              flowTotal = data.result[i].REKAP[0].KPE_AIR_FLOWMETER_REKAP_USED_PRE_TOTAL;
              flowRataRata = data.result[i].REKAP[0].KPE_AIR_FLOWMETER_REKAP_USED_PRE_RATA_RATA;
              listKosong = '';
            }
            let rowspan = 1 + data.result[i].REKAP.length;
            listData += /*html*/`<tr rowspan="${rowspan}">
                                  <td rowspan="${rowspan}" class="fixed-top bordered text-center ${listKosong}"><button class="btn btn-danger hapus" KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL="${data.result[i].TANGGAL_DEL}" KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING="${codding}"><i class="fa fa-trash"></i> Hapus</button></td>
                                  <td rowspan="${rowspan}" class="fixed-top bordered text-center ${listKosong}">${codding}</td>
                                  <td rowspan="${rowspan}" class="fixed-top bordered text-center ${listKosong}">${data.result[i].TANGGAL}</td>
                                  <td rowspan="${rowspan}" class="fixed-top bordered text-center ${listKosong}">${flowTotal}</td>
                                  <td rowspan="${rowspan}" class="fixed-top bordered text-center ${listKosong}">${flowRataRata}</td>
                                  ${flowBeban}
                                 </tr>`;
            for (let j = 0; j < data.result[i].REKAP.length; j++) {
              listData += /*html*/`<tr>
                                      <td class="bordered">${data.result[i].REKAP[j].KPE_AIR_FLOWMETER_NAMA}</td>
                                      <td class="bordered">${data.result[i].REKAP[j].KPE_AIR_FLOWMETER_REKAP_USED_PRE_BEBAN}</td>
                                    </tr>`;
                            
            }

          }
          $('tbody#zone_data').append(listData);
        }else if(data.respon.pesan=="gagal")
        {
          $('tbody#zone_data').html(/*html*/`<tr><td colspan="5"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> list_rekap_used_pre()');
      }//end error
    });
  }
  //?=============== END LIST REKAP ==================?//

  //?===== HAPUS REKAP =====?//
  $('tbody').on('click', 'button.hapus', function(){
    let KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL');
    let KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING = $(this).attr('KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING');
    // console.log(KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING);
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_rekap_used_pre&KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL='+KPE_AIR_FLOWMETER_REKAP_USED_PRE_TANGGAL+'&KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING='+KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING,
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
              })
              listRekap();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                title: 'Gagal!',
                text: ''+data.respon.text_msg+'',
                icon: 'error'
              })
              listRekap();
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
  //?===== END HAPUS REKAP =====?//
</script>