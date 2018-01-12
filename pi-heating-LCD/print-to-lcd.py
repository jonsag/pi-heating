#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import getopt, sys, time

from datetime import datetime

from modules import db_connect, db_disconnect, db_query, initialize_lcd, print_to_LCD, onError, usage

try:
    myopts, args = getopt.getopt(sys.argv[1:],
                                 '1:'
                                 '2:'
                                 'l'
                                 'vh',
                                 ['line1:', 'line2', 'light', 'verbose', 'help'])

except getopt.GetoptError as e:
    onError(1, str(e))
    
if len(sys.argv) == 1:  # no options passed
    onError(2, 2)
    
light = False
line_1 = ""
line_2 = ""
verbose = False
    
for option, argument in myopts:
    if option in ('-l', '--light'):  # turn backlight on
        light = True
    elif option in ('-1', '--line1'):  # first line of LCD
        line_1 = argument
    elif option in ('-2', '--line2'):  # second line of LCD
        line_2 = argument
    elif option in ('-v', '--verbose'):  # verbose output
        verbose = True
    elif option in ('-h', '--help'):  # display help text
        usage(0)
    
#load lcd
if verbose:
    print "+++ Initializing LCD..."
lcd, lcd_wake_time, lcd_columns  = initialize_lcd()

# connect to database
if verbose:
    print "+++ Connecting to db..."
cnx, cursorread = db_connect()

# get first temperature
query = "SELECT value FROM sensors LIMIT 1"
results = db_query(cursorread, query)
temp = results[0][0]
    
#line_1 = datetime.now().strftime('%b %d %H:%M') # mon d h:m
#line_1 = datetime.now().strftime('%d/%m %H:%M') # dd/mm h:m

if not line_1:
    line_1 = "%s %s" % (datetime.now().strftime('%d/%m %H:%M'), temp)
if not line_2:
    line_2 = "Hej, hej Monica!!!"

if light:   
    # clear screen and turn backlight on
    lcd.clear()
    lcd.set_backlight(1)
    if verbose:
        print "--- Backlight ON"
    
    # print to LCD
    print_to_LCD(lcd, 0, 0, "1", line_1, lcd_columns, verbose)
    print_to_LCD(lcd, 0, 1, "2", line_2, lcd_columns, verbose)

    if verbose:
        print "--- Wait %ss..." % lcd_wake_time
    time.sleep(lcd_wake_time)
        
    # clear screen and turn backlight off.
    lcd.clear()
    lcd.set_backlight(0)
    if verbose:
        print "--- Backlight OFF"

# close db
if verbose:
    print "+++ Disconnecting from db..."
db_disconnect(cnx, cursorread)




