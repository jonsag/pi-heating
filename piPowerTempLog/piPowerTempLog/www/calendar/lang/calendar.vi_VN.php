<?php
# vi_VN translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Version: 3.70
# Language: Vietnamese / Tiếng Việt
# Translators: Marshall <hellomarshal_lookatme@yahoo.com.vn> & Aks Mac <ask.bi92@gmail.com>
# Last file update: 20.08.2013

// Class strings localization
define("L_DAYC", "Ngày");
define("L_MONTHC", "Tháng");
define("L_YEARC", "Năm");
define("L_TODAY", "Hôm nay");
define("L_PREV", "Trước");
define("L_NEXT", "Tiếp theo");
define("L_REF_CAL", "Làm mới lịch...");
define("L_CHK_VAL", "Kiểm tra giá trị");
define("L_SEL_LANG", "Lựa chọn ngôn ngữ");
define("L_SEL_ICON", "Lựa chọn");
define("L_SEL_DATE", "Lựa chọn ngày");
define("L_ERR_SEL", "Sự lựa chọn của bạn không hợp lệ");
define("L_NOT_ALLOWED", "Lựa chọn không được chấp nhận");
define("L_DATE_BEFORE", "Vui lòng chọn ngày trước %s");
define("L_DATE_AFTER", "Vui lòng chọn ngày sau %s");
define("L_DATE_BETWEEN", "Vui lòng chọn ngày giữa\\n%s và %s");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "Bỏ lựa chọn");
define("L_CLOSE", "Đóng");
define("L_WARN_2038", "Phiên bản PHP < 5.3.0 không có hỗ trợ cho năm 2038 và sau đó!");
define("L_ERR_NOSET", "Lỗi ! Lịch không được thiệt lập!");
define("L_VERSION", "Phiên bản: %s (%s ngôn ngữ)");
define("L_POWBY", "Hỗ trợ bởi:"); //or "Based on:", "Supported by"
define("L_HERE", "tại đây");
define("L_UPDATE", "Cập nhật %s !");
define("L_TRANAME", "Marshall & Aks Mac");
define("L_TRABY", "Dịch bởi %s");
define("L_DONATE", "Bạn có muốn tặng?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday)
define("FIRST_DAY", "1");

// Months Long Names
define("L_JAN", "Tháng Một");
define("L_FEB", "Tháng Hai");
define("L_MAR", "Tháng Ba");
define("L_APR", "Tháng Tư");
define("L_MAY", "Tháng Năm");
define("L_JUN", "Tháng Sáu");
define("L_JUL", "Tháng Bảy");
define("L_AUG", "Tháng Tám");
define("L_SEP", "Tháng Chín");
define("L_OCT", "Tháng Mười");
define("L_NOV", "Tháng Mười Một");
define("L_DEC", "Tháng Mười Hai"); //Tháng chạp
// Months Short Names
define("L_S_JAN", "Tháng 1");
define("L_S_FEB", "Tháng 2");
define("L_S_MAR", "Tháng 3");
define("L_S_APR", "Tháng 4");
define("L_S_MAY", "Tháng 5");
define("L_S_JUN", "Tháng 6");
define("L_S_JUL", "Tháng 7");
define("L_S_AUG", "Tháng 8");
define("L_S_SEP", "Tháng 9");
define("L_S_OCT", "Tháng 10");
define("L_S_NOV", "Tháng 11");
define("L_S_DEC", "Tháng 12");
// Week days Long Names
define("L_MON", "Thứ Hai");
define("L_TUE", "Thứ Ba");
define("L_WED", "Thứ Tư");
define("L_THU", "Thứ Năm");
define("L_FRI", "Thứ Sáu");
define("L_SAT", "Thứ Bảy");
define("L_SUN", "Chủ Nhật");
// Week days Short Names
define("L_S_MON", "Hai");
define("L_S_TUE", "Ba");
define("L_S_WED", "Tư");
define("L_S_THU", "Năm");
define("L_S_FRI", "Sáu");
define("L_S_SAT", "Bảy");
define("L_S_SUN", "CN");

// Windows encoding
define("WIN_DEFAULT", "windows-1258");
define("L_CAL_FORMAT", "%d %B %Y");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "vi_VN");

// Set the VN specific date/time format
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "vietnamese", "vietnamese.UTF-8", "viet nam.UTF-8", "viet nam");
} else {
setlocale(LC_TIME, "vi_VN.UTF-8", "vnd_vnd.UTF-8", "vie_vie.UTF-8");
}
?>