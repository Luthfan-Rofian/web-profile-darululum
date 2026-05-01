<?php if ($akses == 1) { ?>
    <button type="submit" class="btn btn-success btn-sm tambahproduk">
        <i class="fas fa fa-plus-circle"></i> Tambah Produk Hukum Baru
    </button>
    <hr>
<?php } ?>
<div class="table-responsive b-0 ">
    <table id="listprodukhukum" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th width="95" class="text-center"><b>Aksi</b></th>
                <th><b>Produk Hukum</b></th>
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


                            <a href="<?= base_url('produkhukum/subproduk/' . $data['produk_id']) ?>" title="Detail Produk Hukum" class="btn btn-primary btn-sm p-1"><i class="fas fa-list text-light"></i></a>

                            <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['produk_id'] ?>')">
                                <i class="icon fas fa-edit text-light"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['produk_id'] ?>','<?= $data['nama_produk'] ?>')">
                                <i class="far fa-trash-alt text-light"></i>
                            </button>
                        <?php  } else { ?>
                            <label class="text-danger">Akses dibatasi..!</label>
                        <?php } ?>
                    </td>
                    <td><?= esc($data['nama_produk']) ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th class="text-center"><b>Aksi<b></th>
                <th><b>Produk Hukum</b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {

        var table = $('#listprodukhukum').DataTable({
            "ordering": false,
        });

        $('.tambahproduk').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('produkhukum/formtambah') ?>",
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

    function edit(produk_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('produkhukum/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                produk_id: produk_id
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

    function hapus(produk_id, nama) {
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
                    url: "<?= site_url('produkhukum/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        produk_id: produk_id
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
                                listprodukhukum();
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


    function formkathukum(produk_id) {
        $.ajax({
            url: "<?= site_url('produkhukum/bukakathukum') ?>",
            data: {
                produk_id: produk_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.sukses).show();
                // $('.viewdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kodex Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });
            }
        });
    }
</script>