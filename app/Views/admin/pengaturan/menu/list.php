<div class="media border-bottom m-b-1">
    <?php if ($akses == 1) { ?>
        <button type="submit" class="btn btn-success btn-sm mr-1 tambahmenu">
            <i class="fas fa fa-plus-circle"></i> Tambah Menu Baru
        </button>
        <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm mr-4 tambahmenusecond"> <i class="fas fa fa-plus-circle"></i>Tambah Secondary Menu
        </button>
    <?php } ?>
    <div class="media-body">

        <div class="form-group row">
            <label for="" class="float-left p-1">Posisi :</label>
            <div class="col-sm-4">
                <select class="form-control form-control-sm" name="pilposisi" id="pilposisi">
                    <option Disabled=true Selected=true>-- Filter Posisi Menu --</option>
                    <option data-posisimn="0">Menu Utama</option>
                    <option data-posisimn="1">Top Menu</option>
                    <option data-posisimn="2">Footer Menu</option>
                </select>

            </div>
        </div>
    </div>
</div>

<div class="table-responsive b-0 mt-2">
    <table id="listmenu" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>Nama Menu</b></th>
                <th><b>Link </b></th>
                <th width="50" class="text-center"><b>Icon </b></th>
                <th width="40" class="text-center"><b>Urutan </b></th>
                <th width="40"><b>Posisi </b></th>
                <th width="70" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
            ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1">

                        <?php if ($data['parent'] == 'Y') { ?>
                            <a class="text-primary" href="<?= base_url('menu/submenu/' . $data['menu_id']) ?>" title="Kelola Sub Menu"> <?= esc($data['nama_menu']) ?></a> <i class="mdi mdi-chevron-down"></i>
                        <?php } else { ?>
                            <?= esc($data['nama_menu']) ?>
                        <?php } ?>

                    </td>

                    <?php if ($data['menu_link'] == '#') { ?>
                        <td class="p-1"><?= esc($data['menu_link']) ?></td>
                    <?php } else { ?>
                        <td class="p-1">
                            <i class="mdi mdi-link-variant"></i>
                            <a target="_blank" href="<?php echo base_url($data['menu_link']) ?>"><?= esc($data['menu_link']) ?> </a>
                        </td>
                    <?php } ?>

                    <td class="p-1 text-center">
                        <?php if ($data['icon'] != '') { ?>
                            <a class="text-warning font-13"> <i class="<?= $data['icon'] ?> text-secondary" title="<?= $data['icon'] ?>"></i></a>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>
                    <td class="text-center p-1"><?= esc($data['urutan']) ?></td>

                    <td class="p-1">

                        <?php if ($data['posisi'] == '0') { ?>
                            <a class="text-primary font-13"> Utama </a>
                        <?php } else if ($data['posisi'] == '1') { ?>
                            <a class="text-warning font-13"> Top Menu </a>
                        <?php } else if ($data['posisi'] == '2') { ?>
                            <a class="text-secondary font-13">Footer</a>
                        <?php } ?>
                    </td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['stsmenu'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['menu_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsmenu'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['stsmenu'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['menu_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsmenu'] ? 'btn-info' : 'btn-light' ?>" title="<?= $data['stsmenu'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                            <?php if ($data['posisi'] == '0') { ?>
                                <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['menu_id'] ?>')">
                                    <i class="icon fas fa-edit text-light"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-warning btn-sm p-1" onclick="editsec('<?= $data['menu_id'] ?>')">
                                    <i class="icon fas fa-edit text-light"></i>
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['menu_id'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } else { ?>
                            <label class="text-danger">Akses dibatasi.!</label>
                        <?php } ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>

                <th><b>Nama Menu</b></th>
                <th><b>Link </b></th>
                <th class="text-center"><b>Icon </b></th>
                <th><b>Urutan </b></th>
                <th><b>Posisi </b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $('#pilposisi').on('change', function() {
        const posisimn = $('#pilposisi option:selected').data('posisimn');
        $('[name=posisimn]').val(posisimn);
        listmenu();
    });
</script>

<script>
    $(document).ready(function() {
        $('#listmenu').DataTable();

        $('.tambahmenu').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('menu/formmenu') ?>",
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
                    });
                }
            });
        });


        $('.tambahmenusecond').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('menu/formmenusec') ?>",
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
                    });
                }
            });
        });

    });

    function edit(menu_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('menu/formeditmenu') ?>",
            data: {
                [csrfToken]: csrfHash,
                menu_id: menu_id
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

    function editsec(menu_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('menu/formeditmenusec') ?>",
            data: {
                [csrfToken]: csrfHash,
                menu_id: menu_id
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

    function hapus(menu_id) {
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
                    url: "<?= site_url('menu/hapusmenu') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        menu_id: menu_id
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
                                listmenu();
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

    function toggle(menu_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('menu/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                menu_id: menu_id
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
                    listmenu();
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