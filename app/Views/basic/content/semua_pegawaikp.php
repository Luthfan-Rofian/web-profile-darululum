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

                                    <div class="title-konten text-uppercase">data pegawai</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <!-- ISI KONTEN -->
                                    <div class="mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <?php if ($pegawai) {


                                                                $no = 0;
                                                                foreach ($pegawai as $data) :
                                                                    $no++;
                                                            ?>

                                                                    <div class="table p-0 m-0">
                                                                        <ul>
                                                                            <span style="font-size: 13pt; padding:0pt;"><?= $no ?>.
                                                                                <a class="pointer" title="Lihat Detail" onclick="lihatpegawai('<?= $data['pegawai_id'] ?>')"><?= $data['nama'] ?></a>
                                                                            </span>

                                                                        </ul>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 pt-4">
                                            <nav>
                                                <?php if ($jum > 20) { ?>
                                                    <ul class="pagination justify-content-center">
                                                        <?= $pager->links('hal', 'datagoe'); ?>
                                                    </ul>
                                                <?php } ?>
                                            </nav>

                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                            <a style='color:red'>Maaf belum ada data..!</a>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terpopuler</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if ($beritapopuler) {

                                                foreach ($beritapopuler as $data) :
                                            ?>

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
                                            <?php } else { ?>
                                                <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                    <a style='color:red'>Maaf belum ada data..!</a>
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