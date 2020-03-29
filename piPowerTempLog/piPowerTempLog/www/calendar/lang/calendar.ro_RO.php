<?php
# ro_RO translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.75
# Language: Romanian / Română
# Translator: Ciprian Murariu <ciprianmp@yahoo.com>
# Last file update: 07.01.2016

// Class strings localization
define("L_DAYC", "Ziua");
define("L_MONTHC", "Luna");
define("L_YEARC", "Anul");
define("L_TODAY", "Azi");
define("L_PREV", "Înapoi");
define("L_NEXT", "Înainte");
define("L_CHK_VAL", "Verificaţi valoarea");
define("L_SEL_LANG", "Alegeţi limba");
define("L_SEL_ICON", "Selectaţi");
define("L_SEL_DATE", "Alegeţi data");
define("L_REF_CAL", "Calendarul se reiniţializează...");
define("L_ERR_SEL", "Data selectată nu este validă!");
define("L_NOT_ALLOWED", "Nu este permisă selectarea acestei date!");
define("L_DATE_BEFORE", "Selectaţi o dată înainte de %s!");
define("L_DATE_AFTER", "Selectaţi o dată după %s!");
define("L_DATE_BETWEEN", "Selectaţi o dată între\\n%s şi %s!");
define("L_WEEK_HDR", "S"); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Anulare");
define("L_CLOSE", "Închidere");
define("L_WARN_2038", "Versiunea serverului php nu suportă ani mai mari decât 2038! (<5.3.0)");
define("L_ERR_NOSET", "Eroare! Valoarea calendarului nu poate fi setată!");
define("L_VERSION", "Versiunea: %s (%s de limbi)");
define("L_POWBY", "Bazat pe:");
define("L_HERE", "aici");
define("L_UPDATE", "Update disponibil %s !");
define("L_TRANAME", "Ciprian");
define("L_TRABY", "Tradus de %s");
define("L_DONATE", "Vreţi să donaţi?");
define("L_SRV_TIMEZONE", "Fusul orar al serverului:"); //3.74
define("L_MSG_DISABLED", "Nu puteți alege această dată. Data este dezactivată!"); //3.75

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "ianuarie");
define("L_FEB", "februarie");
define("L_MAR", "martie");
define("L_APR", "aprilie");
define("L_MAY", "mai");
define("L_JUN", "iunie");
define("L_JUL", "iulie");
define("L_AUG", "august");
define("L_SEP", "septembrie");
define("L_OCT", "octombrie");
define("L_NOV", "noiembrie");
define("L_DEC", "decembrie");
// Months Short Names
define("L_S_JAN", "ian");
define("L_S_FEB", "febr");
define("L_S_MAR", "mart");
define("L_S_APR", "apr");
define("L_S_MAY", "mai");
define("L_S_JUN", "iun");
define("L_S_JUL", "iul");
define("L_S_AUG", "aug");
define("L_S_SEP", "sept");
define("L_S_OCT", "oct");
define("L_S_NOV", "nov");
define("L_S_DEC", "dec");
// Week days Long Names
define("L_MON", "luni");
define("L_TUE", "marţi");
define("L_WED", "miercuri");
define("L_THU", "joi");
define("L_FRI", "vineri");
define("L_SAT", "sâmbătă");
define("L_SUN", "duminică");
// Week days Short Names
define("L_S_MON", "l");
define("L_S_TUE", "ma");
define("L_S_WED", "mi");
define("L_S_THU", "j");
define("L_S_FRI", "v");
define("L_S_SAT", "s");
define("L_S_SUN", "d");

// Windows encoding
define("WIN_DEFAULT", "windows-1250");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "ro_RO");

// Set the RO specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "ROU_ROU.UTF-8", "ROU_ROU", "romanian.UTF-8", "romanian"); // For Windows servers
} else {
setlocale(LC_TIME, "ro_RO.UTF-8@euro", "ro_RO.UTF-8", "rou.UTF-8", "rou_rou.UTF-8"); // For Unix/FreeBSD servers
}
?>