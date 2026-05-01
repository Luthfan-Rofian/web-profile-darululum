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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase">SEMUA pengumuman</div>
                            </div>
                        </div>
                        <?php if ($pengumuman) { ?>
                            <div class="row">

                                <div class="col-12">
                                    <div class="card-deck">

                                        <?php $nomor = 0;
                                        foreach ($pengumuman as $data) :
                                            $nomor++;
                                            $pot = substr($data['isi_informasi'], 0, 50);
                                        ?>

                                            <div class="col-xl-3 col-md-4 col-sm-6 ">
                                                <img class="card-img-top img-wrap mt-4 pointer" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')" src="<?= base_url('/public/img/informasi/pengumuman/' . $data['gambar']) ?>" height="150" alt="">
                                                <h4 class="card-title font-size-16 mt-2 pointer" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')"><?= $data['nama'] ?></h4>
                                                <p class="card-text"><?= $pot ?>..<small class="text-muted pointer" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')"><i><code>[selengkapnya]</code></i></small></p>
                                                <p class="card-text">
                                                    <small class="text-muted"><i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_informasi']) ?> <i class="far fa-eye"></i>
                                                        <?= $data['hits'] ?></small>
                                                </p>

                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            </div>
                            <!-- end row -->
                            <!-- PAGINATION -->
                            <div class="col-md-12 pt-4">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <?= $pager->links('hal', 'datagoe'); ?>
                                    </ul>
                                </nav>
                                <div class="viewmodal"></div>
                            </div>
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

<?= $this->endSection() ?>