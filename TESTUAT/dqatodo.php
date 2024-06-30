<?php
include('session.php');
include_once("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h2.php');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>ToDO</h1>
    </div><!-- End Page Title -->

    <!-- ----working area ----->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="#">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>Select Facility</label>
                            <select class="form-control-sm form-control" id="Facilityid1" name="Facilityid1">
                                <option value="0">Select Facility </option>
                                <?php
                                include("db.php");
                                $dist = $_SESSION['dist'];
                                $query = "SELECT fac_id, fac_name FROM facilities where dist_id=$dist ";
                                // $result = mysqli_query($con, $query);
                                $result = $con->query($query);
                                //mysqli_close($con);  
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // $_SESSION['u_facilityid']=$row['fac_id'];
                                ?>
                                        <option value="<?php echo $row['fac_id']; ?>"><?php echo $row['fac_name']; ?></option>
                                <?php
                                    }
                                }
                                mysqli_free_result($result);
                                $con->next_result();
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Select Department/Ward</label>
                            <select class="form-control-sm form-control" id="Facility_Department1" name="Facility_Department1">
                                <option value="0">Fac.Dept.</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Select Assessment Period</label>
                            <select class="form-control-sm form-control" id="Period1" name="Period1">
                                <option value="0">Select Assessment Period</option>

                            </select>
                        </div>
                        <div class="col-sm-2">
                            </br>
                            <button type="submit" value="Submit" name="Noachiv" class="btn btn-primary">View </button>
                        </div>
                    </div>

                </form>
                <?php
                if (isset($_POST['Noachiv'])) {
                ?>
                    <script>
                        $("#Facilityid1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php $_SESSION['xxfid2'] = $_POST['Facilityid1'];echo $_SESSION['xxfid2'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                        var Concernid = $('#Facilityid1').val();
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "responce_dist4.php",
                            data: {
                                cid: Concernid,
                            },
                            datatype: "html",
                            success: function(data) {
                                $("#Facility_Department1").html(data);
                            },
                            error: function(data) {}
                        });
                    </script>
                    <script>
                        $("#Facilityid1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php $_SESSION['xxfid2'] = $_POST['Facilityid1'];                                            echo $_SESSION['xxfid2'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                        var Concernid = $('#Facilityid1').val();
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "responce_dist1.php",
                            data: {
                                cid: Concernid,
                            },
                            datatype: "html",
                            success: function(data) {
                                $("#Period1").html(data);
                            },
                            error: function(data) {}
                        });
                    </script>

                    <?php
                    $_SESSION['FDepartment'] = $_POST["Facility_Department1"];
                    $_SESSION['period'] = $_POST['Period1'];
                    $_SESSION['fid'] = $_POST["Facilityid1"];
                    $F = $_SESSION['FDepartment'];
                    $Fa = $_SESSION['fid'];
                    $p = $_SESSION['period'];
                    $_SESSION['q1'] = "call dqa_remarks($p,$F,$Fa)";
                    // $_SESSION['q'] = mysqli_query($con, $_SESSION['q1']);
                    $query12 = $con->query($_SESSION['q1']);
                    if ($query12->num_rows > 0) {
                        while ($row = mysqli_fetch_array($query12)) {
                    ?>
                            <br>
                            <table class="table table-fit w-auto small table-striped table-bordered table-hover table-condensed" id="tbl_exporttable_to_xls">


                                <thead>
                                    <tr class="table-warning">
                                        <th colspan="2">
                                            <center>DQA Review and Action plan</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Standard</th>
                                        <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>MeasurableElement</th>
                                        <td><?php echo $row['Measurable_Element']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Chk.Point</th>
                                        <td><?php echo $row['Checkpoint']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Means of Verification </th>
                                        <td><?php echo $row['Means_of_Verification']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ass.Method</th>
                                        <td><?php echo $row['Assessment_Method']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Compliance</th>
                                        <td><?php echo $row['ass_compliance']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Dept.Review</th>
                                        <td><?php echo $row['moic_remarcks']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>DQA Review</th>
                                        <td>

                                            <form enctype="multipart/form-data" method="post" action="#">

                                                <select class="custom-select" id="f" name="f">
                                                    <option value="0">--Select---</option>
                                                    <option value="1">Achievable</option>
                                                    <option value="2">Non achievable</option>

                                                </select>

                                                <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                                                <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">
                                        </td>
                                    </tr>
                                    <tr class="2">
                                        <th>Res.Nodal</th>
                                        <td><input type="text" id="res1" name="res"> </td>
                                    </tr>
                                    <tr class="2">
                                        <th>Time Period</th>
                                        <td><input type="date" id="todate" name="todate"></td>
                                    </tr>
                                    <tr class="2">
                                        <th>Action Plan</th>
                                        <td><textarea class="form-control" rows="3" id="comment" name="comment">Action Plan</textarea></td>
                                    </tr>
                                    <tr>
                                        <th>Action</th>
                                        <td> <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save</button></td>
                                    </tr>
                                    </tboday>
                            </table>
                    <?php
                        }
                    }
                    mysqli_free_result($query12);
                    $con->next_result();
                } elseif (isset($_POST['postsubmit2'])) {
                    ?>
                    <script>
                        $("#Facilityid1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php echo $_SESSION['xxfid2'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                        var Concernid = $('#Facilityid1').val();
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "responce_dist4.php",
                            data: {
                                cid: Concernid,
                            },
                            datatype: "html",
                            success: function(data) {
                                $("#Facility_Department1").html(data);
                            },
                            error: function(data) {}
                        });
                    </script>
                    <script>
                        $("#Facilityid1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php echo $_SESSION['xxfid2'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                        var Concernid = $('#Facilityid1').val();
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "responce_dist1.php",
                            data: {
                                cid: Concernid,
                            },
                            datatype: "html",
                            success: function(data) {
                                $("#Period1").html(data);
                            },
                            error: function(data) {}
                        });
                    </script>
                    <?php
                    $q = $_POST['csqa_id1'];
                    $id = $_POST['csqa_id'];
                    $moic_compliance = $_POST['f'];
                    $facid = $_SESSION['fid'];
                    if ($moic_compliance == '2') {
                        $insertfeedback = "call dqa_nonach(2,$id)";
                        $queryinsert = mysqli_query($con, $insertfeedback);
                        if ($queryinsert) {
                            echo "ok dqa_nonach";
                    ?>

                        <?php }
                    } else {
                        $com = $_POST['comment'];
                        $date = $_POST['todate'];
                        $dres = $_POST['res'];
                        $p = $_SESSION['period'];
                        $ass_id = $_POST['csqa_id'];
                        $facid = $_SESSION['fid'];
                        $insertfeedback1 = "call dqa_achiv(1,'$dres','$date','$com',$id)";
                        $queryinsert1 = mysqli_query($con, $insertfeedback1);
                        if ($queryinsert1) {
                            echo "ok moic_achiv";
                        }
                    }
                    $query = mysqli_query($con, $q);
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <table class="table table-fit w-auto small table-striped table-bordered table-hover table-condensed" id="tbl_exporttable_to_xls">


                            <thead>
                                <tr class="table-warning">
                                    <th colspan="2">
                                        <center>DQA Review and Action plan</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Standard</th>
                                    <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                </tr>
                                <tr>
                                    <th>MeasurableElement</th>
                                    <td><?php echo $row['Measurable_Element']; ?></td>
                                </tr>
                                <tr>
                                    <th>Chk.Point</th>
                                    <td><?php echo $row['Checkpoint']; ?></td>
                                </tr>
                                <tr>
                                    <th>Means of Verification </th>
                                    <td><?php echo $row['Means_of_Verification']; ?></td>
                                </tr>
                                <tr>
                                    <th>Ass.Method</th>
                                    <td><?php echo $row['Assessment_Method']; ?></td>
                                </tr>
                                <tr>
                                    <th>Compliance</th>
                                    <td><?php echo $row['ass_compliance']; ?></td>
                                </tr>
                                <tr>
                                    <th>Dept.Review</th>
                                    <td><?php echo $row['moic_remarcks']; ?></td>
                                </tr>
                                <tr>
                                    <th>DQA Review</th>
                                    <td>

                                        <form enctype="multipart/form-data" method="post" action="#">

                                            <select class="custom-select" id="f" name="f">
                                                <option value="0">--Select---</option>
                                                <option value="1">Achievable</option>
                                                <option value="2">Non achievable</option>

                                            </select>

                                            <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                                            <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">
                                    </td>
                                </tr>
                                <tr class="2">
                                    <th>Res.Nodal</th>
                                    <td><input type="text" id="res1" name="res"> </td>
                                </tr>
                                <tr class="2">
                                    <th>Time Period</th>
                                    <td><input type="date" id="todate" name="todate"></td>
                                </tr>
                                <tr class="2">
                                    <th>Action Plan</th>
                                    <td><textarea class="form-control" rows="3" id="comment" name="comment">Action Plan</textarea></td>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <td> <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save</button></td>
                                </tr>
                                </tboday>
                        </table>
                <?php

                    }
                } ?>
            </div>
        </div>
    </section>
    <?php
    include('f.php');
    ?>
    <script>
        $(document).ready(function() {
            $('#f').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === '2') {
                    // Hide rows with class option1 if Option 2 is selected
                    $('.2').hide(); // Show rows with class option2 if Option 2 is selected
                } else {
                    $('.2').show(); // Show rows with class option1 for other selections
                    // Hide rows with class option2 for other selections
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#Facilityid1").on('change', function() {
                var fid1 = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "responce_dist4.php",
                    data: {
                        cid: fid1

                    },
                    datatype: "html",
                    success: function(data) {
                        $("#Facility_Department1").html(data);


                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $("#Facilityid1").on('change', function() {
                var fid = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "responce_dist1.php",
                    data: {
                        cid: fid

                    },
                    datatype: "html",
                    success: function(data) {
                        $("#Period1").html(data);


                    }
                });
            });

        });
    </script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <!-- Template Main JS File -->
    </body>

</html>