<style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    input[type="number"] {
        min-width: 50px;
    }
</style>


<?php if ($transparan) { ?>


    <figure class="highcharts-figure">
        <div id="container"></div>

    </figure>
    <div style="display:none">
        <table id="datatable" class="p-0">
            <thead>
                <tr>
                    <th></th>
                    <th>Realisasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($transparan as $row) {
                    echo "<tr> 
                <th>" . $row['transparan_nama'] . "</th>
                     <td>$row[transparan_jumlah]</td>
                   </tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

<?php } else { ?>
    <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
        <a style='color:red'>Maaf data tidak ditemukan..!</a>
    </div>
<?php } ?>


<?php if ($transparan) {
    foreach ($transparan as $row) {

        $judul = $row['judul'];
    }
} else {
    $judul = "";
} ?>

<script>
    $(function() {
        $('#container').highcharts({

            data: {
                table: 'datatable'
            },
            chart: {
                type: 'pie'
            },

            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },


            legend: {

                borderWidth: 1,
                borderRadius: 5
            },

            title: {
                text: '<b><?= $judul ?></b>'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: ''
                }
            },


            // tooltip: {
            //     pointFormat: '{series.name}: <b>{point.y} ({point.percentage:.1f}%)</b>'
            // },

            tooltip: {
                pointFormat: '<span>{series.name}</span>: <b>{point.percentage:.1f}%</b> ({point.y:,.0f})<br/>',
                split: true
            },



        });
    });
</script>