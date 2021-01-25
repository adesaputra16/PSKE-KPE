<style>

.modal-dialogs {
  width: 100% !important;
  height: 100% !important;
  margin: 0 !important;
  padding: 0 !important;
}

.modal-contents {
  height: auto !important;
  min-height: 100% !important;
  border-radius: 0 !important;
}

.imgPetunjuk{
	max-width: 100% !important;
  height: auto !important;
	padding-right:40px;
}

.text-left {
  text-align: left !important;
}

/* .collapse:not(.show) {
  display: none;
} */

</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="list-group">
			<div class="list-group-item">
				<div class="row">
					<div class="col-md-8">
						<h3><i class="fa fa-tachometer"></i> Dashboard</h3>
					</div>
					<div class="col-md-4 text-right">
						<div class="text-right">
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#petunjukPengisian"><strong><i class="fa fa-info" aria-hidden="true"></i> User Manual Penggunaan Aplikasi KPE</strong></button>
						</div>
					</div>
				</div><!--/.row-->
				<div>
						<hr>
					<p>Aplikasi Konservasi Pemakaian Energi adalah aplikasi yang menangani keseluruhan pemakaian energi seperti kWH, Solar, Batubara dan lain-lain.</p>
					
				</div>   
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="petunjukPengisian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:100000;">
  <div class="modal-dialog modal-lg modal-dialogs">
    <div class="modal-content modal-contents">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
        <h4 class="modal-title" id="gridSystemModalLabel"><strong><i class="fa fa-info-circle"></i> User Manual Penggunaan Aplikasi KPE </strong></h4><br><br>
      </div>
      <div class="modal-body">
      	<div class="row">
        	<div class="col-md-12">
			<p>Dalam aplikasi Konservasi Pemakaian Energi (KPE) ini terdapat beberapa fitur/menu. Untuk mengetahui cara penggunaan fitur/menu yang tersedia, silahkan Anda klik pada masing-masing item berikut ini:</p>
				<div class="box-body">
					<div class="box-group" id="accordion">
						<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
						<div class="panel box">
							<div class="box-header with-border">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										1. Flowmeter
									</a>
								</h4>
								<p>
									Menu flowmeter adalah halaman yang menampung isian/daftar flowmeter. Pada fitur ini, Anda dapat menambah daftar flowmeter, melakukan pengeditan/pengubahan flowmeter, serta melakukan penghapusan flowmeter.
								</p>
							</div>
							<div id="collapseOne" class="panel-collapse collapse">
								<div class="box-body">
									<p>
										<ol type='I'>
											<li>
												<p>Untuk dapat mengakses menu ini, silahkan Anda klik menu <b>Air</b> seperti yang ditandai <b>point 1</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_1.png"><br><br>
											</li>
											<li>
												<p>Selanjutnya silahkan Anda klik menu <b>Flowmeter</b> seperti yang ditandai <b>point 2</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_2.png"><br><br>
											</li>
											<li>
												<p>Setelah itu, Anda akan melihat tampilan seperti berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_3.png"><br><br>
											
												<ol type='1'>Dari gambar di atas dapat dijelaskan seperti berikut ini:
												<li>Terdapat dua tab yang ditandai pada <b>Point 1</b> yaitu tab Flowmeter dan tab Sub Flowmeter. Tab Flowmeter berisikan informasi/daftar flowmeter, sedangkan tab Sub Flowmeter berisikan informasi/daftar Sub Flowmeter.
												</li>
												<li>Terdapat tombol "Tambah Flowmeter" yang ditandai pada <b>point 2</b> yaitu tombol yang harus diklik ketika akan melakukan penginputan/penambahan flowmeter baru.
												</li>
												<li>Terdapat filter isian yang ditandai pada <b>point 3</b> yang dapat digunakan untuk melakukan memfilter/membatasi daftar flowmeter yang akan ditampilkan.
												</li>
												<li>Semua flowmeter yang sudah ditambahkan akan tampil pada daftar flowmeter seperti yang ditandai pada <b>point 4</b>
												</li>
											</ol>
											
											</li>
										</ol>

										<p class="text-info"><b>A. Petunjuk Pengisian Flowmeter</b></p>
										<p>Untuk melakukan pengisian/penambahan flowmeter, maka Anda dapat mengklik tombol "Tambah Flowmeter" seperti yg dijelaskan pada <b>langkah III.2</b> di atas.Selanjutnya akan tampil isian seperti berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_A_1.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Isikan Nama Flowmeter pada isian yang ditandai <b>poin 1</b>
												<li>Isikan pilihan Nama Sub Flowmeter pada isian yang ditandai <b>poin 2</b>
												<li>Isikan Nama Lokasi dimana Flowmeter tersebut berada/ditempatkan pada isian yang ditandai <b>poin 3</b>
												<li>Isikan jenis Distribusi dari Flowmeter tersebut pada isian yang ditandai <b>poin 4</b>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>5</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengisian flowmeter, klik tombol Tutup yang ditunjukkan pada poin <b>6</b> dan form isian flowmeter akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>B. Petunjuk Pengeditan/Pengubahan Flowmeter</b></p>
										<p>Untuk melakukan pengeditan/pengubahan flowmeter, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Flowmeter yang ada pada daftar flowmeter(seperti yg dijelaskan pada <b>langkah III.4</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_B.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Edit</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil form isian berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_B_1.png"><br><br>
												</li>
												<li>Lengkapi atau sesuaikan Isian Nama Flowmeter, Sub Flowmeter, Lokasi dan Distribusi pada isian yang ditandai <b>poin 3</b>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>5</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengeditan/pengubahan flowmeter, klik tombol Tutup yang ditunjukkan pada poin <b>6</b> dan form isian flowmeter akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>C. Petunjuk Penghapusan Flowmeter</b></p>
										<p>Untuk melakukan penghapusan flowmeter, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Flowmeter yang ada pada daftar flowmeter(seperti yg dijelaskan pada <b>langkah III.4</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_C.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Hapus</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil kotak dialog berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_C_1.png"><br><br>
												</li>
												<li>Jika sudah yakin akan menghapus, klik tombol "OK" yang ditandai <b>poin 3</b> untuk menghapus.
												<li>Jika ingin membatalkan penghapusan flowmeter, klik tombol "Cancel" yang ditunjukkan pada poin <b>4</b> dan kotak dialog akan tertutup.</li>
											</ol><br>
										</p>
									</p>
									
								</div>
							</div>
						</div>
						<div class="panel box">
							<div class="box-header with-border">
								<h4 class="box-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										2. Sub Flowmeter
									</a>
								</h4>
								<p>
									Sub Flowmeter merupakan tab menu yang terdapat pada menu Flowmeter (seperti pada langkah 1.III.1), adalah halaman  yang menampung isian/daftar Sub flowmeter. 
									Pada fitur ini, Anda dapat menambah daftar Sub flowmeter, melakukan pengeditan/pengubahan Sub flowmeter, serta melakukan penghapusan Sub flowmeter.
								</p>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse">
								<div class="box-body">
									<p>
										<ol type='I'>
											<li>
												<p>Untuk dapat mengakses tab menu ini, silahkan Anda klik tab menu <b>Sub Flowmeter</b> yang ada pada menu Flowmeter seperti yang ditandai <b>point 1</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_1.png"><br><br>
											</li>
											<li>
												<p>Setelah itu, Anda akan melihat tampilan seperti berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_2.png"><br><br>
											
												<ol type='1'>Dari gambar di atas dapat dijelaskan seperti berikut ini:
												<li>Terdapat tombol "Tambah Sub Flowmeter" yang ditandai pada <b>point 1</b> yaitu tombol yang harus diklik ketika akan melakukan penginputan/penambahan Sub flowmeter baru.
												</li>
												<li>Semua Sub flowmeter yang sudah ditambahkan akan tampil pada daftar sub flowmeter seperti yang ditandai pada <b>point 2</b>
												</li>
											</ol>
											
											</li>
										</ol>

										<p class="text-info"><b>A. Petunjuk Pengisian Sub Flowmeter</b></p>
										<p>Untuk melakukan pengisian/penambahan sub flowmeter, maka Anda dapat mengklik tombol "Tambah Sub Flowmeter" seperti yg dijelaskan pada <b>langkah II.1</b> di atas.Selanjutnya akan tampil isian seperti berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_A_1.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Isikan Nama Sub Flowmeter pada isian yang ditandai <b>poin 1</b>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>2</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengisian sub flowmeter, klik tombol Tutup yang ditunjukkan pada poin <b>3</b> dan form isian sub flowmeter akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>B. Petunjuk Pengeditan/Pengubahan Sub Flowmeter</b></p>
										<p>Untuk melakukan pengeditan/pengubahan sub flowmeter, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Sub Flowmeter yang ada pada daftar sub flowmeter(seperti yg dijelaskan pada <b>langkah II.2</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_B.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Edit</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil form isian berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_B_1.png"><br><br>
												</li>
												<li>Lengkapi atau sesuaikan Isian Nama Sub Flowmeter pada isian yang ditandai <b>poin 3</b>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>4</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengeditan/pengubahan sub flowmeter, klik tombol Tutup yang ditunjukkan pada poin <b>5</b> dan form isian sub flowmeter akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>C. Petunjuk Penghapusan Sub Flowmeter</b></p>
										<p>Untuk melakukan penghapusan sub flowmeter, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Sub Flowmeter yang ada pada daftar sub flowmeter(seperti yg dijelaskan pada <b>langkah II.2</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_C.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Hapus</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil kotak dialog berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah2_C_1.png"><br><br>
												</li>
												<li>Jika sudah yakin akan menghapus, klik tombol "OK" yang ditandai <b>poin 3</b> untuk menghapus.
												<li>Jika ingin membatalkan penghapusan sub flowmeter, klik tombol "Cancel" yang ditunjukkan pada poin <b>4</b> dan kotak dialog akan tertutup.</li>
											</ol><br>
										</p>
									</p>
									
								</div>
							</div>
						</div>
						<div class="panel box">
							<div class="box-header with-border">
								<h4 class="box-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
									3. Catatan Keliling
								</a>
								</h4>
								<p>
									Menu Catatan Keliling adalah halaman yang menampung isian/daftar catatan keliling. Pada fitur ini, Anda dapat menambah daftar catatan, melakukan pengeditan/pengubahan catatan, serta melakukan penghapusan catatan.
								</p>
							</div>
							<div id="collapseThree" class="panel-collapse collapse">
								<div class="box-body">
									<p>
										<ol type='I'>
											<li>
												<p>Untuk dapat mengakses menu ini, silahkan Anda klik menu <b>Air</b> seperti yang ditandai <b>point 1</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah1_1.png"><br><br>
											</li>
											<li>
												<p>Selanjutnya silahkan Anda klik menu <b>Catatan Keliling</b> seperti yang ditandai <b>point 2</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_2.png"><br><br>
											</li>
											<li>
												<p>Setelah itu, Anda akan melihat tampilan seperti berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_3.png"><br><br>
											
												<ol type='1'>Dari gambar di atas dapat dijelaskan seperti berikut ini:
												<li>Terdapat tiga tab yang ditandai pada <b>Point 1</b> yaitu tab Catatan Keliling, tab Beban Harian dan tab Per Dept. Tab Catatan Keliling berisikan informasi/daftar catatan,tab Beban Harian berisikan informasi/daftar pembebanan harian departement, sedangkan tab Per Dept berisikan informasi/daftar Pakai dan Beban berdasarkan flowmeter.
												</li>
												<li>Terdapat tombol "Tambah Catatan" yang ditandai pada <b>point 2</b> yaitu tombol yang harus diklik ketika akan melakukan penginputan/penambahan catatan baru.
												</li>
												<li>Terdapat filter isian yang ditandai pada <b>point 3</b> yang dapat digunakan untuk melakukan memfilter/membatasi daftar catatan yang akan ditampilkan berdasarkan harian,mingguan,bulanan atau tahunan.
												</li>
												<li>Semua catatan yang sudah ditambahkan akan tampil pada daftar catatan seperti yang ditandai pada <b>point 4</b>
												</li>
											</ol>
											
											</li>
										</ol>

										<p class="text-info"><b>A. Petunjuk Pengisian Catatan Keliling</b></p>
										<p>Untuk melakukan pengisian/penambahan catatan keliling, maka Anda dapat mengklik tombol "Tambah Catatan" seperti yg dijelaskan pada <b>langkah III.2</b> di atas.Selanjutnya akan tampil isian seperti berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_A_1.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Isikan pilihan Nama Flowmeter pada isian yang ditandai <b>poin 1</b>.</li>
												<li>Isikan catatan angka pada isian yang ditandai <b>poin 2</b>.</li>
												<li>Isikan tanggal catatan pada isian yang ditandai <b>poin 3</b>.</li>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>4</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengisian catatan, klik tombol Tutup yang ditunjukkan pada poin <b>5</b> dan form isian flowmeter akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>B. Petunjuk Pengeditan/Pengubahan Catatan Keliling</b></p>
										<p>Untuk melakukan pengeditan/pengubahan catatan keliling, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Catatan yang ada pada daftar catatan(seperti yg dijelaskan pada <b>langkah III.4</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_B.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Edit</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil form isian berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_B_1.png"><br><br>
												</li>
												<li>Lengkapi atau sesuaikan Isian Nama Flowmeter, Catatan Angka, dan Tanggal pada isian yang ditandai <b>poin 3</b>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada poin <b>4</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengeditan/pengubahan catatan, klik tombol Tutup yang ditunjukkan pada poin <b>5</b> dan form isian catatan akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>C. Petunjuk Penghapusan Catatan Keliling</b></p>
										<p>Untuk melakukan penghapusan catatan, maka Anda dapat mengklik menu "<b>Aksi</b>" pada salah satu Catatan yang ada pada daftar catatan(seperti yg dijelaskan pada <b>langkah III.4</b>) seperti gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_C.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Klik menu <b>Aksi</b> yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya klik menu <b>Hapus</b> yang ditandai pada <b>poin 2</b></li>
												<li>Berikutnya akan tampil kotak dialog berikut ini:</br>
													<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah3_C_1.png"><br><br>
												</li>
												<li>Jika sudah yakin akan menghapus, klik tombol "OK" yang ditandai <b>poin 3</b> untuk menghapus.
												<li>Jika ingin membatalkan penghapusan catatan, klik tombol "Cancel" yang ditunjukkan pada poin <b>4</b> dan kotak dialog akan tertutup.</li>
											</ol><br>
										</p>
									</p>
								</div>
							</div>
						</div>
						<div class="panel box">
							<div class="box-header with-border">
								<h4 class="box-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
									4. Beban Harian
								</a>
								</h4>
								<p>On Progress</p>
							</div>
							<div id="collapseFour" class="panel-collapse collapse">
								<div class="box-body">
														<p class="text-info"><b>On Progress</b></p>
								</div>
							</div>
						</div>
						<div class="panel box">
							<div class="box-header with-border">
								<h4 class="box-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
									5. Per Dept
								</a>
								</h4>
								<p>
									Per Dept merupakan tab menu yang terdapat pada menu Catatan Keliling (seperti pada langkah 3.III.1), adalah halaman  yang menampung isian/daftar Per Dept. 
									Pada fitur ini, Anda dapat menambah rumus pakai/beban Per Dept,dan melakukan pengeditan/pengubahan rumus pakai/beban Per Dept.
								</p>
							</div>
							<div id="collapseFive" class="panel-collapse collapse">
								<div class="box-body">
									<p>
										<ol type='I'>
											<li>
												<p>Untuk dapat mengakses tab menu ini, silahkan Anda klik tab menu <b>Per Dept</b> yang ada pada menu Catatan Keliling seperti yang ditandai <b>point 1</b> pada gambar berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah5_1.png"><br><br>
											</li>
											<li>
												<p>Setelah itu, Anda akan melihat tampilan seperti berikut ini:</p>
												<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah5_2.png"><br><br>
											
												<ol type='1'>Dari gambar di atas dapat dijelaskan seperti berikut ini:
												<li>Terdapat filter bulan yang ditandai pada <b>point 1</b> yang dapat digunakan untuk melakukan memfilter/membatasi berdasarkan bulan dan tahun.
												</li>
												<li>Jika <b>poin 1</b> sudah terisi selanjutnya klik <b>poin 2</b> untuk melihat berdasarkan filter yang di isikan.</b>
												</li>
												<li>Semua catatan keliling yang sudah di input akan tampil di menu ini dan sudah otomatis di buatkan rumus untuk menghitung Total, Pakai dan Beban seperti yang ditandai <b>poin 3</b>.
												</li>
											</ol>
											
											</li>
										</ol>

										<p class="text-info"><b>A. Petunjuk Pengisian Rumus Pakai/Beban</b></p>
										<p>Untuk melakukan pengisian/penambahan Rumus Pakai/Beban, maka Anda dapat mengklik tombol "<b>&oplus;</b>" di tanggal yang ingin anda isi seperti yg dijelaskan pada <b>langkah II.4</b> di atas.Selanjutnya akan tampil isian seperti berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah5_A_1.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Isikan pilihan Nama Flowmeter pada isian yang ditandai <b>poin 1</b>.</li>
												<li>Isikan rumus pakai(+/-) dan bisa di kosongkan jika tidak ada rumus yang ingin di input seperti yang ditandai <b>poin 2</b>.</li>
												<li>Isikan rumus Beban(+/-) dan bisa di kosongkan jika tidak ada rumus yang ingin di input seperti yang ditandai <b>poin 3</b>.</li>
												<li>Jika sudah yakin dengan isian yang sudah dibuat, klik tombol Simpan yang ditunjukkan pada <b>poin 4</b> untuk menyimpan isian yang sudah dibuat.</li>
												<li>Jika ingin membatalkan pengisian rumus, klik tombol Tutup yang ditunjukkan pada <b>poin 5</b> dan form isian rumus akan tertutup.</li>
											</ol><br>
										</p>

										<p class="text-info"><b>B. Petunjuk Pengeditan/Pengubahan Rumus Pakai/Beban</b></p>
										<p>Untuk melakukan pengeditan/pengubahan rumus, maka Anda dapat mengklik tombol "<b>&oplus;</b>" ditanggal yang ingin anda isi seperti yg dijelaskan pada <b>langkah II.4</b> di atas. Setelah itu anda bisa melakukan hal yang sama seperti langkah <b>A</b>. </p><br>

										<p class="text-info"><b>C. Petunjuk Penghapusan Rumus Pakai/Beban</b></p>
										<p>Untuk melakukan penghapusan sub flowmeter, maka Anda dapat mengklik tombol "<b>&oplus;</b>" ditanggal yang ingin anda isi seperti yg dijelaskan pada <b>langkah II.4</b> di atas. contohnya anda bisa lihat gambar berikut ini:<br>
											<img class="imgPetunjuk" src="aplikasi/kpe/asset/img/contoh_pengisian/langkah5_C_1.png"><br><br>
											<ol type='1'>Dari gambar di atas dapat dijelaskan sebagai berikut:
												<li>Isikan pilihan flowmeter yang ingin di hapus/kosongkan rumusnya seperti yang ditandai pada <b>poin 1</b></li>
												<li>Selanjutnya <b>poin 2</b> dan <b>poin 3</b> dikosongkan saja.</li>
												<li>Jika sudah yakin ingin mengkosongkan rumus, klik tombol Simpan yang ditunjukkan pada <b>poin 4</b>.</li>
												<li>Jika ingin membatalkan mengkosongkan rumus, klik tombol "Cancel" yang ditunjukkan pada <b>poin 5</b> dan form isian rumus akan tertutup.</li>
											</ol><br>
										</p>
									</p>
								</div>
							</div>
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
  </div>
</div>
