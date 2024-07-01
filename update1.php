                    <?php
                    include_once("db.php");
                    include('session.php');
                   // $dist = $_SESSION['dist'];
                    $dep= $_SESSION['dept_id1'] ;
                    $pi= $_SESSION['assperiod'];
                    $fid=$_SESSION['u_facilityid'];
                    $queryd1 = $con->query("SELECT count(ass_id) as total FROM chk_list_assessment 
where ass_compliance in (0,1)  and moic_remarcks is null and fac_id_fk=$fid
and fac_dept_id_fk=$dep  and ass_period_id=$pi;");
                    while ($row = mysqli_fetch_assoc($queryd1)) {
                        $p =  $row['total'];
                        echo json_encode(['data' => $p]);
                    }

                    ?>