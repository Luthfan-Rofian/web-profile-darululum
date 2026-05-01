<a href="<?= base_url('user/') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahgrup">
        <i class="fas fa fa-plus-circle"></i> Tambah Grup Baru
    </button>
<?php } ?>

<small class="text-secondary"> Hak Akses untuk <strong class="text-danger"> Hanya Data Miliknya, </strong> pada beberapa modul sama dengan <strong class="text-warning"> Hanya bisa melihat data</strong>. </small>
<hr>
<div class="table-responsive b-0 ">
    <table id="listgrup" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>Nama Grup</b></th>
                <th><b>Keterangan</b></th>
                <th width="100" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1"><?= esc($data['nama_grup']) ?></td>
                    <td class="p-1"><?= esc($data['ketgrup']) ?></td>


                    <td class="text-center p-1">

                        <button type="button" class="btn btn-info btn-sm p-1" title="Ganti Nama Grup" onclick="editnama('<?= $data['id_grup'] ?>')">
                            <i class="icon fas fa-edit text-light"></i>
                        </button>
                        <button type="button" class="btn btn-social btn-flat btn-success btn-sm p-1" title="Lihat Hak Akses" onclick="lihatakses('<?= $data['id_grup'] ?>')">
                            <i class="icon fas fa-search text-light"></i>
                        </button>

                        <?php if ($data['jenis'] != '1') { ?>
                            <?php if ($data['sts_menu'] != '1') { ?>

                                <button type="button" class="btn btn-secondary btn-sm p-1" title="Tambah Akses Menu" onclick="addmenu('<?= $data['id_grup'] ?>')">
                                    <i class="icon fas fa-sliders-h text-light"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-social btn-flat btn-primary btn-sm p-1" title="Ubah Akses Menu" onclick="editmenu('<?= $data['id_grup'] ?>')">
                                    <i class="icon fas fa-bars text-light"></i>
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-warning btn-sm p-1" title="Ubah Hak Akses" onclick="edit('<?= $data['id_grup'] ?>')">
                                <i class="icon fas fa-user-ninja text-light"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm p-1" title="Hapus Data Grup" onclick="hapus('<?= $data['id_grup'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } ?>

                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>

                <th><b>Nama Grup</b></th>
                <th><b>Keterangan</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#listgrup').DataTable();
        $('.tambahgrup').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('user/formgrup') ?>",
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
                        // showConfirmButton: false,
                        // timer: 3100
                    }).then(function() {
                        // window.location = '';
                    })
                }
            });
        });
    });

    // tambah hak akses ke grup
    function edit(id_grup) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formeditgrup') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_grup: id_grup
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

    function lihatakses(id_grup) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formlihatakses') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_grup: id_grup
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


    function editnama(id_grup) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formeditgrupnm') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_grup: id_grup
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

    // Tambah akses menu
    function addmenu(id_grup) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formaddmenugrup') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_grup: id_grup
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

    // Edit menu
    function editmenu(id_grup) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formeditmenugrup') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_grup: id_grup
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

    function hapus(id_grup) {
        Swal.fire({
            width: '400px',

            title: 'Hapus data?',
            text: `Apakah anda yakin hapus data?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('user/hapusgrup') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id_grup: id_grup
                    },

                    success: function(response) {
                        if (response.sukses) {

                            toastr["success"](response.sukses)
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
                                listgrup();
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