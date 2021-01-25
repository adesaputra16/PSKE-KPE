<!-- Card -->
<div class="col-12">
  <div class="box box-primary box-outline-tabs">
    <div class="box-header">
        <h3 class="box-title">
          <i class="fa fa-pencil-square-o"></i>
          Laporan Pemakaian Energi
        </h3>
      </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="tanggalMulai">Dari :</label>
            <input type="date" class="form-control datepicker" name="tanggalMulai" id="tanggalMulai">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="tanggalAkhir">Sampai :</label>
            <input type="date" class="form-control" name="tanggalAkhir" id="tanggalAkhir">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="energi">Energi :</label>
            <select id="energi" class="form-control">
              <option value="">--Pilih--</option>
              <option value=""> ...</option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <label for="dariDepartement">Department Tujuan</label>
          <div class="input-group custom-search-form">
            <select class="form-control" name="dariDepartement" id="dariDepartement">
              <option value="0">--Pilih--</option>
            </select>
            <span class="input-group-btn">
              <button class="btn btn-primary btn-view" type="submit" id="btn-reload">
                <strong><i class="fa fa-refresh"></i> Refresh</strong>
              </button>
            </span>
        </div>
      </div>
      <div class="row">
				<div class="col-md-12">
          <!-- <table class="table table-hover">
            <thead>
                <tr>
                  <th>No.</th>
                  <th>Jumlah Air</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="zone_data">

            </tbody>
          </table> -->
        </div>
			</div>
    </div>
  </div>
</div>
<!-- End Card -->

<script>
  $('#tanggalMulai').datepicker({
      autoclose: true
    });
</script>