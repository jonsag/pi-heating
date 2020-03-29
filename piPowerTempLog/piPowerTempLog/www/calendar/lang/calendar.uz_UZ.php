<?php
# uz_UZ translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.75
# Language: Uzbek / o`zbekcha // Ex: Romanian (English name) / Română (Original name)
# Translator: Akbar Mirsidikov <besmartness@gmail.com>
# Last file update: 07.01.2016

// Class strings localization
define("L_DAYC", "Kun");
define("L_MONTHC", "Oy");
define("L_YEARC", "Yil");
define("L_TODAY", "Bugun");
define("L_PREV", "O`tgan");
define("L_NEXT", "Keyingi");
define("L_REF_CAL", "Yangilash Kalendarni...");
define("L_CHK_VAL", "Qiymatni tekshirish");
define("L_SEL_LANG", "Tilni tanlash");
define("L_SEL_ICON", "Tanlash"); #3.69
define("L_SEL_DATE", "Sanani tanlash");
define("L_ERR_SEL", "Siz xato tanlaganingiz");
define("L_NOT_ALLOWED", "Bu sanani tanlashga ruxsat berilmaydi");
define("L_DATE_BEFORE", "%s dan oldingi sanani tanlang iltimos");
define("L_DATE_AFTER", "%s dan keyingi sanani tanlang iltimos");
define("L_DATE_BETWEEN", "Iltimos\\n%s va %s orasidagi sanani tanlang");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - use max 2 letters)
define("L_UNSET", "olib tashlash");
define("L_CLOSE", "Yopish"); #3.69
define("L_WARN_2038", "Bu php serverning versiyasi 2038 va undan yuqorisini ko`rsata olmaydi ! (<5.3.0)"); #3.69 - deprecated
define("L_ERR_NOSET", "Xatolik! Kalendarning qiymatini o`rnatib bo`lmaydi!"); #3.70
define("L_VERSION", "Versiya: %s (%s Til)"); #3.70
define("L_POWBY", "Tomonidan yasalgan:"); //or "Based on:", "Supported by" #3.70
define("L_HERE", "bu yerda"); #3.70
define("L_UPDATE", "Update qilishingiz mumkin %s !"); #3.70
define("L_TRANAME", "Akbar"); //Keep a short name #3.70
define("L_TRABY", "Tomonidan tarjima qilingan %s"); #3.70
define("L_DONATE", "Xayriya qilishni istaysizmi ?"); #3.70
define("L_SRV_TIMEZONE", "Server Mintaqaviy vaqti:"); //3.74
define("L_MSG_DISABLED", "Siz bu sanani tanlay olmaysiz. Sana muzlatilgan!"); //3.75

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Yanvar");
define("L_FEB", "Fevral");
define("L_MAR", "Mart");
define("L_APR", "Aprel");
define("L_MAY", "May");
define("L_JUN", "Iyun");
define("L_JUL", "Iyul");
define("L_AUG", "Avgust");
define("L_SEP", "Sentabr");
define("L_OCT", "Octabr");
define("L_NOV", "Noyabr");
define("L_DEC", "Dekabr");
// Months Short Names
define("L_S_JAN", "Yan");
define("L_S_FEB", "Fev");
define("L_S_MAR", "Mar");
define("L_S_APR", "Apr");
define("L_S_MAY", "May");
define("L_S_JUN", "Iyn");
define("L_S_JUL", "Iyl");
define("L_S_AUG", "Avg");
define("L_S_SEP", "Sen");
define("L_S_OCT", "Oct");
define("L_S_NOV", "Noy");
define("L_S_DEC", "Dek");
// Week days Long Names
define("L_MON", "Dushanba");
define("L_TUE", "Seshanba");
define("L_WED", "Chorshanba");
define("L_THU", "Payshanba");
define("L_FRI", "Juma");
define("L_SAT", "Shanba");
define("L_SUN", "Yakshanba");
// Week days Short Names
define("L_S_MON", "Du");
define("L_S_TUE", "Se");
define("L_S_WED", "Cho");
define("L_S_THU", "Pay");
define("L_S_FRI", "Ju");
define("L_S_SAT", "Sha");
define("L_S_SUN", "Yak");

// Windows encoding
define("WIN_DEFAULT", "windows-1254");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "uz_UZ"); // en_US format code of your language

// Set the XX specific date/time format; ENGLISH EXAMPLE:
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "uz-uz.UTF-8", "uzb-uzb.UTF-8", "uz-Latn-UZ.UTF-8", "uz-Latn-UZ", "uz-uz", "uzb-uzb", "uzbek-uzbek.UTF-8");
} else {
setlocale(LC_TIME, "uz_UZ.UTF-8", "uzb_UZ.UTF-8", "uz.UTF-8", "uzb.UTF-8", "uzb_uzb.UTF-8", "uzbek-uzb.UTF-8");
}
?>