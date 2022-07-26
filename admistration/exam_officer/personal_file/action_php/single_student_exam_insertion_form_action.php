<?php

    session_start();

    include('../../action_php/database.php');

    

        // sigle student exam insertion???????????????????????????????????????????????????????????????????????????

        if ($_POST['action'] == 'single student exam insertion') {

                
                
            
            $class = mysqli_real_escape_string($conn, $_POST['class']);
            $term = mysqli_real_escape_string($conn, $_POST['term']);
            $session = mysqli_real_escape_string($conn, $_POST['session']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);

            $addmission_number = $_POST['addmission_num'];

            $array = array($class, 'exam', 'table');
            $class_exam_table = implode('_', $array);

            $query = "SELECT * FROM $class_exam_table WHERE session = '$session' AND term = '$term' AND addmission_num = '$addmission_number'";
            $query_run = mysqli_query($conn, $query);

            $num = mysqli_num_rows($query_run);

            if ($num > 0) {
                
                $output = "exam scores of this student already entered";
            }else{

                if ($category == 'jenior') {
                    
                    //foreach ($addmission_numbers as $addmission_number) {

                        $name = mysqli_real_escape_string($conn, $_POST['name'.$addmission_number]);

                        $eng = mysqli_real_escape_string($conn, $_POST['eng'.$addmission_number]);
                        $rel = mysqli_real_escape_string($conn, $_POST['rel'.$addmission_number]);
                        $bus = mysqli_real_escape_string($conn, $_POST['bus'.$addmission_number]);
                        $lit = mysqli_real_escape_string($conn, $_POST['lit'.$addmission_number]);

                        $cca = mysqli_real_escape_string($conn, $_POST['cca'.$addmission_number]);
                        $fre = mysqli_real_escape_string($conn, $_POST['fre'.$addmission_number]);
                        $mat = mysqli_real_escape_string($conn, $_POST['mat'.$addmission_number]);
                        $b_s = mysqli_real_escape_string($conn, $_POST['b/s'.$addmission_number]);

                        $h_e = mysqli_real_escape_string($conn, $_POST['h/e'.$addmission_number]);
                        $agri = mysqli_real_escape_string($conn, $_POST['agri'.$addmission_number]);
                        $civ = mysqli_real_escape_string($conn, $_POST['civ'.$addmission_number]);
                        $phe = mysqli_real_escape_string($conn, $_POST['phe'.$addmission_number]);

                        $b_t = mysqli_real_escape_string($conn, $_POST['b/t'.$addmission_number]);
                        $com = mysqli_real_escape_string($conn, $_POST['com'.$addmission_number]);
                        //$ = mysqli_real_escape_string($conn, $_POST[''$addmission_number]);

                        


                        // selecting first ca record from table????????????????????????????????????


                        $array_two = array($class, $term, 'term', 'ca', 'table');
                        $class_ca_table = implode('_', $array_two);

                        $query_three = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca1' AND addmission_num = '$addmission_number'";

                        $query_run_three = mysqli_query($conn, $query_three);

                        $num_three = mysqli_num_rows($query_run_three);

                        if ( $num_three > 0) {
                            
                            $row_three = mysqli_fetch_array($query_run_three);

                            $f_eng = $row_three['eng'];
                            $f_rel = $row_three['rel'];
                            $f_bus = $row_three['bus'];

                            $f_lit = $row_three['lit'];
                            $f_cca = $row_three['cca'];
                            $f_fre = $row_three['fre'];

                            $f_mat = $row_three['mat'];
                            $f_b_s = $row_three['b_s'];
                            $f_h_e = $row_three['h_e'];

                            $f_agri = $row_three['agri'];
                            $f_civ = $row_three['civ'];
                            $f_phe = $row_three['phe'];

                            $f_b_t = $row_three['b_t'];
                            $f_com = $row_three['com'];
                            
                        }else{

                            $f_eng = 0;
                            $f_rel = 0;
                            $f_bus = 0;

                            $f_lit = 0;
                            $f_cca = 0;
                            $f_fre = 0;

                            $f_mat = 0;
                            $f_b_s = 0;
                            $f_h_e = 0;

                            $f_agri = 0;
                            $f_civ = 0;
                            $f_phe = 0;

                            $f_b_t = 0;
                            $f_com = 0;
                            
                        }



                        // selecting second ca record from table????????????????????????????????????

                        //$array_two = array($class, $term, 'term', 'ca', 'table');
                        //$class_ca_table = implode('_', $array_two);

                        $query_four = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca2' AND addmission_num = '$addmission_number'";

                        $query_run_four = mysqli_query($conn, $query_four);

                        $num_four = mysqli_num_rows($query_run_four);

                        if ( $num_four > 0) {
                            
                            $row_four = mysqli_fetch_array($query_run_four);

                            $s_eng = $row_four['eng'];
                            $s_rel = $row_four['rel'];
                            $s_bus = $row_four['bus'];

                            $s_lit = $row_four['lit'];
                            $s_cca = $row_four['cca'];
                            $s_fre = $row_four['fre'];

                            $s_mat = $row_four['mat'];
                            $s_b_s = $row_four['b_s'];
                            $s_h_e = $row_four['h_e'];

                            $s_agri = $row_four['agri'];
                            $s_civ = $row_four['civ'];
                            $s_phe = $row_four['phe'];

                            $s_b_t = $row_four['b_t'];
                            $s_com = $row_four['com'];
                            
                        }else{

                            $s_eng = 0;
                            $s_rel = 0;
                            $s_bus = 0;

                            $s_lit = 0;
                            $s_cca = 0;
                            $s_fre = 0;

                            $s_mat = 0;
                            $s_b_s = 0;
                            $s_h_e = 0;

                            $s_agri = 0;
                            $s_civ = 0;
                            $s_phe = 0;

                            $s_b_t = 0;
                            $s_com = 0;
                            
                        }


                        
                        // selecting third ca record from table????????????????????????????????????

                        //$array_two = array($class, $term, 'term', 'ca', 'table');
                        //$class_ca_table = implode('_', $array_two);

                        $query_five = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca3' AND addmission_num = '$addmission_number'";

                        $query_run_five = mysqli_query($conn, $query_five);

                        $num_five = mysqli_num_rows($query_run_five);

                        if ( $num_five > 0) {
                            
                            $row_five = mysqli_fetch_array($query_run_five);

                            $t_eng = $row_five['eng'];
                            $t_rel = $row_five['rel'];
                            $t_bus = $row_five['bus'];

                            $t_lit = $row_five['lit'];
                            $t_cca = $row_five['cca'];
                            $t_fre = $row_five['fre'];

                            $t_mat = $row_five['mat'];
                            $t_b_s = $row_five['b_s'];
                            $t_h_e = $row_five['h_e'];

                            $t_agri = $row_five['agri'];
                            $t_civ = $row_five['civ'];
                            $t_phe = $row_five['phe'];

                            $t_b_t = $row_five['b_t'];
                            $t_com = $row_five['com'];
                            
                        }else{

                            $t_eng = 0;
                            $t_rel = 0;
                            $t_bus = 0;

                            $t_lit = 0;
                            $t_cca = 0;
                            $t_fre = 0;

                            $t_mat = 0;
                            $t_b_s = 0;
                            $t_h_e = 0;

                            $t_agri = 0;
                            $t_civ = 0;
                            $t_phe = 0;

                            $t_b_t = 0;
                            $t_com = 0;
                            
                        }

                        //intval("10");


                        $to_eng = intval($eng) + intval($f_eng) + intval($s_eng) + intval($t_eng);
                        $to_rel = intval($rel) + intval($f_rel) + intval($s_rel) + intval($t_rel);
                        $to_bus = intval($bus) + intval($f_bus) + intval($s_bus) + intval($t_bus);

                        $to_lit = intval($lit) + intval($f_lit) + intval($s_lit) + intval($t_lit);
                        $to_cca = intval($cca) + intval($f_cca) + intval($s_cca) + intval($t_cca);
                        $to_fre = intval($fre) + intval($f_fre) + intval($s_fre) + intval($t_fre);

                        $to_mat = intval($mat) + intval($f_mat) + intval($s_mat) + intval($t_mat);
                        $to_b_s = intval($b_s) + intval($f_b_s) + intval($s_b_s) + intval($t_b_s);
                        $to_h_e = intval($h_e) + intval($f_h_e) + intval($s_h_e) + intval($t_h_e);

                        $to_agri = intval($agri) + intval($f_agri) + intval($s_agri) + intval($t_agri);
                        $to_civ = intval($civ) + intval($f_civ) + intval($s_civ) + intval($t_civ);
                        $to_phe = intval($phe) + intval($f_phe) + intval($s_phe) + intval($t_phe);

                        $to_b_t = intval($b_t) + intval($f_b_t) + intval($s_b_t) + intval($t_b_t);
                        $to_com = intval($com) + intval($f_com) + intval($s_com) + intval($t_com);


                        $total_score = $to_eng + $to_rel + $to_bus + $to_lit + $to_cca + $to_fre + $to_mat + $to_b_s + $to_h_e + $to_agri + $to_civ + $to_phe + $to_b_t + $to_com;








                        
                        $query_two = "INSERT INTO $class_exam_table(name, addmission_num, session, term, eng, rel, bus, lit, cca, fre, mat, b_s, h_e, agri, civ, phe, b_t, com, f_eng, f_rel, f_bus, f_lit, f_cca, f_fre, f_mat, f_b_s, f_h_e, f_agri, f_civ, f_phe, f_b_t, f_com, s_eng, s_rel, s_bus, s_lit, s_cca, s_fre, s_mat, s_b_s, s_h_e, s_agri, s_civ, s_phe, s_b_t, s_com, t_eng, t_rel, t_bus, t_lit, t_cca, t_fre, t_mat, t_b_s, t_h_e, t_agri, t_civ, t_phe, t_b_t, t_com, to_eng, to_rel, to_bus, to_lit, to_cca, to_fre, to_mat, to_b_s, to_h_e, to_agri, to_civ, to_phe, to_b_t, to_com, total_score, status) VALUES('$name', '$addmission_number', '$session', '$term', '$eng', '$rel', '$bus', '$lit', '$cca', '$fre', '$mat', '$b_s', '$h_e', '$agri', '$civ', '$phe', '$b_t', '$com', '$f_eng', '$f_rel', '$f_bus', '$f_lit', '$f_cca', '$f_fre', '$f_mat', '$f_b_s', '$f_h_e', '$f_agri', '$f_civ', '$f_phe', '$f_b_t', '$f_com', '$s_eng', '$s_rel', '$s_bus', '$s_lit', '$s_cca', '$s_fre', '$s_mat', '$s_b_s', '$s_h_e', '$s_agri', '$s_civ', '$s_phe', '$s_b_t', '$s_com', '$t_eng', '$t_rel', '$t_bus', '$t_lit', '$t_cca', '$t_fre', '$t_mat', '$t_b_s', '$t_h_e', '$t_agri', '$t_civ', '$t_phe', '$t_b_t', '$t_com', '$to_eng', '$to_rel', '$to_bus', '$to_lit', '$to_cca', '$to_fre', '$to_mat', '$to_b_s', '$to_h_e', '$to_agri', '$to_civ', '$to_phe', '$to_b_t', '$to_com', '$total_score', 'not approved') ";

                        $query_run_two = mysqli_query($conn, $query_two);
                    //}

                    if ($query_run_two) {
                        
                        $output = 'success';
                    }else{

                        $output = 'records fail enter';
                    }
                }else{

                    
                    //foreach ($addmission_numbers as $addmission_number) {

                        $name = mysqli_real_escape_string($conn, $_POST['name'.$addmission_number]);

                        $eng = mysqli_real_escape_string($conn, $_POST['eng'.$addmission_number]);
                        $rel = mysqli_real_escape_string($conn, $_POST['rel'.$addmission_number]);
                        $ent = mysqli_real_escape_string($conn, $_POST['ent'.$addmission_number]);
                        $phy = mysqli_real_escape_string($conn, $_POST['phy'.$addmission_number]);

                        $che = mysqli_real_escape_string($conn, $_POST['che'.$addmission_number]);
                        $bio = mysqli_real_escape_string($conn, $_POST['bio'.$addmission_number]);
                        $mat = mysqli_real_escape_string($conn, $_POST['mat'.$addmission_number]);
                        $f_m = mysqli_real_escape_string($conn, $_POST['f_m'.$addmission_number]);

                        $eco = mysqli_real_escape_string($conn, $_POST['eco'.$addmission_number]);
                        $agri = mysqli_real_escape_string($conn, $_POST['agri'.$addmission_number]);
                        $geo = mysqli_real_escape_string($conn, $_POST['geo'.$addmission_number]);
                        $gov = mysqli_real_escape_string($conn, $_POST['gov'.$addmission_number]);

                        $com = mysqli_real_escape_string($conn, $_POST['com'.$addmission_number]);
                        $civ = mysqli_real_escape_string($conn, $_POST['civ'.$addmission_number]);
                        //$ = mysqli_real_escape_string($conn, $_POST[''$addmission_number]);

                        


                        // selecting first ca record from table????????????????????????????????????


                        $array_two = array($class, $term, 'term', 'ca', 'table');
                        $class_ca_table = implode('_', $array_two);

                        $query_three = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca1' AND addmission_num = '$addmission_number'";

                        $query_run_three = mysqli_query($conn, $query_three);

                        $num_three = mysqli_num_rows($query_run_three);

                        if ( $num_three > 0) {
                            
                            $row_three = mysqli_fetch_array($query_run_three);

                            $f_eng = $row_three['eng'];
                            $f_rel = $row_three['rel'];
                            $f_ent = $row_three['ent'];

                            $f_phy = $row_three['phy'];
                            $f_che = $row_three['che'];
                            $f_bio = $row_three['bio'];

                            $f_mat = $row_three['mat'];
                            $f_f_m = $row_three['f_m'];
                            $f_eco = $row_three['eco'];

                            $f_agri = $row_three['agri'];
                            $f_geo = $row_three['geo'];
                            $f_gov = $row_three['gov'];

                            $f_com = $row_three['com'];
                            $f_civ = $row_three['civ'];
                            
                        }else{

                            $f_eng = 0;
                            $f_rel = 0;
                            $f_ent = 0;

                            $f_phy = 0;
                            $f_che = 0;
                            $f_bio = 0;

                            $f_mat = 0;
                            $f_f_m = 0;
                            $f_eco = 0;

                            $f_agri = 0;
                            $f_geo = 0;
                            $f_gov = 0;

                            $f_com = 0;
                            $f_civ = 0;
                            
                        }



                        // selecting second ca record from table????????????????????????????????????

                        //$array_two = array($class, $term, 'term', 'ca', 'table');
                        //$class_ca_table = implode('_', $array_two);

                        $query_four = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca2' AND addmission_num = '$addmission_number'";

                        $query_run_four = mysqli_query($conn, $query_four);

                        $num_four = mysqli_num_rows($query_run_four);

                        if ( $num_four > 0) {
                            
                            $row_four = mysqli_fetch_array($query_run_four);

                            $s_eng = $row_four['eng'];
                            $s_rel = $row_four['rel'];
                            $s_ent = $row_four['ent'];

                            $s_phy = $row_four['phy'];
                            $s_che = $row_four['che'];
                            $s_bio = $row_four['bio'];

                            $s_mat = $row_four['mat'];
                            $s_f_m = $row_four['f_m'];
                            $s_eco = $row_four['eco'];

                            $s_agri = $row_four['agri'];
                            $s_geo = $row_four['geo'];
                            $s_gov = $row_four['gov'];

                            $s_com = $row_four['com'];
                            $s_civ = $row_four['civ'];
                            
                        }else{

                            $s_eng = 0;
                            $s_rel = 0;
                            $s_ent = 0;

                            $s_phy = 0;
                            $s_che = 0;
                            $s_bio = 0;

                            $s_mat = 0;
                            $s_f_m = 0;
                            $s_eco = 0;

                            $s_agri = 0;
                            $s_geo = 0;
                            $s_gov = 0;

                            $s_com = 0;
                            $s_civ = 0;
                            
                        }


                        
                        // selecting third ca record from table????????????????????????????????????

                        //$array_two = array($class, $term, 'term', 'ca', 'table');
                        //$class_ca_table = implode('_', $array_two);

                        $query_five = "SELECT * FROM $class_ca_table WHERE session = '$session' AND ca = 'ca3' AND addmission_num = '$addmission_number'";

                        $query_run_five = mysqli_query($conn, $query_five);

                        $num_five = mysqli_num_rows($query_run_five);

                        if ( $num_five > 0) {
                            
                            $row_five = mysqli_fetch_array($query_run_five);

                            $t_eng = $row_five['eng'];
                            $t_rel = $row_five['rel'];
                            $t_ent = $row_five['ent'];

                            $t_phy = $row_five['phy'];
                            $t_che = $row_five['che'];
                            $t_bio = $row_five['bio'];

                            $t_mat = $row_five['mat'];
                            $t_f_m = $row_five['f_m'];
                            $t_eco = $row_five['eco'];

                            $t_agri = $row_five['agri'];
                            $t_geo = $row_five['geo'];
                            $t_gov = $row_five['gov'];

                            $t_com = $row_five['com'];
                            $t_civ = $row_five['civ'];
                            
                        }else{

                            $t_eng = 0;
                            $t_rel = 0;
                            $t_ent = 0;

                            $t_phy = 0;
                            $t_che = 0;
                            $t_bio = 0;

                            $t_mat = 0;
                            $t_f_m = 0;
                            $t_eco = 0;

                            $t_agri = 0;
                            $t_geo = 0;
                            $t_gov = 0;

                            $t_com = 0;
                            $t_civ = 0;
                            
                        }

                        //intval("10");


                        $to_eng = intval($eng) + intval($f_eng) + intval($s_eng) + intval($t_eng);
                        $to_rel = intval($rel) + intval($f_rel) + intval($s_rel) + intval($t_rel);
                        $to_ent = intval($ent) + intval($f_ent) + intval($s_ent) + intval($t_ent);

                        $to_phy = intval($phy) + intval($f_phy) + intval($s_phy) + intval($t_phy);
                        $to_che = intval($che) + intval($f_che) + intval($s_che) + intval($t_che);
                        $to_bio = intval($bio) + intval($f_bio) + intval($s_bio) + intval($t_bio);

                        $to_mat = intval($mat) + intval($f_mat) + intval($s_mat) + intval($t_mat);
                        $to_f_m = intval($f_m) + intval($f_f_m) + intval($s_f_m) + intval($t_f_m);
                        $to_eco = intval($eco) + intval($f_eco) + intval($s_eco) + intval($t_eco);

                        $to_agri = intval($agri) + intval($f_agri) + intval($s_agri) + intval($t_agri);
                        $to_geo = intval($geo) + intval($f_geo) + intval($s_geo) + intval($t_geo);
                        $to_gov = intval($gov) + intval($f_gov) + intval($s_gov) + intval($t_gov);

                        
                        $to_com = intval($com) + intval($f_com) + intval($s_com) + intval($t_com);
                        $to_civ = intval($civ) + intval($f_civ) + intval($s_civ) + intval($t_civ);


                        $total_score = $to_eng + $to_rel + $to_ent + $to_phy + $to_che + $to_bio + $to_mat + $to_f_m + $to_eco + $to_agri + $to_geo + $to_gov + $to_com + $to_civ;








                        
                        $query_two = "INSERT INTO $class_exam_table(name, addmission_num, session, term, eng, rel, ent, phy, che, bio, mat, f_m, eco, agri, geo, gov, com, civ, f_eng, f_rel, f_ent, f_phy, f_che, f_bio, f_mat, f_f_m, f_eco, f_agri, f_geo, f_gov, f_com, f_civ, s_eng, s_rel, s_ent, s_phy, s_che, s_bio, s_mat, s_f_m, s_eco, s_agri, s_geo, s_gov, s_com, s_civ, t_eng, t_rel, t_ent, t_phy, t_che, t_bio, t_mat, t_f_m, t_eco, t_agri, t_geo, t_gov, t_com, t_civ, to_eng, to_rel, to_ent, to_phy, to_che, to_bio, to_mat, to_f_m, to_eco, to_agri, to_geo, to_gov, to_com, to_civ, total_score, status) VALUES('$name', '$addmission_number', '$session', '$term', '$eng', '$rel', '$ent', '$phy', '$che', '$bio', '$mat', '$f_m', '$eco', '$agri', '$geo', '$gov', '$com', '$civ', '$f_eng', '$f_rel', '$f_ent', '$f_phy', '$f_che', '$f_bio', '$f_mat', '$f_f_m', '$f_eco', '$f_agri', '$f_geo', '$f_gov', '$f_com', '$f_civ', '$s_eng', '$s_rel', '$s_ent', '$s_phy', '$s_che', '$s_bio', '$s_mat', '$s_f_m', '$s_eco', '$s_agri', '$s_geo', '$s_gov', '$s_com', '$s_civ', '$t_eng', '$t_rel', '$t_ent', '$t_phy', '$t_che', '$t_bio', '$t_mat', '$t_f_m', '$t_eco', '$t_agri', '$t_geo', '$t_gov', '$t_com', '$t_civ', '$to_eng', '$to_rel', '$to_ent', '$to_phy', '$to_che', '$to_bio', '$to_mat', '$to_f_m', '$to_eco', '$to_agri', '$to_geo', '$to_gov', '$to_com', '$to_civ', '$total_score', 'not approved') ";

                        $query_run_two = mysqli_query($conn, $query_two);
                    //}

                    if ($query_run_two) {
                        
                        $output = 'success';
                    }else{

                        $output = 'records fail enter';
                    }
                }
            }

            echo $output;
            
        }





?>