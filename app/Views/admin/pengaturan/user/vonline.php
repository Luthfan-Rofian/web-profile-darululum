<div id="viewonline">

    <?php
    $dir = "./writable/session/";  //Sesuaikan Folder nya

    // membuka folder direktori
    $open    = opendir($dir) or die('Folder tidak ditemukan ...!');
    // $open = opendir($dir, "a");
    while ($file    = readdir($open)) {
        if ($file != '.' && $file != '..') {
            $files[] = $file;
        }
    }
    // menghitung jumlah file
    $jumlah_file    = count($files);

    use App\Models\M_Dge_grupakses;

    $this->grupakses = new M_Dge_grupakses();

    $db = \Config\Database::connect();
    $id_grup = session()->get('id_grup');
    $userid = session()->get('id');

    $list = $db->table('users')->where('id', $userid)->get()->getRowArray();
    $listgrupno = $db->table('cms__usergrup')->where('id_grup', $id_grup)->get()->getRowArray();

    if ($listgrupno) {
        $role = $listgrupno['nama_grup'];
    } else {
        $role = '-';
    }

    $gm = 'Pengaturan';

    $listgrupakses =  $this->grupakses->grupaksessubmenu($id_grup, $gm);
    if ($listgrupakses) {

        foreach ($listgrupakses as $data) :

            $akses = $data['akses'];

            if ($akses == '1') {

                if ($data['urlmenu'] == 'user') { ?>
                    <!-- <div class="card-header bg-white border-0 ">
                        <h4 class="header-title ">TERAKHIR LOGIN</h4>
                        <hr>
                    </div>-->
                    <h6 class="header-title border-bottom p-2">Riwayat Login Terakhir</h6>
                    <div class="card-body pt-2">

                        <?php if ($user) {
                            foreach ($user as $data) :
                                $id_grupr = $data['id_grup'];
                                $listgrup = $db->table('cms__usergrup')->where('id_grup', $id_grupr)->get()->getRowArray();

                                if ($listgrup) {
                                    $namagrup = $listgrup['nama_grup'];
                                } else {
                                    $namagrup = '-';
                                }
                                $blnk = date('m', strtotime($data["last_login"]));
                                $blnck = bulan($blnk);
                                $tglk = date('d', strtotime($data["last_login"]));
                                $thnk = date('Y', strtotime($data["last_login"]));
                                $jamk = date('H:i:s', strtotime($data["last_login"]));
                                if ($data['user_image'] != 'default.png' && file_exists('public/img/user/' . $data['user_image'])) {
                                    $profil = $data['user_image'];
                                } else {
                                    $profil = 'default.png';
                                }
                        ?>
                                <div class="row no-gutters pt-0">
                                    <div class="col-3 col-sm-2">
                                        <a href="<?= base_url('user') ?>">
                                            <img src="<?= base_url('public/img/user/' . $profil) ?>" class="img-fluid rounded" />
                                        </a>
                                    </div>
                                    <div class="col-9 col-sm-10 pl-3">
                                        <b>
                                            <?php if ($data['sts_on'] == 1) { ?>
                                                <a title="<?= $data['fullname'] ?> Sedang Online" href="<?= base_url('user') ?>">
                                                    <i class="mdi mdi-checkbox-blank-circle text-success"></i>
                                                    <?= $data['fullname'] ?>
                                                </a>
                                            <?php } else { ?>
                                                <a title="<?= $data['fullname'] ?> Offline" href="<?= base_url('user') ?>">
                                                    <i class="mdi mdi-checkbox-blank-circle text-warning"></i>
                                                    <?= $data['fullname'] ?>
                                                </a>
                                            <?php } ?>

                                        </b>
                                        <small class="mb-0 text-sm text-muted">
                                            <?= $namagrup ?>
                                        </small>

                                        <?php if ($data['last_login'] != '') { ?>
                                            <label class="text-warning" title="Login terakhir"><small> <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></small></label>

                                        <?php } ?>
                                    </div>
                                </div>
                                <hr class="mt-2 mb-1" />

                            <?php endforeach; ?>


                            <div class="text-center">
                                <a href="<?= base_url('user') ?>" type="button" class="btn btn-primary btn-sm">
                                    <i class="fas fa-list-ul"></i> User All
                                </a>
                                <button type="button" class="btn btn-warning btn-sm waves-effect waves-light refresh" title="Klik disini untuk OFFkan status Online bila pengguna keluar tanpa Logoff." onclick="reseton('')">
                                    <i class="mdi mdi-account-convert text-light"></i> Reset
                                </button>
                                <?php if ($jumlah_file > 50) { ?>
                                    <button type="button" class="btn btn-danger btn-sm waves-effect waves-light delfile" title="Klik disini untuk hapus file session." onclick="hapusfile('')">
                                        <i class="mdi mdi-recycle text-light"></i> Hapus <?= $jumlah_file ?> File
                                    </button>
                                <?php } else {  ?>
                                    <button type="button" class="btn btn-light btn-sm waves-effect waves-light" title="Jumlah File yang ada di folder session.">
                                        <i class="mdi mdi-restore"></i> <?= $jumlah_file ?> File session
                                    </button>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
        <?php }
            }
        endforeach;
    } else { ?>
        <?php if ($useron) { ?>

            <h6 class="header-title border-bottom p-2">Pengguna Terautentikasi</h6>

        <?php } ?>
        <div class="card-body pt-1">

            <!-- jika ada yg online selain dia -->

            <?php if ($useron) {
                foreach ($useron as $data) :
                    $id_grupr = $data['id_grup'];
                    $listgrup = $db->table('cms__usergrup')->where('id_grup', $id_grupr)->get()->getRowArray();

                    if ($listgrup) {
                        $namagrup = $listgrup['nama_grup'];
                    } else {
                        $namagrup = '-';
                    }
                    $blnk = date('m', strtotime($data["last_login"]));
                    $blnck = bulan($blnk);
                    $tglk = date('d', strtotime($data["last_login"]));
                    $thnk = date('Y', strtotime($data["last_login"]));
                    $jamk = date('H:i:s', strtotime($data["last_login"]));

                    if ($data['user_image'] != 'default.png' && file_exists('public/img/user/' . $data['user_image'])) {
                        $profil = $data['user_image'];
                    } else {
                        $profil = 'default.png';
                    }

            ?>
                    <div class="row no-gutters pt-0">
                        <div class="col-3 col-sm-2">
                            <a>
                                <img src="<?= base_url('public/img/user/' . $profil) ?>" class="img-fluid rounded" />
                            </a>
                        </div>
                        <div class="col-9 col-sm-10 pl-3">
                            <b>
                                <?php if ($data['sts_on'] == 1) { ?>
                                    <a title="<?= $data['fullname'] ?> Sedang Online">
                                        <i class="mdi mdi-checkbox-blank-circle text-success"></i>
                                        <?= $data['fullname'] ?>
                                    </a>
                                <?php } else { ?>
                                    <a title="<?= $data['fullname'] ?> Offline">
                                        <i class="mdi mdi-checkbox-blank-circle text-warning"></i>
                                        <?= $data['fullname'] ?>
                                    </a>
                                <?php } ?>

                            </b>
                            <small class="mb-0 text-sm text-muted">
                                <?= $namagrup ?>
                            </small>

                            <?php if ($data['last_login'] != '') { ?>
                                <label class="text-warning" title="Login terakhir"><small> <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></small></label>
                            <?php } ?>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php } else {
                $blnk = date('m', strtotime($list["last_login"]));
                $blnck = bulan($blnk);
                $tglk = date('d', strtotime($list["last_login"]));
                $thnk = date('Y', strtotime($list["last_login"]));
                $jamk = date('H:i:s', strtotime($list["last_login"]));

                if ($list['user_image'] != 'default.png' && file_exists('public/img/user/' . $list['user_image'])) {
                    $profil2 = $list['user_image'];
                } else {
                    $profil2 = 'default.png';
                }

            ?>

                <!-- Jika tidak ada online -->
                <div class="row no-gutters pt-2">
                    <div class="col-3 col-sm-2">
                        <a href="<?= base_url('user') ?>">
                            <img src="<?= base_url('public/img/user/' . $profil2) ?>" class="img-fluid rounded" />
                        </a>
                    </div>
                    <div class="col-9 col-sm-10 pl-3">
                        <b>

                            <a title="Edit Akun" href="<?= base_url('akun') ?>">
                                <?php if ($list['sts_on'] == 1) { ?>
                                    <i class="mdi mdi-checkbox-blank-circle text-success"></i>
                                <?php } ?>
                                <?= $list['fullname'] ?>
                            </a>

                        </b>

                        <small class="mb-0 text-sm text-muted">
                            <?= $role ?>
                        </small>

                        <?php if ($list['last_login'] != '') { ?>
                            <label class="text-warning"><small> <?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></small></label>
                        <?php } ?>
                    </div>

                </div>

        <?php }
        } ?>

        <!-- MOHON TIDAK MENGHAPUS INFORMASI INI UNTUK KEMUDAHAN DALAM UPDATE SYSTEM -->

        <hr class="mt-0" />

        <div class="border-bottom m-auto">

            <label class="d-block text-muted mb-0 text-center"> <i class="mdi mdi-console"></i> Darul Ulum IT Hub — CMS Pesantren Official <?= $vercms ?></label>
            <p class="text-center"><a href="https://ponpes-darululumtlasih.com" class="text-danger" style="font-size: 12px;">Terakhir Diupdate 18 Desember 2025</a>
                <a class="d-block text-primary mb-0 text-center" style="font-size: 13px;"> Tema Terpasang <i><?= $template['nama'] ?></i></a>
                <? $kunjungan ?>

            <div class="mt-0 bg-light">

                <table class="ml-3" width='100%' border='0' valign='center' style="font-size: 12px;">
                    <tbody>
                        <tr>
                            <td style='color:Goldenrod' align='left' valign='middle'><i class="fas fa-signal"></i> Kunjungan Bulan ini </td>
                            <td align='right' valign='middle'></td>
                            <td style='color:Goldenrod' align='left' valign='middle'> : <?= $pengunjungblnini ?></td>
                        </tr>

                        <tr>
                            <td style='color:blueviolet' width='98' align='left' valign='middle'><i class="fas fa-users"></i> Total Kunjungan</td>
                            <td align='right' valign='middle'></td>
                            <td style='color:blueviolet' width='138' align='left' valign='middle'>: <?= $totkunjungan ?></td>
                        </tr>

                        <tr>
                            <td class="text-success" width='150' align='left' valign='middle'><i class="fas fa-user-clock"></i> Pengguna Aktif</td>
                            <td align='right' valign='middle'></td>
                            <td class="text-success" width='138' align='left' valign='middle'>: <b><?= $pengunjungon ?></b> Jumlah Pengguna</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            </p>

        </div>
        </div>
</div>

<script>
    function reseton() {

        $.ajax({

            url: "<?= site_url('admin/offuser') ?>",
            dataType: "json",

            beforeSend: function() {

                $('.refresh').attr('disable', 'disable');
                $('.refresh').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            complete: function() {
                $('.refresh').removeAttr('disable', 'disable');
                $('.refresh').html('<i class="mdi mdi-account-convert text-light"></i>  Reset Status');
            },

            success: function(response) {
                $('.viewonline').html(response.data);
                // window.location = '';
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                });
            }
        });


    }

    function hapusfile() {

        $.ajax({

            url: "<?= site_url('admin/hapusfile') ?>",
            dataType: "json",

            beforeSend: function() {

                $('.delfile').attr('disable', 'disable');
                $('.delfile').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>On Proses...</i>');
            },
            complete: function() {
                $('.delfile').removeAttr('disable', 'disable');
                $('.delfile').html('<i class="mdi mdi-recycle text-light"></i> Hapus File');
            },

            success: function(response) {
                $('.viewonline').html(response.data);
                window.location = '';
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Ada kesalahan Kode Error: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                });
            }
        });


    }
</script>