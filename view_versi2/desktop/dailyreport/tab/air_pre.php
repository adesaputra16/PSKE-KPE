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

  .table2-header{
    border:1px solid #0F0808 !important;
    border-collapse: collapse;
    margin-top:-1px;
    width:100%;
  }
  .table2-header td{
    font-weight:bold;
    padding:3px;
    border:1px solid #0F0808 !important;	
    font-size:14px;
  }
  .table2-header td{
    padding:0px;
  }

  .table2{
    border:1px solid #0F0808;
    border-collapse: collapse;
    margin-top:-1px;
  }
  .table2 td,.table2 th{
    padding:1px;
    border:1px solid #0F0808 !important;	
    font-size:11px;
    color:#150000;
  }

  .table2 th{
    text-align:center;	
    font-weight:bold !important;
  }

  .table2 td h3{
    font-size:12px;
    font-weight:bold;
    line-height:0px;
  }


  .table2-unbordered{
    border:0px solid #0F0808;
    border-collapse: collapse;
    margin-top:-1px;
    width:100%;
  }
  .table2-unbordered td,.table2-unbordered th{
    padding:3px;
    border:0px solid #0F0808 !important;	
    font-size:9px;
  }



  .table3{
    border-collapse: collapse;
    margin-top:-1px;
  }
  .table3 td,.table3 th{
    padding:1px;
    font-size:11px;
    color:#150000;
  }

  .table3 th{
    text-align:center;	
    font-weight:bold !important;
  }

  .table3 td h3{
    font-size:12px;
    font-weight:bold;
    line-height:0px;
  }


  .table3-unbordered{
    border:0px solid #0F0808;
    border-collapse: collapse;
    margin-top:-1px;
    width:100%;
  }
  .table3-unbordered td,.table3-unbordered th{
    padding:3px;
    border:0px solid #0F0808 !important;	
    font-size:9px;
  }



  .table4{
    border:1px solid #0F0808;
    border-collapse: collapse;
    margin-top:-1px;
  }
  .table4 td,.table4 th{
    padding:1px;
    border:1px solid #0F0808 !important;	
    border-bottom:0px solid #0F0808 !important;	
    border-top:0px solid #0F0808 !important;	
    font-size:11px;
    color:#150000;
  }

  .table4 th{
    text-align:center;	
    font-weight:bold !important;
  }

  .table4 td h3{
    font-size:12px;
    font-weight:bold;
    line-height:0px;
  }


  .tablePrioritas{
    margin-top:-1px;
  }
  .tablePrioritas td,.tablePrioritas th{
    padding:1px;
    font-size:12px;
    color:#150000;
  }

  .tablePrioritas th{
    text-align:center;	
    font-weight:bold !important;
  }

  .tablePrioritas td h3{
    font-size:12px;
    font-weight:bold;
    line-height:0px;
  }




  .text-center{
    text-align:center;
  }
  .text-left{
    text-align:left;
  }

  .text-right{
    text-align:right;
  }

  .text-danger{
    color:#DF0C0F;
  }
  .text-warning{
    color:#DFB70C;
  }

  strong.unit-name{
    font-size:17px;
  }

  hr.header{
    color:#2F2B27;
  }

  h3{
    text-align:center;
  }

  .unit-name-33{
    color:#B83F21;
  }
  .unit-name-34{
    color:#21648E;
  }
  ol li{
    font-size:11px;
  }

  .table2-content{
    
  }

  .table2-content td{
    height:11px;
  }
  .sub-title{
    padding-left:20px;
    font-weight:bold;
    padding-top:2px;
    text-transform: uppercase;
    font-size:13px;
    color:#0D0303;
  }

  .sub-title i{
    color:#3A3939;
    text-transform: lowercase;
  }

  .td-kuning{
    background:#EFCD12;
  }


  .table-comments{
    width:100%;
  }
  .table-comments td,.table-comments th{
    width:210px;
    border-bottom:1px dotted #827D7D !important;
    text-align:left;
    font-size:8px;
  }
  .table-comments th.title{
    color:#424242;
  }

  .darurat{
    background:#EFCD12;
  }
  .td-hrd{
    background-color:#BFBFBF;
  }
  .judul_wo{
    font-size:20px;

  }
  .tdjudul_list{
    font-weight:bold;
  }
  .noborder{
    border:none;
  }

</style>

<div class="box-body">
  <div class="row">
    <div class="col-md-3  form-group">
      <label for="TAHUN_FILTER" >Tahun</label>
      <select class="form-control col-sm-2" name="TAHUN_FILTER" id="TAHUN_FILTER" onchange="filterHariSetahun();">
        <option value="">--Pilih tahun--</option>
        <?php
          $thnsekarang=Date('Y');
          $thnsebelumnya=$thnsekarang-7;
          for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
            echo"<option value='$thn'>$thn</option>";
        } ?>
      </select>
    </div>
    <div class="col-md-3  form-group">
      <label for="TANGGAL_FILTER" >Tanggal</label>
      <input id="TANGGAL_FILTER" name="TANGGAL_FILTER" type="text" class="form-control" value="" readonly>
    </div>
    <input type="hidden" id="first" value=""/>
    <input type="hidden" id="second" value=""/>
    <div class="col-md-4 form-group">
      <label for="JUMLAH_HARI">Hari ke :</label>
      <div class="input-group custom-search-form">
        <select class="form-control" name="JUMLAH_HARI" id="JUMLAH_HARI">
          
        </select>
        <span class="input-group-btn">
          <button type="button" class="btn btn-primary" id="btnFilter"><strong><i class="fa fa-eye"></i> Tampilkan</strong></button>
        </span>
      </div>
    </div>
    <br><br><br>
  </div>
  <div class="row">
    <div class="col-md-7">
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Pretreatment Water Usage (m³)</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>DEPT. USAGE</th>
                <th>USAGE</th>
                <th>(%)</th>
                <th>ACCUMULATIF</th>
                <th>(%)</th>
              </tr>
            </thead>
            <tbody id="PWU">
              <tr> 
                <td colspan="5">
                  <center>
                    <div class="loader"></div>
                  </center>
                </td>
              </tr>
            </tbody>
            <tfoot id="totalPWU">
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Stock</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Described</th>
                <th>(m3) Water</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>Larry the Bird</td>
                <td>@twitter</td>
              </tr>
              <tr>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th>2,173.58</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Pretreatment Water (Process)</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Described</th>
                <th>(m3) Water</th>
                <th>Accumulatif</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <td>Ujang</td>
                <td>Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th>1,152.35</th>
                <th>233,561.16</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Chemical Consumption (Kg)</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Described</th>
                <th>Accept</th>
                <th>Usage</th>
                <th>Accumulatif</th>
                <th>Stock</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th>2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th>3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box box-default box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">Operation</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Described</th>
                <th>Hour</th>
                <th>m3/hour</th>
                <th>Accumulatif (hour)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th>2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th>3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th>Total</th>
                <th>37.26</th>
                <th>125</th>
                <th>1685.35</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="box box-default box-solid">
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th colspan="2"></th>
                <th>Accumulatif</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th>2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th>3</th>
                <td>Larry the Bird</td>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- <table class="table3 table-unbordered" style="border:none;" width="100%">
				<tbody>
          <tr>
            <td class="text-left" valign="bottom" style="border:none;" width="20%"></td>
            <td>
              <table class="table2 table-bordered table2-content" width="100%">
                <tbody>
                  <tr>
                    <td width="50%" align="center"><strong>Prepared and Checked by:</strong></td>
                    <td width="50%" align="center"><strong>Confirmed by:</strong></td>
                  </tr>
                  <tr><td class="text-center"><h1><a onclick="approval('approve')"><i class="fa fa-thumbs-o-up fa-flip-horizontal text-success" aria-hidden="true"></i></a> <a value="disapprove" onclick="approval('disapprove')"><i class="fa fa-thumbs-o-down text-danger" aria-hidden="true"></i></a></h1></td><td class="text-center"><h1><a onclick="approval('approve')"><i class="fa fa-thumbs-o-up fa-flip-horizontal text-success" aria-hidden="true"></i></a> <a onclick="approval('approve')"><i class="fa fa-thumbs-o-down text-danger" aria-hidden="true"></i></a></h1></td></tr>
                  <tr>
                    <td>
                      <table class="table2 table2-unbordered">
                        <tbody>
                          <tr><td>Name</td><td>:ISAKNA</td></tr>
                          <tr><td>Post/Dept</td><td>:Adm</td></tr>
                          <tr><td>Date</td><td>:09/02/2021</td></tr>
                        </tbody>
                      </table>
                    </td>
                    <td>
                      <table class="table2 table2-unbordered">
                        <tbody><tr><td>Name</td><td>:HERI FIKRI</td></tr>
                          <tr><td>Post/Dept</td><td>:Dept Head WT</td></tr>
                          <tr><td>Date</td><td>:09/02/2021</td></tr>
                        </tbody>
                      </table>
						        </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody> 
      </table> -->
    </div>
  </div>
</div>

<script>

  $(function(){
    $('a.sidebar-toggle').click();
    $('#TAHUN_FILTER').val(<?= Date('Y') ?>);
    filterHariSetahun();
    listDlyPre();
  });	

  function tambahKosong(x){
    y=(x>9)?x:'0'+x;
    return y;
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

  function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }

  //?============ Filter Jumlah Hari Dalam Setahun ==============?//
  function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
  }

  function datediff(first, second) {
    return Math.round((second-first)/(1000*60*60*24));
  }

  function filterHariSetahun() {
    let date = new Date($('#TAHUN_FILTER').val());
    $('#JUMLAH_HARI').empty();
    $('#first').val("1/1/"+date.getFullYear()+"");
    $('#second').val("1/1/"+(date.getFullYear()+1)+"");
    let jumlahHari = '';
    for (let i = 1; i <= datediff(parseDate(first.value), parseDate(second.value)); i++) {
      jumlahHari  += /*html*/`<option value="${i}">${depanKosong(i)}</option>`;
    }
    $('#JUMLAH_HARI').append(/*html*/`<option value="">--Pilih--</option>${jumlahHari}`);
  }
  //?============ End Filter Jumlah Hari Dalam Setahun ==============?//

  function approval(app) {
    console.log(app);
  }

  function listDlyPre() {
    $('#PWU').empty();
    $('#totalPWU').empty();
    //!Set jumlah hari
    if ($('#JUMLAH_HARI').val() == "") {
      let dateNow = new Date();
      var date= dateNow.getFullYear()+"/"+(tambahKosong(dateNow.getMonth()+1)) +"/"+tambahKosong(dateNow.getDate());
    } else {
      //!Set tanggal berdasarkan jumlah hari yg di input 
      let targetDate = new Date($('#TAHUN_FILTER').val());
      targetDate.setDate($('#JUMLAH_HARI').val());
      date= targetDate.getFullYear()+"/"+(tambahKosong(targetDate.getMonth()+1)) +"/"+tambahKosong(targetDate.getDate());
    }
    $('#TANGGAL_FILTER').val(date)
    let now = new Date();
    let start = new Date(now.getFullYear(), 0, 0);
    let diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
    let oneDay = 1000 * 60 * 60 * 24;
    let day = Math.floor(diff / oneDay);
    $('#JUMLAH_HARI').val(day)
    // console.log(date);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      //data:'ref=simpan_catatan&'+data,
      data:'aplikasi=<?php echo $d0;?>&ref=list_dly_report_pre&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+date,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        {
          // console.log(data.result);
          // console.log(data.TOTAL_USAGE);
          // let listPWU = '';
          let arrPersen = [];
          let arrAcc = [];
          let arrAccPersen = [];
          for (let i = 0; i < data.result.length; i++) {
            // listPWU += /*html*/`<td>${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>`;
            if (data.result[i].BEBAN_HARIAN.KPE_AIR_FLOWMETER_CATATAN_BEBAN == "0") {
              var beban = '-';
              var persenUsage = '-';
              var persen = '';
            } else if (data.result[i].BEBAN_HARIAN != ""){
              beban = formatNumber(data.result[i].BEBAN_HARIAN.KPE_AIR_FLOWMETER_CATATAN_BEBAN);
              persenUsage = parseFloat(data.result[i].BEBAN_HARIAN.KPE_AIR_FLOWMETER_CATATAN_BEBAN / data.TOTAL_USAGE * 100).toFixed(2);
              persen = parseFloat(data.result[i].BEBAN_HARIAN.KPE_AIR_FLOWMETER_CATATAN_BEBAN / data.TOTAL_USAGE * 100);
              arrPersen.push(persen);
            } else {
              beban = '-';
              persenUsage = '-';
            }
            if (data.result[i].ACCUMULATIF.ACCUMULATIF == null) {
              var acc = '';
              var accTotal = '0';
              var accu = '';
              var accuPersen = '';
            } else {
              acc = parseFloat(data.result[i].ACCUMULATIF.ACCUMULATIF).toFixed(2);
              accu = parseFloat(data.result[i].ACCUMULATIF.ACCUMULATIF);
              accTotal = parseFloat(data.result[i].ACCUMULATIF.ACCUMULATIF / data.ACCUMULATIF_TOTAL * 100).toFixed(2);
              accuPersen = parseFloat(data.result[i].ACCUMULATIF.ACCUMULATIF / data.ACCUMULATIF_TOTAL * 100);
              arrAccPersen.push(accuPersen);
              arrAcc.push(accu);
            }
            $('tbody#PWU').append(/*html*/`<tr>
                                            <td>${data.result[i].KPE_AIR_FLOWMETER_NAMA}</td>
                                            <td>${beban}</td>
                                            <td>${persenUsage}</td>
                                            <td>${acc}</td>
                                            <td>${accTotal}</td>
                                          </tr>`);
          }

          $('#totalPWU').append(/*html*/`<tr>
                                            <th>Total</th>
                                            <th>${formatNumber(parseFloat(data.TOTAL_USAGE).toFixed(2))}</th>
                                            <th>${formatNumber(arrPersen.reduce((a, b) => a + b, 0).toFixed(2))}</th>
                                            <th>${formatNumber(arrAcc.reduce((a, b) => a + b, 0).toFixed(2))}</th>
                                            <th>${formatNumber(arrAccPersen.reduce((a, b) => a + b, 0).toFixed(2))}</th>
                                          </tr>`);
          
        }else if(data.respon.pesan=="gagal")
        {
          console.log('gagal');
        }
      },
      error:function(x,e){
        // error_handler_json(x,e,'=> simpan_catatan()');
        console.log("error");
      }//end error
    });
  }

  $('button#btnFilter').on('click',function () {
    listDlyPre();
  })
  
</script>