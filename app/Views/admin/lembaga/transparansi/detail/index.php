<?= $this->section('content') ?>
<?= $this->extend('admin/script') ?>
<div id="formsub">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box ">

            </div>
        </div>
    </div>

    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">

                    <div class="card-header font-18 bg-light">
                        <h6 class="modal-title mt-0">
                            <i class="fas fa-align-center"></i> DETAIL
                            <input type="hidden" name="transparan_id" value="<?= $transparan_id ?>" id="transparan_id" name="transparan_id">
                            <!-- <div class="float-right">
                                <button type="button" class="btn btn-block btn-primary btn-sm tambah"><i class="fas fa fa-plus-circle"></i> TAMBAH DATA</button>
                            </div> -->
                            <?php
                            if ($list) {
                                foreach ($list as $data) :
                                endforeach;

                                if ($data['jenis'] == '0') { ?>
                                    <a class="text-primary"> <b><?= $data['judul'] ?></b></a>
                                <?php } else { ?>
                                    <a class="text-danger"> <b><?= $data['judul'] ?></b></a>
                            <?php }
                            } ?>

                        </h6>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="viewdata"></div>
                    </div>
                    <div class="viewmodal"></div>
                    <!-- /.card-body -->
                </div>

            </div>

        </div>

    </div>
</div>

<script>
    function listdetailtransparansi() {

        transparansi = $("#transparan_id").val();

        $.ajax({

            url: "<?= site_url('transparansi/detailajx') ?>",
            data: {
                transparansi: transparansi,
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
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

    $(document).ready(function() {
        listdetailtransparansi();

    });
</script>
<?= $this->endSection() ?>