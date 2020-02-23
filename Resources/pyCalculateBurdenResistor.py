#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8
from click.termui import clear

# import modules
import sys
from math import sqrt

from resistor import main


verbose = False

E12 = [1.0, 1.2, 1.5, 
       1.8, 2.2, 2.7, 
       3.3, 3.9, 4.7, 
       5.6, 6.8, 8.2]
E24 = [1.0, 1.1, 1.2, 
       1.3, 1.5, 1.6, 
       1.8, 2.0, 2.2, 
       2.4, 2.7, 3.0, 
       3.3, 3.6, 3.9, 
       4.3, 4.7, 5.1, 
       5.6, 6.2, 6.8, 
       7.5, 8.2, 9.1]
E96 = [1.00, 1.02, 1.05, 
       1.07, 1.10, 1.13, 
       1.15, 1.18, 1.21, 
       1.24, 1.27, 1.30, 
       1.33, 1.37, 1.40, 
       1.43, 1.47, 1.50, 
       1.54, 1.58, 1.62, 
       1.65, 1.69, 1.74, 
       1.78, 1.82, 1.87, 
       1.91, 1.96, 2.00, 
       2.05, 2.10, 2.16, 
       2.21, 2.26, 2.32, 
       2.37, 2.43, 2.49, 
       2.55, 2.61, 2.67, 
       2.74, 2.80, 2.87, 
       2.94, 3.01, 3.09, 
       3.16, 3.24, 3.32, 
       3.40, 3.48, 3.57, 
       3.65, 3.74, 3.83, 
       3.92, 4.02, 4.12, 
       4.22, 4.32, 4.42, 
       4.53, 4.64, 4.75, 
       4.87, 4.99, 5.11, 
       5.23, 5.36, 5.49, 
       5.62, 5.76, 5.90, 
       6.04, 6.19, 6.34, 
       6.49, 6.65, 6.81, 
       6.98, 7.15, 7.32, 
       7.50, 7.68, 7.87, 
       8.06, 8.25, 8.45, 
       8.66, 8.87, 9.09, 
       9.31, 9.53, 9.76]

def findClosestResistor(idealResistance, verbose):
    print "\nSingle resistor:"
    decade = 0
    difference = -1
    oldDifference = -1
    oldResistor = 0
    resistorFound = False
    
    while True:
        #print "Decade: %s" % decade
        for resistor in E12:
            thisResistor = resistor * 10 ** decade
            difference = (thisResistor - idealResistance) / idealResistance
            #print "%s%%" % (difference * 100)
            if difference > 0 and oldDifference < 0:
                resistorFound = True
                break
            else:
                oldDifference = difference
                oldResistor = thisResistor
                
        if resistorFound:
            break
        
        decade += 1
        if decade == 10:
            break
        
    
    print "+++ Closest in E12 series: %s ohm, %s%%" % (oldResistor, oldDifference * 100)
    print "                           %s ohm, %s%%" % (thisResistor, difference * 100)
    
    decade = 0
    difference = -1
    oldDifference = -1
    oldResistor = 0
    resistorFound = False
    
    while True:
        #print "Decade: %s" % decade
        for resistor in E24:
            thisResistor = resistor * 10 ** decade
            difference = (thisResistor - idealResistance) / idealResistance
            #print "%s%%" % (difference * 100)
            if difference > 0 and oldDifference < 0:
                resistorFound = True
                break
            else:
                oldDifference = difference
                oldResistor = thisResistor
                
        if resistorFound:
            break
        
        decade += 1
        if decade == 10:
            break
        
    
    print "\n+++ Closest in E24 series: %s ohm, %s%%" % (oldResistor, oldDifference * 100)
    print "                           %s ohm, %s%%" % (thisResistor, difference * 100)
    
    
    decade = 0
    difference = -1
    oldDifference = -1
    oldResistor = 0
    resistorFound = False
    
    while True:
        #print "Decade: %s" % decade
        for resistor in E96:
            thisResistor = resistor * 10 ** decade
            difference = (thisResistor - idealResistance) / idealResistance
            #print "%s%%" % (difference * 100)
            if difference > 0 and oldDifference < 0:
                resistorFound = True
                break
            else:
                oldDifference = difference
                oldResistor = thisResistor
                
        if resistorFound:
            break
        
        decade += 1
        if decade == 10:
            break
        
    
    print "\n+++ Closest in E96 series: %s ohm, %s%%" % (oldResistor, oldDifference * 100)
    print "                           %s ohm, %s%%" % (thisResistor, difference * 100)
    
print "\n\nThis will help you calculate the burden resistor for the YHDC SCT-013-000 CT sensor.\n\n"

while True:
    maxCurrent = raw_input("\nMax current (default: 100A) ? ")
    if not maxCurrent:
        maxCurrent = "100"
    
    try:
        maxCurrent = int(maxCurrent)
    except:
        print "%s is not an integer!\nTry again\n" % maxCurrent
    else:
        break
    
if verbose:
    print "--- Max current: %sA" % maxCurrent

primaryPeakCurrent = maxCurrent * sqrt(2)

if verbose:
    print "--- Primary peak current: %sA" % primaryPeakCurrent
            
while True:
    turns = raw_input("\nNumber of turns in your CT sensor (default: 2000) ? ")
    if not turns:
        turns = "2000"
    
    try:
        turns = int(turns)
    except:
        print "%s is not an integer!\nTry again\n" % turns
    else:
        break
    
if verbose:
    print "--- Turns: %s" % turns
            
secondaryPeakCurrent = primaryPeakCurrent / turns

if verbose:
    print "--- Secondary peak current: %sA" % secondaryPeakCurrent

while True:
    arduinoVoltage = raw_input("\nVoltage the Arduino is run on (default: 5V) ? ")
    if not arduinoVoltage:
        arduinoVoltage = "5"
    
    try:
        arduinoVoltage = float(arduinoVoltage)
    except:
        print "%s is not a float!\nTry again\n" % arduinoVoltage
    else:
        break
    
if verbose:
    print "--- Arduino voltage: %sV" % arduinoVoltage

idealBurdenResistance = (arduinoVoltage / 2) / secondaryPeakCurrent

print "\n+++ Ideal burden resistor: %s ohm" % idealBurdenResistance
    
findClosestResistor(idealBurdenResistance, verbose)
    
while True:
    print "\nCombining two resistors: \nWhat tolerance on resistor do you use?\n1: E12, 10%\n2: E24, 5%\n3: E96, 1%\n4: Exit"
    tolerance = raw_input("? ")
    if not tolerance:
        tolerance = "1"
    
    if tolerance == "1":
        tolerance = 10
        break
    elif tolerance == "2":
        tolerance = 5
        break
    elif tolerance == "3":
        tolerance = 1
        break
    elif tolerance == "4":
        sys.exit(0)
    else:
        print "%s is not a valid choice!\nTry again\n" % tolerance
    
    
if verbose:
    print "--- Resistor tolerance: %s%%" % tolerance
    
main(idealBurdenResistance, tolerance)

#print "\nE12 series: "
#for resistor in E12:
#    print resistor
    
#print "\nE24 series: "
#for resistor in E24:
#    print resistor    

#print "\nE96 series: "
#for resistor in E96:
#    print resistor
    
    
    
    
    
    
    
    
    
    
    
