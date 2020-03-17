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
	9050 1450 4600 1450
Wire Wire Line
	4600 5850 6450 5850
Wire Wire Line
	6450 5850 6450 5350
Wire Wire Line
	6450 5350 6000 5350
$Comp
L Switch:SW_DPST_x2 SW?
U 1 1 5E70131E
P 6000 2950
F 0 "SW?" H 6000 3185 50  0000 C CNN
F 1 "SW_DPST_x2" H 6000 3094 50  0000 C CNN
F 2 "" H 6000 2950 50  0001 C CNN
F 3 "~" H 6000 2950 50  0001 C CNN
	1    6000 2950
	1    0    0    -1  
$EndComp
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
L Switch:SW_DPST_x2 SW?
U 1 1 5E70E15F
P 6000 2350
F 0 "SW?" H 6000 2585 50  0000 C CNN
F 1 "SW_DPST_x2" H 6000 2494 50  0000 C CNN
F 2 "" H 6000 2350 50  0001 C CNN
F 3 "~" H 6000 2350 50  0001 C CNN
	1    6000 2350
	1    0    0    -1  
$EndComp
Wire Wire Line
	7950 2350 6300 2350
Wire Wire Line
	5800 2350 4600 2350
$Comp
L Device:R R?
U 1 1 5E70F70C
P 6600 2600
F 0 "R?" V 6393 2600 50  0000 C CNN
F 1 "10k" V 6484 2600 50  0000 C CNN
F 2 "" V 6530 2600 50  0001 C CNN
F 3 "~" H 6600 2600 50  0001 C CNN
	1    6600 2600
	0    1    1    0   
$EndComp
Wire Wire Line
	6750 2600 6950 2600
Wire Wire Line
	6950 2600 6950 3200
Wire Wire Line
	6450 2600 6300 2600
Wire Wire Line
	6300 2600 6300 2350
Connection ~ 6300 2350
Wire Wire Line
	6300 2350 6200 2350
Wire Wire Line
	6700 3200 6950 3200
Connection ~ 6950 3200
Wire Wire Line
	6200 2950 6300 2950
Wire Wire Line
	5800 2950 4600 2950
Wire Wire Line
	6400 3200 6300 3200
Wire Wire Line
	6300 3200 6300 2950
Connection ~ 6300 2950
Wire Wire Line
	6300 2950 7850 2950
Wire Wire Line
	4600 1450 4600 2350
$Comp
L Device:LED D?
U 1 1 5E71B66E
P 6050 1800
F 0 "D?" H 6043 2016 50  0000 C CNN
F 1 "LED" H 6043 1925 50  0000 C CNN
F 2 "" H 6050 1800 50  0001 C CNN
F 3 "~" H 6050 1800 50  0001 C CNN
	1    6050 1800
	1    0    0    -1  
$EndComp
Wire Wire Line
	8050 1800 6200 1800
$Comp
L Device:R R?
U 1 1 5E71CD16
P 6600 2050
F 0 "R?" V 6393 2050 50  0000 C CNN
F 1 "330R" V 6484 2050 50  0000 C CNN
F 2 "" V 6530 2050 50  0001 C CNN
F 3 "~" H 6600 2050 50  0001 C CNN
	1    6600 2050
	0    1    1    0   
$EndComp
Wire Wire Line
	6750 2050 6950 2050
Wire Wire Line
	6950 2050 6950 2600
Connection ~ 6950 2600
Wire Wire Line
	6450 2050 5350 2050
Wire Wire Line
	5350 2050 5350 1800
Wire Wire Line
	5350 1800 5900 1800
Connection ~ 4600 2350
Wire Wire Line
	4600 2350 4600 2950
Connection ~ 4600 2950
Wire Wire Line
	6000 5450 6950 5450
Wire Wire Line
	4600 2950 4600 5850
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
Wire Wire Line
	7850 2950 7850 3600
Wire Wire Line
	7850 3600 8350 3600
Wire Wire Line
	8350 3500 7950 3500
Wire Wire Line
	7950 2350 7950 3500
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
Text Notes 2350 3100 0    50   ~ 0
D5
Text Notes 1050 5250 0    50   ~ 0
                 T-568B\n       --------------------------\nPin    Color                    Pin Name\n---    -------------                 -------- \n 1     Orange Stripe     Tx+\n 2     Orange                 Tx-\n 3     Green Stripe       Rx+\n 4     Blue                      Not Used\n 5     Blue Stripe         Not Used\n 6     Green                   Rx-\n 7     Brown Stripe     Not Used\n 8     Brown                  Not Used
Text Notes 2150 3300 0    50   ~ 0
-
Text Notes 2050 3300 0    50   ~ 0
+
$Comp
L Device:R R?
U 1 1 5E71AEF4
P 1950 2850
F 0 "R?" H 2020 2896 50  0000 L CNN
F 1 "10k" H 2020 2805 50  0000 L CNN
F 2 "" V 1880 2850 50  0001 C CNN
F 3 "~" H 1950 2850 50  0001 C CNN
	1    1950 2850
	1    0    0    -1  
$EndComp
Wire Wire Line
	1950 3300 1950 3000
Text Notes 1850 2300 0    50   ~ 0
A2
$Comp
L Device:R R?
U 1 1 5E71D9CA
P 1850 2050
F 0 "R?" H 1920 2096 50  0000 L CNN
F 1 "15k" H 1920 2005 50  0000 L CNN
F 2 "" V 1780 2050 50  0001 C CNN
F 3 "~" H 1850 2050 50  0001 C CNN
	1    1850 2050
	1    0    0    -1  
$EndComp
Text Notes 1850 1900 0    50   ~ 0
+
Wire Wire Line
	1850 3300 1850 2200
$Comp
L Device:R R?
U 1 1 5E720966
P 1750 1550
F 0 "R?" H 1820 1596 50  0000 L CNN
F 1 "5k" H 1820 1505 50  0000 L CNN
F 2 "" V 1680 1550 50  0001 C CNN
F 3 "~" H 1750 1550 50  0001 C CNN
	1    1750 1550
	1    0    0    -1  
$EndComp
Wire Wire Line
	1750 3300 1750 1700
Text Notes 1750 1400 0    50   ~ 0
+
Text Notes 1750 1800 0    50   ~ 0
D3
Text Notes 1950 3100 0    50   ~ 0
D4
Text Notes 1950 2700 0    50   ~ 0
-
Text Notes 2350 2700 0    50   ~ 0
-
$Comp
L Device:R R?
U 1 1 5E725988
P 2350 2850
F 0 "R?" H 2420 2896 50  0000 L CNN
F 1 "10k" H 2420 2805 50  0000 L CNN
F 2 "" V 2280 2850 50  0001 C CNN
F 3 "~" H 2350 2850 50  0001 C CNN
	1    2350 2850
	1    0    0    -1  
$EndComp
Text Notes 2250 3300 0    50   ~ 0
+
Wire Wire Line
	2350 3000 2350 3300
$EndSCHEMATC
