<?php

namespace App\Models;

// use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelBerita extends Model
{
    protected $table      = 'berita';
    protected $primaryKey = 'berita_id';
    protected $allowedFields = [
        'judul_berita', 'slug_berita', 'isi', 'gambar', 'tgl_berita', 'status', 'kategori_id',
        'id', 'jenis_berita', 'hits', 'likepost', 'headline', 'ket_foto', 'ringkasan', 'filepdf', 'sts_komen', 'pilihan'
    ];

    public $db;
    public $builder;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // SERVER SIDE

    protected function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);
        $this->builder->join('users', 'users.id = berita.id');
        $this->builder->join('kategori', 'kategori.kategori_id = berita.kategori_id', 'left');
        $i = 0;

        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $_POST['search']['value']);
                } else {
                    $this->builder->orLike($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        if ($data) {
            $this->builder->where($data);
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function count_filtered($table, $column_order, $column_search, $order, $data = '')
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all($table, $data = '')
    {
        if ($data) {
            $this->builder->where($data);
        }
        $this->builder->from($table);

        return $this->builder->countAll();
    }

    // END SERVER SIDE--------------------------------------------------------------
    //backend
    public function listberita()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }

    // list berita banner
    public function listberitabaner()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }

    public function listberitaauthor($id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->orderBy('berita_id', 'DESC')
            ->where('berita.id', $id)
            ->get()->getResultArray();
    }

    public function listberitapage()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC');
    }

    public function listberitabyuserpg($id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->where('berita.id', $id);
        // ->get()->getResultArray();
    }

    public function listberitabyopdpg($opd_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->where('users.opd_id', $opd_id);
        // ->get()->getResultArray();
    }
    //frontend berita
    public function published()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }

    //frontend berita terbaru 4
    public function terkini1()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC')
            ->get(1, 0)->getResultArray();
    }
    // p3
    public function terkini6()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }
    public function terkini()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC')
            ->get(5, 1)->getResultArray();
    }
    // terkini home yasbin

    public function terkini5($kategori_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'        => '1',
                'jenis_berita'  => 'Berita',
                'berita.kategori_id !='  => $kategori_id,
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(5, 0)->getResultArray();
    }

    public function terkini3()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('berita_id', 'DESC')
            ->get(3, 0)->getResultArray();
    }


    //frontend berita utama 1 (tema p1)
    public function utama()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita',
                'headline' => '1'
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(1, 0)->getResultArray();
    }

    public function utamabykategori($slug_kategori)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'                => '1',
                'jenis_berita'          => 'Berita',
                'headline'              => '1',
                'kategori.slug_kategori' => $slug_kategori,
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(1, 0)->getResultArray();
    }

    public function utamabytag($tag_id)
    {
        return $this->table('berita_tag')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->join('berita_tag', 'berita_tag.berita_id = berita.berita_id')
            ->where(array(
                'status'                 => '1',
                'jenis_berita'           => 'Berita',
                'headline'              => '1',
                'berita_tag.tag_id'      => $tag_id
            ))
            ->orderBy('berita.berita_id', 'DESC')
            ->get(1, 0)->getResultArray();
    }

    //frontend berita (tema p3)
    public function headline6()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita',
                'headline' => '1'
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 1)->getResultArray();
    }

    //frontend berita (tema p1)
    public function headline()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita',
                'headline' => '1'
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(4, 1)->getResultArray();
    }

    //frontend berita (tema p1)
    public function headlineall()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita',
                'headline' => '1'
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }

    public function headline2()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita',
                'headline' => '1'
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(2, 1)->getResultArray();
    }
    //total berita all

    public function totberita()
    {
        return $this->table('berita')
            ->where(array(
                'status'    => '1',
                'jenis_berita' => 'Berita'
            ))
            ->get()->getNumRows();
    }

    public function totberitabyid($id)
    {
        return $this->table('berita')
            ->where(array(
                'status'    => '1',
                'berita.id'        => $id,
                'jenis_berita' => 'Berita'
            ))
            ->get()->getNumRows();
    }

    public function totberitabyopd($id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->where(array(
                'status'    => '1',
                'users.opd_id'        => $id,
                'jenis_berita' => 'Berita'
            ))
            ->get()->getNumRows();
    }
    //total berita menunggu admin

    public function totberitanew()
    {
        return $this->table('berita')
            ->where(array(
                'status'    => '0',
                'jenis_berita' => 'Berita'
            ))
            ->get()->getNumRows();
    }

    //backend berita (add menu)
    public function listaddberita()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->where('jenis_berita', 'Berita')
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }

    //backend halaman (add menu)
    public function listhalaman()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->where('jenis_berita', 'Halaman')
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }


    //frontend halaman
    public function publishhalaman()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Halaman'))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }

    public function populer()
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array('status'    => '1', 'jenis_berita' => 'Berita'))
            ->orderBy('hits', 'DESC');
    }

    public function populerbyid($id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'       => '1',
                'jenis_berita' => 'Berita',
                'berita.id'    => $id,
            ))
            ->orderBy('hits', 'DESC');
    }

    //kategori home menurut seting
    public function listkategori($kategori_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'                => '1',
                'jenis_berita'          => 'Berita',
                'kategori.kategori_id'  => $kategori_id
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(5, 0)->getResultArray();
    }
    public function listkategori6($kategori_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'                => '1',
                'jenis_berita'          => 'Berita',
                'kategori.kategori_id'  => $kategori_id
            ))
            ->orderBy('berita_id', 'DESC')
            ->get(6, 0)->getResultArray();
    }

    //pencarian

    public function cari1($keywordcari)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->like('judul_berita', $keywordcari)
            ->orlike('nama_kategori', $keywordcari)
            ->orlike('isi', $keywordcari)
            ->where('status', '1')
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }


    //pencarian 2 kondisi
    public function cari($keywordcari, $kategori)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->like('judul_berita', $keywordcari)
            ->orlike('isi', $keywordcari)
            ->like('nama_kategori', $kategori)
            ->where(array(
                'status'        => '1',
                'jenis_berita'  => 'Berita',
                // 'nama_kategori' => $kategori,
            ))
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }


    //pencarian kategori ada keyword tdk

    public function carikat($keywordcari, $kategori)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->like('judul_berita', $keywordcari)
            ->like('nama_kategori', $kategori)
            ->like('isi', $keywordcari)
            ->where(array(
                'status'        => '1',
                'jenis_berita'  => 'Berita',
                'nama_kategori' => $kategori,
            ))
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }

    //pencarian kategori ada keyword ada

    public function carikatkey($keywordcari, $kategori)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->like('judul_berita', $keywordcari)
            ->orlike('isi', $keywordcari)
            ->like('kategori.nama_kategori', $kategori)
            ->where(array(
                'status'        => '1',
                'jenis_berita'  => 'Berita',
                'nama_kategori' => $kategori,
            ))
            ->orderBy('berita_id', 'DESC')
            ->get()->getResultArray();
    }

    //view berita per kategori
    public function kategori($slug_kategori)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where(array(
                'status'                 => '1',
                'jenis_berita'           => 'Berita',
                'kategori.slug_kategori' => $slug_kategori
            ))
            ->orderBy('berita_id', 'DESC');
    }


    //view per TAG
    public function tag($tag_id)
    {
        return $this->table('berita_tag')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->join('berita_tag', 'berita_tag.berita_id = berita.berita_id')
            ->where(array(
                'status'                 => '1',
                'jenis_berita'           => 'Berita',
                'berita_tag.tag_id'      => $tag_id
            ))
            ->orderBy('berita.berita_id', 'DESC');
    }


    // view detail berita
    public function detail_berita($slug_berita)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('slug_berita', $slug_berita)
            ->where('status', '1')
            ->get()->getRow();
    }


    // view detail halaman
    public function detail_halaman($slug_berita)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->where('slug_berita', $slug_berita)
            ->where('status', '1')
            ->get()->getRow();
    }

    public function detail_mod($slug_berita)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->where('slug_berita', $slug_berita)
            ->where('status', '1')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('berita')
            ->where('status', '1')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('berita')
            ->where('status', 0)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }
    // utama

    public function getutama()
    {
        return $this->table('berita')
            ->where('headline', '1')
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonutama()
    {
        return $this->table('berita')
            ->where('headline', 0)
            ->orderBy('id', 'ASC')
            ->get()->getResultArray();
    }
    // add temp news
    public function beritalain($id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->orderBy('berita_id', 'RANDOM')
            ->where('berita.berita_id !=', $id)
            ->get(3, 0)->getResultArray();
    }
    // kategori lain 1
    public function kategorilain13($id, $kategori_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->orderBy('berita_id', 'DESC')
            ->where('berita.kategori_id =', $kategori_id)
            ->where('berita.berita_id !=', $id)
            ->get(3, 0)->getResultArray();
    }

    // kategori lain 2
    public function kategorilain23($id, $kategori_id)
    {
        return $this->table('berita')
            ->join('users', 'users.id = berita.id')
            ->join('kategori', 'kategori.kategori_id = berita.kategori_id')
            ->where('jenis_berita', 'Berita')
            ->orderBy('berita_id', 'DESC')
            ->where('berita.kategori_id =', $kategori_id)
            ->where('berita.berita_id !=', $id)
            ->get(3, 3)->getResultArray();
    }
}
