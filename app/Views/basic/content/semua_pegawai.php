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


                                                                foreach ($pegawai as $data) :
                                                            ?>

                                                                    <table class="table table-sm table-bordered table-hover table-striped table-responsive">
                                                                        <tr>
                                                                            <th width="220" rowspan="8">
                                                                                <center>
                                                                                    <?php if ($data['filetupoksi'] != '') { ?>
                                                                                        <a href="<?= base_url('/public/img/informasi/pegawai/' . $data['filetupoksi']) ?>" target="_blank">
                                                                                            <!-- <div class="col-md-3"> -->
                                                                                            <img class="d-inline-block align-top ml-auto mr-1 pointer pt-3 wrapper-img-new" src="<?= base_url('/public/img/informasi/pegawai/' . $data['gambar']) ?>" alt="Profil" width="100%">
                                                                                            <!-- </div> -->
                                                                                        </a>
                                                                                        <div class="text-secondary text-center">
                                                                                            <a href="<?= base_url('/public/img/informasi/pegawai/' . $data['filetupoksi']) ?>" target="_blank">
                                                                                                <div class="d-none d-sm-block btn btn-success btn-sm ml-1 " style="font-size:13px">Lihat Tupoksi &raquo;</div>
                                                                                                <div class="d-block d-sm-none d-inline-block align-top ml-auto mr-1 btn btn-success btn-sm ">Tupoksi</div>
                                                                                            </a>
                                                                                        </div>
                                                                                    <?php } else { ?>
                                                                                        <img class="mt-1 wrapper-img-new" src="<?= base_url('/public/img/informasi/pegawai/' . $data['gambar']) ?>" alt="Profil" width="100%">
                                                                                        <div class="text-secondary text-center">

                                                                                            <div class="d-none d-sm-block btn btn-danger btn-sm ml-1 " style="font-size:13px">Belum ada Tupoksi</div>
                                                                                            <div class="d-block d-sm-none d-inline-block align-top ml-auto mr-1 btn btn-danger btn-sm " title="Belum ada tupoksi">Belum </div>

                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </center>

                                                                                <!-- <img src="<?= base_url('/public/img/informasi/pegawai/' . $data['gambar']) ?>" alt="Profil" class="img-fluid"> -->
                                                                            </th>

                                                                            <th>Nama</th>
                                                                            <th>:</th>
                                                                            <th><?= $data['nama'] ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>NIP</td>
                                                                            <td>:</td>
                                                                            <td><?= $data['nip'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tempat Tanggal Lahir</td>
                                                                            <td>:</td>
                                                                            <td><?= $data['tempat_lahir'] ?>, <?= date_indo($data['tgl_lahir']) ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jenis Kelamin</td>
                                                                            <td>:</td>
                                                                            <td><?= $data['jk'] ==  'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Agama</td>
                                                                            <td>:</td>
                                                                            <td><?= $data['agama'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Pangkat Golongan</td>
                                                                            <td>:</td>
                                                                            <td><?= $data['pangkat'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Jabatan</td>
                                                                            <td width="2">:</td>
                                                                            <td width="50%"><?= $data['jabatan'] ?></td>
                                                                        </tr>

                                                                    </table>
                                                                <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 pt-4">
                                            <nav>
                                                <?php if ($jum > 4) { ?>
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