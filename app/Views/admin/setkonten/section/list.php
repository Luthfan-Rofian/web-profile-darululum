<?= form_open('section/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahsection">
        <i class="fas fa fa-plus-circle"></i> Tambah Section Baru
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
    </button>

    <small class="text-secondary"> Ukuran gambar section <strong class="text-danger">399x210 px</strong>. (disesuaikan dengan template) </small>
    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listsection" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th width="50">Gambar</th>
                <th width="150">Nama Section</th>
                <th>Link</th>
                <th width="70" class="text-center">Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="section_id[]" class="centangsectionid" value="<?= $value['section_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>

                    <td class="p-1"><img class="img-circle elevation-2" src="<?= base_url('/public/img/section/' . $value['gambar']) ?>" width="50"></td>
                    <td><?= $value['nama_section'] ?></td>
                    <td><?= $value['link'] ?></td>

                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $value['section_id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $value['section_id'] ?>','<?= $value['nama_section'] ?>')">
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
                <th>Gambar</th>
                <th>Nama Section</th>
                <th>Link</th>
                <th class="text-center">Aksi</th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listsection').DataTable();

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangsectionid').prop('checked', true);
            } else {
                $('.centangsectionid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangsectionid:checked');
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
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} section?`,
                    text: 'Semua section yang terpilih akan terhapus!',
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
                                listsection();
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

    function edit(section_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('section/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                section_id: section_id
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

    function hapus(section_id, ket) {

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
                    url: "<?= site_url('section/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        section_id: section_id
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
                            listsection();
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
        $('.tambahsection').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('section/formtambah') ?>",
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