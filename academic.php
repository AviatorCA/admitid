<?php
	require "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","edu");

	$boards=$c->query("select * from boards");
	$schools=$c->query("select * from schools_list");
	$subjects_10=$c->query("select * from subjects where class='10'");
	$subjects_12=$c->query("select * from subjects where class='12'");
	$arrItem=['padding','padding-left','padding-top','padding-bottom','padding-right','margin','margin-left','margin-top','margin-bottom','margin-right'];
	$arrP=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];
	$arrN=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];

	$lines=file('../bgs.csv');
	foreach($lines as $color) {
		list($bgs[])= explode(",",$color);
	}
	$months=array('January','Feburary','March','April','May','June','July','August','September','October','November','December');
	$dev=$_GET['dev'];
	if ($dev=='1') {
		$count_10=1;
		$count_12=6;
	}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
<meta charset="UTF-8">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css'>
<link href="https://fonts.googleapis.com/css?family=Khand" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" />
<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
	input{
	  padding-left: 27px!Important;
	}
/* enable absolute positioning */
.inner-addon {
  position: relative;
}

/* style glyph */
.inner-addon .glyphicon {
  position: absolute;
  padding: 10px;
  pointer-events: none;
  margin-top:50px;
}

/* align glyph */
.left-addon .glyphicon  { left:  0px;}
.right-addon .glyphicon { right: 0px;}

/* add padding  */
.left-addon input  { padding-left:  30px; }
.right-addon input { padding-right: 30px; }



body {
  margin: 10px;
}
	.tl{
		text-align:left;
	}
	.tr{
		text-align:right;
	}
	.tc{
		text-align:center;
	}
	.vt{
		vertical-align:top;
	}
	.vm{
		vertical-align:middle;
	}
	.vb{
		vertical-align:bottom;
	}
	.cp {
		cursor: hand;
		cursor:pointer;
	}
<?
	for ($j=0; $j<=count($arrItem)-1; $j++) { 
		for ($i=0; $i<=count($arrP)-1; $i++) { 
			$unit=($i<2)?"":"px";	
			echo "
		   ." . substr(explode("-",$arrItem[$j])[0],0,1) . substr(explode("-",$arrItem[$j])[1],0,1) . $arrP[$i] . " {
					" . $arrItem[$j] . ": " . $arrP[$i] . $unit . ";
				}
			" . PHP_EOL;
		}
	}
	for ($i=0; $i<=count($arrN)-1; $i++) { 
		echo "
	   .mtn" . $arrN[$i] . " {
				margin-top: -" . $arrN[$i] . "px;
			}
		" . PHP_EOL;
	}
	
	for ($i=0; $i<count($bgs); $i++) {
		echo "
		.b-{$bgs[$i]}{
			background-color: " . $bgs[$i] . "
		}" . PHP_EOL;
	}

	for ($i=0; $i<count($bgs); $i++) {
		echo "
		.c-{$bgs[$i]}{
			color: " . $bgs[$i] . "
		}" . PHP_EOL;
	}
	
?>
div {
	font-size:18px;
}
*{
	font-family: Khand;
	font-size:16px;
}
.label{
	font-weight:bold;
}
.pa {
	position:absolute;
}
.pf {
	position:fixed;
}
.border-none{
	border:none;
}

.mtn10 {
	color:blue!Important;
}
.b1r {
	border:1px solid silver;margin:5px
}
.selectable{
    -webkit-touch-callout: all; /* iOS Safari */
    -webkit-user-select: all; /* Safari */
    -khtml-user-select: all; /* Konqueror HTML */
    -moz-user-select: all; /* Firefox */
    -ms-user-select: all; /* Internet Explorer/Edge */
    user-select: all; /* Chrome and Opera */
}
.hide{
	display:none;
}

input {
	border-radius:6px;
	border:0px solid silver;
	width:100%;
	height:50px;
	box-shadow: 0 0 10px rgba(0,0,0,0.1);
	padding-left:60px!Important
}
.trans {
	opacity: 0.4;
	filter: alpha(opacity=80);
}
.input-group{border:none!Important;}
.input-group-addon:first-child {border:none;position:absolute;width:50px;height:50px;padding-top:17px}
.control {
    box-sizing: border-box;
    clear: both;
    font-size: 1rem;
    position: relative;
    text-align: inherit;
}

.mt-1 {
    margin-top: 0.25rem!important;
}

.box {
    background-color: #fff;
    border-radius: 6px;
    box-shadow: 0 0.5em 1em -0.125em rgb(10 10 10 / 10%), 0 0 0 1px rgb(10 10 10 / 2%);
    color: #4a4a4a;
    display: block;
    padding: 1.25rem;
	position: absolute;
	z-index:999999999999999999999;
	font-size:21px;
	margin-top:-14px!Important;
	margin-left:50px!Important;
}

ul {
    list-style: none;
}
li {
	cursor:hand;
	cursor:pointer
}
.hand {
	cursor:hand;
	cursor:pointer
}
li:hover{
	background:black;
	color:white
}
.input, .textarea {
    box-shadow: inset 0 0.0625em 0.125em rgb(10 10 10 / 5%);
    max-width: 100%;
    width: 100%;
}

.control.is-loading::after {
 position:absolute!important;
 right:.625em;
 top:.625em;
 z-index:4
}
.jconfirm-content{
	padding-top:0!Important;
	overflow:hidden!Important;	
}
.jconfirm{
	padding-top:0!Important;
	overflow:hidden!Important;	
}
</style>

</head>
<body translate="no" style="background:#fcfcfc">
	<span id="navigation">
	<img src="hm.png" style="position:absolute;left:480px;top:15px;width:60px;margin:auto;z-index:9">
	<img src="h3.png" style="position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<table  style="position:absolute;left:0;right:0;top:25px;width:740px;margin:auto;z-index:999;height:60px">
		<tr>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%;height:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="profile.php"><div style="width:100%;height:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="academic.php"><div style="width:100%;height:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%"></div></a>
			</td>
			<td style="92.5px">
				<a href="register.php"><div style="width:100%"></div></a>
			</td>
		</tr>
	</table>
	<img src="h1x.png" id="h1x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h2x.png" id="h2x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h3x.png" id="h3x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h4x.png" id="h4x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h5x.png" id="h5x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h6x.png" id="h6x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h7x.png" id="h7x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<img src="h8x.png" id="h8x" style="display:none;position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
	<div class="p0 mtn20" style="position:absolute;left:260px;top:130px;width:275px">
		<div class="p0 tr mtn25">
			<img src="v_done.png" style="width:50px">
		</div>
		<div class="tr mtn15">
			<img src="v_done.png" style="width:50px">
		</div>
		<div class="tr mtn15" style="margin-right:-5px">
			<img src="v_academic.png" style="width:200px">
		</div>
		<div class="tr mtn15">
			<img src="v_pending.png" style="width:50px">
		</div>
		<div class="tr mtn15">
			<img src="v_pending.png" style="width:50px">
		</div>
		<div class="tr mtn15">
			<img src="v_pending.png" style="width:50px">
		</div>
		<div class="tr mtn15">
			<img src="v_pending.png" style="width:50px">
		</div>
		<div class="tr mtn15">
			<img src="v_pending.png" style="width:50px">
		</div>
	</div>
	</span>
	<div class="container" style="margin-top:100px;width:100%;max-width:770px;border-radius:10px">
		<div class="row" style="background:#fff;box-shadow:0 0 10px rgba(0,0,0,0.2);padding:25px;border-radius:10px">
			<div class="col-sm-12 b-white p0 tl"><h2>ACADEMIC ACHIEVEMENTS</h2></div>

				<span id="10">
					<div class="col-sm-12 b-white p0 tl "><h2>10th STANDARD</h2></div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select contenteditable class="input-group" id="10_board" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_grade(this)">
								<option>Select Board</option>
								<? for ($i=0; $i<count($boards); $i++) { ?>
								<option value="<?=$boards[$i]['id'];?>"><?=$boards[$i]['board'];?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl border-none pt15">
						<div class="input-group" style="border:none!Important">
							<section class="control" id="searchbox-container">
							 <span class="input-group-addon" id="middle_name">
								<i class="fa fa-building-o"></i>
							 </span>
							 <input style="font-size:18px; width:90%" type="text" name="city" placeholder="Where did you go to school?" id="10_school"  onclick="set_box('10_school')" onfocus="set_box('10_school')"  autocomplete="off" />
								<div class="control" id="dropdown-menu"></div>
							</section>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select class="input-group" id="10_year" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_grade(this)">
								<option>Year Graduated</option>
								<? for ($i=2015; $i<2030; $i++) { ?>
								<option value="<?=$i;?>"><?=$i;?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select class="input-group" id="10_month" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_grade(this)">
								<option>Month Graduated</option>
								<? for ($i=0; $i<12; $i++) { ?>
								<option value="<?=$months[$i];?>"><?=$months[$i];?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div id="10_btn_holder" class="col-sm-12 b-white p10 tl border-none">
						<button  style="width:220px" onclick="add_subject_init(10)" class="btn btn-info btn-large">Add Subject</button>
					</div>
				</span>
				<span id="12t" style="display:none">
					<div class="col-sm-12 b-white p0 tl "><h2>12th STANDARD</h2></div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select contenteditable class="input-group" id="12_board" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_grade(this)">
								<option>Select Board</option>
								<? for ($i=0; $i<count($boards); $i++) { ?>
								<option value="<?=$boards[$i]['id'] . "|" . $boards[$i]['level'];?>"><?=$boards[$i]['board'];?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl border-none pt15">
						 <div class="input-group" style="border:none!Important">
						<section class="control" id="searchbox-container-12">
						 <span class="input-group-addon">
							<i class="fa fa-building-o"></i>
						 </span>
						 <input style="font-size:18px; width:90%" type="text" name="city" placeholder="Where did you go to school?" id="12_school" onclick="set_box('12_school')" onfocus="set_box('12_school')" autocomplete="off" />
							<div class="control" id="dropdown-menu-12"></div>
						</section>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select class="input-group" id="12_year" style="background:aliceblue;height:50px;padding:10px;width:90%">
								<option>Year Graduated</option>
								<? for ($i=2015; $i<2030; $i++) { ?>
								<option value="<?=$i;?>"><?=$i;?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 b-white p0 tl pt15">
						<div class="input-group" style="border:none!Important">
							<select class="input-group" id="12_month" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_grade(this)">
								<option>Month Graduated</option>
								<? for ($i=0; $i<12; $i++) { ?>
								<option value="<?=$months[$i];?>"><?=$months[$i];?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div id="12_btn_holder" class="col-sm-12 b-white p10 tl border-none tl">
						<button style="width:220px" onclick="add_subject_init(12)" class="btn btn-info btn-large">Add Subject</button>
					</div>

				</span>
			<span id="span_after_10" style="display:none">
				<div class="col-sm-12 b-white p0 tl border-none m10" style="font-size:21px">
					<b style="font-size:21px">What did you do next?</b>
				</div>
				<div class="col-sm-12 b-white p0 tl border-none m10" style="font-size:18px">
					Next, I completed:
				</div>
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="fn_after_10('12')" class="btn btn-default">12th Standard</button>
				</div>				
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="fn_after_10('d2')" class="btn btn-default">2 Year Diploma</button>
				</div>				
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="fn_after_10('d3')" class="btn btn-default">3 Year Diploma</button>
				</div>				
			</span>
			<span id="span_after_12" style="display:none">
				<div class="col-sm-12 b-white p0 tl border-none m10" style="font-size:21px">
					<b style="font-size:21px">What did you do next?</b>
				</div>
				<div class="col-sm-12 b-white p0 tl border-none m10" style="font-size:18px">
					Next, I completed:
				</div>
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="show_matrix()" class="btn btn-default">Im All Done</button>
				</div>				
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="fn_after_12('d2')" class="btn btn-default">2 Year Diploma</button>
				</div>				
				<div class="col-sm-4 b-white p0 tl border-none">
					<button onclick="fn_after_12('d3')" class="btn btn-default">3 Year Diploma</button>
				</div>				
			</span>
			<div id="div_dip1" style="display:none">
			<span id="2dip" style="display:">
				<div class="col-sm-12 b-white p0 tl"><h2>2 YEAR DIPLOMA</h2></div>
				<div class="col-sm-6 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="diploma_inst" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Select Board</option>
							<? for ($i=0; $i<count($boards); $i++) { ?>
							<option><?=$boards[$i]['Boards'];?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-3 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="dip1" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Year Started</option>
							<? for ($i=2023; $i<2030; $i++) { ?>
							<option><?=$i;?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-3 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="dip2" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Year Completed</option>
							<? for ($i=2023; $i<2030; $i++) { ?>
							<option><?=$i;?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-6 b-white p0 tl border-none">
					 <div class="input-group" style="border:none!Important">
						<select class="input-group" id="subject_10_3" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Select Field</option>
							<option>Electrical</option>
							<option>Computer Hardware</option>
							<option>Computer Software</option>
							<option>Automotive Repair</option>
							<option>Aeronautical</option>
							<option>Machine Shop</option>
							<option>Pharmaceutical</option>
							<option>Medicine</option>
						</select>
					</div>
				</div>				
				<div class="col-sm-6 b-white p0 tl border-none">
					 <div class="input-group" style="border:none!Important">
						 <span class="input-group-addon" id="middle_name">
							<i class="fa fa-flag-checkered"></i>
						 </span>
						 <input type="text" id="first_name" style="width:95%" placeholder="Overall Score">
					 </div>
				</div>				
			</span>
			<span id="3dip" style="display:none">
				<div class="col-sm-12 b-white p0 tl"><h2>3 YEAR DIPLOMA</h2></div>
				<div class="col-sm-6 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="board" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Select Board</option>
							<? for ($i=0; $i<count($boards); $i++) { ?>
							<option><?=$boards[$i]['Boards'];?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-3 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="board" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Year Started</option>
							<? for ($i=2023; $i<2030; $i++) { ?>
							<option><?=$i;?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-3 b-white p0 tl">
					<div class="input-group" style="border:none!Important">
						<select class="input-group" id="board" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Year Completed</option>
							<? for ($i=2023; $i<2030; $i++) { ?>
							<option><?=$i;?></option>
							<? } ?>
						</select>
					</div>
				</div>
				<div class="col-sm-6 b-white p0 tl border-none">
					 <div class="input-group" style="border:none!Important">
						<select class="input-group" id="subject_10_3" style="background:aliceblue;height:50px;padding:10px;width:90%">
							<option>Select Field</option>
							<option>Electrical</option>
							<option>Computer Hardware</option>
							<option>Computer Software</option>
							<option>Automotive Repair</option>
							<option>Aeronautical</option>
							<option>Machine Shop</option>
							<option>Pharmaceutical</option>
							<option>Medicine</option>
						</select>
					</div>
				</div>				
				<div class="col-sm-6 b-white p0 tl border-none">
					 <div class="input-group" style="border:none!Important">
						 <span class="input-group-addon" id="middle_name">
							<i class="fa fa-flag-checkered"></i>
						 </span>
						 <input type="text" id="first_name" style="width:95%" placeholder="Overall Score">
					 </div>
				</div>				
			</span>	
			
		</div>
		<div id="next_btn" id="12_btn_holder" class="col-sm-12 b-white p10 tl border-none" style="display:none">
			<button onclick="next(12)" class="btn btn-success btn-large" style="width:220px">Finished</button>
		</div>
		<div class="col-sm-12 b-white p0 tl "><h2>ENGLISH PROFECIENCY</h2></div>
		<div class="col-sm-6 b-white p0 tl pt15">
			<div class="input-group" style="border:none!Important">
				<select contenteditable class="input-group" id="10_board" style="background:aliceblue;height:50px;padding:10px;width:90%" onchange="update_english(this)">
					<option>Select Profeciency Exam Taken</option>
					<option value="ielts">IELTS</option>
					<option value="pte">PTE</option>
					<option value="toefl">TOEFL</option>
				</select>
			</div>
		</div>
		<div class="col-sm-6 b-white p0 tl pt15">
			<input type="text" id="english_test_score" placeholder="Please Enter English Test Score">
		</div>
			<span id="matrix" style="display:none">
				<div class="col-sm-10 b-white p0 tl">
					Overall average, All subjects
				</div>
				<div class="col-sm-10 b-white p0 tl">
					Overall average, Best 5 subjects, without Non Academic
				</div>
				<div class="col-sm-10 b-white p0 tl">
					Overall average, Best 4 subjects, without Non Academic
				</div>
				<div class="col-sm-10 b-white p0 tl">
					Overall average, Best 5 subjects, with Non Academic
				</div>
				<div class="col-sm-10 b-white p0 tl">
					Overall average, Best 4 subjects, with Non Academic
				</div>
				<div class="col-sm-10 b-white p0 tl">
					Reccommended Subject for Higher Studies
				</div>
				<div id="m5" class="col-sm-2 b-white p0 tl">
					
				</div>
			</span>
					</div>
<!--
	max 2 languages with english mandatory
	best of 2 languages with english + 2 academic
	best of 2 ac subs
	best of 3 ac subs
	best of 4 - with at least 1 english and rest academic
-->
	</div>
	<script>

	</script>
	<script src="https://terrawire.com/js/jquery.js"></script>
	<script src="https://terrawire.com/notify.js"></script>
	<script src="https://terrawire.com/utils.js?<?=time();?>"></script>
	<script src="https://terrawire.com/wait.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script>
		var dev=qs('dev')
		setTimeout(function(){
			if (dev=='1') fn_after_10(12);	
		},2000)
		
		
		function update_english(obj) {
			alert(obj.value)
			$.ajax({
				url:'x_add_english.php?student_id='+student_id+'&english_exam_taken='+obj.value+'&english_test_score='+$$('english_test_score').value,
				success:function(data){
					$.notify('Student Grade Data Added','success')
				}
			})
		}
		var count_10='<?=$count_10;?>'
		var count_12='<?=$count_12;?>'
		if (get('reg')=='true') $('#h1x').show()
		function toggle(obj) {
			if (obj.src.indexOf('_off')>=0) {
				turn_all_off()
				obj.src='radio_on.png'
				hide_all()
				if (obj.id=='img_10') {
					$('#10').show()
					$('#12t').hide()
					$('#div_dip1').hide()
					$('#div_dip').hide()
				} else if (obj.id=='img_12') {
					$('#10').hide()
					$('#12t').show()
					$('#div_dip').hide()
					$('#div_dip1').hide()
				} else if (obj.id=='img_dip'){
					$('#10').hide()
					$('#12t').hide()
					$('#div_dip').show()
					$('#div_dip1').show()
					$('#2dip').show()
				} else if (obj.id=='img_2d'){
					$$('img_dip').src='radio_on.png'
					$$('img_2d').src='radio_on.png'
					$$('img_3d').src='radio_off.png'
					$('#2dip').show()
					$('#3dip').hide()
				} else if (obj.id=='img_3d'){
					$$('img_dip').src='radio_on.png'
					$$('img_3d').src='radio_on.png'
					$$('img_2d').src='radio_off.png'
					$('#3dip').show()
					$('#2dip').hide()
				}
			}
		}
		setGrade(10)
		function setGrade(gr) {
			grade=gr
			set('grade',grade)
		}
		
		function set_box(s) {
			set('box',s)
		}
		var board_id,school_id,school_year,school_location,student_id,board_level

		function update_grade(obj) {
			student_id=get('student_id')
			grade=get('grade')
			var school_month	
			if (obj.id=='10_board') {
				board_id=obj.value.split('|')[0]
				board_level=obj.value.split('|')[1]
				set('board_id',board_id)
				set('board_level',board_level)
			}
			if (obj.id=='10_school') {
				school_id=obj.value
				set('school_id',school_id)
			}
			if (obj.id=='10_year') {
				school_year=obj.value
				set('school_year',school_year)
			}
			if (obj.id=='10_month') {
				school_month=obj.value
				set('school_month',school_month)
			}
			if (obj.id=='12_board') {
				board_id=obj.value.split('|')[0]
				board_level=obj.value.split('|')[1]
				set('board_id',board_id)
				set('board_level',board_level)
			}
			if (obj.id=='12_school') {
				school_id=obj.value
				set('school_id',school_id)
			}
			if (obj.id=='12_year') {
				school_year=obj.value
				set('school_year',school_year)
			}
			if (obj.id=='12_month') {
				school_month=obj.value
				set('school_month',school_month)
			}
			if (board_id && board_level && school_id && school_year && grade && school_month) {
				$.ajax({
					url:'x_add_grade_data.php?student_id='+student_id+'&board_id='+board_id+'&school_id='+school_id+'&date_taken='+school_year+'&school_location='+school_location+'&grade='+grade+'&school_month='+school_month+'&board_level='+get('board_level'),
					success:function(data){
						$.notify('Student Grade Data Added','success')
					}
				})
			}
		}
		
		
		function turn_all_off() {
			$$('img_10').src='radio_off.png'
			$$('img_12').src='radio_off.png'
			$$('img_dip').src='radio_off.png'
		}
		
		function hide_all() {
			$('#10').hide()
			$('#12t').hide()
			$('#2dip').hide()
			$('#3dip').hide()
		}

		function getLocation() {
		  if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		  } else {
			alert("Geolocation is not supported by this browser.");
		  }
		}
		function showPosition(position) {
		  var lat = position.coords.latitude;
		  var lng = position.coords.longitude;
		  map.setCenter(new google.maps.LatLng(lat, lng));
		}
		var str=''
		var s_count=1
		
		function add_subject(s_class){
			s_count=1
			add_subject_init(s_class)
		}
		
		function add_subject_init(s_class) {
			str+='	<div class="col-sm-6 b-white p0 tl pt5">'
			str+='		<div class="input-group" style="border:none!Important">'
			str+='		<section class="control" id="searchbox-container-'+s_class+'-'+s_count+'">'
			str+='			<input style="font-size:18px; width:90%" type="text" placeholder="Please Enter Subject Name" id="subject-'+s_class+'-'+s_count+'" autocomplete="off" />'  
			str+='			<div class="control" id="dropdown-menu-'+s_class+'-'+s_count+'"></div>'
			str+='		</section>'	
			str+='		</div>'
			str+='	</div>'
			str+='	<div class="col-sm-5 b-white p0 tl border-none pt5">'
			str+='		 <div class="input-group" style="border:none!Important">'
			str+='			 <span class="input-group-addon" id="middle_name">'
			str+='				<i class="fa fa-flag-checkered"></i>'
			str+='			 </span>'
			str+='			 <input onchange="update_marks(this)" type="text" id="score_'+s_class+'_'+s_count+'" style="width:60%" placeholder="Score">'
			str+='			 <input onchange="update_max(this)" type="text" style="padding-left:15px!Important;width:35%;margin-left:5px" id="max_'+s_class+'_'+s_count+'" placeholder="Out Of">'
			str+='		 </div>'
			str+='	</div>'
			str+='	<div class="col-sm-1 b-white p0 tl border-none mtn5">'
			str+='	<a href="javascript:deleteSub(\'div_'+s_class+'_'+s_count+'\')"><img class="mt25 ml50" src="del.png" style="width:25px;margin-left:10px"></a>'
			str+='	</div>'

			x_score_id='score_'+get('grade')+'_'+s_count
			x_max_id='max_'+get('grade')+'_'+s_count
			x_sub_id='subject_'+get('grade')+'_'+s_count
			var div=document.createElement('div')
			div.innerHTML=str
			str=''
			div.id='div_'+s_class+'_'+s_count
			if (s_class=='12') $$(s_class+'t').appendChild(div)
				else $$(s_class).appendChild(div)
			//alert('subject-'+s_class+'-'+s_count,'dropdown-menu-'+s_class+'-'+s_count,'searchbox-container-'+s_class+'-'+s_count)
			activate_autocomplete('subject-'+s_class+'-'+s_count,'dropdown-menu-'+s_class+'-'+s_count,'searchbox-container-'+s_class+'-'+s_count)
			if (s_count>=count_10) $('#next_btn').show()
			s_count++
			os_class=s_class
		}
		
		function deleteSub (objID) {
			//if (objID.split('_')[2]*1!==s_count-1) return false
			$$(objID).outerHTML=''
			s_count--
		}
		
		function show_matrix() {
			$('#english').show()
		}
		
		var finalize=false
		function next() {
			if (get('grade')=='10'){
				var strB='<iframe style="width:100%;border:none;box-shadow:none" src="up.html"></iframe>'
				var div=document.createElement('div')
				div.className='col-sm-10 tl pt20'
				div.innerHTML=strB
				$$(os_class).appendChild(div)
			} else if (get('grade')=='12') {
				var strB='<iframe style="width:100%;border:none;box-shadow:none" src="up12.html"></iframe>'
				var div=document.createElement('div')
				div.className='col-sm-10 tl pt20'
				div.innerHTML=strB
				$$(os_class+'t').appendChild(div)
				$('#next_btn').hide()
			}
		}
		
		function update_scores(obj) {
			if ($$(x_score_id).value && $$(x_max_id).value) {
				subject_type=$$(x_sub_id).value.split('-')[1]
				x_url='x_add_subject.php?student_id='+get('student_id')+'&board_id='+get('board_id')+'&school_id='+get('school_id')+'&subject_id='+$$(x_sub_id).value+'&grade='+get('grade')+'&score='+$$(x_score_id).value+'&subject_type='+subject_type+'&max='+$$(x_max_id).value+'&board_level='+get('board_level')
				$.ajax({
					url:x_url,
					success:function(data){
						$.notify('Subject Added Succesfully','success')
					}
				})
			}
		}
            $("#but_upload").click(function() {
                var fd = new FormData();
                var files = $('#file')[0].files[0];
                fd.append('file', files);
       
                $.ajax({
                    url: 'upload.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response != 0){
                           alert('file uploaded');
						   show_next_10()
                        }
                        else{
                            alert('file not uploaded');
                        }
                    },
                });
            });
			
			
		function show_next_12() {
			$('#12t').hide()
			$('#span_after_12').show()
		}
		function show_next_10() {
			$('#10').hide()
			$('#span_after_10').show()
			$('#next_btn').hide()
			s_added=1
		}
		function fn_after_10(ac) {
			if (ac=='12') {
				$('#span_after_10').hide()
				$('#12t').show()
				s_added=1
				s_count=1
				setGrade(12)
			}
		}
		
		function update_marks(obj) {
			var max_score=$$(obj.id.replace('score','max')).value
			var ind=obj.id.split('_')[2]
			var ac=ind.split('_')[1]
			var subject_id=get('subject_id')
			var subject_type=get('category')
			$$(obj.id.replace('score','max')).value=get('max')
			x_url='x_add_subject.php?student_id='+get('student_id')+'&board_id='+get('board_id')+'&school_id='+get('school_id')+'&subject_id='+subject_id+'&grade='+get('grade')+'&score='+obj.value+'&subject_type='+subject_type+'&board_level='+get('board_level')
			x_url=x_url+'&max='+get('max')
			console.log(x_url)
			$$(x_score_id).style.background='white'
			$.ajax({
				url:x_url,
				success:function(data){
					$.notify('Marks Added Succesfully','success')
					if (s_count<count_12) add_subject_init(get('grade'))	
				}
			})			
		}
		
		var x_url, x_score_id, x_max_id, x_sub_id
		function update_max(obj) {
			if ($$(x_score_id).value=='') {
				$$(x_score_id).focus()
				$('#'+x_score_id).click()
				$$(x_score_id).style.background='lightyellow'
				return
			}
			if ($$(x_sub_id).value=='Select Subject') {
				$.dialog('Please enter subject name')
				return
			} 
			$$(x_score_id).style.background='white'
			$.ajax({
				url:x_url+'&max='+obj.value,
				success:function(data){
					notify('Max Score Updated','success')	
				}
			})
		}
		var student_id
		setTimeout(function(){
			student_id='<?=$_GET['student_id'];?>'
			if (!student_id) student_id=7
			set('student_id',student_id)
		},2000)
		$('#12t').hide()
		$('#10').show()
		var s_added=0
		var os_class
		
		function activate_autocomplete(box,menu,container) {
			set('box',box)
			var school_id, sr, q, surl
			const searchBox = document.getElementById(box);
			const dropdownMenu = document.getElementById(menu);
			const searchBoxContainer = document.getElementById(container);
			searchBox.addEventListener("keyup", function(event) { 
				const timer = setTimeout(function () { 
					sr = event.target.value;
					q = event.target.value;
					if(!sr) return; //Do nothing for empty value
					searchBoxContainer.classList.add("control", "is-loading");
					if (box=='10_school') {
						surl='https://terrawire.com/edu/x_get_school.php?q='+sr+'&limit=10&board='+get('board_id')
					}
					if (box=='12_school') {
						surl='https://terrawire.com/edu/x_get_school.php?q='+sr+'&limit=10&board='+get('board_id')
					}
					if (box.indexOf('subject-10')>=0) {
						surl='https://terrawire.com/edu/x_get_subject.php?grade=10&q='+sr+'&limit=10&board='+get('board_id')
					}
					if (box.indexOf('subject-12')>=0) {
						surl='https://terrawire.com/edu/x_get_subject.php?grade=12&q='+sr+'&limit=10&board='+get('board_id')
					}
					const request = new Request(surl);
					fetch(request)
						.then((response) => response.json())
						.then((data) => {
							if (searchBox.value) { //src not cleaned, backspace removed
								dropdownMenu.replaceChildren(searchResult(data));
							}
							searchBoxContainer.classList.remove("is-loading");  
						});
				}, 500);
			});	
			function searchResult(result){
				const ul = document.createElement('ul')
				ul.classList.add('box', 'mt-1' ); 
				result.forEach((x)=>{
					if(!x)return;
					ul.appendChild(createListItem(x))
				})
				return ul;
			}	
			function clearDropdown(){
				dropdownMenu.innerHTML = '';
				searchBoxContainer.classList.remove("is-loading");
			}

			
			function createListItem(x){
				var offset=0
				const li = document.createElement('li') 
				li.classList.add('py-1'); //, 'pl-5', 'is-capitalized')
				//li.dataset.lat = x.lat;
				//li.dataset.lon = x.lon;
				li.dataset.id = x.id;
				if (box=='10_school') {
					var txt=x.school.substr(0,41)
				} else if (box=='12_school') {
					var txt=x.school.substr(0,41)
				} else {
					try {
						if (get('box').indexOf('subject-10')>=0) {
							var txt=x.subject.substr(0,41)
						}
						if (get('box').indexOf('subject-12')>=0) {
							var txt=x.subject.substr(0,41)
						}
					} catch(e) {}
				}
				if (txt.toLowerCase().indexOf(q.toLowerCase())==0) offset=1
				li.innerHTML = '<span>' + txt.substr(0,txt.toLowerCase().indexOf(q.toLowerCase())) + '</span><span style="background:orange;color:white;border-radius:2px">' + q + '</span>' + txt.substring(txt.indexOf(q)+offset + q.length,txt.length)

				const selectEvent = function(event){
					event.stopPropagation();  
					const li = event.target
					clearDropdown();
					if (get('box')=='10_school') {
						searchBox.value = x.school;
						school_id=li.dataset.id
						set('school_id',school_id)
					} else if (get('box')=='12_school') {
						searchBox.value = x.school;
						school_id=li.dataset.id
						set('school_id',school_id)
					} else {
						try {
							if (get('box').indexOf('subject-10')>=0) {
								searchBox.value = x.subject;
								subject_id=x.id
								set('subject_id',x.id)						
								set('subject',x.subject)						
								set('category',x.category)						
								set('max',x.max)						
							}
							if (get('box').indexOf('subject-12')>=0) {
								searchBox.value = x.subject;
								subject_id=x.id
								set('subject_id',x.id)						
								set('subject',x.subject)						
								set('category',x.category)						
								set('max',x.max)						
							}
						} catch (e) {}
					}
				};

				li.addEventListener('click', selectEvent)
				li.addEventListener('touchstart', selectEvent)

				return li
			}
			setInterval(function() {
				if (!searchBox.value) { //empty search box
					clearDropdown()
				}
			}, 500);
		}

		activate_autocomplete('10_school','dropdown-menu','searchbox-container','10-school')
		activate_autocomplete('12_school','dropdown-menu-12','searchbox-container-12','12-school')

// function searchResult(result){

    // const ul = document.createElement('ul')
    // ul.classList.add('box', 'mt-1' );

    // const loc = result.loc1.concat(result.loc2);
    // loc.forEach((x)=>{
        // if(!x)return;
        // ul.appendChild(createListItem(x))
    // })

    // return ul;
// }
	



	</script>
</body>
</html>
 
