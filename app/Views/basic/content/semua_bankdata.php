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
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">

                                    <div class="title-konten text-uppercase">bank data</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <!-- ISI KONTEN -->
                                    <div class="mt-3">

                                        <table id="datatable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="15"># </th>
                                                    <th>Nama File</th>
                                                    <th>Tgl Posting</th>
                                                    <th width="65" class="text-center"># </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nomor = 0;
                                                foreach ($list as $data) :
                                                    $nomor++; ?>
                                                    <tr>
                                                        <td><?= $nomor ?></td>
                                                        <td><?= esc($data['nama_bankdata']) ?></td>
                                                        <td><?= date_indo($data['tgl_upload']) ?></td>
                                                        <td class="text-center p-1">
                                                            <a href="<?= base_url('public/unduh/bankdata/'  . $data['fileupload']) ?>" target="_blank"><button class="btn btn-success btn-sm" onclick="updatehits('<?= $data['bankdata_id'] ?>')"><i class="fas fa-download"></i> Download</button></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama File</th>
                                                    <th>Tgl Posting</th>
                                                    <th class="text-center"># </th>

                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>


                                    <br>
                                    <hr>

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
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updatehits(bankdata_id) {

        $.ajax({
            url: "<?= site_url('bankdata/getbankdata') ?>",
            data: {
                bankdata_id: bankdata_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }
</script>

<?= $this->endSection() ?>