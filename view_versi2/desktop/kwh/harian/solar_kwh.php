<div class="box box-solid form_faktur">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-2 form-group">
            <label for="JENIS_LAPORAN">Jenis Akumulasi</label>
            <select class="form-control col-sm-2" name="JENIS_LAPORAN" id="JENIS_LAPORAN" onchange="jenisAkumulasi()" required>
              <!--<option value="0">--Pilih--</option>-->
              <option value="Harian" selected>Harian</option>
              <option value="Mingguan">Mingguan</option>
              <option value="Bulanan">Bulanan</option>
              <!-- <option value="Tahunan">Tahunan</option> -->
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
          <!-- <div class="col-md-4">
            <div class="form-group">
              <label for="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE">Distribusi Type :</label>
              <select id="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" name="KPE_AIR_FLOWMETER_DISTRIBUSI_TYPE" class="form-control" onchange="listKWh();">
                <option value="">--Pilih--</option>
                <option value="PRE">PRE</option>
                <option value="RO">RO</option>
                <option value="REJECT">REJECT</option>
              </select>
            </div>
          </div> -->
          <div class="col-md-2">
            <label>&nbsp;</label>
            <div class="input-group custom-search-form">
              <button type="button" class="btn btn-primary" id="btn-reload"><strong><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</strong></button>
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
      <div class="table-responsive Content animasi-table" idi="divTable">
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

<script>
  $(function() {
    tglHarianSolar()
  })

  function tglHarianSolar() {
    $("th#tglHarianSolar").after(/*html*/`<th>29-Mar-21</th><th>30-Mar-21</th>`)
  }
</script>