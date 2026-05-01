<div class="modal fade" id="modaledit">

    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>


            <?= form_open_multipart('', ['class' => 'formfoto']) ?>
            <?= csrf_field(); ?>

            <div class="modal-body">

                <input type="hidden" value="<?= $id_banner ?>" name="id_banner">
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Keterangan
                    </label>
                    <input type="text" id="ket" name="ket" value="<?= $ket ?>" class="form-control form-control-sm">

                </div>
                <div class="form-group">
                    <label> <i class="mdi mdi-link-variant"></i>
                        Link Sebelumnya
                    </label>
                    <input type="text" id="linkold" name="linkold" readonly value="<?= $link ?>" class="form-control form-control-sm">

                </div>

                <!-- Single menu start -->
                <div id="single">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label><i class="mdi mdi-clipboard-check-outline"></i> Posisi Iklan</label>
                            <select class="form-control form-control-sm" name="posisi" id="posisi">
                                <option Disabled=true Selected=true>-- Pilih Posisi--</option>

                                <option value="1" <?= $posisi ==  '1' ? 'selected' : '' ?>>Beranda Tengah</option>
                                <option value="2" <?= $posisi ==  '2' ? 'selected' : '' ?>>Beranda Kiri</option>
                                <option value="3" <?= $posisi ==  '3' ? 'selected' : '' ?>>Atas</option>

                            </select>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label><i class="mdi mdi-clipboard-check-outline"></i> Sumber Link</label> <small class="text-secondary">(Pilih jika Link diganti)</small>
                            <select class="form-control form-control-sm" name="sumberlink" id="sumberlink">

                                <option Disabled=true Selected=true>-- Pilih Sumber Link--</option>
                                <option value="1">Kategori Berita</option>
                                <option value="2">Halaman</option>
                                <option value="3">Modul CMS</option>
                                <option value="4">Eksternal</option>
                            </select>
                        </div>
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
                        <input type="text" id="link" name="link" value="<?= $link ?>" class="form-control form-control-sm">
                        <div class="invalid-feedback errorlink"></div>
                    </div>
                </div>
                <!-- end single -->

            </div>

            <div class="modal-footer">

                <button type="submit" class="btn btn-primary btnupload"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
            </div>
        </div>
        <?php echo form_close() ?>

    </div>

</div>

</div>


<script>
    $(document).ready(function() {

        $("#eksternal").hide();
        $("#berita").hide();
        $("#halaman").hide();
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
            let form = $('.formfoto')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('iklan/updatebanner') ?>',
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

                        if (response.error.ket) {
                            $('#ket').addClass('is-invalid');
                            $('.errorket').html(response.error.ket);
                        } else {
                            $('#ket').removeClass('is-invalid');
                            $('.errorket').html('');
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
                        listiklan();
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