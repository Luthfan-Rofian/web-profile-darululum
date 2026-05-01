<?= form_open('ebook/hapusall', ['class' => 'formhapus']) ?>
<button type="submit" class="btn btn-success btn-sm tambahebook" id="add">
    <i class="fas fa fa-plus-circle"></i> Tambah Data
</button>

<button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
</button>

<hr>
<div class="table-responsive b-0 ">
    <table id="listebook" class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="2">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="40"><b>Cover</b></th>
                <th><b>Judul</b></th>
                <th><b>Kategori</b></th>
                <th><b>Penerbit</b></th>
                <th><b>Tanggal</b></th>
                <th width="90" class="text-center"><b>Aksi</b> </th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td class="p-1 text-center">
                        <input type="checkbox" name="ebook_id[]" class="centangid" value="<?= $value['ebook_id'] ?>">
                    </td>

                    <td class="text-center p-1">
                        <?php if ($value['gambar'] == 'default.png') { ?>
                            <span class="badge badge-warning pointer" style="font-size:12px" onclick="ganticover(' <?= $value['ebook_id'] ?> ')" title="Tambahkan Cover">No Cover </span>
                        <?php } else { ?>
                            <img class="img-circle elevation-2 pointer" title="Ganti Gambar" onclick="ganticover('<?= $value['ebook_id'] ?>')" src="<?= base_url('public/img/ebook/' . $value['gambar']) ?>" width="50px">
                        <?php } ?>
                    </td>
                    <td class="p-1">
                        <i class="fas fa-file-pdf text-danger"></i>
                        <?= $value['judul'] ?> <span class="badge badge-warning" title="dibaca" style="font-size:10px">(<?= $value['hits'] ?>) </span>
                    </td>
                    <td class="p-1"><?= $value['kategoriebook_nama'] ?></td>
                    <td class="p-1"><?= $value['fullname'] ?></td>
                    <td><?= shortdate_indo($value['tanggal']) ?></td>



                    <td class="text-center p-1">

                        <?php if ($akses == 1) { ?>
                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" onclick="toggle(<?= $value['ebook_id'] ?>)" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle(<?= $value['ebook_id'] ?>)" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php }
                        } else { ?>

                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                        <?php }
                        }
                        ?>
                        <button type="button" title="Detail Book" class="btn btn-success btn-sm p-1" onclick="lihatbook('<?= $value['ebook_id'] ?>','<?= $value['kategoriebook_nama'] ?>')">
                            <i class="fas fa-search"></i>
                        </button>

                        <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $value['ebook_id'] ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $value['ebook_id'] ?>','<?= $value['judul'] ?>')">
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
                <th><b>Cover</b></th>
                <th><b>Judul</b></th>
                <th><b>Kategori</b></th>
                <th><b>Penerbit</b></th>
                <th><b>Tanggal</b></th>
                <th class="text-center"><b>Aksi</b></th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {

        var table = $('#listebook').DataTable({
            "ordering": false,
        });
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
                                listebook();
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

    function edit(ebook_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id
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

    function hapus(ebook_id, ket) {

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
                    url: "<?= site_url('ebook/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        ebook_id: ebook_id
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
                            listebook();
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
        $('.tambahebook').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('ebook/formtambah') ?>",
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


    //lihat
    function lihatbook(ebook_id, kategoriebook_nama) {

        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id,
                kategoriebook_nama: kategoriebook_nama,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modallihat').modal('show');

                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }
    //ganti cover
    function ganticover(ebook_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/formganticover') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id,
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


    function toggle(ebook_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id
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
                    listebook();
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