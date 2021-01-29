

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
              <table class="table table-hover table-bordered table-sticky" id="sum_table">
                <thead>
                    <tr id="nFlowmeter">
                      <th width="10" class="text-center">No</th>
                      <th colspan="2" width="" class="text-center">Aksi</th>
                      <th width="" class="text-center">DEPT.</th>
                      <th colspan="2" width="" class="text-center">Domestik (M&sup2;/Day)</th>
                      <th colspan="2" width="" class="text-center">Produk/Evap/Steam (M&sup3;/Day)</th>
                      <th colspan="2" width="" class="text-center">Proses (M&sup3;/Day)</th>
                      <th colspan="2" width="" class="text-center" style="width:130px">AVG Bulan Lalu(M&sup3;/Day) </th>
                      <th width="" class="text-center">AVG (M&sup3;/Day) </th>
                      <th colspan="2" width="" class="text-center">TOTAL (M&sup3;/Bulan) </th>
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
                <tbody id="zone_data">
                  <tr> 
                    <td class="backloader" colspan="30">
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
              <table class="table table-hover table-bordered table-sticky" id="sum_table">
                <thead>
                    <tr id="nFlowmeter">
                    </tr>
                </thead>
                <tbody id="">
                  <tr> 
                    <td class="backloader" colspan="30">
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
              <table class="table table-hover table-bordered table-sticky" id="sum_table">
                <thead>
                    <tr id="nFlowmeter">
                      
                    </tr>
                </thead>
                <tbody id="">
                  <tr> 
                    <td class="backloader" colspan="30">
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

<script>
  $(function() {
  $('a.sidebar-toggle').click()
  listBebanHarian('1')
  });

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
        console.log(data.result);
        // console.log(data.result_flow);
          
          // $("span.hasil_beban").html(data.respon.hasil_beban);
          $("tbody#zone_data").empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });

          var listBeban='';
          var listFlow = '';
          var listTd = '';
          var tableContent = '';
          var listTable = '';
          var listBeban = '';

          for (var i = 0; i < data.result.length; i++) { 
            var object = data.result[i].BEBAN;
            
            // console.log(data.result+'==='+object);
            listFlow = /*html*/`<td>${data.result[i].NO}</td>
                                      <td><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></td>
                                      <td><button type="button" class="btn btn-xs btn-warning"><i class="fa fa-save"></i></button></td>
                                      <td>${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>`;

              // for (var property=i in object) {
              //   listBeban +=  /*html*/`<td class="bordered">${(object[property])}</td>`;
              // }
              // console.log(listBeban);
            
          //   // for (property in object) {
          //   //   listFlow += /*html*/`<td>${object[property]}</td>`;
                                    
          //   // } 
          //   // tableContent += /*html*/`<tr class="trData">${listData+btnEdit}</tr>`;
            tableContent += /*html*/`<tr>${listFlow} ${listBeban}</tr>`;
            
          }
                                  
          $('tbody#zone_data').append(tableContent);
          
        } else if (data.respon.pesan == "gagal") {
          // alert(data.respon.text_msg);
          $("tbody#zone_data").html("<tr><td colspan='7'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
        }
      }, //end success
      error: function(x, e) {
        // error_handler_json(x, e, '=> list_per_dept()');
        alert('error');
      } //end error
    });
  }
</script>