<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formfoto']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $id ?>" name="id">

                <?php if ($opd != '') { ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-9">
                            <select name="opd_id" id="opd_id" class="form-control">
                                <option Disabled=true Selected=true>-- Pilih Unit Kerja --</option>
                                <?php foreach ($opd as $key => $value) { ?>
                                    <option value="<?= $value['opd_id'] ?>" <?= $opd_id ==  $value['opd_id'] ? 'selected' : '' ?>><?= $value['nama_opd'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback erroropd_id">Silahkan pilih unit kerja</div>
                        </div>
                    </div>

                <?php } ?>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama User</label>
                    <div class="col-sm-9">
                        <input type=" text" class="form-control" name="username" id="username" value="<?= $username ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>">
                        <div class="invalid-feedback erroremail"></div>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak diganti">

                    </div>

                </div>
                <?php if ($jenisgrp != '1') { ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Grup User</label>
                        <div class="col-sm-9">
                            <select name="id_grup" id="id_grup" class="form-control">
                                <option Disabled=true Selected=true>-- Pilih Grup User --</option>
                                <?php foreach ($listgrup as $key => $value) { ?>
                                    <option value="<?= $value['id_grup'] ?>" <?= $id_grup ==  $value['id_grup'] ? 'selected' : '' ?>><?= $value['nama_grup'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorid_grup"></div>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" value="<?= $id_grup ?>" name="id_grup">
                <?php } ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type=" text" class="form-control" name="fullname" id="fullname" value="<?= $fullname ?>" required>
                        <div class="invalid-feedback errorFullname"></div>
                    </div>

                </div>

            </div>

            <div class="modal-footer p-1">

                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formfoto')[0];
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
                    url: '<?= site_url('user/updateuser') ?>',
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
                        $('.btnupload').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                    },
                    success: function(response) {
                        if (response.error) {

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

                        } else if (response.gopdid) {
                            $('#opd_id').addClass('is-invalid');
                            $('.erroropd_id').html(response.gopdid.opd_id);

                            toastr["error"](response.gopdid)

                        } else {

                            toastr["success"](response.sukses)
                            $('#modaledit').modal('hide');
                            listuser();
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