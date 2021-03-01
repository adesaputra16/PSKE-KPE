<?php
  $input_option=array();
  $params=array(
    'case'=>"nonlogin_list_beban_harian",
    'batas'=>100,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option,
  );
  $respon_flow = $KPE->kpe_modules($params)->load->module;
  // echo "<pre>".print_r($respon_flow['RESULT_PRE'],true)."</pre>";
  // exit();
?>

<style> 

  table, th, td{
    border:1px solid #ccc !important;
  }

  tr.trData:hover{
    background:rgba(250, 240, 202,0.5) !important;
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

  table, .table-bodered{
    border-collapse: separate;
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
      <div class="col-md-2  form-group" id="divtahunfilter">
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
      <label>&nbsp;</label>
      <div class="input-group custom-search-form">
        <span class="input-group-btn">
          <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
        </button>
        </span>
      </div>
    </div>
    <!-- End akumulasi-->

    </div>
  </div>
  <!-- /.End Pencarian -->
<section>
  <div class="sk-wave text-center" id="loader">
    <div class="sk-rect sk-rect1"></div>
    <div class="sk-rect sk-rect2"></div>
    <div class="sk-rect sk-rect3"></div>
    <div class="sk-rect sk-rect4"></div>
    <div class="sk-rect sk-rect5"></div>
  </div>

  <div class="animasi-table" id="divTable">
  <!-- //? TOTAL DISTRIBUSI PRE & RO -->
    <div class="TOTAL_DISTRIBUSI_PRE_RO"></div>
  <!-- //? END TOTAL DISTRIBUSI PRE & RO -->
    

  <!-- List data flowmeter PRE -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Distribusi PRE</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <div class="col-md-12"> -->
          <div id="totalPre"></div>
            <div class="table-responsive Content">
              <table class="table table-hover table-bordered table-sticky">
                <thead>
                    <script>
                      function tHead() {
                        $('tr#nFlowmeter').html(/*html*/`<th width="10" class="text-center">No</th>
                                                          <th width="" class="text-center">DEPARTEMEN</th>
                                                          <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                                                          <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                                                          <th colspan="2" width="" class="text-center">TOTAL (M&sup3;/Bulan) </th>`);
                      }
                    </script>
                    <!-- <script>
                      function tHead() {
                        $('tr#nFlowmeter').html(/*html*/`<th width="10" class="text-center">No</th>
                                                          <th width="" class="text-center">Aksi</th>
                                                          <th width="" class="text-center">DEPT.</th>
                                                          <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                                                          <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                                                          <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                                                          <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                                                          <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                                                          <th colspan="2" width="" class="text-center">TOTAL (M&sup3;/Bulan) </th>`);
                      }
                    </script> -->
                    <tr id="nFlowmeter">
                      
                      <!-- <script>
                        $(document).ready(function () {
                        
                          var date = new Date();
                          var bulan = $('select#BULAN_FILTER').val();
                          var tahun = $('select#TAHUN_FILTER').val();

                          if (bulan == '') {
                            var bulans = date.getMonth();
                          } else {
                            bulans = new Date($('#BULAN_FILTER').val());
                          }

                          if (tahun == '') {
                            var tahuns = date.getFullYear();
                          } else {
                            tahuns = new Date($('#TAHUN_FILTER').val());
                          }

                          var lastDay = new Date(tahuns, bulans + 1, 0);
                          var tanggal = lastDay.getDate();
                          var tglBeban = '';
                          for (var t = 1; t <= tanggal; t++) {
                            tglBeban += /*html*/`<th>${t}</th>`;
                          }
                          
                          var th = /*html*/`<th width="10" class="text-center">No</th>
                                            <th colspan="2" width="" class="text-center">Aksi</th>
                                            <th width="" class="text-center">DEPT.</th>
                                            <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                                            <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                                            <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                                            <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                                            <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                                            <th colspan="2" width="" class="text-center">TOTAL (M&sup3;/Bulan) </th>`;
                          $('tr#nFlowmeter').append(th+tglBeban);

                          $('#btn-reload').click(function(){
                            $('tr#nFlowmeter').empty();

                            var date = new Date();
                            var bulan = new Date($('select#BULAN_FILTER').val());
                            var tahun = new Date($('select#TAHUN_FILTER').val());
                            var bulanss = $('select#BULAN_FILTER').val();
                            var tahunss = $('select#TAHUN_FILTER').val();

                            if (bulanss == '') {
                              var bulans = date.getMonth();
                            } else {
                              bulans = bulan.getMonth();
                            }

                            if (tahunss == '') {
                              var tahuns = date.getFullYear();
                            } else {
                              tahuns = tahun.getFullYear();
                            }
                            var lastDay = new Date(tahuns, bulans + 1, 0);
                            var tanggal = lastDay.getDate();
                            var tglBeban = '';

                            for (var t = 1; t <= tanggal; t++) {
                              tglBeban += /*html*/`<th>${t}</th>`;
                            }
                            
                            var th = /*html*/`<th width="10" class="text-center">No</th>
                                              <th colspan="2" width="" class="text-center">Aksi</th>
                                              <th width="" class="text-center">DEPT.</th>
                                              <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                                              <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                                              <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                                              <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                                              <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                                              <th width="" class="text-center">TOTAL (M&sup3;/Bln) </th>`;
                            $('tr#nFlowmeter').append(th+tglBeban);

                          })
                        });
                      </script> -->
                    </tr>
                </thead>
                <tbody id="zone_data_pre">
                </tbody>
                <tfoot id="zone_total">
                </tfoot>
              </table>
            </div>
          <!-- </div> -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- end list data PRE -->

  <!-- List data flowmeter RO -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Distribusi RO</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <div class="col-md-12"> -->
          <div id="totalRo"></div>
            <div class="table-responsive Content">
              <table class="table table-hover table-bordered table-sticky">
                <thead>
                    <tr id="nFlowmeter">
                    </tr>
                </thead>
                <tbody id="zone_data_ro">

                </tbody>
                <tfoot id="zone_total">
                </tfoot>
              </table>
            </div>
          <!-- </div> -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- end list data RO -->

  <!-- List data flowmeter Reject -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Distribusi Reject</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <!-- <div class="col-md-12"> -->
            <div class="table-responsive Content">
              <table class="table table-hover table-bordered table-sticky" id="bebanPRE">
                <thead>
                    <tr id="nFlowmeter">
                      
                    </tr>
                </thead>
                <tbody id="">
                  <tr> 
                    <td class="backloader" colspan="30">
                      <!-- <center>
                        <div class="loader"></div>
                      </center> -->
                    </td>
                  </tr>
                </tbody>
                <tfoot id="zone_total">
                </tfoot>
              </table>
            </div>
          <!-- </div> -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- end list data Reject -->
  </div>
</section>
  <!-- List data PRE dan RO -->
  <div class="row">
    <!-- Total PRE -->
    <!-- <div class="col-md-6">
      <div class="box box-info collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Total PRE</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                    <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                    <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                    <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                    <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                    <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                  </tr>
              </thead>
              <tbody>
                <tr> 
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End Total PRE -->

    <!-- Total RO -->
    <!-- <div class="col-md-6">
      <div class="box box-info collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Total RO</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                  <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                  <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                  <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                  <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                </tr>
              </thead>
              <tbody>
                <tr> 
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End Total RO -->
  </div>
  <!-- End Total PRE & RO -->

  <!-- List data Reject dan Distribusi & Reject -->
  <div class="row">
    <!-- Total Reject -->
    <!-- <div class="col-md-6">
      <div class="box box-info collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Total Reject</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                    <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                    <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                    <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                    <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                    <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                  </tr>
              </thead>
              <tbody>
                <tr> 
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End Total Reject -->

    <!-- Total Distribusi & Reject -->
    <!-- <div class="col-md-6">
      <div class="box box-info collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title">Total Reject RO</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                  <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                  <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                  <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                  <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                </tr>
              </thead>
              <tbody>
                <tr> 
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                  <td>--</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->
    <!-- End Total Distribusi & Reject -->
  </div>
  <!-- End Total Reject & Distribusi & Reject -->


  <div class="row ">
    <div class="col-md-9">
      <div class="pagination-holder clearfix">
        <div class="pagination" id="tujuan-light-pagination"></div>
      </div>
    </div>
    <div class="col-md-3 text-right">
      <label>Jumlah Baris Per Halaman</label>
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="100">
    </div>
  </div>

</div>

<!-- //? ============== MODAL ============== ?// -->
<div class="modal fade" id="modalDetailFlow" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Detail Beban Departemen</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-sticky">
                <thead>
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">DEPARTEMEN</th>
                      <th class="text-center" colspan="2">AVG Bulan Lalu(M³/Day)</th>
                      <th class="text-center">AVG (M³/Day)</th>
                      <th class="text-center" colspan="2">TOTAL (M³/Bulan)</th>
                    </tr>
                </thead>
                <tbody id="detailBeban">
                  <tr> 
                    <td class="backloader" colspan="3">
                      <center>
                        <div class="loader"></div>
                      </center>
                    </td>
                  </tr>
                </tbody>
                <tfoot id="zone_total">
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>

  function loader() {
    let myVar = setTimeout(listBebanHarian, 2500);
  }

  $(function() {
    loader();
    $('[data-toggle="popover"]').popover();
  });

  $('#btn-reload').on('click',function () {
    preLoader();
  })

  //? =============================================================== ?//
  //? ================== CODE DISTRIBUSI PRE ======================== ?//
  //? =============================================================== ?//

  //TODO ================== LIST BEBAN HARIAN ======================== TODO//
  function listBebanHarian()
  {
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

    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_beban_harian&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        
        if (data.respon.pesan == "sukses") 
        {
          tHead();
          $("tbody#zone_data_pre").empty();
          $("tbody#zone_data_ro").empty();
          $("tbody#zone_data_pre").empty();
          $('div.TOTAL_DISTRIBUSI_PRE_RO').empty();
          $('div#totalPre').empty();
          $('div#totalRo').empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });

          var listFlowPre='';
          var listFlowRo='';
          var tableContentPre = '';
          var tableContentRo = '';

          //? =============== TOTAL DISTRIBUSI PRE & RO ================?//
            let totalPreRo = /*html*/`<div class="row">
                                        <div class="col-md-12">
                                          <div class="small-box bg-aqua">
                                            <div class="inner">
                                              <h3>${formatNumber(parseFloat(data.TOTAL_BEBAN + data.TOTAL_BEBAN_RO).toFixed(2))}</h3>

                                              <strong><p>TOTAL DISTRIBUSI PRE & RO</p></strong>
                                            </div>
                                            <div class="icon">
                                              <i class="fa fa-files-o"></i>
                                            </div>
                                          </div>
                                        </div>
                                      </div>`;
          //? =============== END TOTAL DISTRIBUSI PRE & RO ================?//

          //!============= LOOPING FLOWMETER PRE ==============!//
          //? ============ BOX TOTAL PRE =============?//
            let totalPre = /*html*/`<div class="row">
                                      <div class="col-md-4">
                                        <div class="small-box bg-yellow">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.AVG_BEBAN_BULAN_LALU).toFixed(2))}</h3>

                                            <strong><p>AVG Bulan Lalu(M³/Day)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-reply-all"></i>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="small-box bg-green">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.AVG_BEBAN).toFixed(2))}</h3>

                                            <strong><p>AVG (M³/Day)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-tasks"></i>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="small-box bg-aqua">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.TOTAL_BEBAN).toFixed(2))}</h3>

                                            <strong><p>TOTAL (M³/Bln)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-file-text-o"></i>
                                          </div>
                                        </div>
                                      </div>
                                    </div>`;
          //? ============ END BOX TOTAL PRE =============?//

          for (let i = 0; i < data.RESULT_PRE.length; i++) { 
            if(data.RESULT_PRE[i].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA != "")
            {
              var detailFlow = /*html*/` <button KPE_AIR_FLOWMETER_ID="${data.RESULT_PRE[i].KPE_AIR_FLOWMETER_ID}" id="detailFlow" class="btn btn-xs btn-info"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>`;
            } else {
              detailFlow = '';
            }
            listFlowPre = /*html*/`<td>${data.RESULT_PRE[i].NO}</td>
                                    <td>${data.RESULT_PRE[i].KPE_AIR_FLOWMETER_NAMA} ${detailFlow}</td>
                                    <td>${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU).toFixed(2)}</td>
                                    <td>${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU * 100).toFixed(2)}</td>
                                    <td>${data.RESULT_PRE[i].TOTAL.AVG}</td>
                                    <td>${formatNumber(parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN).toFixed(2))}</td>
                                    <td>${parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN / data.TOTAL_BEBAN * 100).toFixed(2)}</td>`;

            tableContentPre += /*html*/`<tr>${listFlowPre}</tr>`;
            
          }
          //!============= END LOOPING FLOWMETER PRE ==============!//

          //!============= LOOPING FLOWMETER RO ==============!//
          //? ============ BOX TOTAL RO =============?//
          let totalRo = /*html*/`<div class="row">
                                      <div class="col-md-4">
                                        <div class="small-box bg-yellow">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.AVG_BEBAN_BULAN_LALU_RO).toFixed(2))}</h3>

                                            <strong><p>AVG Bulan Lalu(M³/Day)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-reply-all"></i>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="small-box bg-green">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.AVG_BEBAN_RO).toFixed(2))}</h3>

                                            <strong><p>AVG (M³/Day)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-tasks"></i>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="small-box bg-aqua">
                                          <div class="inner">
                                            <h3>${formatNumber(parseFloat(data.TOTAL_BEBAN_RO).toFixed(2))}</h3>

                                            <strong><p>TOTAL (M³/Bln)</p></strong>
                                          </div>
                                          <div class="icon">
                                            <i class="fa fa-file-text-o"></i>
                                          </div>
                                        </div>
                                      </div>
                                    </div>`;
          //? ============ END BOX TOTAL RO =============?//

          for (let j = 0; j < data.RESULT_RO.length; j++) { 
            if(data.RESULT_RO[j].KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA != "")
            {
              var detailFlowRO = /*html*/` <button KPE_AIR_FLOWMETER_ID="${data.RESULT_RO[j].KPE_AIR_FLOWMETER_ID}" id="detailFlow" class="btn btn-xs btn-info"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>`;
            } else {
              detailFlowRO = '';
            }
            listFlowRo = /*html*/`<td>${data.RESULT_RO[j].NO}</td>
                                <td>${data.RESULT_RO[j].KPE_AIR_FLOWMETER_NAMA} ${detailFlowRO}</td>
                                <td>${parseFloat(data.RESULT_RO[j].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU).toFixed(2)}</td>
                                <td>${parseFloat(data.RESULT_RO[j].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU_RO * 100).toFixed(2)}</td>
                                <td>${data.RESULT_RO[j].TOTAL_RO.AVG}</td>
                                <td>${formatNumber(parseFloat(data.RESULT_RO[j].TOTAL_RO.TOTAL_BEBAN).toFixed(2))}</td>
                                <td>${parseFloat(data.RESULT_RO[j].TOTAL_RO.TOTAL_BEBAN / data.TOTAL_BEBAN_RO * 100).toFixed(2)}</td>`;

            tableContentRo += /*html*/`<tr>${listFlowRo}</tr>`;
            
          }
          //!============= END LOOPING FLOWMETER RO ==============!//
                                  
          $('div.TOTAL_DISTRIBUSI_PRE_RO').append(totalPreRo);
          $('tbody#zone_data_pre').append(tableContentPre);
          $('div#totalPre').append(totalPre);
          $('tbody#zone_data_ro').append(tableContentRo);
          $('div#totalRo').append(totalRo);
          
        } else if (data.respon.pesan == "gagal") {
          $("tbody#zone_data_pre").html("<tr><td colspan='7'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
        }
      }, //end success
      error: function(x, e) {
        // error_handler_json(x, e, '=> list_per_dept()');
        console.log('error');
      } //end error
    });
  }
  //TODO ================== END LIST BEBAN HARIAN ======================== TODO//

  //TODO ================== EDIT BEBAN HARIAN ======================== TODO//
  $(document).on('click', '.editBebanPRE', function(){
    $('button.editBebanPRE').attr('disabled','disabled');
    let html = '';

      html += '<td>'+$(this).attr('NO')+'</td>';
      html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'</td>';
      html += '<td>'+$(this).attr('AVG_BULAN_LALU')+'</td>';
      html += '<td>'+$(this).attr('AVG_BULAN_LALU_HASIL_RUMUS')+'</td>';
      html += '<td>'+$(this).attr('BEBAN_AVRG')+'</td>';
      html += '<td>'+$(this).attr('TOTAL_BEBAN')+'</td>';
      html += '<td>'+$(this).attr('TOTAL_BEBAN_HASIL_RUMUS')+'</td>';
   
    $(this).closest('tr').html(html);
  });

  $(document).on('click', '.cancelEditPRE', function(){
    $('button.editBebanPRE').removeAttr('disabled');
    let html = '';

      html += '<td>'+$(this).attr('NO')+'</td>';
      html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'</td>';
      html += '<td>'+$(this).attr('AVG_BULAN_LALU')+'</td>';
      html += '<td>'+$(this).attr('AVG_BULAN_LALU_HASIL_RUMUS')+'</td>';
      html += '<td>'+$(this).attr('BEBAN_AVRG')+'</td>';
      html += '<td>'+$(this).attr('TOTAL_BEBAN')+'</td>';
      html += '<td>'+$(this).attr('TOTAL_BEBAN_HASIL_RUMUS')+'</td>';
   
    $(this).closest('tr').html(html);
  });
  //TODO ================== END EDIT BEBAN HARIAN ======================== TODO//

  //TODO ================== SIMPAN BEBAN HARIAN ======================== TODO//
  $(document).on('click', '.simpanBebanPRE', function(){
    let date = new Date();
    if ($('#BULAN_FILTER').val() == "" && $('#TAHUN_FILTER').val() == "") {
      var PERIODE = date.getFullYear()+'-'+satuNolDiDepan(date.getMonth()+1);
    } else {  
      PERIODE = $('#BULAN_FILTER').val()+'-'+$('#TAHUN_FILTER').val();
    }
    let KPE_AIR_FLOWMETER_BEBAN_PRODUK_A = $('#KPE_AIR_FLOWMETER_BEBAN_PRODUK_A').val();
    let KPE_AIR_FLOWMETER_BEBAN_PROSES_A = $('#KPE_AIR_FLOWMETER_BEBAN_PROSES_A').val();
    let BEBAN_AVRG = $(this).attr('BEBAN_AVRG');
    let KPE_AIR_FLOWMETER_ID=$(this).attr('KPE_AIR_FLOWMETER_ID');
    let KPE_AIR_FLOWMETER_NAMA=$(this).attr('KPE_AIR_FLOWMETER_NAMA');
    let data = 'KPE_AIR_FLOWMETER_BEBAN_PRODUK_A='+KPE_AIR_FLOWMETER_BEBAN_PRODUK_A+'&KPE_AIR_FLOWMETER_BEBAN_PROSES_A='+KPE_AIR_FLOWMETER_BEBAN_PROSES_A+'&BEBAN_AVRG='+BEBAN_AVRG+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_NAMA='+KPE_AIR_FLOWMETER_NAMA+'&KPE_AIR_FLOWMETER_BEBAN_PERIODE='+PERIODE+'';
    // console.log(data)
    // return
    Swal.fire({
        title: 'Yakin ingin menyimpan?',
        text: "Data akan disimpan!",
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
          data:'aplikasi=<?php echo $d0;?>&ref=simpan_beban_pre&'+data,
          success:function(data)
          { 
            
            if(data.respon.pesan=="sukses")
            {
              listBebanHarian();
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                title: 'Gagal!',
                text: ''+data.respon.text_msg+'',
                icon: 'error'
              })
              listBebanHarian();
            }
          },
          error:function(x,e){
            error_handler_json(x,e,'=> simpan_beban_pre()');
          }//end error
        });
      }
    })
  });
  //TODO ================== END SIMPAN BEBAN HARIAN ======================== TODO//

  //? =============================================================== ?//
  //? ================== CODE DISTRIBUSI RO ========================= ?//
  //? =============================================================== ?//


  //? =============================================================== ?//
  //? =============== CODE FLOWMETER DEPARTEMEN ===================== ?//
  //? =============================================================== ?//
  //TODO ================== LIST FLOWMETER DEPARTEMEN ======================== TODO//
  $(document).on('click', '#detailFlow', function(){
    let KPE_AIR_FLOWMETER_ID=$(this).attr('KPE_AIR_FLOWMETER_ID');
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_beban_harian_dept&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        { 
          $('#modalDetailFlow').modal('show');
          $('#detailBeban').empty();
          for (let i = 0; i < data.result.length; i++) {
            $('#detailBeban').append(/*html*/`<tr>
                                                <td>${data.result[i].NO}</td>
                                                <td>${data.result[i].KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA}</td>
                                                <td class="text-right">${parseFloat(data.result[i].C_DEPT_BULAN_LALU.AVG_LALU).toFixed(2)}</td>
                                                <td class="text-right">${parseFloat(data.result[i].C_DEPT_BULAN_LALU.AVG_LALU / data.AVG_BEBAN_BULAN_LALU * 100).toFixed(2)}</td>
                                                <td class="text-right">${data.result[i].C_DEPT.AVG}</td>
                                                <td class="text-right">${parseFloat(data.result[i].C_DEPT.TOTAL_BEBAN_DEPT).toFixed(2)}</td>
                                                <td class="text-right">${parseFloat(data.result[i].C_DEPT.TOTAL_BEBAN_DEPT / data.BEBAN_HARIAN * 100).toFixed(2)}</td>
                                              </tr>`);
          }
        }else if(data.respon.pesan=="gagal")
        {
          console.log('error beban dept');
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> list_beban_harian_dept()');
      }//end error
    });
  });

</script>