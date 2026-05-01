        <?= form_open_multipart('', ['class' => 'formtambahx']) ?>
        <?= csrf_field(); ?>
        <table class="table table-hover table-striped tambahform">
            <thead>
                <tr>
                    <!-- <th width="0"></th> -->
                    <!-- <th>Judul </th> -->

                    <th>Keterangan *</th>
                    <th>Gambar *</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- <td id="idhide"> -->
                    <input type="hidden" name="foto_id[]" class="centangid" checked>
                    <!-- </td> -->
                    <input type="hidden" name="kategorifoto_id" value="<?= $kategorifoto_id ?>" class="form-control">
                    <!-- <td>
                        <input type="text" class="form-control" required id="judul" name="judul[]">
                        <div class="invalid-feedback errorjudul">
                    </td> -->

                    <td>
                        <textarea type="text" rows="1" name="judul[]" id="judul" class="form-control"></textarea>
                        <div class="invalid-feedback errorjudul"></div>
                    </td>
                    <td>
                        <input type="file" class="form-control" required id="gambar" name="gambar[]">
                        <div class="invalid-feedback errorgambar">
                    </td>

                    <td class="p-0">
                        <button type="button" class="btn btn-primary btn-sm tambahelemen"><i class="fas fa-plus-circle"></i></button>
                    </td>
                </tr>

            </tbody>

        </table>
        <div class="modal-footer">
            <td>
                <button type="button" class="btn btn-primary btnupload2"><i class="mdi mdi-content-save-all"></i> Simpan Data</button>

            </td>
        </div>
        <?= form_close() ?>

        <script>
            $(document).ready(function() {
                // $(idhide).hide();
                $('.btnupload2').click(function(e) {
                    e.preventDefault();

                    let jmldata = $('.centangid:checked');
                    let gambar = $('file#gambar').val()
                    let form = $('.formtambahx')[0];
                    let data = new FormData(form);
                    // data.append('gambar[]', file);
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
                            url: '<?= site_url('foto/simpanmulti') ?>',
                            data: data,
                            enctype: 'multipart/form-data',
                            processData: false,
                            contentType: false,
                            cache: false,
                            dataType: "json",

                            beforeSend: function() {
                                $('.btnupload2').attr('disable', 'disable');
                                $('.btnupload2').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                            },
                            complete: function() {
                                $('.btnupload2').removeAttr('disable', 'disable');
                                $('.btnupload2').html('<i class="mdi mdi-content-save-all"></i>  Simpan Data');
                            },
                            success: function(response) {
                                if (response.error) {
                                    if (response.error.judul) {
                                        toastr["error"](response.error.judul)
                                    }
                                    if (response.error.gambar) {
                                        toastr["error"](response.error.gambar)
                                    }

                                } else {
                                    toastr["success"](response.sukses)
                                    listfoto();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownerror) {
                                toastr["error"]("Maaf gagal simpan Kode Error:  " + (xhr.status + "\n"), );

                            }

                        });

                });
            });

            //back
            // $('.kembali').click(function(e) {

            //     e.preventDefault();
            //     $.ajax({
            //         url: "<?= site_url('foto/getdetailft') ?>",
            //         dataType: "json",
            //         success: function(response) {
            //             listfoto();
            //         }
            //     });
            // });

            //elemen add
            $('.tambahelemen').click(function(e) {
                e.preventDefault();
                $('.tambahform').append(`
               
                 <tr>
                    <input type="hidden" name="id_detlapak[]" class="centangid" checked>
                              
                    <td>
                        <textarea type="text" rows="1" name="judul[]" id="judul" class="form-control"></textarea>
                        <div class="invalid-feedback errorjudul"></div>
                    </td>
                    <td>
                        <input type="file" class="form-control" required id="gambar" name="gambar[]" >
                        <div class="invalid-feedback errorgambar">
                    </td>
                    <td class="p-0">
                        <button type="button" class="btn btn-danger btn-sm hapuselemen"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
        `);
            });

            $(document).on('click', '.hapuselemen', function(ex) {
                ex.preventDefault();
                $(this).parents('tr').remove();

            });
        </script>