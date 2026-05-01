<?php if ($folder == 'plus1') { ?>

    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<?php } ?>

<style>
    #userphoto {
        display: block;
        float: right;
        margin-left: 10px;
        margin-bottom: 8px;
    }

    #userphoto img {
        display: block;
        padding: 2px;
        background: #fff;
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }
</style>
<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <div class="modal-body">

                <!-- <div id='w'> -->
                <div class="p-2">
                    <div id='content' class='clear'>
                        <div id='userphoto'>

                            <img src='<?= base_url('/public/img/informasi/pegawai/' . $gambar) ?>' style='width:154px;height:154px;' alt='default avatar'>
                        </div>

                        <div class="blog-comments">

                            <div class="header">
                                <div class="title"><?= $nama ?></div>
                            </div>
                        </div>

                        <p></p>
                        <!-- Tema Basic -->
                        <?php if ($folder == 'basic') { ?>

                            <!-- Nav tabs -->
                            <!-- <ul class="nav nav-pills nav-justified" role="tablist"> -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#profilb" role="tab">
                                        <span class="d-none d-md-inline-block"> <b class="font-size-16">PROFIL</b></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#publikasib" role="tab">
                                        <span class="d-none d-md-inline-block"> <b class="font-size-16">PUBLIKASI</b></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#penelitianb" role="tab">
                                        <span class="d-none d-md-inline-block"><b class="font-size-16">PENELITIAN</b></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#pengabdianb" role="tab">
                                        <span class="d-none d-md-inline-block"><b class="font-size-16">PENGABDIAN</b></span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="profilb" role="tabpanel">

                                    <div class='card-body'>

                                        <table class='tablex table-sm table-borderless'>
                                            <tbody>
                                                <tr>
                                                    <th width='120px' scope='row'>NIP </th>
                                                    <td>: <?= $nip ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Tempat Tanggal Lahir</th>
                                                    <td>: <?= $tempat_lahir ?>, <?= date_indo($tgl_lahir) ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Jenis Kelamin</th>
                                                    <td>: <?= $jk ==  'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Agama</th>
                                                    <td>: <?= $agama ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Pangkat Golongan</th>
                                                    <td>: <?= $pangkat ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Jabatan</th>
                                                    <td>: <?= $jabatan ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Tupoksi</th>
                                                    <td>: <?php if ($filetupoksi != '') { ?>
                                                            <a href="<?= base_url('/public/img/informasi/pegawai/' . $filetupoksi) ?>" target="_blank">
                                                                <span class="badge badge-success" title="Klik untuk lihat" style="font-size:13px"> Lihat Tupoksi &raquo;
                                                                </span>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane" id="publikasib" role="tabpanel">
                                    <p class="mt-1">
                                        <?= $publikasi ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="penelitianb" role="tabpanel">
                                    <p class="mt-1">
                                        <?= $penelitian ?>
                                    </p>
                                </div>
                                <div class="tab-pane" id="pengabdianb" role="tabpanel">
                                    <p class="mt-1">
                                        <?= $pengabdian ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- tema plus 1 -->
                        <?php if ($folder == 'plus1') { ?>
                            <!-- <ul class="nav nav-pills nav-justified" role="tablist"> -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">
                                        <b class="font-size-16">PROFIL</b></a>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#lainlain" role="tab"> <b class="font-size-16 ">LAIN-LAIN</b></a></a>
                                </li>

                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#publikasi" role="tab"> <b class="font-size-16 ">PUBLIKASI</b></a></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#penelitian" role="tab"> <b class="font-size-16 ">PENELITIAN</b></a></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#pengabdian" role="tab"> <b class="font-size-16 ">PENGABDIAN</b></a></a>
                                </li> -->
                            </ul>

                            <div class="tab-contentX">

                                <div class="tab-pane active" id="profil" role="tabpanel">

                                    <div class='card-body'>

                                        <table class='tablex table-sm table-borderless'>
                                            <tbody>
                                                <tr>
                                                    <th width='120px' scope='row'>NIP </th>
                                                    <td>: <?= $nip ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Tempat Tanggal Lahir</th>
                                                    <td>: <?= $tempat_lahir ?>, <?= date_indo($tgl_lahir) ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Jenis Kelamin</th>
                                                    <td>: <?= $jk ==  'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Agama</th>
                                                    <td>: <?= $agama ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Pangkat Golongan</th>
                                                    <td>: <?= $pangkat ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Jabatan</th>
                                                    <td>: <?= $jabatan ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Tupoksi</th>
                                                    <td>: <?php if ($filetupoksi != '') { ?>
                                                            <a href="<?= base_url('/public/img/informasi/pegawai/' . $filetupoksi) ?>" target="_blank">
                                                                <span class="badge badge-success" title="Klik untuk lihat" style="font-size:13px"> Lihat Tupoksi &raquo;
                                                                </span>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- Tab lain-lain -->
                                <div class="tab-pane" id="lainlain" role="tabpanel">

                                    <div class='card-body'>

                                        <table class='tablex table-sm table-borderless'>
                                            <tbody>
                                                <tr>
                                                    <th width='120px' scope='row'>Asal S1 </th>
                                                    <td>: <?= $asal_s1 ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Asal S2</th>
                                                    <td>: <?= $asal_s2 ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Asal S3</th>
                                                    <td>: <?= $asal_s3 ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Bidang Kepakaran</th>
                                                    <td>: <?= $bidang_pakar ?></td>
                                                </tr>
                                                <tr>
                                                    <th width='160px' scope='row'>Biodata Singkat</th>
                                                    <td>: <?= $bio_singkat ?></td>
                                                </tr>




                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <!-- <div class="tab-pane" id="publikasi" role="tabpanel">
                                    <p>
                                        <?= $publikasi ?>
                                </div>

                                <div class="tab-pane" id="penelitian" role="tabpanel">
                                    <p>
                                        <?= $penelitian ?>
                                </div>

                                <div class="tab-pane" id="pengabdian" role="tabpanel">
                                    <p>
                                        <?= $pengabdian ?>
                                </div> -->

                            </div>

                    </div>
                <?php } ?>
                </div>
                <div class="modal-footer p-0">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
                </div>


            </div>

        </div>

    </div>
</div>
</div>