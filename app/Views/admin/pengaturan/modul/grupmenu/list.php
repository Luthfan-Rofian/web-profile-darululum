<?php

use App\Models\M_Dge_modul;

$this->modulecms = new M_Dge_modul();
?>

<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambah">
        <i class="fas fa fa-plus-circle"></i> Tambah Menu
    </button>
    <a href="modul/publik" button type="button" title="Kelola Modul Publik CMS Lembaga" class="btn btn-primary btn-sm mr-1">
        <i class="fas fa-copy text-light"></i> Modul Publik
    </a>
<?php } ?>

<small class="text-secondary">Modul ini berfungsi untuk Membuat Menu Utama pada Backend CMS dan <strong class="text-danger"> pembuatan Grup baru, </strong> (jika ada modul baru dengan pengelompokan baru). </small>
<hr>
<div class="table-responsive b-0 ">
    <table id="listgrupmenu" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>NAMA MENU</b></th>
                <th width="120"><b>GRUP</b></th>
                <th width="50"><b>URUTAN</b></th>
                <th width="100" class="text-center"><b>AKSI</b></th>
            </tr>
        </thead>

        <tbody>

            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
                $gm = $data['gm'];
                $jumgm = $this->modulecms->selectCount('gm')->where('tipemn', 'sm')->where('gm =', $gm)->first();
            ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>

                    <td class="p-1">&nbsp;<i class="<?= $data['ikonmn'] ?>"></i> <a class="text-primary" href="<?= base_url('modul/det/' . $data['gm']) ?>"><?= esc($data['modul']) ?><a class="text-danger" title="Jumlah Submenu"> (<?= esc($jumgm['gm']) ?>)</a></a></td>
                    <td class="p-1">&nbsp;<?= esc($data['gm']) ?></td>
                    <td class="text-center p-1"><?= esc($data['urut']) ?></td>

                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>

                            <?php if ($data['aktif'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modul'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['aktif'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle font-13 text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['id_modul'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['aktif'] ? 'btn-light' : 'btn-light' ?>" title="<?= $data['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                            <button type="button" class="btn btn-warning btn-sm p-1" title="Ganti Nama Menu" onclick="edit('<?= $data['id_modul'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>

                            <?php if ($data['level'] == '3') { ?>

                                <button type="button" class="btn btn-social btn-flat btn-primary btn-sm p-1" title="Kelola Akses Menu" onclick="setakses('<?= $data['id_modul'] ?>')">
                                    <i class="icon fas fa-user-ninja text-light"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm p-1" title="Hapus Data Grup" onclick="hapus('<?= $data['id_modul'] ?>')">
                                    <i class="far fa-trash-alt text-light"></i>
                                </button>
                            <?php } ?>
                        <?php } else { ?>
                            <a class="text-danger">Akses dibatasi.!</a>
                        <?php } ?>

                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>

        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b>NAMA MENU</b></th>
                <th><b>GRUP</b></th>
                <th><b>URUTAN</b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>

</div>
<script>
    $(document).ready(function() {
        // $('#listmodul').DataTable();
        var table = $('#listgrupmenu').DataTable({
            "ordering": false,
        });
        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('modul/formtambahmenu') ?>",
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
                        // showConfirmButton: false,
                        // timer: 3100
                    }).then(function() {
                        // window.location = '';
                    })
                }
            });
        });
    });


    function edit(id_modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/formeditmenu') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_modul: id_modul
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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }

    function hapus(id_modul, modul) {
        Swal.fire({
            width: '400px',
            title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${modul}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('modul/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id_modul: id_modul
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
                                listgrupmenu();
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

    // set ke role yang ada
    function setakses(id_modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/formsetaksesmenu') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_modul: id_modul
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
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }

    function toggle(id_modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('modul/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_modul: id_modul
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
                    listgrupmenu();
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
</script>