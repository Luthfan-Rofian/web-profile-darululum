<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahtema">
        <i class="fas fa fa-plus-circle"></i> Tambah Template Baru
    </button>
    <!-- <small class="text-secondary"> Nama Folder untuk template bawaan CMS <strong class="text-danger"> Jangan diganti..! </strong> </small> -->

    <hr>
<?php } ?>


<div class="row">
    <div class="col-12">
        <div class="card-deck-wrapper">
            <div class="card-deck">
                <?php
                foreach ($list as $data) :

                    $folpub = file_exists('public/template/' . $data['folder']);

                    if ($data['img'] != '') {
                        $gbr = $data['img'];
                    } else {
                        $gbr = 'default.png';
                    }

                    if ($folpub) {

                        if ($data['status'] == '1') {
                            if ($akses == 1) {
                ?>

                                <div class="col-lg-4 mt-1">
                                    <!-- <a class="pointer" onclick="toggle('<?= $data['template_id'] ?>')"> -->
                                    <div class="card shadow-sm p-1 bg-info" style="border: 1;  box-shadow: 1px;">
                                        <img class="card-img-top img-fluid" title=" <?= ($data['ket']) ?>" src="<?= base_url('public/img/template/' . $gbr) ?>" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title font-16 mt-0 text-center "><?= esc($data['nama']) ?> - <a class="text-danger"><?= esc($data['pembuat']) ?></a></h4>
                                            <!-- <p class="text-light"><?= ($data['ket']) ?></p> -->
                                            <small class="mt-1 pt-0">
                                                <div class="button-items">
                                                    <button class="btn btn-warning btn-sm waves-effect waves-light" onclick="edit('<?= $data['template_id'] ?>')" type="button"><i class="icon fas fa-edit text-light"></i> Edit</button>
                                                    <button class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus('<?= $data['template_id'] ?>','<?= $data['nama'] ?>')" type="button"><i class="icon far fa-trash-alt text-light"></i> Hapus</button>
                                                    <button class="btn btn-success btn-sm waves-effect waves-light" type="button"><i class="icon far fa-check-circle text-light"></i> Diterapkan</button>
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                    <!-- </a> -->
                                </div>
                                <!-- else no admin -->
                            <?php } else { ?>
                                <div class="col-lg-4 mt-1">
                                    <div class="card shadow-lg p-1" style="border: 1;  box-shadow: 1px;">
                                        <img class="card-img-top img-fluid" title="<?= ($data['ket']) ?>" src="<?= base_url('public/img/template/' . $gbr) ?>" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title font-16 mt-0 text-center text-primary"><?= esc($data['nama']) ?> - <a class="text-danger"><?= esc($data['pembuat']) ?></a></h4>
                                            <small class="mt-1 pt-0">
                                                <div class="button-items">
                                                    <button class="btn btn-success btn-sm waves-effect waves-light" type="button"><i class="icon far fa-check-circle text-light"></i> Telah Diterapkan</button>
                                                </div>
                                            </small>

                                        </div>
                                    </div>

                                </div>
                            <?php   }
                            // else non aktif
                        } else {
                            if ($akses == 1) {
                            ?>
                                <div class="col-lg-4 mt-1">
                                    <div class="card mb-2">
                                        <a class="pointer" title=" <?= ($data['ket']) ?>" onclick="toggle('<?= $data['template_id'] ?>','<?= $data['folder'] ?>')">
                                            <img class="card-img-top img-fluid" src="<?= base_url('public/img/template/' . $gbr) ?>" alt="Card image cap">
                                        </a>
                                        <div class="card-body">
                                            <h4 class="card-title font-16 mt-0 text-center text-primary"><?= esc($data['nama']) ?> - <a class="text-danger"><?= esc($data['pembuat']) ?></a></h4>
                                            <!-- <p><?= ($data['ket']) ?></p> -->
                                            <small class="mt-1 pt-0">
                                                <div class="button-items">
                                                    <button class="btn btn-info btn-sm waves-effect waves-light" onclick="edit('<?= $data['template_id'] ?>')" type="button"><i class="icon fas fa-edit text-light"></i> Edit</button>
                                                    <button class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus('<?= $data['template_id'] ?>','<?= $data['nama'] ?>')" type="button"><i class="icon far fa-trash-alt text-light"></i> Hapus</button>
                                                    <button class="btn btn-warning btn-sm waves-effect waves-light" onclick="toggle('<?= $data['template_id'] ?>','<?= $data['folder'] ?>')" title="Terapkan Tema" type="button"><i class="icon fas fa-palette text-light"></i> Terapkan</button>
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- no akses -->
                            <?php } else { ?>
                                <div class="col-lg-4 mt-1">
                                    <div class="card mb-2">
                                        <img class="card-img-top img-fluid" src="<?= base_url('public/img/template/' . $gbr) ?>" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title font-16 mt-0 text-center text-primary"><?= esc($data['nama']) ?> - <a class="text-danger"><?= esc($data['pembuat']) ?></a></h4>

                                            <small class="mt-1 pt-0">
                                                <div class="button-items">

                                                    <button class="btn btn-warning btn-sm waves-effect waves-light" type="button"><i class="icon fas fa-palette text-light"></i> Tidak diterapkan</button>
                                                </div>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                <?php }
                endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- end row -->
<script>
    //aktifnonaktif

    function toggle(template_id, folder) {
        $.ajax({
            type: "post",
            url: "<?= site_url('template/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                template_id: template_id,
                folder: folder
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
                    listtemplate();
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


    $(document).ready(function() {
        $('#listtemplate').DataTable();
        $('.tambahtema').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('template/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
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


    function edit(template_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('template/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                template_id: template_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
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

    function hapus(template_id, nama) {
        Swal.fire({
            width: '400px',
            title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('template/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        template_id: template_id
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
                                listtemplate();
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