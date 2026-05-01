<!-- ============================= WEBSITE LEMBAGA ============================= -->

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

    <title>Reset Password</title>
    <meta content="Admin Dashboard" name="Aplikasi Pendidikan Net" />
    <meta content="CMS LEMBAGA" name="Aplikasi Pendidikan Net" />

    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi['icon']) ?>">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- Background -->
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <?php if (file_exists('public/img/konfigurasi/logo/' . $konfigurasi['logo'])) {
                    $img = $konfigurasi['logo'];
                } else {
                    $img = 'default.png';
                }
                ?>
                <h3 class="text-center m-0">
                    <a href="<?= base_url() ?>" class="logo logo-admin"><img src="<?= base_url('/public/img/konfigurasi/logo/' . $img) ?>"></a>
                </h3>
                <hr>
                <div class="p-1">
                    <?= form_open('login/prosesgantipass', ['class' => 'formlogin']) ?>
                    <?= csrf_field() ?>

                    <form class="form-horizontal m-t-30" action="index.html">
                        <div class="form-group">
                            <label for="password">Masukan Password Baru</label>
                            <input type="password" class="form-control" name="password" id="password" value="<?= htmlentities(set_value('password'), ENT_QUOTES) ?>" placeholder="Enter password">

                            <div class="invalid-feedback errorpassword"></div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Ulangi Kembali</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?= htmlentities(set_value('password_confirm'), ENT_QUOTES) ?>" placeholder="Enter password">

                            <div class="invalid-feedback errorpassword_confirm"></div>
                        </div>
                        <input type="hidden" name="token" value="<?= $token ?>" />

                        <div class="form-group row m-t-20">
                            <div class="col-6">

                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-success w-md waves-effect waves-light btnlogin" type="submit"><i class="mdi mdi-content-save-settings text-light"></i> Set New Password</button>
                            </div>
                        </div>

                        <!-- </form> -->
                        <?php echo form_close() ?>
                </div>

            </div>
        </div>

        <div class="m-t-40 text-center">
            <p class="text-muted">Remember It ? <a href="<?= base_url('/login') ?>" class="text-white"> Kembali Login </a> </p>
            <p class="text-muted">Hak Cipta © 2023 - <?= date('Y') ?> <?= $konfigurasi['nama'] ?></p>
        </div>

    </div>
    <!-- jQuery  -->
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/waves.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/sweetalert2.js"></script>

</body>

</html>

<script>
    $('.formlogin').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnlogin').prop('disable', true);
                $('.btnlogin').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

            },
            complete: function() {
                $('.btnlogin').prop('disable', false);
                $('.btnlogin').html('Set New Password')
                $('.btnlogin').html('<i class="mdi mdi-content-save-settings"></i>  Set New Password');
            },
            success: function(response) {
                if (response.error) {

                    if (response.error.password) {
                        $('#password').addClass('is-invalid');
                        $('.errorpassword').html(response.error.password);
                    } else {
                        $('#password').removeClass('is-invalid');
                        $('.errorpassword').html();
                    }

                    if (response.error.password_confirm) {
                        $('#password_confirm').addClass('is-invalid');
                        $('.errorpassword_confirm').html(response.error.password_confirm);
                    } else {
                        $('#password_confirm').removeClass('is-invalid');
                        $('.errorpassword_confirm').html();
                    }

                }

                if (response.sukses) {
                    Swal.fire({
                        title: "Sukses Ganti Password",
                        text: "Password Anda telah berhasil diubah silahkan Login",
                        icon: "success",

                    }).then(function() {
                        window.location = 'login';
                    })
                }

            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal proses data!",
                    html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });
            }
        });
        return false;
    });
</script>