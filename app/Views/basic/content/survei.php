<?php
$db = \Config\Database::connect();
?>

<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>


<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">

    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">

                                    <div class="title-konten text-uppercase">Lembar Quisioner</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->

                                        <?php if ($surveytopik) { ?>

                                            <?php foreach ($surveytopik as $data) {
                                                $survey_id = $data['survey_id'];
                                            ?>
                                                <div class="alert alert-primary" style='background-color:#f4f4f4; border-color:#e3e3e3;font-size:20px;'>
                                                    <?= $data['nama_survey'] ?>
                                                </div>
                                            <?php } ?>
                                             Mohon kesediaan Anda untuk memberikan penilaian dan masukan kepada kami, dimana hal ini sangat bermanfaat untuk meningkatkan kualitas layanan kami.

                                            <tr>
                                                <td width="98%" valign="top" align="center" colspan="5" style="border-style: none; border-width: medium">
                                                    <font face="Arial" size="1"><b>Mohon kesediaan Anda untuk memberikan
                                                            penilaian dan masukan kepada Kami, dimana hal ini sangat bermanfaat
                                                            untuk meningkatkan kualitas layanan kami.<br>
                                                        </b><i>Sebelum melanjutkan, Mohon mengisi Nama dan No HP Anda pada form yang telah disediakan dibawah.</i></font>
                                                </td>
                                            </tr>
                                            <hr>
                                            <?= form_open('survey/isisurvei', ['class' => 'formsurvey']) ?>
                                            <?= csrf_field();
                                            ?>

                                            <div class="text-left mt-2 ">
                                                <div class="row">
                                                    <div class="form-group col-md-6 col-12">
                                                        <label class="mt-2">Nama</label>
                                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlentities(set_value('nama'), ENT_QUOTES) ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-6 col-12">
                                                        <label class="mt-2 ">No HP</label>

                                                        <input type="text" class="form-control" id="nohp" name="nohp" value="<?= htmlentities(set_value('nohp'), ENT_QUOTES) ?>" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                    </div>

                                    <div class="text-left ">

                                        <?php
                                            $set = $db->table('survey_pertanyaan')->where('survey_id', $survey_id)->orderBy('pertanyaan_id', 'ASC')->get()->getResultArray();
                                            $no = 0;
                                            if ($set) {
                                                foreach ($set as $datatanya) {
                                                    $no++;
                                        ?>

                                                <b><?= $no ?>. <?= $datatanya['pertanyaan'] ?></b>
                                                <hr>

                                                <?= csrf_field();
                                                    $set2 = $db->table('survey_jawaban')->where('pertanyaan_id', $datatanya['pertanyaan_id'])->orderBy('pertanyaan_id', 'ASC')->get()->getResultArray();
                                                    $nos = 0;
                                                    $i = 1;
                                                    foreach ($set2 as $datajwb) {
                                                        $nos++;
                                                ?>

                                                    <label>
                                                        <!-- <input name="jawaban_id[<?= $no ?>]" class="centang_id" type="radio" value="<?= $datajwb['jawaban_id'] ?>"> -->
                                                        <input name="jawaban_id[<?= $no ?>]" class="centang_id" required type="radio" value="<?= $datajwb['nilai'] ?>">
                                                        <input type="hidden" id="nilai" name="nilai" value="<?= $datajwb['nilai'] ?>" class="form-control">

                                                        <a class="pointer"><?= $datajwb['jawaban'] ?> </a>

                                                    </label><br>

                                                <?php } ?>
                                                <br>

                                            <?php } ?>

                                            <div class="text-left ">
                                                <label> <b class="text-primary">Saran dan masukan yang Membangun</b></label>
                                                <input type="hidden" id="survey_id" name="survey_id" value="<?= $survey_id ?>" class="form-control">
                                                <textarea type="text" id="saran" name="saran" class="form-control"><?= htmlentities(set_value('saran'), ENT_QUOTES) ?></textarea>
                                            </div>

                                            <hr>
                                            <center>
                                                <input style='width: 120px; padding:2px; font-size:14px;' type=submit class='btn btn-primary btnsimpan' value='KIRIM DATA' />
                                                </form>

                                            </center>
                                        <?php } else { ?>
                                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                <a style='color:red'>Belum Ada pertanyaan untuk topik ini.!</a>
                                            </div>
                                        <?php } ?>
                                    </div>

                                <?php } else { ?>
                                    <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                        <a style='color:red'>Belum Ada data Survey.!</a><br> Punya pertanyaan, keluhan, masukan atau saran, silahkan klik <b class="tambahkritik pointer">disini</b>, untuk sampaikan.
                                    </div>
                                <?php } ?>


                                <!-- end konten -->


                                </div>
                                <div class="col-md-4">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terpopuler</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php $nomor = 0;
                                            foreach ($beritapopuler as $data) :
                                                $nomor++; ?>

                                                <div class="card border-light mb-3">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-3 col-4 wraper-img-side">
                                                            <img class="wraper-img-side" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                        </div>

                                                        <div class="col-md-9 col-8 pl-3">
                                                            <a class="judul-side" href="<?php echo base_url('detail/' . $data['slug_berita']) ?>">
                                                                <div><?= $data['judul_berita'] ?></div>
                                                            </a>
                                                            <div class="post-side pt-2">
                                                                <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                                <i class="fa fa-eye"></i> <?= $data['hits'] ?> Kali
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach; ?>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {


        $('.formsurvey').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centang_id:checked');

            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {

                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
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

                            Swal.fire({
                                title: "Maaf..!",
                                html: `Silahkan pilih salah satu jawaban diatas. `,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3550

                            });

                            if (response.error.jawaban_id) {
                                $('#jawaban_id').addClass('is-invalid');
                                $('.errorjawaban_id').html(response.error.jawaban_id);
                            } else {
                                $('#jawaban_id').removeClass('is-invalid');
                                $('.errorjawaban_id').html('');
                            }

                        }
                        if (response.gagal) {

                            Swal.fire({
                                title: "Maaf..!",
                                text: response.gagal,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3550
                            });

                        }
                        if (response.sukses) {

                            Swal.fire({
                                title: "Sukses!",
                                text: response.sukses,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 4550
                            }).then(function() {

                                window.location = '<?= base_url('') ?>';
                            });
                        }

                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        toastr["error"]("Maaf gagal hapus Kode Error:  " + (xhr.status + "\n"), )

                    }
                });

            }
        });

    });
</script>

<?= $this->endSection() ?>