                    <?php
                    include_once("db.php");
                    include('session.php');
                        $dist = $_SESSION['dist'];
                        $queryd1 = $con->query("select count(ass_id)as total   from chk_list_assessment
                            where user_id in (select u_id from s_user where dist_id= $dist)  and moic_remarcks='Non achievable' and DQA_remarcks is null;");
                        while ($row = mysqli_fetch_assoc($queryd1)) {
                            $p =  $row['total'];
                            echo json_encode(['data' => $p]);
                        }
                      
                        ?>