<?php
# en_US - this file includes the specific strings for both en_GB/en_US, as well as some multi-language lines
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.75
# Language: American English / English US
# Translator: Ciprian Murariu <ciprianmp@yahoo.com>
# Last file update: 07.01.2016

if(!function_exists('utf_conv'))
{
	function utf_conv($iso,$charset,$what)
	{
		if(function_exists('iconv')) $what = iconv($iso,$charset,$what);
		return $what;
	};
};

$hl = (isset($_REQUEST["hl"])) ? $_REQUEST["hl"] : false;
if(file_exists("lang/calendar.".($hl ? $hl : (defined("L_LANG") ? L_LANG : "")).".php")) include_once("lang/calendar.".($hl ? $hl : (defined("L_LANG") ? L_LANG : "")).".php");
else
{
	if(!defined("L_LANG") || L_LANG == "L_LANG")
	{
		define("L_LANG", "en_US");
		// Set the US specific date/time format
		if (stristr(PHP_OS,"win")) {
		setlocale(LC_TIME, "eng-usa.UTF-8", "eng-usa");
		} else {
		setlocale(LC_TIME, "en_US.UTF-8", "enu.UTF-8", "usa.UTF-8", "enu_enu.UTF-8", "English-usa.UTF-8");
		}
	}
};

// English US format and localization - default strings when the specified translation is not available
if(!defined("RTL")) define("RTL", 0);
if(!defined("L_DAYC")) define("L_DAYC", "Day");
if(!defined("L_MONTHC")) define("L_MONTHC", "Month");
if(!defined("L_YEARC")) define("L_YEARC", "Year");
if(!defined("L_TODAY")) define("L_TODAY", "Today");
if(!defined("L_PREV")) define("L_PREV", "Previous");
if(!defined("L_NEXT")) define("L_NEXT", "Next");
if(!defined("L_REF_CAL")) define("L_REF_CAL", "Refreshing Calendar...");
if(!defined("L_CHK_VAL")) define("L_CHK_VAL", "Check the value");
if(!defined("L_SEL_LANG")) define("L_SEL_LANG", "Select Language");
if(!defined("L_SEL_ICON")) define("L_SEL_ICON", "Select");
if(!defined("L_SEL_DATE")) define("L_SEL_DATE", "Select Date");
if(!defined("L_ERR_SEL")) define("L_ERR_SEL", "Your selection is not valid");
if(!defined("L_NOT_ALLOWED")) define("L_NOT_ALLOWED", "This date is not allowed to be selected");
if(!defined("L_DATE_BEFORE")) define("L_DATE_BEFORE", "Please choose a date before %s");
if(!defined("L_DATE_AFTER")) define("L_DATE_AFTER", "Please choose a date after %s");
if(!defined("L_DATE_BETWEEN")) define("L_DATE_BETWEEN", "Please choose a date between\\n%s and %s");
if(!defined("L_WEEK_HDR")) define("L_WEEK_HDR", "");
if(!defined("L_UNSET")) define("L_UNSET", "Unset");
if(!defined("L_CLOSE")) define("L_CLOSE", "Close");
if(!defined("L_WARN_2038")) define("L_WARN_2038", "This php server’s version does not have support for year 2038 and later! (<5.3.0)");
if(!defined("L_ERR_NOSET")) define("L_ERR_NOSET", "Error! The calendar value cannot be set!");
if(!defined("L_VERSION")) define("L_VERSION", "Version: %s (%s languages)");
if(!defined("L_POWBY")) define("L_POWBY", "Powered by:"); //or "Based on:", "Supported by"
if(!defined("L_HERE")) define("L_HERE", "here");
if(!defined("L_UPDATE")) define("L_UPDATE", "Update available %s !");
if(!defined("L_TRABY") && defined("L_TRANAME")) define("L_TRABY", "Translated by %s");
if(!defined("L_DONATE")) define("L_DONATE", "<bdo dir=\"ltr\">Do you wish to donate?</bdo>");
if(!defined("L_SRV_TIMEZONE")) define("L_SRV_TIMEZONE", "<bdo dir=\"ltr\">Server Timezone:</bdo>"); //3.74
if(!defined("L_MSG_DISABLED")) define("L_MSG_DISABLED", "You cannot choose this date. Date is disabled!"); //3.75

if(!defined("FIRST_DAY")) define("FIRST_DAY", "0"); // 0 for Sunday

// Months Long Names
if(!defined("L_JAN")) define("L_JAN", "January");
if(!defined("L_FEB")) define("L_FEB", "February");
if(!defined("L_MAR")) define("L_MAR", "March");
if(!defined("L_APR")) define("L_APR", "April");
if(!defined("L_MAY")) define("L_MAY", "May");
if(!defined("L_JUN")) define("L_JUN", "June");
if(!defined("L_JUL")) define("L_JUL", "July");
if(!defined("L_AUG")) define("L_AUG", "August");
if(!defined("L_SEP")) define("L_SEP", "September");
if(!defined("L_OCT")) define("L_OCT", "October");
if(!defined("L_NOV")) define("L_NOV", "November");
if(!defined("L_DEC")) define("L_DEC", "December");
// Months Short Names
if(!defined("L_S_JAN")) define("L_S_JAN", "Jan");
if(!defined("L_S_FEB")) define("L_S_FEB", "Feb");
if(!defined("L_S_MAR")) define("L_S_MAR", "Mar");
if(!defined("L_S_APR")) define("L_S_APR", "Apr");
if(!defined("L_S_MAY")) define("L_S_MAY", "May");
if(!defined("L_S_JUN")) define("L_S_JUN", "Jun");
if(!defined("L_S_JUL")) define("L_S_JUL", "Jul");
if(!defined("L_S_AUG")) define("L_S_AUG", "Aug");
if(!defined("L_S_SEP")) define("L_S_SEP", "Sep");
if(!defined("L_S_OCT")) define("L_S_OCT", "Oct");
if(!defined("L_S_NOV")) define("L_S_NOV", "Nov");
if(!defined("L_S_DEC")) define("L_S_DEC", "Dec");
// Week days Long Names
if(!defined("L_MON")) define("L_MON", "Monday");
if(!defined("L_TUE")) define("L_TUE", "Tuesday");
if(!defined("L_WED")) define("L_WED", "Wednesday");
if(!defined("L_THU")) define("L_THU", "Thursday");
if(!defined("L_FRI")) define("L_FRI", "Friday");
if(!defined("L_SAT")) define("L_SAT", "Saturday");
if(!defined("L_SUN")) define("L_SUN", "Sunday");
// Week days Short Names
if(!defined("L_S_MON")) define("L_S_MON", "Mo");
if(!defined("L_S_TUE")) define("L_S_TUE", "Tu");
if(!defined("L_S_WED")) define("L_S_WED", "We");
if(!defined("L_S_THU")) define("L_S_THU", "Th");
if(!defined("L_S_FRI")) define("L_S_FRI", "Fr");
if(!defined("L_S_SAT")) define("L_S_SAT", "Sa");
if(!defined("L_S_SUN")) define("L_S_SUN", "Su");

// Display extra text beside years, months and/or days in dropdowns (eg. Korean and Japan)
if(!defined("L_USE_YMD_DROP")) define("L_USE_YMD_DROP", 0);

// Windows encoding
if(!defined("WIN_DEFAULT")) define("WIN_DEFAULT", "windows-1252");
if(!defined("L_CAL_FORMAT")) define("L_CAL_FORMAT", "%B %d, %Y");
if(!defined("DATE_FORMAT")) define("DATE_FORMAT", str_replace("%d","j",str_replace("B","F",str_replace("%","",L_CAL_FORMAT))));

// Arabic-Indic Digits variant
if(!defined("L_DIGIT")) define("L_DIGIT", 0);
if(!defined("L_UTF_DIGIT")) define("L_UTF_DIGIT", 0);
if(!defined("L_ARABIC")) define("L_ARABIC", "Arabic Digits");

// Localization patches
$pptit = "\n";
switch ($hl)
{
	case "ar_AE":
		$ppalt = "PayPal - أكثر أمانا وأسهل طريقة للدفع عبر الإنترنت!";
		$pptit .= "شكرا لدعمكم!";
		break;
	case "bg_BG":
		$ppalt = "PayPal - Сигурният и лесен начин да платите онлайн!";
		$pptit .= "Благодарим ви за вашата подкрепа!";
		break;
	case "ca_ES":
		$ppalt = "PayPal – La millor manera i la més fàcil de pagar en línia!";
		$pptit .= "Gràcies pel seu suport!";
		break;
	case "cs_CZ":
		$ppalt = "PayPal - bezpečnější, jednodušší způsob, jak zaplatit on-line!";
		$pptit .= "Děkujeme vám za vaši podporu!";
		break;
	case "da_DK":
		$ppalt = "PayPal - Den sikreste og nemmeste måde at overføre penge online!";
		$pptit .= "Tak for din støtte!";
		break;
	case "de_DE":
		$ppalt = "Jetzt einfach, schnell und sicher online bezahlen - mit PayPal!";
		$pptit .= "Vielen Dank für Ihre Unterstützung!";
		break;
	case "el_GR":
		$ppalt = "PayPal – Ο ασφαλέστερος και ευκολότερος τρόπος να πληρώσεις online!";
		$pptit .= "Σας ευχαριστούμε για την υποστήριξή σας!";
		break;
	case "es_AR":
		$ppalt = "PayPal - La forma segura y fácil de pagar en línea!";
		$pptit .= "Gracias por su apoyo!";
		break;
	case "es_ES":
		$ppalt = "PayPal. ¡La forma rápida y segura de pagar en Internet!";
		$pptit .= "Gracias por su apoyo!";
		break;
	case "fa_IR":
		$ppalt = "PayPal - امن تر، راه ساده تر برای پرداخت آنلاین!";
		$pptit .= "با تشکر از شما برای حمایت از شما!";
		break;
	case "fi_FI":
		$ppalt = "PayPal - Turvallisempi, helpompi tapa maksaa verkossa!";
		$pptit .= "Kiitos tuesta!";
		break;
	case "fr_FR":
		$ppalt = "PayPal - Le moyen le plus sûr et facile de payer en ligne!";
		$pptit .= "Merci pour votre soutien!";
		break;
	case "he_IL":
		$ppalt = "פייפאל - הדרך הבטוחה, הקלה לשלם באינטרנט.";
		$pptit .= "דאנק איר פֿאַר דיין שטיצן!";
		break;
	case "hi_IN":
		$ppalt = "PayPal - ऑनलाइन भुगतान करने के लिए सुरक्षित, आसान तरीका!";
		$pptit .= "आपके समर्थन के लिए धन्यवाद!";
		break;
	case "hu_HU":
		$ppalt = "PayPal - Biztonságosabb és egyszerűbb módja az internetes fizetésnek!";
		$pptit .= "Köszönjük a támogatást!";
		break;
	case "hy_AM":
		$ppalt = "PayPal - Ապահով, ավելի հեշտ ճանապարհ է արդյոք վճարել առցանց.";
		$pptit .= "Շնորհակալություն ձեր աջակցության.";
		break;
	case "id_ID":
		$ppalt = "Paypal - Lebih aman dan mudah untuk pembayaran online!";
		$pptit .= "Terima kasih atas dukungannya!";
		break;
	case "it_IT":
		$ppalt = "PayPal - La più sicura, facile strada per pagare online!";
		$pptit .= "Grazie per il vostro supporto!";
		break;
	case "ja_JP":
		$ppalt = "PayPal－オンラインで安全、簡単にお支払い。";
		$pptit .= "ご支援いただきありがとうございます！";
		break;
	case "ko_KR":
		$ppalt = "PayPal－온라인으로 지불하는 것이 안전, 쉬운 방법!";
		$pptit .= "귀하의 지원에 감사드립니다!";
		break;
	case "lt_LT":
		$ppalt = "PayPal - Saugesnis, patogesnis būdas atsiskaityti internete!";
		$pptit .= "Ačiū už Jūsų paramą!";
		break;
	case "mk_MK":
		$ppalt = "PayPal - Побезбедно, полесен начин да платат онлајн!";
		$pptit .= "Ви благодариме за вашата поддршка!";
		break;
	case "ms_MY":
		$ppalt = "PayPal - Lebih selamat, cara yang lebih mudah untuk membayar dalam talian!";
		$pptit .= "Matur nuwun atas sokongan anda!";
		break;
	case "nb_NO":
		$ppalt = "PayPal - Den sikrere, enklere måte å betale på nettet!";
		$pptit .= "Takk for støtten!";
		break;
	case "ne_NP":
		$ppalt = "Paypal - ईन्टनेटबाट पैसा तिर्ने सजिलो र सुरक्षित माध्यम!";
		$pptit .= "आफ्नो समर्थन लागि धन्यवाद!";
		break;
	case "nl_NL":
		$ppalt = "PayPal, de veilige en complete manier van online betalen!";
		$pptit .= "Dank u voor uw steun!";
		break;
	case "pl_PL":
		$ppalt = "PayPal - Bezpieczniejszy, łatwiejszy sposób, aby zapłacić online!";
		$pptit .= "Dziękujemy za wsparcie!";
		break;
	case "pt_BR":
		$ppalt = "PayPal - A maneira mais fácil e segura de efetuar pagamentos on-line!";
		$pptit .= "Obrigado por seu apoio!";
		break;
	case "pt_PT":
		$ppalt = "PayPal - A maneira mais fácil e segura de efetuar pagamentos on-line!";
		$pptit .= "Obrigado por seu apoio!";
		break;
	case "ro_RO":
		$ppalt = "PayPal - Calea cea mai sigură şi facilă de a efectua plăţi online!";
		$pptit .= "Mulţumim anticipat pentru susţinere!";
		break;
	case "ru_RU":
		$ppalt = "PayPal – безопасный и простой способ оплаты в Интернете!";
		$pptit .= "Спасибо за вашу поддержку!";
		break;
	case "sk_SK":
		$ppalt = "PayPal - Bezpečnejší, jednoduchší spôsob, ako zaplatiť on-line!";
		$pptit .= "Ďakujeme vám za vašu podporu!";
		break;
	case "sr_CS":
		$ppalt = "PayPal - Bezbedniji i lakši način za on-line plaćanje!";
		$pptit .= "Hvala vam na podršci!";
		break;
	case "sv_SE":
		$ppalt = "PayPal - Det säkra, enkla sättet att betala online!";
		$pptit .= "Tack för ditt stöd!";
		break;
	case "th_TH":
		$ppalt = "PayPal - ปลอดภัยวิธีที่ง่ายต่อการชำระเงินออนไลน์!";
		$pptit .= "ขอขอบคุณสำหรับการสนับสนุนของคุณ!";
		break;
	case "tr_TR":
		$ppalt = "PayPal - çevrimiçi ödeme yapmanın en kolay ve güvenli yolu!";
		$pptit .= "Desteğiniz için teşekkür ederiz!";
		break;
	case "uk_UA":
		$ppalt = "PayPal - безпечний і простий спосіб для оплати в інтернеті!";
		$pptit .= "Спасибі за вашу підтримку!";
		break;
	case "uz_UZ":
		$ppalt = "PayPal - Eng xavfsiz, online to`lovning eng oson yo`li!";
		$pptit .= "Yordamingiz uchun rahmat!";
		break;
	case "vi_VN":
		$ppalt = "PayPal - Cách an toàn hơn, dễ dàng hơn để thanh toán trực tuyến!";
		$pptit .= "Cảm ơn bạn đã hỗ trợ của bạn!";
		break;
	case "zh_CN":
		$ppalt = "PayPal － 最安全便捷的在线支付方式！";
		$pptit .= "谢谢您的支持！";
		break;
	case "zh_TW":
		$ppalt = "PayPal － 更安全、更簡單的網上付款方式！";
		$pptit .= "謝謝您的支持！";
		break;
	default:
		$ppalt = "PayPal - The safer, easier way to pay online!";
		$pptit .= "Thank you for your support!";
		break;
};
?>
<script type="text/javascript">
<!--
//	JS strings
	var l_lang = "<?php echo($hl ? $hl : (defined("L_LANG") ? L_LANG : "")); ?>";
	var l_sel_date = "<?php echo(L_SEL_DATE); ?>";
	var l_not_allowed = "<?php echo(L_NOT_ALLOWED); ?>";
	var l_date_before = "<?php echo(L_DATE_BEFORE); ?>";
	var l_date_after = "<?php echo(L_DATE_AFTER); ?>";
	var l_date_between = "<?php echo(L_DATE_BETWEEN); ?>";
	var l_err_noset = "<?php echo(L_ERR_NOSET); ?>";
	var l_msg_disabled = "<?php echo(L_MSG_DISABLED); ?>";
	var l_use_ymd_drop = "<?php echo(L_USE_YMD_DROP); ?>";
	var l_day = "<?php echo(L_DAYC); ?>";
	var l_month = "<?php echo(L_MONTHC); ?>";
	var l_year = "<?php echo(L_YEARC); ?>";
	var l_ref_cal = "<?php echo(L_REF_CAL); ?>";
	//Digitizer
	var l_arabic = "<?php echo(L_ARABIC); ?>";
<?php
if(defined("L_INDIC") && L_INDIC != "L_INDIC"){
?>
	var l_indic = "<?php echo(L_INDIC); ?>";
<?php
}
?>
	var l_utf_digit = <?php echo(L_UTF_DIGIT); ?>;
//	Long Month Names
	var l_january = "<?php echo(defined('L_JAN') ? L_JAN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1199145600')) : strftime('%B','1199145600'))); ?>";
	var l_february = "<?php echo(defined('L_FEB') ? L_FEB : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1201824000')) : strftime('%B','1201824000'))); ?>";
	var l_march = "<?php echo(defined('L_MAR') ? L_MAR : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1204329600')) : strftime('%B','1204329600'))); ?>";
	var l_april = "<?php echo(defined('L_APR') ? L_APR : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1207008000')) : strftime('%B','1207008000'))); ?>";
	var l_may = "<?php echo(defined('L_MAY') ? L_MAY : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1209600000')) : strftime('%B','1209600000'))); ?>";
	var l_june = "<?php echo(defined('L_JUN') ? L_JUN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1212278400')) : strftime('%B','1212278400'))); ?>";
	var l_july = "<?php echo(defined('L_JUL') ? L_JUL : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1214870400')) : strftime('%B','1214870400'))); ?>";
	var l_august = "<?php echo(defined('L_AUG') ? L_AUG : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1217548800')) : strftime('%B','1217548800'))); ?>";
	var l_september = "<?php echo(defined('L_SEP') ? L_SEP : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1220227200')) : strftime('%B','1220227200'))); ?>";
	var l_october = "<?php echo(defined('L_OCT') ? L_OCT : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1222819200')) : strftime('%B','1220227200'))); ?>";
	var l_november = "<?php echo(defined('L_NOV') ? L_NOV : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1225497600')) : strftime('%B','1225497600'))); ?>";
	var l_december = "<?php echo(defined('L_DEC') ? L_DEC : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%B','1228089600')) : strftime('%B','1228089600'))); ?>";
<?php
//	Date Month Names in genitive format
if(defined("L_JANG") && L_JANG != "L_JANG")
{
?>
	var l_genitive = 1;
	var l_januaryg = "<?php echo(defined('L_JANG') ? L_JANG : ""); ?>";
	var l_februaryg = "<?php echo(defined('L_FEBG') ? L_FEBG : ""); ?>";
	var l_marchg = "<?php echo(defined('L_MARG') ? L_MARG : ""); ?>";
	var l_aprilg = "<?php echo(defined('L_APRG') ? L_APRG : ""); ?>";
	var l_mayg = "<?php echo(defined('L_MAYG') ? L_MAYG : ""); ?>";
	var l_juneg = "<?php echo(defined('L_JUNG') ? L_JUNG : ""); ?>";
	var l_julyg = "<?php echo(defined('L_JULG') ? L_JULG : ""); ?>";
	var l_augustg = "<?php echo(defined('L_AUGG') ? L_AUGG : ""); ?>";
	var l_septemberg = "<?php echo(defined('L_SEPG') ? L_SEPG : ""); ?>";
	var l_octoberg = "<?php echo(defined('L_OCTG') ? L_OCTG : ""); ?>";
	var l_novemberg = "<?php echo(defined('L_NOVG') ? L_NOVG : ""); ?>";
	var l_decemberg = "<?php echo(defined('L_DECG') ? L_DECG : ""); ?>";
<?php
}
else{
?>
	var l_genitive = 0;
<?php
}
?>
//	Short Month Names
	var s_jan = "<?php echo(defined('L_S_JAN') ? L_S_JAN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1199145600')) : strftime('%b','1199145600'))); ?>";
	var s_feb = "<?php echo(defined('L_S_FEB') ? L_S_FEB : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1201824000')) : strftime('%b','1201824000'))); ?>";
	var s_mar = "<?php echo(defined('L_S_MAR') ? L_S_MAR : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1204329600')) : strftime('%b','1204329600'))); ?>";
	var s_apr = "<?php echo(defined('L_S_APR') ? L_S_APR : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1207008000')) : strftime('%b','1207008000'))); ?>";
	var s_may = "<?php echo(defined('L_S_MAY') ? L_S_MAY : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1209600000')) : strftime('%b','1209600000'))); ?>";
	var s_jun = "<?php echo(defined('L_S_JUN') ? L_S_JUN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1212278400')) : strftime('%b','1212278400'))); ?>";
	var s_jul = "<?php echo(defined('L_S_JUL') ? L_S_JUL : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1214870400')) : strftime('%b','1214870400'))); ?>";
	var s_aug = "<?php echo(defined('L_S_AUG') ? L_S_AUG : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1217548800')) : strftime('%b','1217548800'))); ?>";
	var s_sep = "<?php echo(defined('L_S_SEP') ? L_S_SEP : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1220227200')) : strftime('%b','1220227200'))); ?>";
	var s_oct = "<?php echo(defined('L_S_OCT') ? L_S_OCT : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1222819200')) : strftime('%b','1222819200'))); ?>";
	var s_nov = "<?php echo(defined('L_S_NOV') ? L_S_NOV : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1225497600')) : strftime('%b','1225497600'))); ?>";
	var s_dec = "<?php echo(defined('L_S_DEC') ? L_S_DEC : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%b','1228089600')) : strftime('%b','1228089600'))); ?>";
//	Long Day Names
	var l_monday = "<?php echo(defined('L_MON') ? L_MON : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270425600')) : strftime('%A','1270425600'))); ?>";
	var l_tuesday = "<?php echo(defined('L_TUE') ? L_TUE : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270512000')) : strftime('%A','1270512000'))); ?>";
	var l_wednesday = "<?php echo(defined('L_WED') ? L_WED : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270598400')) : strftime('%A','1270598400'))); ?>";
	var l_thursday = "<?php echo(defined('L_THU') ? L_THU : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270684800')) : strftime('%A','1270684800'))); ?>";
	var l_friday = "<?php echo(defined('L_FRI') ? L_FRI : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270771200')) : strftime('%A','1270771200'))); ?>";
	var l_saturday = "<?php echo(defined('L_SAT') ? L_SAT : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270857600')) : strftime('%A','1270857600'))); ?>";
	var l_sunday = "<?php echo(defined('L_SUN') ? L_SUN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%A','1270944000')) : strftime('%A','1270944000'))); ?>";
//	Short Day Names
	var s_mon = "<?php echo(defined('L_S_MON') ? L_S_MON : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270425600')) : strftime('%a','1270425600'))); ?>";
	var s_tue = "<?php echo(defined('L_S_TUE') ? L_S_TUE : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270512000')) : strftime('%a','1270512000'))); ?>";
	var s_wed = "<?php echo(defined('L_S_WED') ? L_S_WED : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270598400')) : strftime('%a','1270598400'))); ?>";
	var s_thu = "<?php echo(defined('L_S_THU') ? L_S_THU : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270684800')) : strftime('%a','1270684800'))); ?>";
	var s_fri = "<?php echo(defined('L_S_FRI') ? L_S_FRI : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270771200')) : strftime('%a','1270771200'))); ?>";
	var s_sat = "<?php echo(defined('L_S_SAT') ? L_S_SAT : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270857600')) : strftime('%a','1270857600'))); ?>";
	var s_sun = "<?php echo(defined('L_S_SUN') ? L_S_SUN : (stristr(PHP_OS,'win') ? utf_conv(WIN_DEFAULT,'utf-8',strftime('%a','1270944000')) : strftime('%a','1270944000'))); ?>";
// -->
</script>
<?php
?>