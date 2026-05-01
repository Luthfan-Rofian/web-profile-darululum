<div class="modal fade" id="modaledit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Pesan dari <?= $nama  ?>

                </h6>
            </div>
            <?= form_open_multipart('', ['class' => 'formkritiksaran']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" value="<?= $kritiksaran_id ?>" name="kritiksaran_id">
                <input type="hidden" value="<?= $status ?>" name="status">


                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Topik
                        </label>
                        <!-- <input type="text" id="nama_survey" name="nama_survey" value="<?= $nama_survey ?>" class="form-control" readonly> -->
                        <textarea type="text" class="form-control bg-light" id="nama_survey" name="nama_survey" readonly><?= $nama_survey ?></textarea>

                    </div>

                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-message-processing"></i>
                        Isi Kritik / Saran
                    </label>
                    <textarea type="text" class="form-control bg-light" id="pesan" name="pesan" readonly><?= $pesan ?></textarea>

                </div>


                <div class="modal-footer p-0">

                    <div class="float-right">
                        <button class="btn btn-primary btnupload"><i class="fas fa-paper-plane"></i> Kirim Balasan</button>
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>

                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>


    <script>
        function viewkritik2(kritiksaran_id) {
            $.ajax({
                type: "post",
                url: "<?= site_url('kritiksaran/formedit') ?>",
                data: {
                    kritiksaran_id: kritiksaran_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        $('.viewmodal').html(response.sukses).show();
                        $('#modaledit').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#modaledit').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {

                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    });
                }
            });
        }
    </script>