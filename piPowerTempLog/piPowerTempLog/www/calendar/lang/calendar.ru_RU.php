<?php
# ru_RU translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Russian / pусский
# Translator: Ciprian <ciprianmp@yahoo.com> - using Google Talk translator
# Last file update: 21.07.2013

// Class strings localization
define("L_DAYC", "День");
define("L_MONTHC", "Месяц");
define("L_YEARC", "Год");
define("L_TODAY", "Cегодня");
define("L_PREV", "Предыдущее");
define("L_NEXT", "Следущее");
define("L_REF_CAL", "Обновить календарь...");
define("L_CHK_VAL", "Проверить значение");
define("L_SEL_LANG", "Выбрать язык");
define("L_SEL_ICON", "Выбрать");
define("L_SEL_DATE", "Выбрать дату");
define("L_ERR_SEL", "Выбор неверный");
define("L_NOT_ALLOWED", "Эта дата не может быть выбрана");
define("L_DATE_BEFORE", "Выберите дату до %s");
define("L_DATE_AFTER", "Выберите дату, после %s");
define("L_DATE_BETWEEN", "Выберите дату между\\n%s и %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Отменить");
define("L_CLOSE", "Закрыть");
define("L_WARN_2038", "Этот сервер версии PHP не имеет поддержки 2038 году и позже! (<5.3.0)");
define("L_ERR_NOSET", "Ошибка! Календарь стоимость не может быть установлен!");
define("L_VERSION", "Версия: %s (%s языков)");
define("L_POWBY", "Создано:"); //or "Based on:", "Supported by"
define("L_HERE", "здесь");
define("L_UPDATE", "Доступно обновление %s !");
define("L_TRANAME", "Google"); //Keep a short name
define("L_TRABY", "Перевод %s");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "январь");
define("L_FEB", "февраль");
define("L_MAR", "март");
define("L_APR", "апрель");
define("L_MAY", "май");
define("L_JUN", "июнь");
define("L_JUL", "июль");
define("L_AUG", "август");
define("L_SEP", "сентябрь");
define("L_OCT", "октябрь");
define("L_NOV", "ноябрь");
define("L_DEC", "декабрь");
# Dates - genitive
define("L_JANG", "января");
define("L_FEBG", "февраля");
define("L_MARG", "мартa");
define("L_APRG", "апреля");
define("L_MAYG", "мая");
define("L_JUNG", "июня");
define("L_JULG", "июля");
define("L_AUGG", "августa");
define("L_SEPG", "сентября");
define("L_OCTG", "октября");
define("L_NOVG", "ноября");
define("L_DECG", "декабря");
// Months Short names
define("L_S_JAN", "янв.");
define("L_S_FEB", "фев.");
define("L_S_MAR", "март");
define("L_S_APR", "апр.");
define("L_S_MAY", "май");
define("L_S_JUN", "июнь");
define("L_S_JUL", "июль");
define("L_S_AUG", "авг.");
define("L_S_SEP", "сен.");
define("L_S_OCT", "окт.");
define("L_S_NOV", "ноя.");
define("L_S_DEC", "дек.");
// Week days long names
define("L_MON", "понедельник");
define("L_TUE", "вторник");
define("L_WED", "среда");
define("L_THU", "четверг");
define("L_FRI", "пятница");
define("L_SAT", "суббота");
define("L_SUN", "воскресенье");
// Week days Short Names
define("L_S_MON", "Пн");
define("L_S_TUE", "Вт");
define("L_S_WED", "Ср");
define("L_S_THU", "Чт");
define("L_S_FRI", "Пт");
define("L_S_SAT", "Сб");
define("L_S_SUN", "Вс");

// Windows encoding
define("WIN_DEFAULT", "windows-1251");
define("L_CAL_FORMAT", "%d %B %Y г.");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "ru_RU"); // en_US format of your language

// Set the RU specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "rus-rus.UTF-8", "rus-rus", "Russian.UTF-8", "Russian");
} else {
setlocale(LC_TIME, "ru_RU.UTF-8", "rus.UTF-8", "rus_rus.UTF-8", "Russian.UTF-8");
}
?>