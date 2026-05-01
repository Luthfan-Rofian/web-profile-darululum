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
                <input type="hidden" value="<?= $id_dokumenupl ?>" name="id_dokumenupl">
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Nama File
                    </label>
                    <input type="text" id="nama_dok" name="nama_dok" value="<?= $nama_dok ?>" class="form-control form-control-sm">
                    <div class="invalid-feedback errornama_dok"></div>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Kategori
                    </label>
                    <select class="form-control form-control-sm" name="id_katdok" id="id_katdok">
                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                        <?php foreach ($kat as $key => $value) { ?>
                            <option value="<?= $value['id_katdok'] ?>" <?= $id_katdok ==  $value['id_katdok'] ? 'selected' : '' ?>><?= $value['nama_katdok'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <textarea type="text" class="form-control form-control-sm" id="ket" name="ket"> <?= esc($ket) ?></textarea>

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
                url: '<?= site_url('dokumen/updatedokumen') ?>',
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

                        if (response.error.nama_dok) {
                            $('#nama_dok').addClass('is-invalid');
                            $('.errornama_dok').html(response.error.nama_dok);
                        } else {
                            $('#nama_dok').removeClass('is-invalid');
                            $('.errornama_dok').html('');
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
                        listdokumen();
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