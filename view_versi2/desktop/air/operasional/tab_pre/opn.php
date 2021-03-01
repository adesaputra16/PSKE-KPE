<style>

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
</style>
<div class="box-body">
  <button class="btn btn-success" id="btnTambahData"><i class="fa fa-plus-square"></i> Tambah Data</button>
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
      <div class="sk-wave text-center" id="loader">
        <div class="sk-rect sk-rect1"></div>
        <div class="sk-rect sk-rect2"></div>
        <div class="sk-rect sk-rect3"></div>
        <div class="sk-rect sk-rect4"></div>
        <div class="sk-rect sk-rect5"></div>
      </div>
      <div class="col-md-12 animasi-table" id="divTable">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
                <tr>
                  <th class="bordered text-center" rowspan="3">#</th>
                  <th class="bordered text-center" rowspan="3">Codding</th>
                  <th class="bordered text-center" rowspan="3">Tanggal</th>
                  <th class="bordered text-center" colspan="2" rowspan="2">RAW WATER</th>
                  <th class="bordered text-center" rowspan="3">Akumulasi Proses Raw Water</th>
                  <th class="bordered text-center" colspan="9" rowspan="2">Clarifier</th>
                  <th class="bordered text-center" colspan="11">PROSES PRE</th>
                  <th class="bordered text-center" colspan="3">DISTRIBUSI</th>
                  <th class="bordered text-center" colspan="6">Stock BAK</th>
                  <th class="bordered text-center" rowspan="3">Akum Stock </th>
                  <th class="bordered text-center" colspan="4" rowspan="2">Jam Operasional </th>
                  <th class="bordered text-center" colspan="3" rowspan="2">Akumulasi </th>
                </tr>
                <tr>
                  <th class="bordered text-center" colspan="3">Flow Induk Distribusi</th>
                  <th class="bordered text-center" rowspan="2">Carbon Filter</th>
                  <th class="bordered text-center" rowspan="2">Mess</th>
                  <th class="bordered text-center" rowspan="2">Drain & Backwash</th>
                  <th class="bordered text-center" rowspan="2">Total Proses PRE</th>
                  <th class="bordered text-center" rowspan="2">Akumulasi proses pre</th>
                  <th class="bordered text-center" rowspan="2">Effesiensi</th>
                  <th class="bordered text-center" rowspan="2">Stock Bak Equalisasi</th>
                  <th class="bordered text-center" rowspan="2">Susut Proses PRE</th>
                  <th class="bordered text-center" rowspan="2">Pakai Pre</th>
                  <th class="bordered text-center" rowspan="2">Susut PRE Distribusi</th>
                  <th class="bordered text-center" rowspan="2">Total Distribusi </th>
                  <th class="bordered text-center" rowspan="2">Employe Mess Basin</th>
                  <th class="bordered text-center" rowspan="2">Tower</th>
                  <th class="bordered text-center" rowspan="2">Aerasi Basin</th>
                  <th class="bordered text-center" rowspan="2">Filtered Water Basin</th>
                  <th class="bordered text-center" rowspan="2">Bak BSF 1 & 2</th>
                  <th class="bordered text-center" rowspan="2">Bak BSF 3 & 4</th>
                </tr>
                <tr>
                  <th class="bordered text-center">Flow Raw Water</th>
                  <th class="bordered text-center">Proses Raw Water</th>
                  <th class="bordered text-center">Flow CC 1 & 2</th>
                  <th class="bordered text-center">Proses CC 1 & 2 REAL</th>
                  <th class="bordered text-center">Akumulasi Proses CC 1 & 2 LAPORAN</th>
                  <th class="bordered text-center">Flow CC 3 & 4</th>
                  <th class="bordered text-center">Proses CC 3 & 4 REAL</th>
                  <th class="bordered text-center">Akumulasi Proses CC 3 & 4 LAPORAN</th>
                  <th class="bordered text-center">Total Proses CC REAL</th>
                  <th class="bordered text-center">Total Proses CC LAPORAN</th>
                  <th class="bordered text-center">Akumulasi Proses CC LAPORAN</th>
                  <th class="bordered text-center" colspan="2">Flow Produksi</th>
                  <th class="bordered text-center">Proses Produksi</th>
                  <th class="bordered text-center" colspan="2">CC 1 & 2</th>
                  <th class="bordered text-center" colspan="2">CC 3 & 4</th>
                  <th class="bordered text-center">CC 1 & 3</th>
                  <th class="bordered text-center">CC 3 & 6</th>
                  <th class="bordered text-center">Susut</th>
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
        <h4 class="modal-title" id="exampleModalLabel">Tambah Data</h4>
      </div>
      <div class="modal-body">
      <!-- <div class="row">
        <div class="col-md-12"> -->
          <form action="javascript:simpanOpn();" class="fData" id="fData" name="fData">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL">Tanggal</label>
                  <input type="text" class="form-control datepicker" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING">Codding</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2">Flow CC 1 & 2</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2" placeholder="Flow CC 1 & 2" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4">Flow CC 3 & 4</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4" placeholder="Flow CC 3 & 4" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI">Flow Produksi</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI" placeholder="Flow Produksi" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI">Stock Bak Equalisasi</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI" placeholder="Stock Bak Equalisasi" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO">Flow Proses PRE RO</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO" placeholder="Flow Proses PRE RO" autocomplete="off" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN">Employe Mess Basin</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN" placeholder="Employe Mess Basin" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER">Tower</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER" placeholder="Tower" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN">Aerasi Basin</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN" placeholder="Aerasi Basin" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN">Filtered Water Basin</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN" placeholder="Filtered Water Basin" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2">Bak BSF 1 & 2</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2" placeholder="Bak BSF 1 & 2" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4">Bak BSF 3 & 4</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4" placeholder="Bak BSF 3 & 4" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO">Flow Produk PRE RO</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO" placeholder="Flow Produk PRE RO" autocomplete="off" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Pengkondisian</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN">Flow Raw Water</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN" placeholder="Pengkondisian Flow Raw Water" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-6">
                      <div class="form-group">
                        <label for="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN">Flow Produksi</label>
                        <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN" name="KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN" placeholder="Pengkondisian Flow Raw Water" autocomplete="off">
                      </div>
                      </div>
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
        <!-- </div>
      </div> -->
    </div>
  </div>
</div>

<script>

  function loader() {
    let myLoader = setTimeout(listOperasionalPre, 2000);
  }

  $(function() {
    $("input#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL").datepicker().on('changeDate', function(ev)
    {
      let now = new Date($("input#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL").val());
      let start = new Date(now.getFullYear(), 0, 0);
      let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
      let oneDay = 1000 * 60 * 60 * 24;
      let day = Math.floor(diff / oneDay);
      $('input#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING').val(codding(day));
      $('.datepicker').datepicker('hide');
    });
    loader();
  });

  $('#btn-reload').on('click',function () {
    preLoader();
  })

  $('button#btnTambahData').on('click', function() {
    Swal.fire({
        title: 'Sudah yakin?',
        text: "Sebelum menambah data pastikan catatan di tanggal yang ingin ditambahkan sudah direkap terlebih dulu!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Kembali!',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oke!'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#modalTambahData').modal('show');
        $('form#fData')[0].reset();
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID').val('');
      }
    })
  })

  //?=========== FUNCTION SIMPAN DATA ===========?//
  function simpanOpn() {
    let fData = $('#fData').serialize();
    let date = new Date($("#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL").val());
    let dateSebelumnya = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    let KPE_AIR_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA = dateSebelumnya.getFullYear() + '/' + satuNolDiDepan(dateSebelumnya.getMonth()+1) + '/' + satuNolDiDepan(dateSebelumnya.getDate());
    // console.log(KPE_AIR_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA);
    // alert(fData);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_operasional_pre&KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA='+KPE_AIR_OPERASIONAL_PRE_TANGGAL_SEBELUMNYA+'&'+fData,
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
          // console.log(data.result);
          listOperasionalPre();
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
        error_handler_json(x,e,'=> simpan_operasional_pre()');
      }//end error
    });
  }
  //?=========== END FUNCTION SIMPAN DATA ===========?//

  //?=========== FUNCTION LIST DATA ===========?//
  function listOperasionalPre() {
    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');
    $('#zone_data').empty();
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_operasional_pre&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val(),
      success:function(data)
      { 
        // console.log(data.result);
        if(data.respon.pesan=="sukses")
        {
          for (let i = 0; i < data.result.length; i++) {
            $('#zone_data').append(/*html*/`<tr>
                                              <td class="bordered">
                                                <div class="dropright">
                                                  <button type="button" class="btn btn-sm btn-default btn-opn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <strong><i class="fa fa-ellipsis-v"></i></strong>
                                                  </button>
                                                  <div class="dropdown-menu">
                                                    <li><a class="edit" style='color:rgb(0, 48, 73);' KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN}" KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN}"><i class="fa fa-edit"></i> Edit</a></li>
                                                    <li><a class="hapus" style='color:brown;' KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID}"><i class="fa fa-trash"></i> Hapus</a></li>
                                                  </div>
                                                </div>
                                              </td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_RW}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_RW}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_1_2_REAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_1_2_LAPORAN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_CC_3_4_REAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUM_PROSES_CC_3_4_LAPORAN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOTAL_PROSES_CC_REAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOTAL_PROSES_CC_LAPORAN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_CC_LAPORAN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_HASIL_RUMUS}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PROSES_PRODUKSI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CARBON_FILTER}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_MESS}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_DRAIN_BACKWASH}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOTAL_PROSES_PRE}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_PROSES_PRE}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EFFESIENSI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_SUSUT_PROSES_PRE}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_PAKAI_PRE}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_SUSUT_PRE_DISTRIBUSI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOTAL_DISTRIBUSI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AKUMULASI_STOCK}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_2_RUMUS}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_4_RUMUS}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_1_3}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CC_3_6}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_SUSUT}</td>
                                              <td class="bordered" hidden>${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO}</td>
                                              <td class="bordered" hidden>${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO}</td>
                                            </tr>`);
          }
        }else if(data.respon.pesan=="gagal")
        {
          $("tbody#zone_data").html(/*html*/`<tr><td colspan="18" class="bordered"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> list_operasional_pre()');
      }//end error
    });
  }
  //?=========== END FUNCTION LIST DATA ===========?//

  //?===== EDIT OPERASIONAL PRE =====?//
  $('tbody').on('click', 'a.edit', function(){
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
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO');
        let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO');

        // console.log(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN);
        let date = new Date(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL);
        let day = date.getDate();
        let month = date.getMonth()+1;
        let year = date.getFullYear();
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_CODDING);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TANGGAL').val(year+'/'+satuNolDiDepan(month)+'/'+satuNolDiDepan(day));
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_1_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_RW_PENGKONDISIAN);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_CC_3_4);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUKSI_PENGKONDISIAN);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_STOCK_BAK_EQUALISASI);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_EMPLOYE_MESS_BASIN);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_TOWER);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_AERASI_BASIN);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FILTERED_WATER_BASIN);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_1_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_BAK_BSF_3_4);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PRODUK_PRE_RO);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO').val(KPE_AIR_FLOWMETER_OPERASIONAL_PRE_FLOW_PROSES_PRE_RO);
        $('#modalTambahData').modal('show');
      }
    })
  })
  //?===== END EDIT OPERASIONAL PRE =====?//

  //?===== HAPUS OPERASIONAL PRE =====?//
  $('tbody').on('click', 'a.hapus', function(){
    let KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID');
    
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_operasional_pre&KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID='+KPE_AIR_FLOWMETER_OPERASIONAL_PRE_ID,
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
              listOperasionalPre();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              listOperasionalPre();
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
  //?===== END HAPUS OPERASIONAL PRE =====?//

</script>