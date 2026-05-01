<!-- <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/summernote-image-attributes.js"></script> -->
<!-- <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/lang.js"></script> -->
<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

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
                        <label>Judul Halaman</label>
                        <input type="text" class="form-control form-control-sm" id="judul_berita" name="judul_berita">
                        <div class="invalid-feedback errorJudul">
                        </div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label>Cover Halaman</label>

                        <input type="file" class="form-control form-control-sm" id="gambar" name="gambar">
                        <div class="invalid-feedback errorGambar"></div>
                    </div>

                    <div class="form-group col-md-3 col-12">
                        <label>Keterangan Foto</label>
                        <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto">
                    </div>
                </div>


                <div class="form-group">
                    <label>Isi Halaman</label>
                    <textarea type="text" class="form-control " id="isi" name="isi"></textarea>
                    <div class="invalid-feedback errorIsi"></div>
                </div>


                <div class="modal-footer p-0">
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
                height: 300,
                // minHeight: null,
                // maxHeight: null,
                focus: true,

            });

            // $('#summernote').summernote({
            //     popover: {
            //         image: [
            //             ['custom', ['imageAttributes']],
            //             ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
            //             ['float', ['floatLeft', 'floatRight', 'floatNone']],
            //             ['remove', ['removeMedia']]
            //         ],
            //     },
            //     lang: 'en-US', // Change to your chosen language
            //     imageAttributes: {
            //         icon: '<i class="note-icon-pencil"/>',
            //         removeEmpty: false, // true = remove attributes | false = leave empty if present
            //         disableUpload: false // true = don't display Upload Options | Display Upload Options
            //     }
            // });

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
                        url: '<?= site_url('halaman/simpanHalaman') ?>',
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