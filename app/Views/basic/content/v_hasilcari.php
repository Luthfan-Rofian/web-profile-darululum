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

                <div class="card">
                    <div class="card-body">

                        <!-- ISI BERITA -->

                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($berita) { ?>
                                    <div class="title-konten text-uppercase">Hasil Pencarian dari : <a class="text-danger"> <?= esc($keyword) ?></a></div>
                                <?php  } else { ?>
                                    <div class="title-konten text-uppercase">Hasil Pencarian</div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="berita-tab">
                            <?php if ($berita) { ?>
                                <div class="row mt-4">

                                    <?php $nomor = 0;
                                    foreach ($berita as $data) :
                                        $nomor++; ?>
                                        <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                            <div class="row">
                                                <div class="col-md-12 col-4 col-gambar">
                                                    <div class="wraper-img-new">
                                                        <?php if ($data['jenis_berita'] == "Berita") { ?>
                                                            <img class="wraper-img-new" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                        <?php  } else { ?>
                                                            <img class="wraper-img-new" src=<?= base_url('/public/img/informasi/profil/' . $data['gambar']) ?> ;>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class=" col-md-12 col-8 col-isi">
                                                    <div class="posted-new">
                                                        <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                        <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                        <?php if ($data['jenis_berita'] == "Berita") { ?>
                                                            | <i class="fas fa-folder-open"></i><a href="<?= base_url('category/' . $data['slug_kategori']) ?>"> <?= $data['nama_kategori'] ?></a>

                                                        <?php } ?>
                                                    </div>
                                                    <a class="judul-berita-new" href="<?php echo base_url('detail/' . $data['slug_berita']) ?>">
                                                        <div><?= $data['judul_berita'] ?></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                        </div>
                        <!-- PAGINATION -->
                        <div class="col-md-12 pt-4">
                            <nav>
                                <ul class="pagination justify-content-center">

                                </ul>
                            </nav>
                        </div>
                    <?php  } else { ?>

                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="mt-3 text-center">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 col-6">
                                            <img src="<?= base_url('/public/temp-frontend/assets/images/error-img.png') ?>" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                    <h5>Maaf keyword <b class="text-danger"><?= esc($keyword) ?> </b> tidak ditemukan..!!</h5>
                                    <div class="mt-3">
                                        <a class="btn btn-success waves-effect waves-light" href="<?= base_url('') ?>">Kembali ke Beranda</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>