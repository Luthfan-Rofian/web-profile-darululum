<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>

<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">
    </div>
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


<!-- end page title end breadcrumb -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase mb-3">SEMUA video</div>
                            </div>
                        </div>
                        <?php if ($video) { ?>


                            <div class="row container-grid projects-wrapper">
                                <?php $nomor = 0;
                                foreach ($video as $data) :
                                    $nomor++;
                                    $pot = substr($data['judul'], 0, 50);
                                ?>

                                    <div class="col-md-4 col-12 pb-4 text-center">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $data['video_link'] ?>" allowfullscreen></iframe>
                                        </div>
                                        <div class="judul-galeri">
                                            <a href="" data-toggle="modal" data-target="#foto341874ad-bc33-11eb-8a43-e64c1828d62e" class="judul-galeri"><?= $data['judul'] ?></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- PAGINATION -->
                            <div class="col-md-12 pt-4">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <?= $pager->links('hal', 'datagoe'); ?>
                                    </ul>
                                </nav>

                            </div>

                        <?php } else { ?>
                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                <a style='color:red'>Maaf belum ada data..!</a>
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