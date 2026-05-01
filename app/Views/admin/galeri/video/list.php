<div id="kembali">
    <button type="submit" class="btn btn-warning btn-sm kembali">
        <i class="far fa-arrow-alt-circle-left"></i> Kembali
    </button>
    <small class="text-secondary"> Pada Link Youtube Contoh: <span class="text-warning">https://www.youtube.com/watch?v=</span><strong class="text-danger">X_fh-xVmto0</strong>. Ambil kode yang warna <strong class="text-danger">Merah</strong></small>

</div>

<?= form_open('video/hapusall', ['class' => 'formhapus']) ?>
<button type="submit" class="btn btn-primary btn-sm tambahvideo" id="add">
    <i class="fas fa fa-plus-circle"></i> Tambah Data
</button>
<button type="submit" class="btn btn-success btn-sm btnuploadmulti" id="addmulti">
    <i class="fas fa fa-plus-circle text-light"></i> Tambah Multi
</button>

<button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
</button>

<a href="kategori" button type="button" class="btn btn-info btn-sm" id="add">
    <i class="fas fa-tasks text-light"></i> Kelola Kategori Video
</a>

<hr>
<div class="viewdatamulti"></div>
<div id="tabelmulti">
    <div class="table-responsive b-0 ">
        <table id="listvideo" class="table table-hover table-striped">

            <thead>
                <tr>
                    <th width="3">
                        <input type="checkbox" id="centangSemua" class="text-center">
                    </th>
                    <th><b>VIDEO</b></th>
                    <th><b>JUDUL</b></th>
                    <th><b>KATEGORI</b></th>
                    <th><b>PENERBIT</b></th>
                    <th><b>TANGGAL</b></th>
                    <th width="50" class="text-center"><b>Aksi</b> </th>

                </tr>
            </thead>
            <tbody>
                <?php $nomor = 0;
                $level = session()->get('level');
                foreach ($list as $value) :
                    $nomor++; ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="video_id[]" class="centangid" value="<?= $value['video_id'] ?>">
                        </td>

                        <td class="text-center p-1">
                            <img class="img-circle elevation-2 pointer" title="<?= $value['ket_video'] ?>" src="https://img.youtube.com/vi/<?php echo $value['video_link'] ?>/mqdefault.jpg" width="130" alt="<?= $value['video_id'] ?>">
                        </td>

                        <td><?= $value['judul'] ?></td>
                        <td><?= $value['nama_kategori_video'] ?></td>
                        <td><?= $value['fullname'] ?></td>
                        <td> <?= date_indo($value['tanggal']) ?></td>

                        <td class="text-center p-0">
                            <?php if ($akses == 1) { ?>
                                <?php if ($value['sts_v'] == '1') { ?>
                                    <button type="button" onclick="toggle(<?= $value['video_id'] ?>)" class="btn btn-circle btn-sm p-1 <?= $value['sts_v'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['sts_v'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" onclick="toggle(<?= $value['video_id'] ?>)" class="btn btn-circle btn-sm p-1 <?= $value['sts_v'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['sts_v'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                    </button>
                                <?php }
                            } else { ?>

                                <?php if ($value['sts_v'] == '1') { ?>
                                    <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['sts_v'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['sts_v'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['sts_v'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['sts_v'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                    </button>
                            <?php }
                            }
                            ?>
                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $value['video_id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $value['video_id'] ?>','<?= $value['judul'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>

                    <th>
                        <input type="checkbox" class="text-center" disabled>
                    </th>
                    <th><b>VIDEO</b></th>
                    <th><b>JUDUL</b></th>
                    <th><b>KATEGORI</b></th>
                    <th><b>PENERBIT</b></th>
                    <th><b>TANGGAL</b></th>

                    <th class="text-center"><b>Aksi</b></th>

                </tr>
            </tfoot>
        </table>
    </div>

</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listvideo').DataTable();
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
                                listvideo();
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

    //aktifnonaktif

    function toggle(video_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('video/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                video_id: video_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    listvideo();
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
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


    function edit(video_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('video/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                video_id: video_id
            },
            dataType: "json",
            success: function(response) {
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
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(video_id, ket) {

        Swal.fire({
            // title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${ket}</strong> ini ?`,

            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('video/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        video_id: video_id
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
                            listvideo();
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

    //tambah data
    $(document).ready(function() {
        // listvideo();
        $('.tambahvideo').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('video/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });


        //multiupload

        $('.btnuploadmulti').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: '<?= site_url('video/uploadvideomulti') ?>',
                dataType: "json",
                "data": {
                    [csrfToken]: csrfHash,
                },
                beforeSend: function() {
                    $('.btnuploadmulti').attr('disable', 'disable');
                    $('.btnuploadmulti').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnuploadmulti').removeAttr('disable', 'disable');

                    $('.btnuploadmulti').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                    $(tabelmulti).hide();
                    $(tblhapus).hide();
                    $(add).hide();
                    $(addmulti).hide();
                    $(kembali).show();

                },
                success: function(response) {
                    $('.viewdatamulti').html(response.data);
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });


        // listvideo();
        $('.kembali').click(function(e) {
            $(document).ready(function() {
                listvideo();
            });

        });

    });
</script>