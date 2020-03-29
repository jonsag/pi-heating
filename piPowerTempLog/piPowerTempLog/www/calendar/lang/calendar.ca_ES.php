<?php
# ca_ES translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Catalan / català (in your lang) // ex: Romanian / Română
# Translator: Jordi Babot <jordibabot@gmail.com>
# Last file update: 29.07.2013

// Class strings localization
define("L_DAYC", "Dia");
define("L_MONTHC", "Mes");
define("L_YEARC", "Any");
define("L_TODAY", "Avui");
define("L_PREV", "Anterior");
define("L_NEXT", "Següent");
define("L_REF_CAL", "Refrescant Calendari...");
define("L_CHK_VAL", "Comproveu el valor");
define("L_SEL_LANG", "Selecciona llengua");
define("L_SEL_ICON", "Selecciona");
define("L_SEL_DATE", "Selecciona data");
define("L_ERR_SEL", "La selecció no és vàlida");
define("L_NOT_ALLOWED", "Aquesta data no és permesa");
define("L_DATE_BEFORE", "Sisplau, selecciona una data abans del %s");
define("L_DATE_AFTER", "Sisplau, selecciona una data després del %s");
define("L_DATE_BETWEEN", "Sisplau, selecciona una data entre el\\n%s i el %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Cap");
define("L_CLOSE", "Tancar");
define("L_WARN_2038", "Aquesta versió del PHP al servidor no contempla anys superiors al 2038! (<5.3.0)");
define("L_ERR_NOSET", "Error! El valor del calendari no s'ha pogut desar!");
define("L_VERSION", "Versió: %s (%s idiomes)");
define("L_POWBY", "Impulsat per:"); //or "Based on:", "Supported by"
define("L_HERE", "aquí");
define("L_UPDATE", "Actualització disponible %s !");
define("L_TRANAME", "Jordi Babot Casacuberta");
define("L_TRABY", "Traduït per<br />%s");
define("L_DONATE", "Vols col·laborar amb el projecte?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "gener");
define("L_FEB", "febrer");
define("L_MAR", "març");
define("L_APR", "abril");
define("L_MAY", "maig");
define("L_JUN", "juny");
define("L_JUL", "juliol");
define("L_AUG", "agost");
define("L_SEP", "setembre");
define("L_OCT", "octubre");
define("L_NOV", "novembre");
define("L_DEC", "desembre");
// Months Short Names
define("L_S_JAN", "gen");
define("L_S_FEB", "feb");
define("L_S_MAR", "mar");
define("L_S_APR", "abr");
define("L_S_MAY", "mai");
define("L_S_JUN", "jun");
define("L_S_JUL", "jul");
define("L_S_AUG", "ago");
define("L_S_SEP", "set");
define("L_S_OCT", "oct");
define("L_S_NOV", "nov");
define("L_S_DEC", "des");
// Week days Long Names
define("L_MON", "dilluns");
define("L_TUE", "dimarts");
define("L_WED", "dimecres");
define("L_THU", "dijous");
define("L_FRI", "divendres");
define("L_SAT", "dissabte");
define("L_SUN", "diumenge");
// Week days Short Names
define("L_S_MON", "dl");
define("L_S_TUE", "dm");
define("L_S_WED", "dc");
define("L_S_THU", "dj");
define("L_S_FRI", "dv");
define("L_S_SAT", "ds");
define("L_S_SUN", "du");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "ca_ES"); // en_US format of your language

// Set the CA specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "cat-esp.UTF-8", "cat-esp", "Catalan_Spain", "Catalan-esp.UTF-8");
} else {
setlocale(LC_TIME, "ca_ES.UTF-8", "ca_ES.UTF-8@euro", "ca_ES@euro", "esp.UTF-8", "cat_esp.UTF-8", "Catalan-esp.UTF-8","catalan.UTF-8");
}
?>