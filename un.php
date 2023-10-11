<?php
	require "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","edu");
	$s=$c->query("select * from x_subject_aliases order by subject asc");
	$sub="";
	for ($i=0; $i<count($s); $i++) {
		if ($next !== $s[$i]['subject']) {
			if ($i>0) {
				$arr[]=array("subject"=>$next,"aliases"=>$al);
				$al=trim(strtolower($s[$i]['aliases'])) . ",";
			} else {
				$al=trim(strtolower($s[$i]['aliases'])) . ",";
			}
		} else {
			$al.=trim(strtolower($s[$i]['aliases'])) . ",";
		}
		$next=$s[$i]['subject'];
	}
	
	for ($i=0; $i<count($arr); $i ++ ) {
		$subject=$arr[$i]['subject'];
		$aliases=implode(",",array_unique(array_filter(explode(",",$arr[$i]['aliases']))));
		$c->insert("INSERT INTO `edu`.`x_subject_alias` (`aliases`, `subject`) VALUES ('$aliases', '$subject')");
	}
	
