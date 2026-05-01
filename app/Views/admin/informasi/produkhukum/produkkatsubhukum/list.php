<?= form_open('produkhukum/hapussubsuball', ['class' => 'formhapus']) ?>

<?php
foreach ($list as $dataid) :
?>
<?php endforeach; ?>
<a href="javascript:window.history.go(-1);" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($akses == 1) { ?>

    <button type="submit" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle text-light"></i> Tambah Data
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0">
    <table id="listsubsubproduk" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="4">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th>Judul</th>
                <th width="120">Tgl Posting</th>
                <th width="15" class="text-center">Diunduh</th>
                <th width="70" class="text-center">Aksi </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="subkathukum_id[]" class="centang_id" value="<?= $data['subkathukum_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>

                    <td>
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['file_subkathukum'] != 'default.png' && ($data['file_subkathukum'] != null)) { ?>
                                <i class="fas fa-file-alt text-success pointer font-16" onclick="uploadfile('<?= $data['subkathukum_id'] ?>')" title="Ganti file"></i>
                            <?php } else { ?>
                                <i class="fas fa-file-alt text-danger pointer font-16" onclick="uploadfile('<?= $data['subkathukum_id'] ?>')" title="Upload file"></i>

                        <?php }
                        } ?>

                        <?= esc($data['nama_subkathukum']);

                        if ($data['file_subkathukum'] != 'default.png' && ($data['file_subkathukum'] != null)) { ?>
                            <a href="<?= base_url('public/unduh/produkhukum/'  . $data['file_subkathukum']) ?>" title="Lihat file" target="_blank"><i class="fas fa-search"></i></a>
                        <?php }
                        ?>

                    </td>

                    <td><?= date_indo($data['tanggal_subkathukum']) ?></td>
                    <td class="text-center p-0">

                        <?= esc($data['hits']) ?>x

                    </td>

                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" title="Edit Data" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['subkathukum_id'] ?>','<?= $data['kathukum_id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" title="Hapus Data" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['subkathukum_id'] ?>','<?= $data['nama_subkathukum'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } else { ?>
                            <label class="text-danger">Akses dibatasi..!</label>
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
                <th>Judul</th>
                <th>Tgl Posting</th>
                <th>Diunduh</th>

                <th class="text-center">Aksi </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {

        $('#listsubsubproduk').DataTable();

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
                                listsubsubproduk();
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

    function edit(subkathukum_id, kathukum_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('produkhukum/formeditsubsub') ?>",
            data: {
                [csrfToken]: csrfHash,
                subkathukum_id: subkathukum_id,
                kathukum_id: kathukum_id

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

    function hapus(subkathukum_id, nama_subkathukum) {
        Swal.fire({

            html: `Apakah anda yakin menghapus <strong>${nama_subkathukum}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('produkhukum/hapussubsub') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        subkathukum_id: subkathukum_id
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
                            listsubsubproduk();
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

        $('.tambah').click(function(e) {
            e.preventDefault();
            subproduk = $("#kathukum_id").val();
            $.ajax({
                url: "<?= site_url('produkhukum/formtambahsubsubproduk') ?>",
                data: {
                    [csrfToken]: csrfHash,
                    subproduk: subproduk,
                },
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
    function uploadfile(subkathukum_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('produkhukum/formuploadsubfile') ?>",
            data: {
                [csrfToken]: csrfHash,
                subkathukum_id: subkathukum_id,
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