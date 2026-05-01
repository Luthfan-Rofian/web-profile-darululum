<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->section('v_menu');
$db = \Config\Database::connect();
?>
<style>
    nav-dge {
        display: block;
        /* background: #374147; */
        padding: 2px 40px;

    }

    .menudge {
        display: block;
    }

    .menudge li {
        display: inline-block;
        position: relative;
        z-index: 100;
    }

    .menudge li:first-child {
        margin-left: 0;
    }

    .menudge li a {
        font-weight: 550;
        text-decoration: none;
        padding: 10px 10px;
        display: block;
        color: #fff;
        transition: all 0.2s ease-in-out 0s;
    }

    .menudge li a:hover,
    .menudge li:hover>a {
        color: #fff;
        background: #0e5278;
    }

    /* lbrul */
    .menudge ul {
        visibility: hidden;
        opacity: 0;
        margin: 0;
        padding: 0;
        width: 180px;
        position: absolute;
        left: 0px;
        background: #fff;
        z-index: 99;
        transform: translate(0, 20px);
        transition: all 0.2s ease-out;
    }

    .menudge ul:after {
        bottom: 100%;
        left: 20%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(255, 255, 255, 0);
        border-bottom-color: #fff;
        border-width: 6px;
        margin-left: -6px;
    }

    .menudge ul li {
        display: block;
        float: none;
        background: none;
        margin: 0;
        padding: 0;
    }

    /* font sub2 */
    .menudge ul li a {
        font-size: 14px;
        font-weight: normal;
        display: block;
        color: #797979;
        background: #fff;
    }

    .menudge ul li a:hover,
    .menudge ul li:hover>a {
        background: #0e5278;
        color: #fff;
    }

    .menudge li:hover>ul {
        visibility: visible;
        opacity: 1;
        transform: translate(0, 0);
    }

    .menudge ul ul {
        left: 180px;
        top: 0px;
        visibility: hidden;
        opacity: 0;
        transform: translate(20px, 20px);
        transition: all 0.2s ease-out;
    }

    .menudge ul ul:after {
        left: -6px;
        top: 10%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(255, 255, 255, 0);
        border-right-color: #fff;
        border-width: 6px;
        margin-top: 8px;
    }

    .menudge li>ul ul:hover {
        visibility: visible;
        opacity: 1;
        transform: translate(0, 0);
    }

    .responsive-menudge {
        display: none;
        width: 100%;
        padding: 20px 15px;
        background: #374147;
        color: #fff;
        text-transform: uppercase;
        font-weight: 200;
    }

    .responsive-menudge:hover {
        background: #374147;
        color: #fff;
        text-decoration: none;
    }

    a.dgeaktif {
        background: #0e5278;
    }

    @media (min-width: 768px) and (max-width: 979px) {
        .mainWrap {
            width: 768px;
        }

        .menudge ul {
            top: 17px;
        }

        .menudge li a {
            font-size: 14px;
        }

        a.dgeaktif {
            background: #374147;
        }
    }

    @media (max-width: 767px) {
        .mainWrap {
            width: auto;
            padding: 10px 20px;
        }

        .menudge {
            display: none;
        }

        .responsive-menudge {
            display: block;
            margin-top: 100px;
        }

        nav-dge {
            margin: 0;
            background: none;
        }

        .menudge li {
            display: block;
            margin: 0;
        }

        .menudge li a {
            background: #fff;
            color: #797979;
        }

        .menudge li a:hover,
        .menudge li:hover>a {
            background: #0e5278;
            color: #fff;
        }

        .menudge ul {
            visibility: hidden;
            opacity: 0;
            top: 0;
            left: 0;
            width: 100%;
            transform: initial;
        }

        .menudge li:hover>ul {
            visibility: visible;
            opacity: 1;
            position: relative;
            transform: initial;
        }

        .menudge ul ul {
            left: 0;
            transform: initial;
        }

        .menudge li>ul ul:hover {
            transform: initial;
        }
    }

    @media (max-width: 480px) {}

    @media (max-width: 320px) {}
</style>

<div class="navbar-header">
    <div class="container-fluid">
        <div class="float-right">

            <div class="dropdown d-inline-block">

                <!-- modal pencarian mobile -->
                <!-- <button type="button" data-toggle="modal" data-target="#modalcari" class="d-block d-sm-none d-inline-block align-top btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button> -->
                <button id="resp-menudge" type="button" class="btn btn-sm p-0 font-size-16 d-lg-none header-item waves-effect waves-light">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <div class="d-none d-sm-block">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="page-header-search-dropdown">

                        <form action="<?= base_url('cari/berita') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="form-group p-0">
                                <div class="input-group">
                                    <!-- <div class="col-12"> -->
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Masukan kata kunci pencarian..." aria-label="Pencarian" required>
                                    <!-- </div> -->
                                    <div class="input-group-append p-0">

                                        <button class="btn btn-primary" type="submit" name="cari"><i class="mdi mdi-magnify"></i></button>

                                    </div>


                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
        <!-- LOGO -->
        <?php if (file_exists('public/img/konfigurasi/logo/' . $konfigurasi->logo)) {
            $logo = $konfigurasi->logo;
        } else {
            $logo = 'default.png';
        }
        ?>
        <div class="navbar-brand-box">
            <a href="<?= base_url() ?>" class="logo">
                <!-- <div class="text-center">
                    <span class="logo-sm">
                        <img src="<?= base_url('/public/img/konfigurasi/logo/' . $logo) ?>" height="55">
                    </span>
                </div> -->
                <span class="logo-lg">
                    <img src="<?= base_url('/public/img/konfigurasi/logo/' . $logo) ?>">
                </span>

            </a>
        </div>
        <!-- menu Navbar -->
        <!-- <div class="text-left ml-auto text-danger"> -->
        <button id="" type="button" class="btn btn-sm p-0 font-size-16 d-lg-none header-item mt-0 waves-effect waves-light">
            <!-- <strong class="d-block d-sm-none d-flex"><?= strtoupper($konfigurasi->namasingkat) ?></strong> -->
            <!-- <div class="text-center"> -->
            <span class="logo-sm">
                <a href="<?= base_url() ?>"><img src="<?= base_url('/public/img/konfigurasi/logo/' . $logo) ?>" height="50"></a>
            </span>
            <!-- </div> -->
        </button>

        <div class="topnav p-0">
            <nav-dge class="p-0" id="">

                <ul class="menudge p-1">
                    <form action="<?= base_url('cari/berita') ?>" method="POST" class="form-inline d-block d-lg-none">
                        <?= csrf_field(); ?>
                        <div class="input-group">
                            <input class="form-control" type="search" name="keyword" id="keyword" placeholder="Masukan kata kunci..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-warning" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- loop utama -->

                    <div class="d-none d-sm-block pt-2 p-1 "></div>
                    <?php
                    foreach ($mainmenu as $utama) {

                        $menu_id = $utama['menu_id'];

                        if ($utama['linkexternal'] == 'N') {
                            $linkutm = base_url($utama['menu_link']);
                        } else {
                            $linkutm = ($utama['menu_link']);
                        }

                        if ($utama['parent'] == 'N') { ?>
                            <li class=""><a class="text-dark" target="<?= $utama['target'] ?>" href="<?= $linkutm ?>"><i class="<?= $utama['icon'] ?>"></i> <?= $utama['nama_menu'] ?></a></li>
                        <?php
                        }
                        $set = $db->table('submenu')->where('menu_id', $menu_id)->where('stssubmenu', 1)
                            ->orderBy('urutansm', 'ASC')->get()->getResultArray();
                        if ($utama['parent'] == 'Y') { ?>

                            <li><a class="text-dark" href="#"><i class="<?= $utama['icon'] ?>"></i> <?= $utama['nama_menu'] ?><i class="mdi mdi-chevron-down"></i></a>
                                <ul class="sub-menudge">
                                    <!-- loop submenu -->
                                    <?php foreach ($set as $submenu) {
                                        if ($submenu['linkexternalsm'] == 'N') {
                                            $linksm = base_url($submenu['link_submenu']);
                                        } else {
                                            $linksm = ($submenu['link_submenu']);
                                        }
                                    ?>
                                        <!-- jika ada subsub -->
                                        <?php if ($submenu['parentsm'] == 'Y') {
                                            $setsubsub = $db->table('subsubmenu')->where('submenu_id', $submenu['submenu_id'])->where('stsssm', 1)
                                                ->orderBy('urutanssm', 'ASC')->get()->getResultArray();
                                        ?>

                                            <li class=""><a target="<?= $submenu['targetsm'] ?>" href="#"><i class="<?= $submenu['iconsm'] ?>"></i> <?= $submenu['nama_submenu'] ?><i class="d-block d-lg-none mdi mdi-chevron-down float-right"></i></a>
                                                <ul>
                                                    <!-- loping subsub -->
                                                    <?php foreach ($setsubsub as $subsubmenu) {
                                                        if ($subsubmenu['linkexternalssm'] == 'N') {
                                                            $linkssm = base_url($subsubmenu['link_subsubmenu']);
                                                        } else {
                                                            $linkssm = ($subsubmenu['link_subsubmenu']);
                                                        } ?>

                                                        <li><a target="<?= $subsubmenu['targetssm'] ?>" href="<?= ($linkssm) ?>"><i class="<?= $subsubmenu['iconssm'] ?>"></i> <?= $subsubmenu['nama_subsubmenu'] ?></a></li>

                                                    <?php } ?>
                                                    <!-- end loop subsub -->
                                                </ul>
                                            </li>
                                        <?php } else { ?>
                                            <li><a target="<?= $submenu['targetsm'] ?>" href="<?= ($linksm) ?>"><i class="<?= $submenu['iconsm'] ?>"></i> <?= $submenu['nama_submenu'] ?></a></li>
                                    <?php }
                                    }
                                    ?>
                                    <!-- end loopsub -->
                                </ul>
                            </li>

                    <?php }
                    }
                    ?>

                    <div class="d-block d-lg-none mt-2 mb-0 row text-center">

                        <hr>
                        <p>
                            <strong class="text-center"><?= strtoupper($konfigurasi->namasingkat) ?></strong>
                        </p>

                        <a href="<?= $konfigurasi->sosmed_fb ?>" target="_blank" rel="noreferrer noopener" class="btn btn-primary" type="submit">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="<?= $konfigurasi->sosmed_twiter ?>" target="_blank" rel="noreferrer noopener" class="btn btn-primary" type="submit">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="<?= $konfigurasi->sosmed_instagram ?>" target="_blank" rel="noreferrer noopener" class="btn btn-primary" type="submit">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="<?= $konfigurasi->sosmed_youtube ?>" target="_blank" rel="noreferrer noopener" class="btn btn-primary" type="submit">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </ul>
            </nav-dge>
        </div>
    </div>
</div>



<script type='text/javascript'>
    //<![CDATA[
    $(document).ready(function() {
        var touch = $('#resp-menudge');
        var menudge = $('.menudge');

        $(touch).on('click', function(e) {
            e.preventDefault();
            menudge.slideToggle();
        });

        $(window).resize(function() {
            var w = $(window).width();
            if (w > 767 && menudge.is(':hidden')) {
                menudge.removeAttr('style');
            }
        });

    });
    //]]>
</script>


<?= $this->endSection('v_menu') ?>