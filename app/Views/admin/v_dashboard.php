<?= $this->section('content') ?>
<?= $this->extend('admin/script');

$db = \Config\Database::connect();
$userid = session()->get('id');
$list = $db->table('users')->where('id', $userid)->get()->getRowArray();

?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title text-light" style="text-shadow: 0 0 2px #000; ">Dashboard... <?= session()->get('fullname') ?> </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Login berhasil. Silakan lanjutkan aktivitas Anda...!</li>
            </ol>
            <div class="state-information d-none d-sm-block">

            </div>

        </div>
    </div>
</div>
<!-- end row -->

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('berita/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Berita</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Berita</h6>
                            <h3 class="mb-3 mt-0"><?= $berita ?></h3>
                            <div class="">
                                <span class="badge badge-light text-danger" style="font-size:13px"><?= $kategori ?> </span> <span class="ml-2">Kategori Berita</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('layanan/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Layanan</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Layanan</h6>
                            <h3 class="mb-3 mt-0"><?= $totlayanan ?></h3>
                            <div class="">
                                <span class="">Informasi Layanan</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('bankdata/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">BankData</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Bank Data</h6>
                            <?php if ($bankdata) {
                                $bankdata = $bankdata['bankdata_id'];
                            } else {
                                $bankdata = 0;
                            } ?>
                            <h3 class="mb-3 mt-0"><?= $bankdata ?></h3>
                            <div class="">
                                <span class="">Informasi Bank Data</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('pengumuman/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Infomasi</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Pengumuman</h6>
                            <h3 class="mb-3 mt-0"><?= $totpengumuman ?></h3>
                            <div class="">
                                <span class="">Informasi Pengumuman</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-bullhorn display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php

        if ($grupakses) { ?>
            <div class="col-12 d-none d-sm-block">
                <div class="card m-b-20">
                    <div class="card-header font-24 ">
                        <div class="btn-group float-center">
                            <a class="text-center" href="<?= base_url('konfigurasi') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-cogs font-24"></i><br>Konfigurasi</button>
                            </a>

                            <a class="text-center" href="<?= base_url('halaman') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-newspaper font-24 "></i><br>Halaman</button>
                            </a>
                            <a class="text-center" href="<?= base_url('menu') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-sitemap font-24 "></i><br>Menu</button>
                            </a>
                            <a class="text-center" href="<?= base_url('banner') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-window-restore font-24 "></i><br>Banner</button>
                            </a>

                            <a class="text-center" href="<?= base_url('sambutan') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-microphone-alt font-24 "></i><br>Sambutan</button>
                            </a>
                            <a class="text-center" href="<?= base_url('pegawai/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-id-card font-24 "></i><br>Data Pegawai</button>
                            </a>
                            <a class="text-center" href="<?= base_url('infografis/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fab fa-slideshare font-24 "></i><br>Info Grafis</button>
                            </a>
                            <a class="text-center" href="<?= base_url('linkterkait') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary  mr-1"><i class="fas fa-link font-24 "></i><br>Link Terkait</button>
                            </a>
                            <a class="text-center" href="<?= base_url('video/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fab fa-youtube font-24 "></i><br>Galeri Video</button>
                            </a>
                            <a class="text-center" href="<?= base_url('foto/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-images font-24 "></i><br>Galeri Foto</button>
                            </a>
                            <a class="text-center" href="<?= base_url('poling') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary"><i class="fas fa-chart-bar font-24 "></i><br>Data Poling</button>
                            </a>

                        </div>

                    </div>

                </div>
            </div> <!-- end col -->
        <?php } ?>


        <div class="container-fluid">
            <div class="row">


                <!-- AGENDA -->
                <?php
                if ($agenda) {
                    foreach ($agenda as $data) : ?>

                        <div class="col-xl-5 col-lg-5">
                            <div class="card directory-card m-b-20">
                                <div class="card-body directory-card-bg">
                                    <h4 class="mt-0 header-title"> &nbsp;</h4>
                                    <div class="clearfix">
                                        <div class="directory-img float-left mr-4">
                                            <?php if ($data['gambar'] == 'default.png') { ?>
                                                <img class="rounded-circle thumb-lg img-thumbnail" src="<?= base_url('public/img/informasi/agenda/agenda128.png') ?>" alt="agenda">
                                            <?php } else { ?>
                                                <img class="rounded-circle thumb-lg img-thumbnail" src="<?= base_url('public/img/informasi/agenda/' . $data['gambar']) ?>" alt="agenda">
                                            <?php } ?>
                                        </div>

                                        <h5 class="font-16 mt-0"> <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_mulai']) ?></h5>
                                        <p class="text-muted mb-2"><i class="far fa-clock"></i> <?= $data['jam'] ?></p>
                                        <a class="text-muted">
                                            <span class="text-muted"><i class="fas fa-map-marker-alt"></i> <?= $data['tempat'] ?></span>
                                        </a>
                                    </div>
                                    <div class="directory-content mt-4">
                                        <p class="text-warning mb-5 tooltips" data-toggle="tooltip" title="Penyelenggara / Pengirim Agenda "> <i class="fas fa-paper-plane"></i> <?= $data['pengirim'] ?>
                                        </p>
                                    </div>
                                    <a class="social-icons" href="<?= base_url('agenda/all') ?>">
                                        <ul class="social-links list-inline mb-0 p-2">
                                            <li class="list-inline-item tooltips" data-toggle="tooltip" title="<?= $data['tema'] ?>">
                                                <div class="text-light">Agenda Kegiatan</div>
                                            </li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                } else {
                    ?>
                    <div class="col-xl-5 col-lg-5">
                        <img class="" src="<?= base_url('public/img/informasi/agenda/blankagenda.jpg') ?>" alt="agenda">
                        <center>
                            <a class="text-center p-1" href="<?= base_url('agenda/all') ?>" title="Lihat Semua Agenda">
                                <span style="color:#f5f5f5;background:orange;padding:3px 5px;">Belum ada agenda kegiatan terdekat..!</span>
                            </a>
                        </center>
                    </div>
                <?php } ?>
                <!-- agenda end -->
                <div class="col-lg-7">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div class="viewtampilgrafik"></div>
                        </div>
                    </div>
                </div> <!-- end statistik -->
            </div>

<body>
    <!-- Responsive Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<!-- website -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="4179913036"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Fluid Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="fluid"
     data-ad-layout-key="-fn-4b+iq+4b-1n8"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="1510351813"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- In-Article Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="3747538890"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Auto Relaxed Ad Unit -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3334542440404059"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-3334542440404059"
     data-ad-slot="6573012789"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

    <!-- Additional Ad Container for CPM Rate -->
    <div id="container-782552c8aaf40cabfea318ea6a0232c3"></div>
</body>

<head>
    <!-- Additional Ad Container for CPM Rate -->
    <div id="container-782552c8aaf40cabfea318ea6a0232c3"></div>

<script async src="https://fundingchoicesmessages.google.com/i/pub-3334542440404059?ers=1"></script><script>(function() {function signalGooglefcPresent() {if (!window.frames['googlefcPresent']) {if (document.body) {const iframe = document.createElement('iframe'); iframe.style = 'width: 0; height: 0; border: none; z-index: -1000; left: -1000px; top: -1000px;'; iframe.style.display = 'none'; iframe.name = 'googlefcPresent'; document.body.appendChild(iframe);} else {setTimeout(signalGooglefcPresent, 0);}}}signalGooglefcPresent();})();</script>

</body>
<body>
    <head>
        <meta name="google-site-verification" content="n9kbMSa5rZD8grQJI0na5xwpAUYfBdx3m0ZxPpoVJUg" />
    </head>
</body>


        </div>
        <!-- BERITA POPULER -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">BERITA PALING POPULER</h4>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    <?php if ($beritapopuler) {

                                        foreach ($beritapopuler as $data) :  ?>
                                            <tr>
                                                <td class="text-center p-0"> <a href="<?= base_url('berita/detail/' . $data['slug_berita']) ?>" target="_blank"><img class="img-circle elevation-2" src="<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?>" width="50px"></td>

                                                <td>
                                                    <h8 class="mt-0"><a href="<?= base_url('berita/detail/' . $data['slug_berita']) ?>" target="_blank"><?= $data['judul_berita'] ?> <span class="badge badge-success" style="font-size:10px">(<?= $data['hits'] ?>)</span></h6>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="button-items mt-4">
                        <a href="<?= base_url('berita/all') ?>" class="btn btn-info btn-block waves-effect" style="font-size:14px"> <i class="fas fa-list-ul"></i> Lihat Semua Berita</a></ </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- start dge -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="viewonline"></div>
            </div>
        </div>
        <!-- END BERITA -->

    </div>

</div>

<div class="modal fade" id="petunjuk">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Informasi
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <div class="modal-body text-center">
                Terima kasih atas kepercayaan Anda, yang telah menggunakan layanan kami!
                Panduan Penggunaan Silahkan kunjungi Channel Youtube Kami <br>Portal Digital Pesantren <a href="https://youtube.com/@darululumtlasih6763?si=XpDwykT75QtzL6k1" target="_blank" class="alert-link">DISINI</a>
            </div>
            <div class="modal-footer p-0">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>

</div>

<script>
    $(document).ready(function() {
        TampilGrafik();
        uponline();

    });

    function TampilGrafik() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/TampilkanGrafik') ?>",
            data: {
                [csrfToken]: csrfHash,
            },
            dataType: "json",

            beforeSend: function() {
                $('.viewtampilgrafik').html('<span class="spinner-border spinner-grow-sm text-center" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },

            success: function(response) {
                if (response.data) {
                    $('.viewtampilgrafik').html(response.data);

                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }

    function uponline() {
        $.ajax({
            url: "<?= site_url('admin/getonline') ?>",
            dataType: "json",
            beforeSend: function() {
                $('.viewonline').html('<span class="spinner-border spinner-grow-sm text-center" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            success: function(response) {
                $('.viewonline').html(response.data);
            },

            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                });
            }
        });
    }
</script>


<?= $this->endSection() ?>