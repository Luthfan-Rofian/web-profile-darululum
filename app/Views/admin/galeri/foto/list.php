<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahkategori">
        <i class="fas fa fa-plus-circle"></i> Tambah Album Baru
    </button>
<?php } ?>
<hr>

<div class="table-responsive b-0 ">
    <table id="listkategorifoto" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="6" class="text-center"><b>#</b></th>
                <th width="50" class="text-center"><b>Cover</b></th>
                <th><b>Kategori Foto</b></th>
                <th><b>Deskripsi</b></th>
                <th width="60" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center"><?= $nomor ?></td>
                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <img class="img-circle elevation-2 pointer p-0" onclick="gantifoto('<?= $data['kategorifoto_id'] ?>')" src="<?= base_url('public/img/galeri/katfoto/' . $data['cover_foto']) ?>" title="Ganti Cover" width="70px">
                        <?php } else { ?>
                            <img class="img-circle elevation-2 p-0" src="<?= base_url('public/img/galeri/katfoto/' . $data['cover_foto']) ?>" width="70px">

                        <?php } ?>
                    </td>

                    <td class="p-0">
                        <?php if ($akses == 1 || $akses == 2) { ?>
                            <a class="text-primary" href="<?= base_url('foto/det/' . $data['kategorifoto_id']) ?>" title="Detail Foto"> <?= esc($data['nama_kategori_foto']) ?></a>
                        <?php } else { ?>
                            <a class="text-primary" href="#"> <?= esc($data['nama_kategori_foto']) ?></a>
                        <?php } ?>
                    </td>
                    <td><?= esc($data['ket']) ?></td>
                    <td class="text-center p-0">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-info btn-sm p-1" onclick="edit('<?= $data['kategorifoto_id'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['kategorifoto_id'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
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
                <th width="20" class="text-center"><b>Cover</b></th>
                <th><b>Kategori Foto</b></th>
                <th><b>Deskripsi</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#listkategorifoto').DataTable();
        $('.tambahkategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('foto/formkategori') ?>",
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

    function edit(kategorifoto_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('foto/formeditkategori') ?>",
            data: {
                [csrfToken]: csrfHash,
                kategorifoto_id: kategorifoto_id
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

    function hapus(kategorifoto_id) {
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
                    url: "<?= site_url('foto/hapuskategori') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        kategorifoto_id: kategorifoto_id
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
                                listkategorifoto();
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

    function gantifoto(kategorifoto_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('foto/ganticoverkat') ?>",
            data: {
                [csrfToken]: csrfHash,
                kategorifoto_id: kategorifoto_id,
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
                    title: "Maaf gagal update Foto!",
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