<?php
$db = \Config\Database::connect();

?>

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

                                    <div class="title-konten text-uppercase">Produk Hukum</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->

                                        <?php if ($produkhukum) { ?>

                                            <div class="alert alert-info" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                                Informasi mengenai peraturan, keputusan, dan/atau kebijakan yang mengikat dan/atau berdampak bagi publik dapat diunduh pada list dibawah.
                                                Jika data yang dicari tidak ditemukan, Silahkan klik <b class="tambahkritik pointer">disini</b>, untuk lakukan permintaan Informasi.
                                            </div>

                                            <div id="accordion">
                                                <?php foreach ($produkhukum as $data) {
                                                    $produk_id = $data['produk_id'];
                                                ?>
                                                    <div class="cardx">
                                                        <div class="card-header mt-1" id="heading<?= $data['produk_id'] ?>">
                                                            <h6 class="m-0 font-14">
                                                                <a href="#collapse<?= $data['produk_id'] ?>" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $data['produk_id'] ?>">
                                                                    <i class="fa fa-balance-scale"></i> <?= $data['nama_produk']  ?>
                                                                </a>
                                                            </h6>
                                                        </div>

                                                        <div id="collapse<?= $data['produk_id'] ?>" class="collapse showx" aria-labelledby="heading<?= $data['produk_id'] ?>" data-parent="#accordion">
                                                            <div class="card-body p-1" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                                                <!-- Perulangan sub -->
                                                                <?php
                                                                $set = $db->table('produk_kathukum')->where('produk_id', $produk_id)->orderBy('kathukum_id', 'ASC')->get()->getResultArray();

                                                                foreach ($set as $datasub) {
                                                                ?>

                                                                    <ul style="list-style:none;">
                                                                        <?php if ($datasub['file_kathukum'] != '-' && ($datasub['file_kathukum'] != null)) { ?>
                                                                            <li class="mt-1">
                                                                                <a href="<?= base_url('public/unduh/produkhukum/'  . $datasub['file_kathukum']) ?>" title="Download file" target="_blank"><i class="fas fa-file-alt text-primary pointer font-16"></i> <?= $datasub['nama_kathukum'] ?></a>
                                                                            </li>
                                                                        <?php } else { ?>
                                                                            <li class="mt-1"><?= $datasub['nama_kathukum'] ?></li>
                                                                        <?php } ?>

                                                                        <!-- Perulangan subsub -->

                                                                        <?php $set2 = $db->table('produk_subkathukum')->where('produk_subkathukum.kathukum_id', $datasub['kathukum_id'])->orderBy('produk_subkathukum.subkathukum_id', 'ASC')->get()->getResultArray();
                                                                        $no = 0;
                                                                        foreach ($set2 as $datasubsub) {
                                                                            $no++;
                                                                        ?>
                                                                            <li class="mt-1">
                                                                                <a href="<?= base_url('public/unduh/produkhukum/'  . $datasubsub['file_subkathukum']) ?>" title="Download file" target="_blank"> <?= $no ?>. <?= $datasubsub['nama_subkathukum'] ?></a>
                                                                            </li>

                                                                        <?php } ?>

                                                                    </ul>

                                                                <?php } ?>

                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </div>
                                    </div>
                                    <?php if ($jum > 6) { ?>

                                        <P>
                                        <ul class="pagination justify-content-center">
                                            <?= $pager->links('hal', 'datagoe'); ?>
                                        </ul>
                                        </P>

                                    <?php } ?>

                                <?php } else { ?>
                                    <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                        <a style='color:red'>Belum Ada data Produk Hukum.!</a><br> Punya pertanyaan, keluhan, masukan atau saran, silahkan klik <b class="tambahkritik pointer">disini</b>, untuk sampaikan.
                                    </div>
                                <?php } ?>


                                <!-- end konten -->


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