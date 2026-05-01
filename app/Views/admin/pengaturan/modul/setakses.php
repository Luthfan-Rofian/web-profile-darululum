<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formedit']) ?>

            <?= csrf_field(); ?>
            <div class="modal-body">

                <input type="hidden" class="form-control" id="id_modul" value="<?= $id_modul ?>" name="id_modul" readonly>
                <input type="text" class="form-control" value="<?= $modul ?>" name="modul" readonly>
                <hr>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Pilih Role Grup <?= $statusnya ?>
                        </label>
                        <select name="id_grup" id="id_grup" class="form-control">
                            <option Disabled=true Selected=true>-- Pilih --</option>
                            <?php foreach ($listgrup as $key => $data) { ?>
                                <option value="<?= $data['id_grup'] ?>"><?= $data['nama_grup'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorid_grup"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Grup Menu
                        </label>
                        <select name="akses" id="akses" class="form-control">
                            <option Disabled=true Selected=true>--Pilih Wewenang--</option>
                            <option value="1">Akses Semua Data</option>
                            <option value="2">Hanya Data Miliknya</option>
                            <option value="3" selected>Tidak Boleh Akses</option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <?php if ($statusnya != 'OK') { ?>

                    <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <?php  } else { ?>
                    <small> <strong class="text-danger"><i> Untuk ubah Wewenang silahkan buka Pengaturan Grup User <a href="<?= base_url('user/grup') ?>">Disini</a> .</i></strong></small>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('modul/simpansetakses') ?>',
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

                        if (response.error.id_grup) {
                            $('#id_grup').addClass('is-invalid');
                            $('.errorid_grup').html(response.error.id_grup);
                        } else {
                            $('#id_grup').removeClass('is-invalid');
                            $('.errorid_grup').html('');
                        }
                    } else if (response.aksesganda) {

                        toastr["error"](response.aksesganda)

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
                        listmodul();
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    toastr["error"]("Maaf gagal proses Kode Error: dlm " + (xhr.status + "\n"), )
                    $('#modaledit').modal('hide');

                }
            });
        });
    });
</script>