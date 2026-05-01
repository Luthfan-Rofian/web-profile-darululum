<div id="viewdatakomen">

    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i class="mdi mdi-bell noti-icon"></i>

        <?php if ($totkomen != '0') { ?>
            <span class="badge badge-pill badge-info noti-icon-badge"><?= $totkomen ?></span>
        <?php } ?>

    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">

        <!-- item-->
        <h6 class="dropdown-item-text">
            Komentar Berita
        </h6>
        <div class="slimscroll notification-item-list">

            <?php
            if ($list) {
                foreach ($list as $key => $value) {

                    $blnk = date('m', strtotime($value["tanggal_komen"]));
                    $blnck = bulan($blnk);
                    $tglk = date('d', strtotime($value["tanggal_komen"]));
                    $thnk = date('Y', strtotime($value["tanggal_komen"]));
                    $jamk = date('H:i:s', strtotime($value["tanggal_komen"]));
            ?>
                    <a href="javascript:void(0);" class="dropdown-item notify-item p-1">
                        <div class="notify-icon bg-danger" onclick="viewkom('<?= $value['beritakomen_id'] ?>')"><i class="far fa-comment-dots"></i></div>
                        <b>
                            <p class="notify-details" title="<?= $value['judul_berita'] ?>" onclick="viewkom('<?= $value['beritakomen_id'] ?>')"><?= htmlentities($value['nama_komen']) ?>, <small><?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></small><span class="text-danger"><small><?= htmlentities($value['isi_komen']) ?></small> </span></p>
                        </b>
                    </a>
                <?php } ?>
            <?php } else { ?>
                <p>
                    <a class="dropdown-item text-center text-warning"> Tidak ada komentar baru </a>
                </p>
            <?php } ?>
        </div>
        <!-- All-->
        <a href="<?= base_url('berita/listkomen') ?>" class="dropdown-item text-center text-primary">
            <strong>Lihat Semua Komentar Berita</strong> <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
</a>

<script>
    function viewkom(beritakomen_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('berita/formkomenback') ?>",
            data: {
                [csrfToken]: csrfHash,
                beritakomen_id: beritakomen_id
            },
            dataType: "json",
            success: function(response) {
                if (response.noakses) {

                    Swal.fire({
                        title: "Gagal Akses!",
                        html: `Anda tidak berhak mengakses <strong>Form ini</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        // window.location = '../';
                    })
                }
                if (response.blmakses) {

                    Swal.fire({
                        title: "Maaf gagal load Modul!",
                        html: `Form ini belum atau tidak didaftarkan `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        // window.location = '../admin';
                    })
                }
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalkomen').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalkomen').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                });
            }
        });
    }
</script>