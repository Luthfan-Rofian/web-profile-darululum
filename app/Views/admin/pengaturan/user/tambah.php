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

                <?php if ($opd != '') { ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-9">
                            <select name="opd_id" id="opd_id" class="form-control">
                                <option Disabled=true Selected=true>-- Pilih Unit Kerja --</option>
                                <?php foreach ($opd as $key => $data) { ?>
                                    <option value="<?= $data['opd_id'] ?>"><?= $data['nama_opd'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback erroropd_id">Silahkan pilih unit kerja</div>
                        </div>
                    </div>

                <?php } ?>


                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama User</label>
                    <div class="col-sm-9">
                        <input type=" text" class="form-control" name="username" id="username" placeholder="Username" autofocus>
                        <div class="invalid-feedback errorusername"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                        <div class="invalid-feedback erroremail"></div>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <div class="invalid-feedback errorpassword"></div>
                    </div>

                </div>


                <div id="showhide">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Grup User</label>
                        <div class="col-sm-9">
                            <select name="id_grup" id="id_grup" class="form-control">
                                <option Disabled=true Selected=true>-- Pilih Grup User --</option>
                                <?php foreach ($listgrup as $key => $data) { ?>
                                    <option value="<?= $data['id_grup'] ?>"><?= $data['nama_grup'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorid_grup"></div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type=" text" class="form-control" name="fullname" id="fullname" placeholder="Nama Lengkap" required>
                            <div class="invalid-feedback errorFullname"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto Profil</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" required>
                                <div class="invalid-feedback errorFoto"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer p-1">

                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal"> <i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#opd_id').select2({
                dropdownParent: $('#modaltambah')

            })


            $('.btnupload').click(function(e) {
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
                        url: '<?= site_url('user/simpanUser') ?>',
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

                                if (response.error.username) {
                                    $('#username').addClass('is-invalid');
                                    $('.errorusername').html(response.error.username);
                                } else {
                                    $('#username').removeClass('is-invalid');
                                    $('.errorusername').html('');
                                    $('#username').addClass('is-valid');

                                }

                                if (response.error.password) {
                                    $('#password').addClass('is-invalid');
                                    $('.errorpassword').html(response.error.password);
                                } else {
                                    $('#password').removeClass('is-invalid');
                                    $('.errorpassword').html('');
                                    $('#password').addClass('is-valid');
                                }


                                if (response.error.fullname) {
                                    $('#fullname').addClass('is-invalid');
                                    $('.errorFullname').html(response.error.fullname);
                                } else {
                                    $('#fullname').removeClass('is-invalid');
                                    $('.errorFullname').html('');
                                    $('#fullname').addClass('is-valid');
                                }
                                if (response.error.id_grup) {
                                    $('#id_grup').addClass('is-invalid');
                                    $('.errorid_grup').html(response.error.id_grup);
                                } else {
                                    $('#id_grup').removeClass('is-invalid');
                                    $('.errorid_grup').html('');
                                    $('#id_grup').addClass('is-valid');
                                }


                                if (response.error.email) {
                                    $('#email').addClass('is-invalid');
                                    $('.erroremail').html(response.error.email);
                                } else {
                                    $('#email').removeClass('is-invalid');
                                    $('.erroremail').html('');
                                    $('#email').addClass('is-valid');
                                }

                                if (response.error.foto) {
                                    $('#foto').addClass('is-invalid');
                                    $('.errorFoto').html(response.error.foto);
                                } else {
                                    $('#foto').removeClass('is-invalid');
                                    $('.errorFoto').html('');
                                    $('#foto').addClass('is-valid');
                                }

                            } else if (response.gopdid) {
                                $('#opd_id').addClass('is-invalid');
                                $('.erroropd_id').html(response.gopdid.opd_id);

                                toastr["error"](response.gopdid)

                            } else {


                                toastr["success"](response.sukses)
                                $('#modaltambah').modal('hide');
                                listuser();
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