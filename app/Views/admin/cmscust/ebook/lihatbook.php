<?php
$db = \Config\Database::connect();
$konfigurasi = $db->table('tbl_setaplikasi')->where('id_setaplikasi', '1')->get()->getRowArray();
?>
<div class="modal fade" id="modallihat">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header p-1">
                <h6 class="modal-title mt-0"><?= $title  ?>

                </h6>
            </div>

            <div class="modal-body">
                <table class="table table-sm table-hover table-striped p-0">

                    <tr>
                        <th width="160" rowspan="8"> <img src="<?= base_url('/public/img/ebook/' . $gambar) ?>" alt="Cover" width="100%"></th>
                    </tr>
                    <tr>
                        <td class="p-1"><b>Judul </b></td>
                        <td class="p-1"><b>:</b></td>
                        <td class="p-1"><b><?= $judul ?></b></td>
                    </tr>
                    <tr>
                        <td class="p-1">Kategori</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $kategori ?></td>
                    </tr>

                    <tr>
                        <td class="p-1">Penulis</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $penulis != '' ? $penulis : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">Jumlah Halaman</td>
                        <td class="p-1">:</td>
                        <td class="p-1"><?= $j_hal != '' ? $j_hal : '-' ?></td>
                    </tr>
                    <tr>
                        <td class="p-1" width="25%">Hits dan Tanggal Posting</td>
                        <td class="p-1" width="2%">:</td>
                        <td class="p-1">Telah dibaca <?= $hits ?> x, <?= date_indo($tanggal) ?></td>
                    </tr>
                    <tr>
                        <td class="p-1">File Buku</td>
                        <td class="p-1">:</td>
                        <td class="p-1 text-secondary"> <a href="<?= base_url('bacabuku/' . $fileebook) ?>" target="_blank"><span class="badge badge-success" title="Klik disini untuk mulai baca" style="font-size:13px"> Baca Buku &raquo;</span></a></td>
                    </tr>

                </table>
            </div>

            <p class="p-1 mb-1">
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="ml-3 btn btn-danger" type="button" data-dismiss="modal">Tutup</a>
                <?php } else { ?>
                    <a class="ml-3 btn btn-danger" data-bs-dismiss="modal">Tutup</a>
                <?php } ?>
            </p>
        </div>

    </div>

</div>