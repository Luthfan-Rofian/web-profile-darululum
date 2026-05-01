<button type="submit" class="btn btn-success btn-sm tambah">
    <i class="fas fa fa-plus-circle"></i> Tambah Transparansi Baru
</button>
<hr>
<div class="table-responsive b-0 ">
    <table id="listtransparansi" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="10" class="text-center"><b>#</b></th>
                <th><b>Judul</b></th>
                <th width="60" class="text-center"><b>Tahun</b></th>
                <th width="60" class="text-center"><b>Jenis</b></th>
                <th width="80" class="text-center"><b>Status</b></th>
                <th width="80" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>
                    <td class="p-1"> <a class="text-primary" href="<?= base_url('transparansi/detail/' . $data['transparan_id']) ?>" title="Detail Transparansi"> <?= esc($data['judul']) ?>
                            <?php if ($data['vawal'] == '1') { ?>
                                <small class="text-warning p-0">(Default)</small>
                            <?php } ?>
                        </a>
                    </td>
                    <td class="text-center p-1"><?= esc($data['tahun']) ?></td>
                    <td class="p-1">
                        <?php if ($data['jenis'] == '0') { ?>
                            <a class="text-primary"> Pendapatan</a>
                        <?php } else { ?>
                            <a class="text-danger"> Belanja</a>
                        <?php } ?>

                    </td>
                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['sts'] == '1') { ?>
                                <i class="icon fas fa-check-circle text-success ml-0 text-center pointer" onclick="toggle(<?= $data['transparan_id'] ?>)" title="Klik disini untuk Non Aktifkan"></i>
                                <label class="pointer" title="Klik disini untuk Non Aktifkan" onclick="toggle(<?= $data['transparan_id'] ?> )"> Aktif </label>
                            <?php } else { ?>
                                <i class="icon fas fa-times-circle text-danger ml-0 text-center pointer" onclick="toggle(<?= $data['transparan_id'] ?>)" title="Klik disini untuk terbitkan"></i>
                                <label class="text-danger pointer" title="Klik disini untuk aktifkan" onclick="toggle(<?= $data['transparan_id'] ?>)"> Non Aktif </label>
                            <?php  } ?>
                        <?php } else { ?>
                            <?php if ($data['sts'] == '1') { ?>
                                <i class="icon fas fa-check-circle text-success ml-0 text-center "></i>
                                <label class=""> Aktif </label>
                            <?php } else { ?>
                                <i class="icon fas fa-times-circle text-danger ml-0 text-center"></i>
                                <label class="text-danger"> Non Aktif </label>
                            <?php  } ?>
                        <?php  } ?>
                    </td>
                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <?php if ($data['vawal'] == '1') { ?>
                                <button type="button" onclick="toggledef('<?= $data['transparan_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['vawal'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['vawal'] ? 'Non aktifkan default halaman' : 'Jadikan Default Tampilan Awal' ?>"><i class="nav-icon fas fa-star text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggledef('<?= $data['transparan_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['vawal'] ? 'btn-light' : 'btn-light' ?>" title="<?= $data['vawal'] ? 'Nonaktifkan' : 'Jadikan Default Tampilan Awal' ?>"><i class="nav-icon fas fa-star text-danger"></i>
                                </button>
                            <?php } ?>
                        <?php } ?>
                        <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['transparan_id'] ?>')">
                            <i class="icon fas fa-edit text-light"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['transparan_id'] ?>','<?= $data['judul'] ?>')">
                            <i class="far fa-trash-alt text-light"></i>
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b>Judul</b></th>
                <th class="text-center"><b>Tahun</b></th>
                <th class="text-center"><b>Jenis</b></th>
                <th class="text-center"><b>Status</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#listtransparansi').DataTable();

        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('transparansi/formtambah') ?>",
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

    function edit(transparan_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('transparansi/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                transparan_id: transparan_id
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

    function hapus(transparan_id, nama) {
        Swal.fire({
            width: '400px',

            title: 'Hapus data?',
            // text: `Apakah anda yakin hapus data?`,
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
                    url: "<?= site_url('transparansi/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        transparan_id: transparan_id
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
                                listtransparansi();
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

    function toggle(transparan_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('transparansi/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                transparan_id: transparan_id
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
                    listtransparansi();
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
    // defaultkan tampilan
    function toggledef(transparan_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('transparansi/toggledef') ?>",
            data: {
                [csrfToken]: csrfHash,
                transparan_id: transparan_id
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
                    listtransparansi();
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