<div id="viewdata2">

    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
        <i class="mdi mdi-comment-text-multiple noti-icon"></i>

        <?php if ($totkritik != '0') { ?>
            <span class="badge badge-pill badge-info noti-icon-badge"><?= $totkritik ?></span>
        <?php } ?>

    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">

        <!-- item-->
        <h6 class="dropdown-item-text">
            Pesan Masuk
        </h6>
        <div class="slimscroll notification-item-list">

            <?php
            if ($list) {

                $no = 0;
                foreach ($list as $key => $value) {

            ?>
                    <a href="javascript:void(0);" class="dropdown-item notify-item p-1">

                        <?php if ($value['status'] == '1') { ?>
                            <div class="notify-icon bg-info"><i class="far fa-comments"></i></div>
                            <p class="notify-details" title="Pesan ini telah ditanggapi" onclick="viewkritik2('<?= $value['kritiksaran_id'] ?>')"><?= htmlentities($value['nama']) ?> <span class="text-muted"><?= date_indo($value['tanggal']) ?> | <?= $value['judul'] ?> </span></p>
                        <?php } elseif ($value['status'] == '0') { ?>
                            <div class="notify-icon bg-warning"><i class="far fa-comment-dots"></i></div>
                            <b>
                                <p class="notify-details" title="Pesan ini belum ditanggapi" onclick="viewkritik2('<?= $value['kritiksaran_id'] ?>')"><?= htmlentities($value['nama']) ?><span class="text-danger"><?= date_indo($value['tanggal']) ?> | <?= $value['judul'] ?> </span></p>
                            </b>
                        <?php } else { ?>
                            <div class="notify-icon bg-success"><i class="far fa-comments"></i></div>
                            <p class="notify-details" title="Pesan ini telah ditanggapi & Tampil di Suara Anda" onclick="viewkritik2('<?= $value['kritiksaran_id'] ?>')"><?= htmlentities($value['nama']) ?> <span class="text-muted"><?= date_indo($value['tanggal']) ?> | <?= $value['judul'] ?> </span></p>

                        <?php } ?>
                    </a>
            <?php }
            } ?>
        </div>
        <!-- All-->
        <a href="<?= base_url('kritiksaran/list') ?>" class="dropdown-item text-center text-primary">
            <strong>Lihat Semua</strong> <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
</a>

<script>
    function viewkritik2(kritiksaran_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kritiksaran/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                kritiksaran_id: kritiksaran_id
            },
            dataType: "json",
            success: function(response) {
                if (response.noakses) {

                    Swal.fire({
                        title: "Gagal Akses!",
                        html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
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
                        html: `Modul ini belum atau tidak didaftarkan `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        // window.location = '../admin';
                    })
                }
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaledit').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });
            }
        });
    }
</script>