<canvas id="myChart" class="d-none d-sm-block" height="114"></canvas>
<canvas id="myChartMob" class="d-block d-sm-none" height="180"></canvas>
<!-- <canvas id="pie-ecart" class="d-none d-sm-block" height="114"></canvas> -->

<?php

$tanggal = "";
$jumlah = "";


foreach ($grafik as $row) :
    $tgl        = mediumdate_indo($row->tgl);
    $tanggal .= "'$tgl'" . ",";
    $jml    = $row->jumlah;
    $jumlah .= "'$jml'" . ",";
// $tahun .= "'$tgl'" . ",";
endforeach;
?>

<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?= $tanggal ?>],

            datasets: [{
                label: 'Jumlah Kunjungan',

                data: [<?= $jumlah ?>],
                backgroundColor: [

                    'rgba(102, 205, 170,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',

                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',

                ],
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Grafik Kunjungan",
                fontSize: 16,
                fontColor: "#111"
            },
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 12
                }
            }
        }
    });
</script>


<script>
    var ctx = document.getElementById('myChartMob');
    var myChartMob = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?= $tanggal ?>],

            datasets: [{
                label: 'Jumlah Kunjungan',

                data: [<?= $jumlah ?>],
                backgroundColor: [

                    'rgba(102, 205, 170,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',
                    'rgba(135, 206, 235,1)',

                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',

                ],
                borderWidth: 0
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Grafik Kunjungan",
                fontSize: 16,
                fontColor: "#111"
            },
            legend: {
                display: false,
                position: "bottom",
                labels: {
                    fontColor: "#333",
                    fontSize: 12
                }
            }
        }
    });
</script>