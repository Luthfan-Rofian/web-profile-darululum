<?php
$db = \Config\Database::connect();
?>

<?= form_open('berita/hapuskomenall', ['class' => 'formhapus']) ?>

<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
    </button>

    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listkomen" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="3">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <!-- <th width="10"># </th> -->
                <th>Berita</th>
                <th>Nama</th>
                <th>Komentar</th>
                <th width="110" class="text-center">Tanggal Komen</th>
                <th width="20">Status</th>

                <th width="35" class="text-center">Aksi </th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($list as $value) :

                $blnk = date('m', strtotime($value["tanggal_komen"]));
                $blnck = bulan($blnk);
                $tglk = date('d', strtotime($value["tanggal_komen"]));
                $thnk = date('Y', strtotime($value["tanggal_komen"]));
                $jamk = date('H:i:s', strtotime($value["tanggal_komen"]));

                $berita = $db->table('berita')->where('berita_id', $value['berita_id'])->orderBy('berita_id', 'ASC')->get()->getResultArray();
                if ($berita) {
                    foreach ($berita as $databerita) {
                    };
                    $slug = $databerita['slug_berita'];
                    $judul = $databerita['judul_berita'];
                } else {
                    $slug = '';
                    $judul = '';
                }


            ?>
                <tr>
                    <td>
                        <input type="checkbox" name="beritakomen_id[]" class="centangid" value="<?= $value['beritakomen_id'] ?>">
                    </td>
                    <td>
                        <?php if ($value['sts_komen'] == '0') {

                        ?>
                            <b><a href="<?= base_url('detail/' . $slug) ?>" target="_blank" class="text-primary"><?= $judul ?></a></b>
                        <?php } else { ?>
                            <a href="<?= base_url('detail/' . $slug) ?>" target="_blank" class="text-primary" title="<?= $value['balas_komen'] ?>"><?= $judul ?></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($value['sts_komen'] == '0') { ?>
                            <b><?= htmlentities($value['nama_komen']) ?></b>
                        <?php } else { ?>
                            <?= htmlentities($value['nama_komen']) ?>
                        <?php } ?>

                    </td>

                    <td>
                        <?php if ($value['sts_komen'] == '0') { ?>
                            <b><?= htmlentities($value['isi_komen']) ?></b>
                        <?php } else { ?>
                            <?= htmlentities($value['isi_komen']) ?>
                        <?php } ?>
                    </td>

                    <td>
                        <?php if ($value['sts_komen'] == '0') { ?>
                            <b> <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></b>
                        <?php } else { ?>
                            <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?>
                        <?php } ?>

                    </td>

                    <td class="p-0 text-center">
                        <?php if ($value['sts_komen'] == '1') { ?>

                            <h6>
                                <a><i class="fas fa-check-circle text-success font-20 p-0" title="Telah ditanggapi"></i></a>
                            </h6>

                        <?php } else { ?>
                            <h6>
                                <a><i class="fas fa-arrow-circle-right text-danger font-20 p-0" title="Belum ditanggapi"></i></a>
                            </h6>
                        <?php } ?>
                    </td>

                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $value['beritakomen_id'] ?>')">
                                <i class="fas fa-reply-all"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $value['beritakomen_id'] ?>','<?= htmlentities($value['nama_komen']) ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } else { ?>
                            <a class="text-danger">Akses dibatasi.!</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>

                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <!-- <th>#</th> -->
                <th>Berita</th>
                <th>Nama</th>
                <th>Komentar</th>
                <th>Tanggal Komen</th>
                <th>Status</th>

                <th class="text-center">Aksi</th>

            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listkomen').DataTable();

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangid').prop('checked', true);
            } else {
                $('.centangid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangid:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} data ini?`,
                    text: 'Semua data yang terpilih akan terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            beforeSend: function() {
                                $('.tblhapus').attr('disable', 'disable');
                                $('.tblhapus').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                            },
                            complete: function() {
                                $('.tblhapus').removeAttr('disable', 'disable');
                                $('.tblhapus').html('<i class="far fa-trash-alt text-light"></i>  Hapus yang diceklist');
                            },
                            success: function(response) {
                                toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": true,
                                        "positionClass": "toast-top-right",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "5000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    },
                                    toastr["success"](response.sukses)
                                listkomen();
                                listkomennew();
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                Swal.fire({
                                    title: "Maaf gagal hapus data!",
                                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 3100
                                }).then(function() {
                                    window.location = '';
                                })
                            }
                        });
                    }
                })
            }
        });
    });

    function edit(beritakomen_id) {
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
                        html: `Anda tidak berhak mengakses<strong>Modul ini</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '../dashboard';
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
                        window.location = '../dashboard';
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
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }

    function hapus(beritakomen_id, nama) {

        Swal.fire({
            html: `Yakin hapus komentar dari <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('berita/hapuskomen') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        beritakomen_id: beritakomen_id,

                    },
                    success: function(response) {
                        if (response.sukses) {
                            toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                },
                                toastr["success"](response.sukses)
                            listkomen();
                            listkomennew();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal hapus data!",
                            html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3100
                        }).then(function() {
                            window.location = '';
                        })
                    }
                });
            }
        })
    }
</script>