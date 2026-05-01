<a href="<?= base_url('modul/') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>

<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahmodpublik">
        <i class="fas fa fa-plus-circle"></i> Tambah Modul Publik Baru
    </button>
<?php } ?>
<small class="text-secondary"> Modul Publik Adalah modul yang akan diakses publik, dan menjadi pilihan dalam pembuatan <strong class="text-danger">Menu, Sub Menu, Banner dll</strong> </small>
<hr>
<div class="table-responsive b-0 ">
    <table id="listpublik" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>Modul Publik</b></th>
                <th width="120"><b>Link</b></th>
                <th width="80" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1"><?= esc($data['modpublic']) ?></td>

                    <td class="p-1">
                        <i class="mdi mdi-link-variant"></i>
                        <a target="_blank" href="<?php echo base_url($data['link']) ?>"><?= esc($data['link']) ?> </a>
                    </td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['stsmod'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modpublic'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsmod'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['stsmod'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modpublic'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['stsmod'] ? 'btn-info' : 'btn-light' ?>" title="<?= $data['stsmod'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>
                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['id_modpublic'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['id_modpublic'] ?>')">
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
                <th><b>Modul Publik</b></th>
                <th><b>Link</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {

        var table = $('#listpublik').DataTable({
            "ordering": false,
        });

        $('.tambahmodpublik').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('modul/formpublik') ?>",
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

    function edit(id_modpublic) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/formeditpublik') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_modpublic: id_modpublic
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

    function hapus(id_modpublic) {
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
                    url: "<?= site_url('modul/hapuspublik') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id_modpublic: id_modpublic
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
                                listpublik();
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

    function toggle(id_modpublic) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/togglepublik') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_modpublic: id_modpublic
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
                    listpublik();
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