<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class Fasilitas extends BaseController
{

	public function index()
	{
		$konfigurasi        = $this->konfigurasi->vkonfig();
		$template = $this->template->tempaktif();
		$fasilitasutm = $this->fasilitas->getutama();
		$fasilitas = $this->fasilitas->listfasilitaspage();

		$data = [
			'title'         => 'Fasilitas ' . $konfigurasi->nama,
			'deskripsi'     => $konfigurasi->deskripsi,
			'url'           => $konfigurasi->website,
			'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
			'konfigurasi'   => $konfigurasi,
			'mainmenu'      => $this->menu->mainmenu(),
			'footer'        => $this->menu->footermenu(),
			'topmenu'       => $this->menu->topmenu(),
			'fasilitasutm'  => $fasilitasutm,

			'fasilitas'     => $fasilitas->paginate(12, 'hal'),
			'pager'         => $fasilitas->pager,

			// 'jumpg'         => 12,
			'jumpg'         => $this->fasilitasdetail->jumfas(),
			'banner'        => $this->banner->list(),
			'infografis'    => $this->banner->listinfo(),
			'infografis1'   => $this->banner->listinfo1(),
			'agenda'        => $this->agenda->listagendapage()->paginate(4),
			'section'       => $this->section->list(),
			'linkterkaitall'    => $this->linkterkait->publishlinkall(),
			'folder'        => $template['folder']

		];
		return view('' . $template['folder'] . '/' . 'content/fasilitas', $data);
	}

	// default tampilan front

	public function toggledef()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('fasilitas_id');
			$cari =  $this->fasilitas->find($id);

			if ($cari['sts'] == '1') {
				$list =  $this->fasilitas->getaktif($id);
				$toggle = $list ? 0 : 1;
				$updatedata = [
					'sts'        => $toggle,
				];
				$this->fasilitas->update($id, $updatedata);
				$msg = [
					'sukses' => 'Berhasil nonaktifkan tampilan default!'
				];
			} else {
				$list =  $this->fasilitas->getnonaktif($id);
				$toggle = $list ? 1 : 0;
				$updatedata = [
					'sts'        => $toggle,
				];
				$this->fasilitas->resetstatus();
				$this->fasilitas->update($id, $updatedata);
				$msg = [
					'sukses' => 'Fasilitas ini berhasil dijadikan tampilan default awal!'
				];
			}

			echo json_encode($msg);
		}
	}

	//Detail front end
	public function det($fasilitas_id = null)
	{
		if (!isset($fasilitas_id)) return redirect()->to('/fasilitas');
		// $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

		$konfigurasi        = $this->konfigurasi->vkonfig();
		$template = $this->template->tempaktif();
		$detfasilitas =  $this->fasilitasdetail->list($fasilitas_id);

		$kategori = $this->kategori->list();

		if ($detfasilitas) {


			$data = [
				'title'         => 'Fasilitas ' . $konfigurasi->nama,
				'deskripsi'     => $konfigurasi->deskripsi,
				'url'           => $konfigurasi->website,
				'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
				'konfigurasi'   => $konfigurasi,
				'detfasilitas'   => $detfasilitas,
				'beritapopuler' => $this->berita->populer()->paginate(8),
				'kategori'       => $kategori,
				'mainmenu'       => $this->menu->mainmenu(),
				'footer'         => $this->menu->footermenu(),
				'topmenu'        => $this->menu->topmenu(),
				'banner'         => $this->banner->list(),
				'infografis'     => $this->banner->listinfo(),
				'infografis1'    => $this->banner->listinfo1(),
				'agenda'         => $this->agenda->listagendapage()->paginate(4),
				'linkterkaitall'    => $this->linkterkait->publishlinkall(),
				'folder'        => $template['folder'],

			];
			return view('' . $template['folder'] . '/' . 'content/fasilitas_detail', $data);
		} else {
			return redirect()->to('/fasilitas');
		}
	}

	public function list()
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		$data = [
			'title'       => 'Fasilitas',
			'subtitle'    => 'Lembaga',

		];
		return view('admin/lembaga/fasilitas/index', $data);
	}

	public function getdata()
	{
		if ($this->request->isAJAX()) {

			$id_grup = session()->get('id_grup');
			$url = 'fasilitas/list';
			$listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

			foreach ($listgrupf as $data) :
				$akses = $data['akses'];
			endforeach;
			// jika temukan maka eksekusi
			if ($listgrupf) {
				# cek akses
				if ($akses == '1' || $akses == '2') {
					$data = [
						'title'     => 'Fasilitas',
						'list'      => $this->fasilitas->list(),
						'akses'     => $akses
					];
					$msg = [
						'data' => view('admin/lembaga/fasilitas/list', $data)
					];
				} else {
					$msg = [
						'noakses' => []
					];
				}
			} else {

				$msg = [
					'blmakses' => []
				];
			}

			echo json_encode($msg);
		}
	}

	public function formtambah()
	{
		if ($this->request->isAJAX()) {
			$data = [
				'title' => 'Tambah Data',
			];
			$msg = [
				'data' => view('admin/lembaga/fasilitas/tambah', $data)
			];
			echo json_encode($msg);
		}
	}

	public function simpanfasilitas()
	{
		if ($this->request->isAJAX()) {

			$validation = \Config\Services::validation();

			$valid = $this->validate([
				'fasilitas' => [
					'label' => 'Fasilitas',
					'rules' => 'required|is_unique[fasilitas.fasilitas]',
					'errors' => [
						'required' => '{field} tidak boleh kosong',
						'is_unique' => '{field} tidak boleh sama',
					]
				],

				'cover_foto' => [
					'label' => 'Cover',
					'rules' => 'max_size[cover_foto,3024]|mime_in[cover_foto,image/png,image/jpg,image/jpeg,image/gif]|is_image[cover_foto]',
					'errors' => [
						// 'uploaded' => 'Silahkan Masukkan cover_foto',
						'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
						'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
					]
				]

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'fasilitas'  => $validation->getError('fasilitas'),
						'cover_foto'          => $validation->getError('cover_foto'),
					]
				];
				echo json_encode($msg);
			} else {

				// $userid = session()->get('id');
				$filegambar = $this->request->getFile('cover_foto');
				$nama_file = $filegambar->getRandomName();

				//jika gambar tidak ada
				if ($filegambar->GetError() == 4) {

					$insertdata = [
						'fasilitas' => $this->request->getVar('fasilitas'),
						'ket'                => $this->request->getVar('ket'),
						'lokasi'                => $this->request->getVar('lokasi'),
						'cover_foto'         => 'default.png',

					];

					$this->fasilitas->insert($insertdata);

					$msg = [
						'sukses' => 'Kategori foto berhasil disimpan!'
					];
				} else {

					$insertdata = [

						'fasilitas'  => $this->request->getVar('fasilitas'),
						'slug_kategori_foto'   => mb_url_title($this->request->getVar('fasilitas'), '-', TRUE),
						'ket'                => $this->request->getVar('ket'),
						'lokasi'                => $this->request->getVar('lokasi'),
						'cover_foto'        => $nama_file,

					];

					$this->fasilitas->insert($insertdata);
					// $filegambar->move('public/img/informasi/fasilitas/', $nama_file); //folder gambar
					\Config\Services::image()
						->withFile($filegambar)
						->save('public/img/informasi/fasilitas/' . $nama_file, 70);
					$msg = [
						'sukses' => 'Fasilitas berhasil disimpan!'
					];
				}
				echo json_encode($msg);
			}
		}
	}

	public function ganticoverfas()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('fasilitas_id');
			$list =  $this->fasilitas->find($id);
			$data = [
				'title'       => 'Ganti Cover',
				'id'          => $list['fasilitas_id'],
				'cover_foto'   => $list['cover_foto']

			];
			$msg = [
				'sukses' => view('admin/lembaga/fasilitas/gantifoto', $data)
			];
			echo json_encode($msg);
		}
	}

	public function douploadcover()
	{
		if ($this->request->isAJAX()) {

			$id = $this->request->getVar('fasilitas_id');

			$validation = \Config\Services::validation();

			$valid = $this->validate([
				'cover_foto' => [
					'label' => 'Cover halaman',
					'rules' => 'uploaded[cover_foto]|max_size[cover_foto,1024]|mime_in[cover_foto,image/png,image/jpg,image/jpeg,image/gif]|is_image[cover_foto]',
					'errors' => [
						'uploaded' => 'Masukkan gambar',
						'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
						'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
					]
				]

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'cover_foto' => $validation->getError('cover_foto')
					]
				];
			} else {

				//check
				$cekdata = $this->fasilitas->find($id);
				$fotolama = $cekdata['cover_foto'];

				if ($fotolama != 'default.png' && file_exists('public/img/informasi/fasilitas/' . $fotolama)) {
					unlink('public/img/informasi/fasilitas/' . $fotolama);
				}

				$filegambar = $this->request->getFile('cover_foto');
				$nama_file = $filegambar->getRandomName();

				$updatedata = [
					'cover_foto' => $nama_file
				];

				$this->fasilitas->update($id, $updatedata);
				// $filegambar->move('public/img/informasi/fasilitas/', $nama_file); //folder foto
				\Config\Services::image()
					->withFile($filegambar)
					->save('public/img/informasi/fasilitas/' . $nama_file, 70);
				$msg = [
					'sukses' => 'Cover berhasil diganti!',
				];
			}
			echo json_encode($msg);
		}
	}

	public function formeditfasilitas()
	{
		if ($this->request->isAJAX()) {
			$fasilitas_id = $this->request->getVar('fasilitas_id');
			$list =  $this->fasilitas->find($fasilitas_id);
			$data = [
				'title'               => 'Edit Data',
				'fasilitas_id'        => $list['fasilitas_id'],
				'fasilitas'           => $list['fasilitas'],
				'ket'                 => $list['ket'],
				'lokasi'              => $list['lokasi'],


			];
			$msg = [
				'sukses' => view('admin/lembaga/fasilitas/edit', $data)
			];
			echo json_encode($msg);
		}
	}

	public function updatefasilitas()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'fasilitas' => [
					'label' => 'Fasilitas',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong',
					]
				],

			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'fasilitas' => $validation->getError('fasilitas'),

					]
				];
			} else {
				$updatedata = [
					'fasilitas'  => $this->request->getVar('fasilitas'),
					'ket'        => $this->request->getVar('ket'),
					'lokasi'        => $this->request->getVar('lokasi'),

				];

				$fasilitas_id = $this->request->getVar('fasilitas_id');
				$this->fasilitas->update($fasilitas_id, $updatedata);
				$msg = [
					'sukses' => 'Data berhasil diupdate'
				];
			}
			echo json_encode($msg);
		}
	}

	public function hapusfasilitas()
	{
		if ($this->request->isAJAX()) {

			$fasilitas_id = $this->request->getVar('fasilitas_id');

			//check
			$cekdata = $this->fasilitas->find($fasilitas_id);
			$fotolama = $cekdata['cover_foto'];

			if ($fotolama != 'default.png'  && file_exists('public/img/informasi/fasilitas/' . $fotolama)) {
				unlink('public/img/informasi/fasilitas/' . $fotolama);
			}

			$this->fasilitas->delete($fasilitas_id);
			$msg = [
				'sukses' => 'Data Berhasil Dihapus'
			];

			echo json_encode($msg);
		}
	}
	//end fasilitas

	// Detail fasilitas
	public function detail($fasilitas_id = null)
	{
		if (session()->get('id') == '') {
			return redirect()->to('');
		}
		if ($fasilitas_id == '') {

			return redirect()->to(base_url('fasilitas/list'));
		}
		$list =  $this->fasilitasdetail->list($fasilitas_id);
		$data = [
			'title'     => 'Fasilitas',
			'subtitle'  => 'Detail',
			'fasilitas_id' => $fasilitas_id,
			'list' => $list,

		];
		return view('admin/lembaga/fasilitas/detail/index', $data);
	}

	// get data
	public function detailajx()
	{
		if ($this->request->isAJAX()) {

			$id_grup = session()->get('id_grup');
			$fasilitas_id = $this->request->getVar('fasilitas');
			$list =  $this->fasilitasdetail->list($fasilitas_id);

			$url = 'fasilitas/list';
			$listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

			foreach ($listgrupf as $data) :
				$akses = $data['akses'];
			endforeach;
			// jika temukan maka eksekusi
			if ($listgrupf) {
				# cek akses
				if ($fasilitas_id == '') {
					return redirect()->to(base_url('fasilitas/list'));
				}

				if ($akses == '1') {
					$data = [
						'title'      => 'Detail Fasilitas',
						'list'       => $list,
						'akses'     => '1'
					];
					$msg = [
						'data' => view('admin/lembaga/fasilitas/detail/list', $data)
					];
				} elseif ($akses == '2') {

					$data = [
						'title'      => 'Detail Fasilitas',
						'list'       => $list,
						'akses'     => '2'
					];
					$msg = [
						'data' => view('admin/lembaga/fasilitas/detail/list', $data)
					];
				} else {
					$msg = [
						'noakses' => []
					];
				}
			} else {

				$msg = [
					'blmakses' => []
				];
			}

			echo json_encode($msg);
		}
	}


	public function formtambahdetail()
	{
		if ($this->request->isAJAX()) {
			$data = [
				'title' => 'Tambah Item',
				'fasilitas_id' => $this->request->getVar('fasilitas_id'),
			];
			$msg = [
				'data' => view('admin/lembaga/fasilitas/detail/tambah', $data)
			];
			echo json_encode($msg);
		}
	}

	// simpan detail
	public function uploadfotodetail()
	{
		if ($this->request->isAJAX()) {

			$validation = \Config\Services::validation();
			$valid = $this->validate([
				'deskripsi' => [
					'label' => 'Keterangan Foto',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong!',
					]
				],

				'gambar' => [
					'label' => 'gambar',
					'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
					'errors' => [
						'uploaded' => 'Masukkan gambar',
						'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
						'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'deskripsi'       => $validation->getError('deskripsi'),
						'gambar'          => $validation->getError('gambar')
					]
				];
			} else {


				$filegambar = $this->request->getFile('gambar');

				$nama_file = $filegambar->getRandomName();
				$insertdata = [
					'deskripsi'        => $this->request->getVar('deskripsi'),
					'fasilitas_id'     => $this->request->getVar('fasilitas_id'),
					'gambar'           => $nama_file,

				];

				$this->fasilitasdetail->insert($insertdata);

				// $filegambar->move('public/img/informasi/fasilitas/detail/', $nama_file); //folder gbr
				\Config\Services::image()
					->withFile($filegambar)
					->save('public/img/informasi/fasilitas/detail/' . $nama_file, 70);
				$msg = [
					'sukses' => 'Data berhasil disimpan!'
				];
			}
			echo json_encode($msg);
		}
	}

	public function formeditdetail()
	{
		if ($this->request->isAJAX()) {
			$fasilitasdetail_id = $this->request->getVar('fasilitasdetail_id');
			$list =  $this->fasilitasdetail->find($fasilitasdetail_id);
			$data = [
				'title'       => 'Edit Data',
				'fasilitasdetail_id'   => $list['fasilitasdetail_id'],
				'deskripsi'         => $list['deskripsi'],
				'gambar'      => $list['gambar'],

				'kategorifoto' => $this->kategorifoto->list()
			];
			$msg = [
				'sukses' => view('admin/lembaga/fasilitas/detail/edit', $data)
			];
			echo json_encode($msg);
		}
	}

	public function updatefotodet()
	{
		if ($this->request->isAJAX()) {

			$fasilitasdetail_id = $this->request->getVar('fasilitasdetail_id');

			$validation = \Config\Services::validation();

			$valid = $this->validate([
				'deskripsi' => [
					'label' => 'Keterangan',
					'rules' => 'required',
					'errors' => [
						'required' => '{field} tidak boleh kosong!',
					]
				],

				'gambar' => [
					'label' => 'gambar',
					'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
					'errors' => [
						// 'uploaded' => 'Masukkan gambar',
						'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
						'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
					]
				]
			]);
			if (!$valid) {
				$msg = [
					'error' => [
						'deskripsi' => $validation->getError('deskripsi'),
						'gambar' => $validation->getError('gambar')
					]
				];
			} else {
				$filegambar = $this->request->getFile('gambar');
				$nama_file = $filegambar->getRandomName();
				//jika edit saja
				if ($filegambar->GetError() == 4) {
					$data = [
						'deskripsi'   => $this->request->getVar('deskripsi'),

					];

					$this->fasilitasdetail->update($fasilitasdetail_id, $data);
					$msg = [
						'sukses' => 'Data berhasil diubah!'
					];
				} else {

					//check
					$cekdata = $this->fasilitasdetail->find($fasilitasdetail_id);
					$fotolama = $cekdata['gambar'];
					if ($fotolama != ''  && file_exists('public/img/informasi/fasilitas/detail/' . $fotolama)) {
						unlink('public/img/informasi/fasilitas/detail/' . $fotolama);
					}

					$updatedata = [
						'deskripsi'   => $this->request->getVar('deskripsi'),
						'gambar' => $nama_file
					];

					$this->fasilitasdetail->update($fasilitasdetail_id, $updatedata);

					// $filegambar->move('public/img/informasi/fasilitas/detail/', $nama_file); //folder gbr
					\Config\Services::image()
						->withFile($filegambar)
						->save('public/img/informasi/fasilitas/detail/' . $nama_file, 70);

					$msg = [
						'sukses' => 'Data berhasil diubah!'
					];
				}
			}
			echo json_encode($msg);
		}
	}

	public function hapusdetail()
	{
		if ($this->request->isAJAX()) {

			$fasilitasdetail_id = $this->request->getVar('fasilitasdetail_id');
			//check
			$cekdata = $this->fasilitasdetail->find($fasilitasdetail_id);
			$fotolama = $cekdata['gambar'];
			if ($fotolama != ''  && file_exists('public/img/informasi/fasilitas/detail/' . $fotolama)) {
				unlink('public/img/informasi/fasilitas/detail/' . $fotolama);
				// unlink('public/img/galeri/foto/thumb/' . 'thumb_' . $fotolama);
			}
			$this->fasilitasdetail->delete($fasilitasdetail_id);
			$msg = [
				'sukses' => 'Data berhasil dihapus!'
			];

			echo json_encode($msg);
		}
	}

	public function hapusdetailall()
	{
		if ($this->request->isAJAX()) {
			$fasilitasdetail_id = $this->request->getVar('fasilitasdetail_id');
			$jmldata = count($fasilitasdetail_id);
			for ($i = 0; $i < $jmldata; $i++) {
				//check
				$cekdata = $this->fasilitasdetail->find($fasilitasdetail_id[$i]);
				$fotolama = $cekdata['gambar'];
				if ($fotolama != '' && file_exists('public/img/informasi/fasilitas/detail/' . $fotolama)) {
					unlink('public/img/informasi/fasilitas/detail/' . $fotolama);
				}

				$this->fasilitasdetail->delete($fasilitasdetail_id[$i]);
			}

			$msg = [
				'sukses' => "$jmldata foto berhasil dihapus"
			];
			echo json_encode($msg);
		}
	}
}
