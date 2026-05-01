<?= form_open('unitkerja/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahunitkerja">
        <i class="fas fa fa-plus-circle"></i> Tambah Unit Kerja Baru
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>
<a href="unitkerja/tipe" button type="button" class="btn btn-info btn-sm">
    <i class="fas fa-tasks text-light"></i> Kelola Tipe Unit Kerja
</a>
<hr>
<div class="table-responsive b-0 ">
    <table id="listunitkerja" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="3">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th><b>Unit Kerja</b></th>
                <th><b>Singkatan</b></th>
                <th><b>Tipe</b></th>

                <th width="60" class="text-center"><b>Aksi</b> </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="p-1 text-center">
                        <input type="checkbox" name="opd_id[]" class="centang_id" value="<?= $data['opd_id'] ?>">
                    </td>
                    <td class="p-1 text-center"><?= $nomor ?></td>

                    <td class="p-1">&nbsp;&nbsp;<?= esc($data['nama_opd']) ?></td>
                    <td class="p-1">&nbsp;&nbsp;<?= esc($data['singkatan_opd']) ?></td>
                    <td class="p-1"><?= esc($data['nama_tipe']) ?></td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <button type="button" title="Edit Data" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['opd_id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" title="Hapus Data" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['opd_id'] ?>','<?= $data['nama_opd'] ?>')">
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
                <th><b>Unit Kerja</b></th>
                <th><b>Singkatan</b></th>
                <th><b>Tipe</b></th>
                <th class="text-center">Aksi </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {

        var table = $('#listunitkerja').DataTable({
            "ordering": false,
        });

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centang_id').prop('checked', true);
            } else {
                $('.centang_id').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centang_id:checked');
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
                    title: `Apakah anda yakin menghapus ${jmldata.length} data ini?`,
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
                                listunitkerja();
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


    function edit(opd_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('unitkerja/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                opd_id: opd_id

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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }

    function hapus(opd_id, nama_opd) {
        Swal.fire({
            html: `Apakah anda yakin menghapus <strong>${nama_opd}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('unitkerja/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        opd_id: opd_id
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
                            listunitkerja();
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

        $('.tambahunitkerja').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('unitkerja/formtambah') ?>",
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
</script>