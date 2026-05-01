<div class="modal fade" id="modalview" tabindex="-1" aria-labelledby="modalviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header p-2 bg-warning">
                <h6 class="modal-title" id="modalviewLabel"><?= $list['judultawaran'] ?></h6>
            </div>

            <div class="modal-body">
                <img class="img-fluid" src="<?= base_url('public/img/konfigurasi/pimpinan/' . $list['gbrtawaran']) ?>" alt="">
                <?= $list['isitawaran'] ?>
            </div>

            <div class="modal-footer p-1">
                <?php if ($list['sts_tombol'] != 0) { ?>
                    <a href="<?= $list['linktawaran'] ?>" class="btn btn-primary"><?= $list['namatombol'] ?></a>
                <?php  } ?>
                <?php if ($konfigurasi['verbost'] == 0) { ?>
                    <a class="btn btn-danger text-light" data-dismiss="modal" onclick="nonaktifpenawaran()">Jangan Tampilkan lagi</a>
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="nonaktifpenawaran()">Jangan tampilkan lagi</button> -->
                <?php } else { ?>
                    <a class="btn btn-danger text-light" data-bs-dismiss="modal" onclick="nonaktifpenawaran()">Jangan Tampilkan lagi</a>
                    <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="nonaktifpenawaran()">Jangan tampilkan lagi</button> -->

                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    function nonaktifpenawaran() {
        $.ajax({
            url: "<?= site_url('home/nonaktiftawaran') ?>",
            dataType: "json",
            success: function(response) {
                // $('.viewdata2').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                    thrownerror);
            }
        });
    }
</script>