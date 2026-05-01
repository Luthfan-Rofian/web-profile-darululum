<?= form_open('daftar/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>
    <button type="button" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Partisipan
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>
<?php } ?>

<hr>
<div class="table-responsive b-0 ">
    <table id="listanggota" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="3">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="8"># </th>
                <th width="180"><b>Nama</b></th>
                <th><b>TTL</b></th>
                <th width="50"><b>JK</b></th>
                <th width="80"><b>NO HP</b></th>
                <th><b>Alamat</b></th>
                <th><b>Tanggal Daftar</b></th>
                <th width="80" class="text-center"><b>Aksi </b></th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++;
                if ($value['jk'] == 'L') {
                    $jk = 'Laki-Laki';
                } else {
                    $jk = 'Perempuan';
                }
            ?>
                <tr>
                    <td>
                        <input type="checkbox" name="anggota_id[]" class="centangid" value="<?= $value['anggota_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>


                    <td>
                        <?php if ($value['dok_ktp'] != '') { ?>
                            <i class="mdi mdi-file-check text-success pointer font-18" onclick="uploadfile('<?= $value['anggota_id'] ?>')" title="Ganti file KTP"></i>
                        <?php } else { ?>
                            <i class="mdi mdi-file-outline pointer font-18" onclick="uploadfile('<?= $value['anggota_id'] ?>')" title="Tambahkan file"></i>
                        <?php } ?>

                        <?= esc($value['nama']) ?>

                        <?php if ($value['dok_ktp'] != '') { ?>
                            <i class="far fa-trash-alt text-warning pointer" onclick="hapusfile('<?= $value['anggota_id'] ?>','<?= $value['nama'] ?>')" title="Hapus file KTP"></i>
                        <?php }  ?>

                    </td>



                    <td><?= $value['tempat_lahir'] ?>, <?= date_indo($value['tgl_lahir']) ?></td>
                    <td><?= $jk ?></td>
                    <td><?= htmlentities($value['no_hp']) ?></td>
                    <td><?= htmlentities($value['alamat']) ?></td>
                    <td><?= date_indo($value['tgl_daftar']) ?></td>

                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>

                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $value['anggota_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $value['anggota_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>
                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $value['anggota_id'] ?>','<?= $value['nama'] ?>')">
                                <i class="far fa-edit text-light"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $value['anggota_id'] ?>','<?= $value['nama'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>

                        <?php } else { ?>
                            <?php if ($value['status'] == '1') { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-circle btn-sm p-1 <?= $value['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>
                        <?php  } ?>

                        <button type="button" class="btn btn-info btn-sm p-1" onclick="lihat('<?= $value['anggota_id'] ?>')">
                            <i class="fas fa-search"></i>
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
                <th><b>Nama</b></th>
                <th><b>TTL</b></th>
                <th><b>JK</b></th>
                <th><b>NO HP</b></th>
                <th><b>Alamat</b></th>
                <th><b>Tanggal Daftar</b></th>

                <th class="text-center"><b>Aksi</b></th>

            </tr>
        </tfoot>
    </table>
</div>

<?= form_close() ?>

<script>
    $(document).ready(function() {

        var table = $('#listanggota').DataTable({
            lengthChange: false,
            "ordering": false,
            buttons: ['copy', 'excel', 'pdf', 'print']
            // "buttons": ["copy", "csv", "excel", "pdf", "print"]
        });

        table.buttons().container()
            .appendTo('#listanggota_wrapper .col-md-6:eq(0)');


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
                                listanggota();
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

    function edit(anggota_id, bidang_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('daftar/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                anggota_id: anggota_id,
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

    function lihat(anggota_id, bidang_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('daftar/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                anggota_id: anggota_id,
                bidang_id: bidang_id
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
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function hapus(anggota_id, ket) {

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
                    url: "<?= site_url('daftar/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        anggota_id: anggota_id
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
                            listanggota();
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

    function toggle(anggota_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('daftar/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                anggota_id: anggota_id
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
                    listanggota();
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

    //tambah data
    $(document).ready(function() {

        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('daftar/formtambah') ?>",
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
                        timer: 2100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
        });
    });

    //uploadfile
    function uploadfile(anggota_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('daftar/formuploadfile') ?>",
            data: {
                [csrfToken]: csrfHash,
                anggota_id: anggota_id,
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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }


    function hapusfile(anggota_id, nama) {
        Swal.fire({
            html: `Anda yakin hapus file KTP milik <strong>${nama}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('daftar/hapusfile') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        anggota_id: anggota_id
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
                            listanggota();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal hapus file!",
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