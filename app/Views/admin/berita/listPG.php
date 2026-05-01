<?= form_open('berita/hapusall', ['class' => 'formhapus']) ?>
<button type="submit" class="btn btn-success btn-sm tambahberita">
    <i class="fas fa fa-plus-circle"></i> Tambah Berita Baru
</button>

<button type="submit" class="btn btn-danger btn-sm tblhapus">
    <i class="far fa-trash-alt text-light"></i> Hapus yang dipilih
</button>
<hr>


<div class="table-responsive b-0 ">
    <!-- <table id="databerita" class="table table-responsive table-hover table-striped "> -->
    <table id="databerita2" class="table table-striped table-hover dt-responsive " style="border-collapse: collapse; border-spacing: 0; width: 100%;">

        <thead>
            <tr>
                <th width="1"><input type="checkbox" id="centangSemua"></th>
                <th width="40" class="text-center"><b>Sampul</b></th>
                <th><b>Judul</b></th>
                <th><b>Kategori</b></th>
                <th><b>Tanggal</b></th>
                <th><b>Penerbit</b></th>
                <th class="text-center" width="70"><b>Status</b></th>
                <th class="text-center" width="80"><b>Aksi</b> </th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td>
                        <input type="checkbox" name="berita_id[]" class="centangBeritaid" value="<?= $data['berita_id'] ?>">
                    </td>
                    <td class="text-center"><img class="img-circle elevation-2 pointer" onclick="gantifoto('<?= $data['berita_id'] ?>')" src="<?= base_url('public/img/informasi/berita/' . $data['gambar']) ?>" width="50px"></td>

                    <td><?= esc($data['judul_berita']) ?> <span class="badge badge-info" title="dilihat" style="font-size:10px">(<?= $data['hits'] ?>) </span></td>
                    <td><?= esc($data['nama_kategori']) ?></td>
                    <td><?= date_indo($data['tgl_berita']) ?></td>
                    <td><?= esc($data['fullname']) ?></td>
                    <td>
                        <?php if ($data['status'] == '1') { ?>
                            <h6>
                                <span class="badge badge-success">Aktif</span>

                            </h6>
                        <?php } else { ?>
                            <h6>
                                <span class="badge badge-danger">Tidak Aktif</span>
                            </h6>
                        <?php } ?>
                    </td>

                    <td class="text-center p-0">

                        <?php if ($data['status'] == '1') { ?>
                            <button type="button" onclick="toggle('<?= $data['berita_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-secondary' : 'btn-success' ?>" title="<?= $data['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="fas fa-eye-slash"></i>
                            </button>
                        <?php } else { ?>
                            <button type="button" onclick="toggle('<?= $data['berita_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-secondary' : 'btn-success' ?>" title="<?= $data['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>"><i class="fas fa-eye"></i>
                            </button>
                        <?php } ?>

                        <button type="button" class="btn btn-primary btn-sm p-1" onclick="edit('<?= $data['berita_id'] ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['berita_id'] ?>','<?= $data['judul_berita'] ?>')">
                            <i class="far fa-trash-alt text-light"></i>
                        </button>


                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th><input type="checkbox" class="text-center" disabled></th>
                <th><b>Sampul</b></th>
                <th><b>Judul</b></th>
                <th><b>Kategori</b></th>
                <th><b>Tanggal</b></th>
                <th><b>Penerbit</b></th>
                <th class="text-center"><b>Status</b></th>
                <th class="text-center"><b>Aksi</b> </th>

            </tr>
        </tfoot>
    </table>
    <ul class="pagination justify-content-right">
        <?= $pager->links('hal', 'datagoe'); ?>
    </ul>
</div>

<?= form_close() ?>

<script>
    function AmbilDataBerita() {

        var table = $('#databerita').DataTable({
            "processing": true,
            "serverSide": true,
            "oLanguage": {
                "sLengthMenu": "Tampilkan _MENU_ data per halaman",
                "sSearch": "Pencarian: ",
                "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
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

                "url": "<?php echo site_url('berita/listdata2') ?>",
                "type": "POST",
                error: function() { // error handling
                    $(".databerita-error").html("");
                    $("#databerita").append('<tbody class="databerita-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
                    $("#databerita_processing").css("display", "none");

                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": 1,
                    "orderable": false,
                },
                {
                    "targets": 3,
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
        // AmbilDataBerita();

        // $('#databerita2').DataTable();
        $('#databerita2').DataTablez();

        // $(kembali).hide();

        $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangBeritaid').prop('checked', true);
            } else {
                $('.centangBeritaid').prop('checked', false);

            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangBeritaid:checked');
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
                                $('.tblhapus').html('<i class="far fa-trash-alt text-light"></i> Hapus yang diceklist');
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
                                listberita();
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                Swal.fire({
                                    title: "Maaf gagal hapus data!all",
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
        });
    });

    function edit(berita_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('berita/formedit') ?>",
            data: {
                berita_id: berita_id

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

    function hapus(berita_id) {
        Swal.fire({
            // title: 'Hapus data?',
            html: `Anda yakin hapus berita dengan ID <strong>${berita_id}</strong> ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('berita/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        berita_id: berita_id
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
                            listberita();
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

    //tambah data
    $(document).ready(function() {
        // listberita();
        $('.tambahberita').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('berita/formtambah') ?>",
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


    //aktifnonaktif

    function toggle(id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('berita/toggle') ?>",
            data: {
                id: id
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
                    listberita();
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

    function gantifoto(berita_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('berita/formgantifoto') ?>",
            data: {
                berita_id: berita_id,
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