<?= $this->section('content') ?>
<?= $this->extend('admin/script') ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">
            <div class="state-information d-none d-sm-block">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">

                <div class="card-header font-18 bg-light">
                    <?= form_open_multipart('', ['class' => 'formedit']) ?>
                    <?= csrf_field(); ?>
                    <h5 class="modal-title mt-0">
                        <i class="fas fa-edit"></i> <?= $subtitle ?>
                        <div class="btn-group mr-2 float-right">
                            <?php if ($akses == 1) { ?>
                                <button type="button" class="btn btn-primary btnsimpan mr-1"><i class="mdi mdi-content-save-all"></i> Update Data</button>
                            <?php } ?>
                            <button type="button" class="btn btn-success" onclick="lihathasil('<?= $modalpopup_id ?>')"><i class="mdi mdi-file-find"></i> Lihat Hasil</button>
                        </div>
                    </h5>
                </div>
                <div class='card-body'>
                    <input type="hidden" class="form-control" id="modalpopup_id" value="<?= $modalpopup_id ?>" name="modalpopup_id" readonly>
                    <div class="form-group">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Judul Modal Popup
                        </label>
                        <input type="text" id="judultawaran" value="<?= esc($judultawaran) ?>" name="judultawaran" class="form-control">
                        <div class="invalid-feedback errorjudultawaran"></div>
                    </div>


                    <div class="form-group">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Isi Modal Popup
                        </label>
                        <textarea type="text" class="form-control" id="isitawaran" name="isitawaran"> <?= $isitawaran ?></textarea>
                        <div class="invalid-feedback errorisitawaran"></div>
                    </div>
                </div>

            </div><!-- Main Footer -->
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <i class="mdi mdi-image-filter-hdr"></i> Gambar Modal Popup <br>
                    <small>*Klik foto untuk mengganti gambar.</small>
                    <hr>
                    <div class="form-group text-center">
                        <?php if ($akses == 1) { ?>
                            <img class="img-thumbnail pointer" onclick="gantilogo('<?= $modalpopup_id ?>')" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $gbrtawaran) ?>" alt="Img Modal Popup">
                        <?php } else { ?>
                            <img class="img-thumbnail" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $gbrtawaran) ?>" alt="Img Modal Popup">

                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">

                    <div class="form-group">
                        <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Tombol </label>
                        <div class="form-control">
                            <input type="radio" name="sts_tombol" id="sts_tombol1" value="1" <?= $sts_tombol == '1' ? 'checked' : '' ?>> <label for="sts_tombol1" class="pointer"> Ya &nbsp</label>
                            <input type="radio" name="sts_tombol" id="sts_tombol2" value="0" <?= $sts_tombol == '0' ? 'checked' : '' ?>> <label for="sts_tombol2" class="pointer"> Tidak &nbsp</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Nama Tombol
                        </label>
                        <input type="text" id="namatombol" value="<?= esc($namatombol) ?>" name="namatombol" class="form-control">
                        <div class="invalid-feedback errornamatombol"></div>
                    </div>
                    <div class="form-group">
                        <label> <i class="mdi mdi-link-variant"></i>
                            Link Tombol
                        </label>
                        <input type="text" id="linktawaran" value="<?= esc($linktawaran) ?>" name="linktawaran" class="form-control">
                        <div class="invalid-feedback errorlinktawaran"></div>
                        <small>*Untuk link tujuan dapat diambil pada link menu.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="modal-footer">
                    <div class="btn-group mr-2 float-right">
                        <?php if ($akses == 1) { ?>
                            <button type="button" class="btn btn-primary btnsimpan mr-1"><i class="mdi mdi-content-save-all"></i> Update Data</button>
                        <?php } ?>
                        <button type="button" class="btn btn-success" onclick="lihathasil('<?= $modalpopup_id ?>')"><i class="mdi mdi-file-find"></i> Lihat Hasil</button>
                    </div>
                </div>

            </div>
        </div>

        <?= form_close() ?>
    </div>
</div>

<!-- <div class="viewmodal"></div>

<div class="modalview"></div> -->

<script>
    $(document).ready(function() {
        $('textarea#isitawaran').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true
        });

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('penawaran/submit') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,

                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i> Update Data');
                },

                success: function(response) {
                    if (response.error) {

                        if (response.error.judultawaran) {
                            $('#judultawaran').addClass('is-invalid');
                            $('.errorjudultawaran').html(response.error.judultawaran);
                        } else {
                            $('#judultawaran').removeClass('is-invalid');
                            $('.errorjudultawaran').html('');
                        }

                        if (response.error.isitawaran) {
                            $('#isitawaran').addClass('is-invalid');
                            $('.errorisitawaran').html(response.error.isitawaran);
                        } else {
                            $('#isitawaran').removeClass('is-invalid');
                            $('.errorisitawaran').html('');
                        }

                        if (response.error.linktawaran) {
                            $('#linktawaran').addClass('is-invalid');
                            $('.errorlinktawaran').html(response.error.linktawaran);
                        } else {
                            $('#linktawaran').removeClass('is-invalid');
                            $('.errorlinktawaran').html('');
                        }

                        if (response.error.namatombol) {
                            $('#namatombol').addClass('is-invalid');
                            $('.errornamatombol').html(response.error.namatombol);
                        } else {
                            $('#namatombol').removeClass('is-invalid');
                            $('.errornamatombol').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal update data!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })

                }
            });
        })
    });

    function gantilogo(modalpopup_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('penawaran/formuploadtawaran') ?>",
            data: {
                [csrfToken]: csrfHash,
                modalpopup_id: modalpopup_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal upload data!",
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

<script>
    function lihathasil() {
        $.ajax({
            url: "<?= site_url('penawaran/lihathasiladmin') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal({

                });
                $('.modal-dialog').draggable({
                    handle: ".modal-header"
                });
                $('#modalview').modal('show');
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

<?= $this->endSection() ?>