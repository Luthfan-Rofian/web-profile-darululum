<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>


<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">

    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-5">
                                <div class="col-md-8">
                                    <div class="judul-single-konten">
                                        <?= $berita->judul_berita ?> </div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->
                                    <div class="post-single-konten">
                                        <i class="fas fa-user"></i> <?= $berita->fullname ?> <span class="text-capitalize"></span> |
                                        <i class="fas fa-calendar-alt"></i> <?= date_indo($berita->tgl_berita) ?> |
                                        <i class="fas fa-eye"></i> Dibaca <?= $berita->hits ?> kali
                                    </div>
                                    <hr>
                                    <?php
                                    if ($berita->gambar != 'default.png') { ?>
                                        <img src="<?= base_url('/public/img/informasi/profil/' . $berita->gambar) ?>" width="100%" alt="">
                                        <i><?= $berita->ket_foto ?></i>
                                    <?php }
                                    ?>

                                    <!-- ISI KONTEN -->
                                    <div class="mt-3">
                                        <p><?= $berita->isi ?>
                                        </p>
                                        <?php
                                        if ($berita->filepdf != '') { ?>
                                            <iframe src="<?= base_url('/public/img/informasi/pdf/' . $berita->filepdf) ?>" frameborder="0" width="100%" height="650px"></iframe>
                                        <?php } ?>
                                    </div>

                                    <br>
                                    <hr>

                                </div>
                                <div class="col-md-4">
                                    <div class="row pb-4">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terpopuler</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php $nomor = 0;
                                            foreach ($beritapopuler as $data) :
                                                $nomor++; ?>
                                                <div class="card border-light mb-3">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-3 col-4 wraper-img-side">
                                                            <img class="wraper-img-side" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                        </div>

                                                        <div class="col-md-9 col-8 pl-3">
                                                            <a class="judul-side" href="<?php echo base_url('detail/' . $data['slug_berita']) ?>">
                                                                <div><?= $data['judul_berita'] ?></div>
                                                            </a>
                                                            <div class="post-side pt-2">
                                                                <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                                <i class="fa fa-eye"></i> <?= $data['hits'] ?> Kali
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Info Grafis</div>
                                        </div>
                                    </div>
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <?php $no = 0;
                                            foreach ($infografis as $key => $value) { ?>
                                                <!-- <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li> -->

                                            <?php } ?>
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            <?php $no = 0;
                                            foreach ($infografis as $key => $value) {
                                                $no++
                                            ?>
                                                <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                                    <div class="wraper-info-newx">
                                                        <img class=" pointer" onclick="lihatinfo('<?= $value['id_banner'] ?>')" src="<?= base_url('public/img/informasi/infografis/' .  $value['banner_image']) ?>" width="100%">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>