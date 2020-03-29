<?php
# ko_KR translation for
# PHP-Calendar, DatePicker Calendar class: http://www.triconsole.com/php/calendar_datepicker.php
# Localized version of PHP-Calendar, DatePicker Calendar class: http://ciprianmp.com/scripts/calendar/
# Version: 3.70
# Language: Korean / 한국어
# Translator: Jong-Youn Kim <rogscorp@gmail.com>
# Last file update: 07.08.2013

// Class strings localization
define("L_DAYC", "일");
define("L_MONTHC", "월");
define("L_YEARC", "년");
define("L_TODAY", "오늘");
define("L_PREV", "이전");
define("L_NEXT", "다음");
define("L_REF_CAL", "새로고침 중...");
define("L_CHK_VAL", "값 확인");
define("L_SEL_LANG", "언어 선택");
define("L_SEL_ICON", "아이콘 선택");
define("L_SEL_DATE", "날짜 선택");
define("L_ERR_SEL", "올바르지 않은 값입니다.");
define("L_NOT_ALLOWED", "이 날짜는 선택할 수 없습니다.");
define("L_DATE_BEFORE", "%s이전 날짜를 선택해주세요.");
define("L_DATE_AFTER", "%s이후 날짜를 선택해주세요.");
define("L_DATE_BETWEEN", "\\n%s와 %s사이의 날짜를 선택해주세요.");
define("L_WEEK_HDR", ""); // Optional Short Name for the column header showing the current Week number (W or CW in English - max 2 letters)
define("L_UNSET", "재설정");
define("L_CLOSE", "닫기");
define("L_WARN_2038", "이 php 서버의 버전은 2038년 이후의 날짜를 지원하지 않습니다. (5.3.0버전 미만)");
define("L_ERR_NOSET", "에러: 달력값을 설정할 수 없습니다!");
define("L_VERSION", "버전: %s (%s한국어)");
define("L_POWBY", "지원:"); //or "Based on:", "Supported by"
define("L_HERE", "여기");
define("L_UPDATE", "업데이트 가능 %s !");
define("L_TRANAME", "김종윤 (Jong-Youn Kim)");
define("L_TRABY", "번역: %s");
define("L_DONATE", "개발자를 위해 기부하기를 원하시나요?");

// Set the first day of the week in your language (0 for Sunday, 1 for Monday ... 6 for Saturday)
define("FIRST_DAY", "0");

// Months Long Names
define("L_JAN", "1월");
define("L_FEB", "2월");
define("L_MAR", "3월");
define("L_APR", "4월");
define("L_MAY", "5월");
define("L_JUN", "6월");
define("L_JUL", "7월");
define("L_AUG", "8월");
define("L_SEP", "9월");
define("L_OCT", "10월");
define("L_NOV", "11월");
define("L_DEC", "12월");
// Months Short Names
define("L_S_JAN", "1월");
define("L_S_FEB", "2월");
define("L_S_MAR", "3월");
define("L_S_APR", "4월");
define("L_S_MAY", "5월");
define("L_S_JUN", "6월");
define("L_S_JUL", "7월");
define("L_S_AUG", "8월");
define("L_S_SEP", "9월");
define("L_S_OCT", "10월");
define("L_S_NOV", "11월");
define("L_S_DEC", "12월");
// Week days Long Names
define("L_MON", "월요일");
define("L_TUE", "화요일");
define("L_WED", "수요일");
define("L_THU", "목요일");
define("L_FRI", "금요일");
define("L_SAT", "토요일");
define("L_SUN", "일요일");
// Week days Short Names
define("L_S_MON", "월");
define("L_S_TUE", "화");
define("L_S_WED", "수");
define("L_S_THU", "목");
define("L_S_FRI", "금");
define("L_S_SAT", "토");
define("L_S_SUN", "일");

// Display extratext beside years, months and/or days in dropdowns (eg. Korean and Japan)
define("L_USE_YMD_DROP", 1);

// Windows encoding
define("WIN_DEFAULT", "MS-949");
define("L_CAL_FORMAT", "%Y년%B%d일");
if(!defined("L_LANG") || L_LANG == "L_LANG") define("L_LANG", "ko_KR"); // en_US format of your language

// Set the KR specific date/time format;
if (stristr(PHP_OS,"win")) {
setlocale(LC_TIME, "ko-KR.UTF-8", "ko-KR", "Korean");
} else {
setlocale(LC_TIME, "ko_KR.UTF-8");
}
?>