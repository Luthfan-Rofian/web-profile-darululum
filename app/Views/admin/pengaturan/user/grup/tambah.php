<?php

use App\Models\M_Dge_modul;

$this->modulecms = new M_Dge_modul();

?>
<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Grup Akses
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formtambahgrp']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">


                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama Grup</label>
                        <input type="text" class="form-control form-control-sm" id="nama_grup" name="nama_grup">
                        <div class="invalid-feedback errornama_grup"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">

                        <label>Keterangan</label>
                        <input type="text" class="form-control form-control-sm" id="ketgrup" name="ketgrup">
                    </div>

                </div>

                <div id="accordion">
                    <?php $no = 0;
                    foreach ($listgrupakses as $data) :
                        $no++;

                    ?>
                        <div class="card mb-1">

                            <div class="card-header m-0 p-2" style="background-color:#ADD8E6" id="heading<?= $no ?>">
                                <h6 class="m-0 font-14">
                                    <a href="#collapse<?= $no ?>" class="text-secondary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $no ?>">
                                        <?= strtoupper($data['gm']) ?>
                                    </a>
                                    <div class="float-right m-0">
                                        <a href="#collapse<?= $no ?>" class="text-secondary" data-toggle="collapse" aria-expanded="true" aria-controls="collapse<?= $no ?>">
                                            <i class="fas fa-angle-down"></i>
                                        </a>
                                    </div>
                                </h6>
                            </div>

                            <div id="collapse<?= $no ?>" class="collapse <?= $no == 1 ? 'show' : '' ?>" aria-labelledby="heading<?= $no ?>" data-parent="#accordion">

                                <?php $listmodul =  $this->modulecms->listbygrup($data['gm']); ?>

                                <div class="table-responsive p-1">
                                    <table class="table dataTable table-hover">
                                        <thead class="bg-light p-0 m-0">
                                            <tr>
                                                <th class="text-center p-1">NO</th>
                                                <th class="p-1">NAMA MODUL</th>
                                                <th class="text-center p-1">HAK AKSES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $nomor = 0;
                                            foreach ($listmodul as $data) :
                                                $nomor++; ?>
                                                <tr>
                                                    <td class="text-center p-1">
                                                        <?= $nomor ?></td>
                                                    <td class="p-1">
                                                        <?php if ($data['gm'] == '-') { ?>
                                                            => <?= esc($data['modul']) ?>
                                                        <?php   } else { ?>
                                                            <?= esc($data['modul']) ?>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- <td class="text-center p-0">
                                                        <?= $data['gm'] ?></td> -->

                                                    <td class="p-1">
                                                        <select name="akses[]" id="akses" class="form-control form-control-sm">
                                                            <option Disabled=true Selected=true>--Pilih Wewenang--</option>
                                                            <option value="1">Akses Semua Data</option>
                                                            <option value="2">Hanya Data Miliknya</option>
                                                            <option value="3" selected>Tidak Boleh Akses</option>
                                                        </select>
                                                        <div class="invalid-feedback errorakses"></div>
                                                    </td>
                                                    <td style="display:none"> <input type="hidden" id="id_modul" name="id_modul[]" value="<?= $data['id_modul'] ?>" class="form-control">
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>

                    <?php endforeach; ?>
                </div>





            </div>

            <div class="modal-footer p-1">
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
            let form = $('.formtambahgrp')[0];
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
                    url: '<?= site_url('user/simpangrup') ?>',
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

                            if (response.error.nama_grup) {
                                $('#nama_grup').addClass('is-invalid');
                                $('.errornama_grup').html(response.error.nama_grup);
                            } else {
                                $('#nama_grup').removeClass('is-invalid');
                                $('.errornama_grup').html('');
                            }


                        } else {

                            toastr["success"](response.sukses)
                            $('#modaltambah').modal('hide');
                            listgrup();
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