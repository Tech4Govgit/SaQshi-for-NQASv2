<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h.php');
?>
<main id="main" class="main">
    <div class="pagetitle">

    </div><!-- End Page Title -->
    <!-- ----working area ----->

    <section class="section">

        <div class="row">
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Score</div>
                            <div class="widget-subheading"> <i class="bi bi-arrow-down-circle-fill"></i> <a href="export_deprt_score_card.php">Download Data</a></div>
                        </div>
                        <div class="widget-content-right">
                            <?php
                            $dept_id = $_SESSION['dept_id1'];
                            $Fa = $_SESSION['u_facilityid'];
                            $fat = $_SESSION['f_type_id'];
                            $p =  $_SESSION['assperiod'];
                            $call_q = "call overall_dept_percentage($dept_id,$Fa,$p,$fat)";
                            $q22 = mysqli_query($con, $call_q);
                            while ($row = mysqli_fetch_array($q22)) {
                                $obtained = $row['obtained'];
                                $total = $row['total'];
                                //====
                                if ($obtained != null) {
                                    $percentage = round((($obtained / $total) * 100), 2);
                                    if ($percentage > 70) {
                            ?>
                                        <div class="widget-numbers text-success"><span><?php echo $percentage; ?>%</span></div>
                                    <?php } elseif ($percentage > 65 and $percentage < 70) {

                                    ?>
                                        <div class="widget-numbers text-warning"><span><?php echo $percentage; ?>%</span></div>
                                    <?php
                                    } elseif ($percentage < 65) {
                                    ?>
                                        <div class="widget-numbers text-danger"><span><?php echo $percentage; ?>%</span></div>
                                    <?php
                                    }
                                } else {
                                    $percentage = 0;
                                    ?>
                                    <div class="widget-numbers text-danger"><span><?php echo $percentage; ?>%</span></div>
                            <?php
                                }
                            }
                            mysqli_free_result($q22);
                            $con->next_result();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Indicators</div>
                            <div class="widget-subheading"><i class="bi bi-arrow-down-circle-fill"></i> <a href="export_deprt_indicators.php">Download Data</a></div>
                        </div>
                        <div class="widget-content-right">
                            <?php
                            $call_q1 = "call count_zero($Fa,$dept_id,$p,$fat)";
                            $q56 = mysqli_query($con, $call_q1);
                            while ($row = mysqli_fetch_array($q56)) {
                                $obtained = $row['total'];
                                $total = $row['total1'];
                                if ($obtained != null) {
                                    $percentage = round((($obtained / $total) * 100), 2);
                                    if ($percentage > 70) {
                            ?>
                                        <div class="widget-numbers text-success"><span><?php echo $obtained; ?>/<?php echo $total; ?></div>
                                    <?php } else { ?>
                                        <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                                    <?php
                                    }
                                } else {
                                    $percentage = 0;
                                    ?>
                                    <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                                <?php
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Assessment No.</div>
                            <div class="widget-subheading"></div>
                        </div>
                        <div class="widget-content-right">

                            <div class="widget-numbers text-warning"><span>1</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Non</div>
                            <div class="widget-subheading">Compliance</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-danger"><span> <?php echo  $row['z']; ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Partially</div>
                            <div class="widget-subheading">Compliance</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-warning"><span><?php echo  $row['o']; ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="widget-heading">Fully</div>
                            <div class="widget-subheading">Compliance</div>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-success"><span><?php echo  $row['t']; ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                            }
                            mysqli_free_result($q56);
                            $con->next_result();
        ?>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h2 class="card-title">Score % </h2>
                        <?php

                        $tablequery1 = "call Area_of_concern_NQAS($fat,$Fa,$dept_id,$p)";
                        $q2 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q2)) {
                            $obtained = $row['Obtained'];
                            $total = $row['total'];
                            if ($obtained != null) {
                                $percentage = round((($obtained / $total) * 100), 2);
                                if ($percentage > 70) {
                        ?>
                                    <!-- Progress Bars with labels-->
                                    <label><?php echo  $row['concern_name']; ?></label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                    </div>
                                <?php } elseif ($percentage > 65 and $percentage < 70) {

                                ?>
                                    <label><?php echo  $row['concern_name']; ?></label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                    </div>
                                <?php
                                } elseif ($percentage < 65) {
                                ?>
                                    <label><?php echo  $row['concern_name']; ?></label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                    </div>
                                <?php
                                }
                            } else {
                                $percentage = 0;
                                ?>
                                <label><?php echo  $row['concern_name']; ?></label>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                </div>
                        <?php }
                        }
                        mysqli_free_result($q2);
                        $con->next_result();
                        ?>
                        <!-- End Progress Bars with labels -->

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <h2 class="card-title">Checkpoint assessed</h2>
                        <?php
                        $dept_id = $_SESSION['dept_id1'];;
                        $Fa = $_SESSION['u_facilityid'];
                        $fat = $_SESSION['f_type_id'];
                        $p =  $_SESSION['assperiod'];
                        $tablequery1 = "call Area_of_concern_count_NQAS($fat,$Fa,$dept_id,$p)";
                        $q2 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q2)) {
                        ?>

                            <label><?php echo  $row['concern_name']; ?></label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo  $row['Obtained']; ?>/<?php echo  $row['total']; ?></div>

                            </div>


                        <?php }
                        mysqli_free_result($q2);
                        $con->next_result();
                        ?>
                        <!-- End Progress Bars with labels -->

                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Over All Progress</h5>
                        <?php
                        $dept_id1 = $_SESSION['dept_id1'];;
                        $Fa1 = $_SESSION['u_facilityid'];
                        $p1 =  $_SESSION['assperiod'];
                        $fat1 = $_SESSION['f_type_id'];
                        $tablequery1 = "call count_zero($Fa1,$dept_id1,$p1,$fat1)";
                        $q5 = mysqli_query($con, $tablequery1);
                        while ($row = mysqli_fetch_array($q5)) {

                        ?>
                            <label> Non compliance indicators(0):</label>
                            <span class="badge bg-white text-warning">
                                <h4><?php echo  $row['z']; ?></h4>
                            </span> <br>

                            <label>
                                Partialy compliance indicators(1):</label>
                            <span class="badge bg-white text-info">
                                <h5><?php echo  $row['o']; ?></h5>
                            </span><br>


                            <label>
                                Fully compliance indicators(2): </label>
                            <span class="badge bg-white text-success">
                                <h4><?php echo  $row['t']; ?></h4>
                            </span><br>

                            <label>
                                Number of indicators completed : </label>
                            <span class="badge bg-white text-primary">
                                <h5><?php echo  $row['total']; ?></h5>
                            </span><br>
                            <label>
                                Total Indicators: </label>
                            <span class="badge bg-white text-secondary">
                                <h4><?php echo  $row['total1']; ?></h4>
                            </span><br>
                            </button>
                        <?php }
                        mysqli_free_result($q5);
                        $con->next_result();
                        ?>

                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assessment wise Progress</h5>
                        <!-- Radial Bar Chart -->
                        <div id="radialBarChart">
                            <?php

                            $fid = $_SESSION['u_facilityid'];
                            $did = $_SESSION['dept_id1'];
                            $fty = $_SESSION['f_type_id'];
                            $query = "CALL dept_dash_preriod_g($fid,$did,$fty)";
                            $result = $con->query($query);
                            if ($result->num_rows <= 1) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $values[] = $row['total'];
                                    $values1[] = "'" . $row['period'] . "'";
                                }
                                $h = implode(", ", $values);
                                $h1 = implode(", ", $values1);

                            ?>
                               <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#radialBarChart"), {
                                            series: [{
                                                data: [<?php echo  $h; ?>]
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 100
                                            },
                                            plotOptions: {
                                                bar: {
                                                    borderRadius: 1,
                                                    horizontal: true,
                                                }
                                            },
                                            dataLabels: {
                                                enabled: true
                                            },
                                            xaxis: {
                                                categories: [<?php echo $h1; ?>],
                                            }
                                        }).render();
                                    });
                                </script>
                            <?php }else{
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $values[] = $row['total'];
                                    $values1[] = "'" . $row['period'] . "'";
                                }
                                $h = implode(", ", $values);
                                $h1 = implode(", ", $values1);
                                 ?>
                               <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#radialBarChart"), {
                                            series: [<?php echo  $h; ?>],
                                            chart: {
                                                height: 250,
                                                type: 'radialBar',
                                                toolbar: {
                                                    show: true
                                                }
                                            },
                                            plotOptions: {
                                                radialBar: {
                                                    dataLabels: {
                                                        name: {
                                                            fontSize: '10px',
                                                        },
                                                        value: {
                                                            fontSize: '10px',
                                                        },
                                                        total: {
                                                            show: true,
                                                            label: '',
                                                            formatter: function(w) {
                                                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                                               
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            labels: [<?php echo $h1; ?>],
                                        }).render();
                                    });
                                </script>
                            <?php    } ?>
                            <!-- End Radial Bar Chart -->

                        </div>
                    </div>
                </div>
                <!-----data end------->
            </div>
        </div>


    </section>
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->


<?php
include('f.php');
?>
<!-- Template Main JS File -->



</body>

</html>