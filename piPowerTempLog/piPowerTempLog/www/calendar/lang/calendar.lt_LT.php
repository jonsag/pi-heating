<?php
# lt_LT translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.74
# Language: Lithuanian / lietuvių
# Translator: Martynas Vanagas <martynas.vanagas@gmail.com>
# Last file update: 04.06.2015

// Class strings localization
define("L_DAYC", "diena");
define("L_MONTHC", "mėnuo");
define("L_YEARC", "metai");
define("L_TODAY", "šiandien");
define("L_PREV", "ankstesnis");
define("L_NEXT", "kitas");
define("L_REF_CAL", "Atnaujinamas kalendorius...");
define("L_CHK_VAL", "Patikrinkite reikšmę");
define("L_SEL_LANG", "Pasirinkite kalbą");
define("L_SEL_ICON", "Pasirinkite"); #3.69
define("L_SEL_DATE", "Pasirinkite datą");
define("L_ERR_SEL", "Jūsų pasirinkimas yra neteisingas");
define("L_NOT_ALLOWED", "Negalima pasirinkti šios datos");
define("L_DATE_BEFORE", "Pasirinkite datą prieš %s");
define("L_DATE_AFTER", "Pasirinkite datą po %s");
define("L_DATE_BETWEEN", "Pasirinkite datą tarp\\n%s ir %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Atžymėti");
define("L_CLOSE", "Uždaryti"); #3.69
define("L_WARN_2038", "Ši php serverio versija nepalaiko 2038 ir vėlesnių metų! (<5.3.0)"); #3.69
define("L_ERR_NOSET", "Klaida! Kalendoriaus reikšmė negali būti nustatyta!"); #3.70
define("L_VERSION", "Versija: %s (%s kalbos)"); #3.70
define("L_POWBY", "Sukurta:"); //or "Based on:", "Supported by" #3.70
define("L_HERE", "čia"); #3.70
define("L_UPDATE", "Pasiekiamas atnaujinimas %s !"); #3.70
define("L_TRANAME", "Martynas Vanagas"); //Keep a short name #3.70
define("L_TRABY", "Išverstė %s"); #3.70
define("L_DONATE", "Ar norėtumėte paaukoti?"); #3.70
define("L_SRV_TIMEZONE", "Serverio laiko juosta:"); //3.74

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "sausis");
define("L_FEB", "vasaris");
define("L_MAR", "kovas");
define("L_APR", "balandis");
define("L_MAY", "gegužė");
define("L_JUN", "birželis");
define("L_JUL", "liepa");
define("L_AUG", "rugpjūtis");
define("L_SEP", "rugsėjis");
define("L_OCT", "spalis");
define("L_NOV", "lapkritis");
define("L_DEC", "gruodis");
# Dates - genitive #3.69
define("L_JANG", "sausio mėn.");
define("L_FEBG", "vasario mėn.");
define("L_MARG", "kovo mėn.");
define("L_APRG", "balandžio mėn.");
define("L_MAYG", "gegužės mėn.");
define("L_JUNG", "birželio mėn.");
define("L_JULG", "liepos mėn.");
define("L_AUGG", "rugpjūčio mėn.");
define("L_SEPG", "rugsėjo mėn.");
define("L_OCTG", "spalio mėn.");
define("L_NOVG", "lapkričio mėn.");
define("L_DECG", "gruodžio mėn.");
// Months Short Names
define("L_S_JAN", "Sau");
define("L_S_FEB", "Vas");
define("L_S_MAR", "Kov");
define("L_S_APR", "Bal");
define("L_S_MAY", "Geg");
define("L_S_JUN", "Bir");
define("L_S_JUL", "Lie");
define("L_S_AUG", "Rgp");
define("L_S_SEP", "Rgs");
define("L_S_OCT", "Spl");
define("L_S_NOV", "Lap");
define("L_S_DEC", "Grd");
// Week days Long Names
define("L_MON", "pirmadienis");
define("L_TUE", "antradienis");
define("L_WED", "trečiadienis");
define("L_THU", "ketvirtadienis");
define("L_FRI", "penktadienis");
define("L_SAT", "šeštadienis");
define("L_SUN", "sekmadienis");
// Week days Short Names
define("L_S_MON", "Pr");
define("L_S_TUE", "An");
define("L_S_WED", "Tr");
define("L_S_THU", "Kt");
define("L_S_FRI", "Pn");
define("L_S_SAT", "Št");
define("L_S_SUN", "Sk");

// Windows encoding
define("WIN_DEFAULT", "windows-1257");
define("L_CAL_FORMAT", "%Y \m. %B %d \d.");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "lt_LT"); // en_US format code of your language

// Set the LT specific date/time format; ENGLISH EXAMPLE:
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "lt-LT.UTF-8", "lt-LT", "Lithuanian");
} else {
setlocale(LC_TIME, "lt_LT.UTF-8");
}
?>