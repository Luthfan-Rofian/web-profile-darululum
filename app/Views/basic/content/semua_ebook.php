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

                                    <div class="title-konten text-uppercase">Data Ebook</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->

                                        <?php if ($ebook) { ?>
                                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="berita-tab">
                                                <div class="row mt-4">

                                                    <?php $nomor = 0;
                                                    foreach ($ebook as $data) :
                                                        $nomor++; ?>
                                                        <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                                            <div class="row">
                                                                <div class="col-md-12 col-4 col-gambar">
                                                                    <div class="wraper-img-new">
                                                                        <a href="<?= base_url('bacabuku/' . $data['fileebook']) ?>" target="_blank" onclick="updatehit('<?= $data['ebook_id'] ?>')" title=" Jumlah Halaman <?= $data['j_hal'] ?>, Kategori <?= $data['kategoriebook_nama'] ?>">
                                                                            <img class="wraper-img-new" src=<?= base_url('/public/img/ebook/' . $data['gambar']) ?> ;>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-12 col-8 col-isi">
                                                                    <div class="posted-new">
                                                                        <i class="far fa-calendar-alt"></i> <?= date_indo($data['tanggal']) ?> |
                                                                        <i class="far fa-eye"></i> <?= $data['hits'] ?>x |
                                                                        <i class="fab fa-searchengin"></i> <a class="cate pointer" onclick="lihatbook('<?= $data['ebook_id'] ?>','<?= $data['kategoriebook_nama'] ?>')">Detail</a>

                                                                    </div>
                                                                    <a href="<?= base_url('bacabuku/' . $data['fileebook']) ?>" target="_blank" onclick="updatehit('<?= $data['ebook_id'] ?>')"><?= $data['judul'] ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
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
                                    </div>
                                </div>

                                <!-- end konten -->


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