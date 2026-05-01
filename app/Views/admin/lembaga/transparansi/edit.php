<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Edit Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="transparan_id" value="<?= $transparan_id ?>" name="transparan_id" readonly>


                <div class="form-group">
                    <label>
                        Judul
                    </label>
                    <input type="text" class="form-control" id="judul" value="<?= $judul ?>" name="judul">
                    <div class="invalid-feedback errorjudul"></div>
                </div>


                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>
                            Tahun
                        </label>
                        <input type="number" id="tahun" name="tahun" value="<?= $tahun ?>" class=" form-control" placeholder="Tahun Anggaran">
                        <div class="invalid-feedback errortahun"></div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>
                            Jenis
                        </label>
                        <div class="form-control ">
                            <input type="radio" id="jenis1" name="jenis" value="0" <?= $jenis == '0' ? 'checked' : '' ?>> <label for="jenis1" class="pointer">Pendapatan &nbsp</label>
                            <input type="radio" id="jenis2" name="jenis" value="1" <?= $jenis == '1' ? 'checked' : '' ?>> <label for="jenis2" class="pointer"> Belanja &nbsp</label>
                        </div>
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
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
                    url: '<?= site_url('transparansi/updatedata') ?>',
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

                            if (response.error.judul) {
                                $('#judul').addClass('is-invalid');
                                $('.errorjudul').html(response.error.judul);
                            } else {
                                $('#judul').removeClass('is-invalid');
                                $('.errorjudul').html('');
                            }

                            if (response.error.tahun) {
                                $('#tahun').addClass('is-invalid');
                                $('.errortahun').html(response.error.tahun);
                            } else {
                                $('#tahun').removeClass('is-invalid');
                                $('.errortahun').html('');
                            }


                        } else {

                            toastr["success"](response.sukses)
                            $('#modaledit').modal('hide');
                            listtransparansi();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {

                        toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                        $('#modaledit').modal('hide');

                    }
                });
        });

    });
</script>