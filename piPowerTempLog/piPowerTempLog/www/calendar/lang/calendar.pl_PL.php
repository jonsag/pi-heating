<?php
# pl_PL translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.69
# Language: Polish / polska
# Translator: Adam Królikowski <goldunube@gmail.com>
# Last file update: 19.05.2013

// Class strings localization
define("L_DAYC", "Dzień");
define("L_MONTHC", "Miesiąc");
define("L_YEARC", "Rok");
define("L_TODAY", "Dzisiaj");
define("L_PREV", "Poprzedni");
define("L_NEXT", "Następny");
define("L_REF_CAL", "Odśwież Kalendarz...");
define("L_CHK_VAL", "Sprawdź wartość");
define("L_SEL_LANG", "Wybierz język");
define("L_SEL_ICON", "Wybierać");
define("L_SEL_DATE", "Wybierz Datę");
define("L_ERR_SEL", "Twój wybór jest niepoprawny");
define("L_NOT_ALLOWED", "Ta dana nie może zostać wybrana");
define("L_DATE_BEFORE", "Wybierz datę przed %s");
define("L_DATE_AFTER", "Wybierz datę po %s");
define("L_DATE_BETWEEN", "Wybierz datę między\\n%s a %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Anulować");
define("L_CLOSE", "Zamknąć");
define("L_TRANAME", "Adam Królikowski");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "styczeń");
define("L_FEB", "luty");
define("L_MAR", "marzec");
define("L_APR", "kwiecień");
define("L_MAY", "maj");
define("L_JUN", "czerwiec");
define("L_JUL", "lipiec");
define("L_AUG", "sierpień");
define("L_SEP", "wrzesień");
define("L_OCT", "październik");
define("L_NOV", "listopad");
define("L_DEC", "grudzień");
# Dates - genitive
define("L_JANG", "stycznia");
define("L_FEBG", "lutego");
define("L_MARG", "marca");
define("L_APRG", "kwietnia");
define("L_MAYG", "maja");
define("L_JUNG", "czerwca");
define("L_JULG", "lipca");
define("L_AUGG", "sierpnia");
define("L_SEPG", "września");
define("L_OCTG", "października");
define("L_NOVG", "listopada");
define("L_DECG", "grudnia");
// Months Short Names
define("L_S_JAN", "st");
define("L_S_FEB", "lu");
define("L_S_MAR", "mar");
define("L_S_APR", "kwi");
define("L_S_MAY", "maj");
define("L_S_JUN", "cze");
define("L_S_JUL", "lip");
define("L_S_AUG", "sie");
define("L_S_SEP", "wrz");
define("L_S_OCT", "paź");
define("L_S_NOV", "lis");
define("L_S_DEC", "gru");
// Week days Long Names
define("L_MON", "poniedziałek");
define("L_TUE", "wtorek");
define("L_WED", "środa");
define("L_THU", "czwartek");
define("L_FRI", "piątek");
define("L_SAT", "sobota");
define("L_SUN", "niedziela");
// Week days Short Names
define("L_S_MON", "pon");
define("L_S_TUE", "wt");
define("L_S_WED", "śr");
define("L_S_THU", "czw");
define("L_S_FRI", "pi");
define("L_S_SAT", "sob");
define("L_S_SUN", "nie");

// Windows encoding
define("WIN_DEFAULT", "iso-8859-2");
define("L_CAL_FORMAT", "%d. %B %Y"); //(d-m-Y")
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "pl_PL"); // en_US format of your language

// Set the PL specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "pol-pol.UTF-8", "pol-pol", "Polish.UTF-8", "Polish"); //("Polish.UTF-8","Polish")
} else {
setlocale(LC_TIME, "pl_PL.UTF-8", "pol.UTF-8", "pol_pol.UTF-8", "Polish.UTF-8");
}
?>