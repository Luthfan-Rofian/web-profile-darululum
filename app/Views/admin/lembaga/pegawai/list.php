<?= form_open('pegawai/hapusall', ['class' => 'formhapus']) ?>
<?php if ($akses == 1) { ?>


    <button type="submit" class="btn btn-success btn-sm tambahpegawai">
        <i class="fas fa fa-plus-circle"></i> Tambah Pegawai
    </button>
    <button type="submit" class="btn btn-info btn-sm modalimport">
        <i class="fas fa-download"></i> Import Data Pegawai
    </button>
    <button type="submit" class="btn btn-danger btn-sm tblhapus">
        <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
    </button>

    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listpegawai" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="4">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="5"># </th>
                <th><b>Nama</b></th>
                <th><b>Jabatan</b></th>
                <th><b>Pangkat Gol</b></th>
                <th width="30"><b>Foto</b></th>
                <th width="60" class="text-center"><b>Aksi</b> </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="pegawai_id[]" class="centang_id" value="<?= $data['pegawai_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>
                    <td>

                        <?php if ($akses == 1) { ?>
                            <?php if ($data['filetupoksi'] != '') { ?>
                                <i class="far fa-file-pdf text-danger pointer" onclick="gantipdf('<?= $data['pegawai_id'] ?>')" title="Ganti file tupoksi"></i>
                            <?php } else { ?>
                                <i class="far fa-file-alt pointer" onclick="gantipdf('<?= $data['pegawai_id'] ?>')" title="Tambahkan file tupoksi"></i>
                            <?php } ?>
                            <?= esc($data['nama']) ?>
                            <?php if ($data['filetupoksi'] != '') { ?>
                                <i class="far fa-trash-alt text-warning pointer" onclick="hapuspdf('<?= $data['pegawai_id'] ?>','<?= $data['nama'] ?>')" title="Hapus file tupoksi"></i>
                            <?php }  ?>
                        <?php } else { ?>

                            <?php if ($data['filetupoksi'] != '') { ?>
                                <i class="far fa-file-pdf text-danger pointer"></i>
                            <?php } else { ?>
                                <i class="far fa-file-alt pointer"></i>
                            <?php } ?>
                            <?= esc($data['nama']) ?>


                        <?php }  ?>
                    </td>
                    <td><?= esc($data['jabatan']) ?></td>
                    <td><?= esc($data['pangkat']) ?></td>


                    <td class="text-left p-0">
                        <?php if ($akses == 1) { ?>
                            <img class="img-circle elevation-2 pointer" title="Ganti Foto" onclick="gantifoto('<?= $data['pegawai_id'] ?>')" src="<?= base_url('public/img/informasi/pegawai/' . $data['gambar']) ?>" height="40px" width="45px" alt="<?= $data['nama'] ?>">
                        <?php } else { ?>
                            <img class="img-circle elevation-2" src="<?= base_url('public/img/informasi/pegawai/' . $data['gambar']) ?>" height="40px" width="45px" alt="<?= $data['nama'] ?>">
                        <?php } ?>
                    </td>
                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" title="Detail Pegawai" class="btn btn-success btn-sm p-1" onclick="lihatpegawai('<?= $data['pegawai_id'] ?>')">
                                <i class="fas fa-search"></i>
                            </button>

                            <button type="button" title="Edit Data" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['pegawai_id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" title="Hapus Data" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['pegawai_id'] ?>','<?= $data['nama'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" title="Detail Pegawai" class="btn btn-success btn-sm p-1" onclick="lihatpegawai('<?= $data['pegawai_id'] ?>')">
                                <i class="fas fa-search"></i>
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
                <th><b>Jabatan</b></th>
                <th><b>Pangkat Gol</b></th>
                <th><b>Foto</b></th>
                <th class="text-center"><b>Aksi</b> </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listpegawai').DataTable();

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
                                listpegawai();
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

    function edit(pegawai_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                pegawai_id: pegawai_id
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

    function hapus(pegawai_id, nama) {
        Swal.fire({
            html: `Apakah anda yakin menghapus <strong>${nama}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pegawai/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        pegawai_id: pegawai_id
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
                            listpegawai();
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

        $('.tambahpegawai').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('pegawai/formtambah') ?>",
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

        // form import

        $('.modalimport').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('pegawai/formimport') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalimport').modal({
                        // backdrop: 'static',
                        // keyboard: false
                    });
                    $('#modalimport').modal('show');
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
    //cover
    function gantifoto(pegawai_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formgantifoto') ?>",
            data: {
                [csrfToken]: csrfHash,
                pegawai_id: pegawai_id,
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

    //lihat
    function lihatpegawai(pegawai_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                pegawai_id: pegawai_id,
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


    function gantipdf(pegawai_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formgantitupoksi') ?>",
            data: {
                [csrfToken]: csrfHash,
                pegawai_id: pegawai_id,
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


    function hapuspdf(pegawai_id, nama) {
        Swal.fire({
            html: `Apakah anda yakin hapus file tupoksi dari <strong>${nama}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pegawai/hapuspdf') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        pegawai_id: pegawai_id
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
                            listpegawai();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal hapus data pdf!",
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