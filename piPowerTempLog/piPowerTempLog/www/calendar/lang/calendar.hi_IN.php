<?php
# hi_IN translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Hindi (Devanagari) / हिन्दी (in your lang)
# Translator: Sanjay Sarita Ghoriwala 'SanSar' <ghoriwala@gmail.com>
# Last file update: 10.08.2013

// Class strings localization
define("L_DAYC", "दिन");
define("L_MONTHC", "माह");
define("L_YEARC", "वर्ष");
define("L_TODAY", "आज");
define("L_PREV", "पिछला");
define("L_NEXT", "अगला");
define("L_REF_CAL", "ताजा तिथिपत्र ...");
define("L_CHK_VAL", "मूल्य की जाँच करें");
define("L_SEL_LANG", "भाषा चुनें");
define("L_SEL_ICON", "चयन करे");
define("L_SEL_DATE", "दिनांक चुनें");
define("L_ERR_SEL", "आपका चयन वैध नहीं है");
define("L_NOT_ALLOWED", "यह दिनांक चयन करने की अनुमति नहीं है");
define("L_DATE_BEFORE", "कृपया %s से पहले की एक दिनांक का चयन करें");
define("L_DATE_AFTER", "कृपया %s के बाद की एक दिनांक का चयन करें");
define("L_DATE_BETWEEN", "कृपया %s और %s\\nके बीच किसी दिनांक का चयन करें");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "साफ कर");
define("L_CLOSE", "बंद करे");
define("L_WARN_2038", "इस PHP सर्वर के संस्करण (<5.3.0) में वर्ष 2038 और बाद के वर्षों का समर्थन नहीं है ");
define("L_ERR_NOSET", "त्रुटि! तिथिपत्र परिमाण तय नहीं हो सका");
define("L_VERSION", "संस्करण: %s (%s भाषाएँ)");
define("L_POWBY", "ऊर्जायुक्त:");
define("L_HERE", "यहाँ");
define("L_UPDATE", "नवीन संस्करण उपलब्ध है %s !");
define("L_TRANAME", "संजय घोडिवाला<br />(Sanjay Ghoriwala)");
define("L_TRABY", "अनुवाद %s");
define("L_DONATE", "क्या आप दान देना चाहते है?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "0");

// Months Long Names
define("L_JAN", "जनवरी");
define("L_FEB", "फरवरी");
define("L_MAR", "मार्च");
define("L_APR", "अप्रैल");
define("L_MAY", "मई");
define("L_JUN", "जून");
define("L_JUL", "जुलाई");
define("L_AUG", "अगस्त");
define("L_SEP", "सितम्बर");
define("L_OCT", "अक्टूबर");
define("L_NOV", "नवम्बर");
define("L_DEC", "दिसम्बर");
// Months Short Names
define("L_S_JAN", "जन");
define("L_S_FEB", "फर");
define("L_S_MAR", "मार्च");
define("L_S_APR", "अप्रैल");
define("L_S_MAY", "मई");
define("L_S_JUN", "जून");
define("L_S_JUL", "जुल");
define("L_S_AUG", "अग");
define("L_S_SEP", "सित");
define("L_S_OCT", "अक्टू");
define("L_S_NOV", "नव");
define("L_S_DEC", "दिस");
// Week days Long Names
define("L_MON", "सोमवार");
define("L_TUE", "मंगलवार");
define("L_WED", "बुधवार");
define("L_THU", "गुरुवार");
define("L_FRI", "शुक्रवार");
define("L_SAT", "शनिवार");
define("L_SUN", "रविवार");
// Week days Short Names
define("L_S_MON", "सोम");
define("L_S_TUE", "मंगल");
define("L_S_WED", "बुध");
define("L_S_THU", "गुरु");
define("L_S_FRI", "शुक्र");
define("L_S_SAT", "शनि");
define("L_S_SUN", "रवि");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "hi_IN"); // en_US format of your language

// Set the HI specific date/time format:
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "hi_IN.UTF-8", "hin-hin.UTF-8", "hin", "Hindi.UTF-8", "Hindi");
} else {
setlocale(LC_TIME, "hi_IN.UTF-8", "hin.UTF-8", "ind.UTF-8", "Hindi.UTF-8");
}

// Hindi-Arabic Digits variant
define("L_ARABIC_DIGIT", "०, १, २, ३, ४, ५, ६, ७, ८, ९");
define("L_DIGIT", 1); //Show Hindi by default
define("L_UTF_DIGIT", 2358); //DEVANAGARI
define("L_ARABIC", "Hinglish");
define("L_INDIC", "हिन्दी");
?>