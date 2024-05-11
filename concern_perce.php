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
                                            }
?>