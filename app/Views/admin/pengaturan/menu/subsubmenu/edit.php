<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Edit Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <?= form_open('menu/updatesubsubmenu', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="subsubmenu_id" value="<?= $subsubmenu_id ?>" name="subsubmenu_id" readonly>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Nama Menu</label>
                        <input type="text" id="nama_subsubmenu" name="nama_subsubmenu" value="<?= $nama_subsubmenu ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errornama_subsubmenu"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Sumber Link</label> <small class="text-warning">(Pilih jika Link mau diganti)</small>
                        <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">
                            <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                            <option value="1" data-linkexternalssm="N">Kategori Berita</option>
                            <option value="2" data-linkexternalssm="N">Halaman</option>
                            <option value="3" data-linkexternalssm="N">Modul CMS</option>
                            <option value="4" data-linkexternalssm="Y">Eksternal</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="form-group" id="berita">
                        <label>Pilih Kategori Berita</label>
                        <select name="dberita" id="dberita" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Kategori Berita--</option>
                            <?php foreach ($kategoriberita as $key => $data) { ?>
                                <option data-link_subsubmenu="category/<?= esc($data['slug_kategori']) ?>"><?= $data['nama_kategori'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="halaman">
                        <label>Pilih Halaman</label>
                        <select name="dhalaman" id="dhalaman" class="form-control form-control-sm">
                            <option Disabled=true Selected=true>--Pilih Halaman--</option>
                            <?php foreach ($halaman as $key => $data) { ?>
                                <option data-link_subsubmenu="page/<?= esc($data['slug_berita']) ?>"><?= $data['judul_berita'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorKategori"></div>
                    </div>

                    <div class="form-group" id="modul">
                        <label>Pilih Modul CMS</label>
                        <select class="form-control form-control-sm" name="modulcms" id="modulcms">
                            <option Disabled=true Selected=true>-- Pilih Modul CMS--</option>
                            <?php foreach ($modulpublic as $key => $data) { ?>
                                <option data-link_subsubmenu="<?= esc($data['link']) ?>"><?= $data['modpublic'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errormenu_link"></div>
                    </div>

                    <div class="form-group" id="eksternal">
                        <label>
                            Link URL <small class="text-danger">(Misalnya: http://aplikasipendidikan.net/)</small>
                        </label>
                        <input type="text" id="link_subsubmenu" name="link_subsubmenu" value="<?= $link_subsubmenu ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorlink_subsubmenu"></div>
                    </div>
                    <input type="hidden" id="linkexternalssm" name="linkexternalssm" value="<?= $linkexternalssm ?>" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label>Link Sebelumnya</label>
                    <input type="text" id="link_subsubmenuold" name="link_subsubmenuold" readonly value="<?= $link_subsubmenu ?>" class="form-control form-control-sm">

                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Urutan Sub Menu</label>
                        <input type="number" class="form-control form-control-sm" id="urutanssm" name="urutanssm" value="<?= $urutanssm ?>">
                        <div class="invalid-feedback errorurutanssm"></div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label>Target</label>
                        <div class="form-control form-control-sm">
                            <input type="radio" name="targetssm" id="targetssm1" value="_parent" <?= $targetssm == '_parent' ? 'checked' : '' ?>> <label for="targetssm1" class="pointer"> _parent &nbsp</label>
                            <input type="radio" name="targetssm" id="targetssm2" value="_blank" <?= $targetssm == '_blank' ? 'checked' : '' ?>> <label for="targetssm2" class="pointer"> _blank &nbsp</label>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label>Icon Sub Menu</label>
                        <input type="text" class="form-control form-control-sm" id="iconssm" name="iconssm" value="<?= $iconssm ?>">
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
                <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
        $("#modul").hide();


        // Pilihan Sumber Link 
        $('#sumberlink').on('change', function() {
            const linkexternalssm = $('#sumberlink option:selected').data('linkexternalssm');
            $('[name=linkexternalssm]').val(linkexternalssm);
        });

        // Pilihan Modul CMS
        $('#modulcms').on('change', function() {

            const link_subsubmenu = $('#modulcms option:selected').data('link_subsubmenu');
            $('[name=link_subsubmenu]').val(link_subsubmenu);
        });
        // Pilihan Kategori Berita
        $('#dberita').on('change', function() {

            const link_subsubmenu = $('#dberita option:selected').data('link_subsubmenu');
            $('[name=link_subsubmenu]').val(link_subsubmenu);
        });

        // Pilihan Halaman
        $('#dhalaman').on('change', function() {
            const link_subsubmenu = $('#dhalaman option:selected').data('link_subsubmenu');
            $('[name=link_subsubmenu]').val(link_subsubmenu);
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
                $('[name=link_subsubmenu]').val('');
            } else if ($('#sumberlink').val() == '2') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").show();
                $("#modul").hide();
                $('[name=link_subsubmenu]').val('');
            } else if ($('#sumberlink').val() == '3') {
                $("#eksternal").hide();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").show();
                $('[name=link_subsubmenu]').val('');
            } else {
                $("#eksternal").show();
                $("#berita").hide();
                $("#halaman").hide();
                $("#modul").hide();
                $('[name=link_subsubmenu]').val('');
            }
        });


        $('.btnupdate').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('menu/updatesubsubmenu') ?>',
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

                        if (response.error.nama_subsubmenu) {
                            $('#nama_subsubmenu').addClass('is-invalid');
                            $('.errornama_subsubmenu').html(response.error.nama_subsubmenu);
                        } else {
                            $('#nama_subsubmenu').removeClass('is-invalid');
                            $('.errornama_subsubmenu').html('');
                        }


                        if (response.error.link_subsubmenu) {
                            $('#link_subsubmenu').addClass('is-invalid');
                            $('.errorlink_subsubmenu').html(response.error.link_subsubmenu);
                        } else {
                            $('#link_subsubmenu').removeClass('is-invalid');
                            $('.errorlink_subsubmenu').html('');
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
                        $('#modaledit').modal('hide');
                        listsubsubmenu();
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