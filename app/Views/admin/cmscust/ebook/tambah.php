<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Judul E-Book</label>

                        <input type="text" class="form-control" id="judul" name="judul">
                        <div class="invalid-feedback errorjudul"></div>


                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Kategori E-Book</label>
                        <select name="kategoriebook_id" id="kategoriebook_id" class="form-control">
                            <option Disabled=true Selected=true>-- Pilih Kategori --</option>

                            <?php foreach ($kategori as $key => $data) { ?>
                                <option value="<?= $data['kategoriebook_id'] ?>"><?= $data['kategoriebook_nama'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorkategoriebook_id"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Cover E-Book</label>

                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <!-- <code class="text-warning">Format gambar:<cite title="Source Title">.jpg, .jpeg, .gif, .png</cite></code> -->

                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>File PDF E-Book</label>
                        <input type="file" class="form-control" id="fileebook" name="fileebook">
                        <div class="invalid-feedback errorfileebook"></div>
                        <div class="progress">
                            <div id="file-progress-bar" class="progress-bar"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis">
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Jumlah Halaman</label>
                        <input type="text" class="form-control" id="j_hal" name="j_hal">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".progress").hide();
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
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
                url: '<?= site_url('ebook/simpanEbook') ?>',
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
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
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
                            $("#file-progress-bar").width('0%');
                            $('#fileebook').addClass('is-invalid');
                            $('.errorfileebook').html(response.error.fileebook);
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
                        $(".progress").hide();
                        $('#modaltambah').modal('hide');
                        listebook();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                    $('#modaltambah').modal('hide');
                }
            });
        });
    });
</script>