<?php

namespace App\Controllers;

class Petasitus extends BaseController
{

    public function index()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $template = $this->template->tempaktif();

        $data = [
            'title'             => 'Peta Situs | ' . $konfigurasi->nama,
            'deskripsi'         => $konfigurasi->deskripsi,
            'url'               => $konfigurasi->website,
            'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'       => $konfigurasi,
            'mainmenu'          => $this->menu->mainmenu(),
            'footer'            => $this->menu->footermenu(),
            'topmenu'           => $this->menu->topmenu(),
            'banner'            => $this->banner->list(),
            'infografis'        => $this->banner->listinfo(),
            'infografis1'       => $this->banner->listinfo1(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'section'           => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'beritautama'   => $this->berita->headlineall(),
            'folder'        => $template['folder']

        ];
        return view('' . $template['folder'] . '/' . 'content/petasitus', $data);
    }
}
