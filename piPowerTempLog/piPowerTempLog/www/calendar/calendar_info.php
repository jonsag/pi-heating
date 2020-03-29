<?php
require_once("tc_calendar.php");
require_once("classes/tc_date.php");

if(!isset($show_fb_info)) $show_fb_info = true;
if(!isset($show_servertime_info)) $show_servertime_info = true;

$tobj = new tc_calendar("");
$version = $tobj->version;
$check_version = $tobj->check_new_version;

$tdate = new tc_date();

if(!isset($timezone)) $timezone = date_default_timezone_get();

$wan_enabled = 0;
$new_version = 0;
if($wan_enabled = @fsockopen("www.ciprianmp.com", 80, $errno, $errstr, 1)){
	if($check_version && $wan_enabled){
		if(function_exists("file_get_contents")){
			$new_version = @file_get_contents("http://www.ciprianmp.com/scripts/calendar/tc_calendar_version.php?v=".$version);
		}
	}
}
elseif(function_exists("file_get_contents")){
	$ctx = stream_context_create(array('http' => array('timeout' => 1)));
	$wan_enabled = @file_get_contents("http://www.ciprianmp.com",null,$ctx,0,1);
	if($check_version && $wan_enabled){
		if(function_exists("file_get_contents")){
			$new_version = @file_get_contents("http://www.ciprianmp.com/scripts/calendar/tc_calendar_version.php?v=".$version);
		}
	}
}
$donation_url = (($rtl && L_DONATE != "Do you wish to donate?") ? "" : ($rtl ? '<bdo dir="ltr">' : "")).'<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=BX3RZAYPUMA28&lc='.$hl.'&item_name=Appreciate%20%26%20Support%20the%20Localized%20Calendar%20Class%20development&item_number=LCalClass%20about&no_note=0&cn=Your%20comments%20%28optional%29&no_shipping=1&rm=1&return=http%3a%2f%2fciprianmp%2ecom%2fscripts%2fcalendar&cancel_return=http%3a%2f%2fciprianmp%2ecom%2fscripts%2fcalendar&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted&page_style=LCalCLass" target="_blank" alt="'.$ppalt.$pptit.'" title="'.$ppalt.$pptit.'">'.L_DONATE.'</a></bdo>';
define("L_ABOUT_LOC", "<b>Localized Datepicker</b><br />".sprintf(L_VERSION, "<b>".strval($version)."</b>", "<b>$LANGS_NUM</b>").($new_version ? "<br /><b><font color=\"red\">".sprintf(L_UPDATE, "<a href=\"$WEB_LOC\" target=\"_blank\">".L_HERE."</a>")."</font></b>" : "").(defined("L_TRABY") && L_TRABY != "L_TRABY" ? "<br />".sprintf(L_TRABY, "<b>".L_TRANAME."</b>") : "")."<br /><bdo dir=\"ltr\">&copy;2010-".$cdate->getDate("Y")." <b><a href=\"$WEB_LOC\" target=\"_blank\" title=\"http://ciprianmp.com\">$AUTHOR_LOC</a></b></bdo>".($wan_enabled && $show_fb_info ? "<br /><div id=\"fb-like\" class=\"fb-like\" data-href=\"https://www.facebook.com/DatePicker\" data-send=\"false\" data-layout=\"button_count\" data-show-faces=\"false\" data-font=\"tahoma\" ref=\"loc_about_info\"></div><br />".$donation_url : ($wan_enabled ? "<br />".$donation_url : ""))."<hr /><i>".L_POWBY."<br /><b>PHP Datepicker Calendar</b><br /><bdo dir=\"ltr\">&copy;2006-".$cdate->getDate("Y")." <b><a href=\"$WEB_SUPPORT\" target=\"_blank\" title=\"http://triconsole.com\">$AUTHOR</a></b></bdo></i><br />".($show_servertime_info ? "<hr />".L_SRV_TIMEZONE.($timezone ? "<br />$timezone" : "")."<br /><span id=\"timecontainer\">".$cdate->getDate("Y-m-d H:i:s")."</span>" : ""));

?>
<link href="calendar_info.css" rel="stylesheet" type="text/css" />
<?php if($wan_enabled && $show_fb_info){ ?>
	<div id="fb-root"></div>
	<script>
		window.fbAsyncInit = function(){
			FB.init({
				appId: '674148172599839',
				xfbml: true
			});
		};
		(function() {
			var e = document.createElement('script'); e.async = true;
			e.src = document.location.protocol +
				'//connect.facebook.net/<?php echo(str_replace("sr_CS","sr_RS",str_replace("es_AR","es_ES",str_replace("ar_AE","ar_AR",L_LANG)))); ?>/all.js';
			document.getElementById('fb-root').appendChild(e);
		}());
	</script>
<?php } ?>
<div style="float: <?php echo($rtl ? "right" : "left"); ?>;" id="info">
	<img src="images/<?php echo($new_version ? "version_info.gif" : "about.png"); ?>" width="9" height="9" border="0" id="info_icon" />
	<div id="about" dir="<?php echo(($rtl && L_HERE != "here") ? "rtl" : "ltr"); ?>" style="<?php echo($rtl ? "right: 0px;".(L_HERE != "here" ? " direction: rtl; unicode-bidi: embed;" : "") : "left: 0px;"); ?>"><?php echo($dig ? $cobj->digitize_arabics(L_ABOUT_LOC) : L_ABOUT_LOC); ?></div>
	<script type="text/javascript" src="calendar_servertime.js"></script>
	<script type="text/javascript">
		new showLocalTime("timecontainer", "server-php", 0, "long", l_lang.replace("_","-"))
	</script>
	<script type="text/javascript">
	<!--
	var timeoutID = new Array();

	var obj = document.getElementById("info_icon");
	obj.onmouseover = function(){ displayAbout(); }
	obj.onmouseout = function(){ hideAbout(); }

	var obj = document.getElementById("about");
	obj.onmouseover = function(){ displayAbout(true); }
	obj.onmouseout = function(){ hideAbout(); }

	function displayAbout(flag){
		var obj = document.getElementById("about");

		var this_height = obj.style.height;

		if(typeof(flag) == "undefined" || (flag === true && (this_height != "1px" && this_height != ""))){
			cancelTimer();

			//obj.style.display = "block";
			obj.style.height = "auto";
			obj.style.border = "1px solid #191970";
			obj.style.backgroundColor = "#F8F8FF";
		}
	}
	function hideAbout(){
		var obj = document.getElementById("about");

		this.timeoutID[this.timeoutID.length] = window.setTimeout(function(){
			obj.style.border = "none";
			//obj.style.display = "none";
			obj.style.height = "1px";
			obj.style.backgroundColor = "";
			}
			, 500);
	}
	function cancelTimer(){
		for(i=0; i<this.timeoutID.length; i++){
			var timers = this.timeoutID[i];
			clearTimeout(timers);
		}
		this.timeoutID = new Array();
	}
	//-->
	</script>
</div>