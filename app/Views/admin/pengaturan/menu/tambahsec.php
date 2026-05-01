<div class="modal fade" id="modaltambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Tambah Menu Secondary
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open('menu/simpanmenusec', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama Menu</label>
                        <input type="text" id="nama_menu" name="nama_menu" class="form-control form-control-sm">
                        <div class="invalid-feedback errornama_menu"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Posisi Menu</label>

                        <div class="form-control form-control-sm">
                            <input type="radio" id="posisi1" name="posisi" value="1" checked><label for="posisi1" class="pointer">&nbsp Top Menu &nbsp</label>
                            <input type="radio" id="posisi2" name="posisi" value="2"><label for="posisi2" class="pointer">&nbsp Footer Menu &nbsp</label>
                        </div>
                    </div>
                </div>
                <!-- Single menu start -->
                <div id="single">
                    <div class="form-group">
                        <label>Sumber Link</label>
                        <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">

                            <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                            <option value="1" data-linkexternal="N">Kategori Berita</option>
                            <option value="2" data-linkexternal="N">Halaman</option>
                            <option value="3" data-linkexternal="N">Modul CMS</option>
                            <option value="4" data-linkexternal="Y">Eksternal</option>
                        </select>
                        <div class="invalid-feedback errormenu_link"></div>
                    </div>

                    <div class="form-group" id="berita">
                        <label>Pilih Kategori Berita</label>
                        <select name="dberita" id="dberita" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Kategori Berita--</option>
                            <?php foreach ($kategoriberita as $key => $data) { ?>
                                <option data-menu_link="category/<?= esc($data['slug_kategori']) ?>"><?= $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="halaman">
                        <label>Pilih Halaman</label>
                        <select name="dhalaman" id="dhalaman" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Halaman--</option>
                            <?php foreach ($halaman as $key => $data) { ?>
                                <option data-menu_link="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="modul">
                        <label>Pilih Modul CMS</label>
                        <select class="form-control form-control-sm" name="modulcms" id="modulcms">
                            <option Disabled=true Selected=true>-- Pilih Modul CMS--</option>
                            <?php foreach ($modulpublic as $key => $data) { ?>
                                <option data-menu_link="<?= esc($data['link']) ?>"><?= $data['modpublic'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errormenu_link"></div>
                    </div>

                    <div class="form-group" id="eksternal">
                        <label>
                            Link URL <small class="text-danger">(Misalnya: http://aplikasipendidikan.net/)</small>
                        </label>
                        <input type="text" id="menu_link" name="menu_link" class="form-control form-control-sm">
                        <div class="invalid-feedback errorgm"></div>
                    </div>
                </div>
                <!-- end single -->

                <input type="hidden" id="linkexternal" name="linkexternal" class="form-control form-control-sm">

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Urutan Menu</label>
                        <input type="number" class="form-control form-control-sm" id="urutan" name="urutan">
                        <div class="invalid-feedback errorurutan"></div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Target</label>
                        <div class="form-control form-control-sm">
                            <input type="radio" id="target1" name="target" value="_parent" checked><label for="target1" class="pointer">&nbsp_parent &nbsp</label>
                            <input type="radio" id="target2" name="target" value="_blank"><label for="target2" class="pointer">&nbsp_blank &nbsp</label>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Icon</label>
                        <input type="text" class="form-control form-control-sm" id="icon" name="icon">
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label>Lihat Icon</label>
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm mr-1" data-toggle="modal" data-target=".fontawesome">Font Awesome</button>
                            <button type="button" class="btn btn-outline-secondary waves-effect waves-light btn-sm" data-toggle="modal" data-target=".mdideril">Material Design</button>
                        </div>
                    </div>
                </div>
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

        // $("#single").hide();
        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
        $("#modul").hide();
        $('[name=menu_link]').val('#');
        $('[name=linkexternal]').val('N');


        // Pilihan Sumber Link 
        $('#sumberlink').on('change', function() {
            const linkexternal = $('#sumberlink option:selected').data('linkexternal');
            $('[name=linkexternal]').val(linkexternal);
        });

        // Pilihan Modul CMS
        $('#modulcms').on('change', function() {

            const menu_link = $('#modulcms option:selected').data('menu_link');
            $('[name=menu_link]').val(menu_link);
        });
        // Pilihan Kategori Berita
        $('#dberita').on('change', function() {

            const menu_link = $('#dberita option:selected').data('menu_link');
            $('[name=menu_link]').val(menu_link);
        });

        // Pilihan Halaman
        $('#dhalaman').on('change', function() {

            const menu_link = $('#dhalaman option:selected').data('menu_link');
            $('[name=menu_link]').val(menu_link);
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
                $('[name=menu_link]').val('');
            } else if ($('#sumberlink').val() == '2') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").show();
                $("#modul").hide();
                $('[name=menu_link]').val('');
            } else if ($('#sumberlink').val() == '3') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").show();
                $('[name=menu_link]').val('');
            } else {
                $("#eksternal").show();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=menu_link]').val('');
            }
        });

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formtambah')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('menu/simpanmenusec') ?>',
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

                        if (response.error.nama_menu) {
                            $('#nama_menu').addClass('is-invalid');
                            $('.errornama_menu').html(response.error.nama_menu);
                        } else {
                            $('#nama_menu').removeClass('is-invalid');
                            $('.errornama_menu').html('');
                        }


                        if (response.error.menu_link) {
                            $('#menu_link').addClass('is-invalid');
                            $('.errormenu_link').html(response.error.menu_link);
                        } else {
                            $('#menu_link').removeClass('is-invalid');
                            $('.errormenu_link').html('');
                        }

                        if (response.error.urutan) {
                            $('#urutan').addClass('is-invalid');
                            $('.errorurutan').html(response.error.urutan);
                        } else {
                            $('#urutan').removeClass('is-invalid');
                            $('.errorurutan').html('');
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
                        listmenu();
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