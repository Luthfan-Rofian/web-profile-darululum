<?= form_open('banner/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahbanner">
        <i class="fas fa fa-plus-circle"></i> Tambah Banner Baru
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>

    <small class="text-secondary"> Penyesuaian ukuran banner diatur sendiri pada Pengaturan Situs.</small>
    <hr>
<?php } ?>

<div class="table-responsive b-0 ">
    <table id="listbanner" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="5"># </th>
                <th width="100">Gambar Banner</th>
                <th>Keterangan</th>
                <th>Link</th>
                <th width="60" class="text-center">Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="id_banner[]" class="centangBannerid" value="<?= $value['id_banner'] ?>">
                    </td>
                    <td><?= $nomor ?></td>
                    <td class="p-1">
                        <?php if ($akses == 1) { ?>
                            <img class="img-circle elevation-2 pointer" onclick="gantibanner('<?= $value['id_banner'] ?>')" title="Ganti banner" src="<?= base_url('/public/img/banner/' . $value['banner_image']) ?>" width="150">
                        <?php } else { ?>
                            <img class="img-circle elevation-2" src="<?= base_url('/public/img/banner/' . $value['banner_image']) ?>" width="390">

                        <?php } ?>
                    </td>

                    <td><?= $value['ket'] ?></td>
                    <td><?= $value['link'] ?></td>

                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $value['id_banner'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $value['id_banner'] ?>','<?= $value['ket'] ?>')">
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
                <th>#</th>
                <th>Gambar Banner</th>
                <th>Keterangan</th>
                <th>Link</th>
                <th class="text-center">Aksi</th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        // $('#listbanner').DataTable();
        var table = $('#listbanner').DataTable({
            "ordering": false,
        });
        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangBannerid').prop('checked', true);
            } else {
                $('.centangBannerid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangBannerid:checked');
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
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} banner?`,
                    text: 'Semua banner yang terpilih akan terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
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
                                listbanner();
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )

                            }
                        });
                    }
                })
            }
        });
    });

    function edit(id_banner) {
        $.ajax({
            type: "post",
            url: "<?= site_url('banner/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_banner: id_banner
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

    function hapus(id_banner, ket) {

        Swal.fire({

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
                    url: "<?= site_url('banner/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id_banner: id_banner
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
                            listbanner();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )

                    }
                });
            }
        })
    }

    //tambah data
    $(document).ready(function() {
        $('.tambahbanner').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('banner/formtambah') ?>",
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
    });


    function gantibanner(id_banner) {

        $.ajax({
            type: "post",
            url: "<?= site_url('banner/formgantibanner') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_banner: id_banner,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalupload').modal('show');
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
</script>