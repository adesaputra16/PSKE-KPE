
<link rel="stylesheet" href="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.css">
<style> 
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

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

  .swal2-container {
    z-index: 100005;
  }

  .swal2-popup {
    font-size: 1.3rem !important; 
  }

.circular{
  height: 100px;
  width: 100px;
  position: relative;
}
.circular .inner, .circular .outer, .circular .circle{
  position: absolute;
  z-index: 6;
  height: 100%;
  width: 100%;
  border-radius: 100%;
  box-shadow: inset 0 1px 0 rgba(0,0,0,0.2);
}
.circular .inner{
  top: 50%;
  left: 50%;
  height: 80px;
  width: 80px;
  margin: -40px 0 0 -40px;
  background-color: #dde6f0;
  border-radius: 100%;
  box-shadow: 0 1px 0 rgba(0,0,0,0.2);
}
.circular .circle{
  z-index: 1;
  box-shadow: none;
}
.circular .numb{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  font-size: 18px;
  font-weight: 500;
  color: #4158d0;
  font-family: 'Poppins', sans-serif;
}
.circular .bar{
  position: absolute;
  height: 100%;
  width: 100%;
  background: #fff;
  -webkit-border-radius: 100%;
  clip: rect(0px, 100px, 100px, 50px);
}
.circle .bar .progress{
  position: absolute;
  height: 100%;
  width: 100%;
  -webkit-border-radius: 100%;
  clip: rect(0px, 50px, 100px, 0px);
}
.circle .bar .progress, .dot span{
  background: #4158d0;
}
.circle .left .progress{
  z-index: 1;
  animation: left 2s linear both;
}
@keyframes left {
  100%{
    transform: rotate(180deg);
  }
}
.circle .right{
  z-index: 3;
  transform: rotate(180deg);
}
.circle .right .progress{
  animation: right 2s linear both;
  animation-delay: 2s;
}
@keyframes right {
  100%{
    transform: rotate(180deg);
  }
}
.circle .dot{
  z-index: 2;
  position: absolute;
  left: 50%;
  top: 50%;
  width: 50%;
  height: 10px;
  margin-top: -5px;
  animation: dot 4s linear both;
  transform-origin: 0% 50%;
}
.circle .dot span {
  position: absolute;
  right: 0;
  width: 10px;
  height: 10px;
  border-radius: 100%;
}
@keyframes dot{
  0% {
    transform: rotate(-90deg);
  }
  50% {
    transform: rotate(90deg);
    z-index: 4;
  }
  100% {
    transform: rotate(270deg);
    z-index: 4;
  }
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
            <div class="table-responsive Content">
              <table class="table table-hover table-bordered table-sticky">
                <thead>
                    <script>
                      function tHead() {
                        $('tr#nFlowmeter').html(/*html*/`<th width="10" class="text-center">No</th>
                                                          <th width="" class="text-center">Aksi</th>
                                                          <th width="" class="text-center">DEPT.</th>
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
                  <!-- <tr> 
                    <td class="backloader" colspan="30">
                      <center>
                        <div class="loader"></div>
                      </center>
                    </td>
                  </tr> -->
                  <center id="preloader">
                    <div class="circular">
                      <div class="inner"></div>
                        <div class="outer"></div>
                          <div class="numb">0%</div>
                        <div class="circle">
                          <div class="dot">
                            <span></span>
                          </div>
                        <div class="bar left">
                          <div class="progress">
                        </div>
                        </div>
                          <div class="bar right">
                            <div class="progress">
                          </div>
                        </div>
                      </div>
                    </div>
                    <br><br>
                  </center>
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
      <div class="box box-danger">
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
  <span class="hasil_beban">beban</span>
  </div>

</div>

<script src="aplikasi/<?= $_SESSION['aplikasi']; ?>/asset/plugins/sweet-alert/sweetalert2.min.js"></script>

<script>

  const numb = document.querySelector(".numb");
  let counter = 0;
  const timeValue = setInterval(()=>{
    if(counter == 100){
      $('#preloader').remove();
      clearInterval(timeValue);
      listBebanHarian('1');
      tHead();
    }else{
      counter+=1;
      numb.textContent = counter + "%";
    }
  }, 40);

  $(function() {
    $('a.sidebar-toggle').click()
    // listBebanHarian('1')
  });

  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }

  $('#btn-reload').on('click',function () {
    listBebanHarian('1');
  })

  function tambahKosong(x){
    y=(x>9)?x:'0'+x;
    return y;
  }

  //? =============================================================== ?//
  //? ================== CODE DISTRIBUSI PRE ======================== ?//
  //? =============================================================== ?//

  //TODO ================== LIST BEBAN HARIAN ======================== TODO//
  function listBebanHarian(curPage)
  {
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
      data:'aplikasi=<?php echo $d0;?>&ref=list_beban_harian&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        
        if (data.respon.pesan == "sukses") 
        {
          console.log(data.RESULT_RO[0]);
          console.log(data.RESULT_PRE[0]);
          // console.log(data.TOTAL_BEBAN_RO);
          // console.log(data.SUM_TOTAL_BEBAN_HARIAN_RO);
          console.log(data.SUM_TOTAL_BEBAN_HARIAN_BULAN_LALU);
          console.log(data.SUM_TOTAL_BEBAN_HARIAN_BULAN_LALU_RO);
          
          // $("span.hasil_beban").html(data.respon.hasil_beban);
          $("tbody#zone_data_pre").empty();
          $("tbody#zone_data_ro").empty();
          $("tbody#zone_data_pre").empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });

          var listFlowPre='';
          var listFlowRo='';
          var tableContentPre = '';
          var tableContentRo = '';

          //!============= LOOPING FLOWMETER PRE ==============!//
          for (var i = 0; i < data.RESULT_PRE.length; i++) { 
            var object = data.RESULT_PRE[i].BEBAN;
            
            // console.log(data.RESULT_PRE+'==='+object);
            listFlowPre = /*html*/`<td>${data.RESULT_PRE[i].NO}</td>
                                  <td class="text-center"><button type="button" class="btn btn-sm btn-primary editBebanPRE"  NO="${data.RESULT_PRE[i].NO}" KPE_AIR_FLOWMETER_NAMA="${data.RESULT_PRE[i].KPE_AIR_FLOWMETER_NAMA}" KPE_AIR_FLOWMETER_ID="${data.RESULT_PRE[i].KPE_AIR_FLOWMETER_ID}" BEBAN_AVRG="${data.RESULT_PRE[i].TOTAL.AVG}" TOTAL_BEBAN="${formatNumber(parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN).toFixed(2))}" TOTAL_BEBAN_HASIL_RUMUS="${parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN / data.TOTAL_BEBAN * 100).toFixed(2)}" AVG_BULAN_LALU="${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU).toFixed(2)}" AVG_BULAN_LALU_HASIL_RUMUS="${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU * 100).toFixed(2)}" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A}" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B}" KPE_AIR_FLOWMETER_BEBAN_PRODUK_A="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_PRODUK_A}" KPE_AIR_FLOWMETER_BEBAN_PRODUK_B="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_PRODUK_B}" KPE_AIR_FLOWMETER_BEBAN_PROSES_A="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_PROSES_A}" KPE_AIR_FLOWMETER_BEBAN_PROSES_B="${data.RESULT_PRE[i].BEBAN_BULANAN.KPE_AIR_FLOWMETER_BEBAN_PROSES_B}"><i class="fa fa-edit"></i></button></td>
                                  <td>${data.RESULT_PRE[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                  <td>${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU).toFixed(2)}</td>
                                  <td>${parseFloat(data.RESULT_PRE[i].TOTAL_BULAN_LALU.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU * 100).toFixed(2)}</td>
                                  <td>${data.RESULT_PRE[i].TOTAL.AVG}</td>
                                  <td>${formatNumber(parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN).toFixed(2))}</td>
                                  <td>${parseFloat(data.RESULT_PRE[i].TOTAL.TOTAL_BEBAN / data.TOTAL_BEBAN * 100).toFixed(2)}</td>`;

              // for (var property=i in object) {
              //   listBeban +=  /*html*/`<td class="bordered">${(object[property])}</td>`;
              // }
            
          //   // for (property in object) {
          //   //   listFlow += /*html*/`<td>${object[property]}</td>`;
                                    
          //   // } 
          //   // tableContent += /*html*/`<tr class="trData">${listData+btnEdit}</tr>`;
            tableContentPre += /*html*/`<tr>${listFlowPre}</tr>`;
            
          }

          //!============= LOOPING FLOWMETER RO ==============!//
          for (var i = 0; i < data.RESULT_RO.length; i++) { 
            var object = data.RESULT_RO[i].BEBAN;
            
            // console.log(data.RESULT_RO+'==='+object);
            listFlowRo = /*html*/`<td>${data.RESULT_RO[i].NO}</td>
                                <td class="text-center"><button type="button" class="btn btn-sm btn-primary editBebanRO"  NO="${data.RESULT_RO[i].NO}" KPE_AIR_FLOWMETER_NAMA="${data.RESULT_RO[i].KPE_AIR_FLOWMETER_NAMA}" KPE_AIR_FLOWMETER_ID="${data.RESULT_RO[i].KPE_AIR_FLOWMETER_ID}" BEBAN_AVRG="${data.RESULT_RO[i].TOTAL_RO.AVG}" TOTAL_BEBAN="${formatNumber(parseFloat(data.RESULT_RO[i].TOTAL_RO.TOTAL_BEBAN).toFixed(2))}" TOTAL_BEBAN_HASIL_RUMUS="${parseFloat(data.RESULT_RO[i].TOTAL_RO.TOTAL_BEBAN / data.TOTAL_BEBAN_RO * 100).toFixed(2)}" AVG_BULAN_LALU="${parseFloat(data.RESULT_RO[i].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU).toFixed(2)}" AVG_BULAN_LALU_HASIL_RUMUS="${parseFloat(data.RESULT_RO[i].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU_RO * 100).toFixed(2)}" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A}" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B}" KPE_AIR_FLOWMETER_BEBAN_PRODUK_A="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_PRODUK_A}" KPE_AIR_FLOWMETER_BEBAN_PRODUK_B="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_PRODUK_B}" KPE_AIR_FLOWMETER_BEBAN_PROSES_A="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_PROSES_A}" KPE_AIR_FLOWMETER_BEBAN_PROSES_B="${data.RESULT_RO[i].BEBAN_BULANAN_RO.KPE_AIR_FLOWMETER_BEBAN_PROSES_B}"><i class="fa fa-edit"></i></button></td>
                                <td>${data.RESULT_RO[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                <td>${parseFloat(data.RESULT_RO[i].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU).toFixed(2)}</td>
                                <td>${parseFloat(data.RESULT_RO[i].TOTAL_BULAN_LALU_RO.AVG_BULAN_LALU / data.AVG_BEBAN_BULAN_LALU_RO * 100).toFixed(2)}</td>
                                <td>${data.RESULT_RO[i].TOTAL_RO.AVG}</td>
                                <td>${formatNumber(parseFloat(data.RESULT_RO[i].TOTAL_RO.TOTAL_BEBAN).toFixed(2))}</td>
                                <td>${parseFloat(data.RESULT_RO[i].TOTAL_RO.TOTAL_BEBAN / data.TOTAL_BEBAN_RO * 100).toFixed(2)}</td>`;

              // for (var property=i in object) {
              //   listBeban +=  /*html*/`<td class="bordered">${(object[property])}</td>`;
              // }
            
          //   // for (property in object) {
          //   //   listFlow += /*html*/`<td>${object[property]}</td>`;
                                    
          //   // } 
          //   // tableContent += /*html*/`<tr class="trData">${listData+btnEdit}</tr>`;
            tableContentRo += /*html*/`<tr>${listFlowRo}</tr>`;
            
          }
                                  
          $('tbody#zone_data_pre').append(tableContentPre);
          $('tbody#zone_data_ro').append(tableContentRo);
          
        } else if (data.respon.pesan == "gagal") {
          // alert(data.respon.text_msg);
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
      html += '<td class="text-center"><button type="button" class="btn btn-sm btn-danger cancelEditPRE" NO="'+$(this).attr('NO')+'" KPE_AIR_FLOWMETER_NAMA="'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'" KPE_AIR_FLOWMETER_ID="'+$(this).attr('KPE_AIR_FLOWMETER_ID')+'" BEBAN_AVRG="'+$(this).attr('BEBAN_AVRG')+'" TOTAL_BEBAN="'+$(this).attr('TOTAL_BEBAN')+'" TOTAL_BEBAN_HASIL_RUMUS="'+$(this).attr('TOTAL_BEBAN_HASIL_RUMUS')+'" AVG_BULAN_LALU="'+$(this).attr('AVG_BULAN_LALU')+'" AVG_BULAN_LALU_HASIL_RUMUS="'+$(this).attr('AVG_BULAN_LALU_HASIL_RUMUS')+'" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A')+'" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B')+'" KPE_AIR_FLOWMETER_BEBAN_PRODUK_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_A')+'" KPE_AIR_FLOWMETER_BEBAN_PRODUK_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_B')+'" KPE_AIR_FLOWMETER_BEBAN_PROSES_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_A')+'" KPE_AIR_FLOWMETER_BEBAN_PROSES_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_B')+'"><i class="fa fa-undo" aria-hidden="true"></i></button>&nbsp;<button type="button" class="btn btn-sm btn-warning simpanBebanPRE" BEBAN_AVRG="'+$(this).attr('BEBAN_AVRG')+'" KPE_AIR_FLOWMETER_NAMA="'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'" KPE_AIR_FLOWMETER_ID="'+$(this).attr('KPE_AIR_FLOWMETER_ID')+'"><i class="fa fa-save"></i></button></td>';
      html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B')+'</td>';
      // html += '<td><input class="form-control" id="KPE_AIR_FLOWMETER_BEBAN_PRODUK_A" name="KPE_AIR_FLOWMETER_BEBAN_PRODUK_A" required type="text" pattern="[0-9]+" title="please enter number only" value="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_A')+'"></td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_B')+'</td>';
      // html += '<td><input class="form-control" id="KPE_AIR_FLOWMETER_BEBAN_PROSES_A" name="KPE_AIR_FLOWMETER_BEBAN_PROSES_A" required type="text" pattern="[0-9]+" title="please enter number only" value="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_A')+'"></td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_B')+'</td>';
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
      html += '<td class="text-center"><button type="button" class="btn btn-sm btn-primary editBebanPRE" NO="'+$(this).attr('NO')+'" KPE_AIR_FLOWMETER_NAMA="'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'" KPE_AIR_FLOWMETER_ID="'+$(this).attr('KPE_AIR_FLOWMETER_ID')+'" BEBAN_AVRG="'+$(this).attr('BEBAN_AVRG')+'" TOTAL_BEBAN="'+$(this).attr('TOTAL_BEBAN')+'" TOTAL_BEBAN_HASIL_RUMUS="'+$(this).attr('TOTAL_BEBAN_HASIL_RUMUS')+'" AVG_BULAN_LALU="'+$(this).attr('AVG_BULAN_LALU')+'" AVG_BULAN_LALU_HASIL_RUMUS="'+$(this).attr('AVG_BULAN_LALU_HASIL_RUMUS')+'" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A')+'" KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B')+'" KPE_AIR_FLOWMETER_BEBAN_PRODUK_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_A')+'" KPE_AIR_FLOWMETER_BEBAN_PRODUK_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_B')+'" KPE_AIR_FLOWMETER_BEBAN_PROSES_A="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_A')+'" KPE_AIR_FLOWMETER_BEBAN_PROSES_B="'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_B')+'"><i class="fa fa-edit" aria-hidden="true"></i></button></td>';
      html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_NAMA')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_A')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_DOMESTIK_B')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_A')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PRODUK_B')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_A')+'</td>';
      // html += '<td>'+$(this).attr('KPE_AIR_FLOWMETER_BEBAN_PROSES_B')+'</td>';
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
      var PERIODE = date.getFullYear()+'-'+tambahKosong(date.getMonth()+1);
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
              // Swal.fire({
              //   timer: 1000,
              //   timerProgressBar: true,
              //   title: 'Berhasil!',
              //   text: ''+data.respon.text_msg+'',
              //   icon: 'success',
              // })
              listBebanHarian('1');
            }else if(data.respon.pesan=="gagal")
            {
              Swal.fire({
                title: 'Gagal!',
                text: ''+data.respon.text_msg+'',
                icon: 'error'
              })
              listBebanHarian('1');
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
</script>