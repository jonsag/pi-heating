<?php
# nb_NO translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Norwegian (Bokmål) / norsk, bokmål
# Translator: Stian Hvatum <post@dream-web.no>
# Last file update: 30.07.2013

// Class strings localization
define("L_DAYC", "Dag");
define("L_MONTHC", "Måned");
define("L_YEARC", "År");
define("L_TODAY", "I dag");
define("L_PREV", "Forrige");
define("L_NEXT", "Neste");
define("L_REF_CAL", "Oppdaterer Kalender...");
define("L_CHK_VAL", "Sjekk verdien");
define("L_SEL_LANG", "Velg språk");
define("L_SEL_ICON", "Velg");
define("L_SEL_DATE", "Velg dato");
define("L_ERR_SEL", "Valget er ikke gyldig");
define("L_NOT_ALLOWED", "Denne datoen kan ikke velges");
define("L_DATE_BEFORE", "Velg en dato før %s");
define("L_DATE_AFTER", "Velg en dato etter %s");
define("L_DATE_BETWEEN", "Velg en dato mellom\\n%s og %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Nullstill");
define("L_CLOSE", "Steng");
define("L_WARN_2038", "Denne php-serveren har ikke støtte for år 2038 eller senere! (<5.3.0)");
define("L_ERR_NOSET", "Feil! Kalenderverdien kunne ikke bli satt!");
define("L_VERSION", "Versjon: %s (%s språk)");
define("L_POWBY", "Bygget på:"); //or "Based on:", "Supported by"
define("L_HERE", "her");
define("L_UPDATE", "Oppdatering tilgjengelig %s !");
define("L_TRANAME", "Stian Hvatum");
define("L_TRABY", "Oversatt av %s");
define("L_DONATE", "Ønsker du å donere?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "januar");
define("L_FEB", "februar");
define("L_MAR", "mars");
define("L_APR", "april");
define("L_MAY", "mai");
define("L_JUN", "juni");
define("L_JUL", "juli");
define("L_AUG", "august");
define("L_SEP", "september");
define("L_OCT", "oktober");
define("L_NOV", "november");
define("L_DEC", "desember");
// Months Short Names
define("L_S_JAN", "jan");
define("L_S_FEB", "feb");
define("L_S_MAR", "mar");
define("L_S_APR", "apr");
define("L_S_MAY", "mai");
define("L_S_JUN", "jun");
define("L_S_JUL", "jul");
define("L_S_AUG", "aug");
define("L_S_SEP", "sep");
define("L_S_OCT", "okt");
define("L_S_NOV", "nov");
define("L_S_DEC", "des");
// Week days Long Names
define("L_MON", "mandag");
define("L_TUE", "tirsdag");
define("L_WED", "onsdag");
define("L_THU", "torsdag");
define("L_FRI", "fredag");
define("L_SAT", "lørdag");
define("L_SUN", "søndag");
// Week days Short Names
define("L_S_MON", "ma");
define("L_S_TUE", "ti");
define("L_S_WED", "on");
define("L_S_THU", "to");
define("L_S_FRI", "fr");
define("L_S_SAT", "lø");
define("L_S_SUN", "sø");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d. %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "nb_NO"); // en_US format of your language

// Set the XX specific date/time format; ENGLISH EXAMPLE:
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "nb_NO.UTF-8", "nor-bok.UTF-8", "nor-bok", "nor.UTF-8", "nor-nor.UTF-8", "Norwegian-bokmal.UTF-8", "Norwegian.UTF-8", "Norwegian", "Norwegian_Norway");
} else {
setlocale(LC_TIME, "nb_NO.UTF-8", "no_NB.UTF-8", "no_NO.UTF-8", "nor.UTF-8", "nor_bok.UTF-8", "Norwegian.UTF-8", "Norwegian-bokmal.UTF-8");
}
?>