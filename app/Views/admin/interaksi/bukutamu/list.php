<?= form_open('bukutamu/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>
<a href="bidang" button type="button" class="btn btn-primary btn-sm">
    <i class="fas fa-tasks text-light"></i> Kelola Data Bidang
</a>

<hr>
<div class="table-responsive b-0 ">
    <table id="listbukutamu" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="3">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th><b>Nama</b></th>
                <th><b>Telp/HP</b></th>
                <th><b>Instansi</b></th>
                <th><b>Bidang</b></th>
                <th><b>Keperluan</b></th>
                <th class="text-center"><b>Tanggal</b></th>

                <th width="40" class="text-center"><b>Aksi </b></th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="bukutamu_id[]" class="centangid" value="<?= $value['bukutamu_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>


                    <td><?= htmlentities($value['nama']) ?></td>
                    <td><?= htmlentities($value['telp']) ?></td>
                    <td><?= $value['instansi'] ?></td>
                    <td><?= $value['nama_bidang'] ?></td>
                    <td><?= htmlentities($value['keperluan']) ?></td>
                    <td> <?= date_indo($value['tanggal']) ?></td>

                    <td class="text-center p-0">
                        <button type="button" class="btn btn-info btn-sm p-1" onclick="edit('<?= $value['bukutamu_id'] ?>','<?= $value['bidang_id'] ?>')">
                            <i class="fas fa-search"></i>
                        </button>
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $value['bukutamu_id'] ?>','<?= $value['keperluan'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
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
                <th><b>Nama</b></th>
                <th><b>Telp/HP</b></th>
                <th><b>Instansi</b></th>
                <th><b>Bidang</b></th>
                <th><b>Keperluan</b></th>
                <th><b>Tanggal</b></th>

                <th class="text-center"><b>Aksi</b></th>

            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {

        var table = $('#listbukutamu').DataTable({
            lengthChange: false,
            "ordering": false,
            buttons: ['copy', 'excel', 'pdf', 'print']
            // "buttons": ["copy", "csv", "excel", "pdf", "print"]
        });

        table.buttons().container()
            .appendTo('#listbukutamu_wrapper .col-md-6:eq(0)');


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
                                listbukutamu();
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

    function edit(bukutamu_id, bidang_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bukutamu/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                bukutamu_id: bukutamu_id,
                bidang_id: bidang_id
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

    function hapus(bukutamu_id, ket) {

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
                    url: "<?= site_url('bukutamu/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        bukutamu_id: bukutamu_id
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
                            listbukutamu();
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