<?php

namespace App\Controllers;

class Home extends BaseController
{

	public function index()
	{

		$konfigurasi            = $this->konfigurasi->vkonfig();
		$template = $this->template->tempaktif();
		$poltanya = $this->poling->poltanya();
		$poljawab = $this->poling->poljawab();
		$jumpol = $this->poling->polling_sum();
		$kategori_id = $konfigurasi->kategori_id;
		$beritakate   =  $this->berita->listkategori($kategori_id);
		$beritakate6   =  $this->berita->listkategori6($kategori_id);
		$pegawai = $this->pegawai->listpegawaipage();
		$faq   =  $this->faqtanya->listpublish();
		// $layanan = $this->layanan->listlayananpage();
		$data = [
			'title'             => $konfigurasi->nama,
			'deskripsi'         => $konfigurasi->deskripsi,
			'url'               => $konfigurasi->website,
			'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
			'banner'			=> $this->banner->list(),
			'infografis' 		=> $this->banner->listgrafis(),
			'infografis2' 		=> $this->banner->listinfo(),
			'infografis1' 		=> $this->banner->listinfo1(),
			'linkterkait' 		=> $this->linkterkait->listlinkpage()->paginate(4),
			'linkterkaitall'	=> $this->linkterkait->publishlinkall(),
			'konfigurasi' 		=> $konfigurasi,
			'berita'         	=> $this->berita->listberitapage()->paginate(6),
			'berita4'         	=> $this->berita->listberitapage()->paginate(4),
			'beritapopuler'     => $this->berita->populer()->paginate(5),
			'faq'			   => $faq,
			'ebook2'          	=> $this->ebook->listebookpage()->paginate(2),
			'ebook'          	=> $this->ebook->listebookpage()->paginate(4),
			'pegawai'          	=> $pegawai->paginate(4, 'hal'),
			'terkini1' 			=> $this->berita->terkini1(),
			'terkini6' 			=> $this->berita->published(),
			'terkini' 			=> $this->berita->terkini(),
			'terkini5' 			=> $this->berita->terkini5($kategori_id),
			'utama' 			=> $this->berita->utama(),
			'headline' 			=> $this->berita->headline(),
			'headline6' 		=> $this->berita->headline6(),

			'beritautama' 		=> $this->berita->headlineall(),
			'mainmenu' 			=> $this->menu->mainmenu(),
			'footer' 			=> $this->menu->footermenu(),
			'topmenu' 			=> $this->menu->topmenu(),
			'agenda'       		=> $this->agenda->listagendapage()->paginate(4),
			'agenda5'       	=> $this->agenda->listagendapage()->paginate(5),
			'agenda2'       	=> $this->agenda->listagendapage()->paginate(2),
			'layanan'       	=> $this->layanan->listlayananpage()->paginate(6),
			'foto'      		=> $this->foto->listfotopage()->paginate(6),
			'pengumuman'       	=> $this->pengumuman->listpengumumanpage()->paginate(6),
			'bankdata' 			=>  $this->bankdata->listbankdatapage()->paginate(6),
			'poltanya' 			=> $poltanya['pilihan'],
			'polsts' 			=> $poltanya['status'],
			'poljawab' 			=> $poljawab,
			'jumpol' 			=> $jumpol['jml_vote'],
			'kategoriaktif' 	=> $beritakate,
			'kategoriaktif6' 	=> $beritakate6,
			'section' 			=> $this->section->list(),
			'video'      	    => $this->video->listvideopage()->paginate(1),
			'video4'      	    => $this->video->listvideopage()->paginate(4),
			'counter' 			=> $this->counter->listfront(),
			'pengumuman1'       => $this->pengumuman->listpengumumanpage()->paginate(1),
			'iklan' 		    => $this->banner->listiklantengah(),
			'iklan2' 		    => $this->banner->listiklankanan(),
			'folder'   			=> $template['folder'],
			// onepage
			// 'layananone'     	    => $layanan->paginate(5000, 'hal'),
		];

		return view('' . $template['folder'] . '/' . 'v_home', $data);
	}

	public function cari()
	{
		$konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();


		$berita = $this->berita->published();
		$template = $this->template->tempaktif();
		$keywordcari = $this->request->getVar('keyword');
		if ($keywordcari) {
			$list =  $this->berita->cari1($keywordcari);
			$data = [
				'title'  		=> 'Situs Resmi ' . $konfigurasi['nama'],
				'konfigurasi' 	=> $konfigurasi,
				'berita' 		=> $berita,
				'berita' 		=> $list,
				'keyword' 		=> $keywordcari
			];
			// Menuju ke web front end;

			return view('' . $template['folder'] . '/' . 'content/v_hasilcari', $data);
		}
	}

	public function cekpengunjung()
	{
		if ($this->request->isAJAX()) {

			$data = [
				'kunjungan'    => $this->user->kunjungan(),
				'pengunjungon' => $this->user->totonline(),
			];
			$msg = [
				'data' => view('admin/modal/onpengunjung', $data)

			];

			echo json_encode($msg);
		}
	}

	//lihat penawaran front end
	public function nonaktiftawaran()
	{
		if ($this->request->isAJAX()) {
			$msg =	set_cookie("penawaran", "isi", 5500);
			echo json_encode($msg);
		}
	}
	public function penawaran22()
	{
		if ($this->request->isAJAX()) {


			$konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
			if (get_cookie("penawaran") != 'isi') {;

				$data = [
					'konfigurasi' => $konfigurasi,
					'list'        => $this->modalpopup->orderBy('modalpopup_id')->first(),
				];
				$msg = [
					'data' => view('admin/modal/penawaran', $data)

				];
			} else {
				$msg = [
					// Form penawaran tdk tampil'
				];
			}
			echo json_encode($msg);
		}
	}
}
