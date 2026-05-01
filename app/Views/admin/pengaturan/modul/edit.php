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

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Nama Modul
                        </label>
                        <input type="text" id="modul" name="modul" value="<?= $modul ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errormodul"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Grup Menu
                        </label>
                        <select name="gm" id="gm" class="form-control form-control-sm">
                            <option value="-" selected>--TIDAK DIJADIKAN MENU--</option>
                            <?php foreach ($modulmenu as $key => $data) { ?>
                                <option value="<?= $data['gm'] ?>" <?= $gm ==  $data['gm'] ? 'selected' : '' ?>><?= $data['modul'] ?></option>
                            <?php } ?>


                        </select>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Urutan Modul
                        </label>
                        <input type="number" id="urut" name="urut" value="<?= $urut ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorurut"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            URL Menu
                        </label>
                        <input type="text" id="urlmenu" name="urlmenu" value="<?= $urlmenu ?>" placeholder="Link Controler utk Akses Modul" class="form-control form-control-sm">
                        <div class="invalid-feedback errorurlmenu"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Ikon
                        </label>
                        <input type="text" id="ikonmn" name="ikonmn" value="<?= $ikonmn ?>" placeholder="Jika tdk dijadikan menu abaikan." class="form-control form-control-sm">


                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Lihat Icon</label>
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm mr-1" data-toggle="modal" data-target=".fontawesome">Font Awesome</button>
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm" data-toggle="modal" data-target=".mdideril">Material Design</button>
                        </div>
                    </div>
                </div>

                <!-- <small> <strong class="text-warning"><i> Pembuatan modul ini, hanya untuk mendaftarkan Modul baru ..!</i></strong></small> -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Simpan</button>
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
                url: '<?= site_url('modul/updatemodul') ?>',
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

                        if (response.error.modul) {
                            $('#modul').addClass('is-invalid');
                            $('.errormodul').html(response.error.modul);
                        } else {
                            $('#modul').removeClass('is-invalid');
                            $('.errormodul').html('');
                        }

                        if (response.error.urlmenu) {
                            $('#urlmenu').addClass('is-invalid');
                            $('.errorurlmenu').html(response.error.urlmenu);
                        } else {
                            $('#urlmenu').removeClass('is-invalid');
                            $('.errorurlmenu').html('');
                        }

                        if (response.error.urut) {
                            $('#urut').addClass('is-invalid');
                            $('.errorurut').html(response.error.urut);
                        } else {
                            $('#urut').removeClass('is-invalid');
                            $('.errorurut').html('');
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
                        listmodul();
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