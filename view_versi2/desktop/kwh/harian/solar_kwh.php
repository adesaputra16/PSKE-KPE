<style>
.Content {
  height:800px;
  overflow:auto;
  background:#fff;
}
</style>

<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2 form-group tanggalawal"  id="divtanggalawal">
            <label for="DATA_sDATE" id="labelsDate">Tanggal</label>
            <input id="DATA_sDATE" name="DATA_sDATE"  type="text" class="datepicker col-sm-2 form-control" placeholder="<?= Date("Y/m/d"); ?>" value="<?= Date("Y/m/d"); ?>" autocomplete="off">
          </div>
          <div class="col-md-4">
            <label>&nbsp;</label>
            <div class="input-group custom-search-form">
              <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
              &nbsp;<button type="button" class="btn btn-info btn-distribusi"><strong>Distribusi Harian</strong></button>
            </div>
          </div>
        </div>
      <hr>
      <div class="sk-wave text-center" id="loader">
        <div class="sk-rect sk-rect1"></div>
        <div class="sk-rect sk-rect2"></div>
        <div class="sk-rect sk-rect3"></div>
        <div class="sk-rect sk-rect4"></div>
        <div class="sk-rect sk-rect5"></div>
      </div>
      <div class="table-responsive Content animasi-table" id="divTable">
        <div class="row">
          <div class="col-md-3">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 id="operasional_turbin"></h3>
                <p>Operasional Turbin</p>
              </div>
              <div class="icon">
                <i class="fa fa-file-text"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="small-box bg-green">
              <div class="inner">
                <h3 id="total_kwh"></h3>
                <p>Total kWh</p>
              </div>
              <div class="icon">
                <i class="fa fa-bolt"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 id="acc_kwh"></h3>
                <p>Total Acc kWh</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="small-box bg-red">
              <div class="inner">
                <h3 id="acc_solar"></h3>
                <p>Total Acc Solar</p>
              </div>
              <div class="icon">
                <i class="fa fa-tint"></i>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-hover table-bordered table-sticky">
          <thead>
            <tr>
              <th>KWH METER</th>
              <th colspan="10" class="text-center">PEMAKAIAN SOLAR DAN LISTRIK HARIAN</th>
            </tr>
            <tr>
              <th id="tglHarianSolar">DEPT</th>
              <th>PUTARAN</th>
              <th>READING</th>
              <th>KWh</th>
              <th>% KWh</th>
              <th>ACC KWh</th>
              <th>% ACC KWh</th>
              <th>SOLAR</th>
              <th>ACC SOLAR</th>
            </tr>
          </thead>
          <tbody id="zone_data">
            <!-- <tr> 
              <td class="backloader" colspan="20">
                <center>
                  <div class="loader"></div>
                </center>
              </td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!-- //?======= Modal Distribusi -->
<div class="modal fade" id="modalDistribusi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:10000;">
  <div class="modal-dialog" style="width:90%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h3><i class="fa fa-file-text"></i> Record Harian Distribusi dan Selisih</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div id="alert"></div>
            <form action="javascript:simpanHarianDistribusi()" id="fData">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL">Tanggal</label>
                    <input type="text" class="form-control datepicker KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL" placeholder="<?= Date("Y/m/d"); ?>" autocomplete="off" required>
                    <input type="text" style="display:none;" class="form-control KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID" autocomplete="off">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN">Turbin</label>
                    <input type="text" class="form-control KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN" placeholder="kWh Turbin" autocomplete="off">
                    <a data-toggle="tooltip" title="Pemakaian kWh Turbin (kosongkan jika tidak ada)" data-content="Pemakaian kWh Turbin (kosongkan jika tidak ada)" data-placement="left"><small class="help-block">kWh Turbin <i class="glyphicon glyphicon-info-sign"></i></small></a>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE">Powerhouse</label>
                    <input type="text" class="form-control KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE" placeholder="kWh Powerhouse" autocomplete="off" >
                    <a data-toggle="tooltip" title="Pemakaian kWh Powerhouse (kosongkan jika tidak ada)" data-content="Pemakaian kWh Powerhouse (kosongkan jika tidak ada)" data-placement="left"><small class="help-block">kWh Powerhouse <i class="glyphicon glyphicon-info-sign"></i></small></a>
                  </div>
                </div>
                <div class="col-sm-2 form-group">
                  <label for="KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR">Solar</label>
                  <input type="text" class="form-control KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR" placeholder="Pemakaian Solar" autocomplete="off">
                  <a data-toggle="tooltip" title="Pemakaian Solar (kosongkan jika tidak ada)" data-content="Pemakaian Solar (kosongkan jika tidak ada)" data-placement="left"><small class="help-block">Solar <i class="glyphicon glyphicon-info-sign"></i></small></a>
                </div>
                <div class="col-sm-4 form-group">
                  <label for="KPE_KWH_DISTRIBUSI_SOLAR_KWH_OPERASIONAL_TURBIN_PENGKONDISIAN">Pengkondisian Solar Opn Turbin</label>
                  <div class="input-group custom-search-form">
                  <input type="text" class="form-control KPE_KWH_DISTRIBUSI_SOLAR_KWH_OPERASIONAL_TURBIN_PENGKONDISIAN" id="KPE_KWH_DISTRIBUSI_SOLAR_KWH_OPERASIONAL_TURBIN_PENGKONDISIAN" name="KPE_KWH_DISTRIBUSI_SOLAR_KWH_OPERASIONAL_TURBIN_PENGKONDISIAN" placeholder="Pengkondisian Solar" autocomplete="off">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-success" id="btn-simpan"><strong><i class="fa fa-save"></i> Simpan</strong></button>
                    </span>
                  </div>
                  <a data-toggle="tooltip" title="Pengkondisian Solar Opn Turbin (kosongkan jika tidak ada)" data-content="Pengkondisian Solar Opn Turbin (kosongkan jika tidak ada)" data-placement="left"><small class="help-block">Pengkondisian Solar <i class="glyphicon glyphicon-info-sign"></i></small></a>
                </div>
              </div>
            </form>
            <hr>
            <form action="javascript:listHarianDistribusi()" id="fDataDistribusi" class="fDataDistribusi">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="BULAN_FILTER">Bulan</label>
                    <select class="form-control" name="BULAN_FILTER" id="BULAN_FILTER">
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
                </div>
                <div class="col-sm-6 form-group">
                  <label for="TAHUN_FILTER">Tahun</label>
                  <div class="input-group custom-search-form">
                    <select class="form-control" name="TAHUN_FILTER" id="TAHUN_FILTER">
                      <option value="">--Pilih tahun--</option>
                      <?php
                        $thnsekarang=Date('Y');
                        $thnsebelumnya=$thnsekarang-7;
                        for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
                          echo"<option value='$thn'>$thn</option>";
                        } ?>
                    </select>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary" id="btn-reload-dist"><strong><i class="fa fa-refresh"></i> Tampilkan</strong></button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-sticky">
                <thead>
                    <tr>
                      <th rowspan="2"><center>AKSI</center></th>
                      <th rowspan="2"><center>TGL</center></th>
                      <th colspan="4"><center><b>KWH</b></center></th>
                      <th rowspan="2"><center>Selisih (distribusi - tbn)</center></th>
                    </tr>
                    <tr>
                      <th>Pembebanan</th>
                      <th>Distribusi</th>
                      <th>Turbin</th>
                      <th>Powerhouse</th>
                    </tr>
                </thead>
                <tbody id="zone_data_tbn">
                  <!-- <tr> 
                    <td class="backloader" colspan="20">
                      <center>
                        <div class="loader"></div>
                      </center>
                    </td>
                  </tr> -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- //?======= end ======-->


<script>
  const loader = () => {
    setTimeout(listHarianSolarKwh, 2000);
  }

  $(() => {
    loader()
    tglHarianSolar()
    listHarianDistribusi()
    $(".datepicker").datepicker().on('changeDate', function(ev)
    {  
      $('.datepicker').datepicker('hide')
    })
    // jadwal()
    // $('[data-toggle="popover"]').popover()
  })

  $("#btn-reload").on("click",() => {
    preLoader()
    tglHarianSolar()
    // listHarianSolarKwh()
  })

  $(".btn-distribusi").on("click",() => {
    $("#modalDistribusi").modal('show')
    $("form#fData")[0].reset()
    $(".alert-close").remove()
  })

  const tglHarianSolar = () => {
    $("th.tglHarian").remove()
    $("th#tglHarianSolar").after(/*html*/`<th class="tglHarian">${GetDays()[0]}</th><th class="tglHarian">${GetDays()[1]}</th>`)
  }

  function format_tanggal(fulld) {
    const sdate = fulld;
    const dt = new Date(sdate);
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const tanggal = dt.getDate() + "-" + months[dt.getMonth()] + "-" + dt.getFullYear().toString().substr(-2);
    return tanggal;
  }

  const GetDays = (Mention_today = false) => {
    let DateArray = [];
    let days = 1;
    for (let i = 0; i <= days; i++) {
      if (!Mention_today && i == 0) {
        i = 1;
        days += 1;
      }
      let date = new Date($("input#DATA_sDATE").val());
      let last = new Date(date.getTime() + (i - 1) * 24 * 60 * 60 * 1000);
      let day = last.getDate();
      let month = last.getMonth() + 1;
      let year = last.getFullYear();
      const fulld = Number(year) + "-" + Number(month) + "-" + Number(day);
      DateArray.push(format_tanggal(fulld));
    }
    return DateArray;
  };

  const listHarianSolarKwh = (curPage) => {

    $("#loader").fadeOut();
    $('#divTable').attr('style','display:block;');

    const url = window.location.href;
    const pageA = url.split("#");
    if (pageA[1] == undefined) {} else {
      const pageB = pageA[1].split("page-");
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
      data:'aplikasi=<?php echo $d0;?>&ref=list_harian_solar_kwh&DATE='+$("input#DATA_sDATE").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      success: (data) => {

        $("tbody#zone_data").empty()
        if (data.respon.pesan == 'sukses') {
          let totalKwh = []
          let totalAccKwh = []
          let totalAccSolar = []
          let listData = '',catatan=''
          for (let i = 0; i < data.result.length; i++) {
              listData += /*html*/`<tr>
                                    <td>${data.result[i].KPE_KWH_FLOWMETER_NAMA}</td>
                                    <td>${data.result[i].KPE_KWH_CATATAN_ANGKA}</td>
                                    <td>${data.result[i].KPE_KWH_CATATAN_ANGKA_ESTIMASI}</td>
                                    <td>${data.result[i].KPE_KWH_CATATAN_BEBAN}</td>
                                    <td>${data.result[i].KPE_KWH_FLOWMETER_READING}</td>
                                    <td>${data.result[i].KPE_KWH_CATATAN_BEBAN_X_READING}</td>
                                    <td>${data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_PERSEN}</td>
                                    <td>${data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_ACC}</td>
                                    <td>${data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_ACC_PERSEN}</td>
                                    <td>${data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_PAKAI}</td>
                                    <td>${data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_ACC}</td>
                                  </tr>`
            totalKwh.push(parseFloat(data.result[i].KPE_KWH_CATATAN_BEBAN_X_READING))
            totalAccKwh.push(parseFloat(data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_ACC))
            totalAccSolar.push(parseFloat(data.result[i].KPE_KWH_HARIAN_SOLAR_KWH_SOLAR_ACC))
          }

          $("#operasional_turbin").text(formatNumber(data.DISTRIBUSI.KPE_KWH_DISTRIBUSI_SOLAR_KWH_PEMBEBANAN))
          $("#total_kwh").text(formatNumber(totalKwh.reduce((a, b) => a + b, 0).toFixed(2)))
          $("#acc_kwh").text(formatNumber(totalAccKwh.reduce((a, b) => a + b, 0).toFixed(2)))
          $("#acc_solar").text(formatNumber(totalAccSolar.reduce((a, b) => a + b, 0).toFixed(2)))
          $("tbody#zone_data").append(listData)

        } else if (data.respon.pesan == 'gagal') {
          $("tbody#zone_data").html(/*html*/`<tr><td colspan="11"><div class="alert alert-danger" role="alert"><center><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ${data.respon.text_msg}</center></div></td></tr>`)
          $("#operasional_turbin").text(0)
          $("#total_kwh").text(0)
          $("#acc_kwh").text(0)
          $("#acc_solar").text(0)
        }
      }
    })
  }

  const simpanHarianDistribusi = () => {
    const fData = $("#fData").serialize()
    $("#btn-simpan").attr("disabled","disabled")
    $("#btn-simpan").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Menyimpan...')

    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_harian_solar_kwh&'+fData,
      success: (data) => {
        console.log(data.result);
        if (data.respon.pesan == 'sukses') {
          $('form#fData')[0].reset()
          $("div#alert").html(/*html*/`<div class="alert alert-success alert-dismissible alert-close" role="alert" style="opacity:0.7;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <i class="fa fa-check" aria-hidden="true"></i> ${data.respon.text_msg}
                                      </div>`)
          $("#btn-simpan").removeAttr("disabled")
          $("#btn-simpan").html('<strong><i class="fa fa-check"></i> Tersimpan</strong>')
          listHarianDistribusi()
          preLoader()
        } else if (data.respon.pesan == 'gagal') {
          $("div#alert").html(/*html*/`<div class="alert alert-danger alert-dismissible alert-close" role="alert" style="opacity:0.7;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <i class="fa fa-times" aria-hidden="true"></i> ${data.respon.text_msg}
                                      </div>`)
          // $("#btn-simpan").removeAttr("disabled")
          $("#btn-simpan").removeClass("btn-success")
          $("#btn-simpan").addClass("btn-danger")
          $("#btn-simpan").html('<strong><i class="fa fa-times"></i> Gagal</strong>')
        }
          setTimeout(() => {
            // $(".alert-close").fadeOut()
            $("#btn-simpan").removeAttr("disabled")
            $("#btn-simpan").html('<strong><i class="fa fa-save"></i> Simpan</strong>')
            $("#btn-simpan").removeClass("btn-danger")
            $("#btn-simpan").addClass("btn-success")
          }, 1500);
      },error:function(x,e){
        // error_handler_json(x,e,'=> hapus_catatan()');
        console.log("error")
      }
    })
  }

  const listHarianDistribusi = () => {
    const fDataDistribusi = $("#fDataDistribusi").serialize()
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_harian_distribusi&'+fDataDistribusi,
      success: (data) => {
        $("tbody#zone_data_tbn").empty()
        if (data.respon.pesan == 'sukses') {
          for (let i = 0; i < data.result.length; i++) {
            let arr = JSON.stringify(data.result[i])    
            $("tbody#zone_data_tbn").append(/*html*/`<tr>
                                                      <td class="text-center"><a type="button" class='edit btn btn-sm btn-warning' OBJ='${arr}' ><i class='fa fa-edit'></i></a> <a OBJ='${arr}' type="button" class="delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                                      <td class="text-center">${(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL).substr(5,9)}</td>
                                                      <td class="text-center">${formatNumber(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_PEMBEBANAN)}</td>
                                                      <td class="text-right">${formatNumber(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_DISTRIBUSI)}</td>
                                                      <td class="text-right">${formatNumber(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN)}</td>
                                                      <td class="text-right">${formatNumber(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE)}</td>
                                                      <td class="text-right">${formatNumber(data.result[i].KPE_KWH_DISTRIBUSI_SOLAR_KWH_SELISIH)}</td>
                                                     </tr>`)
          }
        } else if (data.respon.pesan == 'gagal') {
          $("tbody#zone_data_tbn").html(/*html*/`<tr><td colspan="7"><div class="alert alert-danger" role="alert"><center><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ${data.respon.text_msg}</center></div></td></tr>`)
        }
      }
    })
  }

  $('tbody').on('click', 'a.edit', function(){
    const object = $(this).attr('OBJ')
    const data = JSON.parse(object)
    const date = (data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL).split('-')
    $("#KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN").val(data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_TURBIN)
    $("#KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE").val(data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_POWERHOUSE)
    $("#KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR").val(data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_SOLAR)
    $("#KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID").val(data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID)
    $("#KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL").val(`${date[0]}/${date[1]}/${date[2]}`)
  })

  $('tbody').on('click', 'a.delete', function(){
    const object = $(this).attr('OBJ')
    const data = JSON.parse(object)

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
          data:'aplikasi=<?php echo $d0;?>&ref=hapus_harian_distribusi&KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID='+data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_ID+'&KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL='+data.KPE_KWH_DISTRIBUSI_SOLAR_KWH_TANGGAL,
          success:function(data)
          { 
            if(data.respon.pesan=="sukses")
            {
              toastNotifikasi("success",`${data.respon.text_msg}`)
              preLoader()
              listHarianDistribusi()
              
            }else if(data.respon.pesan=="gagal")
            {
              toastNotifikasi("error",`${data.respon.text_msg}`)
            }
          },
          error:function(x,e){
            // error_handler_json(x,e,'=> hapus_catatan()');
            alert('error')
          }//end error
        });
      }
    })
  })
</script>