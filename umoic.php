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
        <h1>Compliance Update</h1>
    </div><!-- End Page Title -->

    <!-- ----working area ----->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="#">
                    <div class="form-group row">
                        <div class="col-auto">
                            <br>
                            <select class="custom-select" id="Period" name="Period">
                                <option value="0">Select Assessment Period</option>
                                <?php
                                $fsid = $_SESSION['u_facilityid'];
                                $query = "CALL get_assessment1(?)";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param('i', $fsid);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['ass_name']; ?>
                                        </option>
                                <?php
                                    }
                                    $result->free();
                                    $con->next_result();
                                }

                                $stmt->close();
                                ?>
                            </select>

                        </div>
                        <div class="col-auto">
                            <br>
                            <select class="form-control-sm custom-select" id="Priority" name="Priority">
                                <option value="2">-Priority-</option>
                                <option value="0">Low</option>
                                <option value="1">Medium</option>
                                <option value="2">High</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <br>
                            <button type="submit" value="Submit" name="submit1" class="btn btn-primary btn-sm">Show Assessments</button>
                        </div>
                    </div>

                </form>


                <?php
                if (isset($_POST['submit1'])) {
                ?>
                    <script>
                        $("#Period option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php $_SESSION['xxp']= $_POST['Period']; echo $_SESSION['xxp'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                    </script>
                    <script>
                        $("#Priority option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php $_SESSION['xxp1']= $_POST['Priority']; echo $_SESSION['xxp1'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                    </script>

                    <?php
                    $_SESSION['FDepartment'] = $_SESSION['dept_id1'];
                    $_SESSION['period'] = $_POST['Period'];
                    $F = $_SESSION['FDepartment'];
                    $Fa = $_SESSION['u_facilityid'];
                    $p = $_SESSION['period'];
                    $_SESSION['Priority']=$_POST['Priority'];
                    $p1=$_SESSION['Priority'];
                    if ($p == 0) {
                    ?>
                        <button type="button" class="btn btn-warning"><?php echo "Kindly select assessment period...!!!!";
                                                                        header("Refresh:3; url=umoic.php");
                                                                        exit; ?><i class="bi bi-exclamation-triangle"></i></button>

                        <?php
                    }
                    // $ca= $_SESSION['cy'];
                    $_SESSION['q1'] = "CALL updt_dept_action_plan($p1,$Fa,$p,$F)";
                    $_SESSION['q'] = "CALL updt_dept_action_plan($p1,$Fa,$p,$F)";
                    $query = $con->query($_SESSION['q']);
                    if ($query->num_rows > 0) {
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <br>
                            <table class="table table-fit w-auto small table-striped table-bordered table-hover table-condensed">

                                <thead>
                                    <tr class="table-warning">
                                        <th colspan="2">
                                            <center>Assessment Compliance Update Based on Action Plan Feedback</center>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.c_subtype_Reference_No" class="table-info">Standard</th>
                                        <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Measurable_Element" class="table-info">MeasurableElement</th>
                                        <td><?php echo $row['Measurable_Element']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Checkpoint" class="table-info">Checkpoint </th>
                                        <td><?php echo $row['Checkpoint']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="chk_list_assessment.ass_compliance" class="table-info">Comp. </th>
                                        <td><?php echo $row['ass_compliance']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Dept.rmk* </th>
                                        <td><?php echo $row['moic_remarcks']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Priority* </th>
                                        <?php $level = $row['Priority1'];
                                        if ($level == 'High') {
                                        ?>

                                            <td class="table-danger"><?php echo $level; ?></td>
                                        <?php } elseif ($level == 'Medium') { ?>
                                            <td class="table-warning"><?php echo $level; ?></td>
                                        <?php } elseif ($level == 'Low') { ?>
                                            <td class="table-success"><?php echo $level; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Dept.actPlan. </th>
                                        <td><?php echo $row['dept_action_plan']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="UpdComp" class="table-info">Upd Comp.</th>

                                        <td>

                                            <form enctype="multipart/form-data" method="post" action="#">

                                                <select class="form-select form-select-sm" id="f" name="f">
                                                    <option value="3">Select</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>

                                                </select>

                                                <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                                                <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">
                                    </tr>
                                    <tr>
                                        <th data-column-id="MOIC_Review" class="table-info">Action</th>

                                        <td> <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save & Next</button></td>
                                    </tr>
                                    </form>
                                    </td>
                                    </tr>
                                <?php
                                //mysqli_free_result($query);
                                // $con->next_result();
                            }
                        } else {
                                ?>
                                <p>
                                    <button addEventListener="function()" type="button" class="btn btn-warning"><?php echo "No compliance updates pending..!"; ?><i class="bi bi-check-circle"></i></button>
                                </p>


                            <?php  }
                        mysqli_free_result($query);
                        $con->next_result();
                    } elseif (isset($_POST['postsubmit2'])) {
                            ?>
<script>
                        $("#Period option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php  echo $_SESSION['xxp'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                    </script>
                    <script>
                        $("#Priority option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php  echo $_SESSION['xxp1'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                    </script>
                            <?php

                            include('conn.php');
                            //session_start();
                            //$id=$_GET['csqa_id'];	
                            $q = $_POST['csqa_id1'];
                            $id = $_POST['csqa_id'];
                            // echo $id ;
                            $moic_compliance = $_POST['f'];
                            if ($moic_compliance == 3) {

                            ?>
                                <button type="button" class="btn btn-danger"><?php echo "Please Select Compliance Value !!!"; ?><i class="bi bi-exclamation-octagon"></i></button>
                            <?php

                                exit;
                            }
                            //echo $moic_compliance;
                            //$obj=$_POST['observation'];
                            //echo $q;

                            $facid = $_SESSION['u_facilityid'];
                            // $uid=$_SESSION['userid'];
                            // mysqli_query($conn,"update chk_list_assessment set ass_compliance=$moic_compliance where ass_id=$id");
                            // $insertfeedback= "update chk_list_assessment_feedback set update_comp=$moic_compliance where ass_id=$id";           
                            $up = "CALL updt_insert_dept_action_plan($moic_compliance,$id)";
                            $up1 = $con->query($up);
                            if ($up1 >= 0) {

                            ?>

                                <p>
                                    <button addEventListener="function()" type="button" class="btn btn-success"><?php echo "Compliance Updated ..!"; ?><i class="bi bi-check-circle"></i></button>
                                </p>
                            <?php
                                //  mysqli_free_result($up1);
                                //  $con->next_result();    
                            }
                            $query = mysqli_query($con, $q);
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-fit w-auto small table-striped table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr class="table-warning">
                                                <th colspan="2">
                                                    <center>Assessment Compliance Update Based on Action Plan Feedback</center>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr class="table-primary">
                                                <th data-column-id="concern_subtype_chklist.c_subtype_Reference_No" class="table-info">Standard</th>
                                                <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="concern_subtype_chklist.Measurable_Element" class="table-info">MeasurableElement</th>
                                                <td><?php echo $row['Measurable_Element']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="concern_subtype_chklist.Checkpoint" class="table-info">Checkpoint </th>
                                                <td><?php echo $row['Checkpoint']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="chk_list_assessment.ass_compliance" class="table-info">Comp. </th>
                                                <td><?php echo $row['ass_compliance']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Dept.rmk* </th>
                                                <td><?php echo $row['moic_remarcks']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Priority* </th>
                                                <?php $level = $row['Priority1'];
                                                if ($level == 'High') {
                                                ?>

                                                    <td class="table-danger"><?php echo $level; ?></td>
                                                <?php } elseif ($level == 'Medium') { ?>
                                                    <td class="table-warning"><?php echo $level; ?></td>
                                                <?php } elseif ($level == 'Low') { ?>
                                                    <td class="table-success"><?php echo $level; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <th data-column-id="chk_list_assessment.moic_remarcks" class="table-info">Dept.actPlan. </th>
                                                <td><?php echo $row['dept_action_plan']; ?></td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="UpdComp" class="table-info">Upd Comp.</th>

                                                <td>

                                                    <form enctype="multipart/form-data" method="post" action="#">

                                                        <select class="form-select form-select-sm" id="f" name="f">
                                                            <option value="3">Select</option>
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>

                                                        </select>

                                                        <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                                                        <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">
                                            </tr>
                                            <tr>
                                                <th data-column-id="MOIC_Review" class="table-info">Action</th>

                                                <td> <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save & Next</button></td>
                                            </tr>
                                            </form>
                                            </td>
                                            </tr>
                                    <?php
                                }
                            }
                                    ?>
                                        </tbody>
                                    </table>
                                </div>


            </div>
        </div>
    </section>
</main><!-- End #main -->
<!-- ----working area end ----->


<script>
    $(document).ready(function() {
        $("#Period1").on('change', function() {
            var Concernid = $('#Period1').val();
            $.ajax({
                method: "POST",
                cache: false,
                url: "response_m.php",
                data: {
                    cid: Concernid,
                },
                datatype: "html",
                success: function(data) {
                    $("#Concern1").html(data);
                },
                error: function(data) {}
            });
        });
    });
</script>
<!-- Template Main JS File -->
<?php
include('f.php');
?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script type="text/JavaScript">
    $(document).ready(function(){   
    $("p").show().delay(3000).fadeOut();
     });
</script>
</body>

</html>