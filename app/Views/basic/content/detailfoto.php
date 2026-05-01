<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>

<!-- Page-Title -->
<div class="page-title-box ">
    <div class="container-fluid ">

    </div>
</div>
<!-- end page title end breadcrumb -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase">SEMUA FOTO</div>
                            </div>
                        </div>
                        <?php if ($foto) { ?>
                            <div class="row container-grid projects-wrapper">

                                <?php $nomor = 0;
                                foreach ($foto as $data) :
                                    $nomor++;
                                    $pot = substr($data['judul'], 0, 50);
                                ?>

                                    <div class="col-xl-3 col-md-4 col-sm-6 branding designing development">
                                        <div class="gallery-box mt-4">
                                            <a class="gallery-popup" href="<?= base_url('/public/img/galeri/foto/' . $data['gambar']) ?>" title="<?= $data['judul'] ?>">
                                                <!-- <div class="wraper-img-new"> -->
                                                <img class="embed-responsive embed-responsive-16by9 wrapper-img-new" src="<?= base_url('/public/img/galeri/foto/thumb/' . 'thumb_'  . $data['gambar']) ?>" alt="1" />
                                                <!-- </div> -->
                                                <div class="gallery-overlay">
                                                    <div class="overlay-content">
                                                        <h5 class="overlay-title"><?= $data['judul'] ?></h5>
                                                        <p class="text-uppercase mb-0"><?= $data['nama_kategori_foto'] ?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- PAGINATION -->
                            <nav>

                                <P>
                                <ul class="pagination justify-content-center">
                                    <a type="submit" href="<?= base_url('foto') ?>" class="btn btn-info text-light"><i class="fas fa-arrow-left"></i> <b class="text-light">Kembali ke Album Foto</b> </a>

                                </ul>
                                </P>


                            </nav>

                        <?php } else { ?>
                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                <a style='color:red'>Maaf belum ada data..!</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>