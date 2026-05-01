<div class="modal fade" id="modaledit">
    <!-- <div class="modal-dialog modal-dialog-centered modal-xl" role="document"> -->
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $berita_id ?>" name="berita_id">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Judul Halaman</label>
                        <input type="text" class="form-control form-control-sm" id="judul_berita" name="judul_berita" value="<?= $judul_berita ?>">

                        <div class="invalid-feedback errorJudul"></div>
                    </div>

                    <!-- <div class="form-group col-md-3 col-12">
                        <label>
                            File Sematan PDF :
                        </label>
                        <label class="form-control">
                            <?php if ($filepdf != '') { ?>
                                <a target='_BLANK' href="<?= base_url('public/img/informasi/pdf/'  . $filepdf) ?>"><i class="far fa-file-pdf text-danger"></i><?= $filepdf ?></a>
                            <?php } else { ?>
                                <label class="text-danger">Tidak ada sematan file pdf pada halaman ini.</label>
                            <?php } ?>
                        </label>

                    </div> -->
                    <div class="form-group col-md-6 col-12">
                        <label>Keterangan Foto</label>
                        <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto" value="<?= $ket_foto ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Isi Halaman</label>
                    <textarea type="text" class="form-control" id="isi" name="isi"> <?= $isi ?></textarea>
                    <div class="invalid-feedback errorIsi"></div>
                </div>

            </div>

            <div class="modal-footer ">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

        </div>

        <?php echo form_close() ?>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {

        $('textarea#isi').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true
        });

        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('halaman/updateprofil') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupdate').attr('disable', 'disable');
                    $('.btnupdate').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupdate').removeAttr('disable', 'disable');
                    $('.btnupdate').html('<i class="mdi mdi-content-save-all"></i> Simpan');
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
                        listhalaman();
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