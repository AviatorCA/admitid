<link href="https://fonts.googleapis.com/css?family=Khand" rel="stylesheet" type="text/css">
<style>
*{
	font-family:Khand;
	font-size:16px;
}
</style>
<?php
	require "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","edu");

	$sql="select * from univ_courses";
	$u=$c->query($sql);
	
	// for ($i=0;$i<count($u); $i++) {
		// if ($u[$i]['program']) $program=$u[$i]['program'];
		// if (!$u[$i+1]['program']) {
			// $c->insert("update univ_courses set program='$program' where id=" . $u[$i+1]['id']);
			// $c->show("update univ_courses set program='$program' where id=" . $u[$i+1]['id']);
		// }
	// }
	
	// $c->insert("delete from univ_courses where study_area is null");

	echo $c->query2HTML($sql,false);
	$c->close();
