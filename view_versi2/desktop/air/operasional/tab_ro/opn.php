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
                  <th class="bordered text-center" rowspan="2">#</th>
                  <th class="bordered text-center" rowspan="2">Codding</th>
                  <th class="bordered text-center" rowspan="2">Tanggal</th>
                  <th class="bordered text-center" colspan="2" >Produk Softener (m3) line 1</th>
                  <th class="bordered text-center" colspan="2" >Produk Softener (m3) line 2</th>
                  <th class="bordered text-center" colspan="2" >Produk Softener</th>
                  <th class="bordered text-center" colspan="2" >Regenerasi line 1</th>
                  <th class="bordered text-center" colspan="2" >Regenerasi line 2</th>
                  <th class="bordered text-center" colspan="2" >Regenerasi</th>
                  <th class="bordered text-center" colspan="3" >Proses RO 1 (m3)</th>
                  <th class="bordered text-center" colspan="3" >Produk RO 1 (m3)</th>
                  <th class="bordered text-center" colspan="2" >Rejct RO 1 (m3)</th>
                  <th class="bordered text-center" rowspan="2" >Debit Produk RO 1 (m3/jam)</th>
                  <th class="bordered text-center" colspan="2" >Waktu Operasi RO 1 ( Jam )</th>
                  <th class="bordered text-center" colspan="3" >Proses RO 2 (m3)</th>
                  <th class="bordered text-center" colspan="3" >Produk RO 2 (m3)</th>
                  <th class="bordered text-center" colspan="2" >Reject RO 2 (m3)</th>
                  <th class="bordered text-center" rowspan="2" >Debit Produk RO 2 (m3/jam)</th>
                  <th class="bordered text-center" colspan="2" >Waktu Operasi RO 2 ( Jam )</th>
                  <th class="bordered text-center" rowspan="2" >Proses Carbon Filter/Pre RO</th>
                  <th class="bordered text-center" colspan="3" >Backwash</th>
                  <th class="bordered text-center" rowspan="2" >Susut</th>
                  <th class="bordered text-center" rowspan="2" >Kontrol Susut</th>
                  <th class="bordered text-center" rowspan="2" >Akum Susut</th>
                  <th class="bordered text-center" rowspan="2" >Akum Produk</th>
                  <th class="bordered text-center" rowspan="2" >Akum Reject</th>
                  <th class="bordered text-center" rowspan="2" >Akum Reject</th>
                  <th class="bordered text-center" colspan="3" >Effesiensi Proses</th>
                  <th class="bordered text-center" colspan="8" >Sounding Real</th>
                  <th class="bordered text-center" colspan="9" >Stok Bak Real</th>
                </tr>
                <tr>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">##</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">##</th>
                  <th class="bordered text-center">Total Produk</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">##</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">##</th>
                  <th class="bordered text-center">Total Regenerasi</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">Proses</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">Produk</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Reject RO 1 (m3)</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Waktu Operasi</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">Proses</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">Produk</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Reject RO 2 (m3)</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Waktu Operasi</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">Flow</th>
                  <th class="bordered text-center">Produk</th>
                  <th class="bordered text-center">Akumulasi</th>
                  <th class="bordered text-center">RO 1</th>
                  <th class="bordered text-center">RO 2</th>
                  <th class="bordered text-center">	&nbsp;</th>
                  <th class="bordered text-center">Bak Soft Water  1</th>
                  <th class="bordered text-center">Bak Soft Water  2</th>
                  <th class="bordered text-center">Bak RO IV</th>
                  <th class="bordered text-center">Bak RO Boiler I</th>
                  <th class="bordered text-center">Bak RO Boiler II</th>
                  <th class="bordered text-center">Bak RO Boiler III</th>
                  <th class="bordered text-center">Bak RO Boiler IV</th>
                  <th class="bordered text-center">Bak RO Boiler V/Sekat</th>
                  <th class="bordered text-center">Stok Total Real</th>
                  <th class="bordered text-center">Bak Soft Water  1</th>
                  <th class="bordered text-center">Bak Soft Water  2</th>
                  <th class="bordered text-center">Tanki RO WTD</th>
                  <th class="bordered text-center">Bak RO Boiler I</th>
                  <th class="bordered text-center">Bak RO Boiler II</th>
                  <th class="bordered text-center">Bak RO Boiler III</th>
                  <th class="bordered text-center">Bak RO Boiler IV</th>
                  <th class="bordered text-center">Bak RO Boiler V/Sekat</th>
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
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL">Tanggal</label>
                  <input type="text" class="form-control datepicker" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1">Produk Softener (m3) Line 1</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1" placeholder="Produk Softener (m3) Line 1" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2">Produk Softener (m3) Line 2</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2" placeholder="Produk Softener (m3) Line 2" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1">Regenerasi line 1</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1" placeholder="Regenerasi line 1" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2">Regenerasi line 2</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2" placeholder="Regenerasi line 2" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1">Proses RO 1 (m3)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1" placeholder="Proses RO 1 (m3)" autocomplete="off" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING">Codding</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING" autocomplete="off" readonly>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1">Produk RO 1 (m3)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1" placeholder="Produk RO 1 (m3)" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1">Debit Produk RO 1 (m3/jam)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1" placeholder="Debit Produk RO 1 (m3/jam)" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2">Proses RO 2 (m3)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2" placeholder="Proses RO 2 (m3)" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2">Produk RO 2 (m3)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2" placeholder="Produk RO 2 (m3)" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2">Debit Produk RO 2 (m3/jam)</label>
                  <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2" placeholder="Debit Produk RO 1 (m3/jam)" autocomplete="off" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Sounding Real</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1">Bak Soft Water 1</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1" placeholder="Bak Soft Water 1" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2">Bak Soft Water 2</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2" placeholder="Bak Soft Water 2" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV">Bak RO IV</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV" placeholder="Bak RO IV" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I">Bak RO Boiler I</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I" placeholder="Bak RO Boiler I" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II">Bak RO Boiler II</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II" placeholder="Bak RO Boiler II" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III">Bak RO Boiler III</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III" placeholder="Bak RO Boiler III" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV">Bak RO Boiler IV</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV" placeholder="Bak RO Boiler IV" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <label for="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT">Bak RO Boiler V/Sekat</label>
                          <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT" name="KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT" placeholder="Bak RO Boiler V/Sekat" autocomplete="off">
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
    let myLoader = setTimeout(listOperasionalRo, 2000);
  }

  $(function() {
    $("input#KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL").datepicker().on('changeDate', function(ev)
    {
      let now = new Date($("input#KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL").val());
      let start = new Date(now.getFullYear(), 0, 0);
      let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
      let oneDay = 1000 * 60 * 60 * 24;
      let day = Math.floor(diff / oneDay);
      $('input#KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING').val(codding(day));
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
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID').val('');
      }
    })
  })

  //?=========== FUNCTION SIMPAN DATA ===========?//
  function simpanOpn() {
    let fData = $('#fData').serialize();
    let date = new Date($("#KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL").val());
    let dateSebelumnya = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    let KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL_SEBELUMNYA = dateSebelumnya.getFullYear() + '/' + satuNolDiDepan(dateSebelumnya.getMonth()+1) + '/' + satuNolDiDepan(dateSebelumnya.getDate());
    // console.log(KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL_SEBELUMNYA);
    // console.log(fData);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_operasional_ro&KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL_SEBELUMNYA='+KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL_SEBELUMNYA+'&'+fData,
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
          listOperasionalRo();
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
        error_handler_json(x,e,'=> simpan_operasional_ro()');
      }//end error
    });
  }
  //?=========== END FUNCTION SIMPAN DATA ===========?//

  //?=========== FUNCTION LIST DATA ===========?//
  function listOperasionalRo() {
    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');
    $('#zone_data').empty();
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_operasional_ro&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val(),
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
                                                    <li><a class="edit" style='color:rgb(0, 48, 73);' KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1_INPUT}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2_INPUT}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV_INPUT}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV}" KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT}"><i class="fa fa-edit"></i> Edit</a></li>
                                                    <li><a class="hapus" style='color:brown;' KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID="${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID}"><i class="fa fa-trash"></i> Hapus</a></li>
                                                  </div>
                                                </div>
                                              </td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_HASIL_LINE_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_HASIL_LINE_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_TOTAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_AKUMULASI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_HASIL_LINE_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_HASIL_LINE_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_TOTAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_AKUMULASI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_HASIL_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_AKUMULASI_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_AKUMULASI_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_AKUMULASI_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_HASIL_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_AKUMULASI_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_HASIL_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_AKUMULASI_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_REJECT_AKUMULASI_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_WAKTU_OPERASI_AKUMULASI_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_CARBON_FILTER}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_BACKWASH_FLOW}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_BACKWASH_PRODUK}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_BACKWASH_AKUMULASI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SUSUT}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_KONTROL_SUSUT}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_AKUMULASI_SUSUT}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_AKUMULASI_PRODUK}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_AKUMULASI_REJECT}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_AKUMULASI_REJECT_HASIL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_EFFESIENSI_PROSES_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_EFFESIENSI_PROSES_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_HASIL_PROSES_PRODUK}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_TOTAL}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_SOFT_WATER_1}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_SOFT_WATER_2}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_TANKI}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_I}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_II}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_III}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_IV}</td>
                                              <td class="bordered">${data.result[i].KPE_AIR_FLOWMETER_OPERASIONAL_RO_STOK_BOILER_V_SEKAT}</td>
                                            </tr>`);
          }
        }else if(data.respon.pesan=="gagal")
        {
          $("tbody#zone_data").html(/*html*/`<tr><td colspan="20" class="bordered"><div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>${data.respon.text_msg}</div></td></tr>`);
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> list_operasional_ro()');
      }//end error
    });
  }
  //?=========== END FUNCTION LIST DATA ===========?//

  //?===== EDIT OPERASIONAL RO =====?//
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
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2 = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV');
        let KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT');

        // console.log(KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2);
        let date = new Date(KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL);
        let day = date.getDate();
        let month = date.getMonth()+1;
        let year = date.getFullYear();
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_CODDING);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_TANGGAL').val(year+'/'+satuNolDiDepan(month)+'/'+satuNolDiDepan(day));
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOFTENER_FLOW_LINE_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_REGENERASI_FLOW_LINE_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_PROSES_FLOW_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_PRODUK_FLOW_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_DEBIT_PRODUK_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_1);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_SOFT_WATER_2);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BAK_IV);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_I);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_II);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_III);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_IV);
        $('#KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT').val(KPE_AIR_FLOWMETER_OPERASIONAL_RO_SOUNDING_BOILER_V_SEKAT);
        $('#modalTambahData').modal('show');
      }
    })
  })
  //?===== END EDIT OPERASIONAL RO =====?//

  //?===== HAPUS OPERASIONAL RO =====?//
  $('tbody').on('click', 'a.hapus', function(){
    let KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID = $(this).attr('KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID');
    
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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_operasional_ro&KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID='+KPE_AIR_FLOWMETER_OPERASIONAL_RO_ID,
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
              listOperasionalRo();
              
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                timer: 1000,
                timerProgressBar: true,
                title: 'Gagal!',
                text: 'Data gagal terhapus.',
                icon: 'error'
              })
              listOperasionalRo();
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
  //?===== END HAPUS OPERASIONAL RO =====?//

</script>