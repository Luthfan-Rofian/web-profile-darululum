<?= form_open('dokumen/hapusall', ['class' => 'formhapus']) ?>
<button type="submit" class="btn btn-success btn-sm tambahdokumen">
    <i class="fas fa fa-plus-circle"></i> Tambah Dokumen Baru
</button>
<button type="submit" class="btn btn-danger btn-sm tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
</button>
<small class="text-secondary"> Modul ini berfungsi mengirim Data/Dokumen ke Administrator Lintas Unit Kerja. Modul tidak disertakan dalam CMS. <span class="text-warning">(Custome Module)</span></small>
<hr>
<div class="table-responsive b-0">
    <table id="listdokumen" class="table table-hover dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">

        <thead class="bg-light">
            <tr>
                <th width="4">
                    <input type="checkbox" id="centangSemua" class="text-center">
                </th>
                <!-- <th width="15"># </th> -->
                <th width="350"><b>Nama Dokumen</b></th>
                <th><b>Kategori</b></th>
                <th width="90"><b>Tgl Posting</b></th>
                <th><b>Pengirim</b></th>
                <th><b>Unit Kerja</b></th>
                <th width="90" class="text-center"><b>Aksi</b> </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>

                <th>
                    <input type="checkbox" class="text-center" disabled>
                </th>
                <!-- <th>#</th> -->
                <th><b>Nama Dokumen</b></th>
                <th><b>Kategori</b></th>
                <th><b>Tgl Posting</b></th>
                <th><b>Pengirim</b></th>
                <th><b>Unit Kerja</b></th>

                <th class="text-center"><b>Aksi</b> </th>

            </tr>
        </tfoot>
    </table>
</div>
<?= form_close() ?>

<script>
    function AmbilData() {

        var table = $('#listdokumen').DataTable({
            "processing": true,
            "serverSide": true,
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sSearch": "Pencarian: ",
                "sZeroRecords": "Data tidak tersedia",
                "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
                "sInfoFiltered": "(di filter dari _MAX_ total data)",
                "oPaginate": {
                    "sFirst": "«",
                    "sLast": "»",
                    "sPrevious": "«",
                    "sNext": "»"
                }
            },
            "order": [],
            "ajax": {

                "url": "<?php echo site_url('dokumen/listdata2') ?>",
                "type": "POST",
                error: function() { // error handling
                    $(".listdokumen-error").html("");
                    $("#listdokumen").append('<tbody class="listdokumen-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                    $("#listdokumen_processing").css("display", "none");

                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },

                {
                    "targets": 5,
                    "orderable": false,
                }
            ],
        });
    }
</script>

<script>
    $(document).ready(function() {
        // $('#listdokumen').DataTable();
        AmbilData();

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
                                listdokumen();
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

    function edit(id_dokumenupl) {
        $.ajax({
            type: "post",
            url: "<?= site_url('dokumen/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_dokumenupl: id_dokumenupl

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

    function hapus(id_dokumenupl) {
        Swal.fire({

            html: `Apakah anda yakin menghapus data ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('dokumen/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        id_dokumenupl: id_dokumenupl
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
                            listdokumen();
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

        $('.tambahdokumen').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('dokumen/formtambah') ?>",
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


    //uploadfile
    function uploadfile(id_dokumenupl) {

        $.ajax({
            type: "post",
            url: "<?= site_url('dokumen/formuploadfile') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_dokumenupl: id_dokumenupl,
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