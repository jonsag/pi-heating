<?php
# es_AR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Argentinian Spanish / español Argentina
# Translator: Matías Olivera <matiolivera@yahoo.com>
# Last file update: 23.07.2013

// Class strings localization
define("L_DAYC", "Día");
define("L_MONTHC", "Mes");
define("L_YEARC", "Año");
define("L_TODAY", "Hoy");
define("L_PREV", "Anterior");
define("L_NEXT", "Próximo");
define("L_REF_CAL", "Actualizando Calendario...");
define("L_CHK_VAL", "Verifica el valor");
define("L_SEL_LANG", "Selecciona lenguage");
define("L_SEL_ICON", "Selecciona");
define("L_SEL_DATE", "Selecciona día");
define("L_ERR_SEL", "Tu selección no es válida");
define("L_NOT_ALLOWED", "Este día no puede ser seleccionado");
define("L_DATE_BEFORE", "Elija una fecha anterior a %s");
define("L_DATE_AFTER", "Elija una fecha posterior al %s");
define("L_DATE_BETWEEN", "Elija una fecha entre el\\n%s y el %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Cancelar");
define("L_CLOSE", "Cerrar");
define("L_WARN_2038", "La versión de este servidor php no tiene soporte para el año 2038 o posterior! (<5.3.0)");
define("L_ERR_NOSET", "Error! No se puede definir este valor de calendario!");
define("L_VERSION", "Versión: %s (%s lenguajes)");
define("L_POWBY", "Desarrollado por:"); //or "Based on:", "Supported by"
define("L_HERE", "aquí");
define("L_UPDATE", "Actualización disponible %s !");
define("L_TRANAME", "Matías Olivera");
define("L_TRABY", "Traducido por %s");

// Set the first day of the week in your language
define("FIRST_DAY", "0"); // 1 for Monday, 0 for Sunday

// Months Long Names
define("L_JAN", "enero");
define("L_FEB", "febrero");
define("L_MAR", "marzo");
define("L_APR", "abril");
define("L_MAY", "mayo");
define("L_JUN", "junio");
define("L_JUL", "julio");
define("L_AUG", "agosto");
define("L_SEP", "septiembre");
define("L_OCT", "octubre");
define("L_NOV", "noviembre");
define("L_DEC", "diciembre");
// Months Short Names
define("L_S_JAN", "ene");
define("L_S_FEB", "feb");
define("L_S_MAR", "mar");
define("L_S_APR", "abr");
define("L_S_MAY", "may");
define("L_S_JUN", "jun");
define("L_S_JUL", "jul");
define("L_S_AUG", "ago");
define("L_S_SEP", "sep");
define("L_S_OCT", "oct");
define("L_S_NOV", "nov");
define("L_S_DEC", "dic");
// Week days Long Names
define("L_MON", "lunes");
define("L_TUE", "martes");
define("L_WED", "miércoles");
define("L_THU", "jueves");
define("L_FRI", "viernes");
define("L_SAT", "sábado");
define("L_SUN", "domingo");
// Week days Short Names
define("L_S_MON", "lu");
define("L_S_TUE", "ma");
define("L_S_WED", "mi");
define("L_S_THU", "ju");
define("L_S_FRI", "vi");
define("L_S_SAT", "sá");
define("L_S_SUN", "do");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "es_AR");

// Set the AR specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "ESP_ARG.UTF-8", "ESP_ARG");
} else {
setlocale(LC_TIME, "es_AR.UTF-8", "esp_arg.UTF-8");
}
?>