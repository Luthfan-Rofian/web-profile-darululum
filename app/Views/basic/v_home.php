<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content');
$db = \Config\Database::connect();
?>

<!-- Page-Title -->
<div class="page-title-box p-4">
    <div class="container-fluid">
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="container-fluid">
                <div class="card p-0">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php $no = 0;
                            foreach ($banner as $key => $value) { ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li>

                            <?php } ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php $no = 0;
                            foreach ($banner as $key => $value) {
                                $pot = substr($value['link'], 0, 5);
                                if ($pot == 'detai' || $pot == 'page/' || $pot == 'surve') {
                                    $linkbn = base_url($value['link']);
                                } else {
                                    $linkbn = ($value['link']);
                                }
                                $no++
                            ?>
                                <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                    <a href="<?= ($linkbn) ?>" title="<?= ($value['ket']) ?>">
                                        <img class="d-block img-fluid" src="<?= base_url('/public/img/banner/' . $value['banner_image']) ?>" width="100%" alt="First slide">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <?php if ($konfigurasi->sts_rt == '1') { ?>
                        <!-- <div class="header-spacer"></div> -->
                        <div id="pengumumanx" class="pengumuman">
                            <div class="info-dinas-header mr-auto">
                                <span class="re-info">Pengumuman <i class="fas fa-bullhorn text-light"></i></span>
                            </div>
                            <div class="dinas-info">
                                <?php if ($pengumuman) {
                                ?>
                                    <marquee onMouseOver="this.stop()" onMouseOut="this.start()" class="item">
                                        <?php
                                        foreach ($pengumuman as $key => $data) { ?>
                                            <span style="color:#f5f5f5;background:orange;padding:3px 5px;"><?= date_indo($data['tgl_informasi']) ?></span>
                                            <span class="pointer" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')"><?= $data['nama'] ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <?php } ?>
                                    </marquee>
                                <?php  } else { ?>
                                    <a class="text-center">
                                        <span style="color:#f5f5f5;background:orange;padding:3px 5px;">Belum ada Pengumuman..!</span>
                                    </a>
                                <?php } ?>

                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>

            <div class="col-xl-9">
                <?php if ($konfigurasi->sts_count == '1') { ?>
                    <br>
                    <div class="row">
                        <?php if ($counter) {
                            foreach ($counter as $key => $value) {
                        ?>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box" style="background-color:<?= $value['bgc'] ?>;">
                                        <div class="inner">
                                            <h3><span data-purecounter-start="0" data-purecounter-end="<?= $value['jm'] ?>" data-purecounter-duration="1" class="purecounter"></span></h3>
                                            <p><b><?= $value['nm'] ?></b> </p>
                                        </div>
                                        <div class="icon">
                                            <i class="<?= $value['ic'] ?>"></i>
                                        </div>
                                        <a href="<?= $value['link'] ?>" class="small-box-footer"><?= $value['sumber'] ?> </a>
                                    </div>
                                </div>
                                <!-- ./col -->
                        <?php }
                        } ?>
                    </div>

                <?php } ?>

                <div class="card">
                    <div class="card-body p-3">
                        <!-- berita utama -->
                        <div class="box-shadow">
                            <div class="section-heading">

                                <div class="title-konten text-uppercase font-size-18 mb-3">BERITA UTAMA</div>
                            </div>
                        </div>
                        <div id="beritautama" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php $no = 0;
                                foreach ($beritautama as $key => $value) { ?>
                                    <!--<li data-target="#beritautama" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li> -->

                                <?php } ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php $no = 0;
                                foreach ($beritautama as $key => $data) {
                                    $no++;
                                    $opd_id2 = $data['opd_id'];
                                    $viewopd2 = $db->table('custome__opd')->where('opd_id', $opd_id2)->where('opd_id !=', 0)->get()->getRowArray();

                                ?>
                                    <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                        <div class="bg-white rounded">
                                            <div class="px-3 kategori bg-danger">
                                                <div class="text-light"><?= $data['nama_kategori'] ?> </div>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('detail/' . $data['slug_berita']) ?>">
                                            <img class="d-block image1" src="<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?>" width="100%" alt="First slide">
                                        </a>
                                        <div class="ketberita">
                                            <!-- <div class="d-none d-sm-block"> -->
                                            <p class="d-none d-sm-block" style="color:#fff;font-size: 15px;line-height: 1.82;font-weight: 400;">
                                                <!-- </div> -->
                                                <span class="align-top">
                                                    <a href="<?= base_url('detail/' . $data['slug_berita']) ?>" style="color:#EDD212; font-size: 20px; ">
                                                        <?= $data['judul_berita'] ?>
                                                    </a>
                                                    <br>
                                                    <i class="far fa-calendar-alt"></i> <?= longdate_indo($data['tgl_berita']) ?>
                                                    <?php if ($viewopd2) {
                                                        if ($viewopd2['opd_id'] != 0) { ?>
                                                            <i class="far fa-building"></i> <a class="text-light" href="<?= base_url('unit/' . $viewopd2['opd_id'] . '/' . $viewopd2['nama_opd']) ?>"><?= $viewopd2['nama_opd'] ?></a>
                                                    <?php  }
                                                    } ?>
                                                </span>
                                            </p>
                                            <p class="d-block d-sm-none" style="color:#fff;font-size: 10px;line-height: 1.52;font-weight: 400;">
                                                <!-- </div> -->
                                                <span class="align-top p-1">
                                                    <a href="<?= base_url('detail/' . $data['slug_berita']) ?>" style="color:#EDD212; font-size: 12px; ">
                                                        <?= $data['judul_berita'] ?>
                                                    </a>
                                                    <br>
                                                    <i class="far fa-calendar-alt"></i> <?= longdate_indo($data['tgl_berita']) ?>
                                                    <?php if ($viewopd2) {
                                                        if ($viewopd2['opd_id'] != 0) { ?>
                                                            <i class="far fa-building"></i><a href="<?= base_url('unit/' . $viewopd2['opd_id'] . '/' . $viewopd2['singkatan_opd']) ?>"><?= $viewopd2['singkatan_opd'] ?></a>
                                                    <?php  }
                                                    } ?>
                                                </span>
                                            </p>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                            <a class="carousel-control-prev" href="#beritautama" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#beritautama" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <!-- berita pilihan -->

                    </div>

                    <?php if ($konfigurasi->sts_section == '1') { ?>

                        <section id="short-stat" class="short-stat">
                            <div class="title-konten text-uppercase font-size-18 mb-2"><?= $konfigurasi->judul_section ?> </div>
                            <div class="row m-1">

                                <?php foreach ($section as $data) {
                                    $sumber = $data['linksumber'];

                                    if ($sumber == 'N') {
                                        $link = base_url($data['link']);
                                    } else {
                                        $link = $data['link'];
                                    }

                                ?>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 p-2">
                                        <div class="count-box p-1 pointer">
                                            <a href="<?= $link ?>">
                                                <img src="<?= base_url('/public/img/section/' . $data['gambar']) ?>" alt="<?= $data['nama_section'] ?>" title="<?= $data['nama_section'] ?>" width="50" height="50">
                                                &nbsp;<?= $data['nama_section'] ?>
                                            </a>
                                        </div>
                                        <!-- <a href="<?= $link ?>" class="text-secondary"><?= $data['nama_section'] ?> <span><i class="fas fa-chevron-right"></i></span></a> -->
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- </div> -->
                        </section>

                    <?php } ?>
                </div>

                <!-- berita terbaru -->
                <div class="card">
                    <div class="card-body">

                        <!-- INFORMASI INSTANSI (BERITA DLL)-->
                        <div class="row">
                            <div class="col-md-12 pt-2 pb-3">
                                <div class="title-konten text-uppercase">Publikasi</div>
                            </div>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-fill nav-pills" id="myTab" role="tablist">

                                    <li class="nav-item mr-1">
                                        <a class="nav-link active" id="berita-tab" data-toggle="tab" href="#berita" role="tab" aria-controls="berita" aria-selected="true">
                                            <i class="mdi mdi-newspaper-variant-multiple-outline font-size-16 mr-1"></i><b>BERITA TERBARU</b>
                                        </a>
                                    </li>
                                    <?php if ($kategoriaktif) {
                                        foreach ($kategoriaktif as $data) {
                                        } ?>
                                        <li class="nav-item mr-1">
                                            <a class="nav-link tab" id="beritapil-tab" data-toggle="tab" href="#beritapil" role="tab" aria-controls="beritapil" aria-selected="true">
                                                <i class="mdi mdi-newspaper-variant-multiple-outline font-size-16 mr-1"></i><b><?= strtoupper($data['nama_kategori']) ?></b>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item mr-1">
                                        <a class="nav-link tab" id="layanan-tab" data-toggle="tab" href="#layanan" role="tab" aria-controls="layanan" aria-selected="false">
                                            <i class="mdi mdi-teach font-size-16 mr-1"></i><b>LAYANAN</b></a>
                                    </li>
                                    <li class="nav-item mr-1">
                                        <a class="nav-link tab" id="pengumuman-tab" data-toggle="tab" href="#pengumuman" role="tab" aria-controls="pengumuman" aria-selected="false">
                                            <i class="mdi mdi-bullhorn font-size-16 mr-1"></i><b>PENGUMUMAN</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false">
                                            <i class="mdi mdi-timetable font-size-16 mr-1"></i><b>AGENDA</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab" id="bankdata-tab" data-toggle="tab" href="#bankdata" role="tab" aria-controls="bankdata" aria-selected="false">
                                            <i class="mdi mdi-database font-size-16 mr-1"></i><b>BANK DATA</b></a>
                                    </li>


                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <!-- BERITA -->
                                    <div class="tab-pane fade show active" id="berita" role="tabpanel" aria-labelledby="berita-tab">
                                        <div class="row mt-4">

                                            <?php $nomor = 0;
                                            foreach ($berita as $data) : $nomor++;
                                                $opd_id = $data['opd_id'];
                                                $viewopd = $db->table('custome__opd')->where('opd_id', $opd_id)->where('opd_id !=', 0)->get()->getRowArray();


                                            ?>
                                                <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                                    <div class="row">
                                                        <div class="col-md-12 col-4 col-gambar">
                                                            <div class="wraper-img-new">
                                                                <div class="bg-white ">
                                                                    <div class="d-none d-sm-block px-2 kategori bg-warning">
                                                                        <div class="text-primary">
                                                                            <i class="fas fa-folder-open"></i><a href="<?= base_url('category/' . $data['slug_kategori']) ?>"> <?= $data['nama_kategori'] ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <img class="wraper-img-new" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                            </div>
                                                        </div>
                                                        <div class=" col-md-12 col-8 col-isi">
                                                            <div class="posted-new text-secondary" style="font-size: 12px;">
                                                                <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                                <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                <div class="d-block d-sm-none">
                                                                    <i class="fas fa-folder-open"></i><a href="<?= base_url('category/' . $data['slug_kategori']) ?>"> <?= $data['nama_kategori'] ?></a>
                                                                </div>
                                                                <?php if ($viewopd) {
                                                                    if ($viewopd['opd_id'] != 0) { ?>
                                                                        <i class="far fa-building"></i> <a href="<?= base_url('unit/' . $viewopd['opd_id'] . '/' . $viewopd['nama_opd']) ?>"><?= $viewopd['singkatan_opd'] ?></a>
                                                                <?php  }
                                                                } ?>

                                                            </div>
                                                            <!-- <a class="judul-berita-new" style="font-size: 15px;" href="<?= base_url($data['slug_berita']) ?>"> -->
                                                            <a class="judul-berita-new" style="font-size: 15px;" href="<?= base_url('detail/' . $data['slug_berita']) ?>">
                                                                <div><?= $data['judul_berita'] ?></div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('berita') ?>" class="btn btn-primary">Lihat Semua Berita<i class="mdi mdi-arrow-right ml-1"></i> </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BERITA PILIHAN -->
                                    <?php if ($kategoriaktif) { ?>
                                        <div class="tab-pane fade" id="beritapil" role="tabpanel" aria-labelledby="beritapil-tab">
                                            <div class="row mt-4">

                                                <?php $nomor = 0;
                                                foreach ($kategoriaktif as $data) : $nomor++;
                                                    $opd_id = $data['opd_id'];
                                                    $viewopd = $db->table('custome__opd')->where('opd_id', $opd_id)->where('opd_id !=', 0)->get()->getRowArray();


                                                ?>
                                                    <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                                        <div class="row">
                                                            <div class="col-md-12 col-4 col-gambar">
                                                                <div class="wraper-img-new">
                                                                     <div class="bg-white ">
                                                                        <div class="d-none d-sm-block px-2 kategori bg-warning">
                                                                            <div class="text-primary">
                                                                                <i class="fas fa-folder-open"></i><a href="<?= base_url('category/' . $data['slug_kategori']) ?>"> <?= $data['nama_kategori'] ?></a>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                    <img class="wraper-img-new" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-12 col-8 col-isi">
                                                                <div class="posted-new text-secondary" style="font-size: 12px;">
                                                                    <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                                    <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                    <div class="d-block d-sm-none">
                                                                        <i class="fas fa-folder-open"></i><a href="<?= base_url('category/' . $data['slug_kategori']) ?>"> <?= $data['nama_kategori'] ?></a>
                                                                    </div>
                                                                    <?php if ($viewopd) {
                                                                        if ($viewopd['opd_id'] != 0) { ?>
                                                                            <i class="far fa-building"></i> <a href="<?= base_url('unit/' . $viewopd['opd_id'] . '/' . $viewopd['nama_opd']) ?>"><?= $viewopd['singkatan_opd'] ?></a>
                                                                    <?php  }
                                                                    } ?>

                                                                </div>
                                                                <!-- <a class="judul-berita-new" style="font-size: 15px;" href="<?= base_url($data['slug_berita']) ?>"> -->
                                                                <a class="judul-berita-new" style="font-size: 15px;" href="<?= base_url('detail/' . $data['slug_berita']) ?>">
                                                                    <div><?= $data['judul_berita'] ?></div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <div class="col-md-12 text-center mt-3">
                                                    <a href="<?= base_url('category/' . $data['slug_kategori']) ?>" class="btn btn-primary">Lihat Semua <?= $data['nama_kategori'] ?><i class="mdi mdi-arrow-right ml-1"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- LAYANAN -->
                                    <div class="tab-pane fade" id="layanan" role="tabpanel" aria-labelledby="layanan-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($layanan as $data) :
                                                    $nomor++;
                                                    $pot = substr($data['isi_informasi'], 0, 20);

                                                ?>
                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action " onclick="lihatlayanan('<?= $data['informasi_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fas fa-chalkboard-teacher float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama'] ?></div>
                                                                        <div class="list-posted">

                                                                            <i class="fas fa-user-alt"></i> <?= $data['fullname'] ?> |
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_informasi']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('layanan') ?>" class="btn btn-primary">Lihat Semua Layanan<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PENGUMUMAN -->
                                    <div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($pengumuman as $data) :
                                                    $nomor++; ?>
                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fa fa-bullhorn float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_informasi']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('pengumuman') ?>" class="btn btn-primary">Lihat Semua Pengumuman<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AGENDA -->
                                    <div class="tab-pane fade" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($agenda as $data) :
                                                    $nomor++; ?>

                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action pointer">
                                                            <div class="row no-gutters" onclick="lihatagenda('<?= $data['agenda_id'] ?>')">
                                                                <div class="media">
                                                                    <i class="far fa-calendar-check float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"> <?= $data['tema'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                            Dari : <?= date_indo($data['tgl_mulai']) ?> -
                                                                            Sampai : <?= date_indo($data['tgl_selesai']) ?>
                                                                            <i class="fas fa-map-marker-alt"></i>
                                                                            <?= $data['tempat'] ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('agenda') ?>" class="btn btn-primary">Lihat Semua Agenda<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BANK DATA -->
                                    <div class="tab-pane fade" id="bankdata" role="tabpanel" aria-labelledby="bankdata-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($bankdata as $data) :
                                                    $nomor++; ?>
                                                    <div class="list-group mt-2">
                                                        <a target="_BLANK" href="<?= base_url('public/unduh/bankdata/'  . $data['fileupload']) ?>" class="list-group-item list-group-item-action" onclick="updatehits('<?= $data['bankdata_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fa fa-database float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama_bankdata'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_upload']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('bankdata') ?>" class="btn btn-primary">Lihat Semua Data<i class="mdi mdi-arrow-right ml-1"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end berita -->
            </div>
            <!-- side kanan -->
            <div class="col-xl-3">

                <!-- sambutan -->
                <?php if ($konfigurasi->sts_sambutan == '1') { ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="title-konten text-uppercase font-size-18 mb-2"><?= $konfigurasi->jabatan_pimpinan ?> </div>

                            <div class="single-sidebar-widget pointer" data-toggle="modal" data-target="#modalViewsambutan">
                                <div class="text-center">
                                    <a rel="nofollow"><img class="img-thumbnail" src="<?= base_url('/public/img/konfigurasi/pimpinan/' . $konfigurasi->gbr_sambutan) ?>" title="Baca sambutan <?= $konfigurasi->jabatan_pimpinan ?>"></a>
                                </div>
                                <div class="text-center">

                                    <button type="submit" class="btn btn-light btn-sm text-uppercase mt-1" data-toggle="modal" data-target="#modalViewsambutan" title="Baca Sambutan <?= $konfigurasi->jabatan_pimpinan ?>">
                                        - <?= $konfigurasi->nama_pimpinan ?> -

                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>

                <!-- pol isi -->
                <?php if (get_cookie("poling") != 'isipoling') { ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="title-konten text-uppercase font-size-18 mb-2">Jajak Pendapat </div>

                            <?php if ($polsts == "Y") { ?>

                                <div class="text-left text-primary">
                                    <b><?= $poltanya ?></b>

                                    <hr>
                                    <?= form_open_multipart('', ['class' => 'formtambah']) ?>
                                    <?= csrf_field();

                                    foreach ($poljawab as $p) :

                                        echo "<input type=radio name=poling_id id=poling_id value='$p[poling_id]' />
					                     <class style=\"color:#666;font-size:14px; padding:2px required\">&nbsp;&nbsp;$p[pilihan]<br />
                                         <div class='invalid-feedback errorpoling_id'></div>";

                                    endforeach;
                                    echo "<br><center><input style='width: 110px; padding:2px; font-size:12px;' type=submit class='btn btn-primary btnsimpan' value='PILIH' />
		                     </form>
		                     <a>
                                      
                             <input style='width: 110px; padding:2px; font-size:12px;'  type=button class='btn btn-info btnlihatpoling' value='LIHAT HASIL' /></a></center>";
                                    ?>
                                </div>

                            <?php } else { ?>
                                <div class="text-center text-danger">
                                    Jajak Pendapat telah ditutup..!
                                </div>
                            <?php  } ?>

                        </div>
                    </div>
                <?php } ?>
                <!-- isi pol end -->

                <!-- hasil pol -->
                <?php if (get_cookie("poling") == 'isipoling') { ?>
                    <!-- <div class="col-xl-3"> -->
                    <div class="card">
                        <div class="card-body">
                            <div class="title-konten text-uppercase font-size-18 mb-2">Hasil Jajak Pendapat </div>

                            <?php if ($polsts == "Y") { ?>

                                <div class="text-left text-primary">
                                    <b><?= $poltanya ?></b>

                                    <hr>
                                    <?php foreach ($poljawab as $p) :
                                        $prosentase = sprintf("%2.1f", (($p['rating'] / $jumpol) * 100));
                                    ?>
                                        <div class="text-muted mb-1"><?= $p['pilihan'] ?> <a class="text-danger" style="font-size: 12px;">(<?= $p['rating'] ?>)</a>
                                            <div class="progress mb-2" style="height: 21px" title="<?= $prosentase ?> %">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: <?= $prosentase ?>%" aria-valuenow="<?= $prosentase ?>" aria-valuemin="0" aria-valuemax="100"><a class="text-light" style="font-size: 12px;"><?= $prosentase ?> %</a></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <label class="text-dark">TOTAL RESPONDEN : </label> <a class="text-danger"><?= $jumpol ?></a>
                                    <div class="progress mb-2" style="height: 20px">
                                        <div class="progress-bar progress-bar progress-bar-animated bg-secondary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><a class="text-light" style="font-size: 12px;"> <?= $jumpol ?></a></div>
                                    </div>
                                </div>

                            <?php } else { ?>
                                <div class="text-center text-danger">
                                    Jajak Pendapat telah ditutup..!
                                </div>
                            <?php  } ?>

                        </div>
                    </div>

                <?php } ?>
                <!-- hasil pol end -->
                <!-- Side info Grafis  -->
                <!-- Video -->
                <div class="card p-1">
                    <div class="card-body mb-1">
                        <div class="title-konten text-uppercase font-size-18 mb-3">Video</div>
                        <div id="carouselExampleIndicators" class="carousel slide pb-0" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php $no = 0;
                                foreach ($video4 as $key => $value) { ?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li>

                                <?php } ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php $no = 0;
                                foreach ($video4 as $key => $value) {
                                    $no++
                                ?>
                                    <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">

                                        <iframe width="100%" height="" src="https://www.youtube.com/embed/<?= $value['video_link'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="true"></iframe>


                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <a href="<?= base_url('video') ?>" class="btn btn-primary btn-sm">Lihat Semua Video<i class="mdi mdi-arrow-right ml-1"></i></a>

                        </div>
                    </div>
                </div>
                <!-- end video -->

                <!-- <p> -->

                <!-- Side Link terkait -->
                <div class="card">
                    <div class="card-body">
                        <div class="title-konten text-uppercase font-size-18 mb-3">Info Grafis</div>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php $no = 0;
                                foreach ($infografis as $key => $value) { ?>
                                     <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li> 

                                <?php } ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php $no = 0;
                                foreach ($infografis as $key => $value) {
                                    $no++
                                ?>
                                    <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                        <div class=" wraper-info-new">
                                            <img class="img-thumbnail pointer" onclick="lihatinfo('<?= $value['id_banner'] ?>')" src="<?= base_url('public/img/informasi/infografis/' .  $value['banner_image']) ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- side kantor kami -->
                <div class="card">
                    <div class="card-body">
                        <div class="title-konten text-uppercase font-size-18 mb-3">Kantor Kami</div>
                        <div>
                            <style type="text/css" media="screen">
                                iframe {
                                    height: 200px;
                                    width: 100%;
                                }
                            </style>
                            <?= $konfigurasi->google_map ?>
                        </div>

                    </div>
                </div>


            </div>

        </div>

    </div>

    <!-- end container -->

    <div id="sinergi" class="sinergi">
        <!-- <div class="container-fluid p-0"> -->
        <div class="owl-carousel sinergi-carousel mb-0">
            <?php foreach ($linkterkaitall as $data) { ?>
                <div class="sinergi-logo">
                    <a href="<?= $data['url'] ?>" target="_blank">
                        <img src="<?= base_url('public/img/linkterkait/' . $data['gambar']) ?>" class="img-fluid" alt="" data-aos="flip-right" title="<?= $data['nama_link'] ?>">
                    </a>
                </div>
            <?php } ?>
        </div>
        <!-- </div> -->
    </div>

</div>

<!-- end page content -->

<div class="modal fade in" tabindex="-1" role="dialog" id="modalViewsambutan">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Sambutan
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <div class="modal-body">
                <div class="card-body p-0">
                    <p style="text-align:justify; "><img src="<?= base_url('/public/img/konfigurasi/pimpinan/' . $konfigurasi->gbr_sambutan) ?>" style="float:left; padding: 8px;" height="180" class="img" /> <?= $konfigurasi->sambutan ?></p>
                </div>
                <div class="modal-footer p-0">
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Ok</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
if ($konfigurasi->sts_modal == '1') { ?>

    <script>
        $(document).ready(function() {
            penawaran();
        });
    </script>

<?php } ?>

<body>
    <!-- Responsive Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<!-- website -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="4179913036"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Fluid Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-fn-4b+iq+4b-1n8"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="1510351813"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- In-Article Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="3747538890"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Auto Relaxed Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="6573012789"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Additional Ad Container for CPM Rate -->
    <div id="container-782552c8aaf40cabfea318ea6a0232c3"></div>
</body>

<head>
    <!-- Additional Ad Container for CPM Rate -->
    <div id="container-782552c8aaf40cabfea318ea6a0232c3"></div>

<script async src="https://fundingchoicesmessages.google.com/i/pub-3334542440404059?ers=1"></script><script>(function() {function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.style.display = 'none'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>

</body>
<body>
    <head>
        <meta name="google-site-verification" content="n9kbMSa5rZD8grQJI0na5xwpAUYfBdx3m0ZxPpoVJUg" />
    </head>
</body>


<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('poling/ubahpoling') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        Swal.fire({
                            title: "Maaf..!",
                            html: `Silahkan pilih salah satu jawaban diatas. `,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3550
                        });

                    }
                    if (response.gagal) {

                        Swal.fire({
                            title: "Maaf..!",
                            text: response.gagal,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3550
                        });

                    }
                    if (response.sukses) {

                        Swal.fire({
                            title: "Sukses!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 3550
                        }).then(function() {

                            window.location = '<?= base_url('') ?>';
                        });
                    }

                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    });
                }
            });
        });

    });
</script>

<?= $this->endSection() ?>