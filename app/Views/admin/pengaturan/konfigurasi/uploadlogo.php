<!-- Modal -->

<div class="modal fade" id="modalupload" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field();

            if (file_exists('public/img/konfigurasi/logo/' . $logo)) {
                $img = $logo;
            } else {
                $img = 'default.png';
            }
            ?>
            <br>

            <center>
                <img class="img-thumbnail" id="img_load" src="<?= base_url('/public/img/konfigurasi/logo/'  . $img) ?>" alt="Logo">
            </center>
            <input type="hidden" value="<?= $id_setaplikasi ?>" name="id_setaplikasi">
            <div class="modal-body">

                <div class="form-group">
                    <label>Ganti Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                    <div class="invalid-feedback errorLogo"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_load').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#logo').change(function() {
        bacaGambar(this);
    });
</script>



<script>
    $(document).ready(function() {

        $('.btnupload').click(function(e) {
            e.preventDefault();
            let logoweb = '<?= base_url('img/konfigurasi/logo/' . $img) ?>';
            let form = $('.formupload')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: '<?= base_url('konfigurasi/douploadlogo') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.logo) {
                            $('#logo').addClass('is-invalid');
                            $('.errorLogo').html(response.error.logo);
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
                            window.location = '';
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal update Logo!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2100
                    }).then(function() {
                        $('#modalupload').modal('hide');
                        window.location = '';
                    })
                }
            });

        });
    });
</script>