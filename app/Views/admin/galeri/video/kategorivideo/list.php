<a href="<?= base_url('video/all') ?>" class="btn btn-warning btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>
<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahkategori">
        <i class="fas fa fa-plus-circle"></i> Tambah Kategori Baru
    </button>
<?php } ?>
<hr>
<div class="table-responsive b-0 ">
    <table id="listkategorivideo" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>KATEGORI</b></th>
                <th width="60" class="text-center"><b>AKSI</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center p-1"><?= $nomor ?></td>
                    <td class="p-1">&nbsp;&nbsp;<?= esc($data['nama_kategori_video']) ?></td>
                    <td class="text-center p-1">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-info btn-sm p-1" onclick="edit('<?= $data['kategorivideo_id'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['kategorivideo_id'] ?>')">
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
                <th><b>KATEGORI</b></th>
                <th class="text-center"><b>AKSI<b></th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {
        // $('#listkategorivideo').DataTable();
        var table = $('#listkategorivideo').DataTable({

            "ordering": false,

            // "pagingType": "numbers",
        });
        $('.tambahkategori').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('video/formkategori') ?>",
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

    function edit(kategorivideo_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('video/formeditkategori') ?>",
            data: {
                [csrfToken]: csrfHash,
                kategorivideo_id: kategorivideo_id
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

    function hapus(kategorivideo_id) {
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
                    url: "<?= site_url('video/hapuskategori') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        kategorivideo_id: kategorivideo_id
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
                                listkategorivideo();
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