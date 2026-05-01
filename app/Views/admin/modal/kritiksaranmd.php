<div class="modal fade" id="modalview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header p-1">
                <h6 class="modal-title m-0"><?= $title  ?>
                    <?php if ($konfigurasi['verbost'] == 0) { ?>
                        <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-dismiss="modal" aria-label="Close"><span>X</span></button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-sm btn-danger float-right btn-modal-close" data-bs-dismiss="modal" aria-label="Close"><span>X</span></button>
                    <?php } ?>
                </h6>
            </div>
            <?= form_open('kritiksaran/simpankritik', ['class' => 'formkritik']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                            <tr>
                                <td colspan="2"><strong><?= $konfigurasi['nama'] ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">Untuk alasan tertentu Anda tidak puas dengan layanan kami,
                                    Anda dapat menyampaikan masukan atau saran dibawah! <br><a class="text-info">Tanggapan akan dikirim ke Email Anda.</a></td>
                            </tr>

                            <tr>
                                <td>Nama</td>
                                <td>
                                    <input type="text" id="nama" name="nama" class="form-control form-control-sm">
                                    <div class="invalid-feedback errornama"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Aktif</td>
                                <td>
                                    <input type="text" id="email" name="email" class="form-control form-control-sm">
                                    <div class="invalid-feedback erroremail"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>No Hp</td>
                                <td>
                                    <input type="text" id="no_hpusr" name="no_hpusr" class="form-control form-control-sm" value="+62">
                                    <div class="invalid-feedback errorno_hpusr"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Topik</td>
                                <td>
                                    <!-- <input type="text" id="judul" name="judul" class="form-control form-control-sm"> -->

                                    <select class="form-control" name="judul" id="judul">
                                        <option Disabled=true Selected=true>-- Pilih Topik --</option>
                                        <option value="Pengaduan">Pengaduan</option>
                                        <option value="Aspirasi">Aspirasi</option>
                                        <option value="Permintaan Informasi">Permintaan Informasi</option>
                                    </select>

                                    <div class="invalid-feedback errorjudul"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Isi</td>
                                <td>
                                    <textarea type="text" id="isi_kritik" name="isi_kritik" class="form-control form-control-sm"></textarea>
                                    <div class="invalid-feedback errorisi_kritik"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer p-0">
                    <button type="submit" class="btn btn-primary btnkritik"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>

                    <?php if ($konfigurasi['verbost'] == 0) { ?>
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal">Batal </button>
                    <?php } else { ?>
                        <button type="button" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">Batal </button>
                    <?php } ?>

                </div>

            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.formkritik').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnkritik').prop('disable', true);
                    $('.btnkritik').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

                },
                complete: function() {
                    $('.btnkritik').prop('disable', false);
                    $('.btnkritik').html('Kirim Pesan')
                    $('.btnkritik').html('<i class="fas fa-paper-plane"></i>  Kirim Pesan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html();
                            $('#nama').addClass('is-valid');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html();
                            $('#email').addClass('is-valid');
                        }

                        if (response.error.no_hpusr) {
                            $('#no_hpusr').addClass('is-invalid');
                            $('.errorno_hpusr').html(response.error.no_hpusr);
                        } else {
                            $('#no_hpusr').removeClass('is-invalid');
                            $('.errorno_hpusr').html();
                            $('#no_hpusr').addClass('is-valid');
                        }

                        if (response.error.judul) {
                            $('#judul').addClass('is-invalid');
                            $('.errorjudul').html(response.error.judul);
                        } else {
                            $('#judul').removeClass('is-invalid');
                            $('.errorjudul').html();
                            $('#judul').addClass('is-valid');
                        }

                        if (response.error.isi_kritik) {
                            $('#isi_kritik').addClass('is-invalid');
                            $('.errorisi_kritik').html(response.error.isi_kritik);
                        } else {
                            $('#isi_kritik').removeClass('is-invalid');
                            $('.errorisi_kritik').html();
                            $('#isi_kritik').addClass('is-valid');
                        }

                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: "Terima Kasih!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 4550
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal mengirim data!",
                        html: `Silahkan coba kembali Error Code: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
            return false;
        });
    });
</script>