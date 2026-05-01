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
        <div class="col-lg-9">
            <div class="card mb-3">

                <div class="card-header font-20 bg-light">

                    <?= form_open_multipart('', ['class' => 'formedit']) ?>
                    <?= csrf_field(); ?>
                    <h6 class="modal-title mt-0">
                        <i class="fas fa-edit"></i> <?= $subtitle ?>

                    </h6>
                </div>

                <div class='card-body'>
                    <input type="hidden" class="form-control" id="id_setaplikasi" value="<?= $id_setaplikasi ?>" name="id_setaplikasi" readonly>

                    <div class="form-group">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Isi Sambutan
                        </label>
                        <textarea type="text" class="form-control p-0" id="sambutan" name="sambutan"> <?= $sambutan ?></textarea>
                        <div class="invalid-feedback errorsambutan"></div>
                    </div>
                </div>



            </div><!-- Main Footer -->
        </div>
        <div class="col-lg-3">
            <div class="card mb-3">
                <div class="card-body">
                    <i class="mdi mdi-image-filter-hdr"></i> Foto Pimpinan <br>
                    <small>*Klik di foto untuk mengganti gambar.</small>
                    <hr>
                    <div class="form-group text-center">
                        <?php if ($akses == 1) { ?>
                            <img class="img-thumbnail pointer" onclick="gantilogo('<?= $id_setaplikasi ?>')" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $gbr_sambutan) ?>" alt="Gambar Sambutan">
                        <?php } else { ?>
                            <img class="img-thumbnail" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $gbr_sambutan) ?>" alt="Gambar Sambutan">

                        <?php } ?>
                    </div>


                    <div class="form-group">
                        <label> <i class="fas fa-user-tie"></i> Nama </label>
                        <input type="text" id="nama_pimpinan" value="<?= esc($nama_pimpinan) ?>" name="nama_pimpinan" class="form-control">
                        <div class="invalid-feedback errornama_pimpinan"></div>
                    </div>
                    <div class="form-group">

                        <label> <i class="fas fa-stream"></i> Jabatan </label>
                        <input type="text" id="jabatan_pimpinan" value="<?= esc($jabatan_pimpinan) ?>" name="jabatan_pimpinan" class="form-control">
                        <div class="invalid-feedback errorjabatan_pimpinan"></div>
                    </div>

                    <div class="form-group">

                        <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Sambutan </label>
                        <div class="form-control">
                            <input type="radio" name="sts_sambutan" value="1" <?= $sts_sambutan == '1' ? 'checked' : '' ?>> Ya &nbsp
                            <input type="radio" name="sts_sambutan" value="0" <?= $sts_sambutan == '0' ? 'checked' : '' ?>> Tidak &nbsp

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($akses == 1) { ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Perbarui Data</button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?= form_close() ?>

    </div>

</div>

<div class="viewmodal"></div>


<script>
    $(document).ready(function() {

        $('textarea#sambutan').summernote({
            height: 350,
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
                url: '<?= site_url('sambutan/submit') ?>',
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
                error: function(xhr, ajaxOptions, thrownerror) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownerror);
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.sambutan) {
                            $('#sambutan').addClass('is-invalid');
                            $('.errorsambutan').html(response.error.sambutan);
                        } else {
                            $('#sambutan').removeClass('is-invalid');
                            $('.errorsambutan').html('');
                        }

                        if (response.error.nama_pimpinan) {
                            $('#nama_pimpinan').addClass('is-invalid');
                            $('.errornama_pimpinan').html(response.error.nama_pimpinan);
                        } else {
                            $('#nama_pimpinan').removeClass('is-invalid');
                            $('.errornama_pimpinan').html('');
                        }

                        if (response.error.jabatan_pimpinan) {
                            $('#jabatan_pimpinan').addClass('is-invalid');
                            $('.errorjabatan_pimpinan').html(response.error.jabatan_pimpinan);
                        } else {
                            $('#jabatan_pimpinan').removeClass('is-invalid');
                            $('.errorjabatan_pimpinan').html('');
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
                        title: "Maaf data gagal di update!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2100
                    });
                }
            });
        })
    });


    function gantilogo(id_setaplikasi) {

        $.ajax({
            type: "post",
            url: "<?= site_url('sambutan/formuploadpimpinan') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_setaplikasi: id_setaplikasi,
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
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });
            }
        });
    }
</script>



<?= $this->endSection() ?>