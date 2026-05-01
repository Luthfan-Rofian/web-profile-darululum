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

            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">

                <div class="card m-b-10 text-white bg-primary">
                    <div class="card-body">
                        <blockquote class="card-blockquote mb-0">
                            PERHATIAN :
                            <footer class="blockquote-footer text-white font-12">
                                File yang diupload Maksimal <cite title="Source Title">6096 KB </cite>

                            </footer>
                            <footer class="blockquote-footer text-white font-12">
                                Format file : <cite title="Source Title">.jpg, .jpeg, .gif, .png, pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt</cite>
                            </footer>
                        </blockquote>

                    </div>

                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Judul Detail Produk Hukum
                    </label>
                    <input type="hidden" id="id_produk" name="id_produk" value="<?= $id_produk ?>" class="form-control">
                    <input type="text" id="nama_kathukum" name="nama_kathukum" class="form-control">
                    <div class="invalid-feedback errornama_kathukum"></div>
                </div>

                <div class="form-group ">
                    <label>Lanjutkan Ke Sub-sub</label>
                    <div class="form-control ">
                        <input class="pointer" type="radio" id="skathukumtida" name="skathukum" value="0" checked> Tidak &nbsp
                        <input class="pointer" type="radio" id="skathukumya" name="skathukum" value="1"> Ya &nbsp
                    </div>
                </div>
                <div id="showhide">
                    <div class="form-group">
                        <label> <i class="mdi mdi-image"></i>
                            Upload File
                        </label>
                        <input type="file" id="file_kathukum" name="file_kathukum" class="form-control">
                        <div class="invalid-feedback errorfile_kathukum"></div>
                    </div>
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

        $("#skathukumya").click(function() {
            $("#showhide").hide();
        })

        $("#skathukumtida").click(function() {
            $("#showhide").show();
        })

    });
</script>


<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('produkhukum/simpanSubproduk') ?>',
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

                        if (response.error.nama_kathukum) {
                            $('#nama_kathukum').addClass('is-invalid');
                            $('.errornama_kathukum').html(response.error.nama_kathukum);
                        } else {
                            $('#nama_kathukum').removeClass('is-invalid');
                            $('.errornama_kathukum').html('');
                        }

                        if (response.error.file_kathukum) {
                            $('#file_kathukum').addClass('is-invalid');
                            $('.errorfile_kathukum').html(response.error.file_kathukum);
                        } else {
                            $('#file_kathukum').removeClass('is-invalid');
                            $('.errorfile_kathukum').html('');
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
                        listsubproduk();
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