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
U 1 1 5E4000FE
P 5800 3150
F 0 "A1" H 5800 4331 50  0000 C CNN
F 1 "Arduino_UNO_R3" H 5800 4240 50  0000 C CNN
F 2 "My_Arduino:Arduino_UNO_R3_shield" H 5800 3150 50  0001 C CIN
F 3 "https://www.arduino.cc/en/Main/arduinoBoardUno" H 5800 3150 50  0001 C CNN
	1    5800 3150
	-1   0    0    -1  
$EndComp
$Comp
L Connector:AudioJack2_Ground_Switch J1
U 1 1 5E403A0A
P 2150 1650
F 0 "J1" H 2182 2075 50  0000 C CNN
F 1 "R1" H 2182 1984 50  0000 C CNN
F 2 "My_Misc:My_Jack_3.5mm_Ledino_KB3SPRS_Horizontal" H 2150 1850 50  0001 C CNN
F 3 "~" H 2150 1850 50  0001 C CNN
	1    2150 1650
	1    0    0    -1  
$EndComp
$Comp
L Connector:AudioJack2_Ground_Switch J3
U 1 1 5E4063C7
P 2150 5750
F 0 "J3" H 2182 6175 50  0000 C CNN
F 1 "T3" H 2182 6084 50  0000 C CNN
F 2 "My_Misc:My_Jack_3.5mm_Ledino_KB3SPRS_Horizontal" H 2150 5950 50  0001 C CNN
F 3 "~" H 2150 5950 50  0001 C CNN
	1    2150 5750
	1    0    0    -1  
$EndComp
$Comp
L Connector:AudioJack2_Ground_Switch J4
U 1 1 5E4064AD
P 8700 1450
F 0 "J4" H 8520 1468 50  0000 R CNN
F 1 "OneWire bus" H 8520 1377 50  0000 R CNN
F 2 "My_Misc:My_Jack_3.5mm_Ledino_KB3SPRS_Horizontal" H 8700 1650 50  0001 C CNN
F 3 "~" H 8700 1650 50  0001 C CNN
	1    8700 1450
	-1   0    0    -1  
$EndComp
$Comp
L Connector:AudioJack2_Ground_Switch J5
U 1 1 5E40C197
P 8700 2650
F 0 "J5" H 8520 2668 50  0000 R CNN
F 1 "LED sensor" H 8520 2577 50  0000 R CNN
F 2 "My_Misc:My_Jack_3.5mm_Ledino_KB3SPRS_Horizontal" H 8700 2850 50  0001 C CNN
F 3 "~" H 8700 2850 50  0001 C CNN
	1    8700 2650
	-1   0    0    -1  
$EndComp
Wire Wire Line
	5300 3350 4650 3350
$Comp
L Device:R R10
U 1 1 5E42DB7E
P 4200 1900
F 0 "R10" H 4270 1946 50  0000 L CNN
F 1 "33R" H 4270 1855 50  0000 L CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 4130 1900 50  0001 C CNN
F 3 "~" H 4200 1900 50  0001 C CNN
	1    4200 1900
	1    0    0    -1  
$EndComp
$Comp
L Connector:AudioJack2_Ground_Switch J2
U 1 1 5E405AED
P 2150 3650
F 0 "J2" H 2182 4075 50  0000 C CNN
F 1 "S2" H 2182 3984 50  0000 C CNN
F 2 "My_Misc:My_Jack_3.5mm_Ledino_KB3SPRS_Horizontal" H 2150 3850 50  0001 C CNN
F 3 "~" H 2150 3850 50  0001 C CNN
	1    2150 3650
	1    0    0    -1  
$EndComp
$Comp
L Device:R R3
U 1 1 5E443353
P 1800 2550
F 0 "R3" V 2007 2550 50  0000 C CNN
F 1 "10k" V 1916 2550 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 1730 2550 50  0001 C CNN
F 3 "~" H 1800 2550 50  0001 C CNN
	1    1800 2550
	0    -1   -1   0   
$EndComp
$Comp
L Device:R R4
U 1 1 5E443359
P 2500 2550
F 0 "R4" V 2707 2550 50  0000 C CNN
F 1 "10k" V 2616 2550 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 2430 2550 50  0001 C CNN
F 3 "~" H 2500 2550 50  0001 C CNN
	1    2500 2550
	0    -1   -1   0   
$EndComp
Wire Wire Line
	1100 800  1100 2550
Wire Wire Line
	1100 2550 1650 2550
Wire Wire Line
	1950 2550 2150 2550
Wire Wire Line
	5000 2550 2900 2550
Wire Wire Line
	2150 2250 2150 2550
Connection ~ 2150 2550
Wire Wire Line
	2150 2550 2350 2550
$Comp
L Device:CP C3
U 1 1 5E44A870
P 2500 3000
F 0 "C3" V 2755 3000 50  0000 C CNN
F 1 "10u" V 2664 3000 50  0000 C CNN
F 2 "Capacitor_THT:CP_Radial_D5.0mm_P2.50mm" H 2538 2850 50  0001 C CNN
F 3 "~" H 2500 3000 50  0001 C CNN
	1    2500 3000
	0    -1   -1   0   
$EndComp
Connection ~ 1100 2550
Wire Wire Line
	2150 3000 2150 2550
Wire Wire Line
	4200 2250 4200 2050
Wire Wire Line
	2150 2250 4200 2250
$Comp
L Device:R R11
U 1 1 5E469BEF
P 4200 3850
F 0 "R11" H 4270 3896 50  0000 L CNN
F 1 "33R" H 4270 3805 50  0000 L CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 4130 3850 50  0001 C CNN
F 3 "~" H 4200 3850 50  0001 C CNN
	1    4200 3850
	1    0    0    -1  
$EndComp
Wire Wire Line
	5300 3450 4200 3450
Wire Wire Line
	4200 3700 4200 3450
Wire Wire Line
	4200 4000 4200 4250
Wire Wire Line
	4200 4250 2150 4250
$Comp
L Device:R R1
U 1 1 5E46F044
P 1750 4550
F 0 "R1" V 1957 4550 50  0000 C CNN
F 1 "10k" V 1866 4550 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 1680 4550 50  0001 C CNN
F 3 "~" H 1750 4550 50  0001 C CNN
	1    1750 4550
	0    -1   -1   0   
$EndComp
$Comp
L Device:R R5
U 1 1 5E4700C7
P 2550 4550
F 0 "R5" V 2757 4550 50  0000 C CNN
F 1 "10k" V 2666 4550 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 2480 4550 50  0001 C CNN
F 3 "~" H 2550 4550 50  0001 C CNN
	1    2550 4550
	0    -1   -1   0   
$EndComp
$Comp
L Device:CP C1
U 1 1 5E4786AC
P 2550 5000
F 0 "C1" V 2805 5000 50  0000 C CNN
F 1 "10u" V 2714 5000 50  0000 C CNN
F 2 "Capacitor_THT:CP_Radial_D5.0mm_P2.50mm" H 2588 4850 50  0001 C CNN
F 3 "~" H 2550 5000 50  0001 C CNN
	1    2550 5000
	0    -1   -1   0   
$EndComp
Wire Wire Line
	1600 4550 1100 4550
Connection ~ 1100 4550
Wire Wire Line
	1900 4550 2150 4550
Wire Wire Line
	2150 4250 2150 4550
Connection ~ 2150 4550
Wire Wire Line
	2150 4550 2400 4550
Wire Wire Line
	5300 3550 4650 3550
Wire Wire Line
	4650 3550 4650 5550
Wire Wire Line
	4650 5550 4200 5550
$Comp
L Device:R R12
U 1 1 5E490841
P 4200 5950
F 0 "R12" H 4270 5996 50  0000 L CNN
F 1 "33R" H 4270 5905 50  0000 L CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 4130 5950 50  0001 C CNN
F 3 "~" H 4200 5950 50  0001 C CNN
	1    4200 5950
	1    0    0    -1  
$EndComp
Wire Wire Line
	4200 5800 4200 5550
Wire Wire Line
	4200 6100 4200 6400
Wire Wire Line
	4200 6400 2150 6400
Wire Wire Line
	2150 4550 2150 5000
Wire Wire Line
	2700 4550 2950 4550
Connection ~ 5000 4550
Wire Wire Line
	5000 4550 5000 2550
$Comp
L Device:R R2
U 1 1 5E4A04FC
P 1750 6700
F 0 "R2" V 1957 6700 50  0000 C CNN
F 1 "10k" V 1866 6700 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 1680 6700 50  0001 C CNN
F 3 "~" H 1750 6700 50  0001 C CNN
	1    1750 6700
	0    -1   -1   0   
$EndComp
$Comp
L Device:CP C2
U 1 1 5E4A0508
P 2550 7150
F 0 "C2" V 2805 7150 50  0000 C CNN
F 1 "10u" V 2714 7150 50  0000 C CNN
F 2 "Capacitor_THT:CP_Radial_D5.0mm_P2.50mm" H 2588 7000 50  0001 C CNN
F 3 "~" H 2550 7150 50  0001 C CNN
	1    2550 7150
	0    -1   -1   0   
$EndComp
Wire Wire Line
	1600 6700 1100 6700
Wire Wire Line
	1900 6700 2150 6700
Connection ~ 2150 6700
Wire Wire Line
	2150 6700 2400 6700
Wire Wire Line
	2150 6700 2150 7150
Wire Wire Line
	2700 6700 3000 6700
Wire Wire Line
	2150 6700 2150 6400
Wire Wire Line
	5000 4550 5000 6700
Wire Wire Line
	5000 4550 5700 4550
Wire Wire Line
	5700 4550 5700 4250
Wire Wire Line
	5600 800  7800 800 
Wire Wire Line
	7800 800  7800 1450
Connection ~ 5600 800 
Wire Wire Line
	8700 1750 8700 2000
Wire Wire Line
	8700 2000 10150 2000
Wire Wire Line
	2350 3650 2600 3650
Wire Wire Line
	2900 3650 2900 3450
Wire Wire Line
	2900 3450 4200 3450
Connection ~ 4200 3450
Wire Wire Line
	4200 5550 3000 5550
Wire Wire Line
	3000 5550 3000 5750
Wire Wire Line
	3000 5750 2550 5750
Connection ~ 4200 5550
Wire Wire Line
	7800 1450 7800 1750
Wire Wire Line
	7800 2650 8400 2650
Connection ~ 7800 1450
$Comp
L Device:R R13
U 1 1 5E4F8DCE
P 7350 1750
F 0 "R13" V 7557 1750 50  0000 C CNN
F 1 "4.7k" V 7466 1750 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 7280 1750 50  0001 C CNN
F 3 "~" H 7350 1750 50  0001 C CNN
	1    7350 1750
	0    -1   -1   0   
$EndComp
Wire Wire Line
	7200 1750 6850 1750
Wire Wire Line
	6850 1750 6850 1250
Wire Wire Line
	7500 1750 7800 1750
Connection ~ 7800 1750
Wire Wire Line
	7800 1750 7800 2650
Wire Wire Line
	5900 6200 10150 6200
$Comp
L Device:LED D1
U 1 1 5E520DA0
P 9150 3950
F 0 "D1" H 9143 3695 50  0000 C CNN
F 1 "Status LED" H 9143 3786 50  0000 C CNN
F 2 "LED_THT:LED_D5.0mm" H 9150 3950 50  0001 C CNN
F 3 "~" H 9150 3950 50  0001 C CNN
	1    9150 3950
	-1   0    0    1   
$EndComp
$Comp
L Device:LED D2
U 1 1 5E526E32
P 9150 4500
F 0 "D2" H 9143 4245 50  0000 C CNN
F 1 "Polled LED" H 9143 4336 50  0000 C CNN
F 2 "LED_THT:LED_D5.0mm" H 9150 4500 50  0001 C CNN
F 3 "~" H 9150 4500 50  0001 C CNN
	1    9150 4500
	-1   0    0    1   
$EndComp
$Comp
L Device:LED D3
U 1 1 5E52A4CF
P 9150 5050
F 0 "D3" H 9143 4795 50  0000 C CNN
F 1 "Pulse LED" H 9143 4886 50  0000 C CNN
F 2 "LED_THT:LED_D5.0mm" H 9150 5050 50  0001 C CNN
F 3 "~" H 9150 5050 50  0001 C CNN
	1    9150 5050
	-1   0    0    1   
$EndComp
Wire Wire Line
	9300 3950 10150 3950
Connection ~ 10150 3950
Wire Wire Line
	10150 3950 10150 4500
Wire Wire Line
	9300 4500 10150 4500
Connection ~ 10150 4500
Wire Wire Line
	10150 4500 10150 5050
Wire Wire Line
	9300 5050 10150 5050
Connection ~ 10150 5050
Wire Wire Line
	10150 5050 10150 6200
$Comp
L Device:R R15
U 1 1 5E53B609
P 8250 3950
F 0 "R15" V 8457 3950 50  0000 C CNN
F 1 "220R" V 8366 3950 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 8180 3950 50  0001 C CNN
F 3 "~" H 8250 3950 50  0001 C CNN
	1    8250 3950
	0    -1   -1   0   
$EndComp
$Comp
L Device:R R16
U 1 1 5E53C70A
P 8250 4500
F 0 "R16" V 8457 4500 50  0000 C CNN
F 1 "220R" V 8366 4500 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 8180 4500 50  0001 C CNN
F 3 "~" H 8250 4500 50  0001 C CNN
	1    8250 4500
	0    -1   -1   0   
$EndComp
$Comp
L Device:R R17
U 1 1 5E53F657
P 8250 5050
F 0 "R17" V 8457 5050 50  0000 C CNN
F 1 "220R" V 8366 5050 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 8180 5050 50  0001 C CNN
F 3 "~" H 8250 5050 50  0001 C CNN
	1    8250 5050
	0    -1   -1   0   
$EndComp
Wire Wire Line
	8400 3950 8750 3950
Wire Wire Line
	8400 4500 8750 4500
Wire Wire Line
	8400 5050 8750 5050
Wire Wire Line
	6300 3250 7000 3250
Wire Wire Line
	7000 3250 7000 3950
Wire Wire Line
	7000 3950 8100 3950
Wire Wire Line
	6300 3350 6900 3350
Wire Wire Line
	6900 3350 6900 4500
Wire Wire Line
	6900 4500 8100 4500
Wire Wire Line
	6300 3450 6800 3450
Wire Wire Line
	6800 3450 6800 5050
Wire Wire Line
	6800 5050 8100 5050
$Comp
L My_Headers:5-pin_3-pole_3,5mm_audio_header J6
U 1 1 5E58EE76
P 700 1700
F 0 "J6" H 679 2007 50  0000 C CNN
F 1 "5-pin_3-pole_3,5mm_audio_header" H 950 1400 50  0001 C CNN
F 2 "My_Headers:5-pin_3,5mm_audio_jack_header" H 1100 1300 50  0001 C CNN
F 3 "~" H 700 1700 50  0001 C CNN
	1    700  1700
	-1   0    0    -1  
$EndComp
$Comp
L My_Headers:5-pin_3-pole_3,5mm_audio_header J7
U 1 1 5E59BE1A
P 700 3550
F 0 "J7" H 679 3857 50  0000 C CNN
F 1 "5-pin_3-pole_3,5mm_audio_header" H 950 3250 50  0001 C CNN
F 2 "My_Headers:5-pin_3,5mm_audio_jack_header" H 1100 3150 50  0001 C CNN
F 3 "~" H 700 3550 50  0001 C CNN
	1    700  3550
	-1   0    0    -1  
$EndComp
$Comp
L My_Headers:5-pin_3-pole_3,5mm_audio_header J8
U 1 1 5E5A234B
P 700 5700
F 0 "J8" H 679 6007 50  0000 C CNN
F 1 "5-pin_3-pole_3,5mm_audio_header" H 950 5400 50  0001 C CNN
F 2 "My_Headers:5-pin_3,5mm_audio_jack_header" H 1100 5300 50  0001 C CNN
F 3 "~" H 700 5700 50  0001 C CNN
	1    700  5700
	-1   0    0    -1  
$EndComp
$Comp
L My_Headers:5-pin_3-pole_3,5mm_audio_header J9
U 1 1 5E5ABB60
P 10900 1450
F 0 "J9" H 11101 1437 50  0000 L CNN
F 1 "5-pin_3-pole_3,5mm_audio_header" H 11150 1150 50  0001 C CNN
F 2 "My_Headers:5-pin_3,5mm_audio_jack_header" H 11300 1050 50  0001 C CNN
F 3 "~" H 10900 1450 50  0001 C CNN
	1    10900 1450
	1    0    0    -1  
$EndComp
$Comp
L My_Headers:5-pin_3-pole_3,5mm_audio_header J10
U 1 1 5E5AD60C
P 10900 2550
F 0 "J10" H 11101 2537 50  0000 L CNN
F 1 "5-pin_3-pole_3,5mm_audio_header" H 11150 2250 50  0001 C CNN
F 2 "My_Headers:5-pin_3,5mm_audio_jack_header" H 11300 2150 50  0001 C CNN
F 3 "~" H 10900 2550 50  0001 C CNN
	1    10900 2550
	1    0    0    -1  
$EndComp
Wire Wire Line
	6850 1250 8200 1250
Wire Wire Line
	10150 1450 10150 950 
Wire Wire Line
	10150 950  8350 950 
Wire Wire Line
	8350 950  8350 1450
Connection ~ 8350 1450
Wire Wire Line
	8350 1450 8500 1450
Wire Wire Line
	8200 800  10350 800 
Wire Wire Line
	10350 800  10350 1250
Wire Wire Line
	8400 2650 8400 2300
Wire Wire Line
	8400 2300 10250 2300
Wire Wire Line
	10250 2300 10250 2550
Wire Wire Line
	10250 2550 10500 2550
Connection ~ 8400 2650
Wire Wire Line
	8400 2650 8500 2650
Wire Wire Line
	8200 2450 8200 2100
Wire Wire Line
	8200 2100 10450 2100
Wire Wire Line
	10450 2100 10450 2350
Wire Wire Line
	10450 2350 10600 2350
Connection ~ 8200 2450
Wire Wire Line
	8200 2450 8500 2450
Wire Wire Line
	900  5700 1500 5700
Wire Wire Line
	1500 5700 1500 6200
Wire Wire Line
	1500 6200 2550 6200
Wire Wire Line
	2550 6200 2550 5750
Connection ~ 2550 5750
Wire Wire Line
	2550 5750 2350 5750
Wire Wire Line
	900  3550 1500 3550
Wire Wire Line
	1500 3550 1500 4050
Wire Wire Line
	1500 4050 2600 4050
Wire Wire Line
	2600 4050 2600 3650
Connection ~ 2600 3650
Wire Wire Line
	2600 3650 2900 3650
Wire Wire Line
	900  1700 1500 1700
Wire Wire Line
	1500 1700 1500 2050
Wire Wire Line
	1500 2050 2650 2050
Wire Wire Line
	2650 1450 2650 1650
Wire Wire Line
	2650 1450 4200 1450
Wire Wire Line
	4650 1450 4650 3350
Wire Wire Line
	4200 1450 4200 1750
Connection ~ 4200 1450
Wire Wire Line
	4200 1450 4650 1450
Wire Wire Line
	2350 1650 2650 1650
Connection ~ 2650 1650
Wire Wire Line
	2650 1650 2650 2050
$Comp
L My_Headers:4-pin_3LED_header J11
U 1 1 5E6DC405
P 10800 4450
F 0 "J11" H 11017 4387 50  0000 L CNN
F 1 "4-pin_3LED_header" H 10800 4150 50  0001 C CNN
F 2 "My_Headers:4-pin_3_LED_header" H 11000 4050 50  0001 C CNN
F 3 "~" H 10800 4450 50  0001 C CNN
	1    10800 4450
	1    0    0    -1  
$EndComp
Wire Wire Line
	10150 6200 10500 6200
Wire Wire Line
	10500 6200 10500 4650
Wire Wire Line
	10500 4650 10600 4650
Connection ~ 10150 6200
Wire Wire Line
	8750 5050 8750 4700
Wire Wire Line
	8750 4700 10450 4700
Wire Wire Line
	10450 4700 10450 4550
Wire Wire Line
	10450 4550 10600 4550
Connection ~ 8750 5050
Wire Wire Line
	8750 5050 9000 5050
Wire Wire Line
	8750 4500 8750 4150
Wire Wire Line
	8750 4150 10300 4150
Wire Wire Line
	10300 4150 10300 4450
Wire Wire Line
	10300 4450 10600 4450
Connection ~ 8750 4500
Wire Wire Line
	8750 4500 9000 4500
Wire Wire Line
	8750 3950 8750 3600
Wire Wire Line
	8750 3600 10400 3600
Wire Wire Line
	10400 3600 10400 4350
Wire Wire Line
	10400 4350 10600 4350
Connection ~ 8750 3950
Wire Wire Line
	8750 3950 9000 3950
Wire Wire Line
	5700 4550 5900 4550
Connection ~ 5700 4550
Connection ~ 5900 4550
Wire Wire Line
	7800 1450 8350 1450
Wire Wire Line
	8200 800  8200 1250
Connection ~ 8200 1250
Wire Wire Line
	8200 1250 8500 1250
Wire Wire Line
	1100 2550 1100 4550
Wire Wire Line
	2150 3000 2350 3000
Wire Wire Line
	2650 3000 2900 3000
Wire Wire Line
	2900 3000 2900 2550
Connection ~ 2900 2550
Wire Wire Line
	2900 2550 2650 2550
$Comp
L Device:Q_Photo_NPN_CBE Q1
U 1 1 5E4D2B82
P 5800 7300
F 0 "Q1" H 5991 7346 50  0000 L CNN
F 1 "Q_Photo_NPN_CBE" H 5991 7255 50  0000 L CNN
F 2 "Package_TO_SOT_THT:TO-18-3" H 6000 7400 50  0001 C CNN
F 3 "~" H 5800 7300 50  0001 C CNN
	1    5800 7300
	1    0    0    -1  
$EndComp
Text Label 10700 2150 0    50   ~ 0
Emitter
Text Label 10700 2000 0    50   ~ 0
Collector
Text Label 6050 6950 0    50   ~ 0
Collector
Text Label 6100 7650 0    50   ~ 0
Emitter
Wire Wire Line
	5900 7100 5900 6950
Wire Wire Line
	5900 6950 6050 6950
Wire Wire Line
	5900 7500 5900 7650
Wire Wire Line
	5900 7650 6100 7650
Wire Notes Line
	5450 6800 5450 7700
Wire Notes Line
	5450 7700 6800 7700
Wire Notes Line
	6800 7700 6800 6800
Wire Notes Line
	6800 6800 5450 6800
Text Notes 5500 6900 0    50   ~ 0
LED sensor
$Comp
L Sensor_Temperature:DS18B20 U1
U 1 1 5E54F8DF
P 4150 7250
F 0 "U1" H 3920 7296 50  0000 R CNN
F 1 "DS18B20" H 3920 7205 50  0000 R CNN
F 2 "Package_TO_SOT_THT:TO-92_Inline" H 3150 7000 50  0001 C CNN
F 3 "http://datasheets.maximintegrated.com/en/ds/DS18B20.pdf" H 4000 7500 50  0001 C CNN
	1    4150 7250
	1    0    0    -1  
$EndComp
Text Label 4250 6850 0    50   ~ 0
Vdd
Text Label 4600 7250 0    50   ~ 0
Data
Text Label 4250 7650 0    50   ~ 0
GND
Wire Wire Line
	4150 6950 4150 6850
Wire Wire Line
	4150 6850 4250 6850
Wire Wire Line
	4450 7250 4600 7250
Wire Wire Line
	4150 7550 4150 7650
Wire Wire Line
	4150 7650 4250 7650
Wire Notes Line
	3500 6750 3500 7700
Wire Notes Line
	3500 7700 4800 7700
Wire Notes Line
	4800 7700 4800 6750
Wire Notes Line
	4800 6750 3500 6750
Text Notes 3550 6850 0    50   ~ 0
OneWire bus
Wire Wire Line
	10150 2000 10150 1650
Wire Wire Line
	10150 1650 10500 1650
Connection ~ 10150 2000
Wire Wire Line
	10500 2550 10500 2000
Wire Wire Line
	10500 2000 10700 2000
Connection ~ 10500 2550
Wire Wire Line
	10500 2550 10700 2550
Wire Wire Line
	10600 2350 10600 2150
Wire Wire Line
	10600 2150 10700 2150
Connection ~ 10600 2350
Wire Wire Line
	10600 2350 10700 2350
Wire Wire Line
	10150 1450 10450 1450
Wire Wire Line
	10350 1250 10400 1250
Wire Wire Line
	10150 2000 10150 3150
Text Label 10650 700  0    50   ~ 0
Data
Text Label 10650 850  0    50   ~ 0
Vdd
Text Label 10650 1000 0    50   ~ 0
GND
Wire Wire Line
	10400 1250 10400 700 
Wire Wire Line
	10400 700  10650 700 
Connection ~ 10400 1250
Wire Wire Line
	10400 1250 10700 1250
Wire Wire Line
	10450 1450 10450 850 
Wire Wire Line
	10450 850  10650 850 
Connection ~ 10450 1450
Wire Wire Line
	10450 1450 10700 1450
Wire Wire Line
	10500 1650 10500 1000
Wire Wire Line
	10500 1000 10650 1000
Connection ~ 10500 1650
Wire Wire Line
	10500 1650 10700 1650
$Comp
L Device:R R7
U 1 1 5E613A8C
P 8200 3150
F 0 "R7" V 7993 3150 50  0000 C CNN
F 1 "1k" V 8084 3150 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 8130 3150 50  0001 C CNN
F 3 "~" H 8200 3150 50  0001 C CNN
	1    8200 3150
	0    1    1    0   
$EndComp
Wire Wire Line
	8050 3150 7950 3150
Wire Wire Line
	7950 3150 7950 2450
Wire Wire Line
	7950 2450 8200 2450
Wire Wire Line
	8350 3150 10150 3150
Connection ~ 10150 3150
Wire Wire Line
	10150 3150 10150 3950
Wire Wire Line
	1100 800  5600 800 
Wire Wire Line
	2150 1950 2150 2250
Connection ~ 2150 2250
Wire Wire Line
	2150 3950 2150 4250
Connection ~ 2150 4250
Wire Wire Line
	2150 6400 2150 6050
Connection ~ 2150 6400
Wire Wire Line
	2150 6400 1350 6400
Wire Wire Line
	1350 6400 1350 5900
Wire Wire Line
	1350 5900 900  5900
Wire Wire Line
	2150 4250 1350 4250
Wire Wire Line
	1350 4250 1350 3750
Wire Wire Line
	1350 3750 900  3750
Wire Wire Line
	2150 2250 1350 2250
Wire Wire Line
	1350 2250 1350 1900
Wire Wire Line
	1350 1900 900  1900
Wire Wire Line
	1100 4550 1100 6700
Wire Wire Line
	2150 5000 2400 5000
Wire Wire Line
	2700 5000 2950 5000
Wire Wire Line
	2950 5000 2950 4550
Connection ~ 2950 4550
Wire Wire Line
	2950 4550 5000 4550
Wire Wire Line
	2150 7150 2400 7150
Wire Wire Line
	2700 7150 3000 7150
Wire Wire Line
	3000 7150 3000 6700
Connection ~ 3000 6700
Wire Wire Line
	3000 6700 5000 6700
Wire Wire Line
	5600 800  5600 2150
Wire Wire Line
	5900 4250 5900 4550
Wire Wire Line
	5900 4550 5900 6200
Wire Wire Line
	6300 2750 6850 2750
Connection ~ 6850 1750
Wire Wire Line
	6850 2750 6850 1750
$Comp
L Device:R R6
U 1 1 5E4A0502
P 2550 6700
F 0 "R6" V 2757 6700 50  0000 C CNN
F 1 "100k" V 2666 6700 50  0000 C CNN
F 2 "Resistor_THT:R_Axial_DIN0207_L6.3mm_D2.5mm_P10.16mm_Horizontal" V 2480 6700 50  0001 C CNN
F 3 "~" H 2550 6700 50  0001 C CNN
	1    2550 6700
	0    -1   -1   0   
$EndComp
$Comp
L Connector:Conn_01x02_Male J13
U 1 1 5E4D0334
P 7450 2950
F 0 "J13" H 7422 2878 50  0000 R CNN
F 1 "Conn_01x02_Male" H 7422 2923 50  0001 R CNN
F 2 "Connector_PinHeader_2.54mm:PinHeader_1x02_P2.54mm_Vertical" H 7450 2950 50  0001 C CNN
F 3 "~" H 7450 2950 50  0001 C CNN
	1    7450 2950
	-1   0    0    1   
$EndComp
$Comp
L Connector:Conn_01x02_Male J12
U 1 1 5E4F32DC
P 4750 1600
F 0 "J12" H 4858 1689 50  0000 C CNN
F 1 "Conn_01x02_Male" H 4858 1690 50  0001 C CNN
F 2 "Connector_PinHeader_2.54mm:PinHeader_1x02_P2.54mm_Vertical" H 4750 1600 50  0001 C CNN
F 3 "~" H 4750 1600 50  0001 C CNN
	1    4750 1600
	1    0    0    -1  
$EndComp
Wire Wire Line
	7950 2450 7100 2450
Wire Wire Line
	7100 2450 7100 2850
Wire Wire Line
	7100 2850 7250 2850
Connection ~ 7950 2450
Wire Wire Line
	6300 2950 7250 2950
Wire Wire Line
	7100 2450 6600 2450
Wire Wire Line
	6600 2450 6600 1600
Wire Wire Line
	6600 1600 4950 1600
Connection ~ 7100 2450
Wire Wire Line
	4950 1700 5150 1700
Wire Wire Line
	5150 1700 5150 3250
Wire Wire Line
	5150 3250 5300 3250
$EndSCHEMATC
