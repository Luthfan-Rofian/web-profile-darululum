<?= $this->extend('/admin/template-backend');

$db = \Config\Database::connect();

$userid  = session()->get('id');
$id_grup = session()->get('id_grup');

// $set  = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
$list = $db->table('users')->where('id', $userid)->get()->getRowArray();

use App\Models\ModelBerita;
use App\Models\M_Dge_grupakses;
use App\Models\ModelKritikSaran;
use App\Models\ModelBeritaKomen;

$this->setnewdata = new ModelBerita();
$this->grupakses = new M_Dge_grupakses();
$jum = $this->setnewdata->totberitanew();
$this->komen = new ModelBeritaKomen();
$this->kritik = new ModelKritikSaran();
$totkritik     = $this->kritik->totkritik();
$totkomen      = $this->komen->totkomen();
$listgrupakses =  $this->grupakses->listgrupaksesmenu($id_grup);

?>


<?= $this->section('nav') ?>

<ul class="navbar-right d-flex list-inline float-right mb-0">

    <li class="dropdown notification-list">
        <?php if ($totkritik != 0) { ?>
            <div class="viewdata2"></div>
        <?php } else { ?>
            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-comment-text-multiple noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm">
                <!-- item-->
                <h6 class="dropdown-item-text">
                    Masukan Saran
                </h6>
                <div class="notification-item-list">
                    <p>
                        <a class="dropdown-item text-center text-danger"> Tidak ada Masukan Saran Baru </a>
                    </p>
                </div>
                <!-- All-->
                <a href="<?= base_url('kritiksaran/list') ?>" class="dropdown-item text-center text-primary">
                    <strong>Lihat Masukan Saran</strong> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        <?php  } ?>
    </li>

    <li class="dropdown notification-list">
        <?php if ($totkomen != 0) { ?>
            <div class="viewdatakomen"></div>
        <?php } else { ?>
            <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-bell noti-icon noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-sm">
                <!-- item-->
                <h6 class="dropdown-item-text">
                    Ruang Aspirasi dan Opini Publik.
                </h6>
                <div class="notification-item-list">
                    <p>
                        <a class="dropdown-item text-center text-danger"> Data tidak ditemukan. </a>
                    </p>

                </div>
                <!-- All-->
                <a href="<?= base_url('berita/listkomen') ?>" class="dropdown-item text-center text-primary">
                    <strong>Lihat Komentar Berita</strong> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        <?php } ?>
    </li>

    <li class="dropdown notification-list">
        <div class="dropdown notification-list nav-pro-img">

            <?php
            if ($list['user_image'] != 'default.png' && file_exists('public/img/user/' . $list['user_image'])) {
                $profil = $list['user_image'];
            } else {
                $profil = 'default.png';
            }
            ?>

            <a class="dropdown-toggle nav-link arrow-none waves-effect nav-user waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="<?= base_url('/public/img/user/' . $profil) ?>" alt="user" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <a class="dropdown-item" href="<?= base_url('akun') ?>"><i class="mdi mdi-account-circle m-r-5"></i> Akun </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" id="logout"><i class="mdi mdi-power text-danger"></i> Keluar</a>
            </div>
        </div>
    </li>
</ul>
<ul class="list-inline menu-left p-0 ">
    <li class="float-left">
        <button class="button-menu-mobile open-left waves-effect waves-light" style="background-color:#006316">
            <i class="fas fa-bars"></i>
        </button>
    </li>
    <div class="row">
        <li class="d-none d-sm-block">
            <div class="dropdown pt-3 d-inline-block">
                <a class="btn btn-light waves-effect waves-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Buat Baru
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item tambahberita" href="<?= base_url('berita/all') ?>">Berita</a>
                    <?php
                    $gm1 = 'Setkonten';
                    $listgruphal =  $this->grupakses->grupaksessubmenu($id_grup, $gm1);
                    foreach ($listgruphal as $datahal) :
                        $akseshal = $datahal['akses'];
                        $linkurlhal = $datahal['urlmenu'];;
                        if ($linkurlhal == 'halaman') { ?>
                            <?php if ($akseshal == 1) { ?>
                                <a class="dropdown-item tambahhalaman" href="<?= base_url('halaman') ?>">Halaman</a>
                    <?php }
                        }
                    endforeach;
                    ?>

                    <a class="dropdown-item tambahvideo" href="<?= base_url('video/all') ?>">Video</a>
                    <a class="dropdown-item tambahpengumuman" href="<?= base_url('pengumuman/all') ?>">Pengumuman</a>

                </div>
            </div>
        </li>
        <li class="d-none d-sm-block">
            <div class="dropdown pt-3 d-inline-block ml-2">
                <a class="btn btn-light waves-effect waves-light" href="<?= base_url() ?>" target=_blank alt="Kunjungi Situs">
                    Kunjungi Situs
                </a>

            </div>
        </li>
    </div>
</ul>

<?= $this->endSection('nav') ?>

<?= $this->section('menu') ?>

<li class="bg-light">
    <a href="<?= base_url('dashboard') ?>" class="waves-effect">
        <i class="fas fa-home"></i><span class="badge badge-primary float-right">Dashboard</span> <span>BERANDA </span>
    </a>
</li>

 <li class="menu-title"><b> Kelola Modul</b></li>

<?php
foreach ($listgrupakses as $data) :

    $aksesmenu = $data['aksesmenu'];
    $namamenu = $data['modul'];
    $gm = $data['gm'];
    if ($aksesmenu = 1) {

?>
        <?php if ($gm == 'Pengaturan') {
        ?>
            <li class="menu-title "><b> Pengaturan Situs</b></li>
        <?php } ?>

        <li>
            <a href="javascript:void(0);" class="waves-effect dropdown-item"><i class="<?= $data['ikonmn'] ?>" style="font-size:20px"></i> <span> <?= $namamenu ?> <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span> </a>
            <ul class="submenu">

                <?php
                $listgrupf =  $this->grupakses->grupaksessubmenu($id_grup, $gm);
                foreach ($listgrupf as $datacek) :
                    $akses = $datacek['akses'];
                    $linkurl = $datacek['urlmenu'];

                    if ($akses != 3) { ?>

                        <?php if ($linkurl == 'berita/all') { ?>
                            <li>
                                <a href="<?= base_url($datacek['urlmenu']) ?>" class="dropdown-item"><i class="<?= $datacek['ikonmn'] ?>"></i>
                                    <?php if ($akses == 1) {
                                        if ($jum != '0') { ?>
                                            <span class="badge badge-danger float-right" title="Jumlah berita yang menunggu verifikasi"><?= $jum ?></span>
                                    <?php }
                                    }
                                    ?> <?= $datacek['modul'] ?>
                                </a>
                            </li>
                        <?php } else {
                        ?>
                            <li><a href="<?= base_url($datacek['urlmenu']) ?>" class="dropdown-item"><i class="<?= $datacek['ikonmn'] ?>"></i> <?= $datacek['modul'] ?></a></li>
                        <?php } ?>
                <?php }
                endforeach;
                ?>

            </ul>
        </li>
        <!--    end menu -->
<?php
    }
endforeach; ?>

<li>
    <a class="dropdown-item text-danger" href="#" id="logout"><i class="fas fa-power-off text-danger"></i> <span><b>KELUAR</b> </span></a>
</li>

<?= $this->endSection('menu') ?>
