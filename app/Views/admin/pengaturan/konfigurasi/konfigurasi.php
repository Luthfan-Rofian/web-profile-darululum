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

        <div class="col-lg-8">
            <div class="card mb-4">
                <?= form_open_multipart('', ['class' => 'formedit']) ?>
                <?= csrf_field(); ?>
                <div class="card-header font-18 bg-light">
                    <h6 class="modal-title mt-0">
                        <i class="fas fa-cogs"></i> <?= $subtitle ?>
                        <?php if ($akses == 1 && $sts_web == '1') { ?>
                            <div class="float-right">
                                <button class="btn btn-primary btn-sm btnsimpan"><i class="mdi mdi-content-save-all"></i> Perbarui Data</button>
                            </div>
                        <?php } ?>
                    </h6>
                </div>

                <div class='card-body'>

                    <input type="hidden" class="form-control" id="id_setaplikasi" value="<?= $id_setaplikasi ?>" name="id_setaplikasi" readonly>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Identitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#konten" role="tab">Konten</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#medsos" role="tab">Sosial Media</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#setemail" role="tab">Pemberitahuan</a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="tab-pane active p-1" id="home1" role="tabpanel">
                            <p class="mt-3 mb-0">

                            <div class="form-group">
                                <label> <i class="mdi mdi-text-shadow"></i>
                                    Nama Situs
                                </label>
                                <input type="text" id="nama" value="<?= esc($nama) ?>" name="nama" class="form-control form-control-sm">
                                <div class="invalid-feedback errorNama"></div>
                            </div>


                            <div class="form-group ">
                                <label> <i class="mdi mdi-text-shadow"></i>
                                    Nama Situs Singkat <small>*)Untuk Tema2 tertentu menggunakan nama singkat pada tampilan mobile</small>
                                </label>

                                <input type="text" id="namasingkat" value="<?= esc($namasingkat) ?>" name="namasingkat" class="form-control form-control-sm" maxlength="50">

                            </div>

                            <div class="form-group">
                                <label> <i class="ion-ios7-settings-strong"></i>
                                    Deskripsi
                                </label>
                                <textarea type="text" rows="3" id="deskripsi" name="deskripsi" class="form-control form-control-sm"><?= esc($deskripsi) ?></textarea>
                                <div class="invalid-feedback errorDeskripsi"></div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="fab fa-whatsapp"></i>
                                        No HP / WhatsApp
                                    </label>
                                    <input type="text" id="no_telp" name="no_telp" value="<?= esc($no_telp) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorno_telp"></div>
                                </div>

                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="ion-email"></i>
                                        Email Kantor
                                    </label>
                                    <input type="text" id="email" name="email" value="<?= esc($email) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback erroremail"></div>
                                </div>
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="ion-android-keypad"></i>
                                        Provinsi
                                    </label>
                                    <input type="text" id="provinsi" name="provinsi" value="<?= esc($provinsi) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorprovinsi"></div>
                                </div>

                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="ion-android-keypad"></i>
                                        Kabupaten
                                    </label>
                                    <input type="text" id="kabupaten" name="kabupaten" value="<?= esc($kabupaten) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorkabupaten"></div>
                                </div>

                            </div>

                            <!-- <div class="row"></div> -->

                            <div class="row mb-0">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="ion-ios7-world"></i>
                                        Alamat Situs
                                    </label>
                                    <input type="url" id="website" name="website" value="<?= esc($website) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorwebsite"></div>
                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="ion-location"></i>
                                        Alamat Kantor
                                    </label>
                                    <input type="text" id="alamat" name="alamat" value="<?= esc($alamat) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback erroralamat"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> <i class="ion-ios7-settings-strong"></i>
                                    Footer Situs
                                </label>
                                <textarea type="text" rows="2" id="footer_cms" name="footer_cms" class="form-control form-control-sm"><?= esc($footer_cms) ?></textarea>

                            </div>
                        </div>

                        <div class="tab-pane p-1" id="konten" role="tabpanel">
                            <p class="mt-2">

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-cards-variant"></i> Judul Section </label>
                                    <input type="text" id="judul_section" value="<?= esc($judul_section) ?>" name="judul_section" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorjudul_section"></div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Section </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_section" id="sts_section1" value="1" <?= $sts_section == '1' ? 'checked' : '' ?>> <label for="sts_section1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_section" id="sts_section2" value="0" <?= $sts_section == '0' ? 'checked' : '' ?>> <label for="sts_section2" class="pointer"> Tidak &nbsp</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">

                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Running Text <small>* Data Pengumuman</small> </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_rt" value="1" id="sts_rt1" <?= $sts_rt == '1' ? 'checked' : '' ?>> <label for="sts_rt1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_rt" value="0" id="sts_rt2" <?= $sts_rt == '0' ? 'checked' : '' ?>> <label for="sts_rt2" class="pointer"> Tidak &nbsp</label>

                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">

                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Counter </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_count" id="sts_count1" value="1" <?= $sts_count == '1' ? 'checked' : '' ?>> <label for="sts_count1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_count" id="sts_count2" value="0" <?= $sts_count == '0' ? 'checked' : '' ?>> <label for="sts_count2" class="pointer"> Tidak &nbsp</label>

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Aktifkan <small>Daftar Akun </small></label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_regis" id="sts_regis1" value="1" <?= $sts_regis == '1' ? 'checked' : '' ?>> <label for="sts_regis1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_regis" id="sts_regis2" value="0" <?= $sts_regis == '0' ? 'checked' : '' ?>> <label for="sts_regis2" class="pointer"> Tidak &nbsp</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Role User <small>Saat Daftar</small> </label>

                                    <select name="id_grup" id="id_grup" class="form-control form-control-sm">
                                        <option Disabled=true Selected=true>-- Pilih --</option>
                                        <?php foreach ($listgrup as $key => $value) { ?>
                                            <option value="<?= $value['id_grup'] ?>" <?= $id_grup ==  $value['id_grup'] ? 'selected' : '' ?>><?= $value['nama_grup'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback errorid_grup"></div>

                                </div>
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Hubungkan <small>Unit Kerja</small> </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="konek_opd" id="konek_opd2" value="1" <?= $konek_opd == '1' ? 'checked' : '' ?>> <label for="konek_opd2" class="pointer" title="Jika aktif user saat mendaftar harus memilih Unit Kerja"> Ya &nbsp</label>
                                        <input type="radio" name="konek_opd" id="konek_opd1" value="0" <?= $konek_opd == '0' ? 'checked' : '' ?>> <label for="konek_opd1" class="pointer" title="Jika aktif user saat mendaftar harus memilih Unit Kerja"> Tidak &nbsp</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Verifikasi <small>Postingan</small> </label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_posting" id="sts_posting1" value="1" <?= $sts_posting == '1' ? 'checked' : '' ?>> <label for="sts_posting1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_posting" id="sts_posting2" value="0" <?= $sts_posting == '0' ? 'checked' : '' ?>> <label for="sts_posting2" class="pointer"> Tidak &nbsp</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Tampilkan Popup <small>(Isinya diatur di Menu Set Konten)</small></label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="sts_modal" id="stsmodal1" value="1" <?= $sts_modal == '1' ? 'checked' : '' ?>> <label for="stsmodal1" class="pointer"> Ya &nbsp</label>
                                        <input type="radio" name="sts_modal" id="stsmodal2" value="0" <?= $sts_modal == '0' ? 'checked' : '' ?>> <label for="stsmodal2" class="pointer"> Tidak &nbsp</label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">

                                    <label> <i class="mdi mdi-archive"></i> Kategori Berita </label> <small>* Kategori terpilih akan tampil di home </small> </label>
                                    <select class="form-control form-control-sm" name="kategori" id="kategori">
                                        <option Disabled=true Selected=true>-- Pilih Kategori --</option>
                                        <?php foreach ($mkategori as $key => $value) { ?>
                                            <option value="<?= $value['kategori_id'] ?>" <?= $kategori_id ==  $value['kategori_id'] ? 'selected' : '' ?>><?= $value['nama_kategori'] ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-clipboard-check-outline"></i> Versi bootstrap <small>(Modal Popup)</small></label>
                                    <div class="form-control form-control-sm">
                                        <input type="radio" name="verbost" id="verbost2" value="0" <?= $verbost == '0' ? 'checked' : '' ?>> <label for="verbost2" class="pointer"> Ver. 4x &nbsp</label>
                                        <input type="radio" name="verbost" id="verbost1" value="1" <?= $verbost == '1' ? 'checked' : '' ?>> <label for="verbost1" class="pointer"> Ver. 5x </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-arrow-expand-vertical"></i>
                                        Tinggi Banner <small>pixel</small>
                                    </label>
                                    <input type="number" id="hpbanner" name="hpbanner" value="<?= esc($hpbanner) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorhpbanner"></div>
                                </div>

                                <div class="form-group col-md-3 col-12">
                                    <label> <i class="mdi mdi-arrow-expand-horizontal"></i>
                                        Lebar Banner <small>pixel</small>
                                    </label>
                                    <input type="number" id="wlbanner" name="wlbanner" value="<?= esc($wlbanner) ?>" class="form-control form-control-sm">
                                    <div class="invalid-feedback errorwlbanner"></div>
                                </div>

                            </div>
                            <!-- <div class="row"> -->
                            <div class="form-group ">
                                <label> <i class="mdi mdi-key"></i>
                                    Site Key <small>Google reCAPTCHA V2 <a class="text-primary" href="https://www.google.com/recaptcha/admin/create" target="_Blank"> (Klik disini untuk Daftar) </a></small>
                                </label>
                                <input type="text" id="g_sitekey" title="Kosongkan jika belum ada Site Key Google" name="g_sitekey" value="<?= esc($g_sitekey) ?>" class="form-control form-control-sm">

                            </div>
                            <div class="form-group ">
                                <label> <i class="mdi mdi-key"></i>
                                    Secret Key <small>Google reCAPTCHA V2 <a class="text-primary" href="https://www.google.com/recaptcha/admin/create" target="_Blank"> (Klik disini untuk Daftar) </a></small>
                                </label>
                                <input type="text" id="g_secretkey" title="Kosongkan jika belum ada Secret Key Google" name="g_secretkey" value="<?= esc($g_secretkey) ?>" class="form-control form-control-sm">
                            </div>
                            <!-- </div> -->
                            </p>
                        </div>

                        <!-- Tab Medsos -->
                        <div class="tab-pane p-1" id="medsos" role="tabpanel">
                            <p class="mt-2">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="fab fa-facebook-f"></i>
                                        Link Akun Facebook
                                    </label>
                                    <input type="url" id="sosmed_fb" name="sosmed_fb" value="<?= esc($sosmed_fb) ?>" class="form-control">
                                    <div class="invalid-feedback errorsosmed_fb"></div>
                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="fab fa-twitter"></i>
                                        Link Akun Twitter
                                    </label>
                                    <input type="text" id="sosmed_twiter" name="sosmed_twiter" value="<?= esc($sosmed_twiter) ?>" class="form-control">
                                    <div class="invalid-feedback errorsosmed_twiter"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="fab fa-instagram"></i>
                                        Link Akun Instagram
                                    </label>
                                    <input type="url" id="sosmed_instagram" name="sosmed_instagram" value="<?= esc($sosmed_instagram) ?>" class="form-control">
                                    <div class="invalid-feedback errorsosmed_instagram"></div>
                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="fab fa-youtube"></i>
                                        Link Akun Youtube
                                    </label>
                                    <input type="text" id="sosmed_youtube" name="sosmed_youtube" value="<?= esc($sosmed_youtube) ?>" class="form-control">
                                    <div class="invalid-feedback errorsosmed_youtube"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> <i class="ion-map"></i>
                                    Google Map
                                </label>
                                <textarea type="text" rows="5" id="google_map" name="google_map" class="form-control"><?= $google_map ?></textarea>
                                <div class="invalid-feedback errorgoogle_map"></div>
                            </div>

                            <div class="form-group">
                                <label> <i class="mdi mdi-link-variant"></i>
                                    Link untuk berbagi Google Map
                                </label>
                                <input type="text" id="link_gmap" value="<?= esc($link_gmap) ?>" name="link_gmap" class="form-control">
                                <div class="invalid-feedback errorlink_gmap"></div>
                            </div>

                        </div>

                        <!-- Tab Set Email -->

                        <div class="tab-pane p-1" id="setemail" role="tabpanel">

                            <h5 class="mb-2">Email Pemberitahuan</h5>
                            <div class="alert alert-warning p-1">
                                <label class="text-dark">
                                    Untuk menggunakan SMTP Google, pastikan Anda telah mengaktifkan konfigurasi "Less Secure Apps" pada pengaturan akun Google Anda.
                                </label>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-text-shadow"></i>
                                        Host SMTP <small>*isi sesuai nama domain/mail server</small>
                                    </label>
                                    <input type="url" id="smtp_host" name="smtp_host" value="<?= esc($smtp_host) ?>" class="form-control form-control-sm">

                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-text-shadow"></i>
                                        User SMTP <small>*alamat email SMTP</small>
                                    </label>
                                    <input type="text" id="smtp_username" name="smtp_username" value="<?= esc($smtp_username) ?>" class="form-control form-control-sm">

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-text-shadow"></i>
                                        Password SMTP <small>*password email SMTP</small>
                                    </label>
                                    <input type="password" id="smtp_password" name="smtp_password" value="<?= esc($smtp_password) ?>" class="form-control form-control-sm">

                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-text-shadow"></i>
                                        Port SMTP <small>*port email SMTP</small>
                                    </label>
                                    <input type="number" id="smtp_port" name="smtp_port" value="<?= esc($smtp_port) ?>" class="form-control form-control-sm">

                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="ion-map"></i>
                                        Balasan pembuka Masukan & Saran
                                    </label>
                                    <input type="text" id="smtp_pesanbalas" name="smtp_pesanbalas" value="<?= esc($smtp_pesanbalas) ?>" class="form-control form-control-sm" title="Balasan pembuka, sebelum isi tanggapan ke email penerima.">

                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-text-shadow"></i>
                                        Nama Pengirim <small>*nama pengirim yang diterima</small>
                                    </label>
                                    <input type="text" id="smtp_pengirim" name="smtp_pengirim" value="<?= esc($smtp_pengirim) ?>" class="form-control form-control-sm" title="Nama yang akan masuk ke email Pengguna">

                                </div>
                            </div>
                            <!-- wa -->

                            <h5 class="mb-1 mt-0">WhatsApp Pemberitahuan</h5>

                            <div class="alert alert-success p-1 mb-0">
                                <label class="text-dark mt-1">
                                    Untuk menggunakan Fitur ini, pastikan Anda telah mengaktifkan Nomor WhatsApp. <small class="text-secondary">(Contoh: <a href="https://waysender.com" target="_blank" title="Salah satu Layanan super murah yang patut dicoba">Waysender.com</a>)</small>
                                </label>
                            </div>
                            <div class="row mt-1">
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-key"></i>
                                        API Key
                                    </label>
                                    <input type="text" id="tokenwa" name="tokenwa" value="<?= esc($tokenwa) ?>" class="form-control form-control-sm">

                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-key"></i>
                                        Url Server
                                    </label>
                                    <input type="text" id="urlserver" name="urlserver" value="<?= esc($urlserver) ?>" class="form-control form-control-sm">

                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-whatsapp"></i>
                                        No WA yang terdaftar
                                    </label>
                                    <input type="text" id="no_waysender" name="no_waysender" value="<?= esc($no_waysender) ?>" class="form-control form-control-sm" title="Nomor WA yang terdaftar di Layanan WA Gateway">

                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label> <i class="mdi mdi-whatsapp"></i>
                                        No WA Penerima pesan
                                    </label>
                                    <input type="text" id="wa_penerima" name="wa_penerima" value="<?= esc($wa_penerima) ?>" class="form-control form-control-sm" title="Nomor WA yang akan mendapatkan pesan ketika ada Masukan Saran yang masuk">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div><!-- Main Footer -->
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body p-3">
                    <i class="mdi mdi-image-filter-hdr"></i> Logo Website <small><a class="text-primary"> *Klik di gambar untuk ganti logo.</a></small>

                    <hr>
                    <div class="form-group text-center">

                        <?php if (file_exists('public/img/konfigurasi/logo/' . $logo)) {
                            $img = $logo;
                        } else {
                            $img = 'default.png';
                        }

                        if ($akses == 1) { ?>
                            <img class="img-thumbnail logoweb pointer" onclick="gantilogo(' <?= $id_setaplikasi ?>')" src="<?= base_url('public/img/konfigurasi/logo/' . $img) ?>" alt="Logo">
                        <?php } else { ?>
                            <img class="img-thumbnail logoweb" src="<?= base_url('public/img/konfigurasi/logo/' . $img) ?>" alt="Logo">

                        <?php } ?>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label> <i class="mdi mdi-arrow-expand-vertical"></i>
                                Tinggi Logo
                            </label>
                            <input type="number" id="hplogo" name="hplogo" value="<?= esc($hplogo) ?>" class="form-control form-control-sm">
                            <div class="invalid-feedback errorhplogo"></div>
                        </div>

                        <div class="form-group col-md-6 col-12">
                            <label> <i class="mdi mdi-arrow-expand-horizontal"></i>
                                Lebar Logo
                            </label>
                            <input type="number" id="wllogo" name="wllogo" value="<?= esc($wllogo) ?>" class="form-control form-control-sm">
                            <div class="invalid-feedback errorwllogo"></div>
                        </div>
                    </div>

                    <!-- <i><small class="text-danger">*Sesuaikan ukuran Tinggi & Lebar logo dengan tema yang digunakan pada form &nbsp;diatas, sebelum diupload.</small></i><br> -->
                    <i><small class="text-primary">Ukuran Logo telah disesuaikan otomatis dengan template yang diterapkan. <a class="text-warning">Anda dapat mengubah ukurannya..!</a></small></i>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body p-2">
                    <i class="mdi mdi-image-filter-vintage"></i> Icon Website <small>
                        <a class="text-primary"> *Klik di gambar untuk ganti icon.</a></small>
                    <hr>
                    <div class="form-group text-center">
                        <?php if ($akses == 1) { ?>
                            <img class="img-thumbnail pointer" onclick="icon('<?= $id_setaplikasi ?>')" src="<?= base_url('public/img/konfigurasi/icon/'  . $icon) ?>" alt="Icon">
                        <?php } else { ?>
                            <img class="img-thumbnail" src="<?= base_url('public/img/konfigurasi/icon/'  . $icon) ?>" alt="Icon">

                        <?php } ?>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label> <i class="ion-ios7-settings-strong"></i>
                            Slogan/Kata Mutiara
                        </label>
                        <textarea type="text" rows="3" id="katamutiara" name="katamutiara" class="form-control form-control-sm"><?= esc($katamutiara) ?></textarea>

                    </div>
                </div>
            </div>
        </div>

        <?php if ($akses == 1 && $sts_web == '1') { ?>
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btnsimpan"><i class="mdi mdi-content-save-all"></i> Perbarui Data</button>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <?= form_close() ?>
</div>

<div class="viewmodal"></div>

<script>
    $(document).ready(function() {

        $('.btnsimpan').click(function(e) {
            e.preventDefault();
            let form = $('.formedit')[0];
            let data = new FormData(form);

            $.ajax({
                type: "post",
                url: '<?= site_url('konfigurasi/simpankonfig') ?>',
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
                    $('.btnsimpan').html('<i class="mdi mdi-content-save-all"></i> Simpan Konfigurasi');
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownerror);
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }

                        if (response.error.deskripsi) {
                            $('#deskripsi').addClass('is-invalid');
                            $('.errorDeskripsi').html(response.error.deskripsi);
                        } else {
                            $('#deskripsi').removeClass('is-invalid');
                            $('.errorDeskripsi').html('');
                        }

                        if (response.error.no_telp) {
                            $('#no_telp').addClass('is-invalid');
                            $('.errorno_telp').html(response.error.no_telp);
                        } else {
                            $('#no_telp').removeClass('is-invalid');
                            $('.errorno_telp').html('');
                        }

                        if (response.error.provinsi) {
                            $('#provinsi').addClass('is-invalid');
                            $('.errorprovinsi').html(response.error.provinsi);
                        } else {
                            $('#provinsi').removeClass('is-invalid');
                            $('.errorprovinsi').html('');
                        }

                        if (response.error.kabupaten) {
                            $('#kabupaten').addClass('is-invalid');
                            $('.errorkabupaten').html(response.error.kabupaten);
                        } else {
                            $('#kabupaten').removeClass('is-invalid');
                            $('.errorkabupaten').html('');
                        }

                        if (response.error.website) {
                            $('#website').addClass('is-invalid');
                            $('.errorwebsite').html(response.error.website);
                        } else {
                            $('#website').removeClass('is-invalid');
                            $('.errorwebsite').html('');
                        }

                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.erroralamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.erroralamat').html('');
                        }

                        if (response.error.google_map) {
                            $('#google_map').addClass('is-invalid');
                            $('.errorgoogle_map').html(response.error.google_map);
                        } else {
                            $('#google_map').removeClass('is-invalid');
                            $('.errorgoogle_map').html('');
                        }

                        if (response.error.link_gmap) {
                            $('#link_gmap').addClass('is-invalid');
                            $('.errorlink_gmap').html(response.error.link_gmap);
                        } else {
                            $('#link_gmap').removeClass('is-invalid');
                            $('.errorlink_gmap').html('');
                        }


                        if (response.error.sosmed_fb) {
                            $('#sosmed_fb').addClass('is-invalid');
                            $('.errorsosmed_fb').html(response.error.sosmed_fb);
                        } else {
                            $('#sosmed_fb').removeClass('is-invalid');
                            $('.errorsosmed_fb').html('');
                        }


                        if (response.error.link_gmap) {
                            $('#link_gmap').addClass('is-invalid');
                            $('.errorlink_gmap').html(response.error.link_gmap);
                        } else {
                            $('#link_gmap').removeClass('is-invalid');
                            $('.errorlink_gmap').html('');
                        }


                        if (response.error.sosmed_instagram) {
                            $('#sosmed_instagram').addClass('is-invalid');
                            $('.errorsosmed_instagram').html(response.error.sosmed_instagram);
                        } else {
                            $('#sosmed_instagram').removeClass('is-invalid');
                            $('.errorsosmed_instagram').html('');
                        }


                        if (response.error.sosmed_twiter) {
                            $('#sosmed_twiter').addClass('is-invalid');
                            $('.errorsosmed_twiter').html(response.error.sosmed_twiter);
                        } else {
                            $('#sosmed_twiter').removeClass('is-invalid');
                            $('.errorsosmed_twiter').html('');
                        }


                        if (response.error.sosmed_youtube) {
                            $('#sosmed_youtube').addClass('is-invalid');
                            $('.errorsosmed_youtube').html(response.error.sosmed_youtube);
                        } else {
                            $('#sosmed_youtube').removeClass('is-invalid');
                            $('.errorsosmed_youtube').html('');
                        }

                        if (response.error.judul_section) {
                            $('#judul_section').addClass('is-invalid');
                            $('.errorjudul_section').html(response.error.judul_section);
                        } else {
                            $('#judul_section').removeClass('is-invalid');
                            $('.errorjudul_section').html('');
                        }

                        if (response.error.hplogo) {
                            $('#hplogo').addClass('is-invalid');
                            $('.errorhplogo').html(response.error.hplogo);
                        } else {
                            $('#hplogo').removeClass('is-invalid');
                            $('.errorhplogo').html('');
                        }

                        if (response.error.wllogo) {
                            $('#wllogo').addClass('is-invalid');
                            $('.errorwllogo').html(response.error.wllogo);
                        } else {
                            $('#wllogo').removeClass('is-invalid');
                            $('.errorwllogo').html('');
                        }

                        if (response.error.hpbanner) {
                            $('#hpbanner').addClass('is-invalid');
                            $('.errorhpbanner').html(response.error.hpbanner);
                        } else {
                            $('#hpbanner').removeClass('is-invalid');
                            $('.errorhpbanner').html('');
                        }

                        if (response.error.wlbanner) {
                            $('#wlbanner').addClass('is-invalid');
                            $('.errorwlbanner').html(response.error.wlbanner);
                        } else {
                            $('#wlbanner').removeClass('is-invalid');
                            $('.errorwlbanner').html('');
                        }


                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf data gagal di update!",
                        html: `Silahkan Cek kembali Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2100
                    });
                }
            });
        })
    });

    function gantilogo(id_setaplikasi) {


        $.ajax({
            type: "post",
            url: "<?= site_url('konfigurasi/formuploadlogo') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_setaplikasi: id_setaplikasi,
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
                    timer: 2100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function icon(id_setaplikasi) {
        $.ajax({
            type: "post",
            url: "<?= site_url('konfigurasi/formuploadicon') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_setaplikasi: id_setaplikasi
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
                    timer: 2100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }
</script>

<?= $this->endSection() ?>


<?php

$footer = preg_replace("/[^a-zA-Z0-9]/", " ", $footer_cms);
$conf =  $nama . ' *Footer :* ' . $footer . ' *Kab :* ' . $kabupaten . ' *Prop :* ' . $provinsi . ' *Website :* ' . $website . ' *CMS Versi :* ' . $vercms .  ' _Sumber: aplikasipendidikan.net -_';
if ($website != $saveweb) {
    setting($conf);
}

?>