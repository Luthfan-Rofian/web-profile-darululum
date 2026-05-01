<!-- Modal -->
<div class="modal fade" id="modalupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field(); ?>
            <br>
            <center>


                <img class="img-thumbnail" id="img_load" src="<?= base_url('public/img/galeri/katfoto/'  . $cover_foto) ?>" alt="Cover">

            </center>
            <input type="hidden" value="<?= $id ?>" name="kategorifoto_id">

            <div class="modal-body">
                <div class="form-group">
                    <label>Upload Cover</label>

                    <input type="file" class="form-control" id="cover_foto" name="cover_foto">
                    <div class="invalid-feedback errorcover_foto"></div>
                    <div class="progress">
                        <div id="file-progress-bar" class="progress-bar"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    function bacacover_foto(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_load').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#cover_foto').change(function() {
        bacacover_foto(this);
    });
</script>

<script>
    $(document).ready(function() {
        $(".progress").hide();
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formupload')[0];
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
                url: '<?= site_url('foto/douploadcover') ?>',
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
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('#modalupload').modal('hide');
                            listkategorifoto();
                            $(".progress").hide();
                            // window.location = '';
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    Swal.fire({
                        title: "Maaf gagal update cover_foto!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        $('#modalupload').modal('hide');
                        window.location = '';
                    })

                }
            });

        });
    });
</script>