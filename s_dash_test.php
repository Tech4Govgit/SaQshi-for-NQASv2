<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h4.php');
?>
<main id="main" class="main">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a role="tab" class="nav-link " data-toggle="tab" href="#tab-content-0">
                <span>Summary</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link " data-toggle="tab" href="#tab-content-1">
                <span>DrillDown*</span>
            </a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab-content-0">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php
                        // $b_id =  $_SESSION['block_id'];
                        $call_q1 = "call state_dash_count";
                        $q22 = mysqli_query($con, $call_q1);
                        while ($row = mysqli_fetch_array($q22)) {
                            $CHC = $row['CHC'];
                            $PHC = $row['PHC'];
                            $DH = $row['DH'];
                            $HWC = $row['HWC'];
                            $UPHC = $row['UPHC'];
                            $CHCcomp = $row['CHCcomp'];
                            $PHCcomp = $row['PHCcomp'];
                            $DHcomp = $row['DHCcomp'];
                            $HWCcomp = $row['HWCcomp'];
                            $UPHCcomp = $row['UPHCcomp'];
                            //====
                        ?>
                            <div class="col">


                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <i class="mdi mdi-image font-20  text-muted"></i>
                                        <p class="font-16 m-b-5">DH</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="font-light text-right"><?php echo $DHcomp; ?>/<?php echo $DH; ?></h1>
                                    </div>
                                </div>



                            </div>
                            <div class="col">

                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <i class="mdi mdi-image font-20  text-muted"></i>
                                        <p class="font-16 m-b-5">CHC</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="font-light text-right"><?php echo $CHCcomp; ?>/<?php echo $CHC; ?></h1>
                                    </div>
                                </div>

                            </div>
                            <div class="col">

                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <i class="mdi mdi-image font-20  text-muted"></i>
                                        <p class="font-16 m-b-5">PHC</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="font-light text-right"><?php echo $PHCcomp; ?>/<?php echo $PHC; ?></h1>
                                    </div>
                                </div>

                            </div>

                            <div class="col">



                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <i class="mdi mdi-image font-20  text-muted"></i>
                                        <p class="font-16 m-b-5">HWC</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="font-light text-right"><?php echo $HWCcomp; ?>/<?php echo $HWC; ?></h1>
                                    </div>
                                </div>




                            </div>
                            <div class="col">

                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <i class="mdi mdi-image font-20  text-muted"></i>
                                        <p class="font-16 m-b-5">UPHC</p>
                                    </div>
                                    <div class="ml-auto">
                                        <h1 class="font-light text-right"><?php echo $UPHCcomp; ?>/<?php echo $UPHC; ?></h1>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        mysqli_free_result($q22);
                        $con->next_result();
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <a href="export_state_score_card.php">
                                <h4 class="card-title">Compliance Summary <i class="bi bi-arrow-down-circle-fill"></i></h4>
                            </a>
                            </br>
                            <div class="table-responsive">                                
                        <table class="table  small  table-bordered " id="tbl_exporttable_to_xls" data-toggle="bootgrid">
                                    <thead>
                                    <tr class="table-primary">
                                        <th scope="Dist_Name">District</th>
                                        <th scope="Block_Name">Block</th>
                                        <th scope="facilities_type">Type</th>
                                        <th scope="fac_name">Name</th>                                                                               
                                    </tr>
                                    </thead>
                                   
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <!---------------tab2--------------------->

        <div class="tab-pane show active" id="tab-content-1">
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="#">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                </br>
                                <label>District</label>
                                <select class="form-control-sm form-control" id="District1" name="District1">
                                    <option value="0">--Select--</option>
                                    <?php
                                    $call_q111 = "SELECT distinct(dist_id),Dist_Name FROM facilities";
                                    $q221 = mysqli_query($con, $call_q111);
                                    while ($row = mysqli_fetch_array($q221)) {
                                    ?>
                                        <option value="<?php $_SESSION['did'] = $row['dist_id'];
                                                        echo $row['dist_id']; ?>"><?php echo $row['Dist_Name']; ?></option>
                                    <?php }
                                    mysqli_free_result($q221);
                                    $con->next_result();
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                </br>
                                <label>Block</label>
                                <select class="form-control-sm form-control" id="District" name="District">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                </br>
                                <label>Ins. Type</label>
                                <select class="form-control-sm form-control" id="Block" name="Block">
                                    <option value="0">--Select--</option>
                                    <?php
                                    //  $dist_id = $_SESSION['dist'];
                                    $call_q1 = "SELECT fac_type_id,facilities_type FROM facilities_type";
                                    $q22 = mysqli_query($con, $call_q1);
                                    while ($row = mysqli_fetch_array($q22)) {
                                    ?>
                                        <option value="<?php echo $row['fac_type_id']; ?>"><?php echo $row['facilities_type']; ?></option>
                                    <?php }
                                    mysqli_free_result($q22);
                                    $con->next_result();
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                </br>
                                <label>Institute </label>
                                <select class="form-control-sm form-control" id="Village" name="Village">
                                    <option value="0">--Select--</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                </br>
                                <label>Assessment </label>
                                <select class="form-control-sm form-control" id="Period" name="Period">
                                    <option value="0">--Select--</option>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                </br>


                                <label></label>
                                </br>
                                <button type="submit" value="Submit" name="postsubmit" class="mb-2 mr-2 btn btn-primary">View</button>
                            </div>
                    </form>
                    </br>
                    <hr class="dropdown-divider">
                    <hr class="dropdown-divider">





                    <?php
                    if (isset($_POST['postsubmit'])) {
                        $u_facilityid = $_POST['Block'];
                        $u_ass = $_POST['Period'];
                        $u_fid = $_POST['Village'];

                    ?>
                        <!------------------------------------->
                        <div class="row">
                            <div class="col-lg-6 col-xl-4">
                                <div class="card mb-3 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Departments</div>
                                            <div class="widget-subheading"> </div>
                                        </div>
                                        <?php

                                        $fid = $u_fid;


                                        $call_q1 = "SELECT count(fac_dept_id) FROM fac_dept_map where fac_id=$fid";
                                        $q22 = mysqli_query($con, $call_q1);
                                        while ($row = mysqli_fetch_array($q22)) {
                                            $obtained = $row['count(fac_dept_id)'];

                                            //====
                                            if ($obtained != null) {
                                        ?>
                                                <div class="widget-content-right">
                                                    <div class="widget-numbers text-primary"><span><?php echo $obtained; ?></span></div>
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
                                            <div class="widget-heading">Score</div>
                                            <div class="widget-subheading"> </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <?php
                                            $f_ty_id = $u_facilityid;
                                            $fid = $u_fid;
                                            $assid = $u_ass;

                                            $call_q1 = "call facility_dash_dh_perc($f_ty_id, $fid, $assid)";
                                            $q22 = mysqli_query($con, $call_q1);
                                            while ($row = mysqli_fetch_array($q22)) {
                                                $obtained = $row['Obtained'];
                                                $total = $row['total'];
                                                //====
                                                if ($obtained != null) {
                                                    $percentage = round((($obtained / $total) * 100), 2);
                                                    if ($percentage > 70) {
                                            ?>
                                                        <div class="widget-numbers text-success"><span><?php echo $percentage; ?>%</span></div>
                                                    <?php } else { ?>
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
                                            <div class="widget-subheading"> </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <?php
                                            $call_q2 = "call facility_dash_dh_perc($f_ty_id, $fid, $assid)";
                                            $call_q2 = mysqli_query($con, $call_q2);
                                            while ($row = mysqli_fetch_array($call_q2)) {
                                                $obtained = $row['assessed_checklist'];
                                                $total = $row['total_checklist'];
                                                if ($obtained != null) {
                                                    $percentage = round((($obtained / $total) * 100), 2);
                                                    if ($percentage > 70) {
                                            ?>
                                                        <div class="widget-numbers text-success"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                                                    <?php } else { ?>
                                                        <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                                                    <?php
                                                    }
                                                } else {
                                                    $percentage = 0;
                                                    ?>
                                                    <div class="widget-numbers text-danger"><span><?php echo $obtained; ?>/<?php echo $total; ?></span></div>
                                                <?php
                                                } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!------------------------------------->
                        <div class="row">
                            <div class="col-lg-6 col-xl-4">
                                <div class="card mb-3 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Non Compliance</div>
                                            <div class="widget-subheading"></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-danger"><span><?php echo  $row['z']; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-4">
                                <div class="card mb-3 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Partially Compliance</div>
                                            <div class="widget-subheading"></div>
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
                                            <div class="widget-heading">Fully Compliance</div>
                                            <div class="widget-subheading"></div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"><span><?php echo  $row['t']; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                                            }
                                            mysqli_free_result($call_q2);
                                            $con->next_result();
                        ?>
                        </div>
                        <!------------------------------------->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Departments Score(%) Card </h6>
                                        <?php
                                        $f_ty_id = $u_facilityid;
                                        $fid = $u_fid;
                                        $assid = $u_ass;
                                        $tablequery = "CALL depart_dash_dh($f_ty_id, $fid, $assid)";
                                        $q = mysqli_query($con, $tablequery);
                                        while ($row = mysqli_fetch_array($q)) {
                                            $perce = round(($row['Obtained'] / $row['total']) * 100, 2);
                                            if ($perce > 70) {
                                        ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-success"> <?php echo  $perce; ?>%</span><br>

                                            <?php } elseif ($perce > 65 and $perce < 70) {
                                            ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-warning"> <?php echo  $perce; ?>%</span><br>
                                            <?php
                                            } elseif ($perce < 65) {

                                            ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-danger"> <?php echo  $perce; ?>%</span><br>
                                            <?php
                                            } else {
                                                $perce = 0;
                                            ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-danger"> <?php echo  $perce; ?>%</span><br>
                                        <?php }
                                        }

                                        mysqli_free_result($q);
                                        $con->next_result();
                                        ?>
                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-6">
                                <div class="card">

                                    <div class="card-body">
                                        <h4 class="card-title">Checkpoint assessed </h4>
                                        <?php

                                        $f_ty_id = $u_facilityid;
                                        $fid = $u_fid;
                                        $assid = $u_ass;
                                        $tablequery = "CALL depart_dash_indicator_count_dh($f_ty_id, $fid, $assid)";
                                        $q = mysqli_query($con, $tablequery);
                                        while ($row = mysqli_fetch_array($q)) {
                                            $perce = round(($row['Obtained'] / $row['total']) * 100, 2);
                                            if ($perce > 70) {
                                        ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-success"> <?php echo  $row['Obtained']; ?></span>/<span class="badge bg-secondary rounded-pill"><?php echo  $row['total']; ?></span><br>

                                            <?php } else {
                                            ?>
                                                <span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> <?php echo  $row['dept_name']; ?></span>
                                                <span class="badge bg-danger"> <?php echo  $row['Obtained']; ?></span>/<span class="badge bg-secondary rounded-pill"><?php echo  $row['total']; ?></span><br>
                                        <?php }
                                        }

                                        mysqli_free_result($q);
                                        $con->next_result();
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------->
                        </div>

                        <div class=row>
                            <div class="col-lg-6">
                                <div class="card">

                                    <div class="card-body">
                                        <h5 class="card-title">Areas of Concern wise Facility Score(%) Card </h5>
                                        <?php
                                        $f_ty_id = $u_facilityid;
                                        $fid = $u_fid;
                                        $assid = $u_ass;
                                        $tablequery = "CALL admin_dash($f_ty_id, $fid, $assid)";
                                        $q = mysqli_query($con, $tablequery);
                                        while ($row = mysqli_fetch_array($q)) {
                                            $conc = $row['concern_name'];
                                            $perce = round(($row['Obtained'] / $row['total']) * 100, 2);

                                            if ($perce > 70) {
                                        ?>
                                                <!-- Progress Bars with labels-->
                                                <label><?php echo  $conc; ?></label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                                </div>
                                            <?php } elseif ($perce > 65 and $perce < 70) {

                                            ?>
                                                <label><?php echo  $conc; ?></label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                                </div>
                                            <?php
                                            } elseif ($perce < 65) {
                                            ?>
                                                <label><?php echo $conc; ?></label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                                </div>
                                            <?php
                                            } else {
                                                $perce = 0;
                                            ?>
                                                <label><?php echo  $conc; ?></label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%" aria-valuenow="<?php echo $row['Obtained']; ?>" aria-valuemin="0" aria-valuemax="<?php echo $row['total']; ?>"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?>%</div>
                                                </div>
                                        <?php }
                                        }
                                        mysqli_free_result($q);
                                        $con->next_result();
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Department Wise Compliance Status</h5>

                                        <!-- Column Chart -->
                                        <div id="columnChart">
                                            <?php

                                            $fid = $u_fid;
                                            $assid = $u_ass;
                                            $query = "CALL facility_dept_caht($fid,$assid)";
                                            $result = $con->query($query);
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $values[] = $row['dept_name'];
                                                    $values1[] = "'" . $row['o'] . "'";
                                                    $values0[] = "'" . $row['z'] . "'";
                                                    $values2[] = "'" . $row['t'] . "'";
                                                }
                                                $h = "'" . implode("','", $values) . "'";
                                                $h0 = implode(",", $values0);
                                                $h1 = implode(",", $values1);
                                                $h2 = implode(",", $values2);
                                            ?>
                                                <script>
                                                    document.addEventListener("DOMContentLoaded", () => {
                                                        new ApexCharts(document.querySelector("#columnChart"), {
                                                            series: [{
                                                                name: 'Non compliance',
                                                                data: [<?php echo $h0; ?>]
                                                            }, {
                                                                name: 'Partially  Compliance',
                                                                data: [<?php echo $h1; ?>]
                                                            }, {
                                                                name: 'Fully compliance',
                                                                data: [<?php echo $h2; ?>]
                                                            }],
                                                            chart: {
                                                                type: 'bar',
                                                                height: 350
                                                            },
                                                            plotOptions: {
                                                                bar: {
                                                                    horizontal: false,
                                                                    columnWidth: '25%',
                                                                    endingShape: 'rounded'
                                                                },
                                                            },
                                                            dataLabels: {
                                                                enabled: false
                                                            },
                                                            stroke: {
                                                                show: true,
                                                                width: 2,
                                                                colors: ['transparent']
                                                            },
                                                            xaxis: {
                                                                categories: [<?php echo $h; ?>],
                                                            },
                                                            yaxis: {
                                                                title: {
                                                                    text: 'No of Indicators'
                                                                }
                                                            },
                                                            fill: {
                                                                opacity: 1
                                                            },
                                                            tooltip: {
                                                                y: {
                                                                    formatter: function(val) {
                                                                        return val + " " + "indicators"
                                                                    }
                                                                }
                                                            }
                                                        }).render();
                                                    });
                                                </script>
                                        <?php }
                                        } ?>
                                        <!-- End} Column Chart -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                </div>
            </div>
        </div>
        <!--------------tab2 end tab3 start------------------->
        <div class="tab-pane" id="tab-content-2">


        </div>

        <!--------------tab3 end ------------------->
    </div>


    <script type="text/javascript" src="assets/scripts/main.js"></script>
    <script>
        $(document).ready(function() {
            $("#District1").on('change', function() {
                var Blockid2 = $(this).val();              
                $.ajax({
                    method: "POST",
                    url: "responce_dist2.php",
                    data: {
                        cid: Blockid2,                     
                    },
                    datatype: "html",
                    success: function(data) {
                        $("#District").html(data);

                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#Block").on('change', function() {
                var Blockid = $(this).val();
                var Districtid = document.getElementById("District");
                var selectedValue1 = District.value;
                //var Districtid1 = document.getElementById("District1");
                //var selectedValue2 = District1.value;
                $.ajax({
                    method: "POST",
                    url: "responce_dist3.php",
                    data: {
                        cid: selectedValue1,
                        bid: Blockid,
                      //  did: selectedValue2,

                    },
                    datatype: "html",
                    success: function(data) {
                        $("#Village").html(data);

                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#Village").on('change', function() {
                var Villageid = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "responce_dist1.php",
                    data: {
                        cid: Villageid,
                    },
                    datatype: "html",
                    success: function(data) {
                        $("#Period").html(data);

                    }
                });
            });

        });
    </script>
    
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->
<?php
include('f.php');
?>

<!-- Template Main JS File -->
</body>

</html>

<script type="text/javascript">
$( document ).ready(function() {
	var grid = $("#tbl_exporttable_to_xls").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		
		url: "gresponse.php",
		formatters: {
		        "commands": function(column, row)
		        {
		            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> ";
		        }
		    }
   }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        //alert("You pressed edit on row: " + $(this).data("row-id"));
			var ele =$(this).parent();
			var g_id = $(this).parent().siblings(':first').html();
            var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
console.log(g_id);
                    console.log(g_name);

		//console.log(grid.data());//
		$('#edit_model').modal('show');
					if($(this).data("row-id") >0) {
							
                                // collect the data
                                $('#edit_id').val(ele.siblings(':first').html()); // in case we're changing the key
                                $('#edit_Status').val(ele.siblings(':nth-of-type(2)').html());
					} else {
					 alert('Now row selected! First select row, then click edit button');
					}
    }).end().find(".command-delete").on("click", function(e)
    {
	
		var conf = confirm('Delete ' + $(this).data("row-id") + ' items?');
					alert(conf);
                    if(conf){
                                $.post('gresponse.php', { id: $(this).data("row-id"), action:'delete'}
                                    , function(){
                                        // when ajax returns (callback), 
										$("#tbl_exporttable_to_xls").bootgrid('reload');
                                }); 
								//$(this).parent('tr').remove();
								//$("#tbl_exporttable_to_xls").bootgrid('remove', $(this).data("row-id"))
                    }
    });
});

function ajaxAction(action) {
				data = $("#frm_"+action).serializeArray();
				$.ajax({
				  type: "POST",  
				  url: "gresponse.php",  
				  data: data,
				  dataType: "json",       
				  success: function(response)  
				  {
					$('#'+action+'_model').modal('hide');
					$("#tbl_exporttable_to_xls").bootgrid('reload');
				  }   
				});
			}
			
			$( "#command-add" ).click(function() {
			  $('#add_model').modal('show');
			});
			$( "#btn_add" ).click(function() {
			  ajaxAction('add');
			});
			$( "#btn_edit" ).click(function() {
			  ajaxAction('edit');
			});
});
</script>