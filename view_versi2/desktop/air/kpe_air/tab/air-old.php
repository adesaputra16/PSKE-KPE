<style>
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


</style>


<div class="box-body">
  <button type="button" class="btn btn-sm btn-success modalCatatan" ><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Catatan</button> 
  <div class="pull-right">
    <button type="button" class="btn btn-sm btn-primary" id="btn-reload"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</button>
    <a type="button" id="cetakPdf" class="btn btn-sm btn-warning"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a> 
  </div>
  <br><br>
  
  <!-- Pencarian -->
  <div class="row">
    <div class="col-md-2 form-group">
      <label for="JENIS_LAPORAN">Jenis Akumulasi</label>
      <select class="form-control col-sm-2" name="JENIS_LAPORAN" id="JENIS_LAPORAN" onchange="jenisAkumulasi()" required>
        <!--<option value="0">--Pilih--</option>-->
        <option value="Harian" selected>Harian</option>
        <option value="Mingguan">Mingguan</option>
        <option value="Bulanan">Bulanan</option>
        <option value="Tahunan">Tahunan</option>
      </select>
    </div>
    
    <div class="col-md-2 form-group tanggalawal"  id="divtanggalawal">
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
    <div class="col-md-2  form-group" id="divtahunfilter2" hidden>
      <label for="TAHUN_FILTER2" >Tahun</label>
      <select class="form-control col-sm-2" name="TAHUN_FILTER2" id="TAHUN_FILTER2">
        <option value="">--Pilih tahun--</option>
        <?php
          $thnsekarang=Date('Y');
          $thnsebelumnya=$thnsekarang-7;
          for($thn=$thnsebelumnya;$thn<=$thnsekarang;$thn++){
            echo"<option value='$thn'>$thn</option>";
          } ?>
      </select>
    </div>
  </div>

  <!-- Tabel -->
  <div class="box">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
                <tr>
                  <th rowspan="2">NO.</th>
                  <th colspan="2" rowspan="2"><center><b>DEPARTEMENT</b></center></th>
                  <th id="tglCatatan" ><center><b>TANGGAL</b></center></th>
                  <th rowspan="2"><b>LOKASI</b></th>
                  <th rowspan="2"><b>DISTRIBUSI</b></th>
                  <th rowspan="2"><b>AKSI</b></th>
                </tr>
                <tr id="colTgl">
                </tr>
            </thead>
            <tbody id="zone_data">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- end tabel -->

  <div class="row">
    <div class="col-md-9">
      <div class="pagination-holder clearfix">
        <div class="pagination" id="tujuan-light-pagination"></div>
      </div>
    </div>
    <div class="col-md-3 text-right">
      <label>Jumlah Baris Per Halaman</label>
      <input class="form-control" id="REC_PER_HALAMAN" max='1000' min="1" name="REC_PER_HALAMAN" required="" type="number" value="10">
    </div>

    <!-- <span class="coba">dsfadsf</span> -->
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCatatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="exampleModalLabel">Tambah Catatan</h4>
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-md-12">
          <form action="javascript:simpan();" class="fDataWilayah" id="fData" name="fDataWilayah">
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
              <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control">
              <option value="">--Pilih--</option>
              </select>
            </div>
            <!-- <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_SUB_ID">Sub Flowmeter</label>
              <select id="KPE_AIR_FLOWMETER_SUB_ID" name="KPE_AIR_FLOWMETER_SUB_ID" class="form-control">
              <option value="">--Pilih--</option>
              </select>
            </div> -->
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_CATATAN_ANGKA">Catatan Angka</label>
              <input type="text" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_ANGKA" name="KPE_AIR_FLOWMETER_CATATAN_ANGKA" autocomplete="off" placeholder="123.456" step="any">
              
              <input type="hidden" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_ID" name="KPE_AIR_FLOWMETER_CATATAN_ID" value="">
            </div>
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_CATATAN_TANGGAL">Tanggal</label>
              <input type="date" class="form-control" id="KPE_AIR_FLOWMETER_CATATAN_TANGGAL" name="KPE_AIR_FLOWMETER_CATATAN_TANGGAL" >
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var months = {'01':'January', '02':'Februari', '03':'Maret', '04':'April', '05':'Mei', '06':'Juni', '07':'Juli', '08':'Agustus', '09':'September', '10':'Oktober', '11': 'November', '12':'Desember'};

  $(function(){
    $('input#DATA_eDATE').attr("readonly","readonly");
    $("input#DATA_sDATE").datepicker().on('changeDate', function(ev)
    {  
      var TANGGAL_AWAL=$("input#DATA_sDATE").val();   
      // alert(TANGGAL_AWAL);          
      //MENENTUKAN TANGGAL AKHIRNYA SEMINGGU DARI TANGGAL AWAL
      var myDate = new Date(TANGGAL_AWAL);
      myDate.setDate(myDate.getDate() + 6);
      
      var month = '' + (myDate.getMonth() + 1),day = '' + myDate.getDate(),year = myDate.getFullYear();
      if (month.length < 2) 
        month = '0' + month;
      if (day.length < 2) 
        day = '0' + day;
      var TANGGAL_AKHIR=year+"/"+month+"/"+day;
      //END MENETUKAN TANGGAL AKHIRNYA
      // alert(TANGGAL_AKHIR);
      var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val();
      if (JENIS_LAPORAN == "Harian") 
      {
        $('input#DATA_eDATE').val('');
      } else {
        $("input#DATA_eDATE").val(TANGGAL_AKHIR);
      }
      $('.datepicker').datepicker('hide');
      });
  });	

  function jenisAkumulasi(){
    var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val(); 
    if (JENIS_LAPORAN == "Harian") 
    {
    
      $('input#DATA_sDATE').removeAttr("disabled");
      $('input#DATA_sDATE').attr("required");
      $('div#divtanggalawal').attr("style", "display:block");
      $('label#labelsDate').html("Tanggal");
      $('input#DATA_sDATE').val("");
      
      $('input#DATA_eDATE').attr("disabled","disabled");
      $('div#divtanggalakhir').attr("style", "display:none");      
      
      $('select#BULAN_FILTER').attr("disabled","disabled");
      $('select#BULAN_FILTER').removeAttr("required");
      $('select#BULAN_FILTER').val("");
      $('div#divbulanfilter').attr("style", "display:none");
      
      $('select#TAHUN_FILTER').attr("disabled","disabled");
      $('select#TAHUN_FILTER').removeAttr("required");
      $('div#divtahunfilter').attr("style", "display:none");
      $('select#TAHUN_FILTER').val("");

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
      
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

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
    
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
      $('div#divtahunfilter').attr("style", "display:none");

      $('select#TAHUN_FILTER2').removeAttr("disabled");
      $('select#TAHUN_FILTER2').attr("required");
      $('div#divtahunfilter2').attr("style", "display:block");
      $('select#TAHUN_FILTER2').val("");
    
    }else if (JENIS_LAPORAN == "Tahunan")
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
      
      $('select#TAHUN_FILTER').removeAttr("disabled");
      $('select#TAHUN_FILTER').attr("required");
      $('select#TAHUN_FILTER').val("");
      $('div#divtahunfilter').attr("style", "display:block");

      $('select#TAHUN_FILTER2').attr("disabled","disabled");
      $('select#TAHUN_FILTER2').removeAttr("required");
      $('div#divtahunfilter2').attr("style", "display:none");
      $('select#TAHUN_FILTER2').val("");
    
    }else{
      $('input#DATA_eDATE').attr("readonly","readonly");}
    //search();
  }

  $('.modalCatatan').on('click', function(){
    $("#modalCatatan").modal('show');
    $('#KPE_AIR_FLOWMETER_ID').val('');
    $('#KPE_AIR_FLOWMETER_SUB_ID').val('');
    $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA').val('');
    $('#KPE_AIR_FLOWMETER_CATATAN_ID').val('');
    $('#KPE_AIR_FLOWMETER_CATATAN_TANGGAL').val('');
  })

  function simpan()
  {
  var fData=$("#fData").serialize(); 
  var data = "&KPE_AIR_FLOWMETER_NAMA="+btoa($("#KPE_AIR_FLOWMETER_ID").children("option:selected"). text())+"&"+fData
  $.ajax({
    type:'POST',
    url:refseeAPI,
    dataType:'json',
    //data:'ref=simpan_catatan&'+data,
    data:'aplikasi=<?php echo $d0;?>&ref=simpan_catatan&'+data,
    success:function(data)
    { 
      
      if(data.respon.pesan=="sukses")
      {
        $("#modalCatatan").modal('hide');
        alert(data.respon.text_msg);
        tampil('1');
        
      }else if(data.respon.pesan=="gagal")
      {
        alert(data.respon.text_msg);
        tampil('1');
      }
    },
    error:function(x,e){
      error_handler_json(x,e,'=> simpan_catatan()');
    }//end error
  });
  }


  $('tbody').on('click', 'a.edit', function(){
    var KPE_AIR_FLOWMETER_CATATAN_ANGKA = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ANGKA');
    var KPE_AIR_FLOWMETER_CATATAN_ID = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ID');
    var KPE_AIR_FLOWMETER_NAMA = $(this).attr('KPE_AIR_FLOWMETER_NAMA');
    var KPE_AIR_FLOWMETER_ID = $(this).attr('KPE_AIR_FLOWMETER_ID');
    var KPE_AIR_FLOWMETER_CATATAN_TANGGAL = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_TANGGAL');
    $("#modalCatatan").modal('show');
    $('input#KPE_AIR_FLOWMETER_CATATAN_ANGKA').val(KPE_AIR_FLOWMETER_CATATAN_ANGKA);
    $('input#KPE_AIR_FLOWMETER_CATATAN_ID').val(KPE_AIR_FLOWMETER_CATATAN_ID);
    $('input#KPE_AIR_FLOWMETER_NAMA').val(KPE_AIR_FLOWMETER_NAMA);
    $('input#KPE_AIR_FLOWMETER_CATATAN_TANGGAL').val(KPE_AIR_FLOWMETER_CATATAN_TANGGAL);
    $('select#KPE_AIR_FLOWMETER_ID').val(KPE_AIR_FLOWMETER_ID);
  });

  function tampil(curPage)
  {
    // var data = 'tampil_catatan&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage;
    // console.log(data);
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
      data:'aplikasi=<?php echo $d0;?>&ref=tampil_catatan&keyword='+$("input#keyword").val()+'&DATA_sDATE='+$("input#DATA_sDATE").val()+'&DATA_eDATE='+$("input#DATA_eDATE").val()+'&BULAN_FILTER='+$("select#BULAN_FILTER").val()+'&TAHUN_FILTER='+$("select#TAHUN_FILTER").val()+'&TAHUN_FILTER2='+$("select#TAHUN_FILTER2").val()+'&batas='+$("input#REC_PER_HALAMAN").val()+'&halaman='+ curPage,
      
      success: function(data) {
        // console.log(data);
        if (data.respon.pesan == "sukses") 
        {
          // alert(data.respon.pesan);
          // $("span.coba").html(data.respon.boaboa);
          $("tbody#zone_data").empty();
          $('#tujuan-light-pagination').pagination({
            pages: data.result_option.jml_halaman,
            cssStyle: 'light-theme',
            currentPage: curPage,
          });
          
              
              var tableContent = "";  
              for (var j = 0; j < data.result.length; j++) 
              {
							// calculate rowspan for first cell
                var rowspan = 0;
                var JFLOWMETER = data.result[j].FLOWMETER.length;
                rowspan += JFLOWMETER;
                // create rows
                tableContent += "<tr>"+
                                "<td rowspan=" + parseInt(1 + rowspan) + ">" + data.result[j].NO + ".</td>"+
                                "<td rowspan=" + parseInt(1 + rowspan) + ">" + data.result[j].KPE_AIR_FLOWMETER_SUB_NAMA + "</td></tr>";
                var d = new Date();
                var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
                for (var i = 0; i < data.result[j].FLOWMETER.length; i++) 
                {
                  var date = new Date(data.result[j].FLOWMETER[i].ENTRI_WAKTU);
                  var tanggal = date.getFullYear() +"/" + (date.getMonth()+1) + "/" + (date.getDate()+2) + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds(); 
                  console.log(date);
                  console.log(strDate);

                  if (new Date(tanggal) < new Date(strDate)) {
                    var disabled = 'disabled';
                  }
                  else{
                    var disabled = '';
                  }

                  tableContent += "<tr>" +
                                  "<td>" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_NAMA +"</td>"+
                                  // "<td>" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_TANGGAL + "</td>" +
                                  "<td>" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ANGKA + "</td>" +
                                  "<td>" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_LOKASI + "</td>" +
                                  "<td>" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_DISTRIBUSI + "</td>" +
                                  "<td>" +
                                    "<div class='btn-group'>"+
                                      "<div class='btn-group dropleft' role='group'>"+
                                        "<button type='button' class='btn btn-xs btn-default dropdown-toggle dropdown-toggle-split' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'"+disabled+">"+
                                          "<span class='sr-only'>Toggle Dropleft</span>"+
                                        "</button>"+
                                        "<div class='dropdown-menu'>"+
                                          "<li><a class='edit' KPE_AIR_FLOWMETER_ID='"+data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_ID+"' KPE_AIR_FLOWMETER_CATATAN_ANGKA='" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ANGKA + "' KPE_AIR_FLOWMETER_CATATAN_TANGGAL='" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_TANGGAL + "' KPE_AIR_FLOWMETER_NAMA='" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_NAMA + "' KPE_AIR_FLOWMETER_CATATAN_ID='" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ID + "' ><i class='fa fa-edit'></i>Edit </a></li>"+
                                          "<li><a class='hapus' KPE_AIR_FLOWMETER_CATATAN_ID='" + data.result[j].FLOWMETER[i].KPE_AIR_FLOWMETER_CATATAN_ID + "'><i class='fa fa-trash'></i> Hapus </a></li>"+
                                        "</div>"+
                                      "</div>"+
                                      "<button type='button' class='btn btn-xs btn-success' "+disabled+">"+
                                        "<i class='fa fa-eye'></i>"+
                                      "</button>"+
                                    "</div>"+
                                  "</td>"+
                                  "</tr>";
                                
                }
              }
              $("tbody#zone_data").append(tableContent);
            

        } else if (data.respon.pesan == "gagal") {
          // alert(data.respon.text_msg);
          $("tbody#zone_data").html("<tr><td colspan='7'><div class='alert alert-danger' role='alert'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> " + data.respon.text_msg + "</div></td></tr>");
        }
      }, //end success
      error: function(x, e) {
        error_handler_json(x, e, '=> tampil_catatan()');
      } //end error
    });
  }

  $(window).on('hashchange', function(e) {
  tampil('1');
  });
  $("input#REC_PER_HALAMAN").on('change', function() {
  tampil('1');
  });
  $("input#DATA_sDATE").on('change', function() {
  tampil('1');
  });

  $('tbody').on('click', 'a.hapus', function(){
  // var KPE_AIR_FLOWMETER_CATATAN_ID = $(this).attr('KPE_AIR_FLOWMETER_CATATAN_ID');
  // alert(KPE_AIR_FLOWMETER_CATATAN_ID);
  if (confirm('Yakin akan menghapus data ini??')){
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      data:'aplikasi=<?php echo $d0;?>&ref=hapus_catatan&KPE_AIR_FLOWMETER_CATATAN_ID='+KPE_AIR_FLOWMETER_CATATAN_ID,
      success:function(data)
      { 
        if(data.respon.pesan=="sukses")
        {
          alert(data.respon.text_msg);
          tampil('1');
          
        }else if(data.respon.pesan=="gagal")
        {
          alert(data.respon.text_msg);
          tampil('1');
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> hapus_catatan()');
      }//end error
    });
  }
  })

  function ambil_flowmeter()
  {
  $.ajax({
    type: 'POST',
    url: refseeAPI,
    dataType: 'json',
    data:'aplikasi=<?php echo $d0;?>&ref=ambil_daftar_flowmeter',
    success: function(data) {
      //console.log("List");
      if (data.respon.pesan == "sukses") 
      {
        for (i = 0; i < data.result.length; i++) {
          $("select#KPE_AIR_FLOWMETER_ID").append("<option value='" + data.result[i].KPE_AIR_FLOWMETER_ID + "'>" + data.result[i].KPE_AIR_FLOWMETER_NAMA + "</option>");
        }
      }else
      {}
    }
  })
  }

  // --------------------Format Tanggal-------------------- //
  function format_tanggal(fulld)
  {
    var sdate = fulld;
    var dt = new Date(sdate);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var tanggal = dt.getDate() + "-" + months[dt.getMonth()] + "-" + dt.getFullYear().toString().substr(-2);
    return tanggal;
  }

  function format_tahun(fully)
  {
    var sdate = fully;
    var dt = new Date(sdate);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var tanggal = months[dt.getMonth()] + "-" + dt.getFullYear().toString().substr(-2);
    return tanggal;
  }

  const GetDays = (Mention_today=false)=>{
  //Mention today mean the array will have today date 
  var DateArray = [];
  var days=6;
  for(var i=0;i<=days;i++){
  if(!Mention_today && i==0){i=1;days+=1}
  var date = new Date($('input#DATA_sDATE').val());
  var last = new Date(date.getTime() + ((i - 1) * 24 * 60 * 60 * 1000));
  var day =(last.getDate());
  var month=last.getMonth()+1;
  var year=last.getFullYear();
  const fulld = (Number(year)+'-'+Number(month)+'-'+Number(day)) // Format date as you like
  // console.log(fulld)
  DateArray.push(format_tanggal(fulld));
  }
  return DateArray;
  }

  const GetMonth = (Mention_today=false)=>{
  //Mention today mean the array will have today date 
  var DateArray = [];
  var days=30;
  for(var i=0;i<=days;i++){
  if(!Mention_today && i==0){i=1;days+=1}
  var date = new Date($('select#BULAN_FILTER').val());
  var year = new Date($('select#TAHUN_FILTER2').val());
  var last = new Date(date.getTime() + ((i - 1) * 24 * 60 * 60 * 1000));
  var day =(last.getDate());
  var month=last.getMonth()+1;
  var year=year.getFullYear();
  const fulld = (Number(year)+'-'+Number(month)+'-'+Number(day)) // Format date as you like
  // console.log(fulld)
  DateArray.push(format_tanggal(fulld));
  }
  return DateArray;
  }

  const GetYear = (Mention_today=false)=>{
  //Mention today mean the array will have today date 
  var DateArray = [];
  var days=11;
  for(var i=0;i<=days;i++){
  if(!Mention_today && i==0){i=1;days+=1}
  var date = new Date($('select#TAHUN_FILTER').val());
  var last = new Date(date.getMonth() + ((i - 1) * 24 * 31 * 60 * 60 * 1000));
  var month=last.getMonth()+1;
  var year=date.getFullYear();
  const fully = (Number(year)+'-'+Number(month)) // Format date as you like
  // console.log(fulld)
  DateArray.push(format_tahun(fully));
  }
  return DateArray;
  }
  // ------------------End Format Tanggal ------------------//

  $('#btn-reload').click(function(){
    var JENIS_LAPORAN = $('select#JENIS_LAPORAN').val();
    $('tr#colTgl').empty();
    if (JENIS_LAPORAN == "Harian") 
    {
      $('th#tglCatatan').attr("colspan",1);
      $('tr#colTgl').append("<th>"+format_tanggal($('input#DATA_sDATE').val())+"</th>")
    } else if (JENIS_LAPORAN == "Mingguan")
    {	
      $('th#tglCatatan').attr("colspan",7);
      for (var j = 0; j < GetDays().length; j++) 
      {
        // console.log(GetDays()[j])
        $('tr#colTgl').append("<th>"+GetDays()[j]+"</th>")
      }
    } else if (JENIS_LAPORAN == "Bulanan")
    {	
    //   var month = new Date($('select#BULAN_FILTER').val());
    //   alert(month);
      $('th#tglCatatan').attr("colspan",31);
      for (var j = 0; j < GetMonth().length; j++) 
      {
        // console.log(GetMonth()[j])
        $('tr#colTgl').append("<th>"+GetMonth()[j]+"</th>")
      }
    
    }else if (JENIS_LAPORAN == "Tahunan")
    {
      $('th#tglCatatan').attr("colspan",12);
      for (var j = 0; j < GetYear().length; j++) 
      {
        $('tr#colTgl').append("<th>"+GetYear()[j]+"</th>")
      }
    } else {

    }
    tampil('1');
    })

  function search() {
    tampil('1');
  }

  $(function() {
    ambil_flowmeter();
    tampil('1');
    $('tr#colTgl').append("<th>"+format_tanggal($('input#DATA_sDATE').val())+"</th>")
  });


  $('#cetakPdf').on('click', function(){
  //tampil();
  var JENIS_LAPORAN=$('select#JENIS_LAPORAN').val(); 
  if (JENIS_LAPORAN == "Harian") {
    var se = new Date($('input#DATA_sDATE').val());
  } else {
    var se = new Date($('input#DATA_eDATE').val());
  }
  var sd = new Date($('input#DATA_sDATE').val());
  var DATA_sDATE = sd.getFullYear() + "-" + (sd.getMonth()+1) + "-" + sd.getDate();
  var DATA_eDATE = se.getFullYear() + "-" + (se.getMonth()+1) + "-" + se.getDate();
  var BULAN_FILTER = $("#BULAN_FILTER").val();
  var TAHUN_FILTER2 = $("#TAHUN_FILTER2").val();
  var TAHUN_FILTER = $("#TAHUN_FILTER").val();
  window.open('?show=kpe/pdf/cetak_pemakaian_air/'+DATA_sDATE+'/'+DATA_eDATE+'/'+BULAN_FILTER+'/'+TAHUN_FILTER2+'/'+TAHUN_FILTER+'', '_blank');
  })

</script>
