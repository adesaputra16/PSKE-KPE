
<?php 
  $input_option=array();
  $params=array(
    'case'=>"nonlogin_ambil_daftar_flowmeter",
    'batas'=>10,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option,
  );
  $respon_flow = $KPE->kpe_modules($params)->load->module;

  $input_option_dept=array(
    'KPE_AIR_FLOWMETER_ID' => 'kosong'
  );
  $params_dept=array(
    'case'=>"nonlogin_list_flowmeter_departemen",
    'batas'=>10,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option,
  );
  $respon_dept = $KPE->kpe_modules($params_dept)->load->module;

  $input_option_kal=array(
    'KPE_AIR_FLOWMETER_ID' => '0'
  );
  $params_kal=array(
    'case'=>"nonlogin_list_angka_flowmeter_kalibrasi",
    'batas'=>10,
    'halaman'=>1,
    'data_http'=>$_COOKIE['data_http'],
    'input_option'=>$input_option_kal,
  );
  $respon_kal = $KPE->kpe_modules($params_kal)->load->module;
  // echo "<pre>".print_r($respon_kal['result'],true)."</pre>";
?>
<div class="callout callout-danger">
  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
  <div class="row">
    <div class="col-md-12">
      <h5><b><i class="icon fa fa-ban"></i> Form input ini tidak bisa menginput :</b></h5>
      <div class="col-md-6">
        <b>Flowmeter yang digunakan beberapa departemen :</b>
        <ul>
          <?php 
            foreach ($respon_dept['result'] as $rd) {
              echo "<li>$rd[KPE_AIR_FLOWMETER_NAMA]</li>";
            }
          ?>
        </ul>
      </div>
      <div class="col-md-6">
        <b>Flowmeter yang dikalibrasi :</b>
        <ul>
          <?php 
            foreach ($respon_kal['result'] as $rk) {
              echo "<li>$rk[KPE_AIR_FLOWMETER_NAMA]</li>";
            }
          ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="box">
  <div class="box-header">
    <div class="box-title"></div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form action="javascript:simpanMultiple();" id="fData" class="fData">
          <input type="hidden" name="TOTAL_LOOP" id="TOTAL_LOOP" value="<?= @$_POST['JUMLAH']; ?>">
          <table class="table table-hover table-striped table-borderless">
            <thead>
              <tr>
                <th>#</th>
                <th>Flow</th>
                <th>Catatan</th>
                <th>Beban</th>
                <th>Catatan Sebelumnya</th>
                <th>Beban Sebelumnya</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
            <?php
            for ($i = 1; $i <= $_POST['JUMLAH']; $i++) { ?>
              <tr>
                <th><?= $i; ?></th>
                <td>
                <input type="hidden" name="KPE_AIR_FLOWMETER_NAMA[]" id="KPE_AIR_FLOWMETER_NAMA-<?= $i; ?>" class="form-control">
                  <select name="KPE_AIR_FLOWMETER_ID[]" id="KPE_AIR_FLOWMETER_ID-<?= $i; ?>" class="form-control selectpicker" data-live-search="true" onchange="listCatatan('<?= $i; ?>');" required width="100%">
                    <option value="">--Pilih--</option>
                    <?php 
                      foreach ($respon_flow['result'] as $rf) {
                        echo "<option value='$rf[KPE_AIR_FLOWMETER_ID]'>$rf[KPE_AIR_FLOWMETER_NAMA]</option>"; 
                      }
                    ?>
                  </select>
                </td>
                <td>
                  <input type="number" name="KPE_AIR_FLOWMETER_CATATAN_ANGKA[]" id="KPE_AIR_FLOWMETER_CATATAN_ANGKA-<?= $i; ?>" class="form-control" required autocomplete='off' step='any'>
                </td>
                <td>
                  <input type="text" name="KPE_AIR_FLOWMETER_CATATAN_BEBAN[]" id="KPE_AIR_FLOWMETER_CATATAN_BEBAN-<?= $i; ?>" class="form-control" required readonly>
                </td>
                <td>
                  <input type="text" name="KPE_AIR_FLOWMETER_CATATAN_ANGKA_SEBELUMNYA[]" id="KPE_AIR_FLOWMETER_CATATAN_ANGKA_SEBELUMNYA-<?= $i; ?>" class="form-control" required readonly>
                </td>
                <td>
                  <input type="text" name="KPE_AIR_FLOWMETER_CATATAN_BEBAN_SEBELUMNYA[]" id="KPE_AIR_FLOWMETER_CATATAN_BEBAN_SEBELUMNYA-<?= $i; ?>" class="form-control" required readonly>
                </td>
                <td>
                  <input type="text" name="KPE_AIR_FLOWMETER_CATATAN_TANGGAL[]" id="KPE_AIR_FLOWMETER_CATATAN_TANGGAL-<?= $i; ?>" class="form-control" value="<?= $_POST['TANGGAL']; ?>" required readonly>
                </td>
              </tr>
            <?php
            }
            ?>
            </tbody>
          </table>
          <div class="form-group pull-right">
            <button type="submit" name="add" class="btn btn-success" id="btnSimpanCatatan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

  /*===== Function list catatan hari sebelumnya dan Flowmeter yg dikalibrasi =====*/
  function listCatatan(id) {

    let KPE_AIR_FLOWMETER_ID = $('#KPE_AIR_FLOWMETER_ID-'+id+'').val();
    let KPE_AIR_FLOWMETER_NAMA = $('#KPE_AIR_FLOWMETER_NAMA-'+id+'').val($('#KPE_AIR_FLOWMETER_ID-'+id+'').children("option:selected").text());
    let KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = $("#KPE_AIR_FLOWMETER_DEPARTEMEN_ID").children("option:selected").text();
    let date = new Date($('#KPE_AIR_FLOWMETER_CATATAN_TANGGAL-'+id+'').val());
    let dates = $("#KPE_AIR_FLOWMETER_CATATAN_TANGGAL").val();
    date = new Date((new Date(date)).valueOf() - 1000*60*60*24);
    let KPE_AIR_FLOWMETER_CATATAN_TANGGAL = date.getFullYear() + '/' + satuNolDiDepan(date.getMonth()+1) + '/' + satuNolDiDepan(date.getDate());
    // console.log(KPE_AIR_FLOWMETER_CATATAN_TANGGAL);
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data:'aplikasi=<?php echo $d0;?>&ref=list_catatan_sebelumnya&KPE_AIR_FLOWMETER_ID='+KPE_AIR_FLOWMETER_ID+'&KPE_AIR_FLOWMETER_CATATAN_TANGGAL='+KPE_AIR_FLOWMETER_CATATAN_TANGGAL+'&KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA='+KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA+'&KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE='+dates,
      success: function(data) {
        // console.log(data.result);
        // console.log(data.tes);
        if (data.respon.pesan == "sukses" && data.result[0].CATATAN != null) 
        {
          for (var i = 0; i < data.result.length; i++) {
            if (data.result[i].CATATAN == null) {
              $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA-'+id+'').removeAttr("onkeyup");
              $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA_SEBELUMNYA-'+id+'').val(""); 
            } else {
              $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA-'+id+'').attr('onkeyup','cekAngkaCatatan('+id+');'); 
              $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA_SEBELUMNYA-'+id+'').val(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_ANGKA);
              $('#KPE_AIR_FLOWMETER_CATATAN_BEBAN_SEBELUMNYA-'+id+'').val(formatNumber(data.result[i].CATATAN.KPE_AIR_FLOWMETER_CATATAN_BEBAN));
              
            }
          }
          
        } else
        {
          let month = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
          let dateKosong = new Date(data.result[0].CATATAN_TERAKHIR.KPE_AIR_FLOWMETER_CATATAN_TANGGAL);
          dateKosong = new Date((new Date(dateKosong)).valueOf() + 1000*60*60*24);
          let KPE_AIR_FLOWMETER_CATATAN_TANGGAL_KOSONG = satuNolDiDepan(dateKosong.getDate()) + " " + month[dateKosong.getMonth()] + " " + dateKosong.getFullYear();
          let KPE_AIR_FLOWMETER_CATATAN_TANGGAL_KOSONGS = dateKosong.getFullYear() + '/' + satuNolDiDepan(dateKosong.getMonth()+1) + '/' + satuNolDiDepan(dateKosong.getDate());   
          Swal.fire({
            title: ""+KPE_AIR_FLOWMETER_CATATAN_TANGGAL_KOSONG+"",
            text: "Catatan angka tanggal "+KPE_AIR_FLOWMETER_CATATAN_TANGGAL_KOSONGS+" belum terisi!",
            icon: 'error',
          })
          $(".selectpicker").selectpicker("val","");
          $('#KPE_AIR_FLOWMETER_NAMA-'+id+'').val('');
        }
      }
    })
  }
  /*===== End list catatan sebelumnya =====*/

  /*===== Cek catatan yg diinput lebih besar atau lebih kecil dari angka sebelumnya =====*/
  function cekAngkaCatatan(id) {
    let bebanSekarang = (parseFloat($('#KPE_AIR_FLOWMETER_CATATAN_ANGKA-'+id+'').val()) - parseFloat($('#KPE_AIR_FLOWMETER_CATATAN_ANGKA_SEBELUMNYA-'+id+'').val())).toFixed(2);
    // console.log(typeof bebanSekarang);
    if (parseFloat(bebanSekarang) >= 0 ) {
	    $('#KPE_AIR_FLOWMETER_CATATAN_BEBAN-'+id+'').val(bebanSekarang);
      $('#KPE_AIR_FLOWMETER_CATATAN_BEBAN-'+id+'').attr("style","border-color:#3c763d; color:#3c763d;");
      $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA-'+id+'').attr("style","border-color:#3c763d; color:#3c763d;");
    } else {
      $('#KPE_AIR_FLOWMETER_CATATAN_BEBAN-'+id+'').val(bebanSekarang);
      $('#KPE_AIR_FLOWMETER_CATATAN_BEBAN-'+id+'').attr("style","border-color:#a94442; color:#a94442;");
      $('#KPE_AIR_FLOWMETER_CATATAN_ANGKA-'+id+'').attr("style","border-color:#a94442; color:#a94442;");
    }
  }
  /*===== End cek catatan =====*/

  /*===== Function untuk menyimpan Catatan Keliling =====*/
  function simpanMultiple()
  {
    $("#btnSimpanCatatan").attr("disabled","disabled");
    let fData=$("#fData").serialize();
    // console.log(fData);
    // return
    $.ajax({
      type:'POST',
      url:refseeAPI,
      dataType:'json',
      //data:'ref=simpan_catatan&'+data,
      data:'aplikasi=<?php echo $d0;?>&ref=simpan_catatan_multiple&'+fData,
      success:function(data)
      { 
        
        if(data.respon.pesan=="sukses")
        {
          $("#modalCatatan").modal('hide');
          // alert(data.respon.text_msg);
          // console.log(data.respon.text_msg);
          Swal.fire({
            timer:2000,
            progressBar:true,
            title: 'Berhasil!',
            text: ''+data.respon.text_msg+'',
            icon: 'success'
          })
          $(".selectpicker").selectpicker("val","");
          $("#btnSimpanCatatan").removeAttr("disabled");
          let movePage = setTimeout(() => {
            window.location.href = '?show=kpe/air/catatan/air'
          }, 2000);
          
        }else if(data.respon.pesan=="gagal")
        {
          Swal.fire({
            title: 'Gagal!',
            text: ''+data.respon.text_msg+'',
            icon: 'error'
          })
          $("#btnSimpanCatatan").removeAttr("disabled");
        }
      },
      error:function(x,e){
        error_handler_json(x,e,'=> simpan_catatan()');
      }//end error
    });
  }
  /*===== End function simpan Catatan =====*/

</script>