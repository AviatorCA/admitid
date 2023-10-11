<?php
$mobile=base64_decode($_SERVER['QUERY_STRING']);
if (!$mobile) $mobile="15274163323";
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
	<meta http-equiv="Cache-control" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Khand" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css" />
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <title>View Interview</title>

<style>
a{
font-family:Khand
}
.container * {
    margin: 0;
    padding: 0;
    -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
    -webkit-transition: 0.5s;
    -o-transition: 0.5s;
    transition: 0.5s;

}
.container *:after , .container *:before {
	margin: 0;
    padding: 0;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

h2.title {
    font-size: 24px;
    color: #fff;
    font-weight: bold;
    font-family: tahoma;
    text-align: center;
    padding: 2em;
    display: block;
    margin: auto;
    background-color: #A97A7A;
}
.container {
    width: 960px;
    background: none;
    margin: auto;
    position: relative;
    height: 460px;
}
.vidcontainer {

	width: 75%;
    height: 100%;
    float: right;
    position: relative;
    overflow: hidden;
}

video {
    width: 100%;
    height: 405px;
    color: #fff;
    text-align: center;
    font-size: 20px;
}

.videolist {
    float: right;
    width: 25%;
    background-color: rgb(76, 76, 76);
    height: 100%;
    position: relative;
}

.vids {
    margin: 5px;
    background-color: #292626;
    max-height: 450px;
    min-height: 450px;
    border: 1px solid #616060;
    overflow-y: scroll;
    list-style: none;
    direction: rtl;
}
.vids::-webkit-scrollbar {
    width: 5px;
    background-color: #8A8A8A;
    border: 1px solid #AFACAC;

}
.vids::-webkit-scrollbar-thumb {
    background-color: #FF8D00;
    border-radius: 5px;
}
.vids::-webkit-scrollbar-thumb:hover{
background-color:#fff;
}
.vids::-webkit-scrollbar-thumb:active{
background-color:#ccc;
}


.vids a {
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    display: block;
    border-bottom: 1px solid #616060;
    padding: 8px 5px;
    margin: 5px;
}

/*--- controllers ---*/
.controllers {
    position: absolute;
    bottom: 0;
    height: 50px;
    background-color: #fff;
    width: 100%;
}

.controllers button {
    border: 1px solid #E7E7E7;
    background-color: #FFFFFF;
    color: #777;
    height: 40px;
    width: 40px;
    border-radius: 50%;
    margin: 5px;
    box-shadow: 1px 1px 3px #4C4C4C;
    outline: none;
    font-size: 18px;
    display: inline-block;
    float: left;
}

.controllers button:focus {
    box-shadow: 1px 0px 7px #4C4C4C;
    border-color: #ff8d00;
    color: #ff8d00;
    background-color: #4C4C4C;
}

.btnPlay:after {
    content: "\f04b";
    font-family: 'FontAwesome';
}
.paused:after {
    content: "\f04c";
}

.sound:after {
content: "\f027";
    font-family: 'FontAwesome';
}
.sound2:after {
content: "\f028";
}

.muted:after {
    content: "\f026";
}
.btnFS:after {
     content: "\f065";
    font-family: 'FontAwesome';
}
.ads {
    height: 350px;
    width: 350px;
    position: absolute;
    background-color: #777;
    top: 27.5px;
    right: 40px;
    z-index: 11;
}
.bigplay {
    height: 150px;
    width: 150px;
    position: absolute;
    top: 127.5px;
    left: 40%;
    z-index: 11;
    color: #fff;
    font-size: 150px;
    line-height: 150px;
    text-align: center;
    cursor: pointer;
    text-shadow: 0px 0px 15px #ff8d00;
}
.closeme {
    height: 32px;
    width: 32px;
    background-color: #fff;
    top: -10px;
    right: -10px;
    border: 1px solid #ff8d00;
    display: block;
    position: absolute;
    border-radius: 50%;
    text-align: center;
    line-height: 30px!important;
    color: #ff8d00;
    font-size: 25px!important;
}

.playing {
    background-color: #999;
    border: 1px solid #ff8d00!important;
    -webkit-transition: 0s;
    -o-transition: 0s;
    transition: 0s;
 }
.playing:after {
    content: "\f01d";
    font-family: 'FontAwesome';
    color: #f0f0f0;
    float: left;
}
/* PROGRESS BAR CSS */

.topControl {
    position: absolute;
    display: block;
    width: 100%;
    bottom: 50px;
    background-color: #fff;
    z-index: 1;
}
/* Progress bar */
.progress {
    width: 100%;
    height: 5px;
    position: relative;
    float: left;
    cursor: pointer;
    background: #999;
}
.progress span {
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    display: block;
}
.timeBar{
    z-index:10;
    width:0;
    background: #ff8d00;
}

.bufferBar{
    z-index:5;
    width:0;
    background: #eee;
}
/* time and duration */
.time{
    width:12%;
    float:right;
    text-align:center;
    font-size:11px;
    line-height:12px;
    right: -12%;
    opacity: 0;
    position: absolute;
}

.topControl:hover .time {
    right: 0;
    opacity: 1;
}


.topControl:hover .progress {
    width: 88%;
    height: 12px;
}

/* VOLUME BAR CSS */
/* volume bar */
.volume {
    position: relative;
    cursor: pointer;
    width: 70px;
    height: 10px;
    float: left;
    margin-top: 20px;
    margin-right: 15px;
    background-color: #999;
}
.volumeBar{
    display: block;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #ff8d00;
    z-index: 10;
}

.loading {
    width: 100%;
    background-color: rgba(255,141,0,0.5);
    height: 405px;
    position: absolute;
    top: 0;
}
i.fa.fa-spinner.fa-spin {
    height: 60px;
    width: 60px;
    font-size: 60px;
    color: #fff;
    text-shadow: 0px 0px 8px #000;
    top: 172.5px;
    left: 330px;
    position: absolute;
}
.disabled {
    pointer-events: none;
    cursor: not-allowed;
    background-color: #C2C2C2!important;
}


ul.speedcnt {
    display: none;
    position: absolute;
    right: 30px;
    bottom: 60px;
    background-color: #fff;
    border-radius: 5px;
    list-style: none;
    -webkit-transition: 0s;
    -o-transition: 0s;
    transition: 0s;
}

ul.speedcnt li {
    text-align: center;
    font-family: 'verdana', tahoma , serif;
    font-size: 13px;
    padding: 5px 20px;
    cursor: pointer;
    display: block;
    border-bottom: 1px solid #ccc;
}

ul.speedcnt li:last-child {
    border-bottom: none;
}

ul.speedcnt li.selected {
    background-color: rgba(255, 141, 0, 0.6);
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
</head>

<body style="background:#f0f0f0" translate="no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!--[if lt IE 9]>
  <script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<div class="container">
<div class="vidcontainer">
<video id="myvid" >

  Your browser does not support the video tag.
  
</video>

        <div class="topControl">
			<div class="progress">
				<span class="bufferBar"></span>
				<span class="timeBar"></span>
			</div>
			<div class="time">
				<span class="current"></span> / 
				<span class="duration"></span> 
			</div>
        </div>

<div class="controllers">
  	<button class="btnPlay" title="Play/Pause video"></button>
  	<button class="prevvid disabled" title="Previous video"><i class="fa fa-step-forward fa-rotate-180"></i></button>
    <button class="nextvid" title="Next video"><i class="fa fa-step-forward"></i></button>
    <button class="sound sound2 btn" title="Mute/Unmute sound"></button>
    <div class="volume" title="Set volume">
			<span class="volumeBar"></span>
	</div>
    <button class="btnFS " style="float:right" title="full screen"></button>
    <button class="btnspeed " style="float:right" title="Video speed"><i class="fa fa-gear"></i></button>
    <ul class="speedcnt">
    	<li class="spdx50">1.5</li>
    	<li class="spdx25">1.25</li>
    	<li class="spdx1 selected">Normal</li>
    	<li class="spdx050">0.5</li>
    </ul>
	<button class="btnLight lighton " style="float:right" title="on/off light"><i class="fa fa-lightbulb-o"></i></button>
</div>
<div class="bigplay" title="play the video"><i class="fa fa-play-circle-o"></i></div>
<div class="loading"><i class="fa fa-spinner fa-spin"></i></div>
    </div>

	<div class="videolist">
		<nav class="vids">
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_0.mp4?dsdsd">About You</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_1.mp4">Why this Course</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_2.mp4">Why this Univ</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_3.mp4">Why Australia</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_4.mp4">Funding</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_5.mp4">Intentions</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_6.mp4">Job Prospects</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_7.mp4">VISA</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_8.mp4">Rejections</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_9.mp4">Siblings</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_10.mp4">Family in Australia</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_11.mp4">Sponsor</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_12.mp4">Dependents</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_13.mp4">Start Date</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_14.mp4">OSHC</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_15.mp4">Extra Curricular</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_16.mp4">Anything Else</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_qa_17.mp4">Thank You</a>
			<a class="link" href="https://terrawire.com/uploads/<?=$mobile;?>_interview.mp4">Full Interview</a>
		</nav>
	</div>
</div>
    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script id="rendered-js" >
/* nice mp4 video playlist with jQuery 
   created by: Menni Mehdi
   in : 23/01/2016
   license : if you like it use it
*/


$(document).ready(function ()
{
	
	// questions[0]='So, please tell me about yourself? Feel free to talk about your academic and other achievements?'
	// questions[1]='Why have you selected this course? How do you feel this course will help your career?'
	// questions[2]='Why have you chosen this university? What other universities have you researched in Australia?'
	// questions[3]='Why do you want to study in Australia?! Why not study a similar course offered by an Indian university?'
	// questions[4]='How do you intend to fund your education and living expenses in Australia?'
	// questions[5]='What do you intend to do in Australia once your current course ends?'
	// questions[6]='What are your job prospects on completion of your chosen course of study?'
	// questions[7]='Are you aware, of the conditions of your student visa?'
	// questions[8]='Have you or any of your family members travelled abroad or have had any visa rejections in the past?'
	// questions[9]='How many siblings do you have? What do they do?'
	// questions[10]='Do you know someone in Australia?'
	// questions[11]='Who is sponsoring your studies in Australia? How are you related to the sponsor?'
	// questions[12]='Are there more people who are dependent on your sponsor?'
	// questions[13]='What are your course commencement and end dates? And how much does it cost?'
	// questions[14]='Do you know about OSHC? Why is it necessary for every student!'
	// questions[15]='What are your extra curricular hobbies? Do you play any sports?'
	// questions[16]='Is there anything else you would like to add?'
	// questions[17]='Thank you so much for your time! It was nice talking to you.'
			
  var vid = $('#myvid');

  //default video source
  $(vid).attr("src", $("a.link:first").attr("href"));

  // addClass playing to first video link
  $("a.link:first").addClass("playing");


  $("a.link").on("click", function (event) {

    // prevent link default
    event.preventDefault();

    // change video source
    $(vid).attr("src", $(this).attr("href"));

    // remouve class playing from unplayed video href
    $(".vids a").removeClass("playing");

    // add class playing to video href
    $(this).addClass("playing");

    // add class paused to give the play/pause button the right look  
    $('.btnPlay').addClass('paused');

    // play the video
    vid[0].play();

    // adjust prev button state
    if ($("a.link:first").hasClass("playing")) {
      $(".prevvid").addClass("disabled");
    } else
    {
      $(".prevvid").removeClass("disabled");
    }

    // adjust next button state
    if ($("a.link:last").hasClass("playing")) {
      $(".nextvid").addClass("disabled");
    } else
    {
      $(".nextvid").removeClass("disabled");
    }

  });


  //VIDEO EVENTS
  //video canplay event
  vid.on('canplay', function () {
    $('.loading').fadeOut(100);
  });

  //video canplaythrough event
  //solve Chrome cache issue
  var completeloaded = false;
  vid.on('canplaythrough', function () {
    completeloaded = true;
  });

  //video ended event
  vid.on('ended', function () {
    $('.btnPlay').removeClass('paused');
    vid[0].pause();
  });

  //video seeking event
  vid.on('seeking', function () {
    //if video fully loaded, ignore loading screen
    if (!completeloaded) {
      $('.loading').fadeIn(200);
    }
  });

  //video seeked event
  vid.on('seeked', function () {});

  //video waiting for more data event
  vid.on('waiting', function () {
    $('.loading').fadeIn(200);
  });

  /*controllers*/
  //before everything get started
  vid.on('loadedmetadata', function () {
    //set video properties
    $('.current').text(timeFormat(0));
    $('.duration').text(timeFormat(vid[0].duration));
    if (vid[0].muted)
    {
      updateVolume(0, 0);
    } else
    {
      updateVolume(0, 0.7);
    }
  });

  //display video buffering bar
  var startBuffer = function () {
    var currentBuffer = vid[0].buffered.end(0);
    var maxduration = vid[0].duration;
    var perc = 100 * currentBuffer / maxduration;
    $('.bufferBar').css('width', perc + '%');

    if (currentBuffer < maxduration) {
      setTimeout(startBuffer, 500);
    }
  };


  //display current video play time
  vid.on('timeupdate', function () {
    var currentPos = vid[0].currentTime;
    var maxduration = vid[0].duration;
    var perc = 100 * currentPos / maxduration;
    $('.timeBar').css('width', perc + '%');
    $('.current').text(timeFormat(currentPos));
  });

  //CONTROLS EVENTS
  //video screen and play button clicked
  vid.on('click', function () {playpause();});
  $('.btnPlay').on('click', function () {playpause();});
  var playpause = function () {
    if (vid[0].paused || vid[0].ended) {
      $('.btnPlay').addClass('paused');
      vid[0].play();
    } else
    {
      $('.btnPlay').removeClass('paused');
      vid[0].pause();
    }
  };

  //VIDEO PROGRESS BAR
  //when video timebar clicked
  var timeDrag = false; /* check for drag event */
  $('.progress').on('mousedown', function (e) {
    timeDrag = true;
    updatebar(e.pageX);
  });
  $(document).on('mouseup', function (e) {
    if (timeDrag) {
      timeDrag = false;
      updatebar(e.pageX);
    }
  });
  $(document).on('mousemove', function (e) {
    if (timeDrag) {
      updatebar(e.pageX);
    }
  });
  var updatebar = function (x) {
    var progress = $('.progress');

    //calculate drag position
    //and update video currenttime
    //as well as progress bar
    var maxduration = vid[0].duration;
    var position = x - progress.offset().left;
    var percentage = 100 * position / progress.width();
    if (percentage > 100) {
      percentage = 100;
    }
    if (percentage < 0) {
      percentage = 0;
    }
    $('.timeBar').css('width', percentage + '%');
    vid[0].currentTime = maxduration * percentage / 100;
  };
  //sound button clicked
  $('.sound').click(function () {
    vid[0].muted = !vid[0].muted;
    $(this).toggleClass('muted');
    if (vid[0].muted) {
      $('.volumeBar').css('width', 0);
    } else
    {
      $('.volumeBar').css('width', vid[0].volume * 100 + '%');
    }
  });

  //VOLUME BAR
  //volume bar event
  var volumeDrag = false;
  $('.volume').on('mousedown', function (e) {
    volumeDrag = true;
    vid[0].muted = false;
    $('.sound').removeClass('muted');
    updateVolume(e.pageX);
  });
  $(document).on('mouseup', function (e) {
    if (volumeDrag) {
      volumeDrag = false;
      updateVolume(e.pageX);
    }
  });
  $(document).on('mousemove', function (e) {
    if (volumeDrag) {
      updateVolume(e.pageX);
    }
  });
  var updateVolume = function (x, vol) {
    var volume = $('.volume');
    var percentage;
    //if only volume have specificed
    //then direct update volume
    if (vol) {
      percentage = vol * 100;
    } else
    {
      var position = x - volume.offset().left;
      percentage = 100 * position / volume.width();
    }

    if (percentage > 100) {
      percentage = 100;
    }
    if (percentage < 0) {
      percentage = 0;
    }

    //update volume bar and video volume
    $('.volumeBar').css('width', percentage + '%');
    vid[0].volume = percentage / 100;

    //change sound icon based on volume
    if (vid[0].volume == 0) {
      $('.sound').removeClass('sound2').addClass('muted');
    } else
    if (vid[0].volume > 0.5) {
      $('.sound').removeClass('muted').addClass('sound2');
    } else
    {
      $('.sound').removeClass('muted').removeClass('sound2');
    }

  };

  //speed text clicked
  $('.spdx50').on('click', function () {fastfowrd(this, 1.5);});
  $('.spdx25').on('click', function () {fastfowrd(this, 1.25);});
  $('.spdx1').on('click', function () {fastfowrd(this, 1);});
  $('.spdx050').on('click', function () {fastfowrd(this, 0.5);});
  var fastfowrd = function (obj, spd) {
    $('.speedcnt li').removeClass('selected');
    $(obj).addClass('selected');
    vid[0].playbackRate = spd;
    vid[0].play();
    $("ul.speedcnt").fadeOut("fast");
    $('.btnPlay').addClass('paused');
  };
  $(".btnspeed").click(function () {

    $("ul.speedcnt").slideToggle(100);
  });

  //fullscreen button clicked
  $('.btnFS').on('click', function () {
    if ($.isFunction(vid[0].webkitEnterFullscreen)) {
      vid[0].webkitEnterFullscreen();
    } else
    if ($.isFunction(vid[0].mozRequestFullScreen)) {
      vid[0].mozRequestFullScreen();
    } else
    {
      alert('Your browsers doesn\'t support fullscreen');
    }
  });

  //light bulb button clicked
  $('.btnLight').click(function () {
    $(this).toggleClass('lighton');

    //if lightoff, create an overlay
    if (!$(this).hasClass('lighton')) {
      $('body').append('<div class="overlay"></div>');
      $('.overlay').css({
        'position': 'absolute',
        'width': 100 + '%',
        'height': $(document).height(),
        'background': '#000',
        'opacity': 0.9,
        'top': 0,
        'left': 0,
        'z-index': 999 });

      $('.vidcontainer').css({
        'z-index': 1000 });

    }
    //if lighton, remove overlay
    else {
        $('.overlay').remove();
      }
  });

  //hide pause button if video onplaying
  //if (vid.onplaying = true) { $('.btnPlay').addClass('paused'); };


  //previous video button
  $(".prevvid").click(function () {
    $(vid).attr("src", $(".playing").prev().attr("href"));
    vid[0].play();
    $(".playing").prev().addClass("playing");
    $(".playing:last").removeClass("playing");
    $('.btnPlay').addClass('paused');
    $(".nextvid").removeClass("disabled");
    if ($("a.link:first").hasClass("playing")) {
      $(this).addClass("disabled");
    } else {
      $(this).removeClass("disabled");
    };
  });

  //previous video button
  $(".nextvid").click(function () {
    $(vid).attr("src", $(".playing").next().attr("href"));
    vid[0].play();
    $(".playing").next().addClass("playing");
    $(".playing:first").removeClass("playing");
    $('.btnPlay').addClass('paused');
    $(".prevvid").removeClass("disabled");
    if ($("a.link:last").hasClass("playing")) {
      $(this).addClass("disabled");
    } else {
      $(this).removeClass("disabled");
    };

  });



  //Time format converter - 00:00
  var timeFormat = function (seconds) {
    var m = Math.floor(seconds / 60) < 10 ? "0" + Math.floor(seconds / 60) : Math.floor(seconds / 60);
    var s = Math.floor(seconds - m * 60) < 10 ? "0" + Math.floor(seconds - m * 60) : Math.floor(seconds - m * 60);
    return m + ":" + s;
  };
  $(".closeme , .bigplay").click(function () {
    $("this,.ads,.bigplay").fadeOut(200);
    vid[0].play();
    $('.btnPlay').addClass('paused');
  });
  //end
});
//# sourceURL=pen.js
    </script>

  
</body>

</html>
