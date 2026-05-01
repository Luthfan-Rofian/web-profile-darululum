<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content');
$db = \Config\Database::connect();
?>

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
                                <?php foreach ($berita as $datakat) {
                                } ?>
                                <div class="title-konten text-uppercase">SEMUA <?= $datakat['nama_kategori'] ?></div>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="berita-tab">
                            <div class="row mt-4">

                                <?php $nomor = 0;
                                foreach ($berita as $data) :
                                    $nomor++;

                                    $opd_id2 = $data['opd_id'];
                                    $viewopd2 = $db->table('custome__opd')->where('opd_id', $opd_id2)->where('opd_id !=', 0)->get()->getRowArray();

                                ?>

                                    <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                        <div class="row">
                                            <div class="col-md-12 col-4 col-gambar">
                                                <div class="wraper-img-new">
                                                    <img class="wraper-img-new" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                </div>
                                            </div>
                                            <div class=" col-md-12 col-8 col-isi">
                                                <div class="posted-new">
                                                    <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                    <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                    <?php if ($viewopd2) {
                                                        if ($viewopd2['opd_id'] != 0) { ?>
                                                            | <i class=" far fa-building"></i> <a href="<?= base_url('unit/' . $viewopd2['opd_id'] . '/' . $viewopd2['nama_opd']) ?>"><?= $viewopd2['nama_opd'] ?></a>
                                                    <?php  }
                                                    } ?>
                                                    <!-- <i class="fas fa-folder-open"></i> <?= $data['nama_kategori'] ?> -->
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

                                <?php if ($jum > 6) { ?>
                                    <P>

                                    <ul class="pagination justify-content-center">
                                        <?= $pager->links('hal', 'datagoe'); ?>
                                    </ul>
                                    </P>
                                <?php } ?>


                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>