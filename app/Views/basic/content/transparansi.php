<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

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
                                <div class="title-konten text-uppercase mb-3">Transparansi Anggaran</div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12 p-2">
                                <div class="card-deck">


                                    <?= csrf_field(); ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div style="background-color: #fff8dc;
              border-radius: 5px;
              border: 1px solid #ffdb92;
              margin: 0 5px 0 0px;" class="row pt-3">

                                            <div class="col-lg-10 col-md-12 col-sm-12">
                                                <div class="mb-3 d-flex">
                                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                                        <div class="input-group">

                                                            <select class="form-control pointer" name="tahun" id="tahun">
                                                                <option value="">-Pilih Tahun Anggaran-</option>
                                                                <?php
                                                                $thnini = date('Y');
                                                                for ($i = 2015; $i <= $thnini; $i++) { ?>
                                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                                <?php }  ?>

                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ml-1">

                                                        <select name="judul" id="judul" class="form-control pointer">
                                                            <option Disabled=true Selected=true>-- Silahkan Pilih Judul--</option>
                                                            <?php foreach ($listopsi as $key => $data) { ?>
                                                                <option value="<?= $data['judul'] ?>"><?= $data['judul'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-primary btn-block mb-3" id="terapkan">Terapkan</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">

                                                <div class="viewtampilgrafik text-center"></div>

                                            </div>

                                        </div> <!-- end statistik -->
                                        <div class="alert alert-info" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <!-- Transparansi keuangan diartikan sebagai penyampaian informasi keuangan kepada masyarakat luas (warga), dalam rangka pertanggungjawaban pemerintah, kepatuhan pemerintah terhadap ketentuan dan peraturan yang berlaku, dan meningkatkan efektifitas pengawasan masyarakat terhadap pembangunan dan pelayanan. -->
                                                <!-- Untuk menampilkan data, silahkan Pilih Tahun Anggaran, judul dan klik tombol <b>Terapkan</b>. <br> -->
                                                Jika data yang dicari tidak ditemukan, Silahkan klik <b class="tambahkritik pointer">disini</b>, untuk lakukan permintaan Informasi.
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


<script>
    $(document).ready(function() {
        TampilGrafikAwal();

        $('#terapkan').click(function(e) {

            e.preventDefault();
            TampilGrafik();
        });

    });


    // awal
    function TampilGrafikAwal() {
        $.ajax({
            type: "post",
            url: "<?= site_url('transparansi/TampilkanGrafikAll') ?>",
            data: {
                [csrfToken]: csrfHash,
                tahun: $('#tahun').val(),
                judul: $('#judul').val(),
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
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function TampilGrafik() {
        $.ajax({
            type: "post",
            url: "<?= site_url('transparansi/TampilkanGrafik') ?>",
            data: {
                [csrfToken]: csrfHash,
                tahun: $('#tahun').val(),
                judul: $('#judul').val(),

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
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }
</script>




<?= $this->endSection() ?>