<?= form_open('user/hapusall', ['class' => 'formhapus']) ?>
<?php

$db = \Config\Database::connect();
?>
<button type="submit" class="btn btn-danger btn-sm tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
</button>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahuser">
        <i class="fas fa fa-plus-circle"></i> Tambah Pengguna Baru
    </button>
    <a href="user/grup" button type="button" class="btn btn-primary btn-sm">
        <i class="fas fa-user-shield text-light"></i> Kelola Grup
    </a>
<?php } ?>

<hr>
<div class="table-responsive p-0 order-table">
    <table id="listuser" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="30"><b>Foto</b></th>
                <th width="85"><b>User Name</b></th>
                <th><b>Nama</b></th>
                <th><b>Email</b></th>
                <th width="70"><b>Role Grup</b></th>
                <th width="90"><b>Last Login</b></th>
                <th width="70" class="text-center"><b>Aksi</b> </th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($list as $value) :
                // $level = $value['level'];

                $id_grup = $value['id_grup'];
                $listgrup = $db->table('cms__usergrup')->where('id_grup', $id_grup)->get()->getRowArray();

                if ($value['user_image'] != 'default.png' && file_exists('public/img/user/' . $value['user_image'])) {
                    $profil = $value['user_image'];
                } else {
                    $profil = 'default.png';
                }

                if ($listgrup) {
                    $namagrup = $listgrup['nama_grup'];
                    $jenisgrp = $listgrup['jenis'];
                } else {
                    $namagrup = '-';
                }
                if ($value["last_login"] != '') {
                    # code...
                    $blnk = date('m', strtotime($value["last_login"]));
                    $blnck = bulan($blnk);
                    $tglk = date('d', strtotime($value["last_login"]));
                    $thnk = date('Y', strtotime($value["last_login"]));
                    $jamk = date('H:i:s', strtotime($value["last_login"]));
                } else {
                    $blnk = '';
                    $blnck = '';
                    $tglk = '';
                    $thnk = '';
                    $jamk = '';
                }

                $opd_id = $value['opd_id'];
                $viewopd = $db->table('custome__opd')->where('opd_id', $opd_id)->where('opd_id !=', 0)->get()->getRowArray();


            ?>
                <tr>
                    <td>
                        <input type="checkbox" name="id[]" class="centangUserid" value="<?= $value['id'] ?>">
                    </td>
                    <td class="p-0"><img class="img-circle elevation-2 rounded pointer" onclick="gantifoto('<?= $value['id'] ?>')" src="<?= base_url('public/img/user/' . $profil) ?>" width="50px" title="Klik disini untuk Ganti Foto"></td>

                    <td class="p-0">
                        <?php if ($value['active'] != '1') { ?>
                            <a class="text-danger"><?= $value['username'] ?></a>
                        <?php } else { ?>
                            <?= $value['username'] ?>
                        <?php } ?>
                        <?php if ($value['active'] == '1') { ?>
                            <br>
                            <?php if ($value['sts_on'] == '1') { ?>
                                <span class="badge badge-success badge-pill">
                                    <i class="mdi mdi-checkbox-blank-circle text-success"></i> Online
                                </span>
                            <?php } else { ?>
                                <span class="badge badge-warning badge-pill">
                                    <i class="mdi mdi-checkbox-blank-circle text-warning"></i> Offline
                                </span>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="p-0">

                        <?= $value['fullname'] ?> <br>
                        <?php if ($viewopd) { ?>
                            <a class="text-primary" title="Unit Kerja : <?= $viewopd['nama_opd'] ?>"><?= $viewopd['singkatan_opd'] ?></a>
                        <?php } ?>
                    </td>
                    <td class="p-0"><?= $value['email'] ?><br>
                        <a class="text-danger" title="Upaya Login"><?= $value['login_attempts'] != '' ? ' (' . $value['login_attempts'] . ')' : '' ?></a>
                    </td>
                    <td class="p-0"><?= $namagrup ?></td>

                    <td>
                        <?php if ($value['last_login'] != '') { ?>
                            <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?>
                        <?php } else { ?>
                            -
                        <?php } ?>
                    </td>

                    <td class="text-center p-0">

                        <?php if ($akses == 1) { ?>

                            <?php if ($jenisgrp != '1') { ?>

                                <?php if ($value['active'] == '1') { ?>
                                    <button type="button" onclick="toggle('<?= $value['id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $value['active'] ? 'btn-light' : 'btn-success' ?>" title="<?= $value['active'] ? 'Non Aktifkan Akun' : 'Aktifkan' ?>"><i class="nav-icon fas fa-user-check text-success"></i>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" onclick="toggle('<?= $value['id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $value['active'] ? 'btn-info' : 'btn-light' ?>" title="<?= $value['active'] ? 'Non Aktifkan' : 'Aktifkan Akun' ?>"><i class="nav-icon fas fa-user-alt-slash text-danger"></i>
                                    </button>
                                <?php } ?>


                            <?php } ?>
                            <button type="button" class="btn btn-info btn-sm p-1" title="Lihat Statistik Postingan" onclick="lihat('<?= $value['id'] ?>','<?= $jenisgrp ?>')">
                                <i class="nav-icon fa fa-search "></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $value['id'] ?>','<?= $jenisgrp ?>')">
                                <i class="fa fa-edit"></i>
                            </button>

                        <?php } ?>
                        <?php if ($jenisgrp != '1') { ?>

                            <button type="button" class="btn btn-danger btn-sm waves-effect waves-light p-1" onclick="hapus('<?= $value['id'] ?>','<?= $value['fullname'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php }  ?>

                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>

                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <th><b>Foto</b></th>
                <th><b>User Name</b></th>
                <th><b>Nama</b></th>
                <th><b>Email</b></th>
                <th><b>Role Grup</b></th>
                <th><b>Last Login</b></th>
                <th class="text-center"><b>Aksi</b> </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#listuser').DataTable();

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangUserid').prop('checked', true);
            } else {
                $('.centangUserid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangUserid:checked');
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
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} user?`,
                    text: 'Semua user yang terpilih akan terhapus!',
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
                                listuser();
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

    function edit(id, jenisgrp) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                id: id,
                jenisgrp: jenisgrp
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                    $('#modaledit').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
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

    function lihat(id, jenisgrp) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                id: id,
                jenisgrp: jenisgrp
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal('show');
                    $('#modallihat').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
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

    function hapus(id, nama) {
        Swal.fire({

            html: `Apakah anda yakin menghapus <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('user/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id: id
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
                            listuser();
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

        $('.tambahuser').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('user/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal('show');
                    $('#modaltambah').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
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

    //aktifnonaktif

    function toggle(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('user/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                id: id
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
                    listuser();
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

    function gantifoto(id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('user/formgantifoto') ?>",
            data: {
                id: id,
                [csrfToken]: csrfHash,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal('show');
                    $('#modalupload').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

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