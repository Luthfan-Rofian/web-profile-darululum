<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelVideo extends Model
{
    protected $table      = 'video';
    protected $primaryKey = 'video_id';
    protected $allowedFields = [
        'judul', 'video_link', 'tanggal', 'id', 'kategorivideo_id', 'sts_v', 'ket_video', 'hits', 'likevideo'
    ];

    //backend
    public function listvideo()
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->orderBy('video_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listvideoauthor($id)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->where('video.id', $id)
            ->orderBy('video_id', 'DESC')
            ->get()->getResultArray();
    }


    public function listvideopage()
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->where('video.sts_v', 1)
            ->orderBy('video_id', 'DESC');
    }

    //frontend video
    public function published()
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->where('video.sts_v', 1)
            ->orderBy('video_id', 'DESC')
            ->get(8, 0)->getResultArray();
    }


    // view detail video
    public function detail_video($video_id)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->where('video_id', $video_id)
            ->get()->getRow();
    }

    //frontend video terkait
    public function videolainnya($video_id)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->where('video.sts_v', 1)
            ->where('video.video_id !=', $video_id)
            ->orderBy('video_id', 'DESC')
            ->get(8, 0)->getResultArray();
    }

    //pencarian kategori kosong

    public function cari($keywordcari, $kategori)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->like('judul', $keywordcari)
            ->orlike('ket_video', $keywordcari)
            ->orlike('kategori_video.nama_kategori_video', $kategori)
            ->where('video.sts_v', 1)
            ->where('kategori_video.nama_kategori_video', $kategori)
            ->orderBy('video_id', 'DESC')
            ->get()->getResultArray();
    }

    //pencarian kategori ada keyword tdk

    public function carikat($keywordcari, $kategori)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->like('judul', $keywordcari)
            ->like('ket_video', $keywordcari)
            ->like('kategori_video.nama_kategori_video', $kategori)
            ->where('video.sts_v', 1)
            ->where('kategori_video.nama_kategori_video', $kategori)
            ->orderBy('video_id', 'DESC')
            ->get()->getResultArray();
    }

    //pencarian kategori ada keyword ada

    public function carikatkey($keywordcari, $kategori)
    {
        return $this->table('video')
            ->join('users', 'users.id = video.id')
            ->join('kategori_video', 'kategori_video.kategorivideo_id = video.kategorivideo_id')
            ->like('judul', $keywordcari)
            ->orlike('ket_video', $keywordcari)
            ->like('kategori_video.nama_kategori_video', $kategori)
            ->where('video.sts_v', 1)
            ->where('kategori_video.nama_kategori_video', $kategori)
            ->orderBy('video_id', 'DESC')
            ->get()->getResultArray();
    }

    public function totvideo()
    {
        return $this->table('video')
            ->where('sts_v', 1)
            ->get()->getNumRows();
    }


    public function getaktif()
    {
        return $this->table('video')
            ->like('sts_v', '1')
            ->orderBy('video_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('video')
            ->where('sts_v', '0')
            ->orderBy('video_id', 'ASC')
            ->get()->getResultArray();
    }
}
