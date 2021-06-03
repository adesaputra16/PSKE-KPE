<?php

$input_option = array();
$params = array(
  //'case'=>"presensi_lembur_spl_pdf_nonlogin",
  'case' => "nonlogin_list_kwh_flowmeter",
  'batas' => 100,
  'halaman' => 1,
  'data_http' => $_COOKIE['data_http'],
  'input_option' => $input_option,
);
$respon_flow = $KPE->kpe_kwh($params)->load->module;
// echo "<pre>" . print_r($respon_flow['result'], true) . "</pre>";

?>

<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="list-group">
      <div class="list-group-item">
        <div class="row">
          <div class="col-md-12">
            <h3><i class="fa fa-calculator"></i> Form Formula</h3>
            <hr>
            <form class="fData" id="fData" name="fData">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="KPE_KWH_FLOWMETER_ID">Flowmeter</label>
                    <select id="KPE_KWH_FLOWMETER_ID" name="KPE_KWH_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
                      <option value="">--Pilih--</option>
                      <?php
                      foreach ($respon_flow['result'] as $rf) {
                        echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="KPE_KWH_RUMUS_OPERATOR">Operator</label>
                    <select id="KPE_KWH_RUMUS_OPERATOR0" name="KPE_KWH_RUMUS_OPERATOR[]" class="form-control selectpicker" onchange="cekOperator(0)" required>
                      <option value="">--Pilih--</option>
                      <option value="+">Tambah [ + ]</option>
                      <option value="-">Kurang [ - ]</option>
                      <option value="*">Kali [ * ]</option>
                      <option value="/">Bagi [ / ]</option>
                      <option value="(">Kurung buka [ ( ]</option>
                      <option value=")">Kurung tutup [ ) ]</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3" id="KPE_KWH_RUMUS_TYPE0">
                  <div class="form-group">
                    <label for="KPE_KWH_RUMUS_TYPE">Type</label>
                    <select id="KPE_KWH_RUMUS_TYPE0" name="KPE_KWH_RUMUS_TYPE[]" class="form-control selectpicker" onchange="typeRumus(0)" required>
                      <option value="">--Pilih--</option>
                      <option value="CUSTOM">CUSTOM</option>
                      <option value="FIELD">FIELD</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-7 form-group" id="KPE_KWH_RUMUS_VALUE0" style="display: none;">
                  <label for="KPE_KWH_RUMUS_VALUE">Angka</label>
                  <div class="input-group custom-search-form">
                    <input type="text" name="KPE_KWH_RUMUS_VALUE[]" id="KPE_KWH_RUMUS_VALUE" class="form-control" placeholder="Masukkan Angka..">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger" id="removeRow"><strong><i class="fa fa-trash"></i> Hapus</strong></button>
                    </span>
                  </div>
                </div>
                <div class="col-md-3" id="KPE_KWH_FLOWMETER_ID_TARGET0">
                  <div class="form-group">
                    <label for="KPE_KWH_FLOWMETER_ID_TARGET">Flowmeter</label>
                    <select id="KPE_KWH_FLOWMETER_ID_TARGET" name="KPE_KWH_FLOWMETER_ID_TARGET[]" class="form-control selectpicker" data-live-search="true">
                      <option value="">--Pilih--</option>
                      <?php
                      foreach ($respon_flow['result'] as $rf) {
                        echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 form-group" id="KPE_KWH_RUMUS_FIELD0">
                  <label for="KPE_KWH_RUMUS_FIELD">Field</label>
                  <div class="input-group custom-search-form">
                    <select id="KPE_KWH_RUMUS_FIELD" name="KPE_KWH_RUMUS_FIELD[]" class="form-control selectpicker" data-live-search="true">
                      <option value="">--Pilih--</option>
                      <option value="PUTARAN">PUTARAN</option>
                      <option value="KWH">KWH</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger" id="removeRow"><strong><i class="fa fa-trash"></i> Hapus</strong></button>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group input_fields_wrap">
                <div id="newRow"></div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="pull-left">
                    <button type="button" class="tambahForm btn btn-primary" name="tambahForm" id="tambahForm" data-placement="top" title="Add">
                      <span class="fa fa-plus"></span> Tambah Form
                    </button>
                    <button class="btn btn-success" id="btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                    <button id="cancelFormula" type="button" class="btn btn-danger"><span class="fa fa-undo"></span> Cancel</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="list-group">
  <div class="list-group-item">
    <form action="javascript:simpanDepartemen();" class="fData" id="fData" name="fData">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
            <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
              <option value="">--Pilih--</option>
              <?php
              foreach ($respon_flow['result'] as $rf) {
                echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="KPE_AIR_FLOWMETER_ID">Operator</label>
            <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" required>
              <option value="">--Pilih--</option>
              <option value="+">+</option>
              <option value="-">-</option>
              <option value="*">*</option>
              <option value="/">/</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="KPE_AIR_FLOWMETER_ID">Type</label>
            <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" required>
              <option value="">--Pilih--</option>
              <option value="CUSTOM">CUSTOM</option>
              <option value="FIELD">FIELD</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="KPE_AIR_FLOWMETER_ID">Flowmeter</label>
            <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
              <option value="">--Pilih--</option>
              <?php
              foreach ($respon_flow['result'] as $rf) {
                echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>";
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group input_fields_wrap">
          <div id="newRow"></div>
        </div>
        <div class="col-md-4 form-group">
          <label for="KPE_AIR_FLOWMETER_ID">Field</label>
          <div class="input-group custom-search-form">
            <select id="KPE_AIR_FLOWMETER_ID" name="KPE_AIR_FLOWMETER_ID" class="form-control selectpicker" data-live-search="true" required>
              <option value="">--Pilih--</option>
              <option value="PUTARAN">PUTARAN</option>
              <option value="KWH">KWH</option>
            </select>
            <span class="input-group-btn">
              <button type="button" class="btn btn-danger" id="removeRow"><strong><i class="fa fa-trash"></i> Hapus</strong></button>
            </span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="pull-left">
            <button type="button" class="addFlowDept btn btn-primary" name="addFlowDept" id="addFlowDept" data-placement="top" title="Add">
              <span class="fa fa-plus"></span> Tambah Form
            </button>
            <button id="resetDept" type="button" class="btn btn-danger"><span class="fa fa-undo"></span> Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div> -->

<script>
  function typeRumus(num) {
    const TYPE = $('#KPE_KWH_RUMUS_TYPE' + num).val()
    if (TYPE == "CUSTOM") {
      $('div#KPE_KWH_FLOWMETER_ID_TARGET' + num).attr('style', 'display:none;')
      $('div#KPE_KWH_RUMUS_FIELD' + num).attr('style', 'display:none;')
      $('div#KPE_KWH_RUMUS_VALUE' + num).removeAttr('style')
    } else {
      $('div#KPE_KWH_FLOWMETER_ID_TARGET' + num).removeAttr('style')
      $('div#KPE_KWH_RUMUS_FIELD' + num).removeAttr('style')
      $('div#KPE_KWH_RUMUS_VALUE' + num).attr('style', 'display:none;')
    }
  }

  function cekOperator(num) {
    const OPERATOR = $('#KPE_KWH_RUMUS_OPERATOR' + num).val()
    if (OPERATOR == "(" || OPERATOR == ")") {
      $('div#KPE_KWH_FLOWMETER_ID_TARGET' + num).attr('style', 'display:none;')
      $('div#KPE_KWH_RUMUS_FIELD' + num).attr('style', 'display:none;')
      $('div#KPE_KWH_RUMUS_VALUE' + num).attr('style', 'display:none;')
      $('div#KPE_KWH_RUMUS_TYPE' + num).attr('style', 'display:none;')
    } else {
      $('div#KPE_KWH_FLOWMETER_ID_TARGET' + num).removeAttr('style')
      $('div#KPE_KWH_RUMUS_FIELD' + num).removeAttr('style')
      $('div#KPE_KWH_RUMUS_TYPE' + num).removeAttr('style')
      $('div#KPE_KWH_RUMUS_VALUE' + num).attr('style', 'display:none;')
    }
  }

  let counter = 1
  $('#tambahForm').on('click', () => {
    $('#newRow').append( /*html*/ `<div class="row" id="inputFormRow">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="KPE_KWH_RUMUS_OPERATOR">Operator</label>
                        <select id="KPE_KWH_RUMUS_OPERATOR${counter}" name="KPE_KWH_RUMUS_OPERATOR[]" class="form-control selectpicker" onchange="cekOperator(${counter})" required>
                          <option value="">--Pilih--</option>
                          <option value="+">Tambah [ + ]</option>
                          <option value="-">Kurang [ - ]</option>
                          <option value="*">Kali [ * ]</option>
                          <option value="/">Bagi [ / ]</option>
                          <option value="(">Kurung buka [ ( ]</option>
                          <option value=")">Kurung tutup [ ) ]</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3" id="KPE_KWH_RUMUS_TYPE${counter}">
                      <div class="form-group">
                        <label for="KPE_KWH_RUMUS_TYPE">Type</label>
                        <select id="KPE_KWH_RUMUS_TYPE${counter}" name="KPE_KWH_RUMUS_TYPE[]" class="form-control selectpicker" onchange="typeRumus(${counter})" required>
                          <option value="">--Pilih--</option>
                          <option value="CUSTOM">CUSTOM</option>
                          <option value="FIELD">FIELD</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-7 form-group" id="KPE_KWH_RUMUS_VALUE${counter}" style="display: none;">
                  <label for="KPE_KWH_RUMUS_VALUE">Angka</label>
                  <div class="input-group custom-search-form">
                    <input type="text" name="KPE_KWH_RUMUS_VALUE[]" id="KPE_KWH_RUMUS_VALUE" class="form-control" placeholder="Masukkan Angka..">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-danger" id="removeRow"><strong><i class="fa fa-trash"></i> Hapus</strong></button>
                    </span>
                  </div>
                </div>
                    <div class="col-md-3" id="KPE_KWH_FLOWMETER_ID_TARGET${counter}">
                      <div class="form-group">
                        <label for="KPE_KWH_FLOWMETER_ID_TARGET">Flowmeter</label>
                        <select id="KPE_KWH_FLOWMETER_ID_TARGET" name="KPE_KWH_FLOWMETER_ID_TARGET[]" class="form-control selectpicker" data-live-search="true" required>
                          <option value="">--Pilih--</option>
                          <?php
                          foreach ($respon_flow['result'] as $rf) {
                            echo "<option value='$rf[KPE_KWH_FLOWMETER_ID]'>$rf[KPE_KWH_FLOWMETER_NAMA]</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 form-group" id="KPE_KWH_RUMUS_FIELD${counter}">
                      <label for="KPE_KWH_RUMUS_FIELD">Field</label>
                      <div class="input-group custom-search-form">
                        <select id="KPE_KWH_RUMUS_FIELD" name="KPE_KWH_RUMUS_FIELD[]" class="form-control selectpicker" data-live-search="true" required>
                          <option value="">--Pilih--</option>
                          <option value="PUTARAN">PUTARAN</option>
                          <option value="KWH">KWH</option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-danger" id="removeRow"><strong><i class="fa fa-trash"></i> Hapus</strong></button>
                        </span>
                      </div>
                    </div>
                  </div>`)

    counter++
  })

  $(document).on('click', 'button#removeRow', function() {
    $(this).closest('#inputFormRow').remove()
  })

  $('#btn-simpan').on('click', function() {
    let counts = []
    let elements = $('select#KPE_KWH_RUMUS_OPERATOR').length
    $("form#fData").find('select#KPE_KWH_RUMUS_OPERATOR').each(function() {
      if (this.value != "") {
        counts.push(this.value)
      }
    })
    if (elements !== counts.length) {
      toastNotifikasi("error", "Oprator harus di isi semua")
    } else {
      simpanRumus(elements)
      // toastNotifikasi("success", "Berhasil")
    }
  })

  $('#cancelFormula').on('click', function() {
    $("form#fData")[0].reset()
    $(".selectpicker").selectpicker("val", "")
    $("form#fData").find('div#inputFormRow').each(function() {
      this.remove()
    })
  })

  const simpanRumus = (elements) => {
    const fData = $("#fData").serialize()
    $.ajax({
      type: 'POST',
      url: refseeAPI,
      dataType: 'json',
      data: 'aplikasi=<?php echo $d0; ?>&ref=simpan_rumus_kwh&COUNT=' + elements + '&' + fData,
      success: function(data) {
        if (data.respon.pesan == "sukses") {
          Swal.fire({
            timer: 1200,
            timerProgressBar: true,
            title: 'Berhasil!',
            text: '' + data.respon.text_msg + '',
            icon: 'success',
          })
          console.log(data.result);

        } else if (data.respon.pesan == "gagal") {
          Swal.fire({
            title: 'Gagal',
            text: '' + data.respon.text_msg + '',
            icon: 'error'
          })
        }
      },
      error: function(x, e) {
        // error_handler_json(x,e,'=> hapus_catatan()');
        console.log('error')
      } //end error
    })

  }
</script>