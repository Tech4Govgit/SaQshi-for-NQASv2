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
        <h1>Action Plan</h1>
    </div><!-- End Page Title -->

    <!-- ----working area ----->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="post" action="#">

                    <div class="form-group row">
                        <div class="col-auto">
                            <label for="complainant">Select Assessment Period</label>
                            <select class="form-control-sm form-control" id="Period1" name="Period" aria-label="size 8 select example">
                                <option value="0">Select Assessment Period</option>
                                <?php
                                $fsid = $_SESSION['u_facilityid'];
                                $query = "call get_assessment1($fsid)";
                                $result = $con->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $row['id'];
                                                        $_session['assid'] = $row['id']; ?>"><?php echo $row['ass_name']; ?></option>
                                <?php
                                    }
                                    mysqli_free_result($result);
                                    $con->next_result();
                                }
                                ?>

                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="ibank">Select Area Of Concern</label>
                            <select class="form-control-sm form-control" id="Concern1" name="Concern">
                                <option value="0">-Select-</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            </br>
                            <button type="submit" value="Submit" name="submit1" class="btn btn-primary btn-sm">Action Plan</button>
                        </div>

                        <div class="col-auto">
                            </br>
                        <!---    <button type="submit" value="Submit" name="submit3" class="btn btn-success btn-sm" >View Compliance for Action Plan</button> -->
                        </div>

                    </div>
                </form>

                <!---- data load-------------------->
                <?php
                if (isset($_POST['submit1'])) { ?>
                    <script>
                        $("#Period1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php $_SESSION['xxp2'] = $_POST['Period'];                                            echo $_SESSION['xxp2'] ?>") {                                $(this).prop('selected', true);
                            }
                        });
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
                    </script>
                    <?php
                    $_SESSION['FDepartment'] = $_SESSION['dept_id1'];
                    $_SESSION['concern'] = $_POST['Concern'];
                    $_SESSION['period'] = $_POST['Period'];
                    //  $_SESSION['F_type']=$_POST["Facility_type"];
                    //$_SESSION['Cn']=$_POST["Concern"];
                    // $_SESSION['cy']=$_POST["category"];           
                    $C = $_SESSION['concern'];
                    $F = $_SESSION['FDepartment'];
                    $Fa = $_SESSION['u_facilityid'];
                    $p = $_SESSION['period'];
                    if ($p == 0) {
                        echo '<button type="button" class="btn btn-danger">Kindly select assessment period...!!!!</button>';

                        header("Refresh:3; url=moic.php");
                        exit;
                    }
                    ?>
                    <script>
                        $("#Period1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php echo $_POST['Period'] ?>") {
                                $(this).prop('selected', true);
                            }
                        });
                    </script>

                    <?php

                    // $ca= $_SESSION['cy'];
                    $_SESSION['q1'] = "CALL moic_action_plan($Fa,$p,$F,$C)";
                    //  $result = $con->query($query);
                    $query = $con->query($_SESSION['q1']);
                    if ($query->num_rows > 0) {
                        while ($row = mysqli_fetch_array($query)) {
                    ?>
                            <br>
                            <table class="table table-fit w-auto small table-striped table-bordered table-hover table-condensed" id="tbl_exporttable_to_xls">


                                <thead>
                                    <tr class="table-warning">
                                        <th colspan="2">
                                            <center>Formulate your action plan</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.c_subtype_Reference_No">Standard</th>
                                        <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Reference_No">Ref.</th>
                                        <td><?php echo $row['csqa_reference_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Measurable_Element">MeasurableElement</th>
                                        <td><?php echo $row['Measurable_Element']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Checkpoint">Checkpoint </th>
                                        <td><?php echo $row['Checkpoint']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Means_of_Verification">Means of Verification</th>
                                        <td><?php echo $row['Means_of_Verification']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="concern_subtype_chklist.Means_of_Verification">Ass.Method</th>
                                        <td><?php echo $row['Assessment_Method']; ?></td>
                                    </tr>
                                    <tr>
                                        <th data-column-id="chk_list_assessment.ass_compliance">Comp.</th>
                                        <td><?php echo $row['ass_compliance']; ?></td>
                                    </tr>
                                    <form enctype="multipart/form-data" method="post" action="#">
                                        <tr>
                                            <th data-column-id="MOIC_Priority_Review">Priority</th>
                                            <td> <select class="custom-select" id="Priority" name="Priority">
                                                    <option value="0">Low</option>
                                                    <option value="1">Medium</option>
                                                    <option value="2">High</option>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr>


                                            <th data-column-id="MOIC_Review">Dept.Review</th>
                                            <td> <select class="custom-select" id="f1" name="f">
                                                    <option value="0">--Select---</option>
                                                    <option value="1">Achievable</option>
                                                    <option value="2">Non achievable</option>

                                                </select>

                                                <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">

                                                <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">

                                            </td>
                                        </tr>

                                        <tr class="2">
                                            <th data-column-id="MOIC_Review">Res.Nodal</th>
                                            <td><input type="text" id="res1" name="res" pattern="[a-zA-Z]{1,}" required> </td>
                                        </tr>
                                        <tr class="2">
                                            <th data-column-id="MOIC_Review">Time Period</th>
                                            <td>
                                                <input type="date" id="todate" name="todate">
                                            </td>
                                        </tr>
                                        <tr class="2">
                                            <th data-column-id="MOIC_Review">Action Plan</th>
                                            <td>
                                                <textarea class="form-control" rows="3" id="comment" name="comment">Action Plan</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th data-column-id="MOIC_Review">Action</th>
                                            <td>
                                                <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save & Next</button>
                                            </td>
                                        </tr>
                                    </form>


                                <?php
                            }
                        } else {
                                ?>
                                <p>
                                    <button addEventListener="function()" type="button" class="btn btn-warning"><?php echo "Compliance not found for Action plane..!"; ?><i class="bi bi-check-circle"></i></button>
                                </p>


                            <?php  }
                        mysqli_free_result($query);
                        $con->next_result();
                            ?>
                            <tr>
                                <td colspan="2"> <button type="button" class="btn btn-outline-success">
                                        <?php
                                        $_SESSION['getcount_assessment_count'] = "CALL get_acctionplan_assessment_count($Fa,$p,$F)";
                                        $getcount = "CALL get_acctionplan_assessment_count($Fa,$p,$F)";
                                        $queryb = $con->query($getcount);
                                        while ($row = mysqli_fetch_assoc($queryb)) {
                                            $p =  $row['total'];
                                            $p1 = $row['completed'];
                                        ?>
                                            <?php echo 'Action Plan:-';
                                            ?> <span class="badge bg-warning"><?php echo $p1; ?></span>/ out of <span class="badge bg-warning"><?php echo $p; ?></span>Pending for Planning
                                    </button> </td>

                            </tr>
                                </tbody>
                            </table>
                        <?php }
                                        mysqli_free_result($queryb);
                                        $con->next_result();
                                    } elseif (isset($_POST['postsubmit2'])) {

                        ?>
                         <script>
                        $("#Period1 option").each(function(index) {
                            var item = $(this).val();
                            if (item == "<?php   echo $_SESSION['xxp2'] ?>") {                                $(this).prop('selected', true);
                            }
                        });
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
                    </script>
                        <br>
                        <table class="table w-auto small table-striped table-bordered table-hover table-condensed">

                            <thead>
                                <tr class="table-warning">
                                    <th colspan="2">
                                        <center>Formulate your action plan</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        // include('conn.php');
                                        $q = $_POST['csqa_id1'];
                                        $id = $_POST['csqa_id'];
                                        $p = $_SESSION['period'];
                                        $pri = $_POST['Priority'];
                                        $moic_compliance = $_POST['f'];
                                        if ($moic_compliance == '2') {
                                            $ass_id = $id;
                                            $facid = $_SESSION['u_facilityid'];
                                            $insertfeedback = "call moic_nonach(2,$ass_id,$facid,$p,$pri)";
                                            $queryinsert = $con->query($insertfeedback);
                                            if ($queryinsert) {
                                                // echo '<button type="button" class="btn btn-success">Compliance status updated!</button>';

                                ?>
                                        <p>
                                            <button addEventListener="function()" type="button" class="btn btn-success"><?php echo "Compliance action plane status updated..!"; ?><i class="bi bi-check-circle"></i></button>
                                        </p>
                                    <?php

                                            }
                                            //  mysqli_free_result($queryinsert);
                                            // $con->next_result();
                                        } else {
                                            $com = $_POST['comment'];
                                            $date = $_POST['todate'];
                                            $dres = $_POST['res'];
                                            if ($dres == '' or $date == '' or $dres == 0 or  $com = '' or  $com = 0) {
                                                echo "Please Select responsible Person/Nodal and Date";
                                    ?>

                                    <?php exit;
                                            }
                                    ?>
                                    <?php
                                            $com = $_POST['comment'];
                                            $p = $_SESSION['period'];
                                            $ass_id = $_POST['csqa_id'];
                                            $facid = $_SESSION['u_facilityid'];
                                            $insertfeedback1 = "call moic_achiv(1,$ass_id, $facid,$p,'$dres','$date','$com',$pri)";
                                            $queryinsert1 = $con->query($insertfeedback1);
                                            // $queryinsert1 = mysqli_query($con, $insertfeedback1);
                                            if ($queryinsert1) {
                                                // echo '<button type="button" class="btn btn-success">Compliance status updated!</button>';

                                    ?>
                                        <p>
                                            <button addEventListener="function()" type="button" class="btn btn-success"><?php echo "Compliance action plane status updated..!"; ?><i class="bi bi-check-circle"></i></button>
                                        </p>
                                    <?php }
                                            // mysqli_free_result($queryinsert1);
                                            // $con->next_result();
                                        }
                                        //$query = mysqli_query($con, $q);
                                        $queryd = $con->query($q);
                                        if ($queryd->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($queryd)) {
                                    ?>

                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.c_subtype_Reference_No">Standard</th>
                                            <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.Reference_No">Ref.</th>
                                            <td><?php echo $row['csqa_reference_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.Measurable_Element">MeasurableElement</th>
                                            <td><?php echo $row['Measurable_Element']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.Checkpoint">Checkpoint </th>
                                            <td><?php echo $row['Checkpoint']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.Means_of_Verification">Means of Verification</th>
                                            <td><?php echo $row['Means_of_Verification']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="concern_subtype_chklist.Means_of_Verification">Ass.Method</th>
                                            <td><?php echo $row['Assessment_Method']; ?></td>
                                        </tr>
                                        <tr>
                                            <th data-column-id="chk_list_assessment.ass_compliance">Comp.</th>
                                            <td><?php echo $row['ass_compliance']; ?></td>
                                        </tr>
                                        <form enctype="multipart/form-data" method="post" action="#">
                                            <tr>
                                                <th data-column-id="MOIC_Priority_Review">Priority</th>
                                                <td> <select class="custom-select" id="Priority" name="Priority">
                                                        <option value="0">Low</option>
                                                        <option value="1">Medium</option>
                                                        <option value="2">High</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th data-column-id="MOIC_Review">Dept.Review</th>
                                                <td>
                                                    <select id="f1" name="f">
                                                        <option value="0">--Select---</option>
                                                        <option value="1">Achievable</option>
                                                        <option value="2">Non achievable</option>
                                                    </select>
                                                    <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                                                    <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['ass_id']; ?>">
                                            </tr>

                                            <tr class="2">
                                                <th data-column-id="MOIC_Review">Res.Nodal</th>
                                                <td><input type="text" id="res1" name="res"> </td>
                                            </tr>
                                            <tr class="2">
                                                <th data-column-id="MOIC_Review">Time Period</th>
                                                <td>
                                                    <input type="date" id="todate" name="todate">
                                                </td>
                                            </tr>
                                            <tr class="2">
                                                <th data-column-id="MOIC_Review">Action Plan</th>
                                                <td>
                                                    <textarea class="form-control" rows="3" id="comment" name="comment">Action Plan</textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th data-column-id="MOIC_Review">Action</th>
                                                <td>
                                                    <button type="submit" name="postsubmit2" class="btn btn-primary btn-sm">Save & Next</button>
                                                </td>
                                            </tr>
                                        </form>

                                <?php
                                            }
                                        }
                                        mysqli_free_result($queryd);
                                        $con->next_result();
                                ?>
                                <tr>
                                    <td colspan="2"> <button type="button" class="btn btn-outline-success">
                                            <?php
                                            $queryd1 = $con->query($_SESSION['getcount_assessment_count']);
                                            while ($row = mysqli_fetch_assoc($queryd1)) {
                                                $p =  $row['total'];
                                                $p1 = $row['completed'];
                                            ?>
                                                <?php echo 'Action Plan:-';
                                                ?> <span class="badge bg-warning"><?php echo $p1; ?></span>/ out of <span class="badge bg-warning"><?php echo $p; ?></span>Pending for Planning
                                        </button> </td>


                                </tr>
                            </tbody>
                        </table>
                    <?php
                                            }
                                        } elseif (isset($_POST['submit3'])) {

                    ?>
                   
                    <br>

                    <?php
                                            $_SESSION['FDepartment'] = $_SESSION['dept_id1'];
                                            //    $_SESSION['concern'] = $_POST['Concern'];
                                            $_SESSION['period'] = $_POST['Period'];
                                            //  $_SESSION['F_type']=$_POST["Facility_type"];
                                            //$_SESSION['Cn']=$_POST["Concern"];
                                            // $_SESSION['cy']=$_POST["category"];           
                                            //   $C = $_SESSION['concern'];
                                            $F = $_SESSION['FDepartment'];
                                            $Fa = $_SESSION['u_facilityid'];
                                            $p = $_SESSION['period'];
                                            if ($p == 0) {
                    ?>
                        <p>
                            <button addEventListener="function()" type="button" class="btn btn-danger"><?php echo "Kindly Select Assessment Period..!"; ?><i class="bi bi-check-circle"></i></button>
                        </p>

                        <?php
                                            } else {
                                                // $ca= $_SESSION['cy'];
                                                $_SESSION['q1'] = "CALL moic_action_plan_view($Fa,$p,$F)";
                                                $_SESSION['q'] = mysqli_query($con, $_SESSION['q1']);
                                                $query = $_SESSION['q'];
                                                if ($query->num_rows > 0) {
                        ?>
                            <font size="2" face="Times New Roman">
                                <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:100%" id="tbl_exporttable_to_xls">

                                    <thead>
                                        <tr>
                                            <th colspan="6">
                                                <center>Compliance details</center>
                                            </th>
                                            <th colspan="1"><img src="assets/img/ex.png" onclick="ExportToExcel('xlsx')"> </th>
                                        </tr>
                                        <tr>

                                            <th data-column-id="concern_subtype_chklist.c_subtype_Reference_No">Standard</th>
                                            <th data-column-id="concern_subtype_chklist.Reference_No">Ref.</th>
                                            <th data-column-id="concern_subtype_chklist.Measurable_Element">MeasurableElement</th>
                                            <th data-column-id="concern_subtype_chklist.Checkpoint">Checkpoint </th>
                                            <th data-column-id="concern_subtype_chklist.Means_of_Verification">Ass. methord</th>
                                            <th data-column-id="concern_subtype_chklist.Means_of_Verification">Means of Verification</th>
                                            <th data-column-id="chk_list_assessment.ass_compliance">Comp.</th>
                                        </tr>
                                    </thead>
                                    <?php
                                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>


                                        <tbody>
                                            <tr>

                                                <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                                                <td><?php echo $row['csqa_reference_id']; ?></td>
                                                <td><?php echo $row['Measurable_Element']; ?></td>
                                                <td><?php echo $row['Checkpoint']; ?></td>
                                                <td><?php echo $row['Assessment_Method']; ?></td>
                                                <td><?php echo $row['Means_of_Verification']; ?></td>
                                                <td><?php echo $row['ass_compliance']; ?></td>
                                            </tr>
                                        <?php }
                                                } else {
                                        ?>
                                        <p>
                                            <button addEventListener="function()" type="button" class="btn btn-warning"><?php echo "Sorry No complinace..!"; ?><i class="bi bi-check-circle"></i></button>
                                        </p>


                            <?php  }
                                                mysqli_free_result($query);
                                                $con->next_result();
                                            }
                                        } ?>
                                        </tbody>
                                        <script>
                                            function ExportToExcel(type, fn, dl) {
                                                var elt = document.getElementById('tbl_exporttable_to_xls');
                                                var wb = XLSX.utils.table_to_book(elt, {
                                                    sheet: "sheet1"
                                                });
                                                return dl ?
                                                    XLSX.write(wb, {
                                                        bookType: type,
                                                        bookSST: true,
                                                        type: 'base64'
                                                    }) :
                                                    XLSX.writeFile(wb, fn || ('Partial_nonpartial_Compliance_details.' + (type || 'xlsx')));
                                            }
                                        </script>
                                </table>



                                <!-----data end------->
            </div>
        </div>
    </section>
</main><!-- End #main -->
<!-- ----working area end ----->

<script>
    $(document).ready(function() {
        $('#f1').change(function() {
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