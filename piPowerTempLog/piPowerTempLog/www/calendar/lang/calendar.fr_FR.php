<?php
# fr_FR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.73
# Language: French / français
# Translators: Pierre Liget <sourceforge@pliget.freesurf.fr> and Yann aka Corwin9s <corwin@ninesages.org>
# Last file update: 27.01.2015

// Class strings localization
define("L_DAYC", "Jour");
define("L_MONTHC", "Mois");
define("L_YEARC", "Année");
define("L_TODAY", "Aujourd’hui");
define("L_PREV", "Précédent");
define("L_NEXT", "Suivant");
define("L_REF_CAL", "Actualisation du calendrier en cours ...");
define("L_CHK_VAL", "Vérifiez la valeur");
define("L_SEL_LANG", "Choix de la langue");
define("L_SEL_ICON", "Choisir");
define("L_SEL_DATE", "Choix de la date");
define("L_ERR_SEL", "Le choix n’est pas valide");
define("L_NOT_ALLOWED", "Cette date ne peut pas être choisie");
define("L_DATE_BEFORE", "Veuillez choisir une date\\navant le %s");
define("L_DATE_AFTER", "Veuillez choisir une date\\naprès le %s");
define("L_DATE_BETWEEN", "Veuillez choisir une date entre le\\n%s et le %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Annuler"); //Remise à zéro
define("L_CLOSE", "Fermer");
define("L_WARN_2038", "Cette version de PHP ne supporte pas les années 2038 et après! (<5.3.0)");
define("L_ERR_NOSET", "Erreur! La valeur du calendrier ne peut pas être fixée!");
define("L_VERSION", "Version: %s (%s langues)");
define("L_POWBY", "Basé sur:"); //or "Based on:", "Supported by"
define("L_HERE", "ici");
define("L_UPDATE", "Mise à jour disponible %s !");
define("L_TRANAME", "Pierre</b> et <b>Yann");
define("L_TRABY", "Traduit par %s");
define("L_DONATE", "Souhaitez-vous faire un don?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "janvier");
define("L_FEB", "février");
define("L_MAR", "mars");
define("L_APR", "avril");
define("L_MAY", "mai");
define("L_JUN", "juin");
define("L_JUL", "juillet");
define("L_AUG", "août");
define("L_SEP", "septembre");
define("L_OCT", "octobre");
define("L_NOV", "novembre");
define("L_DEC", "décembre");
// Months Short Names
define("L_S_JAN", "janv.");
define("L_S_FEB", "févr.");
define("L_S_MAR", "mars");
define("L_S_APR", "avr.");
define("L_S_MAY", "mai");
define("L_S_JUN", "juin");
define("L_S_JUL", "juil.");
define("L_S_AUG", "août");
define("L_S_SEP", "sept.");
define("L_S_OCT", "oct.");
define("L_S_NOV", "nov.");
define("L_S_DEC", "déc.");
// Week days Long Names
define("L_MON", "lundi");
define("L_TUE", "mardi");
define("L_WED", "mercredi");
define("L_THU", "jeudi");
define("L_FRI", "vendredi");
define("L_SAT", "samedi");
define("L_SUN", "dimanche");
// Week days Short Names
define("L_S_MON", "lun.");
define("L_S_TUE", "mar.");
define("L_S_WED", "mer.");
define("L_S_THU", "jeu.");
define("L_S_FRI", "ven.");
define("L_S_SAT", "sam.");
define("L_S_SUN", "dim.");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "fr_FR");

// Set the FR specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "fra_fra.UTF-8", "french.UTF-8", "french");
} else {
setlocale(LC_TIME, "fr_FR.UTF-8", "fr.UTF-8", "fr_FR.UTF-8@euro"); // For French formats
}
?>