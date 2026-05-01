<!-- ============================= CMS DATAGOE DIDEVELOP OLEH VIAN TAUM  ============================= -->
<!doctype html>
<html lang="in">

<head>
    <!-- SITE TITLE -->
    <meta name="description" content="<?= $konfigurasi->deskripsi ?>">
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi->icon) ?>">
    <title><?= esc($title) ?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="<?= $konfigurasi->nama ?>" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="index,follow" name="googlebot">
    <meta name="robots" content="index,follow">
    <meta content="In-Id" http-equiv="content-language">
    <meta content="id" name="language">
    <meta content="id" name="geo.country">
    <meta content="Indonesia" name="geo.placename">
    <link rel="canonical" href="<?= base_url() ?>" />

    <!-- facebook META -->
    <meta property="fb:pages" content="140586622674265" />
    <meta property="fb:app_id" content="140586622674265" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?= $url ?>">
    <meta property="og:title" content="<?= esc($title) ?>">
    <meta property="og:image" content="<?= $img ?>">
    <meta property="og:site_name" content="<?= $konfigurasi->website ?>">
    <meta property="og:description" content="<?= $deskripsi ?>">
    <meta property="article:author" content="https://www.facebook.com/datagoe/" />
    <meta property="article:publisher" content="https://www.facebook.com/datagoe/" />
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">

    <!-- twitter card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@datagoe_wkc" />
    <meta name="twitter:creator" content="@datagoe_wkc">
    <meta name="twitter:title" content="<?= esc($title) ?>" />
    <meta name="twitter:description" content="<?= $deskripsi ?>" />
    <meta name="twitter:image:src" content="<?= $img ?>" />


    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>/public/template/<?= $folder ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>/public/template/<?= $folder ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/public/template/<?= $folder ?>/assets/css/app-modif.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>/public/template/<?= $folder ?>/assets/css/app.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/sweetalert2.js"></script>

    <script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/jquery/jquery.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- widget -->
    <link href="<?= base_url() ?>/public/template/temp-backend/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/public/template/temp-backend/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/public/template/temp-backend/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/wajib.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <!-- Vendor CSS Files -->

</head>

<style>
    .pointer {
        cursor: pointer;
    }

    #myBtn {
        display: none;
        position: fixed;
        bottom: 38px;
        right: 30px;
        z-index: 99;
        font-size: 13px;
        border: none;
        outline: none;
        background-color: #0e5278;
        color: white;
        cursor: pointer;
        padding: 10px;
        border-radius: 4px;
    }

    #myBtn:hover {
        background-color: #555;
    }

    @media screen and (min-width: 450px) {
        .image1 {
            height: 425px;
            margin-left: auto;
            margin-right: auto;
        }
    }

    @media screen and (max-width: 550px) {

        .image1 {
            height: 210px;
        }
    }

    .kategori {
        position: absolute;
        text-transform: uppercase;
        font-size: 0.8rem;
        top: 3%;
        left: 5%;
        border-radius: 80px;
    }

    .kategori_inline {
        text-transform: uppercase;
        font-size: 0.8rem;
        border-radius: 80px;
    }

    .ketberita {
        position: absolute;
        right: 15%;
        bottom: 20px;
        left: 15%;
        z-index: 10;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #fff;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, .6);
    }

    .ketberita {
        background-color: rgba(0, 0, 0, 0.5);
        width: 100%;
        right: 0px;
        left: 0px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
        bottom: 0px;
        text-align: left;
    }

    .sinergi {
        padding: 0px 0;
    }

    .sinergi .sinergi-logo {
        padding: 1px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        height: 100px;
    }

    .sinergi .sinergi-logo img {
        transition: all 0.3s ease-in-out;
        height: 60px;
    }

    .sinergi .sinergi-logo:hover img {
        filter: none;
        transform: scale(1.1);
    }

    /* WhatsApp Floating Button CSS (UPDATED) */
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        left: 30px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
        text-decoration: none;
        overflow: hidden; /* Menyembunyikan teks saat tidak hover */
    }

    /* NEW: Pulse Animation */
    .whatsapp-float {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }

    /* NEW: Hover with Label */
    .whatsapp-float:hover {
        background-color: #128C7E;
        width: 180px; /* Lebar saat hover */
        border-radius: 30px; /* Agar lebih memanjang */
        text-decoration: none;
        animation: none; /* Hentikan animasi pulse saat hover */
    }

    .whatsapp-float .fab {
        font-size: 35px;
        transition: all 0.3s ease;
    }

    .whatsapp-float .whatsapp-text {
        display: none; /* Sembunyikan teks secara default */
        font-weight: bold;
        font-size: 16px;
        margin-left: 10px;
        white-space: nowrap;
    }

    .whatsapp-float:hover .whatsapp-text {
        display: block; /* Tampilkan teks saat hover */
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }


    /* Adjust position on smaller screens */
    @media screen and (max-width: 768px) {
        .whatsapp-float {
            width: 50px;
            height: 50px;
            bottom: 30px;
            left: 20px;
        }
        .whatsapp-float .fab {
            font-size: 28px;
        }
        .whatsapp-float:hover {
            width: 150px; /* Lebar hover di mobile lebih kecil */
        }
        .whatsapp-float .whatsapp-text {
            font-size: 14px;
        }
    }
</style>

<body data-layout="horizontal" data-layout-size="boxed">

    <button onclick="topFunction()" id="myBtn" title="Go to Top"><i class="mdi mdi-chevron-up"></i><br>TOP</button>

    <div id="layout-wrapper">

        <header id="page-topbar">
            <?= $this->renderSection('v_menu') ?>
        </header>

        <div class="main-content">

            <div class="page-content">
                <?= $this->renderSection('content') ?>

            </div>
            <!-- End Page-content -->
        </div>
        <footer class="footer-area text-center mt-0 p-0">
            <div class="container-fluid mt-0">
                <div class="row">
                    <!-- Footer Widget Area -->

                    <div class="footer-widget p-0">
                        <br>
                        <a class="text-uppercase" style=" color:#fff; font-size: large;"><?= $konfigurasi->nama ?></a> <br>
                        <a class="text-light" style="font-size: 14px;" href="<?= $konfigurasi->link_gmap ?>" target=" _blank"><?= $konfigurasi->alamat ?>. Kabupaten <?= $konfigurasi->kabupaten ?>, Provinsi: <?= $konfigurasi->provinsi ?></a> <br>
                        <a style="color:#fff; font-size: 14px;">No. Telp: <?= $konfigurasi->no_telp ?> | E-mail: </a> <a class="text-light" style="font-size: 14px;" href="mailto:<?= $konfigurasi->email ?>?subject=KONTAK KAMI"><?= $konfigurasi->email ?></a> <br>

                        <a class="text-light" target="_blank" href="<?= $konfigurasi->sosmed_fb ?>" style="color: #778899;font-size: large;"><i class="fab fa-facebook"></i></a> &nbsp;
                        <a class="text-light" target="_blank" href="<?= $konfigurasi->sosmed_instagram ?>" style="color: #778899;font-size: large;"><i class="fab fa-instagram"></i></a> &nbsp;
                        <a class="text-light" target="_blank" href="<?= $konfigurasi->sosmed_twiter ?>" style="color: #778899;font-size: large;"><i class="fab fa-twitter"></i></a> &nbsp;
                        <a class="text-light" target="_blank" href="<?= $konfigurasi->sosmed_youtube ?>" style="color: #778899; font-size: large;"><i class="fab fa-youtube"></i></a> &nbsp;

                        <!-- Logo -->

                        <hr style="color:#fff;">
                        <p style="color:#fff; text-indent: 0%; ">

                            <?php foreach ($footer as $menu) { ?>

                                <?php
                                if ($menu['linkexternal'] == 'N') { ?>
                                    <a class="text-light mb-1" target="<?= $menu['target'] ?>" href="<?= base_url($menu['menu_link']) ?> " style="font-size: 14px;"> <i class="<?= $menu['icon'] ?>"></i> <?= $menu['nama_menu'] ?> | </a>

                                <?php } else { ?>
                                    <a class="text-light mb-1" target="<?= $menu['target'] ?>" href="<?= $menu['menu_link'] ?>" style="font-size: 14px;"> <i class="<?= $menu['icon'] ?>"></i> <?= $menu['nama_menu'] ?> | </a>
                            <?php  }
                            } ?>
                            <a style="font-size: 14px;color:#fff;"> &copy; <?= date('Y') ?> <?= $konfigurasi->nama ?> </a>
                            <br>

                            <i> <a style="font-size: 14px;color:#fff;"> <?= $konfigurasi->footer_cms ?> </a>
                            </i>
                            &nbsp;| <a class="viewonline pb-0" style="font-size: 14px;color:#fff; padding-bottom: 0pt;"></a>
                        </p>

                    </div>

                </div>
            </div>

        </footer>
    </div>

    <div class="viewdata"></div>
    <div class="viewmodal"></div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalcari">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-body p-0">
                        <p style="text-align:justify; ">

                        <form action="<?= base_url('cari/berita') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="input-group p-0">
                                <input type="text" class="form-control" name="keyword" id="keyword" value="<?= htmlentities(set_value('keyword'), ENT_QUOTES) ?>" placeholder="Masukkan kata kunci pencarian.." aria-label="Pencarian" autofocus required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="submit" name="cari"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>

                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Button HTML (UPDATED) -->
    <?php
    // Ambil nomor dari konfigurasi
    $wa_number = '';
    if (!empty($konfigurasi->no_telp)) {
        // Hapus semua karakter selain angka
        $wa_number = preg_replace('/[^0-9]/', '', $konfigurasi->no_telp);
        // Jika nomor dimulai dengan '0', ganti dengan '62' (kode Indonesia)
        if (substr($wa_number, 0, 1) === '0') {
            $wa_number = '62' . substr($wa_number, 1);
        }
    }
    ?>
    <?php if (!empty($wa_number)): ?>
    <!-- PERUBATAN HANYA DI BARIS INI: TEKS PESAN WHATSAPP TELAH DIUPDATE SESUAI PERMINTAAN -->
    <a href="https://wa.me/<?= $wa_number ?>?text=Assalamu%E2%80%99alaikum%20Warahmatullahi%20Wabarakatuh%2C%20mohon%20izin%20Admin%2C%20saya%20ingin%20bertanya%20seputar%20Pondok%20Pesantren%20Darul%20Ulum%20Tlasih." class="whatsapp-float" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-text">Hubungi Kami</span>
    </a>
    <?php endif; ?>

</body>

<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/js/app.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/js/pages/datatables.init.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/js/pages/gallery.init.js"></script>
<script src="<?= base_url() ?>/public/template/<?= $folder ?>/assets/js/app.js"></script>
<script src="<?= base_url() ?>/public/template/temp-backend/assets/js/purecounter.js"></script>

<script src="<?= base_url() ?>/public/template/temp-backend/assets/js/datagoe/jquery.waypoints.min.js"></script>
<script src="<?= base_url() ?>/public/template/temp-backend/assets/js/datagoe/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>/public/template/temp-backend/assets/js/datagoe/moddatagoe.js"></script>

</html>
<script>
    $(document).ready(function() {
        LihatOnline();
    });
</script>

<?= $this->include('/admin/modal/getjs'); ?>

<script>
    $(function() {
        var url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/, "") + "$");
        $('.menu a').each(function() {
            if (urlRegExp.test(this.href.replace(/\/$/, ""))) {
                $(this).addClass('dgeaktif');
            }
        });

    });

    var mybutton = document.getElementById("myBtn");

    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>