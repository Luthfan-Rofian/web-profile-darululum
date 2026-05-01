<?= $this->section('content') ?>
<?= $this->extend('admin/script') ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">
            <div class="state-information d-none d-sm-block">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper">
    <div class="row">

        <div class="col-lg-12">
            <div class="card mb-4">
                <?= form_open_multipart('', ['class' => 'formedit']) ?>
                <?= csrf_field(); ?>
                <div class="card-header font-18 bg-light">
                    <h5 class="modal-title mt-0">
                        <i class="fas fa-cogs"></i> <?= $subtitle ?>


                    </h5>
                </div>

                <div class='card-body'>

                    <input type="hidden" class="form-control" id="id_setaplikasi" value="<?= $id_setaplikasi ?>" name="id_setaplikasi" readonly>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Backup Data</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#migrasi" role="tab">Migrasi DB</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="tab-pane active p-1" id="home1" role="tabpanel">
                            <p class="mt-3 mb-0">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Backup Database </strong></h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <form class="form-horizontal">
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <?= session()->getFlashdata('msg') ?>
                                                                <td class="col-sm-10"><b>Backup Seluruh Database (.sql)</b></td>
                                                                <td class="col-sm-2">
                                                                    <button type="button" class="btn btn-social btn-flat btn-block btn-info" onclick="location.href=('/cmsdatagoe/database/doBackupm')">Backup Db</button>
                                                                    <a href="" class="btn btn-social btn-flat btn-block btn-info btn-sm btnbackupdb"><i class="fa fa-download"></i> Unduh Database</a>
                                                                    <a href="" class="btn btn-social btn-flat btn-block btn-info btn-sm btnbackupdb"><i class="fa fa-download"></i> Unduh Database</a>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="col-sm-10"><b>Backup Seluruh Folder CMS (.zip)</b> </td>
                                                                <td class="col-sm-2">
                                                                    <a href="<?= site_url("database/desa_backup"); ?>" class="btn btn-social btn-flat btn-block btn-info btn-sm"><i class="fa fa-download"></i> Unduh Folder Desa</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                                <p>Proses Unduh akan mengunduh keseluruhan database anda.</p>
                                                <div class="row">
                                                    <ul>
                                                        <li> Usahakan untuk melakukan backup secara rutin dan terjadwal. </li>
                                                        <li> Backup yang dihasilkan sebaiknya disimpan di komputer terpisah dari server CMS Datagoe. </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>




                        <div class="tab-pane p-1" id="migrasi" role="tabpanel">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">

                                        <div class="alert alert-warning p-1 mt-2">
                                            <label class="text-dark p-0">
                                                Proses ini untuk mengubah database CMS ke struktur database CMS DATAGOE Terbaru..
                                            </label>
                                        </div>
                                        <p class="text-danger text-red well well-sm no-shadow" style="margin-top: 10px;">
                                            <small>
                                                <strong><i class="fa fa-info-circle text-red"></i> Sebelum melakukan migrasi ini, pastikan database CMS anda telah dibackup.</strong>
                                            </small>
                                        </p>
                                        <p>Segala bentuk kerugian dan kesalahan yang ditimbulkan akibat kelalaian sendiri, Tidak menjadi Tanggung Jawab Developer..!</p>


                                        <!-- </form> -->

                                        <tr>
                                            <td style="padding-top:20px;padding-bottom:10px;">
                                                <div class="form-group">
                                                    <div class="col-sm-8 col-lg-4">
                                                        <a href="#" class="btn btn-block btn-danger btn-sm btnmigrasi" title="Migrasi DB"> <i class="fas fa-spin fa-refresh"></i> Migrasi Database Ke CMS Terbaru</a>
                                                    </div>
                                                </div>
                                                <div class="ajax-content"></div>
                                            </td>
                                        </tr>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div>

            </div><!-- Main Footer -->
        </div>


    </div>
    <?= form_close() ?>
</div>

<div class="viewmodal"></div>

<script>
    $('.btnmigrasi').click(function(e) {
        e.preventDefault();
        let form = $('.formedit')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: '<?= site_url('database/migrasidb') ?>',
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnmigrasi').attr('disable', 'disable');
                $('.btnmigrasi').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                // $('#loading').modal('show');
            },
            complete: function() {
                $('.btnmigrasi').removeAttr('disable', 'disable');
                $('.btnmigrasi').html('<i class="mdi mdi-content-save-all"></i> Simpan');
            },
            success: function(response) {
                if (response.error) {

                    // if (response.error.nama_link) {
                    //     $('#nama_link').addClass('is-invalid');
                    //     $('.errornamalink').html(response.error.nama_link);
                    // } else {
                    //     $('#nama_link').removeClass('is-invalid');
                    //     $('.errornamalink').html('');
                    // }



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
                    // $('#loading').modal('hide');
                    // listlinkterkait();
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                // $('#loading').modal('hide');
            }
        });
    });
</script>

<script>
    $('.btnbackupdb').click(function(e) {
        e.preventDefault();
        let form = $('.formedit')[0];
        let data = new FormData(form);
        $.ajax({
            type: "post",
            url: '<?= site_url('database/doBackup') ?>',
            data: data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnbackupdb').attr('disable', 'disable');
                $('.btnbackupdb').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                // $('#loading').modal('show');
            },
            complete: function() {
                $('.btnbackupdb').removeAttr('disable', 'disable');
                $('.btnbackupdb').html('<i class="mdi mdi-content-save-all"></i> Simpan');
            },
            success: function(response) {
                if (response.error) {

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
                        toastr["error"](response.error)

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

                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );

            }
        });
    });
</script>
<?= $this->endSection() ?>