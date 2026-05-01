<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
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


                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Judul</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="judul" name="judul">
                        <div class="invalid-feedback errorjudul">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <select name="kategorivideo_id" id="kategorivideo_id" class="form-control">
                            <option Disabled=true Selected=true>-- Pilih Kategori --</option>

                            <?php foreach ($kategori as $key => $data) { ?>
                                <option value="<?= $data['kategorivideo_id'] ?>"><?= $data['nama_kategori_video'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Deskripsi</label>
                    <div class="col-sm-9">
                        <textarea type="text" rows="2" id="ket_video" name="ket_video" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Link Youtube</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="video_link" name="video_link">
                        <div class="invalid-feedback errorvideo_link">
                        </div>
                        <small class="text-secondary">Contoh: <span class="text-warning">https://www.youtube.com/watch?v=</span><strong class="text-danger">X_fh-xVmto0</strong>. Ambil kode yang warna <strong class="text-danger">Merah</strong></small>
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
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('video/uploadvideo') ?>',
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

                        if (response.error.kategorifoto_id) {
                            $('#kategorifoto_id').addClass('is-invalid');
                            $('.errorKategori').html(response.error.kategorifoto_id);
                        } else {
                            $('#kategorifoto_id').removeClass('is-invalid');
                            $('.errorKategori').html('');
                        }

                        if (response.error.video_link) {
                            $('#video_link').addClass('is-invalid');
                            $('.errorvideo_link').html(response.error.video_link);
                        } else {
                            $('#video_link').removeClass('is-invalid');
                            $('.errorvideo_link').html('');
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
                        $('#modaltambah').modal('hide');
                        listvideo();
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