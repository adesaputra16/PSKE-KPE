<?php

if (empty($params['case']))
	{
	$result['respon']['pesan'] == "gagal";
	$result['respon']['pesan'] == "Module tidak dapat di muat";
	echo json_encode($result);
	exit();
	}


		$input = $params['input_option'];
		$bulan = Date("m");
		$tahun = Date("Y");
		$sql_fd = "SELECT KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID,KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA,KPE_AIR_FLOWMETER_DEPARTEMEN_PERIODE,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL,KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN,KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL FROM KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A'";

		$this->MYSQL = new MYSQL();
		$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
		$this->MYSQL->queri = $sql_fd;
		$result_fd = $this->MYSQL->data();

		/*===================== Cek Flowmeter ini di kalibrasi atau tidak ===================*/
		if ($input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'] == "") {// Jika filed Kalibrasi Persen kosong (Flowmeter tidak di kalibrasi)
			$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI = 'off';
			$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN = '';
		} else {// Flowmeter dikalibrasi
			$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI = 'on';
			$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN = $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'];
		}

		/*===================== Mencari hasil Pakai ===================*/
		if (base64_decode($input['KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA']) == "" || $input['KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA'] == "") { // Jika filed Departemen Nama kosong/Bukan flowmeter yg digunakan beberapa departemen (Pembulatan 2 angka dibelakang koma)
			$KPE_AIR_FLOWMETER_CATATAN_PAKAI = round($input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'] - $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN'],2);
			$KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA = "";
		}else {// Pembulatan 3 angka dibelakang koma
			$KPE_AIR_FLOWMETER_CATATAN_PAKAI = round($input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'] - $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA_HIDDEN'],3);
			$KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA =  base64_decode($input['KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA']);
		}

		/*===================== Mencari hasil Beban ===================*/
		if ($input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'] != "") {// Cek flowmeter di kalibrasi atau tidak
			if ($input['TOTAL_PERSONIL'] != "") {// Cek flowmeter yg di kalibrasi ini apakah flowmeter yg digunakan beberapa departemen ataua tidak (Pembulatan 3 angka dibelakang koma)
				$KPE_AIR_FLOWMETER_CATATAN_BEBAN = round($KPE_AIR_FLOWMETER_CATATAN_PAKAI-($KPE_AIR_FLOWMETER_CATATAN_PAKAI*$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN/100),3);		
			} else { //Bukan flowmeter yg digunakan beberapa departemen (Pembualatan 2 angka dibelakang koma)
				$KPE_AIR_FLOWMETER_CATATAN_BEBAN = round($KPE_AIR_FLOWMETER_CATATAN_PAKAI-($KPE_AIR_FLOWMETER_CATATAN_PAKAI*$KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN/100),2);
			}
		} else { //Flowmeter tidak di kalibrasi
			if ($input['KPE_AIR_FLOWMETER_ID'] == "20210109152131751632") {
				$sql_prd = "SELECT KPE_AIR_FLOWMETER_CATATAN_BEBAN FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='20210109152213278549' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."'";
				$this->MYSQL = new MYSQL();
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->queri = $sql_prd;
				$result_prd = $this->MYSQL->data()[0];
				$KPE_AIR_FLOWMETER_CATATAN_BEBAN = $KPE_AIR_FLOWMETER_CATATAN_PAKAI-$result_prd['KPE_AIR_FLOWMETER_CATATAN_BEBAN'];
				//! Flow CCH tidak menggunakan formula lagi 2021-02-25
				// } elseif ($input['KPE_AIR_FLOWMETER_ID'] == "20210109164532364198") {
				// 	$sql_cch = "SELECT KPE_AIR_FLOWMETER_CATATAN_BEBAN FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='20210109144530481281' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."'";
				// 	$this->MYSQL = new MYSQL();
				// 	$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				// 	$this->MYSQL->queri = $sql_cch;
				// 	$result_cch = $this->MYSQL->data()[0];
				// 	$KPE_AIR_FLOWMETER_CATATAN_BEBAN = $KPE_AIR_FLOWMETER_CATATAN_PAKAI-$result_cch['KPE_AIR_FLOWMETER_CATATAN_BEBAN'];
				//!End
				} elseif ($input['KPE_AIR_FLOWMETER_ID'] == "20210109152549278861") {
					$sql_rop_packing = "SELECT KPE_AIR_FLOWMETER_CATATAN_BEBAN FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='20210109165156619692' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."'";
					$this->MYSQL = new MYSQL();
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->queri = $sql_rop_packing;
					$result_rop_packing = $this->MYSQL->data()[0];
					$KPE_AIR_FLOWMETER_CATATAN_BEBAN = $result_rop_packing['KPE_AIR_FLOWMETER_CATATAN_BEBAN']*28/100;
			} else {
				$KPE_AIR_FLOWMETER_CATATAN_BEBAN = $KPE_AIR_FLOWMETER_CATATAN_PAKAI;
			}
		}

		/*===================== Mencari hasil Beban jika flowmeter digunakan beberapa departemen ===================*/
		if ($input['TOTAL_PERSONIL'] == "") {
			$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN = "";
		} else {
			$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],3);
		}

		if ($input['KPE_AIR_FLOWMETER_CATATAN_NOTE'] == '') {
			$KPE_AIR_FLOWMETER_CATATAN_NOTE = 'kosong';
		} else {
			$KPE_AIR_FLOWMETER_CATATAN_NOTE = $input['KPE_AIR_FLOWMETER_CATATAN_NOTE'];
		}

		/*===================== Looping insert ke database jika flowmeter digunakan beberapa departemen ===================*/
		if ($result_fd > 0) {
			foreach ($result_fd as $key => $value) {
				if ($input['KPE_AIR_FLOWMETER_ID'] == "20210109165156619692") {
					if ($result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'] ==  "20210302112932644896") {
						$personil = $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'];
						$catatan = $KPE_AIR_FLOWMETER_CATATAN_BEBAN;
						$hasil = ($personil*$catatan)/100;
						$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $hasil;
						$beban1 = $hasil;
					} elseif ($result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'] == "20210302112919193282") {
						$personil = $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'];
						$catatan = $KPE_AIR_FLOWMETER_CATATAN_BEBAN;
						$hasil = ($personil*$catatan)/100;
						$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $hasil;
						$beban2 = $hasil;
					} else {
						$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $KPE_AIR_FLOWMETER_CATATAN_BEBAN-($beban1+$beban2);
					}
					// $final[] = $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI;
					$data_master_catatan_dept = array(
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'],
						'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
						'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
						'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_DEPARTEMEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSONIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN";
					$this->MYSQL->record = $data_master_catatan_dept;	
					$this->MYSQL->simpan();
				} else {
					
					if ($input['KPE_AIR_FLOWMETER_ID'] == "20210131083305548129") {
						$KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],3);
					} else {
						$KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],2);
					}
					// $KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],2);
					$data_master_catatan_dept = array(
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'],
						'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
						'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
						'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_DEPARTEMEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSONIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,
						'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
						'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
						'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
						'RECORD_STATUS' => "A"
					);
		
					$this->MYSQL =new MYSQL;
					$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
					$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN";
					$this->MYSQL->record = $data_master_catatan_dept;	
					$this->MYSQL->simpan();
				}
			}
		}
		/*========End Looping========*/
	
		if($input['KPE_AIR_FLOWMETER_CATATAN_ID']=="")
		{
			$sql_ca = "SELECT KPE_AIR_FLOWMETER_CATATAN_TANGGAL,KPE_AIR_FLOWMETER_CATATAN_ANGKA FROM KPE_AIR_FLOWMETER_CATATAN WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND RECORD_STATUS='A' AND KPE_AIR_FLOWMETER_CATATAN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."'";

			$this->MYSQL = new MYSQL();
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->queri = $sql_ca;
			$result_ca = $this->MYSQL->data();
			if ($result_ca >= 1) {
				$this->callback['respon']['pesan'] = "gagal";
				$this->callback['respon']['text_msg'] = "Catatan ditanggal ini sudah pernah di input";
			} else {
				$data_master = array(
					'KPE_AIR_FLOWMETER_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_AIR_FLOWMETER_CATATAN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
					'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
					'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
					'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,
					'KPE_AIR_FLOWMETER_CATATAN_PERSONIL_DEPARTEMEN' => $input['PERSONIL_DEPARTEMEN'],
					'KPE_AIR_FLOWMETER_CATATAN_TOTAL_PERSONIL' => $input['TOTAL_PERSONIL'],
					'KPE_AIR_FLOWMETER_CATATAN_TOTAL_PERSEN' => $input['PERSEN'],
					'KPE_AIR_FLOWMETER_CATATAN_PERSONIL_HASIL' => $input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
					'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
					'KPE_AIR_FLOWMETER_CATATAN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
					'KPE_AIR_FLOWMETER_CATATAN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
					'KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN,
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
					'KPE_AIR_FLOWMETER_CATATAN_NOTE' => $KPE_AIR_FLOWMETER_CATATAN_NOTE,
					'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
					'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "A"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
				$this->MYSQL->record = $data_master;				
	
				if ($this->MYSQL->simpan() == true)
					{
						$this->callback['respon']['pesan']="sukses";
						$this->callback['respon']['text_msg']="Berhasil Simpan";
						$this->callback['result']=$result;
					}
					else
					{
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Gagal Simpan";
					}
			}
		}else 
		{
			/*===== Edit catatan flowmeter yg digunakan beberapa departemen =====*/
			$data_master_flow_edit = array(
				'EDIT_WAKTU' => date("Y-m-d H:i:s"),
				'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
				'RECORD_STATUS' => "E"
			);
			$this->MYSQL =new MYSQL;
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN";
			$this->MYSQL->record = $data_master_flow_edit;
			$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_ID='".$input['KPE_AIR_FLOWMETER_ID']."' AND KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL='".$input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL']."' AND RECORD_STATUS='A'";
			if($this->MYSQL->ubah() == true){
				foreach ($result_fd as $key => $value) {
					if ($input['KPE_AIR_FLOWMETER_ID'] == "20210109165156619692") {
						if ($result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'] ==  "20210302112932644896") {
							$personil = $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'];
							$catatan = $KPE_AIR_FLOWMETER_CATATAN_BEBAN;
							$hasil = ($personil*$catatan)/100;
							$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $hasil;
							$beban1 = $hasil;
						} elseif ($result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'] == "20210302112919193282") {
							$personil = $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'];
							$catatan = $KPE_AIR_FLOWMETER_CATATAN_BEBAN;
							$hasil = ($personil*$catatan)/100;
							$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $hasil;
							$beban2 = $hasil;
						} else {
							$KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI = $KPE_AIR_FLOWMETER_CATATAN_BEBAN-($beban1+$beban2);
						}
						// $final[] = $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI;
						// $KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],2);
						$data_master_catatan_dept = array(
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'],
							'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
							'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
							'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_DEPARTEMEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSONIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DIREKSI,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
							'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
							'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
							'RECORD_STATUS' => "A"
						);
			
						$this->MYSQL =new MYSQL;
						$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
						$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN";
						$this->MYSQL->record = $data_master_catatan_dept;	
						$this->MYSQL->simpan();
					} else {
						
						if ($input['KPE_AIR_FLOWMETER_ID'] == "20210131083305548129") {
							$KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],3);
						} else {
							$KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],2);
						}
						// $KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN = round($KPE_AIR_FLOWMETER_CATATAN_BEBAN*$result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],2);
						$data_master_catatan_dept_edit = array(
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_ID' => waktu_decimal(Date("Y-m-d H:i:s")),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_FLOW_ID' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_ID'],
							'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
							'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_FLOW_NAMA'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
							'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_DEPARTEMEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSONIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSONIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_TOTAL_PERSEN' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_TOTAL_PERSEN'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PERSONIL_HASIL' => $result_fd[$key]['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_BEBAN_DEPARTEMEN,
							'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
							'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
							'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
							'RECORD_STATUS' => "A"
						);
			
						$this->MYSQL =new MYSQL;
						$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
						$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN";
						$this->MYSQL->record = $data_master_catatan_dept_edit;	
						$this->MYSQL->simpan();
					}
				}
			}
			/*===== End edit catatan flowmeter yg digunakan beberapa departemen =====*/

			/*===== Edit catatan flowmeter =====*/
			$data_master_edit = array(
				
				'EDIT_WAKTU' => date("Y-m-d H:i:s"),
				'EDIT_OPERATOR' => $user_login['PERSONAL_NIK'],
				'RECORD_STATUS' => "E"
			);

			$this->MYSQL =new MYSQL;
			$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
			$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
			$this->MYSQL->record = $data_master_edit;
			$this->MYSQL->dimana = "WHERE KPE_AIR_FLOWMETER_CATATAN_ID='".$input['KPE_AIR_FLOWMETER_CATATAN_ID']."' AND RECORD_STATUS='A'";

			if ($this->MYSQL->ubah() == true)
			{
				$data_master_ubah = array(
					'KPE_AIR_FLOWMETER_CATATAN_INDEX' => waktu_decimal(Date("Y-m-d H:i:s")),
					'KPE_AIR_FLOWMETER_CATATAN_ID' => $input['KPE_AIR_FLOWMETER_CATATAN_ID'],
					'KPE_AIR_FLOWMETER_ID' => $input['KPE_AIR_FLOWMETER_ID'],
					'KPE_AIR_FLOWMETER_NAMA' => base64_decode($input['KPE_AIR_FLOWMETER_NAMA']),
					'KPE_AIR_FLOWMETER_CATATAN_TANGGAL' => $input['KPE_AIR_FLOWMETER_CATATAN_TANGGAL'],
					'KPE_AIR_FLOWMETER_CATATAN_DEPARTEMEN_NAMA' => $KPE_AIR_FLOWMETER_DEPARTEMEN_NAMA,
					'KPE_AIR_FLOWMETER_CATATAN_PERSONIL_DEPARTEMEN' => $input['PERSONIL_DEPARTEMEN'],
					'KPE_AIR_FLOWMETER_CATATAN_TOTAL_PERSONIL' => $input['TOTAL_PERSONIL'],
					'KPE_AIR_FLOWMETER_CATATAN_TOTAL_PERSEN' => $input['PERSEN'],
					'KPE_AIR_FLOWMETER_CATATAN_PERSONIL_HASIL' => $input['KPE_AIR_FLOWMETER_DEPARTEMEN_PERSONIL_HASIL'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_REAL' => $input['KPE_AIR_FLOWMETER_KALIBRASI_REAL'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_SELISIH' => $input['KPE_AIR_FLOWMETER_KALIBRASI_SELISIH'],
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI_PERSEN' => $input['KPE_AIR_FLOWMETER_KALIBRASI_PERSEN'],
					'KPE_AIR_FLOWMETER_CATATAN_ANGKA' => $input['KPE_AIR_FLOWMETER_CATATAN_ANGKA'],
					'KPE_AIR_FLOWMETER_CATATAN_PAKAI' => $KPE_AIR_FLOWMETER_CATATAN_PAKAI,
					'KPE_AIR_FLOWMETER_CATATAN_BEBAN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN,
					'KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN' => $KPE_AIR_FLOWMETER_CATATAN_BEBAN_DEPARTEMEN,
					'KPE_AIR_FLOWMETER_CATATAN_KALIBRASI' => $KPE_AIR_FLOWMETER_CATATAN_KALIBRASI,
					'KPE_AIR_FLOWMETER_CATATAN_NOTE' => $KPE_AIR_FLOWMETER_CATATAN_NOTE,
					'ENTRI_WAKTU' => date("Y-m-d H:i:s"),
					'ENTRI_OPERATOR' => $user_login['PERSONAL_NIK'],
					'RECORD_STATUS' => "A"
				);
	
				$this->MYSQL =new MYSQL;
				$this->MYSQL->database = $this->CONFIG->mysql_koneksi()->db_nama;
				$this->MYSQL->tabel ="KPE_AIR_FLOWMETER_CATATAN";
				$this->MYSQL->record = $data_master_ubah;
	
				if ($this->MYSQL->simpan() == true)
					{
						
							$this->callback['respon']['pesan']="sukses";
							$this->callback['respon']['text_msg']="Berhasil Mengubah";
							$this->callback['result']=$result;
					}
					else
					{
					$this->callback['respon']['pesan'] = "gagal";
					$this->callback['respon']['text_msg'] = "Gagal Mengubah";
					}
			}else {
				$this->callback['respon']['pesan'] = "gagal";
				$this->callback['respon']['text_msg'] = "Gagal Mengubah";
			}
		}
		/*===== End edit catatan flowmeter =====*/
		
		


?>
