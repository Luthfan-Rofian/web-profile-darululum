<?= $this->extend('/admin/template-backend') ?>
<?= $this->extend('/admin/menu') ?>
<?= $this->section('script') ?>


<script <?= csp_script_nonce() ?>>
    let csrfToken = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';

    $('a#logout').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('login/logout') ?>",
                    type: 'post',
                    data: {
                        [csrfToken]: csrfHash,
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Anda berhasil keluar!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1250
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                        });
                    }
                });
            }
        })
    })
</script>

<?= $this->endSection('script') ?>