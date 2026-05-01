<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Profil</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#lainlain" role="tab">Lain-lain</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#publikasi" role="tab">Publikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#penelitian" role="tab">Penelitian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pengabdian" role="tab">Pengabdian</a>
                    </li> -->
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="profil" role="tabpanel">
                        <p>
                            <input type="hidden" value="<?= $pegawai_id ?>" name="pegawai_id">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-account"></i>
                                    Nama
                                </label>
                                <input type="text" id="nama" name="nama" value="<?= $nama ?>" class="form-control">
                                <div class="invalid-feedback errornama"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-account-key"></i>
                                    NIP/No Pegawai
                                </label>
                                <input type="text" id="nip" name="nip" value="<?= $nip ?>" class="form-control">
                                <div class="invalid-feedback errornip"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-map-marker-multiple"></i>
                                    Tempat Lahir
                                </label>
                                <input type=" text" id="tempat_lahir" name="tempat_lahir" value="<?= $tempat_lahir ?>" class="form-control">
                                <div class="invalid-feedback errortempat_lahir"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-calendar-range"></i>
                                    Tanggal Lahir
                                </label>
                                <input type="text" id="tgl_lahir" name="tgl_lahir" value=" <?= shortdate_indo($tgl_lahir) ?>" class=" form-control date-picker">
                                <div class="invalid-feedback errortgl_lahir"></div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-gender-male-female"></i>
                                    Jenis Kelamin
                                </label>

                                <select class="form-control" name="jk" id="jk">
                                    <option Disabled=true Selected=true>-- Jenis Kelamin --</option>
                                    <?php
                                    $lk = "L";
                                    $pr = "P";
                                    ?>
                                    <option value="L" <?= $jk ==  $lk ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= $jk ==  $pr ? 'selected' : '' ?>>Perempuan</option>
                                </select>

                                <div class="invalid-feedback errorjk"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-file-document-box"></i>
                                    Agama
                                </label>

                                <select class="form-control" name="agama" id="agama">
                                    <option Disabled=true Selected=true>-- Pilih Agama --</option>

                                    <option value="Islam" <?= $agama ==  "Islam" ? 'selected' : '' ?>>Islam</option>
                                    <option value="Kristen" <?= $agama ==  "Kristen" ? 'selected' : '' ?>>Kristen</option>
                                    <option value="Katolik" <?= $agama ==  "Katolik" ? 'selected' : '' ?>>Katolik</option>
                                    <option value="Hindu" <?= $agama ==  "Hindu" ? 'selected' : '' ?>>Hindu</option>
                                    <option value="Buddha" <?= $agama ==  "Buddha" ? 'selected' : '' ?>>Buddha</option>
                                    <option value="Khonghucu" <?= $agama ==  "Khonghucu" ? 'selected' : '' ?>>Khonghucu</option>

                                </select>
                                <div class="invalid-feedback erroragama"></div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-certificate"></i>
                                    Pangkat - Golongan
                                </label>
                                <input type=" text" id="pangkat" name="pangkat" value="<?= $pangkat ?>" class="form-control">
                                <div class="invalid-feedback errorpangkat"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-arrange-send-backward"></i>
                                    Jabatan
                                </label>
                                <input type="text" id="jabatan" name="jabatan" value="<?= $jabatan ?>" class=" form-control">
                                <div class="invalid-feedback errorjabatan"></div>
                            </div>
                        </div>
                        <p></p>
                    </div>
                    <!-- TAB LAIN-lain -->
                    <!-- <div class="tab-pane" id="lainlain" role="tabpanel">
                        <p></p>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S1
                                </label>
                                <input type="text" id="asal_s1" name="asal_s1" value="<?= $asal_s1 ?>" class="form-control">

                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S2
                                </label>
                                <input type="text" id="asal_s2" name="asal_s2" value="<?= $asal_s2 ?>" class=" form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-home-map-marker"></i>
                                    Asal S3
                                </label>
                                <input type="text" id="asal_s3" name="asal_s3" value="<?= $asal_s3 ?>" class="form-control">

                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-book-multiple-variant"></i>
                                    Bidang Kepakaran
                                </label>
                                <input type="text" id="bidang_pakar" name="bidang_pakar" value="<?= $bidang_pakar ?>" class=" form-control">

                            </div>
                        </div>

                        <div class="form-group">
                            <label> <i class="mdi mdi-account"></i>
                                Biodata Singkat
                            </label>
                            <textarea type="text" class="form-control form-control-sm" id="bio_singkat" name="bio_singkat"><?= esc($bio_singkat) ?></textarea>
                        </div>
                    </div> -->
                    <!-- <div class="tab-pane" id="publikasi" role="tabpanel">
                        <p>
                        <div class="form-group">
                            <textarea type="text" id="publikasi" name="publikasi" class="form-control form-control-sm"><?= esc($publikasi) ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane " id="penelitian" role="tabpanel">
                        <p>
                        <div class="form-group">
                            <textarea type="text" id="penelitian" name="penelitian" class="form-control form-control-sm"><?= esc($penelitian) ?></textarea>
                        </div>
                    </div>

                    <div class="tab-pane " id="pengabdian" role="tabpanel">
                        <p>
                        <div class="form-group">
                            <textarea type="text" id="pengabdian" name="pengabdian" class="form-control form-control-sm"><?= esc($pengabdian) ?></textarea>
                        </div>
                    </div> -->

                </div>



                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            $('textarea#publikasi').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: false
            });

            $('textarea#penelitian').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: false
            });

            $('textarea#pengabdian').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: false
            });


            $('.btnupdate').click(function(e) {
                e.preventDefault();
                let form = $('.formedit')[0];
                let data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: '<?= site_url('pegawai/updatepegawai') ?>',
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

                            if (response.error.nama) {
                                $('#nama').addClass('is-invalid');
                                $('.errornama').html(response.error.nama);
                            } else {
                                $('#nama').removeClass('is-invalid');
                                $('.errornama').html('');
                            }

                            if (response.error.nip) {
                                $('#nip').addClass('is-invalid');
                                $('.errornip').html(response.error.nip);
                            } else {
                                $('#nip').removeClass('is-invalid');
                                $('.errornip').html('');
                            }

                            if (response.error.tempat_lahir) {
                                $('#tempat_lahir').addClass('is-invalid');
                                $('.errortempat_lahir').html(response.error.tempat_lahir);
                            } else {
                                $('#tempat_lahir').removeClass('is-invalid');
                                $('.errortempat_lahir').html('');
                            }

                            if (response.error.tgl_lahir) {
                                $('#tgl_lahir').addClass('is-invalid');
                                $('.errortgl_lahir').html(response.error.tgl_lahir);
                            } else {
                                $('#tgl_lahir').removeClass('is-invalid');
                                $('.errortgl_lahir').html('');
                            }

                            if (response.error.jk) {
                                $('#jk').addClass('is-invalid');
                                $('.errorjk').html(response.error.jk);
                            } else {
                                $('#jk').removeClass('is-invalid');
                                $('.errorjk').html('');
                            }

                            if (response.error.agama) {
                                $('#agama').addClass('is-invalid');
                                $('.erroragama').html(response.error.agama);
                            } else {
                                $('#agama').removeClass('is-invalid');
                                $('.erroragama').html('');
                            }

                            if (response.error.pangkat) {
                                $('#pangkat').addClass('is-invalid');
                                $('.errorpangkat').html(response.error.pangkat);
                            } else {
                                $('#pangkat').removeClass('is-invalid');
                                $('.errorpangkat').html('');
                            }

                            if (response.error.jabatan) {
                                $('#jabatan').addClass('is-invalid');
                                $('.errorjabatan').html(response.error.jabatan);
                            } else {
                                $('#jabatan').removeClass('is-invalid');
                                $('.errorjabatan').html('');
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
                            listpegawai();
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