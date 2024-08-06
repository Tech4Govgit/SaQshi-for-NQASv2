<?php
include('session.php');
include_once("db.php");
//$sessionid = session_id();
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h1.php');
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
                <label> <a href="export_facility_all_rpt.php?id=<?php echo $_SESSION['u_facilityid']; ?>">Download compliance for all departments*<i class="bi bi-arrow-down-circle-fill"></a></i> </label>
            </div>

            <?php
            if (isset($_POST['submit1'])) {

                
          $dept_id = $_POST["Facility_Department"];
          $_SESSION['period'] = $_POST['Period'];
          $Fa = $_SESSION['u_facilityid'];
          $fat = $_SESSION['f_type_id'];
          $p = $_SESSION['period'];
          $t = $_SESSION['userid'];
         $tablequerydepartment = "SELECT dept_name,fac_dept_id from fac_department 
where fac_dept_id in (select fac_dept_id_fk from chk_list_assessment where fac_id_fk=13088 and ass_period_id=57)";
          $q = mysqli_query($con, $tablequerydepartment);                   
          while ($row = mysqli_fetch_array($q)) {
            ?>
            <table class="table w-auto small table-striped table-bordered table-hover table-condensed" style="width:100%" id="tbl_exporttable_to_xls">
            <thead>    
            <tr>
            <center>  <th colspan="6" style="background-color:#FF5733"><?php $_SESSION['dept']=$row['fac_dept_id'];echo $row['dept_name']; ?> </th> </center>
          </tr>
          <th colspan="1"><img src="assets/img/ex.png" onclick="ExportToExcel('xlsx')"> </th>
          </thead>
          <tbody>
          <tr>
                 
                 <td>Reference No.</td>
                 <td>Measurable Element</td>
                 <td>Check point</td>
                 <td>Comp</td>
                 <td>AccMethord</td>
                 <td>Mofv</td>
                 
                 
 </tr>
               <?php
               $d=3;
$tablequeryareofconcern="select concern_name,concern_id from area_of_concern where concern_id
in( select area_of_con_id_fk from chk_list_assessment where fac_id_fk=13088 and ass_period_id=57 and fac_dept_id_fk=$d)";
$q2 = mysqli_query($con, $tablequeryareofconcern);
while ($row = mysqli_fetch_array($q2)) {
    
?>
<tr>
<center><th colspan="6" style="background-color:#FFC300"><?php $_session['con_id']=$row['concern_id'];echo $row['concern_name']; ?> </th></center>
               </tr>
               
         
          <?php
          $conid=$_session['con_id'];
          $tablequerysubtype="SELECT Reference_No,c_subtype_id,area_of_con_subtypedeatils FROM sarbsoft_nqa.area_of_concern_subtype where c_subtype_id in(
select distinct c_subtype_id_fk from chk_list_assessment where fac_id_fk=13088 and ass_period_id=57 and fac_dept_id_fk=$d
 and  area_of_con_id_fk=$conid and fac_type_id=$fat) order by c_subtype_id asc";
          $q4 = mysqli_query($con, $tablequerysubtype);
          while ($row = mysqli_fetch_array($q4)) {
?>
<tr>
<th colspan="1"  style="background-color:#FFC300"><?php $_session['sub_con_id']=$row['c_subtype_id'];echo $row['Reference_No']; ?> </th>
<th colspan="5"  style="background-color:#FFC300"><?php echo $row['area_of_con_subtypedeatils']; ?> </th>
            
          </tr>
          
    
    
<?php
$sub_id=$_session['sub_con_id'];
$tablequeryrest = "CALL fac_tot_reports($Fa,$t,$sub_id,$conid,$d)";
$q3 = mysqli_query($con, $tablequeryrest);                   
while ($row = mysqli_fetch_array($q3)) {

    ?>
    <tr>
               
                                    
                                    <td ><?php echo $row['csqa_reference_id']; ?></td>
                                    <td><?php echo $row['Measurable_Element']; ?></td>
                                    <td><?php echo $row['Checkpoint']; ?></td>
                                    <td><?php echo $row['ass_compliance']; ?></td>
                                    <td><?php echo $row['Assessment_Method']; ?></td>
                                    <td><?php echo $row['Means_of_Verification']; ?></td>
                                    
                               
</td>
    <?php
}
mysqli_free_result($q3);
$con->next_result(); 

}
mysqli_free_result($q4);
$con->next_result(); 
               ?>
             
        <?php  }
        mysqli_free_result($q2);
        $con->next_result(); 
     
        
        }
        mysqli_free_result($q);
$con->next_result(); 
    }

            ?>
                <tbody>     
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
<!-- ======= Footer ======= -->
<?php
include('f.php');
?>

</body>
<script>
    function getText(element) {
        var textHolder = element.options[element.selectedIndex].text
        document.getElementById("Department_name_hidden").value = textHolder;
    }
</script>

</html>