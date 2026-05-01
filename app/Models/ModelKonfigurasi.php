<?php

namespace App\Models;

use App\Entities\Apiupdate;
use CodeIgniter\Model;

class ModelKonfigurasi extends Model
{
    protected $table      = 'tbl_setaplikasi';
    protected $primaryKey = 'id_setaplikasi';
    protected $allowedFields = [
        'nama', 'alamat', 'no_telp', 'kecamatan', 'kabupaten', 'provinsi', 'email', 'website', 'deskripsi', 'logo', 'icon', 'google_map',
        'sambutan', 'gbr_sambutan', 'link_gmap', 'sosmed_fb', 'sosmed_instagram', 'sosmed_twiter', 'sosmed_youtube', 'kategori_id', 'judul_section',
        'sts_section', 'nama_pimpinan', 'jabatan_pimpinan', 'sts_sambutan', 'sts_modal', 'sts_count', 'sts_rt', 'hplogo', 'wllogo',  'hpbanner', 'wlbanner',
        'sts_regis', 'sts_web', 'sts_posting', 'verbost', 'smtp_host', 'smtp_username', 'smtp_password', 'smtp_port', 'smtp_pengirim', 'ukuran_upload',
        'smtp_pesanbalas', 'g_sitekey', 'g_secretkey', 'vercms', 'konek_opd', 'id_grup', 'footer_cms', 'katamutiara', 'tokenwa', 'no_waysender', 'wa_penerima', 'namasingkat', 'urlserver'
    ];



    //backend
    public function list()
    {
        return $this->table('tbl_setaplikasi')
            ->orderBy('id_setaplikasi', 'ASC')
            ->get()->getResultArray();
    }

    public function vkonfig()
    {
        $sql = "SELECT nama,vercms,icon,logo,deskripsi,website,link_gmap,google_map,alamat,kabupaten,provinsi,kecamatan,
        email,no_telp,sosmed_fb,sosmed_instagram,sosmed_twiter,sosmed_youtube,footer_cms,kategori_id,
        sts_sambutan,sambutan, sts_modal, sts_count,sts_section,sts_rt,judul_section,gbr_sambutan,sts_regis,konek_opd,
        jabatan_pimpinan,nama_pimpinan,katamutiara,namasingkat,g_secretkey,g_sitekey,verbost  FROM tbl_setaplikasi";
        $rs = $this->db->query($sql)->getRow();
        return $rs;
    }
}
