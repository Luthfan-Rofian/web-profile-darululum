<!-- ============================= WEBSITE LEMBAGA ============================= -->
<?php
$db = \Config\Database::connect();
?>

<?php

use App\Models\Modelkonfigurasi;

$this->konfigurasi = new Modelkonfigurasi();
$konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Cetak Quisioner</title>

    <meta content="CMS LEMBAGA" name="Aplikasi Pendidikan Net" />

    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi['icon']) ?>">
    <link href="<?= base_url() ?>/public/temp-backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/temp-backend/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/temp-backend/assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>

    <br>

    <div class="col-12 ml-auto">
        <div class="card ">
            <div class="card-block mb-1">

                <div class="content text-center p-2">
                    <h4 class="text-dark"><?= $konfigurasi['nama'] ?></h4>
                    <div class="gen-section">
                        <div class="gen-content">
                            <?php if ($nama_survey) { ?>

                                <div class="alert alert-danger" style='background-color:#f4f4f4; border-color:#e3e3e3;font-size:18px;'>
                                    <?= $nama_survey ?>
                                </div>
                        </div>

                        <div class="text-left ml-3">

                            <?php
                                $set = $db->table('survey_pertanyaan')->where('survey_id', $survey_id)->orderBy('pertanyaan_id', 'ASC')->get()->getResultArray();
                                if ($set) {
                                    $no = 0;
                                    foreach ($set as $datatanya) {
                                        $no++;
                            ?>

                                    <b><?= $no ?>. <?= $datatanya['pertanyaan'] ?></b>
                                    <hr>

                                    <?= form_open('survey/isisurvei', ['class' => 'formsurvey']) ?>
                                    <?= csrf_field();
                                        $set2 = $db->table('survey_jawaban')->where('pertanyaan_id', $datatanya['pertanyaan_id'])->orderBy('pertanyaan_id', 'ASC')->get()->getResultArray();
                                        $nos = 0;
                                        $i = 1;
                                        foreach ($set2 as $datajwb) {
                                            $nos++;
                                    ?>

                                        <label>
                                            <input name="jawaban_id[<?= $no ?>]" class="centang_id" type="radio" value="<?= $datajwb['jawaban_id'] ?>">

                                            <span class="pointer"><?= $datajwb['jawaban'] ?></span>

                                        </label><br>

                                    <?php }
                                    ?>
                                    <br>

                                <?php } ?>

                                <div class="text-left ">
                                    <label> <b class="text-primary">Saran dan Kritik yang Membangun</b></label>
                                    <input type="hidden" id="survey_id" name="survey_id" value="<?= $survey_id ?>" class="form-control">
                                    <textarea type="text" id="saran" name="saran" class="form-control"></textarea>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                    <a style='color:red'>Belum Ada pertanyaan untuk topik ini.!</a>
                                </div>
                            <?php } ?>
                            <br>

                        </div>

                    <?php } else { ?>

                        <h4 class="">Maaf, Belum Ada data Survey.!</h4><br>
                        <a class="btn btn-info mb-5 waves-effect waves-light" href="<?= base_url('/') ?>"><i class="mdi mdi-home"></i> Kembali ke Halaman Utama</a> -->


                    <?php } ?>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>

<script>
    window.print();
</script>