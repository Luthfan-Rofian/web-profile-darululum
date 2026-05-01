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
                                    <div class="title-konten text-uppercase">Masukan dan Saran</div>

                                    <div class="blog-comments mt-1">
                                        <!-- Single Comment -->
                                        <?php if ($suaraanda) { ?>

                                            <div id="comment-1" class="comment">

                                                <div class="item">
                                                    <?php $nomor = 0;
                                                    foreach ($suaraanda as $data) {
                                                        $nomor++;
                                                        if ($data['tanggal'] != '') {
                                                            $tglbls = $data['tanggal'];
                                                        } else {
                                                            $tglbls = date('Y-m-d');
                                                        }
                                                    ?>
                                                        <div class="alert alert-info" style='background-color:#f8f9f4; border-color:#e3e3e3;'>
                                                            <div class="comment-img">
                                                                <img class="img-circle comment-img float-left" src="<?= base_url('public/template/temp-backend/assets/images/usr2.png') ?>" width="50" alt="Nama">
                                                            </div>
                                                            <div>
                                                                <div class="author"><?= esc($data['nama']) ?></div>

                                                                <div class="date text-danger"><?= esc($data['judul'])  ?> - <?= date_indo($data['tanggal']) ?></div>
                                                                <p><?= esc($data['isi_kritik']) ?></p>
                                                            </div>
                                                            <div class="comment-img">
                                                                <img class="comment-img float-left" src="<?= base_url('public/template/temp-backend/assets/images/adm.png') ?>" width="100" alt="Admin">
                                                            </div>
                                                            <!-- <div> -->
                                                            <div class="author text-primary">Admin</div>
                                                            <div class="date text-warning">Ditanggapi - <?= date_indo($tglbls) ?></div>
                                                            <p><i><?= ($data['balas']) ?></i> </p>
                                                        </div>

                                                    <?php } ?>

                                                </div>

                                            </div>
                                            <?php if ($jum > 4) { ?>
                                                <P>
                                                <ul class="pagination justify-content-center">
                                                    <?= $pager->links('hal', 'datagoe'); ?>
                                                </ul>
                                                </P>
                                            <?php } ?>

                                        <?php } else { ?>
                                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                <a style='color:red'>Belum Ada data masukan saran.!</a><br> Punya pertanyaan, keluhan, masukan atau saran, silahkan <b>isi form dibawah</b>, untuk sampaikan.
                                            </div>
                                        <?php } ?>

                                        <!-- <div class="reply-form"> -->
                                        <div class="hlm-title">
                                            <span class="hlm-title-blueborder">
                                                <span>Berikan</span>
                                                <span class="strong">Masukan / Saran</span>
                                            </span>
                                        </div>


                                        <div class="alert alert-info" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                            <img style='float:left; padding: 8px; margin-top:-13px; margin-right:5px;' width="95" class="pull-left" src="<?= base_url('public/template/temp-backend/assets/images/icon_rules.png') ?>">
                                            Seluruh pesan yang masuk akan kami moderasi terlebih dahulu sebelum ditampilkan.
                                            Pesan yang mengandung unsur <a target='_BLANK' style='color:red'>sara, hoax, pornografi, spam, ujaran kebencian,
                                                atau link tidak bermanfaat</a> akan kami hapus.
                                        </div>
                                        <?= form_open('kritiksaran/simpankritik', ['class' => 'formkritik']) ?>
                                        <?= csrf_field() ?>
                                        <!-- <div class="alert alert-light"> -->
                                        <div class="row">
                                            <div class="form-group col-md-3 col-12">
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlentities(set_value('nama'), ENT_QUOTES) ?>" placeholder="Nama Lengkap*" required>
                                                <div class="invalid-feedback errornama"></div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <input type="text" class="form-control" id="no_hpusr" name="no_hpusr" maxlength="20" value="<?= htmlentities(set_value('no_hpusr'), ENT_QUOTES) ?>" placeholder="Nomor Handphone (WA)*" required>
                                                <div class="invalid-feedback errorno_hpusr"></div>
                                            </div>

                                            <div class="form-group col-md-3 col-12">
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlentities(set_value('email'), ENT_QUOTES) ?>" placeholder="Alamat Email*" required>
                                                <div class="invalid-feedback erroremail"></div>
                                            </div>
                                            <div class="form-group col-md-3 col-12">
                                                <select class="form-control" name="judul" id="judul">
                                                    <option Disabled=true Selected=true>-- Pilih Topik --</option>
                                                    <option value="Pengaduan">Pengaduan</option>
                                                    <option value="Aspirasi">Aspirasi</option>
                                                    <option value="Permintaan Informasi">Permintaan Informasi</option>
                                                </select>

                                                <div class="invalid-feedback errorjudul"></div>
                                            </div>

                                            <div class="col-md-12 ">
                                                <textarea rows="3" type="text" id="isi_kritik" name="isi_kritik" class="form-control" placeholder="Tulis pertanyaan, keluhan, masukan atau saran anda disini*" required=""><?= htmlentities(set_value('isi_kritik'), ENT_QUOTES) ?></textarea>
                                                <div class="invalid-feedback errorisi_kritik"></div>
                                            </div>

                                            <div class="col-md-4 pt-3 mr-20" style="margin-right: 20px;">
                                                <div class="form-group">
                                                    <!-- <label>Captcha Code</label><br> -->
                                                    <div class="g-recaptcha" data-sitekey="<?= $sitekey ?>"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 pt-lg-5">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btnkritik"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <?= form_close() ?>

                                    </div><!-- End  -->

                                </div>
                                <div class="col-md-4">

                                    <aside class="sidebar">
                                        <div class="widget list-news">
                                            <!-- BERITA  -->
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
                                                                    <a class="judul-side" href="<?php echo base_url('berita/detail/' . $data['slug_berita']) ?>">
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

                                            <!-- KATEGORI  -->

                                            <?php if ($kategori) { ?>
                                                <div class="row pb-3">
                                                    <div class="col-md-12">
                                                        <div class="caption">Kategori</div>
                                                    </div>
                                                </div>
                                                <!-- <div class="widget-header">
                                                    <h4 class="widget-title">Kategori</h4>
                                                </div> -->
                                                <div class="widget-body">

                                                    <?php foreach ($kategori as $data) : ?>
                                                        <div class="post-content">
                                                            <div class="list-group m-1">
                                                                <div class="list-group-item list-group-item-action">
                                                                    <div class="row no-gutters">
                                                                        <div class="media-body">
                                                                            <i class="fa fa-folder ml-0 text-warning"></i> <a href="<?= base_url('category/' . $data['slug_kategori']) ?>" class="newsrow__title"><?= $data['nama_kategori'] ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            <?php } else { ?>
                                                <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                    <a style='color:red'>Belum ada data Kategori..!</a>
                                                </div>
                                            <?php } ?>
                                        </div>


                                    </aside>


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

        $('.formkritik').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnkritik').prop('disable', true);
                    $('.btnkritik').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

                },
                complete: function() {
                    $('.btnkritik').prop('disable', false);
                    $('.btnkritik').html('Kirim Pesan')
                    $('.btnkritik').html('<i class="fas fa-paper-plane"></i>  Kirim Pesan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html();
                            $('#nama').addClass('is-valid');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html();
                            $('#email').addClass('is-valid');
                        }

                        if (response.error.no_hpusr) {
                            $('#no_hpusr').addClass('is-invalid');
                            $('.errorno_hpusr').html(response.error.no_hpusr);
                        } else {
                            $('#no_hpusr').removeClass('is-invalid');
                            $('.errorno_hpusr').html();
                            $('#no_hpusr').addClass('is-valid');
                        }

                        if (response.error.judul) {
                            $('#judul').addClass('is-invalid');
                            $('.errorjudul').html(response.error.judul);
                        } else {
                            $('#judul').removeClass('is-invalid');
                            $('.errorjudul').html();
                            $('#judul').addClass('is-valid');
                        }

                        if (response.error.isi_kritik) {
                            $('#isi_kritik').addClass('is-invalid');
                            $('.errorisi_kritik').html(response.error.isi_kritik);
                        } else {
                            $('#isi_kritik').removeClass('is-invalid');
                            $('.errorisi_kritik').html();
                            $('#isi_kritik').addClass('is-valid');
                        }

                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: "Terima Kasih!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 4550
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                        });
                    }
                    if (response.gagal) {
                        Swal.fire({
                            title: "Maaf...!",
                            text: response.gagal,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 4550
                        }).then(function() {
                            // window.location = '<?= base_url('') ?>';
                            window.location = '';
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal mengirim data!",
                        html: `Silahkan coba kembali Error Code: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
            return false;
        });
    });
</script>
<?= $this->endSection() ?>