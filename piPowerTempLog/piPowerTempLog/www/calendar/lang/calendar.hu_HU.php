<?php
# hu_HU translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Hungarian / magyar
# Translator: Jácint Zsuzsanna <jacint.zsuzsanna@yahoo.com>
# Last file update: 29.07.2013

// Class strings localization
define("L_DAYC", "Nap");
define("L_MONTHC", "Hónap");
define("L_YEARC", "Év");
define("L_TODAY", "Ma");
define("L_PREV", "Előző");
define("L_NEXT", "Következő");
define("L_REF_CAL", "Naptár frissítése...");
define("L_CHK_VAL", "Ellenőrizd az értéket");
define("L_SEL_LANG", "Válassz nyelvet");
define("L_SEL_ICON", "Kiválaszt");
define("L_SEL_DATE", "Válassz dátumot");
define("L_ERR_SEL", "A választásod nem érvényes");
define("L_NOT_ALLOWED", "Ezt a dátumot nem lehet kiválasztani");
define("L_DATE_BEFORE", "Kérjük, válasszon egy dátumot előtt %s");
define("L_DATE_AFTER", "Kérjük, válasszon egy dátumot követően %s");
define("L_DATE_BETWEEN", "Kérjük, válasszon egy dátumot közötti\\n%s és %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Mégse");
define("L_CLOSE", "Bezár");
define("L_WARN_2038", "A php szerver ezen verziója nem támogatja a 2038-as illetve az ezt követő éveket! (<5.3.0)");
define("L_ERR_NOSET", "Hiba! A naptári értéket nem lehet beállítani!");
define("L_VERSION", "Verzió: %s (%s nyelvek)");
define("L_POWBY", "Üzemelteti:"); //or "Based on:", "Supported by"
define("L_HERE", "itt");
define("L_UPDATE", "Frissítés %s elérhető.");
define("L_TRANAME", "Jácint Zsuzsanna");
define("L_TRABY", "Fordította %s");
define("L_DONATE", "Szeretnél adományozni?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "január");
define("L_FEB", "február");
define("L_MAR", "március");
define("L_APR", "április");
define("L_MAY", "május");
define("L_JUN", "június");
define("L_JUL", "július");
define("L_AUG", "augusztus");
define("L_SEP", "szeptember");
define("L_OCT", "október");
define("L_NOV", "november");
define("L_DEC", "december");
// Months Short Names
define("L_S_JAN", "jan.");
define("L_S_FEB", "febr.");
define("L_S_MAR", "márc.");
define("L_S_APR", "ápr.");
define("L_S_MAY", "máj.");
define("L_S_JUN", "jún.");
define("L_S_JUL", "júl.");
define("L_S_AUG", "aug.");
define("L_S_SEP", "szept.");
define("L_S_OCT", "okt.");
define("L_S_NOV", "nov.");
define("L_S_DEC", "dec.");
// Week days Long Names
define("L_MON", "hétfő");
define("L_TUE", "kedd");
define("L_WED", "szerda");
define("L_THU", "csütörtök");
define("L_FRI", "péntek");
define("L_SAT", "szombat");
define("L_SUN", "vasárnap");
// Week days Short Names
define("L_S_MON", "H");
define("L_S_TUE", "K");
define("L_S_WED", "Sze");
define("L_S_THU", "Cs");
define("L_S_FRI", "P");
define("L_S_SAT", "Szo");
define("L_S_SUN", "V");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%Y. %B %d.");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "hu_HU");

// Set the HU specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "hun_hun.UTF-8", "hungarian.UTF-8", "hungarian");
} else {
setlocale(LC_TIME, "hu_HU.UTF-8", "hu_HU.UTF-8@euro", "hun_hun.UTF-8", "hungarian.UTF-8", "hun.UTF-8", "hu.UTF-8"); // For HU formats
}
?>