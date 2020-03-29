<?php
# fi_FI translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Finnish / suomi // ex: Romanian / română
# Translator: Ilja Mäki <iksa@netti.fi>
# Last file update: 31.07.2013

// Class strings localization
define("L_DAYC", "Päivä");
define("L_MONTHC", "Kuukausi");
define("L_YEARC", "Vuosi");
define("L_TODAY", "Tänään");
define("L_PREV", "Edellinen");
define("L_NEXT", "Seuraava");
define("L_REF_CAL", "Päivitetään kalenteria...");
define("L_CHK_VAL", "Tarkista arvo");
define("L_SEL_LANG", "Valitse kieli");
define("L_SEL_ICON", "Valitse");
define("L_SEL_DATE", "Valitse päiväys");
define("L_ERR_SEL", "Valintasi ei ole kelvollinen");
define("L_NOT_ALLOWED", "Tätä päivämäärää ei voi valita");
define("L_DATE_BEFORE", "Valitse päivämäärä ennen %s");
define("L_DATE_AFTER", "Valitse päivämäärä %s jälkeen");
define("L_DATE_BETWEEN", "Valitse päivämäärä väliltä\\n%s ja %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Nollaa");
define("L_CLOSE", "Sulje");
define("L_WARN_2038", "Tässä php-palvelimen versiossa ei ole tukea vuodelle 2038 ja siitä eteenpäin! (<5.3.0)");
define("L_ERR_NOSET", "Virhe! Kalenteriarvoa ei voi asettaa!");
define("L_VERSION", "Versio: %s (%s kieltä)");
define("L_POWBY", "Perustuu:"); //or "Based on:", "Supported by"
define("L_HERE", "tässä");
define("L_UPDATE", "Päivitys saatavilla %s !");
define("L_TRANAME", "Ilja Mäki");
define("L_TRABY", "Suomentanut %s");
define("L_DONATE", "Haluatko lahjoittaa?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "tammikuu");
define("L_FEB", "helmikuu");
define("L_MAR", "maaliskuu");
define("L_APR", "huhtikuu");
define("L_MAY", "toukokuu");
define("L_JUN", "kesäkuu");
define("L_JUL", "heinäkuu");
define("L_AUG", "elokuu");
define("L_SEP", "syyskuu");
define("L_OCT", "lokakuu");
define("L_NOV", "marraskuu");
define("L_DEC", "joulukuu");
# Dates - genitive
define("L_JANG", "tammikuuta");
define("L_FEBG", "helmikuuta");
define("L_MARG", "maaliskuuta");
define("L_APRG", "huhtikuuta");
define("L_MAYG", "toukokuuta");
define("L_JUNG", "kesäkuuta");
define("L_JULG", "heinäkuuta");
define("L_AUGG", "elokuuta");
define("L_SEPG", "syyskuuta");
define("L_OCTG", "lokakuuta");
define("L_NOVG", "marraskuuta");
define("L_DECG", "joulukuuta");
// Months Short Names
define("L_S_JAN", "tam");
define("L_S_FEB", "hel");
define("L_S_MAR", "maa");
define("L_S_APR", "huh");
define("L_S_MAY", "tou");
define("L_S_JUN", "kes");
define("L_S_JUL", "hei");
define("L_S_AUG", "elo");
define("L_S_SEP", "syy");
define("L_S_OCT", "lok");
define("L_S_NOV", "mar");
define("L_S_DEC", "jou");
// Week days Long Names
define("L_MON", "maanantai");
define("L_TUE", "tiistai");
define("L_WED", "keskiviikko");
define("L_THU", "torstai");
define("L_FRI", "perjantai");
define("L_SAT", "lauantai");
define("L_SUN", "sunnuntai");
// Week days Short Names
define("L_S_MON", "ma");
define("L_S_TUE", "ti");
define("L_S_WED", "ke");
define("L_S_THU", "to");
define("L_S_FRI", "pe");
define("L_S_SAT", "la");
define("L_S_SUN", "su");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "fi_FI"); // en_US format of your language

// Set the FI specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "fin_fin.UTF-8", "fi_FI@euro", "fi_FI.UTF-8", "Finnish_Finland");
} else {
setlocale(LC_TIME, "fi_FI.UTF-8", "fi_FI@euro", "fi_FI", "Finnish.UTF-8");
}
?>