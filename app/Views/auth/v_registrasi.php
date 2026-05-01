<!-- ============================= WEBSITE LEMBAGA ============================= -->

<!DOCTYPE html>
<html lang="in">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Registrasi Pengguna</title>
    <meta content="Admin Dashboard" name="Aplikasi Pendidikan Net" />
    <meta content="CMS LEMBAGA" name="Aplikasi Pendidikan Net" />
    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi->icon) ?>">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/public/template/temp-backend/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <!-- Background -->
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div class="wrapper-page">
        <div class="card">
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
                <h4 class="text-danger font-18 m-b-5 text-center">REGISTRASI PENGGUNA</h4>

                <hr>
                <div class="p-1">

                    <?= form_open_multipart('', ['class' => 'formregis']) ?>
                    <?= csrf_field() ?>
                    <form class="form-horizontal m-t-30" action="index.html">

                        <?php if ($opd != '') { ?>

                            <div class="form-group">
                                <label> Unit Kerja</label>
                                <div>
                                    <select name="opd_id" id="opd_id" class="form-control">
                                        <option Disabled=true Selected=true>-- Pilih Unit Kerja --</option>
                                        <?php foreach ($opd as $key => $data) { ?>
                                            <option value="<?= $data['opd_id'] ?>"><?= $data['nama_opd'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback erroropd_id">Silahkan pilih unit kerja</div>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="form-group ">
                            <label>Nama Lengkap</label>
                            <div>
                                <input type=" text" class="form-control" name="fullname" id="fullname" value="<?= htmlentities(set_value('fullname'), ENT_QUOTES) ?>" placeholder="Nama Lengkap">
                                <div class="invalid-feedback errorFullname"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>
                                    E-mail
                                </label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= htmlentities(set_value('email'), ENT_QUOTES) ?>" placeholder="E-mail">
                                <div class="invalid-feedback erroremail"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>
                                    Nama User
                                </label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= htmlentities(set_value('username'), ENT_QUOTES) ?>" placeholder="Username" autofocus>
                                <div class="invalid-feedback errorusername"></div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" value="<?= htmlentities(set_value('password'), ENT_QUOTES) ?>" placeholder="Enter password">

                                <div class="invalid-feedback errorpassword"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label for="password_confirm">Ulangi Kembali</label>
                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?= htmlentities(set_value('password_confirm'), ENT_QUOTES) ?>" placeholder="Enter password">

                                <div class="invalid-feedback errorpassword_confirm"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Foto Profil</label>
                            <div>
                                <div class="input-group">
                                    <input type="file" id="user_image" name="user_image" class="form-control">
                                    <div class="invalid-feedback erroruser_image"></div>
                                </div>
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
                                    <button class="btn btn-success waves-effect waves-light btnsimpan" type="submit"><i class="mdi mdi-account-plus text-light"></i> Register</button>
                                </div>

                            </div>
                        </div>

                        <?= form_close() ?>
                </div>

            </div>

        </div>

        <div class="m-t-30 text-center">
            <p class="text-muted">Remember It ? <a href="<?= base_url('/login') ?>" class="text-white"> Kembali Login </a> </p>
            <p class="text-muted">Hak Cipta © <?= date('Y') ?> <?= $konfigurasi->nama ?></p>
        </div>

    </div>
    <!-- jQuery  -->
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/waves.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/sweetalert2.js"></script>

    <script src="<?= base_url() ?>/public/template/temp-backend/plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/pages/form-advanced.js"></script>
    <script src="<?= base_url() ?>/public/template/temp-backend/assets/js/app.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {

        $('#opd_id').select2({

        })

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formregis')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('login/daftarakun') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="mdi mdi-account-plus text-light"></i>  Register');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorusername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorusername').html('');
                            $('#username').addClass('is-valid');
                        }

                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorpassword').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.errorpassword').html('');
                            $('#password').addClass('is-valid');
                        }

                        if (response.error.password_confirm) {
                            $('#password_confirm').addClass('is-invalid');
                            $('.errorpassword_confirm').html(response.error.password_confirm);
                        } else {
                            $('#password_confirm').removeClass('is-invalid');
                            $('.errorpassword_confirm').html();
                        }

                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorFullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.errorFullname').html('');
                            $('#fullname').addClass('is-valid');
                        }


                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html('');
                            $('#email').addClass('is-valid');
                        }

                        if (response.error.user_image) {
                            $('#user_image').addClass('is-invalid');
                            $('.erroruser_image').html(response.error.user_image);
                        } else {
                            $('#user_image').removeClass('is-invalid');
                            $('.erroruser_image').html('');

                        }

                    }
                    if (response.gopdid) {
                        $('#opd_id').addClass('is-invalid');
                        $('.erroropd_id').html(response.gopdid.opd_id);

                        // toastr["error"](response.gopdid)
                    }
                    if (response.gagalcap) {
                        Swal.fire({
                            title: "Maaf...!",
                            text: response.gagalcap,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 4550
                        }).then(function() {
                            window.location = '';
                        });
                    }

                    if (response.sukses) {

                        Swal.fire({
                            title: "Sukses Registrasi Akun",
                            text: " Silahkan menunggu proses Verifikasi dan Aktivasi Akun oleh Administrator..!",
                            icon: "success",

                        }).then(function() {
                            window.location = 'home';
                        })
                    }

                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal load data!",
                        html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    });
                }
            });
        });

    });
</script>