<!-- ============================= WEBSITE LEMBAGA ============================= -->

<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Login</title>
    <meta content="Admin Dashboard" name="Aplikasi Pendidikan Net" />
    <meta content="CMS LEMBAGA" name="Aplikasi Pendidikan Net" />

    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi->icon) ?>">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/style.css" rel="stylesheet" type="text/css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <style>
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
    </style>
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div id="overlay"></div>
    <div class="wrapper-page">
        <div class="card p-1">
            <div class="card-body">
                <?php if (file_exists('public/img/konfigurasi/logo/' . $konfigurasi->logo)) {
                    $img = $konfigurasi->logo;
                } else {
                    $img = 'default.png';
                }
                ?>

                <h3 class="text-center m-0">
                    <a href="<?= base_url() ?>" class="logo logo-admin"><img src="<?= base_url('/public/img/konfigurasi/logo/' . $img) ?>"></a>
                </h3>
                <h4 class="text-secondary font-18 m-b-5 text-center">Autentikasi Sistem</h4>

                <hr>
                <div class="p-1">
                    <?= form_open('login/validasi', ['class' => 'formlogin']) ?>
                    <?= csrf_field() ?>
                    <form class="form-horizontal m-t-30" action="index.html" autocomplete="off | unknown-autocomplete-value">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= htmlentities(set_value('usernama'), ENT_QUOTES) ?>" placeholder="Enter username" autofocus required>
                            <div class="invalid-feedback errorUsername"></div>
                        </div>
                        <div class="form-group">
                            <label for="userpassword">Password</label>
                            <input type="password" class="form-control" name="password_hash" id="password_hash" value="<?= htmlentities(set_value('password_hash'), ENT_QUOTES) ?>" placeholder="Enter password" required>
                            <div class="invalid-feedback errorPassword">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="<?= $sitekey ?>"></div>
                                </div>
                            </div>
                            <div class="col-md-6 text-right" style="margin-top: 20px;">
                                <div class="form-group">
                                    <button class="btn btn-primary waves-effect waves-light btnlogin" type="submit"><i class="fas fa-sign-in-alt text-light"></i> Sign in</button>
                                </div>

                            </div>
                        </div>
                        <a title="Request reset password" href="<?= base_url('lupapassword') ?>" class="text-danger"><i class="mdi mdi-lock"></i>
                            Lupa Password?
                        </a>

                    </form>
                    <?php echo form_close() ?>
                </div>

            </div>
        </div>

        <div class="m-t-40 text-center">
            <?php if ($konfigurasi->sts_regis != 0) { ?>
                <p class="text-white-50">Belum Punya Akun? <a href="<?= base_url('registrasi') ?>" class="text-white"> Daftar disini </a> </p>
            <?php  } ?>

            <p class="text-muted">Hak Cipta © 2023 - <?= date('Y') ?> <?= $konfigurasi->nama ?> <br><small><i class="mdi mdi-console"></i> Versi <?= $konfigurasi->vercms ?></p>
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
    $(document).ready(function() {
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
                    $('.btnlogin').html('Log in')
                    $('.btnlogin').html('<i class="fas fa-sign-in-alt"></i>  Sign in');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.username) {

                            Swal.fire({
                                title: "Login Gagal..!",
                                text: "User atau password yang anda masukkan salah!",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3250
                            });

                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorUsername').html();
                        }

                        if (response.error.password_hash) {

                            Swal.fire({
                                title: "Login Gagal..!",
                                text: "User atau password yang anda masukkan salah!",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 3250
                            });
                        } else {
                            $('#password_hash').removeClass('is-invalid');
                            $('.errorPassword').html();
                        }
                    }

                    if (response.sukses) {
                        window.location = '<?= base_url('dashboard') ?>';
                    }

                    if (response.gagalcap) {
                        Swal.fire({
                            title: "Maaf...!",
                            text: response.gagalcap,
                            icon: "error",
                            // showConfirmButton: false,
                            timer: 4550
                        }).then(function() {
                            // window.location = '<?= base_url('') ?>';
                            window.location = '';
                        });
                    }
                    if (response.usahalebih) {
                        $('#overlay').show();
                        $('form :input').prop('disabled', true);
                        Swal.fire({
                            title: "Maaf...!",
                            text: response.usahalebih,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 10550
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                            // window.location = '';
                        });
                    }
                    if (response.nonactive) {
                        Swal.fire({
                            title: "Maaf Gagal Login..!",
                            text: "Anda tidak berhak mengakses Dashboard..!",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 3250
                        });
                    }

                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Ada kesalahan`,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    });
                }
            });
            return false;
        });
    });
</script>