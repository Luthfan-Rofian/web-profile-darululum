<?= form_open('tanyajawab/hapusjwball', ['class' => 'formhapus']) ?>


<a href="javascript:window.history.go(-1);" class="btn btn-info btn-sm "><i class="far fa-arrow-alt-circle-left font-14"></i> Kembali</a>

<div class="float-right">
    <button type="button" class="btn btn-block btn-primary btn-sm tambah"><i class="fas fa fa-plus-circle"></i> TAMBAH DATA</button>
</div>
<button type="submit" class="btn btn-danger btn-sm tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang diceklist
</button>

<hr>
<div class="table-responsive b-0">
    <table id="listjawaban" class="table table-hover table-striped">

        <thead>
            <tr>
                <th width="4">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <th width="10"># </th>
                <th>Jawaban</th>
                <th width="40" class="text-center">Aksi </th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="faq_jawabid[]" class="centang_id" value="<?= $data['faq_jawabid'] ?>">
                    </td>
                    <td><?= $nomor ?></td>
                    <td>
                        <?= ($data['faq_jawaban']) ?>
                    </td>


                    <td class="text-center p-0">

                        <button type="button" title="Edit Data" class="btn btn-warning btn-sm" onclick="edit('<?= $data['faq_jawabid'] ?>','<?= $data['faq_tanyaid'] ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" title="Hapus Data" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['faq_jawabid'] ?>')">
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
                <th>Jawaban</th>

                <th class="text-center">Aksi </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    $(document).ready(function() {

        $('#listjawaban').DataTable();

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centang_id').prop('checked', true);
            } else {
                $('.centang_id').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centang_id:checked');
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
                    title: `Apakah anda yakin menghapus ${jmldata.length} data ini?`,
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
                                listjawaban();
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )

                            }
                        });
                    }
                })
            }
        });
    });

    function edit(faq_jawabid, faq_tanyaid) {

        $.ajax({
            type: "post",
            url: "<?= site_url('tanyajawab/formeditjawaban') ?>",
            data: {
                [csrfToken]: csrfHash,
                faq_jawabid: faq_jawabid,
                faq_tanyaid: faq_tanyaid

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

    function hapus(faq_jawabid) {
        Swal.fire({

            html: `Apakah anda yakin menghapus jawaban ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('tanyajawab/hapusjawaban') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        faq_jawabid: faq_jawabid
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
                            listjawaban();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )

                    }
                });
            }
        })
    }


    //tambah data
    $(document).ready(function() {

        $('.tambah').click(function(e) {
            e.preventDefault();
            faq_tanyaid = $("#faq_tanyaid").val();
            $.ajax({
                url: "<?= site_url('tanyajawab/formtambahjawaban') ?>",
                data: {
                    faq_tanyaid: faq_tanyaid,
                },
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
</script>