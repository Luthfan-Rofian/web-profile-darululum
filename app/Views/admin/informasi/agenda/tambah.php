<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

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
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Tema Agenda
                    </label>
                    <input type="text" id="tema" name="tema" class="form-control">
                    <div class="invalid-feedback errortema"></div>
                </div>

                <div class="form-group">
                    <label> <i class="ion-ios7-settings-strong"></i>
                        Deskripsi
                    </label>
                    <textarea type="text" id="isi_agenda" name="isi_agenda" class="form-control"></textarea>
                    <div class="invalid-feedback errorisi_agenda"></div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="fas fa-paper-plane"></i>
                            Penyelenggara / Pengirim
                        </label>
                        <input type="text" id="pengirim" name="pengirim" class="form-control">
                        <div class="invalid-feedback errorpengirim"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-map-marker-multiple"></i>
                            Tempat
                        </label>
                        <input type="text" id="tempat" name="tempat" class=" form-control">
                        <div class="invalid-feedback errortempat"></div>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Tanggal Mulai
                        </label>
                        <input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control date-picker">
                        <div class="invalid-feedback errortgl_mulai"></div>
                    </div>

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Tanggal Selesai
                        </label>
                        <input class="form-control date-picker" id="tgl_selesai" type="text" name="tgl_selesai" />
                        <div class="invalid-feedback errortgl_selesai"></div>
                    </div>

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-update"></i>
                            Jam s/d Selesai
                        </label>
                        <input type="text" id="jam" name="jam" class=" form-control" placeholder="cth: 08 - Selesai">
                        <div class="invalid-feedback errorjam"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Cover Agenda
                    </label>
                    <input type="file" id="gambar" name="gambar" class="form-control">
                    <div class="invalid-feedback errorgambar"></div>
                </div>

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

        $('textarea#isi_agenda').summernote({
            height: 200,
            minHeight: null,
            maxHeight: null,
            focus: true
        });

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('agenda/simpanAgenda') ?>',
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

                        if (response.error.tema) {
                            $('#tema').addClass('is-invalid');
                            $('.errortema').html(response.error.tema);
                        } else {
                            $('#tema').removeClass('is-invalid');
                            $('.errortema').html('');
                        }


                        if (response.error.isi_agenda) {
                            $('#isi_agenda').addClass('is-invalid');
                            $('.errorisi_agenda').html(response.error.isi_agenda);
                        } else {
                            $('#isi_agenda').removeClass('is-invalid');
                            $('.errorisi_agenda').html('');
                        }

                        if (response.error.gambar) {
                            $('#gambar').addClass('is-invalid');
                            $('.errorGambar').html(response.error.gambar);
                        } else {
                            $('#gambar').removeClass('is-invalid');
                            $('.errorGambar').html('');
                        }

                        if (response.error.tempat) {
                            $('#tempat').addClass('is-invalid');
                            $('.errortempat').html(response.error.tempat);
                        } else {
                            $('#tempat').removeClass('is-invalid');
                            $('.errortempat').html('');
                        }

                        if (response.error.tgl_mulai) {
                            $('#tgl_mulai').addClass('is-invalid');
                            $('.errortgl_mulai').html(response.error.tgl_mulai);
                        } else {
                            $('#tgl_mulai').removeClass('is-invalid');
                            $('.errortgl_mulai').html('');
                        }

                        if (response.error.tgl_selesai) {
                            $('#tgl_selesai').addClass('is-invalid');
                            $('.errortgl_selesai').html(response.error.tgl_selesai);
                        } else {
                            $('#tgl_selesai').removeClass('is-invalid');
                            $('.errortgl_selesai').html('');
                        }

                        if (response.error.jam) {
                            $('#jam').addClass('is-invalid');
                            $('.errorjam').html(response.error.jam);
                        } else {
                            $('#jam').removeClass('is-invalid');
                            $('.errorjam').html('');
                        }

                        if (response.error.pengirim) {
                            $('#pengirim').addClass('is-invalid');
                            $('.errorpengirim').html(response.error.pengirim);
                        } else {
                            $('#pengirim').removeClass('is-invalid');
                            $('.errorpengirim').html('');
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
                        listagenda();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                    $('#modaltambah').modal('hide');

                }
            });
        });
    });
</script>