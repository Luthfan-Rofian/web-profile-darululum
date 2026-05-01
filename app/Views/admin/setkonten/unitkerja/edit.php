<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                <input type="hidden" value="<?= $opd_id ?>" name="opd_id">


                <div class="form-group">
                    <label>
                        Nama Unit Kerja
                    </label>
                    <input type="text" id="nama_opd" name="nama_opd" value="<?= $nama_opd ?>" class="form-control">
                    <div class="invalid-feedback errornama_opd"></div>
                </div>


                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>
                            Singkatan Unit Kerja
                        </label>
                        <input type=" text" id="singkatan_opd" name="singkatan_opd" value="<?= $singkatan_opd ?>" class="form-control">
                        <div class="invalid-feedback errorsingkatan_opd"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>
                            Tipe
                        </label>
                        <select class="form-control" name="tipe_id" id="tipe_id">
                            <option Disabled=true Selected=true>-- Pilih Tipe --</option>
                            <?php foreach ($tipe as $key => $value) { ?>
                                <option value="<?= $value['tipe_id'] ?>" <?= $tipe_id ==  $value['tipe_id'] ? 'selected' : '' ?>><?= $value['nama_tipe'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label>
                        Alamat
                    </label>
                    <input type="text" id="alamat" name="alamat" value="<?= $alamat ?>" class=" form-control">
                    <div class="invalid-feedback erroralamat"></div>
                </div>

                <div class="form-group">
                    <label>
                        Deskripsi
                    </label>
                    <textarea type="text" class="form-control" id="deskripsi_opd" name="deskripsi_opd"> <?= esc($deskripsi_opd) ?></textarea>

                    <div class="invalid-feedback errordeskripsi_opd"></div>
                </div>



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


        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('unitkerja/updatepenerbit') ?>',
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

                        if (response.error.nama_opd) {
                            $('#nama_opd').addClass('is-invalid');
                            $('.errornama_opd').html(response.error.nama_opd);
                        } else {
                            $('#nama_opd').removeClass('is-invalid');
                            $('.errornama_opd').html('');
                        }

                        if (response.error.deskripsi_opd) {
                            $('#deskripsi_opd').addClass('is-invalid');
                            $('.errordeskripsi_opd').html(response.error.deskripsi_opd);
                        } else {
                            $('#deskripsi_opd').removeClass('is-invalid');
                            $('.errordeskripsi_opd').html('');
                        }

                        if (response.error.singkatan_opd) {
                            $('#singkatan_opd').addClass('is-invalid');
                            $('.errorsingkatan_opd').html(response.error.singkatan_opd);
                        } else {
                            $('#singkatan_opd').removeClass('is-invalid');
                            $('.errorsingkatan_opd').html('');
                        }

                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.erroralamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.erroralamat').html('');
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
                        listunitkerja();
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