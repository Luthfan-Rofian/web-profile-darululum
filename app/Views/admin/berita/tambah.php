<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

<div class="modal fade" id="modaltambah" tabindex="-1" role="document" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl " role="document">
        <div class="modal-content ">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body mb-0">

                <div class="row">

                    <div class="col-lg-9">
                        <div class="mb-0">

                            <div class="row">
                                <?php

                                if ($akses == '1') { ?>
                                    <div class="form-group col-md-10 col-12">
                                    <?php } else { ?>
                                        <div class="form-group col-md-12 col-12">
                                        <?php } ?>
                                        <label>Judul Berita <b class="text-danger">*</b></label>
                                        <input type="text" class="form-control form-control-sm" id="judul_berita" name="judul_berita">
                                        <div class="invalid-feedback errorJudul"></div>
                                        </div>
                                        <?php if ($akses == '1') { ?>
                                            <div class="form-group col-md-2 col-12">
                                                <label> </i>
                                                    Berita Utama
                                                </label>
                                                <!-- <div class="form-control form-control-sm">
                                                    <input type="radio" id="headline1" name="headline" value="0" checked> <label for="headline1" class="pointer">Tidak &nbsp</label>
                                                    <input type="radio" id="headline2" name="headline" value="1"> <label for="headline2" class="pointer"> Ya &nbsp</label>
                                                </div> -->
                                                <select class="form-control form-control-sm" name="headline" id="headline">
                                                    <option Disabled=true Selected=true>-- Pilih --</option>
                                                    <option value="0" selected>Tidak</option>
                                                    <option value="1">Ya</option>
                                                </select>

                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" class="form-control form-control-sm" name="headline" value="0">
                                        <?php } ?>

                                    </div>

                                    <div class="form-group p-0">
                                        <!-- <label>Isi Berita <b class="text-danger">*</b></label> -->
                                        <textarea type="text" class="form-control form-control-sm" id="isi" name="isi"></textarea>
                                        <div class="invalid-feedback errorIsi"></div>
                                    </div>
                                    <div class="row mt-0">
                                        <div class="form-group col-md-6 col-12 ">
                                            <label>Foto Berita</label>
                                            <input type="file" class="form-control form-control-sm" id="gambar" name="gambar">
                                            <div class="invalid-feedback errorGambar"></div>
                                        </div>

                                        <div class="form-group col-md-6 col-12">
                                            <label>Keterangan Foto</label>
                                            <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Keterangan Foto</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control form-control-sm" id="gambar" name="gambar">
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Keterangan Foto</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto">
                                        </div>
                                    </div> -->

                            </div><!-- Row -->
                        </div>
                        <div class="col-lg-3">

                            <div class="mb-0">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label> </i>
                                            Berita Pilihan
                                        </label>

                                        <select class="form-control form-control-sm" name="pilihan" id="pilihan">
                                            <option Disabled=true Selected=true>-- Pilih --</option>
                                            <option value="0" selected>Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label> Tanggal Posting </label>
                                        <input type="text" id="tgl_berita" name="tgl_berita" value="<?= shortdate_indo(date('Y-m-d')) ?>" class="form-control form-control-sm date-picker">
                                        <div class="invalid-feedback errortgl_berita"></div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Ringkasan Berita <b class="text-danger">*</b></label>
                                    <textarea type="text" rows="10" id="ringkasan" name="ringkasan" class="form-control form-control-sm"></textarea>
                                    <div class="invalid-feedback errorringkasan"></div>
                                </div>

                                <div class="form-group">
                                    <label>Kategori Berita <b class="text-danger">*</b></label>
                                    <select name="kategori_id" id="kategori_id" class="form-control form-control-sm">
                                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                                        <?php foreach ($kategori as $key => $data) { ?>
                                            <option value="<?= $data['kategori_id'] ?>"><?= $data['nama_kategori'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback errorKategori"></div>
                                </div>

                                <div class="form-group">
                                    <label>Tag Berita <b class="text-danger">*</b></label>
                                    <select name="tag_id[]" id="tag_id" class="form-control form-control-sm" placeholder=" Pilih Tagar" multiple="multiple">
                                        <?php foreach ($tag as $key => $data) { ?>
                                            <option value="<?= $data['tag_id'] ?>"><?= $data['nama_tag'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback errorTag"></div>
                                </div>
                                <!-- <div class="row"> -->
                                <div class="form-group">
                                    <label> </i>
                                        Komentar Berita
                                    </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" id="sts_komen1" name="sts_komen" value="0" checked> <label for="sts_komen1" class="pointer">Tidak &nbsp</label>
                                        <input type="radio" id="sts_komen2" name="sts_komen" value="1"> <label for="sts_komen2" class="pointer"> Ya &nbsp</label>
                                    </div>
                                    <!-- <select class="form-control form-control-sm" name="sts_komen" id="sts_komen">
                                        <option Disabled=true Selected=true>-- Pilih --</option>
                                        <option value="0" selected>Tidak</option>
                                        <option value="1">Ya</option>
                                    </select> -->
                                </div>

                                <!-- </div> -->
                                <?php if ($akses == '1') { ?>
                                    <div class="form-group ">
                                        <label> </i>
                                            Penulis
                                        </label>
                                        <select name="id" id="id" class="form-control form-control-sm ">
                                            <option Disabled=true Selected=true>-- Pilih Penulis--</option>
                                            <?php foreach ($user as $key => $data) { ?>
                                                <option value="<?= $data['id'] ?>"><?= $data['fullname'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <!-- <div class="form-group ">
                                    <label>Foto Berita <b class="text-danger">*</b></label>
                                    <input type="file" class="form-control form-control-sm" id="gambar" name="gambar">
                                    <div class="invalid-feedback errorGambar"></div>
                                </div> -->

                                <!-- </div> -->

                                <!-- <div class="form-group"> -->
                                <div class="modal-footer p-0">
                                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
                                </div>
                                <!-- </div> -->

                            </div>
                        </div>
                    </div>

                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#id').select2({})
            $('#kategori_id').select2({})
            $('#tag_id').select2({
                placeholder: ' Pilih Tagar '
            })

            $('textarea#isi').summernote({
                height: 400,
                minHeight: null,
                maxHeight: null,
                // focus: true
            });


            $('.btnsimpan').click(function(e) {
                e.preventDefault();
                let form = $('.formtambah')[0];
                let data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: '<?= site_url('berita/simpanBerita') ?>',
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

                            if (response.error.kategori_id) {
                                $('#kategori_id').addClass('is-invalid');
                                $('.errorKategori').html(response.error.kategori_id);
                            } else {
                                $('#kategori_id').removeClass('is-invalid');
                                $('.errorKategori').html('');
                            }

                            if (response.error.tag_id) {
                                $('#tag_id').addClass('is-invalid');
                                $('.errorTag').html(response.error.tag_id);
                            } else {
                                $('#tag_id').removeClass('is-invalid');
                                $('.errorTag').html('');
                            }


                            if (response.error.ringkasan) {
                                $('#ringkasan').addClass('is-invalid');
                                $('.errorringkasan').html(response.error.ringkasan);
                            } else {
                                $('#ringkasan').removeClass('is-invalid');
                                $('.errorringkasan').html('');
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
                            listberita();
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