<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formebook']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $ebook_id ?>" name="ebook_id">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Judul E-Book</label>

                        <input type="text" class="form-control" id="judul" name="judul" value="<?= $judul ?>">
                        <div class="invalid-feedback errorjudul"></div>


                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Kategori E-Book</label>
                        <select name="kategoriebook_id" id="kategoriebook_id" class="form-control">
                            <option Disabled=true Selected=true>-- Pilih Kategori --</option>

                            <?php foreach ($kategoriebook as $key => $value) { ?>
                                <option value="<?= $value['kategoriebook_id'] ?>" <?= $kategoriebook_id ==  $value['kategoriebook_id'] ? 'selected' : '' ?>><?= $value['kategoriebook_nama'] ?></option>
                            <?php } ?>
                        </select>
                        <!-- <div class="invalid-feedback errorkategoriebook_id"></div> -->
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" value="<?= $penulis ?> ">
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Jumlah Halaman</label>
                        <input type="text" class="form-control" id="j_hal" name="j_hal" value=<?= $j_hal  ?>>
                    </div>
                </div>


                <div class="row">

                    <div class="form-group col-md-6 col-12">
                        <label>Ganti File PDF E-Book</label>
                        <input type="file" class="form-control" id="fileebook" name="fileebook">
                        <div class="invalid-feedback errorfileebook"></div>
                        <div class="progress">
                            <div id="file-progress-bar" class="progress-bar"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-6 col-12">

                        <label>
                            File PDF Saat:
                        </label>
                        <label class="form-control"><a target='_BLANK' href="<?= base_url('public/deploy/pdf/'  . $fileebook) ?>"><i class="far fa-file-pdf text-danger"></i> <?= $fileebook ?></a></label>
                    </div>


                </div>




            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".progress").hide();
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formebook')[0];
            let data = new FormData(form);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(element) {
                        if (element.lengthComputable) {
                            $(".progress").show();
                            var percentComplete = ((element.loaded / element.total) * 100);
                            $("#file-progress-bar").width(percentComplete + '%');
                            // $("#file-progress-bar").html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                type: "post",
                url: '<?= site_url('ebook/updatedata') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                    $("#file-progress-bar").width('0%');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.judul) {
                            $('#judul').addClass('is-invalid');
                            $('.errorjudul').html(response.error.judul);
                        } else {
                            $('#judul').removeClass('is-invalid');
                            $('.errorjudul').html('');
                        }

                        if (response.error.kategoriebook_id) {
                            $('#kategoriebook_id').addClass('is-invalid');
                            $('.errorkategoriebook_id').html(response.error.kategoriebook_id);
                        } else {
                            $('#kategoriebook_id').removeClass('is-invalid');
                            $('.errorkategoriebook_id').html('');
                        }

                        if (response.error.fileebook) {
                            $('#fileebook').addClass('is-invalid');
                            $('.errorfileebook').html(response.error.fileebook);
                            $("#file-progress-bar").width('0%');
                            $(".progress").hide();

                        } else {
                            $('#fileebook').removeClass('is-invalid');
                            $('.errorfileebook').html('');
                            $(".progress").show();
                        }

                    } else {
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
                        $('#modaledit').modal('hide');
                        listebook();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaledit').modal('hide');
                }
            });
        });
    });
</script>