<button type="submit" class="btn btn-success btn-sm tambah">
    <i class="fas fa fa-plus-circle"></i> Tambah Topik Baru
</button>

<hr>
<div class="table-responsive b-0 ">
    <table id="listsurveytopik" class="table table-hover table-striped">
        <thead class="">
            <tr>
                <th width="40" class="text-center"><b>#</b></th>
                <th><b>Topik Survei</b></th>
                <th width="95" class="text-center"><b>Hasil Survei</b></th>
                <th width="80" class="text-center"><b>Status</b></th>
                <th width="140" class="text-center"><b>Aksi</b></th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
                $skor = $data['skor'];
                $r1_stb = $data['r1_stb'];
                $r2_stb = $data['r2_stb'];
                $r1_kb = $data['r1_kb'];
                $r2_kb = $data['r2_kb'];
                $r1_b = $data['r1_b'];
                $r2_b = $data['r2_b'];
                $r1_sb = $data['r1_sb'];
                $r2_sb = $data['r2_sb'];

            ?>
                <tr>
                    <td class="text-center"><?= $nomor ?></td>
                    <td>
                        <a href="<?= base_url('survey/cetak/' . $data['survey_id']) ?>" target="_blank" class="text-primary" title="Cetak"><i class="fas fa-print
 text-primary font-14"></i> </a>

                        <?= esc($data['nama_survey']) ?>

                        <?php if ($skor != 0) { ?>
                            <a href="<?= base_url('survey/pesan/' . $data['survey_id']) ?>">
                                <span class="badge badge-info pointer" title="Lihat Responden" style="font-size:12px">(<?= $data['hits'] ?>) </span>
                            </a>
                        <?php } ?>

                    </td>

                    <td class="text-center">
                        <?php if ($skor != 0) { ?>

                            <?php if ($skor >= $r1_stb && $skor <= $r2_stb) { ?>
                                <span class="badge badge-danger" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_stb'] ?> (<?= $skor ?>)</span>
                            <?php  } elseif ($skor >= $r1_kb && $skor <= $r2_kb) { ?>
                                <span class="badge badge-warning" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_kb'] ?> (<?= $skor ?>)</span>

                            <?php  } elseif ($skor >= $r1_b && $skor <= $r2_b) { ?>
                                <span class="badge badge-info" title="Penilaian Akhir" style="font-size:12px"> <?= $data['ket_b'] ?> (<?= $skor ?>)</span>

                            <?php  } elseif ($skor >= $r1_sb && $skor <= $r2_sb) { ?>
                                <span class="badge badge-success" title="Penilaian Akhir" style="font-size:12px"><?= $data['ket_sb'] ?> (<?= $skor ?>)</span>

                            <?php    } ?>

                        <?php  } else { ?>
                            -
                        <?php    } ?>
                    </td>
                    <td class="text-center">
                        <?php if ($data['status'] == '1') { ?>
                            <span class="badge badge-success" style="font-size:12px">AKTIF </span>
                        <?php } else { ?>
                            <span class="badge badge-danger" style="font-size:12px">NON AKTIF </span>
                        <?php } ?>
                    </td>
                    <td class="text-center p-0">
                        <a href="<?= base_url('survey/pertanyaan/' . $data['survey_id']) ?>" title="Manajemen Pertanyaan" class="btn btn-primary btn-sm p-1">
                            <i class="fas fa-list text-light"></i></a>

                        <?php if ($akses == 1) { ?>
                            <?php if ($data['status'] == '1') { ?>
                                <button type="button" onclick="toggle('<?= $data['survey_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-light' : 'btn-success' ?>" title="<?= $data['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="fas fa-check-circle text-success"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" onclick="toggle('<?= $data['survey_id'] ?>')" class="btn btn-circle btn-sm p-1 <?= $data['status'] ? 'btn-info' : 'btn-light' ?>" title="<?= $data['status'] ? 'Non Aktifkan' : 'Aktifkan' ?>"><i class="nav-icon far fa-eye text-danger"></i>
                                </button>
                            <?php } ?>

                        <?php } ?>
                        <button type="button" class="btn btn-warning btn-sm p-1" onclick="edit('<?= $data['survey_id'] ?>')">
                            <i class="icon fas fa-edit text-light"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm p-1" onclick="hapus('<?= $data['survey_id'] ?>','<?= $data['nama_survey'] ?>')">
                            <i class="far fa-trash-alt text-light"></i>
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><b>#<b></th>
                <th><b>Topik Survei</b></th>
                <th class="text-center"><b>Hasil Survei</b></th>
                <th class="text-center"><b>Status<b></th>
                <th class="text-center"><b>Aksi<b></th>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    //aktifnonaktif

    function toggle(survey_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('survey/toggle') ?>",
            data: {
                [csrfToken]: csrfHash,
                survey_id: survey_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    listsurveytopik();
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

    function edit(survey_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('survey/formedit') ?>",
            data: {
                [csrfToken]: csrfHash,
                survey_id: survey_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
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


    $(document).ready(function() {
        $('#listsurveytopik').DataTable();
        $('.tambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('survey/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambah').modal('show');
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
        });
    });


    function hapus(survey_id, nama) {
        Swal.fire({

            title: 'Hapus data?',
            html: `Apakah anda yakin menghapus <strong>${nama}</strong> ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('survey/hapus') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        [csrfToken]: csrfHash,
                        survey_id: survey_id
                    },

                    success: function(response) {
                        if (response.sukses) {
                            toastr["success"](response.sukses)
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
                                listsurveytopik();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownerror) {
                        Swal.fire({
                            title: "Maaf gagal hapus data!",
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
        })
    }
</script>