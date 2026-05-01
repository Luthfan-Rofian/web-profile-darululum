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
                                <div class="title-konten text-uppercase">SEMUA Layanan</div>
                            </div>
                        </div>
                        <?php if ($layanan) { ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php
                                    foreach ($layanan as $data) :

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