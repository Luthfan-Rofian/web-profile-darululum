<a href="javascript:window.history.go(-1);" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>

<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahsubmenu">
        <i class="fas fa fa-plus-circle"></i> Tambah Menu Baru
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0 ">
    <table id="listsubsubmenu" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="30" class="text-center"><b>#</b></th>
                <th><b>Menu</b></th>
                <th><b>Link</b></th>
                <th width="20"><b>Urutan</b></th>
                <th width="70" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1">
                        <?php if ($data['iconssm'] != '') { ?>
                            &nbsp; <i class="<?= $data['iconssm'] ?> text-secondary" title="<?= $data['iconssm'] ?>"></i><a class="text-warning font-12"></a>
                        <?php } ?>
                        <?= esc($data['nama_subsubmenu']) ?>
                    </td>

                    <td class="p-1">

                        <i class="mdi mdi-link-variant"></i>
                        <a target="_blank" href="<?php echo base_url($data['link_subsubmenu']) ?>"><?= esc($data['link_subsubmenu']) ?> </a>

                    </td>

                    <td class="text-center p-1"><?= esc($data['urutanssm']) ?></td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['stsssm'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['subsubmenu_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsssm'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['stsssm'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['subsubmenu_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsssm'] ? 'btn-light' : 'btn-light' ?>" title="<?= $data['stsssm'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['subsubmenu_id'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['subsubmenu_id'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php } else { ?>
                            <a class="text-danger p-1">Akses dibatasi.!</a>
                        <?php } ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>

                <th><b>Menu</b></th>
                <th><b>Link </b></th>
                <!-- <th><b>Induk</b></th> -->
                <th><b>Urutan</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        $('#listsubsubmenu').DataTable();

        $('.tambahsubmenu').click(function(e) {
            e.preventDefault();
            submenu_id = $("#submenu_id").val();
            $.ajax({
                data: {
                    submenu_id: submenu_id,
                },
                url: "<?= site_url('menu/formsubsubmenu') ?>",
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

    function edit(subsubmenu_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('menu/formeditsubsubmenu') ?>",
            data: {
                [csrfToken]: csrfHash,
                subsubmenu_id: subsubmenu_id
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

    function hapus(subsubmenu_id) {
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
                    url: "<?= site_url('menu/hapussubsubmenu') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        subsubmenu_id: subsubmenu_id
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
                                listsubsubmenu();
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

    function toggle(subsubmenu_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('menu/togglesubsub') ?>",
            data: {
                [csrfToken]: csrfHash,
                subsubmenu_id: subsubmenu_id
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
                    listsubsubmenu();
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
</script>