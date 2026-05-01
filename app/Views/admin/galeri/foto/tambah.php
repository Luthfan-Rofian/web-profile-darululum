<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori_foto" name="nama_kategori_foto">
                    <div class="invalid-feedback errorNamakategori"></div>
                </div>
                <div class="form-group">
                    <label> </i>
                        Deskripsi
                    </label>
                    <textarea type="text" rows="3" id="ket" name="ket" class="form-control"></textarea>

                </div>
                <div class="form-group">
                    <label>Cover</label>
                    <input type="file" class="form-control" id="cover_foto" name="cover_foto">
                    <div class="invalid-feedback errorcover_foto"></div>
                    <div class="progress">
                        <div id="file-progress-bar" class="progress-bar"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $(".progress").hide();
        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);

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
                    url: '<?= site_url('foto/simpankategori') ?>',
                    data: data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    dataType: "json",

                    beforeSend: function() {
                        $('.btnsimpan').attr('disable', 'disable');
                        $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                        $("#file-progress-bar").width('0%');
                    },
                    complete: function() {
                        $('.btnsimpan').removeAttr('disable', 'disable');
                        $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                    },
                    success: function(response) {
                        if (response.error) {

                            if (response.error.nama_kategori_foto) {
                                $('#nama_kategori_foto').addClass('is-invalid');
                                $('.errorNamakategori').html(response.error.nama_kategori_foto);
                            } else {
                                $('#nama_kategori_foto').removeClass('is-invalid');
                                $('.errorNamakategori').html('');
                            }

                            if (response.error.cover_foto) {
                                $('#cover_foto').addClass('is-invalid');
                                $('.errorcover_foto').html(response.error.cover_foto);
                                $("#file-progress-bar").width('0%');
                                $(".progress").hide();
                            } else {
                                $('#cover_foto').removeClass('is-invalid');
                                $('.errorcover_foto').html('');
                                $(".progress").show();
                            }


                        } else {

                            toastr["success"](response.sukses)
                            $('#modaltambah').modal('hide');
                            listkategorifoto();
                            $(".progress").hide();
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