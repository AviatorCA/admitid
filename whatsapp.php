<?php
require_once 'vendor/autoload.php'; // Loads the library
use Twilio\TwiML\MessagingResponse;
use Twilio\Rest\Client;
include "class/utils.class.php";
$c=new utils;
$c->connect("199.91.65.83","edu");
$sid = "ACb53808456a8db2cf19224ce15dc3ba8b";
$token = "febf314d696a009f16bc3bb01a6b3574";
$twilio = new Client($sid, $token);
$step=5; 
$r=$_REQUEST;
file_put_contents("mindee.txt",json_encode($r));
$b = json_encode($r);
$response = new MessagingResponse;
global $from;
global $c;
$pn=strtolower(trim($r["Body"]));

$from=explode(":",$r["From"])[1];
$from=trim(str_replace('+','',$from));
$next_action=$c->query("select next_action from `edu`.`x_comm_progression` where mobile='$from' order by id DESC limit 1")[0]['next_action'];
file_put_contents("f_current_before.txt",$next_action);

// echo "
	// <Response>
		// <Message>Under Maintenance. Building Conditional Offer Letter and verifying all functionality. Try Later.</Message>
	// </Response>";		
// exit;
if ($pn=='reset') {
	echo "
	<Response>
		<Message>Application was reset successfully! To restart process, please upload a pdf or a picture of your passport (first page)...</Message>
	</Response>";		
	$student_id=get_var('student_id');
	$c->insert("delete from x_comm_progression where mobile='$from'");
	$c->insert("delete from x_comm_variable_store where mobile='$from'");
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_raw_scores where student_id='$student_id'");
	$c->insert("delete from student_registration where mobile='$from'");
	$next_action="first_page";
	$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
} else if ($pn=='upload') {
	$student_id=get_var('student_id');
	$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$student_id')");
	$c->insert("delete from x_comm_progression where mobile='$from' and next_action='showing_courses'");
	$c->insert("delete from x_comm_progression where mobile='$from' and next_action='show'");
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_raw_scores where student_id='$student_id'");
	$c->insert("delete from student_registration where mobile='$from'");
	echo "
	<Response>
		<Message>Please re-upload your 12th marksheet!!!</Message>
	</Response>";	
} else if (strstr($pn,'purge')) {
	if (stristr($pn,'12345678')) {
		$mobile=str_replace('+','',$c->isValidIndianMobile(trim(str_replace('12345678','',str_replace('purge','',$pn)))));
		purge_student($c,$mobile);
	}
} else {
	if (($r['NumMedia']*1=='0') && $pn=="" && ($next_action !=="first_page") && ($next_action !=="get_board") && ($next_action !=="upload_english_test") && ($next_action !=="upload_marksheet")) {
		echo "<Response>
			<Message>That message was *blank* and Im pretty sure I have no use for it. Please try again.</Message>
		</Response>";		
	} else {
		if ((empty($next_action) || $next_action===null)) {
			$c->insert("DELETE FROM `edu`.`x_comm_courses_displayed` WHERE mobile='$from'");
			echo "
<Response>
<Message>
To start your admission application process, we need the following documents:\r\n
1. Passport: First Page
2. Passport Last page
3. IELTS / PTE / TOEFL Score Card
4. 12th Marksheet\r\n
Please start by uploading the first page of your passport!
</Message>
</Response>";
			$next_action="first_page";
			if (!empty(trim($from)))  $c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
		} else if ($next_action=="first_page") {
			if ($r['NumMedia']=='1') {
				if ($r['MediaContentType0']=='image/jpeg') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.jpg';
				}
				if ($r['MediaContentType0']=='image/png') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.png';
				}
				if ($r['MediaContentType0']=='application/pdf') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.pdf';
				}
				$p=exec("curl -X POST https://api.mindee.net/v1/products/mindee/passport/v1/predict -H 'Authorization: Token 31f1c735e446fcdf392a590a1ace7e37' -H 'content-type: multipart/form-data' -F document=$url");
				$arr1=json_decode($p,true);
				$data=$arr1['document']['inference']['prediction'];

				$birth_date=$data['birth_date']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'birth_date', '$birth_date')");
				$birth_place=$data['birth_place']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'birth_place', '$birth_place')");
				$country=$data['country']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'country', '$country')");
				$expiry_date=$data['expiry_date']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'expiry_date', '$expiry_date')");
				$gender=$data['gender']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'gender', '$gender')");
				$student_name=$data['given_names'][0]['value'] . " " . $data['given_names'][1]['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'student_name', '$student_name')");
				$passport_no=$data['id_number']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'passport_no', '$passport_no')");
				$issuance_date=$data['issuance_date']['value'];
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'issuance_date', '$issuance_date')");

				echo "<Response>
					<Message>Now, please send us the second page of your passport</Message>
				</Response>";	

				$next_action="get_board";
				$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

			} else {
			echo "
<Response>
<Message>
To start your admission application process, we need the following documents:\r\n
1. Passport: First Page
2. Passport Last page
3. IELTS / PTE / TOEFL Score Card
4. 12th Marksheet\r\n
Please start by uploading the first page of your passport!
</Message>
</Response>";
			}
		} else if ($next_action=="get_board") {
			if ($r['NumMedia']=='1') {
				if ($r['MediaContentType0']=='image/jpeg') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.jpg';
				}
				if ($r['MediaContentType0']=='image/png') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.png';
				}
				if ($r['MediaContentType0']=='application/pdf') {
					file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
					$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf';
					$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.pdf';
				}
				
				$p=exec("curl -X POST https://api.mindee.net/v1/products/theaviator007/passport_page_2/v1/predict -H 'Authorization: Token 31f1c735e446fcdf392a590a1ace7e37' -H 'content-type: multipart/form-data' -F document=$url");
				
				file_put_contents("0_p.txt",$p);
				$arr1=json_decode($p,true);

				$data=$arr1['document']['inference']['prediction'];
				file_put_contents("0_p1.txt",json_encode($data));

				$address1=$data['address1']['values'];
				$add1="";
				for ($j=0; $j<count($address1); $j++) {
					$add1.=$address1[$j]['content'] . " ";
				}
		//		$address1=$add1;
				
				$address2=$data['address2']['values'];
				$add2="";
				for ($j=0; $j<count($address2); $j++) {
					$add2.=$address2[$j]['content'] . " ";
				}
		//		$address2=$add2;

				$address3=$data['address3']['values'];
				$add3="";
				for ($j=0; $j<count($address3); $j++) {
					$add3.=$address3[$j]['content'] . " ";
				}
			//	$address3=$add3;

				$fathers_name=$data['name']['values'];
				$fn="";
				for ($j=0; $j<count($fathers_name); $j++) {
					$fn.=$fathers_name[$j]['content'] . " ";
				}
		//		$fathers_name=$fn;
				
				$mothers_name=$data['spouse']['values'];
				$mn="";
				for ($j=0; $j<count($mothers_name); $j++) {
					$mn.=$mothers_name[$j]['content'] . " ";
				}
		//		$mothers_name=$mn;

				$file_no=$data['file']['values'];
				$fl="";
				for ($j=0; $j<count($file_no); $j++) {
					$fl.=$file_no[$j]['content'] . " ";
				}
		//		$file_no=$fl;

				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'fathers_name', '$fn')");
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'mothers_name', '$mn')");
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'address1', '$add1')");
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'address2', '$add2')");
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'address3', '$add3')");
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'file_no', '$fl')");

				echo "
				<Response>
					<Message>What was your school board? Abbreviation are ok. Eg CBSE or PSEB etc</Message>
				</Response>";	

				$next_action="request_location";
				$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

			} else {
				if ($set_reset=="true") {
				echo "<Response>
					<Message>Records Reset! To re-start, you must send us a pic of your passport</Message>
				</Response>";	
				} else {
				echo "<Response>
					<Message>Please send us a pic of page 2 of your passport</Message>
				</Response>";
				}
			}
		} else if ($next_action=="request_location") {
			$board=strtolower(trim($r["Body"]));
			$board_str="";
			$board=trim(strtolower(str_replace(array(".",",","-","(",")"),"",$r["Body"])));
			$b=$c->query("select board from x_boards where board='$board' or board_a='$board'");
			if ($board !== strtolower(str_replace(array(".",",","-","(",")"),"",$b[0]['board']))) {
				if (is_numeric(trim($board))) {
					del_var('board_selected');
					set_var('board_selected',$board);
					$sel_board=json_decode(get_var('boards'),true)[trim($board)*1-1];
					if ($sel_board!=="") {
						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'board', '$sel_board')");
						$lx=$c->query("select show_location from x_show_locations group by show_location");
						$sStr="
						<Response>
							<Message>
								 \r\n Please Select your Preferred City where you would like to attend college \r\n \r\n";
									for ($x=0; $x<count($lx); $x++) {
										$loc[]=$lx[$x]['show_location'];
									}
									for ($x=0; $x<count($loc); $x++) {
										$sStr.=($x+1) . ". " . $loc[$x] . "\r\n" ;
									}
							$sStr.="Reply with selection (1 - " . (count($loc)) . ")
							</Message>
						</Response>";	
						echo $sStr;
						$next_action="request_email";
						$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
					}
				} else {
					$b1=$c->query("select * from x_boards where trim(`board`) LIKE '$board%'");
					if (count($b1)>5) {
							echo "<Response>
								<Message>That was too broad. Please more specific.</Message>
							</Response>";				
					} else {
						if (count($b1)>0) {
							for ($x=0; $x<count($b1); $x++) {
								$board_str=ltrim($board_str) . ($x+1) . ". " . trim($b1[$x]['board']) . "\r\n";
								$bx[]=$b1[$x]['board'];
							}
							del_var('boards');
							set_var('boards',json_encode($bx));
							echo "<Response>
								<Message>Based on your input, we found the following boards:\r\n\r\n$board_str\r\nPlease select one by replying with a number (1,2,3 or the board name)</Message>
							</Response>";
						} else {
							echo "<Response>
								<Message>No match found. Try again please.</Message>
							</Response>";
						}
					}
				}
			} else {
				$sel_board=$board;
				del_var('board_selected');
				set_var('board_selected',$board);
				$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'board', '$sel_board')");
				$lx=$c->query("select show_location from x_show_locations group by show_location");
				$sStr="
				<Response>
					<Message>
						 \r\n Please Select your Preferred City where you would like to attend college \r\n \r\n";
							for ($x=0; $x<=count($lx); $x++) {
								$loc[]=$lx[$x]['show_location'];
							}
							for ($x=0; $x<count($loc); $x++) {
								$sStr.=($x+1) . ". " . $loc[$x] . "\r\n" ;
							}
					$sStr.="Reply with selection (1 - " . (count($loc)-1) . ")
					</Message>
				</Response>";	
				echo $sStr;
				$next_action="request_email";
				$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
			}
		} else if ($next_action=="request_email") {
			$lx=$c->query("select show_location from x_show_locations group by show_location");
			for ($x=0; $x<count($lx); $x++) {
				$loc[]=$lx[$x]['show_location'];
			}
			$location=trim($r["Body"]);
			$locx=$loc[$location*1];
			$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'location', '$locx')");
			echo "
			<Response>
				<Message>Whats yor Email Address?</Message>
			</Response>";	
			$next_action="request_english_test_type";
			$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

		} else if ($next_action=="request_english_test_type") {
			$stream=$r["Body"];
			$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'email', '$stream')");
			echo "
<Response>
<Message> We now need to know what type of English proficiency exam you took. \r\n  Please make a selection below [1 to 3]: \r\n
1. IELTS 
2. PTS 
3. TOEFL 
</Message>
</Response>";	
			$next_action="request_upload_english_test";
			$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

		} else if ($next_action=="request_upload_english_test") {
			if ($r["Body"]=="1") $english_test_type="IELTS";
			if ($r["Body"]=="2") $english_test_type="PTS";
			if ($r["Body"]=="3") $english_test_type="TOEFL";
			$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'english_test_type', '$english_test_type')");
			echo "
			<Response>
				<Message>
					Please upload your $english_test_type Marksheet
				</Message>
			</Response>";	
			$next_action="upload_english_test";
			$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

		} else if ($next_action=="upload_english_test") {
			/*
				Call OCR Mindee
			*/
				if ($r['NumMedia']=='1') {
					if ($r['MediaContentType0']=='image/jpeg') {
						file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
						$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg';
						$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.jpg';
						$ielts_url="curl -X POST https://api.mindee.net/v1/products/manishpahwa/ielts_certificate/v1/predict -H 'Authorization: Token 887ecdb4b35faf5bcf6cdb48b51d0e7a' -H 'content-type: multipart/form-data' -F document=$url";
						$m=exec($ielts_url);
					} else if ($r['MediaContentType0']=='image/png') {
						file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
						$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png';
						$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.png';
						$ielts_url="curl -X POST https://api.mindee.net/v1/products/manishpahwa/ielts_certificate/v1/predict -H 'Authorization: Token 887ecdb4b35faf5bcf6cdb48b51d0e7a' -H 'content-type: multipart/form-data' -F document=$url";
						$m=exec($ielts_url); 
					} else {
						file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
						$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf';
						$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.pdf';
						$ielts_url="curl -X POST https://api.mindee.net/v1/products/manishpahwa/ielts_certificate/v1/predict -H 'Authorization: Token 887ecdb4b35faf5bcf6cdb48b51d0e7a' -H 'content-type: multipart/form-data' -F document=$url";
						$m=exec($ielts_url);
					}
						file_put_contents("ielts_url.txt",$ielts_url);
						echo "
						<Response>
							<Message>Whats your year of passing for class 10?</Message>
						</Response>";	

						$d=json_decode($m,true);
						file_put_contents("ielts2.txt",$m);
						$score_listening=$d['document']['inference']['pages'][0]['prediction']['score_listening']['values'][0]['content'];
						$score_reading=$d['document']['inference']['pages'][0]['prediction']['score_reading']['values'][0]['content'];
						$score_writing=$d['document']['inference']['pages'][0]['prediction']['score_writing']['values'][0]['content'];
						$score_speaking=$d['document']['inference']['pages'][0]['prediction']['score_speaking']['values'][0]['content'];
						$score_overall=$d['document']['inference']['pages'][0]['prediction']['score_overall']['values'][0]['content'];

						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'score_listening', '$score_listening')");
						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'score_reading', '$score_reading')");
						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'score_writing', '$score_writing')");
						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'score_speaking', '$score_speaking')");
						$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'score_overall', '$score_overall')");

						$next_action="year_10th_passing";
						$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");

				} else {
					echo "
						<Response>
							<Message>
								Please upload a valid $english_test_type Marksheet
							</Message>
						</Response>";	
				}
			
		} else if ($next_action=="year_10th_passing") {
			/*
				Call OCR Mindee
			*/
			$year_10th_passing=$pn;
			set_var('year_10th_passing',trim($pn));
			$next_action="process_marksheet";
			$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
			echo "<Response>
				<Message>Please upload your 12th marksheet.\r\n\r\nPlease keep in mind that once you upload, it will take upto 2 minutes to check your eligibility and process your marksheet. Thank you in advance for waiting.
				</Message>
			</Response>";
		} else if ($next_action=="process_marksheet") {
			/*
				Call OCR Mindee
			*/

			if ($r['MediaContentType0']=='image/jpeg') {
				file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
				$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.jpg';
				$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.jpg';
				$m=exec("curl -X POST https://api.mindee.net/v1/products/theaviator007/cbse_marksheet/v1/predict -H 'Authorization: Token e9651837ac4e3ac2622b542d666e114f' -H 'content-type: multipart/form-data' -F document=$url");
			} else if ($r['MediaContentType0']=='image/png') {
				file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
				$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.png';
				$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.png';
				$m=exec("curl -X POST https://api.mindee.net/v1/products/theaviator007/cbse_marksheet/v1/predict -H 'Authorization: Token e9651837ac4e3ac2622b542d666e114f' -H 'content-type: multipart/form-data' -F document=$url");
			} else {
				file_put_contents('whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf', $c->get_remote_data(stripslashes($r['MediaUrl0'])));
				$doc='/sites/home2/terrawire/public_html/whatsapp_attc/' . stripslashes($r['SmsMessageSid']) . '.pdf';
				$url="https://terrawire.com/whatsapp_attc/" . stripslashes($r['SmsMessageSid']) . '.pdf';
				$m=exec("curl -X POST https://api.mindee.net/v1/products/theaviator007/cbse_marksheet/v1/predict -H 'Authorization: Token e9651837ac4e3ac2622b542d666e114f' -H 'content-type: multipart/form-data' -F document=$url");
				
			}
			// /*
				// Now parse Marks
			// */

			$d=json_decode($m,true);

			$year_12th_passing=$d['document']['inference']['pages'][0]['prediction']['dated']['values'][0]['content'];
			$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'year_12th_passing', '$year_12th_passing')");
			set_var('year_12th_passing',trim($year_12th_passing));
			
			$content1=$d['document']['inference']['pages'][0]['prediction']['sub1']['values'];
			file_put_contents('ocrRaw.txt',file_get_contents('ocrRaw.txt') . PHP_EOL . json_encode($content1));
			$sub1='';
			for ($j=0; $j<count($content1); $j++) {
				$sub1.=$content1[$j]['content'] . " ";
			}
			$sub[]=strtolower(trim($sub1));

			$content2=$d['document']['inference']['pages'][0]['prediction']['sub2']['values'];
			file_put_contents('ocrRaw.txt',file_get_contents('ocrRaw.txt') . PHP_EOL . json_encode($content2));
			$sub2='';
			for ($j=0; $j<count($content2); $j++) {
				$sub2.=$content2[$j]['content'] . " ";
			}
			$sub[]=strtolower(trim($sub2));

			$content3=$d['document']['inference']['pages'][0]['prediction']['sub3']['values'];
			file_put_contents('ocrRaw.txt',file_get_contents('ocrRaw.txt') . PHP_EOL . json_encode($content3));
			$sub3='';
			for ($j=0; $j<count($content3); $j++) {
				$sub3.=$content3[$j]['content'] . " ";
			}
			$sub[]=strtolower(trim($sub3));

			$content4=$d['document']['inference']['pages'][0]['prediction']['sub4']['values'];
			file_put_contents('ocrRaw.txt',file_get_contents('ocrRaw.txt') . PHP_EOL . json_encode($content4));
			$sub4='';
			for ($j=0; $j<count($content4); $j++) {
				$sub4.=$content4[$j]['content'] . " ";
			}
			$sub[]=strtolower(trim($sub4));

			$content5=$d['document']['inference']['pages'][0]['prediction']['sub5']['values'];
			$sub5='';
			for ($j=0; $j<count($content5); $j++) {
				$sub5.=$content5[$j]['content'] . " ";
			}
			$sub[]=strtolower(trim($sub5));
			file_put_contents('ocr5.txt',json_encode($sub));

			$total[]=$d['document']['inference']['pages'][0]['prediction']['total1']['values'][0]['content'];
			$total[]=$d['document']['inference']['pages'][0]['prediction']['total2']['values'][0]['content'];
			$total[]=$d['document']['inference']['pages'][0]['prediction']['total3']['values'][0]['content'];
			$total[]=$d['document']['inference']['pages'][0]['prediction']['total4']['values'][0]['content'];
			$total[]=$d['document']['inference']['pages'][0]['prediction']['total5']['values'][0]['content'];
			file_put_contents('ocr55.txt',json_encode($total));

			if ($d['document']['inference']['pages'][0]['prediction']['total6']) {
				if ($d['document']['inference']['pages'][0]['prediction']['total6']['values'][0]['content']*1 >0) {
					$content6=$d['document']['inference']['pages'][0]['prediction']['sub6']['values'];
					$sub6='';
					for ($j=0; $j<count($content6); $j++) {
						$sub6.=$content6[$j]['content'] . " ";
					}
					$sub[]=strtolower(trim($sub6));
					$total[]=$d['document']['inference']['pages'][0]['prediction']['total6']['values'][0]['content'];
				}
			}
			
			if ($d['document']['inference']['pages'][0]['prediction']['total7']) {
				if ($d['document']['inference']['pages'][0]['prediction']['total7']['values'][0]['content']*1 >0) {
					$content7=$d['document']['inference']['pages'][0]['prediction']['sub7']['values'];
					$sub7='';
					for ($j=0; $j<count($content7); $j++) {
						$sub7.=$content7[$j]['content'] . " ";
					}
					$sub[]=strtolower(trim($sub7));
					$total[]=$d['document']['inference']['pages'][0]['prediction']['total7']['values'][0]['content'];
				}
			}
			
			if ($d['document']['inference']['pages'][0]['prediction']['total8']) {
				if ($d['document']['inference']['pages'][0]['prediction']['total8']['values'][0]['content']*1 >0) {
					$content8=$d['document']['inference']['pages'][0]['prediction']['sub8']['values'];
					$sub8='';
					for ($j=0; $j<count($content8); $j++) {
						$sub8.=$content8[$j]['content'] . " ";
					}
					$sub[]=strtolower(trim($sub8));
					$total[]=$d['document']['inference']['pages'][0]['prediction']['total8']['values'][0]['content'];
				}
			}
			
			/*
				Now Create new student ID by inserting in student_reg table
			*/
			$email=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='email'")[0]['variable_value'];
			$c->insert("delete from student_registration where mobile='$from'");
			$student_id=$c->insert("INSERT INTO `edu`.`student_registration` (`email`, `mobile`, `fname`,`pswd`) VALUES ('$email', '$from', '$name','$from')");
			$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', 'student_id', '$student_id')");
				
			/*
				Now Insert Marks in DB, with student ID
			*/
			for ($i=0; $i<count($sub); $i++) {
				$board=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='board' LIMIT 1")[0]['variable_value'];
				$board_id='14';
				$arrA=array(". "," ."," . ");
				$arrB=array("","","");
				$subject=str_replace($arrA,$arrB,trim($sub[$i]));
				if ($i>0) {
					$subject=trim(str_replace($sub[$i-1],"",$sub[$i]));
				} else {
					$subject=trim($sub[$i]);
				}
				if ($subject=="business accountancy") $subject="accountancy";
				$subject=str_replace("accountancy","",strtolower($subject));
				if ($subject=="") $subject="accountancy";
				$subject_id=$c->query("select * from x_subjects_progression where `subject`='$subject' and `board_id`='14'")[0]['id'];
				$stp[]=$c->query("select * from `x_subjects_progression` where `id`='$subject_id' and `board_id`='14'")[0]['subject_type'];
				$marks=$total[$i];
				$xid[]=$c->insert("INSERT INTO `edu`.`x_raw_scores` (`student_id`, `subject_id`, `score`, `max`, `board_id`, `grade`, `subject_type`, `board_level`) VALUES ('$student_id', '$subject_id', '$marks', 100, '$board_id', '12', '', '2')");
			}
			/*
				Now Generate x_matrix link with student_id, fetch it, then parse and show progression subjects
			*/
			$xids=implode("|",$xid);
			$stps=implode("|",$stp);
			$from=str_replace('+','',$from);
			shell_exec("curl 'https://terrawire.com/edu/x_matrix.php?student_id=$student_id&mobile=$from&xids=$xids&stps=$stps' > /dev/null &");
			$strOp="";
			$year_10th_passing=get_var('year_10th_passing')*1;
			$year_12th_passing=get_var('year_12th_passing')*1;
			$gap=$year_12th_passing*1-$year_10th_passing*1;
			set_var('10th_to_12th_gap',$gap);
echo "
<Response>
	<Message>Based on your marksheet and location preferences, we found multiple qualifying courses in which you are very likely to get admission. \r\n\r\nTo see your matches, Click link below. \r\n\r\nYou will need to login to your student portal. Your Credentials:\r\n\r\n*Login*: $email\r\n*Password*: $from\r\n*URL*:https://admitid.com/signin?" . base64_encode("$email|$from|$student_id") . "\r\n\r\nLogin to view courses now!</Message>
</Response>";
			
			}
	}
}

function get_var($var) {
	global $c;
	return $c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='$var'")[0]['variable_value'];
}

function set_var($var,$val) {
	global $c;
	global $from;
	del_var($var);
	$c->insert("INSERT INTO `edu`.`x_comm_variable_store` (`mobile`, `variable_name`, `variable_value`) VALUES ('$from', '$var', '$val')");
}

function del_var($var) {
	global $c;
	global $from;
	$c->insert("DELETE FROM `edu`.`x_comm_variable_store` WHERE `mobile`='$from' and `variable_name`='$var'");
}

function reset_all() {
	echo "
	<Response>
		<Message>Application was reset successfully! To restart process, please upload or take a picture of your passport</Message>
	</Response>";		
	global $from;
	global $c;
	$from=str_replace('+','',$from);
	file_put_contents('reset_all.txt',$from);
	$student_id=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='student_id' LIMIT 1")[0]['variable_value'];
	$c->insert("delete from student_registration where mobile='$from'");
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_comm_progression where mobile='$from'");
	$c->insert("delete from x_comm_variable_store where mobile='$from'");
	$c->insert("delete from x_raw_scores where student_id='$student_id'");

	$next_action="get_board";
	if (!empty(trim($from))) $c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
}

function re_upload() {
	global $from;
	global $c;
	$from=str_replace('+','',$from);
	file_put_contents('upload_all.txt',$from);
	$student_id=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='student_id' LIMIT 1")[0]['variable_value'];
	$c->insert("delete from x_comm_progression where mobile='$from' AND next_action='show'");
	$c->insert("delete from x_comm_variable_store where mobile='$from' and variable_name='current'");
	$c->insert("delete from x_comm_variable_store where mobile='$from' and variable_name='total'");
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_raw_scores where student_id='$student_id'");
}

function reset_student() {
	global $from;
	global $c;
	$from=str_replace('+','',$from);
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_comm_progression where mobile='$from'");
	$c->insert("delete from x_comm_variable_store where mobile='$from'");
	$student_id=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='student_id' LIMIT 1")[0]['variable_value'];
	$c->insert("delete from x_raw_scores where student_id='$student_id'");
	$next_action="get_board";
	$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
}

function purge_student($c,$mobile) {
	global $c;
	$from=$mobile;
	$c->insert("delete from x_comm_courses_displayed where mobile='$from'");
	$c->insert("delete from x_comm_progression where mobile='$from'");
	$c->insert("delete from x_comm_variable_store where mobile='$from'");
	$student_id=$c->query("select variable_value from x_comm_variable_store where mobile='$from' and variable_name='student_id' LIMIT 1")[0]['variable_value'];
	$c->insert("delete from x_raw_scores where student_id='$student_id'");
	
	echo "<Response><Message>To start, you must send us a pic of your passport</Message></Response>";		

	$next_action="get_board";
	$c->insert("INSERT INTO `edu`.`x_comm_progression` (`mobile`, `next_action`) VALUES ('$from', '$next_action')");
}
/*

FRONT END VALIDATIONS

Name: 
	Passport 1st page
	12th Marksheet
	IELTS etc
	
Parents name
	Passport Last page
	12th Marksjheet
	
DOB
	Passport 1st page
	12th Marksheet
	IELTS etc
	
Passport Number: 
	Passport 1st page
	IELTS etc

GAP
	Between 10th and 12th: 2 years max
	After 12th: 18 Months Max
	IELTS: Max 2 years after date of result

*/
?>