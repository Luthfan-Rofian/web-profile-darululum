<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


// use App\Models\M_Cust_anggota;
use App\Models\M_Dge_grupakses;
use App\Models\M_Dge_grupuser;
use App\Models\M_Dge_modul;
use App\Models\M_Dge_modulpublic;
use App\Models\M_Dokumen;
use App\Models\M_Dokumenkat;
use App\Models\M_Fasilitas;
use App\Models\M_FasilitasDetail;
use App\Models\M_Produk;
use App\Models\M_Unitkerja;
use App\Models\M_Unitkerjatipe;


use App\Models\ModelAgenda;
use App\Models\ModelBankData;
use App\Models\ModelBanner;
use App\Models\ModelKonfigurasi;
use App\Models\ModelUser;
use App\Models\ModelBerita;
use App\Models\ModelBeritaKomen;
use App\Models\ModelBeritaTag;
use App\Models\ModelBtBidang;
use App\Models\ModelBukutamu;
use App\Models\ModelCounter;
use App\Models\ModelEbook;
use App\Models\ModelFaq_Jawab;
use App\Models\ModelFaq_Tanya;
use App\Models\ModelFoto;
use App\Models\ModelInformasi;
use App\Models\ModelKategori;
use App\Models\ModelKategoriEbook;
use App\Models\ModelKategoriFoto;
use App\Models\ModelKategoriVideo;
use App\Models\ModelKritikSaran;
use App\Models\ModelLinkTerkait;
use App\Models\ModelMenu;
use App\Models\ModelModalPop;
use App\Models\ModelPegawai;
use App\Models\ModelPoling;
use App\Models\ModelProdukHukum;
use App\Models\ModelProdukKatHukum;
use App\Models\ModelProdukKatSubHukum;
use App\Models\ModelSection;
use App\Models\ModelSubMenu;
use App\Models\ModelSubsubMenu;
use App\Models\ModelSurveyJawaban;
use App\Models\ModelSurveyPertanyaan;
use App\Models\ModelSurveyResponden;
use App\Models\ModelSurveyTopik;
use App\Models\ModelTag;
use App\Models\ModelTemplate;
use App\Models\ModelTransparan;
use App\Models\ModelTransparanDetail;
use App\Models\ModelVideo;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'Tgl_indo', 'cookie', 'dge'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        // Custome module
        $this->unitkerja = new M_Unitkerja();
        $this->unitkerjatipe = new M_Unitkerjatipe();
        $this->dokumen = new M_Dokumen();
        $this->dokumenkat = new M_Dokumenkat();
        $this->produk = new M_Produk();

        // pengaturan hak akses
        $this->modulecms = new M_Dge_modul();
        $this->grupuser = new M_Dge_grupuser();
        $this->grupakses = new M_Dge_grupakses();
        $this->modulpublic = new M_Dge_modulpublic();

        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();

        $this->konfigurasi = new ModelKonfigurasi();
        $this->email = \Config\Services::email();

        $this->banner = new ModelBanner();
        $this->user = new ModelUser();
        $this->berita = new ModelBerita();
        $this->kategori = new ModelKategori();
        $this->infografis = new ModelBanner();
        $this->profil = new ModelBerita();
        $this->pegawai = new ModelPegawai();
        $this->linkterkait = new ModelLinkTerkait();
        $this->agenda = new ModelAgenda();
        $this->layanan = new ModelInformasi();
        $this->pengumuman = new ModelInformasi();
        $this->bankdata = new ModelBankData();
        $this->kategorifoto = new ModelKategoriFoto();
        $this->foto = new ModelFoto();
        $this->video = new ModelVideo();
        $this->kritiksaran = new ModelKritikSaran();

        $this->poling = new ModelPoling();
        $this->menu = new ModelMenu();
        $this->submenu = new ModelSubMenu();
        $this->subsubmenu = new ModelSubsubMenu();
        $this->section = new ModelSection();
        $this->ebook = new ModelEbook();
        $this->kategoriebook = new ModelKategoriEbook();
        $this->produkhukum = new ModelProdukHukum();
        $this->produkkathukum = new ModelProdukKatHukum();
        $this->produkkatsubhukum = new ModelProdukKatSubHukum();
        $this->surveytopik = new ModelSurveyTopik();
        $this->pertanyaan = new ModelSurveyPertanyaan();
        $this->jawaban = new ModelSurveyJawaban();
        $this->responden = new ModelSurveyResponden();
        // buku tamu
        $this->bidang = new ModelBtBidang();
        $this->bukutamu = new ModelBukutamu();
        $this->template = new ModelTemplate();
        $this->counter = new ModelCounter();
        $this->kategorivideo = new ModelKategoriVideo();
        $this->tag = new ModelTag();
        $this->beritatag = new ModelBeritaTag();
        $this->beritakomen = new ModelBeritaKomen();
        $this->faqtanya = new ModelFaq_Tanya();
        $this->faqjawab = new ModelFaq_Jawab();
        $this->modalpopup = new ModelModalPop();
        $this->transparandetail = new ModelTransparanDetail();
        $this->transparan = new ModelTransparan();
        $this->fasilitas = new M_Fasilitas();
        $this->fasilitasdetail = new M_FasilitasDetail();
        // custome
        // $this->anggota = new M_Cust_anggota();
    }
}
