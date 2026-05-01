<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                    <label>Fasilitas</label>
                    <input type="text" class="form-control" id="fasilitas" name="fasilitas">
                    <div class="invalid-feedback errorfasilitas"></div>
                </div>
                <div class="form-group">
                    <label> </i>
                        Keterangan
                    </label>
                    <textarea type="text" rows="3" id="ket" name="ket" class="form-control"></textarea>

                </div>

                <div class="form-group">
                    <label> </i>
                        Lokasi GMap
                    </label>
                    <textarea type="text" rows="3" id="lokasi" name="lokasi" class="form-control"></textarea>

                </div>
                <div class="form-group">
                    <label>Cover</label>
                    <input type="file" class="form-control" id="cover_foto" name="cover_foto">
                    <div class="invalid-feedback errorcover_foto"></div>
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

        $('textarea#ket').summernote({
            height: 300,
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
                    url: '<?= site_url('fasilitas/simpanfasilitas') ?>',
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

                            if (response.error.fasilitas) {
                                $('#fasilitas').addClass('is-invalid');
                                $('.errorfasilitas').html(response.error.fasilitas);
                            } else {
                                $('#fasilitas').removeClass('is-invalid');
                                $('.errorfasilitas').html('');
                            }

                            if (response.error.cover_foto) {
                                $('#cover_foto').addClass('is-invalid');
                                $('.errorcover_foto').html(response.error.cover_foto);
                            } else {
                                $('#cover_foto').removeClass('is-invalid');
                                $('.errorcover_foto').html('');
                            }


                        } else {

                            toastr["success"](response.sukses)
                            $('#modaltambah').modal('hide');
                            listfasilitas();
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