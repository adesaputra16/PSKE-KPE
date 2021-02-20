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

  /* table {
    font-size:12px;
    
  } */

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
    z-index: 100005;
  }

  .swal2-popup {
    font-size: 1.3rem !important; 
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
          <option value="Bulanan" selected>Bulanan</option>
          <!-- <option value="Tahunan">Tahunan</option> -->
        </select>
      </div>
      
      <div class="col-md-2 form-group" id="divbulanfilter">
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
      <div class="col-md-4  form-group" id="divtahunfilter">
        <label for="TAHUN_FILTER" >Tahun</label>
        <div class="input-group custom-search-form">
          <select class="form-control col-sm-2" name="TAHUN_FILTER" id="TAHUN_FILTER">
            <option value="">--Pilih tahun--</option>
            <?php
              $thnsekarang=Date('Y');
              $thnsebelumnya=$thnsekarang-7;
              for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
                echo"<option value='$thn'>$thn</option>";
              } ?>
          </select>
          <span class="input-group-btn">
            <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
          </span>
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
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
                <tr>
                  <th class="bordered text-center">#</th>
                  <th class="bordered text-center">Codding</th>
                  <th class="bordered text-center">Tanggal</th>
                  <th class="bordered text-center">Flowmeter</th>
                  <th class="bordered text-center">Beban</th>
                </tr>
            </thead>
            <tbody id="zone_data">
              <tr>
                <td class="backloader" colspan="5">
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

<script>
  $(function() {
    $('a.sidebar-toggle').click();
    listRekap();
  })

  function listRekap() {
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_rekap_used_pre',
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          $('tbody#zone_data').empty();
          console.log(data.result);
          let listData = '';
          for (let i = 0; i < data.result.length; i++) {
            if (data.result[i].REKAP == "") {
              var codding = '-';
            } else {
              codding = data.result[i].REKAP[0].KPE_AIR_FLOWMETER_REKAP_USED_PRE_CODDING;
            }
            let rowspan = data.result[i].REKAP.lenght;
            listData += /*html*/`<tr>
                                  <td >${data.result[i].NO}</td>
                                  <td >${codding}</td>
                                  <td >${data.result[i].TANGGAL}</td>
                                 </tr>`;
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
</script>