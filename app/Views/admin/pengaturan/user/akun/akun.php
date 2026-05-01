<?= $this->section('content') ?>
<?= $this->extend('admin/script') ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">
            <div class="state-information d-none d-sm-block">
            </div>
        </div>
    </div>
</div>
<div class="page-content-wrapper">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <?php if ($user_image != 'default.png' && file_exists('public/img/user/' . $user_image)) {
                        $profil = $user_image;
                    } else {
                        $profil = 'default.png';
                    } ?>
                    <i class="mdi mdi-image-filter-hdr"></i> Foto Profil
                    <small>*Klik di foto untuk ganti gambar.</small>
                    <hr>
                    <div class="form-group text-center">
                        <img class="img-thumbnail logoweb pointer" onclick="gantilogo('<?= esc($id) ?>')" src="<?= base_url('public/img/user/'  . esc($profil)) ?>" alt="Foto Profil" width="210px">
                    </div>
                    <div class="alert alert-secondary text-center" role="alert">
                        <?php if ($role) {
                            foreach ($role as $row) :
                            endforeach;
                        } ?>
                        Wewenang Anda : <b><?= $row['nama_grup'] ?></b>

                    </div>
                    <!-- <div class="table-responsive p-0">
                        <table class="table table-striped table-hover tabel-rincian" id="listkel">
                            <tbody>
                                <tr>
                                    <td class="p-1" width="50%">Jumlah Berita/Artikel</td>
                                    <td class="p-1" width="2%">:</td>
                                    <td class="p-1"><b>2</b></td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah Layanan</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah Bank Data</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah Pengumuman</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah Foto</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah Video</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                                <tr>
                                    <td class="p-1">Jumlah E-Book</td>
                                    <td class="p-1">:</td>
                                    <td class="p-1">3</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card m-b-20">

                <div class="card-header font-16 bg-light">

                    <?= form_open_multipart('', ['class' => 'formprofil']) ?>
                    <?= csrf_field(); ?>
                    <h6 class="modal-title mt-0">
                        <i class="fas fa-edit"></i> Update Profile
                    </h6>
                </div>

                <div class='card-body'>

                    <input type="hidden" value="<?= esc($id) ?>" name="id">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama User</label>
                        <div class="col-sm-9">
                            <input type=" text" class="form-control" name="username" id="username" value="<?= esc($username) ?>">
                            <div class="invalid-feedback errorusername"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email Aktif</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" value="<?= esc($email) ?>">
                            <div class="invalid-feedback erroremail"></div>
                            <small class="text-warning"><i>*Pastikan E-mail Anda Aktif.</i></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak diganti">
                            <small class="text-warning"><i>*Kosongkan jika Password tidak diganti.</i></small>
                        </div>

                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type=" text" class="form-control" name="fullname" id="fullname" value="<?= esc($fullname) ?>" required>
                            <div class="invalid-feedback errorfullname"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-primary btn-sm btnupload"><i class="mdi mdi-content-save-all"></i> Update Data</button>
                </div>

                <?= form_close() ?>

            </div>
        </div>
    </div>
</div>

<div class="viewmodal">
</div>

<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_load').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#user_image').change(function() {
        bacaGambar(this);
    });

    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formprofil')[0];
            let data = new FormData(form);
            $.ajax({
                type: "post",
                url: '<?= site_url('akun/updateuser') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                },
                success: function(response) {

                    if (response.error) {

                        if (response.error.fullname) {
                            $('#fullname').addClass('is-invalid');
                            $('.errorfullname').html(response.error.fullname);
                        } else {
                            $('#fullname').removeClass('is-invalid');
                            $('.errorfullname').html('');
                            $('#fullname').addClass('is-valid');
                        }
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorusername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorusername').html('');
                            $('#username').addClass('is-valid');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html('');
                            $('#email').addClass('is-valid');
                        }

                    } else {
                        toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            },
                            toastr["success"](response.sukses)

                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                }
            });
        });
    });

    function gantilogo(id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('akun/formgantifoto') ?>",
            data: {
                id: id,
                [csrfToken]: csrfHash,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal('show');
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
</script>

<?= $this->endSection() ?>