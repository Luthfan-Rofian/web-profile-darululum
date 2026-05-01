<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Akses Menu Dashboard
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formeditgrp']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body p-2 mb-0">
                <input type="hidden" value="<?= $id_grup ?>" name="id_grup">

                <div class="form-group">
                    <!-- <label class="">Akses Modul</label> -->

                    <div class="table-responsive p-0 mb-0">
                        <table class="table table-bordered dataTable table-hover">
                            <thead class="bg-light">
                                <tr>

                                    <th class="text-center">No</th>
                                    <th>Nama Menu</th>
                                    <th>Akses Menu</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 0;
                                foreach ($modul as $data) :
                                    $nomor++; ?>
                                    <tr class="mb-0">
                                        <td class="text-center p-1">
                                            <?= $nomor ?></td>
                                        <td class="p-1">
                                            <?= esc($data['modul']) ?>

                                        </td>

                                        <td class="p-1">
                                            <select name="aksesmenu[]" id="aksesmenu" class="form-control form-control-sm">
                                                <option Disabled=true Selected=true>Pilih</option>
                                                <option value="0">Sembunyikan Menu</option>
                                                <option value="1" selected>Tampilkan Menu</option>

                                            </select>

                                            <div class="invalid-feedback errorakses"></div>
                                        </td>
                                        <td style="display:none"> <input type="text" id="id_modul" name="id_modul[]" value="<?= $data['id_modul'] ?>" class="form-control">
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer p-0">
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btnupdate').click(function(e) {
                e.preventDefault();
                let form = $('.formeditgrp')[0];
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
                        url: '<?= site_url('user/simpangrupmenu') ?>',
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

                                // if (response.error.nama_grup) {
                                //     $('#nama_grup').addClass('is-invalid');
                                //     $('.errornama_grup').html(response.error.nama_grup);
                                // } else {
                                //     $('#nama_grup').removeClass('is-invalid');
                                //     $('.errornama_grup').html('');
                                //     $('#nama_grup').addClass('is-valid');
                                // }


                            } else {

                                toastr["success"](response.sukses)
                                $('#modaledit').modal('hide');
                                listgrup();
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