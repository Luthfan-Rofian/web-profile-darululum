<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- <div class="modal fade" id="modaltambah" tabindex="-1"> -->
    <div class="modal-dialog modal-dialog-centered">
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

                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <input type="text" class="form-control form-control-sm" id="ket" name="ket">
                    <div class="invalid-feedback errorKeterangan"></div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>Upload File</label>
                    <input type="file" class="form-control form-control-sm" id="banner_image" name="banner_image">
                    <div class="invalid-feedback errorFoto"></div>
                </div>


                <!-- Single menu start -->
                <div id="single">
                    <div class="form-group">
                        <label><i class="mdi mdi-link-variant"></i> Sumber Link</label>
                        <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">
                            <!-- <option value="1" selected='selected'>--Pilih Sumber--</option> -->
                            <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                            <option value="1">Kategori Berita</option>
                            <option value="2">Halaman</option>
                            <option value="3">Modul CMS</option>
                            <option value="4">Berita</option>
                            <option value="5">Eksternal</option>
                        </select>
                        <!-- <div class="invalid-feedback errorlink"></div> -->
                    </div>

                    <div class="form-group" id="berita">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Kategori Berita</label>
                        <select name="dberita" id="dberita" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Kategori Berita--</option>
                            <?php foreach ($kategori as $key => $data) { ?>
                                <option data-link="category/<?= esc($data['slug_kategori']) ?>"><?= $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="halaman">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Halaman</label>
                        <select name="dhalaman" id="dhalaman" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Halaman--</option>
                            <?php foreach ($halaman as $key => $data) { ?>
                                <option data-link="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="detberita">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Berita</label>

                        <select name="dtberita" id="dtberita" class="form-control select2">
                            <option Disabled=true Selected=true>--Pilih Berita--</option>
                            <?php foreach ($berita as $key => $data) { ?>
                                <option data-link="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errordberita"></div>
                    </div>

                    <div class="form-group" id="modul">
                        <label> <i class="mdi mdi-clipboard-check-outline"></i> Pilih Modul CMS</label>
                        <select class="form-control form-control-sm" name="modulcms" id="modulcms">
                            <option Disabled=true Selected=true>-- Pilih Modul CMS--</option>
                            <?php foreach ($modulpublic as $key => $data) { ?>
                                <option data-link="<?= esc($data['link']) ?>"><?= $data['modpublic'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorlink"></div>
                    </div>

                    <div class="form-group" id="eksternal">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Link URL <small class="text-danger">(Misalnya: http://aplikasipendidikan.net/)</small>
                        </label>
                        <input type="text" id="link" name="link" class="form-control form-control-sm">
                        <div class="invalid-feedback errorgm"></div>
                    </div>
                </div>
                <!-- end single -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#dtberita').select2({
            dropdownParent: $('#modaltambah')
        })
        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
        $("#detberita").hide();
        $("#modul").hide();
        // $('[name=link]').val('#');
        // $('[name=linkexternal]').val('N');


        // Pilihan Sumber Link 
        $('#sumberlink').on('change', function() {
            const linkexternal = $('#sumberlink option:selected').data('linkexternal');
            $('[name=linkexternal]').val(linkexternal);
        });

        // Pilihan Modul CMS
        $('#modulcms').on('change', function() {

            const link = $('#modulcms option:selected').data('link');
            $('[name=link]').val(link);
        });
        // Pilihan Kategori Berita
        $('#dberita').on('change', function() {

            const link = $('#dberita option:selected').data('link');
            $('[name=link]').val(link);
        });

        // Pilihan Halaman
        $('#dhalaman').on('change', function() {

            const link = $('#dhalaman option:selected').data('link');
            $('[name=link]').val(link);
        });

        // Pilihan Berita
        $('#dtberita').on('change', function() {

            const link = $('#dtberita option:selected').data('link');
            $('[name=link]').val(link);
        });

        $('#sumberlink').on('change', function() {
            $('[name=dberita]').val('');
            $('[name=dhalaman]').val('');
            $('[name=dtberita]').val('');
            $('[name=modulcms]').val('');

            if ($('#sumberlink').val() == '1') {
                $("#eksternal").hide();
                $("#berita").show();
                $("#halaman").hide();
                $("#detberita").hide();
                $("#modul").hide();
                $('[name=link]').val('');
            } else if ($('#sumberlink').val() == '2') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").show();
                $("#detberita").hide();
                $("#modul").hide();
                $('[name=link]').val('');
            } else if ($('#sumberlink').val() == '3') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#detberita").hide();
                $("#modul").show();
                $('[name=link]').val('');
            } else if ($('#sumberlink').val() == '4') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $("#detberita").show();
                $('[name=link]').val('');
            } else {
                $("#eksternal").show();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $("#detberita").hide();
                $('[name=link]').val('');
            }
        });


    });
</script>

<script>
    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('banner/uploadfoto') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.ket) {
                            $('#ket').addClass('is-invalid');
                            $('.errorKeterangan').html(response.error.ket);
                        } else {
                            $('#ket').removeClass('is-invalid');
                            $('.errorKeterangan').html('');
                        }

                        if (response.error.banner_image) {
                            $('#banner_image').addClass('is-invalid');
                            $('.errorFoto').html(response.error.banner_image);
                        } else {
                            $('#banner_image').removeClass('is-invalid');
                            $('.errorFoto').html('');
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
                        listbanner();
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