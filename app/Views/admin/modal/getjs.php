<script>
    let csrfToken = '<?= csrf_token() ?>';
    let csrfHash = '<?= csrf_hash() ?>';



    $('.tambahkritik').click(function(e) {

        e.preventDefault();

        $.ajax({
            url: "<?= site_url('kritiksaran/formkritik') ?>",
            dataType: "json",
            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modalview').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    });


    $('.btnlihatpoling').click(function(e) {

        e.preventDefault();

        $.ajax({

            url: "<?= site_url('poling/lihatpoling') ?>",
            dataType: "json",

            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal({
                    // backdrop: 'static',
                    // keyboard: false
                });

                $('#modalview').modal('show');
                $('body').removeClass("modal-open");
            },
            error: function(xhr, ajaxOptions, thrownerror) {

                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    });

    //view infografis-----------
    function lihatinfo(id_banner) {

        $.ajax({
            type: "post",
            url: "<?= base_url('infografis/formlihatinfo') ?>",
            data: {
                [csrfToken]: csrfHash,
                id_banner: id_banner
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    // html: `Silahkan coba kembali Error Code: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    //view foto-----------
    function lihatfoto(foto_id, nama_kategori_foto) {

        $.ajax({
            type: "post",
            url: "<?= base_url('foto/formlihatfoto') ?>",
            data: {
                [csrfToken]: csrfHash,
                foto_id: foto_id,
                nama_kategori_foto: nama_kategori_foto
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        // backdrop: 'static',
                        // keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    //view agenda-----------
    function lihatagenda(agenda_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('agenda/formlihatagenda') ?>",
            data: {
                [csrfToken]: csrfHash,
                agenda_id: agenda_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    //view layanan-----------
    function lihatlayanan(informasi_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('layanan/formlihatlayanan') ?>",
            data: {
                [csrfToken]: csrfHash,
                informasi_id: informasi_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false

                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }



    //view pengumuman-----------
    function lihatpengumuman(informasi_id) {

        $.ajax({
            type: "post",
            url: "<?= base_url('pengumuman/formlihatpengumuman') ?>",
            data: {
                [csrfToken]: csrfHash,
                informasi_id: informasi_id
            },
            dataType: "json",

            success: function(response) {
                if (response.sukses) {

                    $('.viewmodal').html(response.sukses).show();
                    $('#modalview').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modalview').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    //bank data
    function updatehits(bankdata_id) {

        $.ajax({
            url: "<?= site_url('bankdata/getbankdata') ?>",
            data: {
                [csrfToken]: csrfHash,
                bankdata_id: bankdata_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }

        });
    }

    // Ebook

    function lihatbook(ebook_id, kategoriebook_nama) {

        $.ajax({
            type: "post",
            url: "<?= site_url('ebook/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id,
                kategoriebook_nama: kategoriebook_nama,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal('show');
                    $('body').removeClass("modal-open");
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    //ebook data
    function updatehit(ebook_id) {

        $.ajax({
            url: "<?= site_url('ebook/getebook') ?>",
            data: {
                [csrfToken]: csrfHash,
                ebook_id: ebook_id
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);

            }

        });
    }

    //LIKE POSTING BERITA
    function likeposting(berita_id) {

        $.ajax({
            url: "<?= site_url('berita/likeposting') ?>",
            data: {
                [csrfToken]: csrfHash,
                berita_id: berita_id
            },
            dataType: "json",
            success: function(response) {

                if (response.sukses) {

                    Swal.fire({
                        title: "Sukses!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1550
                    }).then(function() {
                        // window.location = '';
                    });
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
    }

    function likepostingvid(video_id) {

        $.ajax({
            url: "<?= site_url('video/likevideo') ?>",
            data: {
                [csrfToken]: csrfHash,
                video_id: video_id
            },
            dataType: "json",
            success: function(response) {

                if (response.sukses) {

                    Swal.fire({
                        title: "Sukses!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1550
                    }).then(function() {
                        // window.location = '';
                    });
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
    }

    //lihat pegawai
    function lihatpegawai(pegawai_id) {

        $.ajax({
            type: "post",
            url: "<?= site_url('pegawai/formlihat') ?>",
            data: {
                [csrfToken]: csrfHash,
                pegawai_id: pegawai_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modallihat').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#modallihat').modal('show');
                    $('body').removeClass("modal-open");

                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    window.location = '';
                })
            }
        });
    }

    function penawaran() {

        $.ajax({
            type: "post",
            url: "<?= site_url('home/penawaran22') ?>",
            dataType: "json",
            data: {
                [csrfToken]: csrfHash,
            },
            success: function(response) {
                $('.viewmodal').html(response.data).show();
                $('#modalview').modal('show');
                $('body').removeClass("modal-open");

            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                });
            }
        });
    }

    function LihatOnline() {
        $.ajax({
            type: "post",
            url: "<?= site_url('home/cekpengunjung') ?>",
            dataType: "json",
            data: {
                [csrfToken]: csrfHash,
            },
            beforeSend: function() {
                $('.viewonline').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },

            success: function(response) {
                if (response.data) {
                    $('.viewonline').html(response.data);

                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data Pengunjung ONline!",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 3100
                }).then(function() {
                    // window.location = '';
                })
            }
        });
    }
</script>