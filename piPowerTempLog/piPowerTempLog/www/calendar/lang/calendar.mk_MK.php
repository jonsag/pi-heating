<?php
# mk_MK translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Macedonian / македонски
# Translator: Миле Ѓоргиев <milegorgiev@yahoo.com>
# Last file update: 30.07.2013

// Class strings localization
define("L_DAY", "Ден");
define("L_MONTH", "Месец");
define("L_YEAR", "Година");
define("L_TODAY", "Денес");
define("L_PREV", "Претходен");
define("L_NEXT", "Нареден");
define("L_REF_CAL", "Календарот се вчитува...");
define("L_CHK_VAL", "Провери ја вредноста");
define("L_SEL_LANG", "Избери јазик");
define("L_SEL_ICON", "Избери икона");
define("L_SEL_DATE", "Избери датум");
define("L_ERR_SEL", "Вашиот избор не е валиден");
define("L_NOT_ALLOWED", "Овој датум не е дозволен да биде избран");
define("L_DATE_BEFORE", "Одберете датум пред %s");
define("L_DATE_AFTER", "Одберете датум после %s");
define("L_DATE_BETWEEN", "Одберете датум помеѓу\\n%s and %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Ресетирај");
define("L_CLOSE", "Затвори");
define("L_WARN_2038", "php верзијата на серверот ја нема поддршката за 2038 година и наредните години! (<5.3.0)");
define("L_ERR_NOSET", "Грешка! Вредноста на календарот не може да биде поставена!");
define("L_VERSION", "Верзија: %s (%s јазици)");
define("L_POWBY", "Покренато од:"); //or "Базирано на:", "Поддржано од"
define("L_HERE", "овде");
define("L_UPDATE", "Достапни се<br />надоградби %s !");
define("L_TRANAME", "Миле Ѓоргиев");
define("L_TRABY", "Преведено од %s");
define("L_DONATE", "Дали сакате да донирате?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "јануари");
define("L_FEB", "февруари");
define("L_MAR", "март");
define("L_APR", "aприл");
define("L_MAY", "мај");
define("L_JUN", "јуни");
define("L_JUL", "јули");
define("L_AUG", "aвгуст");
define("L_SEP", "cептември");
define("L_OCT", "oктомври");
define("L_NOV", "ноември");
define("L_DEC", "декември");
// Months Short Names
define("L_S_JAN", "јан");
define("L_S_FEB", "фев");
define("L_S_MAR", "мар");
define("L_S_APR", "aпр");
define("L_S_MAY", "мај");
define("L_S_JUN", "јун");
define("L_S_JUL", "јул");
define("L_S_AUG", "aвг");
define("L_S_SEP", "cеп");
define("L_S_OCT", "oкт");
define("L_S_NOV", "ное");
define("L_S_DEC", "дек");
// Week days Long Names
define("L_MON", "понеделник");
define("L_TUE", "вторник");
define("L_WED", "cреда");
define("L_THU", "четврток");
define("L_FRI", "петок");
define("L_SAT", "cабота");
define("L_SUN", "недела");
// Week days Short Names
define("L_S_MON", "пон");
define("L_S_TUE", "вто");
define("L_S_WED", "cре");
define("L_S_THU", "чет");
define("L_S_FRI", "пет");
define("L_S_SAT", "cаб");
define("L_S_SUN", "нед");

// Windows encoding
define("WIN_DEFAULT", "windows-1251");
define("L_CAL_FORMAT", "%d %B %Y г.");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "mk_MK"); // en_US format of your language

// Set the MK specific date/time format; ENGLISH EXAMPLE:
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "mac.UTF-8", "mkd.UTF-8", "mk-MK.UTF-8", "Macedonian.UTF-8");
} else {
setlocale(LC_TIME, "mk_MK.UTF-8", "mk.UTF-8", "Macedonian.UTF-8");
}
?>