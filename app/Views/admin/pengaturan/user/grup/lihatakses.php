<?php

use App\Models\M_Dge_grupakses;

$this->grupakses = new M_Dge_grupakses();
?>
<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Lihat Akses <?= $nama_grup ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formeditgrp']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">
                <input type="hidden" value="<?= $id_grup ?>" name="id_grup">
                <input type="hidden" class="form-control form-control-sm" id="nama_grup" name="nama_grup" value="<?= $nama_grup ?>" readonly>
                <div id="accordion">
                    <?php $no = 0;
                    foreach ($modul as $data) :
                        $no++;
                        $gm = $data['gm'];
                    ?>
                        <div class="card mb-1">
                            <div class="card-header p-2" style="background-color:#ADD8E6" id="heading<?= $no ?>">
                                <h6 class="m-0 font-14">
                                    <a href="#collapse<?= $no ?>" class="text-secondary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $no ?>">
                                        <?= strtoupper($data['gm']) ?>
                                    </a>
                                    <div class="float-right m-0">
                                        <a href="#collapse<?= $no ?>" class="text-secondary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $no ?>">
                                            <i class="fas fa-angle-down"></i>
                                        </a>
                                    </div>
                                </h6>
                            </div>

                            <div id="collapse<?= $no ?>" class="collapse show" aria-labelledby="heading<?= $no ?>" data-parent="#accordion">
                                <div class="card-body p-0">
                                    <?php $listmodul =  $this->grupakses->listgrupaksesedit($id_grup, $gm); ?>
                                    <!-- Detailnya -->
                                    <div class="table-responsive p-1 mb-0">
                                        <table class="table dataTable table-hover">
                                            <thead class="bg-light p-0 m-0">
                                                <tr>

                                                    <th class="text-center p-1">#</th>
                                                    <th class="p-1">NAMA MODUL</th>
                                                    <th class="text-center p-1">HAK AKSES</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomor = 0;
                                                foreach ($listmodul as $data) :
                                                    $nomor++; ?>
                                                    <tr class="p-0">
                                                        <td class="text-center p-1">
                                                            <?= $nomor ?>.</td>
                                                        <td class="p-1">

                                                            <?php if ($data['akses'] == '1') { ?>

                                                                <?php if ($data['gm'] == '-') { ?>
                                                                    <a class="text-success"> => <?= esc($data['modul']) ?></a>
                                                                <?php   } else { ?>
                                                                    <a class="text-success"><?= esc($data['modul']) ?></a>
                                                                <?php } ?>

                                                            <?php } elseif ($data['akses'] == '2') { ?>

                                                                <?php if ($data['gm'] == '-') { ?>
                                                                    <a class="text-warning"> => <?= esc($data['modul']) ?></a>
                                                                <?php   } else { ?>
                                                                    <a class="text-warning"><?= esc($data['modul']) ?></a>
                                                                <?php } ?>
                                                            <?php } elseif ($data['akses'] == '3') { ?>
                                                                <?php if ($data['gm'] == '-') { ?>
                                                                    <a class="text-danger"> => <?= esc($data['modul']) ?></a>
                                                                <?php   } else { ?>
                                                                    <a class="text-danger"><?= esc($data['modul']) ?></a>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                        <!-- <td class="p-1">
                                                        <?= $data['gm'] ?>
                                                    </td> -->

                                                        <td class="p-1">
                                                            <select name="akses[]" id="akses" class="form-control form-control-sm">

                                                                <option value="1" <?php if ($data['akses'] == '1') echo "selected"; ?>>Akses Semua Data</option>
                                                                <option value="2" <?php if ($data['akses'] == '2') echo "selected"; ?>>Hanya Data Miliknya</option>
                                                                <option value="3" <?php if ($data['akses'] == '3') echo "selected"; ?>>Tidak Boleh Akses </option>

                                                            </select>

                                                            <div class="invalid-feedback errorakses"></div>
                                                        </td>
                                                        <td style="display:none"> <input type="hidden" id="id_modul" name="id_modul[]" value="<?= $data['id_modul'] ?>" class="form-control">
                                                        <td style="display:none"> <input type="hidden" id="id_grupakses" name="id_grupakses[]" value="<?= $data['id_grupakses'] ?>" class="form-control">
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- end detail -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="modal-footer p-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>