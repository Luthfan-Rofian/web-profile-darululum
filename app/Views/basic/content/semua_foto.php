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
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase">Album Foto</div>
                            </div>
                        </div>
                        <?php if ($album) { ?>
                            <div class="row container-grid projects-wrapper">

                                <?php

                                foreach ($album as $key => $data) {
                                    $idalbum = $data['kategorifoto_id'];
                                    $jumfoto = $db->table('foto')->where('kategorifoto_id', $idalbum)->get()->getNumRows();
                                ?>

                                    <div class="col-md-3 col-12 pb-4 text-center">

                                        <div class="gallery-box mt-4">
                                            <div class="bg-white rounded">
                                                <div class="px-3 kategori bg-danger">
                                                    <div class="text-light"><?= $jumfoto ?> Foto </div>
                                                </div>
                                            </div>
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('foto/detail/' . $data['kategorifoto_id']) ?>" title="Lihat Foto">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/galeri/katfoto/' . $data['cover_foto']) ?>" alt="<?= $data['nama_kategori_foto'] ?>" />
                                                </a>
                                            <?php } else { ?>
                                                <a title="Belum ada foto yang dapat ditampilkan">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/galeri/katfoto/' . $data['cover_foto']) ?>" alt="<?= $data['nama_kategori_foto'] ?>" />
                                                </a>
                                            <?php } ?>
                                            <!-- <span class="date"><?= longdate_indo($data['tgl_album']) ?></span> -->
                                        </div>
                                        <div class="judul-galeri">
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('foto/detail/' . $data['kategorifoto_id']) ?>" title="Lihat Foto"><?= $data['nama_kategori_foto'] ?></a>
                                            <?php } else { ?>
                                                <a title="Belum ada foto yang dapat ditampilkan"><?= $data['nama_kategori_foto'] ?></a>

                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php } ?>
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

                            
                            <!-- PAGINATION -->
                            <div class="col-md-12 pt-4">
                                <nav>
                                    <?php if ($jumpg > 12) { ?>
                                        <P>
                                        <ul class="pagination justify-content-center">
                                            <?= $pager->links('hal', 'datagoe'); ?>
                                        </ul>
                                        </P>
                                    <?php } ?>

                                </nav>

                            </div>


                        <?php } ?>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>