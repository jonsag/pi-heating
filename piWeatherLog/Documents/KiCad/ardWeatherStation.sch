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
L MCU_Module:Arduino_UNO_R3 A?
U 1 1 5E6FB570
P 8850 3700
F 0 "A?" H 8850 4881 50  0000 C CNN
F 1 "Arduino_UNO_R3" H 8850 4790 50  0000 C CNN
F 2 "Module:Arduino_UNO_R3" H 8850 3700 50  0001 C CIN
F 3 "https://www.arduino.cc/en/Main/arduinoBoardUno" H 8850 3700 50  0001 C CNN
	1    8850 3700
	1    0    0    -1  
$EndComp
$Comp
L My_Headers:10-pin_header_LCD_interface J?
U 1 1 5E6FBAAB
P 5800 5150
F 0 "J?" H 5792 4335 50  0000 C CNN
F 1 "10-pin_header_LCD_interface" H 5792 4426 50  0000 C CNN
F 2 "" H 5700 4550 50  0001 C CNN
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
L Device:R R?
U 1 1 5E70A083
P 6550 3200
F 0 "R?" V 6343 3200 50  0000 C CNN
F 1 "10k" V 6434 3200 50  0000 C CNN
F 2 "" V 6480 3200 50  0001 C CNN
F 3 "~" H 6550 3200 50  0001 C CNN
	1    6550 3200
	0    1    1    0   
$EndComp
$Comp
L Device:R R?
U 1 1 5E70F70C
P 6550 2850
F 0 "R?" V 6343 2850 50  0000 C CNN
F 1 "10k" V 6434 2850 50  0000 C CNN
F 2 "" V 6480 2850 50  0001 C CNN
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
L Device:LED D?
U 1 1 5E71B66E
P 6550 1800
F 0 "D?" H 6543 2016 50  0000 C CNN
F 1 "LED" H 6543 1925 50  0000 C CNN
F 2 "" H 6550 1800 50  0001 C CNN
F 3 "~" H 6550 1800 50  0001 C CNN
	1    6550 1800
	1    0    0    -1  
$EndComp
Wire Wire Line
	8050 1800 6700 1800
$Comp
L Device:R R?
U 1 1 5E71CD16
P 6550 2150
F 0 "R?" V 6343 2150 50  0000 C CNN
F 1 "330R" V 6434 2150 50  0000 C CNN
F 2 "" V 6480 2150 50  0001 C CNN
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
L Connector:RJ45 J?
U 1 1 5E711975
P 2050 3700
F 0 "J?" V 2153 3270 50  0000 R CNN
F 1 "RJ45" V 2062 3270 50  0000 R CNN
F 2 "" V 2050 3725 50  0001 C CNN
F 3 "~" V 2050 3725 50  0001 C CNN
	1    2050 3700
	0    -1   -1   0   
$EndComp
Text Notes 3000 4100 0    50   ~ 0
                 T-568B\n       --------------------------\nPin    Color                    Pin Name\n---    -------------                 -------- \n 1     Orange Stripe     Tx+\n 2     Orange                 Tx-\n 3     Green Stripe       Rx+\n 4     Blue                      Not Used\n 5     Blue Stripe         Not Used\n 6     Green                   Rx-\n 7     Brown Stripe     Not Used\n 8     Brown                  Not Used
Text Notes 2150 3300 0    50   ~ 0
-
Text Notes 2050 3300 0    50   ~ 0
+
Wire Wire Line
	1750 3300 1750 2250
Text Notes 2250 3300 0    50   ~ 0
+
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
L Device:R R?
U 1 1 5E72DD5E
P 10300 3800
F 0 "R?" V 10093 3800 50  0000 C CNN
F 1 "15k" V 10184 3800 50  0000 C CNN
F 2 "" V 10230 3800 50  0001 C CNN
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
$Comp
L Device:R R?
U 1 1 5E7355D3
P 6550 2500
F 0 "R?" V 6343 2500 50  0000 C CNN
F 1 "5k" V 6434 2500 50  0000 C CNN
F 2 "" V 6480 2500 50  0001 C CNN
F 3 "~" H 6550 2500 50  0001 C CNN
	1    6550 2500
	0    1    1    0   
$EndComp
Wire Wire Line
	8350 3400 7550 3400
Wire Wire Line
	7550 3400 7550 2250
Wire Wire Line
	7550 2250 6300 2250
Wire Wire Line
	6400 2500 6300 2500
Wire Wire Line
	6300 2500 6300 2250
Connection ~ 6300 2250
Wire Wire Line
	6300 2250 1750 2250
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
Wire Wire Line
	6700 2500 7300 2500
Wire Wire Line
	7300 2500 7300 1450
Wire Wire Line
	7300 1450 9050 1450
Connection ~ 9050 1450
$Comp
L Connector:RJ45 J?
U 1 1 5E76C975
P 2050 4500
F 0 "J?" V 2061 4070 50  0000 R CNN
F 1 "RJ45" V 2152 4070 50  0000 R CNN
F 2 "" V 2050 4525 50  0001 C CNN
F 3 "~" V 2050 4525 50  0001 C CNN
	1    2050 4500
	0    -1   1    0   
$EndComp
$Comp
L My_Parts:Wind_vane U?
U 1 1 5E770C07
P 4550 6150
F 0 "U?" H 4022 6196 50  0000 R CNN
F 1 "Wind_vane" H 4022 6105 50  0000 R CNN
F 2 "" H 4100 6700 50  0001 C CNN
F 3 "" H 4100 6700 50  0001 C CNN
	1    4550 6150
	-1   0    0    -1  
$EndComp
$Comp
L My_Parts:Anemometer U?
U 1 1 5E7848A3
P 4450 7200
F 0 "U?" H 4122 7246 50  0000 R CNN
F 1 "Anemometer" H 4122 7155 50  0000 R CNN
F 2 "" H 4200 7600 50  0001 C CNN
F 3 "" H 4200 7600 50  0001 C CNN
	1    4450 7200
	-1   0    0    -1  
$EndComp
$Comp
L My_Parts:Rain_bucket U?
U 1 1 5E7B3A0A
P 4400 5100
F 0 "U?" H 3972 5146 50  0000 R CNN
F 1 "Rain_bucket" H 3972 5055 50  0000 R CNN
F 2 "" H 4050 5500 50  0001 C CNN
F 3 "" H 4050 5500 50  0001 C CNN
	1    4400 5100
	-1   0    0    -1  
$EndComp
$EndSCHEMATC
