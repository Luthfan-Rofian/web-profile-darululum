<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <!-- <?= form_open_multipart('dokumen/simpanDokumen', ['class' => 'formtambah']) ?> -->
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">

                 <div class="card m-b-10 text-white bg-primary">
                    <div class="card-body">
                        <blockquote class="card-blockquote mb-0">
                            PERHATIAN :
                            <footer class="blockquote-footer text-white font-12">
                                File yang diupload Maksimal <cite title="Source Title">2096 KB </cite>

                            </footer>
                            <footer class="blockquote-footer text-white font-12">
                                Format file : <cite title="Source Title">.jpg, .jpeg, .gif, .png, pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt</cite>
                            </footer>
                        </blockquote>

                    </div>

                </div> -->

                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Nama Dokumen *
                    </label>
                    <input type="text" id="nama_dok" name="nama_dok" class="form-control form-control-sm">
                    <div class="invalid-feedback errornama_dok"></div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Kategori *
                    </label>

                    <select name="id_katdok" id="id_katdok" class="form-control form-control-sm ">
                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                        <?php foreach ($kat as $key => $data) { ?>
                            <option value="<?= $data['id_katdok'] ?>"><?= $data['nama_katdok'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback errorid_katdok"></div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Upload File *
                    </label>
                    <input type="file" id="file_dok" name="file_dok" class="form-control form-control-sm">
                    <div class="invalid-feedback errorfile_dok"></div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <textarea type="text" id="ket" name="ket" class="form-control form-control-sm"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('dokumen/simpanDokumen') ?>',
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

                        if (response.error.nama_dok) {
                            $('#nama_dok').addClass('is-invalid');
                            $('.errornama_dok').html(response.error.nama_dok);
                        } else {
                            $('#nama_dok').removeClass('is-invalid');
                            $('.errornama_dok').html('');
                        }
                        if (response.error.id_katdok) {
                            $('#id_katdok').addClass('is-invalid');
                            $('.errorid_katdok').html(response.error.id_katdok);
                        } else {
                            $('#id_katdok').removeClass('is-invalid');
                            $('.errorid_katdok').html('');
                        }

                        if (response.error.file_dok) {
                            $('#file_dok').addClass('is-invalid');
                            $('.errorfile_dok').html(response.error.file_dok);
                        } else {
                            $('#file_dok').removeClass('is-invalid');
                            $('.errorfile_dok').html('');
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
                        $('#modaltambah').modal('hide');
                        listdokumen();
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