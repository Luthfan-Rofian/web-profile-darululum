<div class="table-responsive b-0 ">
    <table id="listsurveypesan" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th width="100"><b>Nama</b></th>
                <th width="100"><b>No HP</b></th>
                <th><b>Pesan</b></th>
                <th width="100"><b>Tanggal Isi</b></th>
                <th width="60" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td class="text-center"><?= $nomor ?></td>
                    <td>
                        <?= htmlentities($data['nama']) ?>
                    </td>
                    <td>
                        <?= esc($data['nohp']) ?>
                    </td>
                    <td>
                        <?= htmlentities($data['saran']) ?>

                    </td>
                    <td> <?= date_indo($data['tanggal']) ?></td>
                    <td class="text-center p-0">
                        <button type="button" title="Hapus Data" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['responden_id'] ?>','<?= $data['saran'] ?>')">
                            <i class="far fa-trash-alt text-light"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b>Nama</b></th>
                <th><b>No HP</b></th>
                <th><b>Pesan</b></th>
                <th><b>Tanggal Isi</b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#listsurveypesan').DataTable();
    });


    function hapus(responden_id, nama) {
        Swal.fire({
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
                    url: "<?= site_url('survey/hapusrespon') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        responden_id: responden_id
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
                                listsurveypesan();
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