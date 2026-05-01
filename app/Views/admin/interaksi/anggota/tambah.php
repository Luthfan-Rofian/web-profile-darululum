<link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/public/template/temp-backend/assets/js/date-picker.js"></script>

<div class="modal fade" id="modaltambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Partisipan

                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Nama
                        </label>
                        <input type="text" id="nama" name="nama" class="form-control form-control-sm">
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-account-key"></i>
                            NIK
                        </label>
                        <input type="text" id="nik" name="nik" class=" form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Tempat Lahir
                        </label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control form-control-sm">

                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-calendar-range"></i>
                            Tanggal Lahir
                        </label>
                        <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control form-control-sm date-picker">
                        <div class="invalid-feedback errortgl_lahir"></div>
                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-gender-male-female"></i>
                            Jenis Kelamin
                        </label>

                        <select class="form-control form-control-sm" name="jk" id="jk">
                            <option Disabled=true Selected=true>-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>

                        <div class="invalid-feedback errorjk"></div>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="fas fa-tty"></i>
                            No HP
                        </label>
                        <input type="text" id="no_hp" name="no_hp" class=" form-control form-control-sm">

                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            RT/RW
                        </label>
                        <input type="text" id="rtrw" name="rtrw" class="form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Provinsi
                        </label>
                        <input type="text" id="provinsi" name="provinsi" class="form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kabupaten
                        </label>
                        <input type="text" id="kab" name="kab" class=" form-control form-control-sm">

                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kecamatan
                        </label>
                        <input type="text" id="kec" name="kec" class="form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Kelurahan
                        </label>
                        <input type="text" id="kel" name="kel" class=" form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pekerjaan
                        </label>
                        <input type="text" id="pekerjaan" name="pekerjaan" class="form-control form-control-sm">

                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pendidikan
                        </label>
                        <input type="text" id="pendidikan" name="pendidikan" class=" form-control form-control-sm">

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-file-plus"></i>
                            Upload KTP
                        </label>
                        <input type="file" id="dok_ktp" name="dok_ktp" class=" form-control form-control-sm">
                        <div class="invalid-feedback errordok_ktp"></div>
                        <div class="progress">
                            <div id="file-progress-bar" class="progress-bar"></div>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label> <i class="mdi mdi-map-marker-multiple"></i>
                        Alamat
                    </label>
                    <textarea type="text" class="form-control form-control-sm bg-light" id="alamat" name="alamat"></textarea>
                    <div class="invalid-feedback erroralamat"></div>
                </div>

                <div class="modal-footer p-0">
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $(".progress").hide();
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
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(element) {
                                if (element.lengthComputable) {
                                    $(".progress").show();
                                    var percentComplete = ((element.loaded / element.total) * 100);
                                    $("#file-progress-bar").width(percentComplete + '%');
                                    // $("#file-progress-bar").html(percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        type: "post",
                        url: '<?= site_url('daftar/simpan') ?>',
                        data: data,
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",

                        beforeSend: function() {
                            $('.btnsimpan').attr('disable', 'disable');
                            $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                            $("#file-progress-bar").width('0%');
                        },
                        complete: function() {
                            $('.btnsimpan').removeAttr('disable', 'disable');
                            $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                        },
                        success: function(response) {
                            if (response.error) {

                                if (response.error.nama) {
                                    $('#nama').addClass('is-invalid');
                                    $('.errornama').html(response.error.nama);
                                } else {
                                    $('#nama').removeClass('is-invalid');
                                    $('.errornama').html();
                                    $('#nama').addClass('is-valid');
                                }

                                if (response.error.jk) {
                                    $('#jk').addClass('is-invalid');
                                    $('.errorjk').html(response.error.jk);
                                } else {
                                    $('#jk').removeClass('is-invalid');
                                    $('.errorjk').html();
                                    $('#jk').addClass('is-valid');
                                }

                                if (response.error.no_hp) {
                                    $('#no_hp').addClass('is-invalid');
                                    $('.errorno_hp').html(response.error.no_hp);
                                } else {
                                    $('#no_hp').removeClass('is-invalid');
                                    $('.errorno_hp').html();
                                    $('#no_hp').addClass('is-valid');
                                }

                                if (response.error.tgl_lahir) {
                                    $('#tgl_lahir').addClass('is-invalid');
                                    $('.errortgl_lahir').html(response.error.tgl_lahir);
                                } else {
                                    $('#tgl_lahir').removeClass('is-invalid');
                                    $('.errortgl_lahir').html();
                                    $('#tgl_lahir').addClass('is-valid');
                                }

                                if (response.error.alamat) {
                                    $('#alamat').addClass('is-invalid');
                                    $('.erroralamat').html(response.error.alamat);
                                } else {
                                    $('#alamat').removeClass('is-invalid');
                                    $('.erroralamat').html();
                                    $('#alamat').addClass('is-valid');
                                }

                                if (response.error.dok_ktp) {
                                    $('#dok_ktp').addClass('is-invalid');
                                    $('.errordok_ktp').html(response.error.dok_ktp);
                                    $("#file-progress-bar").width('0%');
                                    $(".progress").hide();
                                } else {
                                    $('#dok_ktp').removeClass('is-invalid');
                                    $('.errordok_ktp').html('');
                                    $(".progress").show();
                                }


                            } else {

                                toastr["success"](response.sukses)
                                $('#modaltambah').modal('hide');
                                listanggota();
                                $(".progress").hide();
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