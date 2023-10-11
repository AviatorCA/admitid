<?php
	require "../class/utils.class.php";
	$c=new utils;
	$c->connect("199.91.65.83","edu");
	$arrItem=['padding','padding-left','padding-top','padding-bottom','padding-right','margin','margin-left','margin-top','margin-bottom','margin-right'];
	$arrP=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];
	$arrN=['auto',0,1,2,3,4,5,7,10,15,20,25,30,25,50,75,100,150,200];

	$lines=file('../bgs.csv');
	foreach($lines as $color) {
		list($bgs[])= explode(",",$color);
	}
	$eid=$_GET['eid'];
	$did=$_GET['did'];
	$uid=$_GET['uid'];
	$cid=$_GET['cid'];
	$months=array('January','Feburary','March','April','May','June','July','August','September','October','November','December');
	
	if ($eid=="") {
		$s=$c->query("select distinct subjects from x_progression_subjects order by subjects asc");
	} else {
		$s=$c->query("select distinct subjects from x_progression_subjects order by subjects asc");
		$subs=$c->query("select progression_subjects from x_eligibility where eid=$eid")[0]['progression_subjects'];
		$subjects=json_decode($subs);
	}
?>
<style>
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
	div {
		padding:2px;
		font-family:Khand;
	}
	.blue {
		/* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#e6f0a3+0,d2e638+50,c3d825+51,dbf043+100;Green+Gloss+%232 */
		background: #e6f0a3; /* Old browsers */
		background: -moz-linear-gradient(top,  #e6f0a3 0%, #d2e638 50%, #c3d825 51%, #dbf043 100%); /* FF3.6-15 */
		background: -webkit-linear-gradient(top,  #e6f0a3 0%,#d2e638 50%,#c3d825 51%,#dbf043 100%); /* Chrome10-25,Safari5.1-6 */
		background: linear-gradient(to bottom,  #e6f0a3 0%,#d2e638 50%,#c3d825 51%,#dbf043 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e6f0a3', endColorstr='#dbf043',GradientType=0 ); /* IE6-9 */
		padding:2px;
		padding-left:5px;
		padding-right:5px;
		margin-right:5px;
		border-radius:5px;
		font-size:0.9em;
		margin-top:-15px!Important;
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

.input, .textarea {
    box-shadow: inset 0 0.0625em 0.125em rgb(10 10 10 / 5%);
    max-width: 100%;
    width: 30%;
}

.control.is-loading::after {
 z-index:4
}

.none {
	padding--left:10px;
}
.expand-all {
	padding:10px!Important;
}
.separator {
	content: ' | ';
}	
* {
	font-size:14px;
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
</style>
<!DOCTYPE html>
<html lang="en" >
	<head>
		<script>
			var timestamp = new Date().getTime()
		</script>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' />
		<link href="https://fonts.googleapis.com/css?family=Khand" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" />
		<style>
		</style>
	</head>
	<body>
	
	<table style="width:600px;margin:auto">
	<? 
		$ctr=1;
		for ($i=0; $i<count($s); $i++) { 
	?>
			<tr>
				<td class="p10 tl">
					<?
						$src="chk_off.png";
						if (in_array($s[$i]['subjects'],$subjects)) $src="chk_on.png";
					?>
					<? echo "<img class='hand' onclick=\"toggle(this,'" . $s[$i]['subjects'] . "')\" src='$src' style='width:20px; font-size:14px!Important'>&nbsp;&nbsp;" . $s[$i]['subjects']; ?>
					<? $src="chk_off.png";?>
				</td>
				<td class="p10 tl">
					<? if (!is_null($s[$i+1]['subjects'])) { ?>
					<?
						$src="chk_off.png";
						if (in_array($s[$i+1]['subjects'],$subjects)) $src="chk_on.png";
					?>
					<? echo "<img class='hand' onclick=\"toggle(this,'" . $s[$i+1]['subjects'] . "')\" src='chk_off.png' style='width:20px; font-size:14px!Important'>&nbsp;&nbsp;" . $s[$i+1]['subjects']; ?>
						<? $src="chk_off.png";?>
					<? } ?>
				</td>
				<td class="p10 tl">
				</td>
			</tr>	
	
	<?
		$ctr++;
		$i++;
		}
	?>
	</table>
	<script src="js/jquery.js"></script>
	<script src="js/notify.js"></script>
	<script src="js/utils.js"></script>
	<script src="js/wait.js"></script>
	<script src="https://kit.fontawesome.com/c52e99344b.js" crossorigin="anonymous"></script>
	<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js'></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>		

	<script>
		window.onload = function () {
			var timestamp2 = new Date().getTime()
			console.log('Took ' + (timestamp2-timestamp)/1000 + ' seconds to load')
		}
		
		function toggle(img,sub) {
			if (img.src.indexOf('chk_off')>=0) {
				img.src='chk_on.png'
				add_subject(sub)
			} else {
				img.src='chk_off.png'
				delete_sub(sub)
			}
		}
		
		function add_subject(sub) {
			$.ajax({
				url:'x_add_progression.php?subject='+sub+'&eid=<?=$eid;?>&did=<?=$did;?>&cid=<?=$cid;?>&uid=<?=$uid;?>&user=<?=rand(111111,999999);?>',
				success:function(data){
					$.notify('Added!','success')
				}
			})
		}
		
		function delete_sub(sub) {
			$.ajax({
				url:'x_delete_progression.php?subject='+sub+'&eid=<?=$eid;?>&did=<?=$did;?>&cid=<?=$cid;?>&uid=<?=$uid;?>&user=<?=rand(111111,999999);?>',
				success:function(data){
					$.notify('Deleted!','success')
				}
			})
		}
		
	</script>
	</body>
</html>