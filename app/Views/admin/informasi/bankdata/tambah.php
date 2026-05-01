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
            <!-- <?= form_open_multipart('bankdata/simpanBankData', ['class' => 'formtambah']) ?> -->
            <?= form_open_multipart('', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">

                <!-- <div class="card m-b-10 text-white bg-primary">
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
                        Nama File
                    </label>
                    <input type="text" id="nama_bankdata" name="nama_bankdata" class="form-control">
                    <div class="invalid-feedback errornama_bankdata"></div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Upload File
                    </label>
                    <input type="file" id="fileupload" name="fileupload" class="form-control">
                    <div class="invalid-feedback errorfileupload"></div>
                    <div class="progress">
                        <div id="file-progress-bar" class="progress-bar"></div>
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

            $(".progress").hide();
        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(element) {
                        if (element.lengthComputable) {
                            $(".progress").show();
                            var percentComplete = ((element.loaded / element.total) * 100);
                            $("#file-progress-bar").width(percentComplete + '%');
                            // $("#file-progress-bar").html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                type: "post",
                url: '<?= site_url('bankdata/simpanBankData') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                    $("#file-progress-bar").width('0%');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama_bankdata) {
                            $('#nama_bankdata').addClass('is-invalid');
                            $('.errornama_bankdata').html(response.error.nama_bankdata);
                        } else {
                            $('#nama_bankdata').removeClass('is-invalid');
                            $('.errornama_bankdata').html('');
                        }

                        if (response.error.fileupload) {
                            $("#file-progress-bar").width('0%');
                            $('#fileupload').addClass('is-invalid');
                            $('.errorfileupload').html(response.error.fileupload);
                            $(".progress").hide();

                        } else {
                            $('#fileupload').removeClass('is-invalid');
                            $('.errorfileupload').html('');
                            $(".progress").show();
                        }
                    } else if (response.nofile) {

                        toastr["error"](response.nofile)
                        $("#file-progress-bar").width('0%');
                        $('#fileupload').addClass('is-invalid');
                        // $('.errornofile').html(response.error.nofile);
                        $(".progress").hide();
                    } else {

                        toastr["success"](response.sukses)
                        $('#modaltambah').modal('hide');
                        listbankdata();
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