<?php
$db = \Config\Database::connect();

?>
<?= $this->extend('' . $folder . '/' . 'template-frontend') ?>
<?= $this->extend('' . $folder . '/' . 'v_menu') ?>
<?= $this->section('content') ?>

<div class="page-title-box">
    <div class="container-fluid">

    </div>
</div>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <!-- ISI KONTEN -->
                    <div class="row pt-2 pb-3">
                        <div class="col-md-8">

                            <div class="title-konten text-uppercase">peta situs</div>

                            <!-- ++++++ DETAIL KONTEN +++++++++++ -->
                            <div class="entry-content p-3">

                                <?php foreach ($mainmenu as $utama) {
                                    $menu_id = $utama['menu_id'];
                                ?>
                                    <div class="list-group mt-1">
                                        <?php
                                        if ($utama['parent'] == 'N') {
                                            if ($utama['linkexternal'] == 'N') { ?>
                                                <li class="list-group-item list-group-item-action"><a target="<?= $utama['target'] ?>" href="<?= base_url($utama['menu_link']) ?>">
                                                        <i class="<?= $utama['icon'] ?>"></i> <?= $utama['nama_menu'] ?> </a></li>
                                            <?php } else { ?>
                                                <li class="list-group-item list-group-item-action"><a target="<?= $utama['target'] ?>" href="<?= $utama['menu_link'] ?>"> <i class="<?= $utama['icon'] ?>"></i> <?= $utama['nama_menu'] ?> </a></li>
                                            <?php  }
                                        }
                                        $set = $db->table('submenu')
                                            ->where('menu_id', $menu_id)
                                            ->where('stssubmenu', 1)
                                            ->orderBy('urutansm', 'ASC')->get()->getResultArray();
                                        if ($utama['parent'] == 'Y') { ?>
                                            <li class="list-group-item list-group-item-action">
                                                <a><i class="<?= $utama['icon'] ?>"></i><?= $utama['nama_menu'] ?> <i class="fas fa-caret-down"></i></a>
                                                <ul>
                                                    <?php foreach ($set as $submenu) {

                                                        if ($submenu['linkexternalsm'] == 'N') {
                                                            $linksm = base_url($submenu['link_submenu']);
                                                        } else {
                                                            $linksm = ($submenu['link_submenu']);
                                                        }

                                                    ?>
                                                        <?php if ($submenu['parentsm'] == 'Y') {
                                                            $setsubsub = $db->table('subsubmenu')->where('submenu_id', $submenu['submenu_id'])->where('stsssm', 1)
                                                                ->orderBy('urutanssm', 'ASC')->get()->getResultArray();
                                                        ?>

                                                            <li class="list-group-item list-group-item-action p-2">
                                                                <a href="<?= $linksm ?>"><i class="<?= $submenu['iconsm'] ?>"></i> <?= $submenu['nama_submenu'] ?> <i class="fas fa-caret-down"></i></a>
                                                                <ul>
                                                                    <?php foreach ($setsubsub as $subsubmenu) {

                                                                        if ($subsubmenu['linkexternalssm'] == 'N') {
                                                                            $linkssm = base_url($subsubmenu['link_subsubmenu']);
                                                                        } else {
                                                                            $linkssm = ($subsubmenu['link_subsubmenu']);
                                                                        }
                                                                    ?>
                                                                        <li class="list-group-item list-group-item-action p-2"><a target="<?= $subsubmenu['targetssm'] ?>" href="<?= $linkssm ?>"><i class="<?= $subsubmenu['iconssm'] ?>"></i> <?= $subsubmenu['nama_subsubmenu'] ?> </a></li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>




                                                        <?php } else { ?>
                                                            <li class="list-group-item list-group-item-action p-2"><a target="<?= $submenu['targetsm'] ?>" href="<?= $linksm ?>"><i class="<?= $submenu['iconsm'] ?>"></i> <?= $submenu['nama_submenu'] ?> </a></li>
                                                        <?php } ?>

                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php $settop = $db->table('menu')->where('posisi', '1')->where('stsmenu', 1)
                                    ->orderBy('urutan', 'ASC')->get()->getResultArray(); ?>
                                <?php foreach ($settop as $topmenu) {
                                    if ($topmenu['linkexternal'] == 'N') {
                                        $linktop = base_url($topmenu['menu_link']);
                                    } else {
                                        $linktop = ($topmenu['menu_link']);
                                    }
                                ?>
                                    <div class="list-group mt-1">
                                        <li class="list-group-item list-group-item-action"><a target="<?= $topmenu['target'] ?>" href="<?= $linktop ?>"><i class="<?= $topmenu['icon'] ?>"></i> <?= $topmenu['nama_menu'] ?> <a class="text-warning">(Top Menu)</a></a></li>
                                    </div>
                                <?php } ?>

                                <?php $setfot = $db->table('menu')
                                    ->where('posisi', '2')
                                    ->where('stsmenu', 1)
                                    ->orderBy('urutan', 'ASC')->get()->getResultArray(); ?>
                                <?php foreach ($setfot as $fm) {
                                    if ($fm['linkexternal'] == 'N') { ?>
                                        <div class="list-group mt-1">
                                            <li class="list-group-item list-group-item-action"><a target="<?= $fm['target'] ?>" href="<?= base_url($fm['menu_link']) ?>"><i class="<?= $fm['icon'] ?>"></i> <?= $fm['nama_menu'] ?> </a></li>

                                        <?php } else { ?>
                                            <li class="list-group-item list-group-item-action"><a target="<?= $fm['target'] ?>" href="<?= $fm['menu_link'] ?>"><i class="<?= $fm['icon'] ?>"></i> <?= $fm['nama_menu'] ?> </a></li>
                                        <?php  } ?>

                                        </div>
                                    <?php } ?>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="row pb-3">
                                <div class="col-md-12">
                                    <div class="caption">Berita Terpopuler</div>
                                </div>
                            </div>

                            <!-- BERITA SIDEBAR -->
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $nomor = 0;
                                    foreach ($beritapopuler as $data) :
                                        $nomor++; ?>

                                        <div class="card border-light mb-3">
                                            <div class="row no-gutters">
                                                <div class="col-md-3 col-4 wraper-img-side">
                                                    <img class="wraper-img-side" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
                                                </div>

                                                <div class="col-md-9 col-8 pl-3">
                                                    <a class="judul-side" href="<?php echo base_url('detail/' . $data['slug_berita']) ?>">
                                                        <div><?= $data['judul_berita'] ?></div>
                                                    </a>
                                                    <div class="post-side pt-2">
                                                        <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                        <i class="fa fa-eye"></i> <?= $data['hits'] ?> Kali
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>