<?php
	require "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","ggtw");

	$arrItem=['padding','padding-left','padding-top','padding-bottom','padding-right','margin','margin-left','margin-top','margin-bottom','margin-right'];
	$arrP=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];
	$arrN=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];

	$lines=file('../bgs.csv');
	foreach($lines as $color) {
		list($bgs[])= explode(",",$color);
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


<style>
	input{
	  padding-left: 17px;
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
	padding-top:15px!Important;
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
	box-shadow: 0 0 10px rgba(0,0,0,0.1)
}
.trans {
	opacity: 0.4;
	filter: alpha(opacity=80);
}
.input-group{border:none!Important;}
.input-group-addon:first-child {border:none;position:absolute;width:50px;height:50px;padding-top:17px}
</style>
</head>
<body translate="no" style="background:none">
	<img src="hm.png" style="position:absolute;left:580px;top:15px;width:80px;margin:auto;z-index:9">
	<img src="h2.png" style="position:absolute;left:0;right:0;top:25px;width:740px;margin:auto">
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
	<img src="v2.png" style="position:absolute;left:360px;top:130px;width:275px">	
	<div class="container" style="margin-top:100px;width:100%;max-width:770px;border-radius:10px">
		<div class="row" style="background:#fff;box-shadow:0 0 10px rgba(0,0,0,0.2);padding:25px;border-radius:10px">

				<div class="col-sm-4 b-white p0 tl  border-none inner-addon left-addon">
					 <div class="input-group" style="border:none!Important">First Name<span class="input-group-addon" id="middle_name"><i class="fa fa-user"></i></span><input type="text" id="first_name"/></div>
				</div>
				<div class="col-sm-4 b-white p0 tl border-none">
					 <div class="input-group" style="border:none!Important">Middle Name<span class="input-group-addon" id="middle_name">M</span><input type="text" id="first_name"/></div>
				</div>
				<div class="col-sm-4 b-white p0 tl  border-none inner-addon left-addon">
					 <div class="input-group" style="border:none!Important">Last Name<span class="input-group-addon" id="basic-addon1">L</span><input type="text" id="first_name"/></div>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Gender<input type="text" id="first_name"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Marital Status<input type="text" id="marital_status"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Fathers Name<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Mothers Name<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-12 b-white p0 tl  border-none inner-addon left-addon">
					Passport Number<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Issue Date<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Expiry Date<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Place of Issue<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Passport Holder Nationality<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-12 b-white p0 tl  border-none inner-addon left-addon">
					Address<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-12 b-white p0 tl  border-none inner-addon left-addon">
					Address 2<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					City<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					State<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Zipcode<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-6 b-white p0 tl  border-none inner-addon left-addon">
					Country<input type="text" id="student_title"/>
				</div>
				<div class="col-sm-12 b-white p0 mt10 tl  border-none inner-addon left-addon">
					Save and Proceed to Academic Profile
				</div>
				<div class="col-sm-12 b-white p0 tl border-none">
					<button class="btn btn-danger" onclick="step2()">Goto Step 3</button>
				</div>
			</div>
		</div>
	</div>
	<script>

	</script>
	<script src="https://terrawire.com/js/jquery.js"></script>
	<script src="https://terrawire.com/utils.js?<?=time();?>"></script>
	<script src="https://terrawire.com/wait.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script>
		if (get('reg')=='true') $('#h1x').show()

	</script>
</body>
</html>
 
