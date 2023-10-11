<?php
	include "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","edu");
	$sid=$_GET['student_id'];
	$mobile=$_GET['mobile'];
	
	function student_scores($student_id,$mobile) {
		global $c;
		$op=[];
		$grades=array('12');
		$p=0;
		$sum=[];
		$s=0;
		$all=[];
		$grade=$grades[$p];
		$threshold=$c->query("select * from x_university_thresholds where board_id=14")[0]['threshold'];
		$threshold_e=$c->query("select * from x_university_thresholds where board_id=14")[0]['threshold_e'];
		$threshold_na=$c->query("select * from x_university_thresholds where board_id=14")[0]['threshold_na'];
		$c->insert("update x_raw_scores set eligible='1' where score > $threshold and subject_type='A' and student_id=$student_id");
		$c->insert("update x_raw_scores set eligible='1' where score > $threshold_e and subject_type='L' and student_id=$student_id");
		$c->insert("update x_raw_scores set eligible='1' where score > $threshold_na and subject_type='N' and student_id=$student_id");
		$all=$c->query("SELECT * FROM `x_raw_scores` where student_id=$student_id and grade='" . $grades[$p] . "' order by score desc, subject_type");
		$all_wo_na=$c->query("SELECT * FROM `x_raw_scores` where student_id=$student_id and grade='" . $grades[$p] . "' and subject_type<>'N' order by score desc, subject_type");
		$overall=0;
		$overall_wo_na=0;
		
		for ($r=0; $r<count($all); $r++) {
			$s=$c->query("SELECT * FROM `x_subjects` where board='cbse' and id=" . $all[$r]['subject_id']);
			$subject_id=$s[0]['id'];
			$subject=trim($s[0]['subject']);
			$alias=$s[0]['alias'];
			$scr[trim(strtolower($subject))]=$all[$r]['score'];
			$types[]=$all[$r]['subject_type'];
			$overall=$overall*1 + $all[$r]['score']*1;
			if ($all[$r]['subject_type']=="A") {
				if(stripos(strtolower($subject), "math") !== false){
					$maths=true;
					$sub="mathematics";
				}
				if(stripos(strtolower($subject), "physic") !== false){
					$physics=true;
					$sub="physics";
				}
				if(stripos(strtolower($subject), "chem") !== false){
					$chemistry=true;
					$sub="chemistry";
				}
				if(stripos(strtolower($subject), "bio") !== false){
					$biology=true;
					$sub="biology";
				}
				if(stripos(strtolower($subject), "comp") !== false){
					$it=true;
					$sub="it";
				}
				if(stripos(strtolower($subject), "inform") !== false){
					$it=true;
					$sub="it";
				}
				if(stripos(strtolower($subject), "comm") !== false){
					$commerce=true;
					$sub="commerce";
				}
				if(stripos(strtolower($subject), "eco") !== false){
					$economics=true;
					$sub="economics";
				}
				if(stripos(strtolower($subject), "acc") !== false){
					$accounting=true;
					$sub="accounting";
				}
				if(stripos(strtolower($subject), "political") !== false){
					$political_science=true;
					$sub="arts";
				}
				if(stripos(strtolower($subject), "geo") !== false){
					$geography=true;
					$sub="arts";
				}
				if(stripos(strtolower($subject), "media") !== false){
					$media=true;
					$sub="media studies";
				}
				if(stripos(strtolower($subject), "history") !== false){
					$history=true;
					$ss="arts";
				}
				if(stripos(strtolower($subject), "psych") !== false){
					$psychology=true;
					$sub="psychology";
				}
				if(stripos(strtolower($subject), "public") !== false){
					$public_administration=true;
					$sub="arts";
				}
				if(stripos(strtolower($subject), "socio") !== false){
					$sociology=true;
					$sub="arts";
				}
				if(stripos(strtolower($subject), "busi") !== false){
					$business=true;
					$sub="business";
				}
				if ($subject_id==117 || $subject_id==116 || $subject_id==114 || $subject_id==112 || $subject_id==109 ||  $subject_id==100 ||  $subject_id==99 ||  $subject_id==97 ||  $subject_id==93) {
					$sub="arts";
				}
				if ($subject_id==120 || $subject_id==91 || $subject_id==92) {
					$sub="it";
				}
				if ($subject_id==118 || $subject_id==88) {
					$sub="business";
				}
				if ($subject_id==85) {
					$sub="accounting";
				}
				if ($subject_id==102) {
					$sub="media studies";
				}
				if ($subject_id==113) {
					$sub="psychology";
				}
				if ($all[$r]['score']*1>$threshold*1) {
					$psubs['A'][]=trim($sub);
					$subs['A'][strtolower($subject)]=$all[$r]['score'];
				}
			}
			if ($all[$r]['subject_type']=="L") {
				if(stripos(strtolower($subject), "eng") !== false){
					if ($all[$r]['score']*1>$threshold_e*1) {
						$english=true;
						$ss['english']=$all[$r]['score'];
						$psubs['L'][]='english';
						$subs['L']['english']=$all[$r]['score'];
					}
				}
			}
			if ($all[$r]['subject_type']=="R") {
				if ($all[$r]['score']*1>$threshold_na*1) {
					$regional_language=true;
					$ss[strtolower($subject)]=$all[$r]['score'];
					$subs[strtolower($subject)]=$all[$r]['score'];
					$psubs['R'][]=strtolower($alias);
				}
			}
			if ($all[$r]['subject_type']=="N") {
				if ($all[$r]['score']*1>$threshold_na*1) {
					$non_academic=true;
					$ss[strtolower($subject)]=$all[$r]['score'];
					$subs[strtolower($subject)]=$all[$r]['score'];
					$psubs['N'][]=strtolower($alias);
				}
			}
		}
		
		for ($r=0; $r<count($all); $r++) {
			$overall_wo_na=$overall_wo_na+$all_wo_na[$r]['score']*1;
		}
		
		$arr['overal_percentage']=round($overall/count($all),0);
		$arr['overal_percentage_wo_na']=round($overall_wo_na/count($all_wo_na),0);
		$arr['individual_scores']=$scr;
		$arr['standardized_scores']=$subs;
		$arr['types']=$types;
		$no=count($all);
		for ($k=4; $k<=$no; $k++) {
			$rules_pass=false;
			$s=0;
			$arr['best_of_' . $k]['subjects']=[];
			$arr['best_of_' . $k]['scores']=[];
			$arr['best_of_' . $k]['subject_types']=[];
			$rule1=0;
			$rule2=0;
			$rule3=0;
			for ($i=0; $i<$k; $i++) {
				$subject=$c->query("SELECT subject FROM `x_subjects` where id=" . $all[$i]['subject_id'])[0]['subject'];
				$subject_id=$all[$i]['subject_id'];
				if ($subject_id==79 || $subject_id==78) $subject='english';
				$arr['best_of_' . $k]['subjects'][]=trim(strtolower($subject));
				$arr['best_of_' . $k]['scores'][]=$all[$i]['score'];
				$arr['best_of_' . $k]['subject_types'][]=$all[$i]['subject_type'];
				$arr['best_of_' . $k]['subject_ids'][]=$all[$i]['subject_id'];
				if ($k==4) {
					$arr['top4']['subjects'][]=trim($subject);
					$arr['top4']['scores'][]=$all[$i]['score'];
					$arr['top4']['subject_types'][]=$all[$i]['subject_type'];
				}
				$s+=$all[$i]['score'];
			}
			$sum[$k]=$s;
			$avg[$k]=round($s/$k,2);
			$arr['best_of_' . $k]['average']=$avg[$k];
			$rule1=calc_rule_1($arr['best_of_' . $k]);
			$rule2=calc_rule_2($arr['best_of_' . $k]);
			$rule3=calc_rule_3($arr['best_of_' . $k]);
			if ($rule1 || $rule2 || $rule3) {
				$max=max($rule1,$rule2,$rule3);
				if ($max>0) {
					$arr['best_of_' . $k]['rules_avg']=$max;
					$rules_pass=true;
					if (($rule1>$rule2)&&($rule1>rule3)) {
						$arr['best_of_' . $k]['best_combination']=array('English'=>1,'Regional Language'=>1,'Academic'=>2);
					}
					if (($rule2>$rule1)&&($rule2>rule3)) {
						$arr['best_of_' . $k]['best_combination']=array('English'=>1,'Academic'=>3);
					}
					if (($rule3>$rule1)&&($rule3>rule2)) {
						$arr['best_of_' . $k]['best_combination']=array('Regional Language'=>1,'Academic'=>3);
					}
				} else {
					$arr['best_of_' . $k]['rules_avg']='fail';
				}
			} else {
				$arr['best_of_' . $k]['rules_avg']='fail';
			}
		}
		if ($rules_pass=true) {
			if (!$maths) {
				if ($subs['A']['biology']) {
					if ($subs['A']['physics'] || $subs['A']['chemistry']) {
						$progression[]="medical";
					}
				} else {

					if (count($psubs['A'])>0) {
						$progression=$psubs['A'];
					}
					if (count($psubs['R'])>0) {
						$progression=array_merge($progression,$psubs['R']);
					}
					if (count($psubs['N'])>0) {
						$progression=array_merge($progression,$psubs['N']);
					}
					if (count($psubs['L'])>0) {
						$progression=array_merge($progression,$psubs['L']);
					}
				}
			} else {
				if ($subs['A']['mathematics'] && $subs['A']['physics'] && $subs['A']['chemistry']) {
					if (!$biology) {
						if ($it) {
							$progression[]="mathematics";							
							$progression[]="physics";							
							$progression[]="chemistry";							
							$progression[]="engineering";							
							$progression[]="it";							
						} else {
							$progression[]="engineering";
						}
					} else {
						if ($it) {
							$progression[]="engineering";							
							$progression[]="it";							
							$progression[]="biology";							
						} else {
							$progression[]="engineering";
							$progression[]="medical";
						}
					}
				} else if (!$chemistry && !$physics) {
					if ($subs['A']['mathematics'] && $subs['A']['biology']) {
						$progression[]="medical";
						$progression[]="mathematics";
						$progression[]="biology";

					} else if ($subs['A']['mathematics'] && $it) {
						$progression[]="engineering";
						$progression[]="it";
						$progression[]="mathematics";
					}
				}
			}

			if (count($psubs['A'])>0) {
				if ($progression) $progression=array_merge($progression,$psubs['A']);
					else $progression=$psubs['A'];
			}
			if (count($psubs['L'])>0) {
				if ($progression) $progression=array_merge($progression,['english']);
					else $progression=array('english');
			}
			if (count($subs['N'])>0) {
				if ($progression) $progression=array_merge($progression,$psubs['N']);
					else $progression=$psubs['N'];
			}
			$progression=array_unique(array_filter($progression));
		}
		$courses=$c->query("select * from x_subject_group_course_mapper");
		for ($b=0; $b<count($courses); $b++) {
			$cl=[];
			$match=$courses[$b]['subject_group'];
			$arr_subject_group=explode(",",$match);
			$x_match=false;
			for ($p=0; $p<=count($progression); $p++) {
				if (count($arr_subject_group)==1) {
					if (in_array($arr_subject_group[0],array($progression[$p]))) {
						$sgs[]=$arr_subject_group;
						$xc=explode(",",$courses[$b]['course_ids']);
						$x_match=true;
						for ($z=0; $z<=count($xc); $z++) {
							if (!in_array($xc[$z],$cl)) {
								if ($xc[$z]) $cl[]=$xc[$z];
								$cl=array_filter($cl);

							}
						}
						$sg[$p]=array("progression"=>$progression[$p],"courses"=>implode(",",array_unique($cl)));
					}
				} else {
					if (in_array($arr_subject_group[0],array($progression[$p])) && (in_array($arr_subject_group[1],array($progression[$p])))) {
						$sgs[]=$arr_subject_group;
						$xc=explode(",",$courses[$b]['course_ids']);
						$x_match=true;
						for ($z=0; $z<count($xc); $z++) {
							if (!in_array($xc[$z],$cl)) {
								$cl[]=$xc[$z];
							}
						}
						$sg[$p]=array("progression"=>$progression[$p],"courses"=>implode(",",array_unique($cl)));
					}
				}
			}
			$course_list=$cl;
		}
		$x_courses=[];
		for ($p=0; $p<=count($sg); $p++) {
			$ng[]=$sg[$p];
		}
		for ($p=0; $p<=count($ng); $p++) {
			$cl[]=explode(",",$ng[$p]['courses']);
		}
		for ($a=0; $a<count($cl); $a++) {
			$x_courses=$cl[$a];
			$progression_subject=$sg[$a]['progression'];
			$ctrs=$a+1;
			$c->insert("INSERT INTO `edu`.`x_comm_student_progression` (`mobile`, `student_id`, `progression_subject`, `order`) VALUES ('$mobile', '$student_id', '$progression_subject', $ctrs)");
			for ($z=0; $z<count($x_courses); $z++) {
				$str="";
				$ctr=$z+1;
				$ucdc=$c->query("select * from x_ucdc where course_id=" . $x_courses[$z]);
				$xu=count($ucdc);
				$ucdc_id='0';
				$strU="";
				//ucdc is commented out to show results even if there is no data entered by Manish
				$cnn=$c->query("select * from x_courses where course_id=" . $x_courses[$z])[0];
				$course_name=$cnn['course'];
				$cnni[]=$x_courses[$z];
				$cnnx[]=$course_name;
				$key1=$cnn['keywords'];
				$key2=str_replace("|",",",$cnn['alias3']);
				$keywords="$key1,$key2,$progression_subject";
				$course_id=$x_courses[$z];
			//	if ($course_name) {
				$cx=0;
					if ($ucdc) {
						for ($u=0; $u<count($ucdc); $u++) {
							$str="";
							$ucdc_id=$ucdc[$u]['ucdc_id'];
							if (is_eligible($ucdc_id,$mobile)) {
								$cid=$ucdc[$u]['cid'];
								$course_id=$ucdc[$u]['course_id'];
								$uid=$ucdc[$u]['uid'];
								$cost=$ucdc[$u]['cost'];
								$link=$ucdc[$u]['link'];
								$location=$c->query("select * from x_campuses where cid=$cid")[0]['campus_name'];
								$un=$c->query("select * from x_universities where uid=$uid")[0];
								$university=$un['university'];
								$arr1=array("The","of","University","Institute","Pty Ltd","Inc","Pty Limited","College","Limited");
								$arr2=array("","","","","","","","","");
								$univ=str_replace($arr1,$arr2,trim($university));
								$keywords=$keywords . "," . $univ;
								$location=$c->query("select show_location from x_show_locations where real_location='$location'")[0]['show_location'];
								$keywords=$keywords . "," . $location;
								$sql="INSERT INTO `edu`.`x_comm_courses_displayed` (`mobile`, `student_id`, `uid`, `location`, `course_id`, `ucdc_id`, `course`, `university`, `link`, `cost`, `progression_subject`,`keywords`) VALUES ('$mobile', '$student_id', '$uid', '$location', '$course_id', '$ucdc_id', '$course_name', '$university', '$link', '$cost', '$progression_subject','$keywords')";
								file_put_contents("_sql.txt",file_get_contents('_sql.txt') . $sql . ";" . PHP_EOL);
								$ix=$c->insert($sql);
								if ($ix) $cx++;
							}
						}
					} else {
						$ucdcid=rand(9990000,9999999);
						$q=$c->query("select * from x_providers where `Course Name`='$course_name' group by Provider");
						for ($r=0; $r<count($q); $r++) {
							$str="";
							$university=$q[$r]['Provider'];
							$uid=$c->query("select uid from x_universities where university='$university'")[0]['uid'];
							$loc=explode("-",$q[$r]['Locations']);
							$location=$loc[0];
							$link=$q[$r]['Detail_Url'];
							$cost='45000';
							$location=$c->query("select show_location from x_show_locations where real_location='$location'")[0]['show_location'];						// $str.="Course: " . $course_name . "\r\n";
							$arr1=array("The","of","University","Institute","Pty Ltd","Inc","Pty Limited","College","Limited");
							$arr2=array("","","","","","","","","");
							$univ=str_replace($arr1,$arr2,trim($university));
							$keywords=$keywords . "," . $univ;
							$keywords=$keywords . "," . $location;
							$sql="INSERT INTO `edu`.`x_comm_courses_displayed` (`mobile`, `student_id`, `uid`, `location`, `course_id`, `ucdc_id`, `course`, `university`, `link`, `cost`, `progression_subject`,`keywords`) VALUES ('$mobile', '$student_id', '$uid', '$location', '$course_id', '$ucdcid', '$course_name', '$university', '$link', '$cost','$progression_subject','$keywords')";
							file_put_contents("_sql.txt",file_get_contents('_sql.txt') . $sql . ";" . PHP_EOL);
							$ix=$c->insert($sql);
							if ($ix) $cx++;
					}
				}
				$op[]=$str;
	//		}
			}}

			$total_op.=count($op);
			$ar['reccomended_courses']=$progression;
			$ar['total_courses']=$total_op;
			$ar['student_info']['student_id']=$all[0]['student_id'];
			$ar['student_info']['board_id']=$all[0]['board_id']; 
			$ar['student_info']['board_level']=$all[0]['board_level'];
			$ar['student_info']['scores']['Grade ' . $grade . ' Scores']=$arr;				
			$ar['subject_groups']=$sg;
			$arr=[];
			$scr=[];
			$op='';
			return $ar;
		}
	
	function is_eligible($ucdc_id,$mobile) {
		global $c;
		$eid=$c->query("select eid from x_course_eligibility where ucdc_id='$ucdc_id'")[0]['eid'];
		$el=$c->query("select * from x_eligibility where eid='$eid'");
		/*
			Get IELTS Results from x_comm_variable_store table and compare with values from eligibility table
		*/
		/*
			Get best_of_4 Results from x_comm_variable_store table and compare with values from eligibility table
		*/
		/*
			Get individual_subjects from x_comm_variable_store table and compare with mandatory_subject value from eligibility table
		*/
		/*
			If any fail, then 
				return false;
		*/
			return true;
	}
	
	function calc_rule_1($arrR) {
		global $c;
		$avg1=0;
		$arrA=[];
		$arrE=[];
		$arrG=[];		
		for ($m=0; $m<count($arrR); $m++) {
			if($arrR['subject_types'][$m]=='L') $arrE[]=$arrR['scores'][$m];
			if($arrR['subject_types'][$m]=='A') $arrA[]=$arrR['scores'][$m];
			if($arrR['subject_types'][$m]=='R') $arrG[]=$arrR['scores'][$m];
		}
		if ((count($arrE)>=1) && (count($arrG)>=1) && (count($arrA)>=2)) {
			$sumE=array_sum($arrE);
			$sumA=array_sum($arrA);
			$sumR=array_sum($arrG);
			$avg1=round(($sumE+$sumA+$sumR)/(count($arrE)+count($arrA)+count($arrG)),0);
		} else {
			$avg1=0;
		}
		return $avg1;
	}
	
	function calc_rule_2($arrR) {
		global $c;
		$avg2=0;
		$arrA=[];
		$arrE=[];
		$arrG=[];
		for ($m=0; $m<count($arrR); $m++) {
			if($arrR['subject_types'][$m]=='L') $arrE[]=$arrR['scores'][$m];
			if($arrR['subject_types'][$m]=='A') $arrA[]=$arrR['scores'][$m];
		}
		if ((count($arrE)>=1) && (count($arrA)>=3)) {
			$sumE=array_sum($arrE);
			$sumA=array_sum($arrA);
			$avg2=round(($sumE+$sumA)/(count($arrE)+count($arrA)),0);
		} else {
			$avg2=0;
		}
		return $avg2;
	}

	function calc_rule_3($arrR) {
		global $c;
		$avg3=0;
		$arrA=[];
		$arrE=[];
		$arrG=[];		
		for ($m=0; $m<count($arrR); $m++) {
			if($arrR['subject_types'][$m]=='R') $arrG[]=$arrR['scores'][$m];
			if($arrR['subject_types'][$m]=='A') $arrA[]=$arrR['scores'][$m];
		}
		if ((count($arrG)>=1) && (count($arrA)>=3)) {
			$sumA=array_sum($arrA);
			$sumR=array_sum($arrG);
			$avg3=round(($sumA+$sumG)/(count($arrA)+count($arrG)),0);
		} else {
			$avg3=0;
		}
		return $avg3;
	}
	$xids=$_GET['xids'];
	$stps=$_GET['stps'];
	$xs=explode("|",$xids);
	$ps=explode("|",$stps);
	for ($i=0; $i<count($xs); $i++) {
		$c->insert("UPDATE `edu`.`x_raw_scores` SET `subject_type`='" . $ps[$i] . "' where id='". $xs[$i] . "'");
	}
	$x=student_scores($sid,$mobile);
	$y=$x['total_courses'];
	if ($_GET['debug']=='1') {
		$c->show($x);
	} else {
		echo $y;
	}
	$c->close();