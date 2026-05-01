<?= form_open('bankdata/hapusall', ['class' => 'formhapus']) ?>
<button type="submit" class="btn btn-primary btn-sm tambahbankdata">
    <i class="fas fa fa-plus-circle"></i> Tambah Data
</button>
<button type="submit" class="btn btn-danger btn-sm tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
</button>

<hr>
<div class="table-responsive b-0">
    <table id="listbankdata" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="5"># </th>
                <th>Nama File</th>
                <th>Tgl Posting</th>
                <th class="text-center">Penerbit</th>
                <th width="20" class="text-center">Diunduh</th>
                <th width="50" class="text-center">Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="bankdata_id[]" class="centang_id" value="<?= $data['bankdata_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>

                    <td>
                        <?php if ($data['fileupload'] != '') { ?>
                            <i class="fas fa-file-alt text-success pointer" onclick="uploadfile('<?= $data['bankdata_id'] ?>')" title="Ganti file"></i>

                        <?php } ?>

                        <?= esc($data['nama_bankdata']) ?>

                        <?php if ($data['fileupload'] != '') { ?>
                            <a href="<?= base_url('public/unduh/bankdata/'  . $data['fileupload']) ?>" title="Lihat file" target="_blank"><i class="fas fa-search"></i></a>
                        <?php }  ?>
                    </td>

                    <td><?= date_indo($data['tgl_upload']) ?></td>
                    <td class="text-center p-0"><?= esc($data['fullname']) ?></td>
                    <td class="text-center p-0"><?= esc($data['hits']) ?>x</td>
                    <td class="text-center p-0">

                        <button type="button" title="Edit Data" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['bankdata_id'] ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" title="Hapus Data" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['bankdata_id'] ?>','<?= $data['nama_bankdata'] ?>')">
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
                <th>#</th>
                <th>Nama File</th>
                <th>Tgl Posting</th>
                <th>Penerbit</th>
                <th>Diunduh</th>

                <th class="text-center">Aksi </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listbankdata').DataTable();

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
                                listbankdata();
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

    function edit(bankdata_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bankdata/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                bankdata_id: bankdata_id

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

    function hapus(bankdata_id, nama_bankdata) {
        Swal.fire({

            html: `Apakah anda yakin menghapus <strong>${nama_bankdata}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('bankdata/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        bankdata_id: bankdata_id
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
                            listbankdata();
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

        $('.tambahbankdata').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('bankdata/formtambah') ?>",
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


    //uploadfile
    function uploadfile(bankdata_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('bankdata/formuploadfile') ?>",
            data: {
                [csrfToken]: csrfHash,
                bankdata_id: bankdata_id,
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