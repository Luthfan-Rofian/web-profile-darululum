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
                            <i class="fas fa-question"></i> Pertanyaan
                            <input type="hidden" value="<?= $survey_id ?>" id="survey_id" name="survey_id">

                            <?php
                            if ($list) {
                                foreach ($list as $data) :
                                endforeach
                            ?>
                                <a class="text-danger"><?= $data['nama_survey'] ?></a>
                            <?php } ?>

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
    function listpertanyaan() {

        survey_id = $("#survey_id").val();

        $.ajax({

            url: "<?= site_url('survey/getpertanyaan') ?>",
            data: {
                survey_id: survey_id,
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
        listpertanyaan();

    });
</script>
<?= $this->endSection() ?>