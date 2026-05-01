<?= $this->section('content') ?>
<?= $this->extend('admin/script') ?>

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">

        </div>
    </div>
</div>

<div class="page-content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card m-b-20">

                <div class="card-header font-18 bg-light">
                    <h6 class="modal-title mt-0">
                        <i class="mdi mdi-google-analytics"></i> Informasi Pengunjung
                    </h6>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div>
                        <div>
                            <div style="float: right;margin: -4px 20px 0 5px;">
                                <form id="select_month_year" style="margin: 0;padding: 0;" method="post">
                                    <?= csrf_field() ?>
                                    <?= generate_months() . '  ' . generate_years(); ?>
                                    <input type="button" name="submit" id="chart_submit_btn" value="Get Data" />
                                </form>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function() {
                                var chart;
                                $(document).ready(function() {
                                    Highcharts.setOptions({
                                        colors: ['#32353A']
                                    });
                                    chart = new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'month_year_container',
                                            type: 'column',
                                            margin: [50, 30, 80, 60]
                                        },
                                        title: {
                                            text: 'Kunjungan'
                                        },
                                        xAxis: {
                                            categories: [
                                                <?php
                                                $i = 1;
                                                $count = count($chart_data_curr_month);
                                                foreach ($chart_data_curr_month as $data) {
                                                    if ($i == $count) {
                                                        echo "'" . $data->day . "'";
                                                    } else {
                                                        echo "'" . $data->day . "',";
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            ],
                                            labels: {
                                                rotation: -45,
                                                align: 'right',
                                                style: {
                                                    fontSize: '9px',
                                                    fontFamily: 'Tahoma, Verdana, sans-serif'
                                                }
                                            }
                                        },
                                        yAxis: {
                                            min: 0,
                                            title: {
                                                text: 'Kunjungan'
                                            }
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        tooltip: {
                                            formatter: function() {
                                                return '<b>' + this.x + '</b><br/>' +
                                                    'Kunjungan: ' + Highcharts.numberFormat(this.y, 0);
                                            }
                                        },
                                        series: [{
                                            name: 'Kunjungan',
                                            data: [
                                                <?php
                                                $i = 1;
                                                $count = count($chart_data_curr_month);
                                                foreach ($chart_data_curr_month as $data) {
                                                    if ($i == $count) {
                                                        echo $data->visits;
                                                    } else {
                                                        echo $data->visits . ",";
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            ],
                                            dataLabels: {
                                                enabled: false,
                                                rotation: 0,
                                                color: '#F07E01',
                                                align: 'right',
                                                x: -3,
                                                y: 20,
                                                formatter: function() {
                                                    return this.y;
                                                },
                                                style: {
                                                    fontSize: '11px',
                                                    fontFamily: 'Verdana, sans-serif'
                                                }
                                            },
                                            pointWidth: 20
                                        }]
                                    });
                                });
                            });
                        </script>
                        <script type="text/javascript">
                            $("#chart_submit_btn").click(function(e) {
                                // get the token value
                                var cct = $("input[name=csrf_token_name]").val();
                                //reset #container
                                $('#month_year_container').html('');
                                $.ajax({
                                    url: "<?= site_url('visitorcontroller/get_chart_data') ?>", //The url where the server req would we made.
                                    //async: false,
                                    type: "POST", //The type which you want to use: GET/POST
                                    data: $('#select_month_year').serialize(), //The variables which are going.
                                    dataType: 'html', //Return data type (what we expect).
                                    csrf_token_name: cct,
                                    success: function(response) {
                                        if (response.toLowerCase().indexOf("no data found") >= 0) {
                                            $('#month_year_container').html(response);
                                        } else {
                                            //build the chart
                                            var tsv = response.split(/n/g);
                                            var count = tsv.length - 1;
                                            var cats_val = new Array();
                                            var visits_val = new Array();
                                            for (i = 0; i < count; i++) {
                                                var line = tsv[i].split(/t/);
                                                var line_data = line.toString().split(",");
                                                var date = line_data[0];
                                                var visits = line_data[1];
                                                cats_val[i] = date;
                                                visits_val[i] = parseInt(visits);
                                            }
                                            var _categories = cats_val;
                                            var _data = visits_val;
                                            var chart;
                                            $(document).ready(function() {
                                                Highcharts.setOptions({
                                                    colors: ['#32353A']
                                                });
                                                chart = new Highcharts.Chart({
                                                    chart: {
                                                        renderTo: 'month_year_container',
                                                        type: 'column',
                                                        margin: [50, 30, 80, 60]
                                                    },
                                                    title: {
                                                        text: 'Kunjungan'
                                                    },
                                                    xAxis: {
                                                        categories: _categories,
                                                        labels: {
                                                            rotation: -45,
                                                            align: 'right',
                                                            style: {
                                                                fontSize: '9px',
                                                                fontFamily: 'Tahoma, Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Kunjungan'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        formatter: function() {
                                                            return '<b>' + this.x + '</b><br/>' +
                                                                'Kunjungan: ' + Highcharts.numberFormat(this.y, 0);
                                                        }
                                                    },
                                                    series: [{
                                                        name: 'Kunjungan',
                                                        data: _data,
                                                        dataLabels: {
                                                            enabled: false,
                                                            rotation: 0,
                                                            color: '#F07E01',
                                                            align: 'right',
                                                            x: -3,
                                                            y: 20,
                                                            formatter: function() {
                                                                return this.y;
                                                            },
                                                            style: {
                                                                fontSize: '11px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        },
                                                        pointWidth: 20
                                                    }]
                                                });
                                            });
                                        }
                                    }
                                });
                            });
                        </script>
                        <div id="month_year_container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                    </div>


                    <div class="viewdata">
                    </div>
                </div>

                <div class="viewmodal">
                </div>

                <!-- /.card-body -->
            </div>

        </div>

    </div>

    <script>
        function listvisitor() {
            $.ajax({
                url: "<?= site_url('visitor/getdata') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewdata').html(response.data);
                    $(kembali).hide();
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" +
                        thrownerror);
                }
            });
        }

        $(document).ready(function() {
            listvisitor();

        });
    </script>

    <?= $this->endSection() ?>