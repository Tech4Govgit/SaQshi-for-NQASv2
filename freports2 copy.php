<?php
include('session.php');
include_once("db.php");
//$sessionid = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h.php');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reports</h1>
    </div><!-- End Page Title -->

    <!-- ----working area ----->
    <section class="section">
        <div class="card">
            <div class="card-body">

                <form enctype="multipart/form-data" method="post" action="#">

                    <div class="form-group row">
                        <div class="col-auto">
                            <label for="complainant">Select Department</label>
                            <select class="form-control" id="Facility_Department" name="Facility_Department" onchange="getText(this)">
                                <option value="0">--Select--</option>
                                <?php
                                $fsid = $_SESSION['u_facilityid'];
                                $query = "SELECT  fac_dept_id, dept_name FROM fac_department where fac_dept_id in (select fac_dept_id from fac_dept_map where fac_id=$fsid)";
                                // $query = mysqli_query($con, $qr);
                                $result = $con->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $row['fac_dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                            <input type="hidden" name="Department_name_hidden" id="Department_name_hidden">

                        </div>
                        <div class="col-auto">
                            <label for="complainant">Select Assessment </label>
                            <select class="form-control" id="Period" name="Period">
                                <option value="0">---Select--</option>
                                <?php
                                $fsid = $_SESSION['u_facilityid'];
                                $query = "SELECT distinct id, ass_name  FROM assessment_desc where fac_id_fk=$fsid";
                                // $query = mysqli_query($con, $qr);
                                $result = $con->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['ass_name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-auto">
                            <label for="complainant">Select Reports type </label>
                            <select class="form-control" id="rt" name="rt">
                                <option value="0">---Select--</option>
                                <option value="1">Area of concern and standard NQAS</option>
                                <option value="2">Area of concern NQAS</option>
                                <option value="3">Department NQAS</option>
                                <option value="4">MusQan </option>
                                <option value="5">LaQshya</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <br>
                            <button type="submit" value="Submit1" name="submit1" class="btn btn-primary">View</button>

                        </div>
                    </div>


                </form>
            </div>

            <?php
            if (isset($_POST['submit1'])) {
            ?>
                <script>
                    $("#Period option").each(function(index) {
                        var item = $(this).val();
                        if (item == "<?php echo $_POST['Period'] ?>") {
                            $(this).prop('selected', true);
                        }
                    });
                </script>
                <script>
                    $("#rt option").each(function(index) {
                        var item = $(this).val();
                        if (item == "<?php echo $_POST['rt'] ?>") {
                            $(this).prop('selected', true);
                        }
                    });
                </script>
                <script>
                    $("#Facility_Department option").each(function(index) {
                        var item = $(this).val();
                        if (item == "<?php echo $_POST['Facility_Department'] ?>") {
                            $(this).prop('selected', true);
                        }
                    });
                </script>

                <?php
                $dept_id = $_POST["Facility_Department"];
                $rt = $_POST["rt"];
                if ($rt == 1) {
                    if ($dept_id == 5 or $dept_id == 6 or $dept_id == 7 or $dept_id == 23)

                ?>

                    <center>
                        <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:100%" id="tbl_exporttable_to_xls">

                            <thead>
                                <tr>
                                    <?php { ?>
                                        <th colspan="2" rowspan="2">
                                            <center>
                                                <img src="assets/img/n.jpg" alt="" height=50 width=50>
                                            </center>
                                        </th> <?php } ?>
                                    <th colspan="2" style="background-color:#C34A2C">
                                        <center>
                                            <h4><?php echo $_POST["Department_name_hidden"] ?> Score card </h4>
                                        </center>
                                    </th>
                                    <th colspan="2" rowspan="2">
                                        <center>
                                            <img src="assets/img/muskan.png" alt="" height=50 width=50>
                                        </center>
                                    </th>
                                </tr>
                                <tr>

                                    <th colspan="2" style="background-color:#FFCCAE""><center>Area of Concern & Standards wise Score card</center></th>
    </tr>
</thead>
<tbody> 
    <tr>
                    <td style=" background-color:#F5F5DC ">Area of Concern.</td>
                    <td style=" background-color:#F5F5DC ">Standard</td>
                    <td style=" background-color:#F5F5DC ">Subtypes</td>
                    <td style=" background-color:#F5F5DC ">Full Marks</td>
                    <td style=" background-color:#F5F5DC ">Obtained Marks</td>
                    <td style=" background-color:#F5F5DC ">Percentage(%)</td>
    </tr>
        <?php
                    $dept_id = $_POST["Facility_Department"];
                    $_SESSION['period'] = $_POST['Period'];
                    $Fa = $_SESSION['u_facilityid'];
                    $fat = $_SESSION['f_type_id'];
                    $p = $_SESSION['period'];
                    // $t=$_SESSION['u_name'];
                    $t = $_SESSION['userid'];
                   // $tablename = "temp$t";
                    //creating temp table 
                    $tablequery = "CALL get_Standards_wise_Score_card($fat, $Fa,$dept_id,$p)";
                    $q = mysqli_query($con, $tablequery);
                    //temp table

                    while ($row = mysqli_fetch_array($q)) {
        ?>
                  
                  <tr>
                <td style=" background-color:#FFFFE0"><?php echo $row['concern_name']; ?></td>
                                    <td style="background-color:#FFFFE0"><?php echo $row['id1']; ?></td>
                                    <td style="background-color:#FFFFE0"><?php echo $row['area_of_con_subtypedeatils']; ?></td>
                                    <td style="background-color:#FFFFE0"><?php echo $row['total']; ?></td>
                                    <td style="background-color:#FFFFE0"><?php echo $row['obtained']; ?></td>
                                    <td style="background-color:#FFFFE0"><?php echo round(($row['obtained'] / $row['total']) * 100, 2) ?></td>
                                </tr>

                            <?php
                        } ?>
                            <br>
                            <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Export Score Card to Excel</button>
                            <button type="button" class="btn btn-info" onclick="Export()">Export Score Card to Pdf</button>
                        <?php } elseif ($rt == 2) {
                        $dept_id = $_POST["Facility_Department"];
                        if ($dept_id == 5 or $dept_id == 6 or $dept_id == 7 or $dept_id == 23)

                        ?>
                            <!-- ================================================================================= -->
                            <center>
                                <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:30%" id="tbl_exporttable_to_xls">
                                    <thead>
                                        <tr>
                                            <?php { ?>
                                                <th colspan="1" rowspan="1">
                                                    <center>
                                                        <img src="assets/img/n.jpg" alt="" height=100 width=100>
                                                    </center>
                                                </th> <?php } ?>
                                            <th colspan="2" style="background-color:#C34A2C">
                                                <center>
                                                    <h4><?php echo $_POST["Department_name_hidden"] ?> Score card </h4>
                                                </center>
                                            </th>
                                            <th colspan="1" rowspan="1">
                                                <center>
                                                    <img src="assets/img/muskan.png" alt="" height=100 width=100>
                                                </center>
                                            </th>
                                        </tr>

                                        <!------------------->
                                        <tr>
                                            <td style="background-color:#90EE90	" colspan="3"><?php echo $_POST["Department_name_hidden"] ?> Score</td>
                                            <?php
                                            $_SESSION['FDepartment'] = $_POST["Facility_Department"];

                                            $_SESSION['period'] = $_POST['Period'];
                                            //  $_SESSION['F_type']=$_POST["Facility_type"];
                                            //$_SESSION['Cn']=$_POST["Concern"];
                                            // $_SESSION['cy']=$_POST["category"];           

                                            $F = $_SESSION['FDepartment'];
                                            $Fa = $_SESSION['u_facilityid'];
                                            $p = $_SESSION['period'];
                                            // $ca= $_SESSION['cy'];
                                            $_SESSION['t'] = "select sum(concern_subtype_chklist.compliance)as total
                            from concern_subtype_chklist where fac_dept_id_fk=$F";
                                            $_SESSION['t1'] = mysqli_query($con, $_SESSION['t']);
                                            $queryt = $_SESSION['t1'];
                                            while ($row = mysqli_fetch_array($queryt)) {
                                                $total = $row['total'];
                                            }
                                            //==================
                                            $_SESSION['o'] = "select sum(chk_list_assessment.ass_compliance) as obtained
                        from chk_list_assessment where (chk_list_assessment.fac_id_fk=$Fa and chk_list_assessment.fac_dept_id_fk=$F and chk_list_assessment.ass_period_id=$p)";
                                            $_SESSION['o1'] = mysqli_query($con, $_SESSION['o']);
                                            $queryo = $_SESSION['o1'];
                                            while ($row = mysqli_fetch_array($queryo)) {
                                                $obtained = $row['obtained'];
                                                //====
                                                if ($obtained != null) {
                                                    $percentage = round((($obtained / $total) * 100), 2);
                                                } else {
                                                    $percentage = 0;
                                                }
                                                //=====================

                                                //=====================

                                            ?>

                                                <td style="background-color: yellow" rowspan="2">
                                                    <h3><?php echo $percentage; ?>%</h3>
                                                </td>


                                            <?php
                                            }   ?>


                                        </tr>
                                        <!---------->
                                        <tr>
                                            <th colspan="3" style="background-color:#FFCCAE""><center><h5>Area of Concern wise Score card </h5></center></th>
    </tr>
</thead>
<tbody> 
    <tr>
                   
                    <td style=" background-color:#F5F5DC ">Area of Concern</td>
                    <td style=" background-color:#F5F5DC ">Full Marks</td>
                    <td style=" background-color:#F5F5DC ">Obtained Marks</td>
                    <td style=" background-color:#F5F5DC ">Percentage(%)</td>
    </tr>
        <?php
                        $dept_id = $_POST["Facility_Department"];
                        $_SESSION['period'] = $_POST['Period'];
                        $Fa = $_SESSION['u_facilityid'];
                        $fat = $_SESSION['f_type_id'];
                        $p = $_SESSION['period'];
                        $t = $_SESSION['u_name'];
                        $t = $_SESSION['userid'];

                        //creating temp table 
                        $tablequery1 = "call Area_of_concern_NQAS($fat,$Fa,$dept_id,$p)";

                        $q2 = mysqli_query($con, $tablequery1);

                        while ($row = mysqli_fetch_array($q2)) {
        ?>
                  
                  <tr>
                      
                      <td style=" background-color:#FFFFE0"><?php echo $row['concern_name']; ?></td>
                                            <td style="background-color:#FFFFE0"><?php echo $row['total']; ?></td>
                                            <td style="background-color:#FFFFE0"><?php echo $row['Obtained']; ?></td>
                                            <td style="background-color:#FFFFE0"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?></td>
                                        </tr>

                                    <?php
                                } ?>
                                    <br>
                                    <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Export Score Card to Excel</button>
                                    <button type="button" class="btn btn-info" onclick="Export()">Export Score Card to Pdf</button>
                                <?php } elseif ($rt == 3) {
                                $dept_id = $_POST["Facility_Department"];
                                if ($dept_id == 5 or $dept_id == 6 or $dept_id == 7 or $dept_id == 23)
                                ?>
                                    <!-- ================================================================================= -->
                                    <center>
                                        <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:30%" id="tbl_exporttable_to_xls">
                                            <thead>
                                                <tr>
                                                    <?php { ?>
                                                        <th colspan="2" rowspan="1">
                                                            <center>
                                                                <img src="assets/img/n.jpg" alt="" height=100 width=100>
                                                            </center>
                                                        </th> <?php } ?>

                                                    <th colspan="2" rowspan="1">
                                                        <center>
                                                            <img src="assets/img/muskan.png" alt="" height=100 width=100>
                                                        </center>
                                                    </th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="4" style="background-color:#C34A2C">
                                                        <center>
                                                            <h4><?php echo $_POST["Department_name_hidden"] ?> Score card </h4>
                                                        </center>
                                                    </th>
                                                </tr>
                                                <tr>

                                                    <td style="background-color:#F5F5DC	">Department</td>
                                                    <td style="background-color:#F5F5DC	">Full Marks</td>
                                                    <td style="background-color:#F5F5DC	">Obtained Marks</td>
                                                    <td style="background-color:#F5F5DC	">Percentage(%)</td>
                                                </tr>
                                                <?php
                                                $dept_id = $_POST["Facility_Department"];
                                                $_SESSION['period'] = $_POST['Period'];
                                                $Fa = $_SESSION['u_facilityid'];
                                                $fat = $_SESSION['f_type_id'];
                                                $p = $_SESSION['period'];
                                                $t = $_SESSION['u_name'];
                                                $t = $_SESSION['userid'];
                                                //creating temp table 
                                                $tablequery1 = "call Department_NQAS($fat,$Fa,$dept_id,$p)";
                                                $q3 = mysqli_query($con, $tablequery1);

                                                while ($row = mysqli_fetch_array($q3)) {
                                                ?>

                                                    <tr>

                                                        <td style="background-color:#FFFFE0"><?php echo $row['dept_name']; ?></td>
                                                        <td style="background-color:#FFFFE0"><?php echo $row['total']; ?></td>
                                                        <td style="background-color:#FFFFE0"><?php echo $row['Obtained']; ?></td>
                                                        <td style="background-color:#FFFFE0"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?></td>
                                                    </tr>

                                                <?php
                                                }
                                                // mysqli_free_result($q3);
                                                //  $con->next_result(); 
                                                ?>
                                                <br>
                                                <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Export Score Card to Excel</button>
                                                <button type="button" class="btn btn-info" onclick="Export()">Export Score Card to Pdf</button>
                                            <?php } elseif ($rt == 4) {
                                            $dept_id = $_POST["Facility_Department"];
                                            if ($dept_id == 5 or $dept_id == 6 or $dept_id == 7 or $dept_id == 23)

                                            ?>
                                                <!-- ================================================================================= -->
                                                <center>
                                                    <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:30%" id="tbl_exporttable_to_xls">
                                                        <thead>
                                                            <tr>
                                                                <?php { ?>
                                                                    <th colspan="1" rowspan="1">
                                                                        <center>
                                                                            <img src="assets/img/n.jpg" alt="" height=100 width=100>
                                                                        </center>
                                                                    </th> <?php } ?>
                                                                <th colspan="2">
                                                                    <center>
                                                                        <h4>MusQan Score card </h4>
                                                                    </center>
                                                                </th>
                                                                <th colspan="1" rowspan="1">
                                                                    <center>
                                                                        <img src="assets/img/muskan.png" alt="" height=100 width=100>
                                                                    </center>
                                                                </th>

                                                            </tr>

                                                            <tr>
                                                                <th colspan="4" style="background-color:#FFCCAE""><center><h4>Area of Concern wise Score card </h4></center></th>
                                           
                                        </tr>

</thead>
<tbody> 
    <tr>
                   
                    <td style=" background-color:#F5F5DC ">Area of Concern</td>
                    <td style=" background-color:#F5F5DC ">Full Marks</td>
                    <td style=" background-color:#F5F5DC ">Obtained Marks</td>
                    <td style=" background-color:#F5F5DC ">Percentage(%)</td>
                   
    </tr>
        <?php
                                            $dept_id = $_POST["Facility_Department"];
                                            $_SESSION['period'] = $_POST['Period'];
                                            $Fa = $_SESSION['u_facilityid'];
                                            $fat = $_SESSION['f_type_id'];
                                            $p = $_SESSION['period'];
                                            //$t = $_SESSION['u_name'];
                                            $t = $_SESSION['userid'];
                                            //   $tablename = "temp$t";
                                            //creating temp table 
                                            $tablequery12 = "call musqan($fat,$Fa,$p)";

                                            $q4 = $con->query($tablequery12);

                                            while ($row = mysqli_fetch_array($q4)) {
        ?>
                  
                  <tr>
                      
                      <td style=" background-color:#FFFFE0"><?php echo $row['concern_name']; ?></td>
                                                                <td style="background-color:#FFFFE0"><?php echo $row['total']; ?></td>
                                                                <td style="background-color:#FFFFE0"><?php echo $row['Obtained']; ?></td>
                                                                <td style="background-color:#FFFFE0"><?php echo round(($row['Obtained'] / $row['total']) * 100, 2) ?></td>

                                                            </tr>
                                                        <?php
                                                        //  mysqli_free_result($q4);
                                                        // $con->next_result();
                                                    }

                                                        ?>

                                                        <br>
                                                        <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Export Score Card to Excel</button>
                                                        <button type="button" class="btn btn-info" onclick="Export()">Export Score Card to Pdf</button>

                                                </center>


                                        <?php

                                        }
                                    } ?>


                                        <!-- ================================================================================= -->



                                            </tbody>
                                        </table>
                                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
                                        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
                                        <script type="text/javascript">
                                            function Export() {
                                                html2canvas(document.getElementById('tbl_exporttable_to_xls'), {
                                                    onrendered: function(canvas) {
                                                        var data = canvas.toDataURL();
                                                        var docDefinition = {
                                                            content: [{
                                                                image: data,
                                                                width: 300
                                                            }]
                                                        };
                                                        pdfMake.createPdf(docDefinition).download("ScoreCard.pdf");
                                                    }
                                                });
                                            }
                                        </script>
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
                                                    XLSX.writeFile(wb, fn || ('Facility_Score Card.' + (type || 'xlsx')));
                                            }
                                        </script>
                                    </center>






        </div>
        </div>
    </section>
</main><!-- End #main -->
<!-- ----working area end ----->
<!-- ======= Footer ======= -->
<?php
include('f.php');
?>


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
<script src="assets/js/main.js"></script>


</body>
<script>
    function getText(element) {
        var textHolder = element.options[element.selectedIndex].text
        document.getElementById("Department_name_hidden").value = textHolder;
    }
</script>

</html>