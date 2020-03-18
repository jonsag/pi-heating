EESchema Schematic File Version 4
EELAYER 30 0
EELAYER END
$Descr A4 11693 8268
encoding utf-8
Sheet 1 1
Title ""
Date ""
Rev ""
Comp ""
Comment1 ""
Comment2 ""
Comment3 ""
Comment4 ""
$EndDescr
$Comp
L MCU_Module:Arduino_UNO_R3 A1
U 1 1 5E6FB570
P 8850 3700
F 0 "A1" H 8850 4881 50  0000 C CNN
F 1 "Arduino_UNO_R3" H 8850 4790 50  0000 C CNN
F 2 "My_Arduino:Arduino_UNO_R3_shield_larger_pads" H 8850 3700 50  0001 C CIN
F 3 "https://www.arduino.cc/en/Main/arduinoBoardUno" H 8850 3700 50  0001 C CNN
	1    8850 3700
	1    0    0    -1  
$EndComp
$Comp
L My_Headers:10-pin_header_LCD_interface J3
U 1 1 5E6FBAAB
P 5800 5150
F 0 "J3" H 5792 4335 50  0000 C CNN
F 1 "10-pin_header_LCD_interface" H 5792 4426 50  0000 C CNN
F 2 "My_Headers:10-pin_LCD_header_larger_pads" H 5700 4550 50  0001 C CNN
F 3 "~" H 6250 5100 50  0001 C CNN
	1    5800 5150
	-1   0    0    1   
$EndComp
Wire Wire Line
	8350 4400 7550 4400
Wire Wire Line
	7550 4400 7550 5250
Wire Wire Line
	7550 5250 6000 5250
Wire Wire Line
	8350 4300 7450 4300
Wire Wire Line
	7450 4300 7450 5150
Wire Wire Line
	7450 5150 6000 5150
Wire Wire Line
	8350 4200 7350 4200
Wire Wire Line
	7350 4200 7350 5050
Wire Wire Line
	7350 5050 6000 5050
Wire Wire Line
	8350 4100 7250 4100
Wire Wire Line
	7250 4100 7250 4950
Wire Wire Line
	7250 4950 6000 4950
Wire Wire Line
	7150 4000 7150 4850
Wire Wire Line
	7150 4850 6000 4850
Wire Wire Line
	7150 4000 8350 4000
Wire Wire Line
	7050 4750 6000 4750
Wire Wire Line
	8750 4800 8750 5450
Wire Wire Line
	9050 2700 9050 1450
Wire Wire Line
	8350 3300 8050 3300
$Comp
L Device:R R3
U 1 1 5E70A083
P 6550 3200
F 0 "R3" V 6343 3200 50  0000 C CNN
F 1 "10k" V 6434 3200 50  0000 C CNN
F 2 "My_Misc:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal_larger_pads" V 6480 3200 50  0001 C CNN
F 3 "~" H 6550 3200 50  0001 C CNN
	1    6550 3200
	0    1    1    0   
$EndComp
$Comp
L Device:R R2
U 1 1 5E70F70C
P 6550 2850
F 0 "R2" V 6343 2850 50  0000 C CNN
F 1 "10k" V 6434 2850 50  0000 C CNN
F 2 "My_Misc:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal_larger_pads" V 6480 2850 50  0001 C CNN
F 3 "~" H 6550 2850 50  0001 C CNN
	1    6550 2850
	0    1    1    0   
$EndComp
Wire Wire Line
	6700 3200 6950 3200
Connection ~ 6950 3200
Wire Wire Line
	6400 3200 6300 3200
Wire Wire Line
	6300 3200 6300 2950
Connection ~ 6300 2950
Wire Wire Line
	6300 2950 7350 2950
$Comp
L Device:LED D1
U 1 1 5E71B66E
P 6550 1800
F 0 "D1" H 6543 2016 50  0000 C CNN
F 1 "LED" H 6543 1925 50  0000 C CNN
F 2 "My_Headers:2-pin_LED_header_large" H 6550 1800 50  0001 C CNN
F 3 "~" H 6550 1800 50  0001 C CNN
	1    6550 1800
	1    0    0    -1  
$EndComp
Wire Wire Line
	8050 1800 6700 1800
$Comp
L Device:R R1
U 1 1 5E71CD16
P 6550 2150
F 0 "R1" V 6343 2150 50  0000 C CNN
F 1 "330R" V 6434 2150 50  0000 C CNN
F 2 "My_Misc:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal_larger_pads" V 6480 2150 50  0001 C CNN
F 3 "~" H 6550 2150 50  0001 C CNN
	1    6550 2150
	0    1    1    0   
$EndComp
Wire Wire Line
	6000 5450 6950 5450
Wire Wire Line
	8050 1800 8050 3300
Wire Wire Line
	7050 4750 7050 3900
Wire Wire Line
	7050 3900 8350 3900
Wire Wire Line
	6950 3200 6950 5450
Connection ~ 6950 5450
Wire Wire Line
	6950 5450 8750 5450
$Comp
L Connector:RJ45 J1
U 1 1 5E711975
P 2050 3700
F 0 "J1" V 2153 3270 50  0000 R CNN
F 1 "RJ45" V 2062 3270 50  0000 R CNN
F 2 "My_Parts:RJ45_cabled_large" V 2050 3725 50  0001 C CNN
F 3 "~" V 2050 3725 50  0001 C CNN
	1    2050 3700
	0    -1   -1   0   
$EndComp
Wire Wire Line
	9800 5350 9800 3800
Wire Wire Line
	9800 1450 9050 1450
Wire Wire Line
	6000 5350 9800 5350
Wire Wire Line
	2350 2950 2350 3300
Wire Wire Line
	2350 2950 6300 2950
Wire Wire Line
	1950 2600 1950 3300
Wire Wire Line
	9350 3900 10750 3900
Wire Wire Line
	10750 3900 10750 3800
Wire Wire Line
	10750 1250 1850 1250
Wire Wire Line
	1850 1250 1850 3300
$Comp
L Device:R R4
U 1 1 5E72DD5E
P 10300 3800
F 0 "R4" V 10093 3800 50  0000 C CNN
F 1 "15k" V 10184 3800 50  0000 C CNN
F 2 "My_Misc:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal_larger_pads" V 10230 3800 50  0001 C CNN
F 3 "~" H 10300 3800 50  0001 C CNN
	1    10300 3800
	0    1    1    0   
$EndComp
Wire Wire Line
	10150 3800 9800 3800
Connection ~ 9800 3800
Wire Wire Line
	9800 3800 9800 1450
Wire Wire Line
	10450 3800 10750 3800
Connection ~ 10750 3800
Wire Wire Line
	10750 3800 10750 1250
Wire Wire Line
	7350 3600 7350 2950
Wire Wire Line
	7350 3600 8350 3600
Wire Wire Line
	7450 3500 7450 2600
Wire Wire Line
	7450 2600 6300 2600
Wire Wire Line
	7450 3500 8350 3500
Wire Wire Line
	6400 2850 6300 2850
Wire Wire Line
	6300 2850 6300 2600
Connection ~ 6300 2600
Wire Wire Line
	6300 2600 1950 2600
Wire Wire Line
	6700 2850 6950 2850
Connection ~ 6950 2850
Wire Wire Line
	6950 2850 6950 3200
Wire Wire Line
	6700 2150 6950 2150
Wire Wire Line
	5350 2150 6400 2150
Wire Wire Line
	5350 1800 5350 2150
Wire Wire Line
	5350 1800 6400 1800
Wire Wire Line
	6950 2150 6950 2850
Connection ~ 9050 1450
$Comp
L Connector:RJ45 J2
U 1 1 5E76C975
P 2050 4500
F 0 "J2" V 2061 4070 50  0000 R CNN
F 1 "RJ45" V 2152 4070 50  0000 R CNN
F 2 "My_Parts:RJ45_cabled_large" V 2050 4525 50  0001 C CNN
F 3 "~" V 2050 4525 50  0001 C CNN
	1    2050 4500
	0    -1   1    0   
$EndComp
$Comp
L My_Parts:Wind_vane U3
U 1 1 5E770C07
P 4550 6850
F 0 "U3" H 4022 6896 50  0000 R CNN
F 1 "Wind_vane" H 4022 6805 50  0000 R CNN
F 2 "My_Headers:2-pin_Wind_vane_header_large" H 4100 7400 50  0001 C CNN
F 3 "" H 4100 7400 50  0001 C CNN
	1    4550 6850
	-1   0    0    -1  
$EndComp
$Comp
L My_Parts:Anemometer U2
U 1 1 5E7848A3
P 4450 5900
F 0 "U2" H 4122 5946 50  0000 R CNN
F 1 "Anemometer" H 4122 5855 50  0000 R CNN
F 2 "My_Headers:2-pin_Anemometer_header_large" H 4200 6300 50  0001 C CNN
F 3 "" H 4200 6300 50  0001 C CNN
	1    4450 5900
	-1   0    0    -1  
$EndComp
$Comp
L My_Parts:Rain_bucket U1
U 1 1 5E7B3A0A
P 4400 5100
F 0 "U1" H 3972 5146 50  0000 R CNN
F 1 "Rain_bucket" H 3972 5055 50  0000 R CNN
F 2 "My_Headers:2-pin_Rain_bucket_header_large" H 4050 5500 50  0001 C CNN
F 3 "" H 4050 5500 50  0001 C CNN
	1    4400 5100
	-1   0    0    -1  
$EndComp
Wire Wire Line
	2050 5100 3650 5100
Wire Wire Line
	3650 5100 3650 4850
Wire Wire Line
	3650 4850 3850 4850
Wire Wire Line
	2050 4900 2050 5100
Wire Wire Line
	1950 4900 1950 5200
Wire Wire Line
	1950 5200 3650 5200
Wire Wire Line
	3650 5200 3650 5350
Wire Wire Line
	3650 5350 3850 5350
Wire Wire Line
	2250 4900 2250 5850
Wire Wire Line
	2250 5850 3650 5850
Wire Wire Line
	3650 5850 3650 5650
Wire Wire Line
	3650 5650 3850 5650
Wire Wire Line
	2350 5950 3650 5950
Wire Wire Line
	3650 5950 3650 6150
Wire Wire Line
	3650 6150 3850 6150
Wire Wire Line
	2150 4900 2150 6750
Wire Wire Line
	2150 6750 3850 6750
Wire Wire Line
	1850 4900 1850 6850
Wire Wire Line
	1850 6850 3850 6850
Wire Wire Line
	2350 4900 2350 5950
Text Notes 3200 6750 0    50   ~ 0
black
Text Notes 3200 6850 0    50   ~ 0
blue
Text Notes 3200 5850 0    50   ~ 0
yellow
Text Notes 3200 5950 0    50   ~ 0
red
Text Notes 3200 5200 0    50   ~ 0
red
Text Notes 3200 5100 0    50   ~ 0
blue
Wire Wire Line
	2050 1450 2050 3300
Wire Wire Line
	2250 3300 2250 1450
Connection ~ 2250 1450
Wire Wire Line
	2250 1450 2050 1450
Wire Wire Line
	6950 2150 6950 1550
Wire Wire Line
	6950 1550 2150 1550
Wire Wire Line
	2150 1550 2150 3300
Connection ~ 6950 2150
Wire Wire Line
	2250 1450 9050 1450
$EndSCHEMATC
