<?php
# ms_MY translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Malaysian / Bahasa Melayu
# Translator: Noralbaniah <noralbaniahnia@yahoo.com>
# Last file update: 30.07.2013

// Class strings localization
define("L_DAYC", "Hari");
define("L_MONTHC", "Bulan");
define("L_YEARC", "Tahun");
define("L_TODAY", "Hari ini");
define("L_PREV", "Sebelumnya");
define("L_NEXT", "Seterusnya");
define("L_REF_CAL", "Menyegarkan Kalendar...");
define("L_CHK_VAL", "Memeriksa nilainya");
define("L_SEL_LANG", "Pilih Bahasa");
define("L_SEL_ICON", "Pilih");
define("L_SEL_DATE", "Pilih Tarikh");
define("L_ERR_SEL", "Pemilihan anda adalah tidak sah");
define("L_NOT_ALLOWED", "Tarikh ini adalah tidak dibenarkan untuk dipilih");
define("L_DATE_BEFORE", "Sila pilih tarikh sebelum %s");
define("L_DATE_AFTER", "Sila pilih tarikh selepas %s");
define("L_DATE_BETWEEN", "Sila pilih tarikh di antara\\n%s dan %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Belum Ditetap");
define("L_CLOSE", "Tutup");
define("L_WARN_2038", "Versi server php ini tidak mempunyai sokongan bagi tahun 2038 dan kemudian! (<5.3.0)");
define("L_ERR_NOSET", "Ralat! Nilai kelandar tidak boleh ditetapkan!");
define("L_VERSION", "Versi: %s (%s bahasa)");
define("L_POWBY", "Dikuasakan oleh:"); //or "Based on:", "Supported by"
define("L_HERE", "di sini");
define("L_UPDATE", "Kemaskini disediakan %s !");
define("L_TRANAME", "Noralbaniah");
define("L_TRABY", "Diterjemahkan oleh<br />%s");
define("L_DONATE", "Adakah anda ingin<br />memberi sumbangan?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Januari");
define("L_FEB", "Februari");
define("L_MAR", "Mac");
define("L_APR", "April");
define("L_MAY", "Mei");
define("L_JUN", "Jun");
define("L_JUL", "Julai");
define("L_AUG", "Ogos");
define("L_SEP", "September");
define("L_OCT", "Oktober");
define("L_NOV", "November");
define("L_DEC", "Disember");
// Months Short Names
define("L_S_JAN", "Jan");
define("L_S_FEB", "Feb");
define("L_S_MAR", "Mac");
define("L_S_APR", "Apr");
define("L_S_MAY", "Mei");
define("L_S_JUN", "Jun");
define("L_S_JUL", "Jul");
define("L_S_AUG", "Ogo");
define("L_S_SEP", "Sep");
define("L_S_OCT", "Okt");
define("L_S_NOV", "Nov");
define("L_S_DEC", "Dis");
// Week days Long Names
define("L_MON", "Isnin");
define("L_TUE", "Selasa");
define("L_WED", "Rabu");
define("L_THU", "Khamis");
define("L_FRI", "Jumaat");
define("L_SAT", "Sabtu");
define("L_SUN", "Ahad");
// Week days Short Names
define("L_S_MON", "Isn");
define("L_S_TUE", "Sel");
define("L_S_WED", "Rbu");
define("L_S_THU", "Kha");
define("L_S_FRI", "Jum");
define("L_S_SAT", "Sab");
define("L_S_SUN", "Ahd");

// Windows encoding
define("WIN_DEFAULT", "windows-1252");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "ms_MY");

// Set the MS specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME,  "Malay_malaysia", "Malay_malaysia.1252", "zlm_zlm", "zlm.UTF-8", "MSA_MAY.UTF-8", "MSA_MAY", "malaysian"); // For Windows servers
} else {
setlocale(LC_TIME, "ms_MY.UTF8", "ms_MY", "msa.UTF-8", "msa_may.UTF-8"); // For Unix/FreeBSD servers
}
?>