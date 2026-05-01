<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                <div class="form-group">
                    <label>Judul Halaman</label>
                    <input type="text" class="form-control" id="judul_berita" name="judul_berita">
                    <div class="invalid-feedback errorJudul">
                    </div>
                </div>

                <div class="form-group">
                    <label>Isi Halaman</label>
                    <textarea type="text" class="form-control " id="isi" name="isi"></textarea>
                    <div class="invalid-feedback errorIsi"></div>
                </div>

                <div class="form-group">
                    <label>File PDF</label>

                    <input type="file" class="form-control" id="filepdf" name="filepdf">
                    <div class="invalid-feedback errorfilepdf"></div>

                </div>

                <div class="form-group">
                    <label>Gambar Halaman</label>

                    <input type="file" class="form-control" id="gambar" name="gambar">
                    <div class="invalid-feedback errorGambar"></div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Batal</button>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $('textarea#isi').summernote({
                height: 150,
                minHeight: null,
                maxHeight: null,
                focus: true
            });

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
                        type: "post",
                        url: '<?= site_url('halaman/simpanHalamanpdf') ?>',
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
                            $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                        },
                        success: function(response) {
                            if (response.error) {

                                if (response.error.judul_berita) {
                                    $('#judul_berita').addClass('is-invalid');
                                    $('.errorJudul').html(response.error.judul_berita);
                                } else {
                                    $('#judul_berita').removeClass('is-invalid');
                                    $('.errorJudul').html('');
                                }


                                if (response.error.isi) {
                                    $('#isi').addClass('is-invalid');
                                    $('.errorIsi').html(response.error.isi);
                                } else {
                                    $('#isi').removeClass('is-invalid');
                                    $('.errorIsi').html('');
                                }

                                if (response.error.gambar) {
                                    $('#gambar').addClass('is-invalid');
                                    $('.errorGambar').html(response.error.gambar);
                                } else {
                                    $('#gambar').removeClass('is-invalid');
                                    $('.errorGambar').html('');
                                }

                                if (response.error.filepdf) {
                                    $('#filepdf').addClass('is-invalid');
                                    $('.errorfilepdf').html(response.error.filepdf);
                                } else {
                                    $('#filepdf').removeClass('is-invalid');
                                    $('.errorfilepdf').html('');
                                }

                            } else {

                                toastr["success"](response.sukses)
                                $('#modaltambah').modal('hide');
                                listhalaman();
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