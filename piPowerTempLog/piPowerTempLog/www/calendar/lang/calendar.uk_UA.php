<?php
# uk_UA translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Ukrainian / український
# Translator: Ciprian <ciprianmp@yahoo.com> - using Google Talk translator
# Last file update: 21.07.2013

// Class strings localization
define("L_DAYC", "День");
define("L_MONTHC", "Місяць");
define("L_YEARC", "Рік");
define("L_TODAY", "Cьогодні");
define("L_PREV", "Попередня");
define("L_NEXT", "Наступна");
define("L_REF_CAL", "Освіжаючий календар...");
define("L_CHK_VAL", "Перевірте значення");
define("L_SEL_LANG", "Виберіть мову");
define("L_SEL_ICON", "Вибирати");
define("L_SEL_DATE", "Виберіть дату");
define("L_ERR_SEL", "Ваш вибір не дійсні");
define("L_NOT_ALLOWED", "Ця дата не може бути обраний");
define("L_DATE_BEFORE", "Будь ласка, оберіть дату до %s");
define("L_DATE_AFTER", "Будь ласка, оберіть дату, після %s");
define("L_DATE_BETWEEN", "Будь ласка, оберіть дату між\\n%s та %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Скасувати");
define("L_CLOSE", "Близько");
define("L_WARN_2038", "Цей сервер версії PHP не має підтримки 2038 і пізніше! (<5.3.0)");
define("L_ERR_NOSET", "Помилка! Календар вартість не може бути встановлений!");
define("L_VERSION", "Версія: %s (%s мов)");
define("L_POWBY", "Створено:"); //or "Based on:", "Supported by"
define("L_HERE", "тут");
define("L_UPDATE", "Доступно оновлення %s !");
define("L_TRANAME", "Google"); //Keep a short name
define("L_TRABY", "Переклад %s");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
# Menu - nominative
define("L_JAN", "січень");
define("L_FEB", "лютий");
define("L_MAR", "березень");
define("L_APR", "квітень");
define("L_MAY", "травень");
define("L_JUN", "червень");
define("L_JUL", "липень");
define("L_AUG", "серпень");
define("L_SEP", "вересень");
define("L_OCT", "жовтень");
define("L_NOV", "листопад");
define("L_DEC", "грудень");
# Dates - genitive
define("L_JANG", "січня");
define("L_FEBG", "лютия");
define("L_MARG", "березеня");
define("L_APRG", "квітеня");
define("L_MAYG", "травеня");
define("L_JUNG", "червеня");
define("L_JULG", "липняя");
define("L_AUGG", "серпеня");
define("L_SEPG", "вересня");
define("L_OCTG", "жовтня");
define("L_NOVG", "листопада");
define("L_DECG", "грудня");
// Months Short Names
define("L_S_JAN", "січ.");
define("L_S_FEB", "лют.");
define("L_S_MAR", "бер.");
define("L_S_APR", "квіт.");
define("L_S_MAY", "трав.");
define("L_S_JUN", "чер.");
define("L_S_JUL", "лип.");
define("L_S_AUG", "серп.");
define("L_S_SEP", "вер.");
define("L_S_OCT", "жовт.");
define("L_S_NOV", "лист.");
define("L_S_DEC", "груд.");
// Week days Long Names
define("L_MON", "понеділок");
define("L_TUE", "вівторок");
define("L_WED", "середа");
define("L_THU", "четвер");
define("L_FRI", "п’ятниця");
define("L_SAT", "субота");
define("L_SUN", "неділя");
// Week days Short Names
define("L_S_MON", "Пн");
define("L_S_TUE", "Вт");
define("L_S_WED", "Ср");
define("L_S_THU", "Чт");
define("L_S_FRI", "Пт");
define("L_S_SAT", "Сб");
define("L_S_SUN", "Нд");

// Windows encoding
define("WIN_DEFAULT", "windows-1251");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "uk_UA"); // en_US format of your language

// Set the RU specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "ukr-ukr.UTF-8", "ukr-ukr", "Ukrainian.UTF-8", "Ukrainian");
} else {
setlocale(LC_TIME, "uk_UA.UTF-8", "ukr.UTF-8", "ukr_ukr.UTF-8", "Ukrainian.UTF-8");
}
?>