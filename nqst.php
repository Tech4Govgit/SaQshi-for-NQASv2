<?php
include('session.php');
include_once("db.php");
$dept_id = $_SESSION['dept_id1'];
$_SESSION['Cn'] = 0;
$f_type_id = $_SESSION['f_type_id'];
$fid = $_SESSION['u_facilityid'];
$query = "select Health_facilty_type,fac_name from facilities where fac_id=$fid";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$faciltytype = $row['Health_facilty_type'];
$facname = $row['fac_name'];
$_SESSION['facilty_type'] = $faciltytype;
$lang = $_SESSION['lang'];
if ($lang == 1) {
  $_SESSION['concern_name'] = 'concern_name_assam';
  $area_of_con_subtypedeatils = 'area_of_con_subtypedeatils_assam';
  $_SESSION['M'] = 'Measurable_Element_assam';
  $_SESSION['C'] = 'Checkpoint_assam';
  $_SESSION['Means'] = 'Means_of_Verification_assam';
} elseif ($lang == 2) {
  $_SESSION['concern_name'] = 'concern_name_ben';
  $area_of_con_subtypedeatils = 'area_of_con_subtypedeatils_ben';
  $_SESSION['M'] = 'Measurable_Element_ben';
  $_SESSION['C'] = 'Checkpoint_ben';
  $_SESSION['Means'] = 'Means_of_Verification_ben';
} elseif ($lang == 3) {
  $_SESSION['concern_name'] = 'concern_name_hin';
  $area_of_con_subtypedeatils = 'area_of_con_subtypedeatils_hin';
  $_SESSION['M'] = 'Measurable_Element_hin';
  $_SESSION['C'] = 'Checkpoint_hin';
  $_SESSION['Means'] = 'Means_of_Verification_hin';
} elseif ($lang == 4) {
  $_SESSION['concern_name'] = 'concern_name_odia';
  $area_of_con_subtypedeatils = 'area_of_con_subtypedeatils_odia';
  $_SESSION['M'] = 'Measurable_Element_odia';
  $_SESSION['C'] = 'Checkpoint_odia';
  $_SESSION['Means'] = 'Means_of_Verification_odia';
} elseif ($lang == 5) {
  $_SESSION['concern_name'] = 'concern_name';
  $area_of_con_subtypedeatils = 'area_of_con_subtypedeatils';
  $_SESSION['M'] = 'Measurable_Element';
  $_SESSION['C'] = 'Checkpoint';
  $_SESSION['Means'] = 'Means_of_Verification';
};
?>
<!DOCTYPE html>
<html lang="en">
<?php
include('h.php');
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Assessment</h1>
  </div><!-- End Page Title -->
  <section class="section">
    <div class="card">
      <div class="card-body">
        <form enctype="multipart/form-data" method="post" action="#">
          <div class="form-group row">
            <div class="col-auto">
              <label for="ibank">Select Area Of Concern</label>
              <select class="form-select" id="Concern" name="Concern">
                <option value="0">-Select-</option>
                <?php
                $urole = $_SESSION['urole'];
                $fsid = $_SESSION['u_facilityid'];
                $fs_user_id = $_SESSION['userid'];
                $ftype = $_SESSION['facilty_type'];
                $concern_name = $_SESSION['concern_name'];
                if ($urole == 2) {
                  $query = "CALL get_area_of_con($ftype,'$concern_name')";
                }
                $result = $con->query($query);
                if ($result->num_rows > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <option value="<?php echo $row['concern_id']; ?>"><?php echo $row['concern_name']; ?></option>
                <?php
                  }
                  mysqli_free_result($result);
                  $con->next_result();
                }
                ?>
              </select>
            </div>


            <div class="col-auto">
              <label for="ibank">Select Standard</label>
              <select class="form-select" id="category" name="category">
                <option value="0">-Select-</option>
              </select>
            </div>
            <div class="col-auto">
              <label for="dep">Select Assessment Method</label>
              <select class="form-select" id="Assessment_Method" name="Assessment_Method">
                <option value="">-Select-</option>
                <option value="SI">SI</option>
                <option value="OB">OB</option>
                <option value="PI">PI</option>
                <option value="RR">RR</option>
                <option value="RR">CI</option>
              </select>
            </div>
            <div class="col-auto">
              </br>
              <button type="submit" value="Submit" name="postsubmit" class="btn btn-outline-primary btn-sm">Show Checklist</button>
            </div>
          </div>
        </form>

        <!---- data load-------------------->



        <?php
        if (isset($_POST['postsubmit'])) {

          $M = $_SESSION['M'];
          $C = $_SESSION['C'];
          $Means = $_SESSION['Means'];
          $_SESSION['Cn'] = $_POST["Concern"];
          $_SESSION['cy'] = $_POST["category"];
          $p = $_SESSION['assperiod'];
          $F = $_SESSION['dept_id1'];
          $Fa = $_SESSION['facilty_type'];
          $Co = $_SESSION['Cn'];
          $ca = $_SESSION['cy'];
          $fid = $_SESSION['u_facilityid'];
          $_SESSION['Assessment_Method'] = $_POST['Assessment_Method'];
          $ASSm = $_SESSION['Assessment_Method'];
          if ($Co == 0 or $ca == "") {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kindly Select Area of Concern/Standard from drop down.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

          <?php //exit;
          }

          $_SESSION['q1'] = "CALL get_assessment($fid,$Fa,$Co,$ca,$p,$F,'$ASSm','$M','$C','$Means')";
          $query = $con->query($_SESSION['q1']);
          while ($row = mysqli_fetch_array($query)) {

          ?>
            <br>
            <table class="table table-fit w-auto small table-striped  table-bordered table-hover table-condensed">
              <tbody>
                <tr>
                  <th colspan="2">
                    <center>Check List details for Compliance </center>
                  </th>

                </tr>
                <tr>
                  <th data-column-id="c_subtype_id_fk">Standard</th>
                  <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                </tr>
                <tr>
                  <th data-column-id="c_subtype_id_fk">Ref.No</th>
                  <td><?php echo $row['csqa_reference_id']; ?></td>
                </tr>
                <tr>
                  <th data-column-id="Measurable_Element">MeasurableElement</th>
                  <td><?php echo $row['M']; ?></td>
                </tr>
                <tr>
                  <th data-column-id="Checkpoint">Checkpoint</th>
                  <td><?php echo $row['C']; ?></td>
                </tr>
                <tr>
                  <th data-column-id="Assessment_Method">Ass.Method</th>
                  <td><?php echo $row['Assessment_Method']; ?></td>
                </tr>
                <tr>
                  <th data-column-id="Means_of_Verification">Means of Verification</th>
                  <td><?php echo $row['Means']; ?></td>
                </tr>
                <form method="POST" action="#">
                  <tr>
                    <th data-column-id="Compliance">Compliance</th>
                    <td>
                      <select class="form-control" id="f1" name="f">
                        <option value="">-Select-</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                      </select>

                      <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                      <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['csqa_id']; ?>">
                      <input type="hidden" id="csqa_id2" name="csqa_id2" value="<?php echo $row['c_subtype_id_fk']; ?>">
                    </td>
                  </tr>
                  <tr>
                    <th>Action</th>
                    <td>
                      <button type="submit" id="postsubmit1" name="postsubmit1" class="btn btn-primary btn-sm">Save & Next </button>
                    </td>
                  </tr>
                </form>



              <?php
            }
            mysqli_free_result($query);
            $con->next_result();
              ?>
              <tr>
                <td colspan="2"> <button type="button" class="btn btn-outline-success">
                    <?php
                    $_SESSION['getcount'] = "CALL get_assessment_count($fid,$Fa,$Co,$ca,$F,$p)";
                    $getcount = "CALL get_assessment_count($fid,$Fa,$Co,$ca,$F,$p)";
                    $queryb = $con->query($getcount);
                    while ($row = mysqli_fetch_assoc($queryb)) {
                      $p =  $row['id1'];
                      $p1 = $row['id2'];
                      $pb1 = $row['c'];
                      $p2 =  $row['id3'];
                      $p12 = $row['id4'];
                      $pb12 = $row['c2'];
                    ?>
                      <?php echo 'Area of Concern:-';
                      echo $pb1; ?> <span class="badge bg-warning"><?php echo $p; ?></span>/ out of <span class="badge bg-warning"><?php echo $p1; ?></span>completed
                  </button>
                </td>
              </tr>
              <tr>
                <td colspan="4"><button type="button" class="btn btn-outline-success">
                    <?php echo 'Standard:-';
                      echo $pb12; ?> <span class="badge bg-warning"><?php echo $p2; ?></span>/ out of <span class="badge bg-warning"><?php echo $p12; ?></span>completed
                </td></button>
              </tr>
              </tbody>
            </table>
            <?php }
                    mysqli_free_result($queryb);
                    $con->next_result();
                  } elseif (isset($_POST['postsubmit1'])) {
                    $ass_compliance = $_POST['f'];
                    if ($ass_compliance == 0 or  $ass_compliance == 1 or  $ass_compliance == 2) {

                      $fd = $_SESSION['dept_id1'];
                      $q = $_POST['csqa_id1'];
                      $_SESSION['$subtye'] = $_POST['csqa_id2'];
                      $id = $_POST['csqa_id'];
                      $query1 = "select area_of_con_id_fk,c_subtype_id_fk from concern_subtype_chklist where csqa_id=$id";
                      $queryn = mysqli_query($con, $query1);
                      while ($row = mysqli_fetch_array($queryn)) {
                        $areofconcern = $row['area_of_con_id_fk'];
                        $subtype = $row['c_subtype_id_fk'];
                      }
                      //$obj=$_POST['observation'];
                      //echo $q;
                      $facid = $_SESSION['u_facilityid'];
                      $uid = $_SESSION['userid'];

                      $conc = $_SESSION['Cn'];
                      // echo  $conc;
                      $concsub = $_SESSION['$subtye'];
                      $assperiod = $_SESSION['assperiod'];
                      //mysqli_query($conn,"insert into chk_list_assessment (fac_id_fk,fac_dept_id_fk,c_subtype_id_fk,area_of_con_id_fk,csqa_id_fk,ass_compliance,ass_period_id,user_id)values($facid,$fd,$concsub,$conc,$id,$ass_compliance,1,$uid)");
                      $insertq = "CALL in_assessment($facid,$fd,$subtype, $areofconcern,$id,$ass_compliance,$assperiod,$uid)";
                      $insertresult = $con->query($insertq);

                      if ($insertresult) {

            ?>
            </br>
              <p>
                <button addEventListener="function()"  type="button" class="btn btn-success"><?php echo "Compliance Added ..!"; ?><i class="bi bi-check-circle"></i></button>
              </p>
            <?php
                        //mysqli_free_result($insertresult);
                        //$con->next_result();

                      } else {
                        echo "sorry";
                      }
                      $query1 = $con->query($q);
                      while ($row = mysqli_fetch_array($query1)) {
            ?>
              <table class="table table-fit w-auto small table-striped  table-bordered table-hover table-condensed">
                <tbody>
                  <tr>
                    <th colspan="2">
                      <center>Check List details for Compliance </center>
                    </th>

                  </tr>
                  <tr>
                    <th data-column-id="c_subtype_id_fk">Standard</th>
                    <td><?php echo $row['c_subtype_Reference_No_fk']; ?></td>
                  </tr>
                  <tr>
                    <th data-column-id="c_subtype_id_fk">Ref.No</th>
                    <td><?php echo $row['csqa_reference_id']; ?></td>
                  </tr>
                  <tr>
                    <th data-column-id="Measurable_Element">MeasurableElement</th>
                    <td><?php echo $row['M']; ?></td>
                  </tr>
                  <tr>
                    <th data-column-id="Checkpoint">Checkpoint</th>
                    <td><?php echo $row['C']; ?></td>
                  </tr>
                  <tr>
                    <th data-column-id="Assessment_Method">Ass.Method</th>
                    <td><?php echo $row['Assessment_Method']; ?></td>
                  </tr>
                  <tr>
                    <th data-column-id="Means_of_Verification">Means of Verification</th>
                    <td><?php echo $row['Means']; ?></td>
                  </tr>
                  <form method="POST" action="#">
                    <tr>
                      <th data-column-id="Compliance">Compliance</th>
                      <td>
                        <select class="form-control" id="f" name="f">
                          <option value="">-Select-</option>
                          <option value="0">0</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                        </select>
                        <input type="hidden" id="csqa_id1" name="csqa_id1" value="<?php echo  $_SESSION['q1']; ?>">
                        <input type="hidden" id="csqa_id" name="csqa_id" value="<?php echo $row['csqa_id']; ?>">
                        <input type="hidden" id="csqa_id2" name="csqa_id2" value="<?php echo $row['c_subtype_id_fk']; ?>">
                      </td>
                    </tr>
                    <tr>
                      <th>
                        Action
                      </th>
                      <td>

                        <button type="submit" id="postsubmit1" name="postsubmit1" class="btn btn-primary btn-sm">Save & Next</button>

                      </td>
                    </tr>
                  </form>

                <?php }
                      mysqli_free_result($query1);
                      $con->next_result();
                ?>



                <tr>
                  <td colspan="2"> <button type="button" class="btn btn-outline-success">
                      <?php
                      $queryc = $con->query($_SESSION['getcount']);
                      while ($row = mysqli_fetch_assoc($queryc)) {
                        $p =  $row['id1'];
                        $p1 = $row['id2'];
                        $pb1 = $row['c'];
                        $p2 =  $row['id3'];
                        $p12 = $row['id4'];
                        $pb12 = $row['c2'];
                      ?>
                        <?php echo 'Area of Concern:-';
                        echo $pb1; ?> <span class="badge bg-warning"><?php echo $p; ?></span>/ out of <span class="badge bg-warning"><?php echo $p1; ?></span>completed
                    </button>
                  </td>
                </tr>
                <tr>
                  <td colspan="4"><button type="button" class="btn btn-outline-success">
                      <?php echo 'Standard:-';
                        echo $pb12; ?> <span class="badge bg-warning"><?php echo $p2; ?></span>/ out of <span class="badge bg-warning"><?php echo $p12; ?></span>completed
                  </td></button>
                </tr>
                </tbody>
              </table>
            <?php
                      }
                    } else {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Kindly Select Compliance(0 or 1 or 2) from drop down.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php }
                  }
        ?>
        </tbody>
        </table>

        <!-----data end------->
      </div>
    </div>
  </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->

<script type="text/JavaScript">
  $(document).ready(function() {
                $("#Concern").on('change', function() {
                    var Concernid = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "response.php",
                        data: {
                            cid: Concernid,

                        },
                        datatype: "html",
                        success: function(data) {
                            $("#category").html(data);


                        }
                    });
                });

            });
        </script>
<script type="text/JavaScript">
$(document).ready(function(){   
    $("p").show().delay(3000).fadeOut();
     });
</script>

<!-- Template Main JS File -->
<?php
include('f.php');
?>


</body>

</html>