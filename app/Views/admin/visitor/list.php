<?= form_open('visitor/hapusall', ['class' => 'formhapus']) ?>
<hr>
<!-- 
<button type="submit" class="btn btn-danger btn-sm tblhapus" id="tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
</button> -->


<button type="button" class="btn btn-danger btn-sm tblhapus" id="tblhapus" onclick="hapussemua('x1')">
    <i class="far fa-trash-alt text-light"></i> Kosongkan Statistik Pengunjung
</button>

<hr>
<div class="table-responsive b-0 ">
    <table id="listvisitor" class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="5">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="25"># </th>
                <th>IP</th>
                <th width="30" class="text-center">Jumlah</th>
                <th>Request URL</th>
                <!-- <th>Browser</th> -->
                <th width="120">Tanggal</th>
                <th width="20" class="text-center">Aksi </th>

            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $value) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="visitor_id[]" class="centangid" value="<?= $value['visitor_id'] ?>">
                    </td>
                    <td><?= $nomor ?></td>

                    <td><?= $value['ip_address'] ?></td>
                    <td class="text-center"><?= $value['no_of_visits'] ?></td>
                    <td><?= $value['requested_url'] ?></td>
                    <!-- <td><?= $value['user_agent'] ?></td> -->
                    <td><?= $value['access_date'] ?></td>

                    <td class="text-center p-0">

                        <button type="button" class="btn btn-danger btn-sm" id="tblhapus" onclick="hapus('<?= $value['visitor_id'] ?>','<?= $value['page_name'] ?>')">
                            <i class="far fa-trash-alt text-light"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>

                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <th>#</th>
                <th>IP</th>
                <th class="text-center">Jumlah</th>
                <th>Request URL</th>
                <!-- <th>Browser</th> -->
                <th>Tanggal</th>
                <th class="text-center">Aksi</th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    //hapus multi
    $(document).ready(function() {
        $('#listvisitor').DataTable();
        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangid').prop('checked', true);
            } else {
                $('.centangid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangid:checked');
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
                    title: `Apakah anda yakin ingin menghapus ${jmldata.length} data ini?`,
                    text: 'Semua data yang terpilih akan terhapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak'
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
                                listvisitor();
                            }
                        });
                    }
                })
            }
        });
    });


    function hapus(visitor_id, ket) {

        Swal.fire({
            // title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${ket}</strong> ini ?`,

            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('visitor/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        visitor_id: visitor_id
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
                            listvisitor();
                        }
                    }
                });
            }
        })
    }

    function hapussemua(visitor_id) {

        Swal.fire({
            // title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>semua data</strong> ini ?`,

            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus semua!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('visitor/hapussemua') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        visitor_id: visitor_id
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
                            listvisitor();
                        }
                    },

                    error: function(xhr, ajaxOptions, thrownerror) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownerror);
                    }
                });
            }
        })
    }
</script>