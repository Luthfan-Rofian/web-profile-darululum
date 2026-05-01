<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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

                <div class="row">

                    <div class="col-lg-9">
                        <div class=" mb-0">
                            <input type="hidden" value="<?= $berita_id ?>" name="berita_id">

                            <div class="row">
                                <div class="form-group col-md-10 col-12">
                                    <label>
                                        Judul Berita
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="judul_berita" name="judul_berita" value="<?= $judul_berita ?>">

                                    <div class="invalid-feedback errorJudul">
                                    </div>
                                </div>

                                <div class="form-group col-md-2 col-12">
                                    <label> </i>
                                        Berita Utama
                                    </label>
                                    <!-- <div class="form-control form-control-sm">
                                        <input type="radio" id="headline1" name="headline" value="0" <?= $headline == '0' ? 'checked' : '' ?>> <label for="headline1" class="pointer">Tidak &nbsp</label>
                                        <input type="radio" id="headline2" name="headline" value="1" <?= $headline == '1' ? 'checked' : '' ?>> <label for="headline2" class="pointer"> Ya &nbsp</label>
                                    </div> -->
                                    <select class="form-control form-control-sm" name="headline" id="headline">
                                        <option Disabled=true Selected=true>-- Pilih --</option>

                                        <option value="0" <?= $headline ==  0 ? 'selected' : '' ?>>Tidak</option>
                                        <option value="1" <?= $headline ==  1 ? 'selected' : '' ?>>Ya</option>

                                    </select>
                                </div>

                            </div>

                            <div class="form-group p-0">
                                <!-- <label>Isi Berita</label> -->
                                <textarea type="text" id="isi" name="isi"> <?= esc($isi) ?></textarea>
                                <div class="invalid-feedback errorIsi"></div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Keterangan Foto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="ket_foto" name="ket_foto" value="<?= $ket_foto ?>">
                                </div>
                            </div> -->
                        </div><!-- Main Footer -->
                    </div>
                    <div class="col-lg-3">

                        <div class="mb-0">
                            <div class="row">
                                <div class="form-group col-md-6 col-12 ">
                                    <label>Berita Pilihan</label>
                                    <select class="form-control form-control-sm" name="pilihan" id="pilihan">
                                        <option value="0" <?= $pilihan ==  0 ? 'selected' : '' ?>>Tidak</option>
                                        <option value="1" <?= $pilihan ==  1 ? 'selected' : '' ?>>Ya</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-12 ">

                                    <label> Tanggal Posting </label>

                                    <input type="text" id="tgl_berita" name="tgl_berita" value="<?= shortdate_indo($tgl_berita) ?>" class="form-control form-control-sm date-picker">

                                    <div class="invalid-feedback errortgl_berita"></div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ringkasan Berita</label>
                                <textarea type="text" rows="10" class="form-control form-control-sm" id="ringkasan" name="ringkasan"> <?= esc($ringkasan) ?></textarea>
                                <div class="invalid-feedback errorringkasan"></div>
                            </div>

                            <div class="form-group">
                                <label>Kategori Berita</label>
                                <select class="form-control form-control-sm" name="kategori_id" id="kategori_id">
                                    <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                                    <?php foreach ($kategori as $key => $value) { ?>
                                        <option value="<?= $value['kategori_id'] ?>" <?= $kategori_id ==  $value['kategori_id'] ? 'selected' : '' ?>><?= $value['nama_kategori'] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback errorKategori"></div>
                            </div>

                            <div class="form-group">
                                <label>Tag Berita</label>

                                <select name="tag_id[]" id="tag_id" class="form-control form-control-sm" multiple="multiple">

                                    <?php foreach ($tag as $key => $value) { ?>
                                        <option value="<?= $value['tag_id'] ?>" <?php foreach ($tag_id as $key => $val) { ?> <?= $val['tag_id'] ==  $value['tag_id'] ? 'selected' : '';
                                                                                                                            } ?>>
                                            <?= $value['nama_tag'] ?></option>
                                    <?php } ?>

                                </select>
                                <div class="invalid-feedback errorTag"></div>
                            </div>

                            <!-- <div class="row"> -->


                            <div class="form-group ">
                                <label>Komentar Berita</label>
                                <select class="form-control form-control-sm" name="sts_komen" id="sts_komen">
                                    <option value="0" <?= $sts_komen ==  0 ? 'selected' : '' ?>>Tidak</option>
                                    <option value="1" <?= $sts_komen ==  1 ? 'selected' : '' ?>>Ya</option>
                                </select>
                            </div>
                            <?php if ($akses == '1') { ?>
                                <div class="form-group ">
                                    <label> </i>
                                        Penulis
                                    </label>
                                    <select name="id" id="id" class="form-control form-control-sm ">
                                        <option Disabled=true Selected=true>-- Pilih Penulis--</option>
                                        <?php foreach ($user as $key => $data) { ?>

                                            <option value="<?= $data['id'] ?>" <?= $id ==  $data['id'] ? 'selected' : '' ?>><?= $data['fullname'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <!-- </div> -->
                            <br>


                            <div class="modal-footer p-0">
                                <button type="submit" class="btn btn-primary btnupdate"><i class="fa fa-share-square"></i> Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
                            </div>
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
            // theme: 'boostrap4',
            placeholder: 'Silahkan Pilih tag'
        })

        $('textarea#isi').summernote({
            height: 540,
            // minHeight: null,
            // maxHeight: null,
            // focus: true
        });

        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('berita/updateberita') ?>',
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

                        if (response.error.isi) {
                            $('#isi').addClass('is-invalid');
                            $('.errorIsi').html(response.error.isi);
                        } else {
                            $('#isi').removeClass('is-invalid');
                            $('.errorIsi').html('');
                        }

                        if (response.error.tgl_berita) {
                            $('#tgl_berita').addClass('is-invalid');
                            $('.errortgl_berita').html(response.error.tgl_berita);
                        } else {
                            $('#tgl_berita').removeClass('is-invalid');
                            $('.errortgl_berita').html('');
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
                        listberita();
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