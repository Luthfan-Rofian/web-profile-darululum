<div class="modal fade" id="modaledit">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formgambar']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $section_id ?>" name="section_id">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-text-shadow"></i>
                            Nama Section
                        </label>
                        <input type="text" id="nama_section" name="nama_section" value="<?= $nama_section ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errornama_section"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label><i class="mdi mdi-link-variant"></i> Link Sebelumnya</label>
                        <input type="text" id="linkold" name="linkold" readonly value="<?= $link ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorlink"></div>
                    </div>
                </div>

                <div class="form-group ">
                    <!-- <label>Eksternal Link</label> -->
                    <label><i class="mdi mdi-clipboard-check-outline"></i> Sumber Link</label> <small class="text-danger"> (Pilih jika Link mau diganti) </small>
                    <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">
                        <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                        <option value="1" data-linksumber="N">Kategori Berita</option>
                        <option value="2" data-linksumber="N">Halaman</option>
                        <option value="3" data-linksumber="N">Modul CMS</option>
                        <option value="4" data-linksumber="Y">Eksternal</option>
                    </select>

                </div>

                <!-- Single menu start -->
                <input type="hidden" id="linksumber" name="linksumber" value="<?= $linksumber ?>" class="form-control form-control-sm">
                <div id="single">

                    <div class="form-group" id="berita">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Kategori Berita</label>
                        <select name="dberita" id="dberita" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Kategori Berita--</option>
                            <?php foreach ($kategoriberita as $key => $data) { ?>
                                <option data-link="category/<?= esc($data['slug_kategori']) ?>"><?= $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" id="halaman">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Halaman</label>
                        <select name="dhalaman" id="dhalaman" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Halaman--</option>
                            <?php foreach ($halaman as $key => $data) { ?>
                                <option data-link="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="form-group" id="modul">
                        <label><i class="mdi mdi-clipboard-check-outline"></i> Pilih Modul CMS</label>
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
                        <input type="text" id="link" name="link" value="<?= $link ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorlink"></div>
                    </div>
                </div>
                <!-- end single -->

                <div class="form-group">
                    <label> <i class="mdi mdi-file-image"></i>
                        Ganti gambar
                    </label>
                    <input type="file" class="form-control form-control-sm" id="gambar" name="gambar">
                    <div class="invalid-feedback errorgambar"></div>
                    <a class="text-warning">
                        <small>Format gambar: .jpg, .jpeg, .gif, .png, Ukuran 300x300px </small>
                    </a>

                </div>
                <center>
                    <img class="img-thumbnailx" id="img_load" src="<?= base_url('public/img/section/'  . $gambar) ?>" height="100" alt="Section">

                </center>
                <center>Gambar section</center>



                <!-- <div class="form-group">
                    <label> <i class="mdi mdi-image"></i>
                        Gambar section
                    </label>
                    <img id='img_load' class="img-thumbnail" src='<?= base_url('public/img/section/' . $gambar) ?>'>

                </div> -->
            </div>

            <div class="modal-footer">

                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
            <?php echo form_close() ?>

        </div>

    </div>

</div>


<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_load').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#gambar').change(function() {
        bacaGambar(this);
    });

    $(document).ready(function() {
        // $("#single").hide();
        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
        $("#modul").hide();
        // $('[name=link]').val('#');
        $('[name=linksumber]').val('N');


        // Pilihan Sumber Link 
        $('#sumberlink').on('change', function() {
            const linksumber = $('#sumberlink option:selected').data('linksumber');
            $('[name=linksumber]').val(linksumber);
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

        $('#sumberlink').on('change', function() {
            $('[name=dberita]').val('');
            $('[name=dhalaman]').val('');
            $('[name=modulcms]').val('');

            if ($('#sumberlink').val() == '1') {
                $("#eksternal").hide();
                $("#berita").show();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=link]').val('');
            } else if ($('#sumberlink').val() == '2') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").show();
                $("#modul").hide();
                $('[name=link]').val('');
            } else if ($('#sumberlink').val() == '3') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").show();
                $('[name=link]').val('');
            } else {
                $("#eksternal").show();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=link]').val('');
            }
        });


        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formgambar')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('section/updatesection') ?>',
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
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama_section) {
                            $('#nama_section').addClass('is-invalid');
                            $('.errornama_section').html(response.error.nama_section);
                        } else {
                            $('#nama_section').removeClass('is-invalid');
                            $('.errornama_section').html('');
                        }

                        if (response.error.link) {
                            $('#link').addClass('is-invalid');
                            $('.errorlink').html(response.error.link);
                        } else {
                            $('#link').removeClass('is-invalid');
                            $('.errorlink').html('');
                        }

                        if (response.error.gambar) {
                            $('#gambar').addClass('is-invalid');
                            $('.errorgambar').html(response.error.gambar);
                        } else {
                            $('#gambar').removeClass('is-invalid');
                            $('.errorgambar').html('');
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
                        listsection();
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