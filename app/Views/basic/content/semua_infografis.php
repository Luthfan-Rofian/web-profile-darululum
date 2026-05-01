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

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">

                                    <div class="title-konten text-uppercase">Data Infografis</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->

                                        <?php if ($infografis) { ?>
                                            <div class="row container-grid projects-wrapper">

                                                <?php
                                                foreach ($infografis as $data) :
                                                ?>

                                                    <div class="col-xl-4 col-md-4 col-sm-4 branding designing development">
                                                        <div class="gallery-box mt-4">
                                                            <a class="gallery-popup" href="<?= base_url('public/img/informasi/infografis/' .  $data['banner_image']) ?>" title="<?= $data['ket'] ?>">
                                                                <!-- <div class="wraper-img-new"> -->
                                                                <img class="embed-responsive embed-responsive-16by9 wrapper-img-new" src="<?= base_url('/public/img/informasi/infografis/thumb/' . 'thumb_'  . $data['banner_image']) ?>" alt="<?= $data['ket'] ?>" />
                                                                <!-- </div> -->
                                                                <div class="gallery-overlay">
                                                                    <div class="overlay-content">
                                                                        <h5 class="overlay-title"><?= $data['ket'] ?></h5>

                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <!-- PAGINATION -->
                                            <div class="col-md-12 pt-4">
                                                <nav>
                                                    <?php if ($jum > 6) { ?>
                                                        <P>
                                                        <ul class="pagination justify-content-center">
                                                            <?= $pager->links('hal', 'datagoe'); ?>
                                                        </ul>
                                                        </P>
                                                    <?php } ?>
                                                </nav>

                                            </div>

                                        <?php } else { ?>
                                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                <a style='color:red'>Maaf belum ada data..!</a>
                                            </div>
                                        <?php } ?>


                                        <!-- end konten -->
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terkini</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php $nomor = 0;
                                            foreach ($beritaterkini as $data) :
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