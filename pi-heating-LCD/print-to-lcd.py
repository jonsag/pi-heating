#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import getopt, sys, time

from datetime import datetime

from modules import (db_connect, db_create_cursor, db_close_cursor, db_disconnect, db_query, 
                     initialize_lcd, print_to_LCD, 
                     remove_leading_zero, random_chars, 
                     active_schedules, active_devices, process_schedules, 
                     onError, usage)

try:
    myopts, args = getopt.getopt(sys.argv[1:],
                                 'l'
                                 '1:2:'
                                 'g:'
                                 'vh',
                                 ['line1=', 'line2=', 'gpio=', 'light', 'verbose', 'help'])

except getopt.GetoptError as e:
    onError(1, str(e))
    
if len(sys.argv) == 1:  # no options passed
    onError(2, 2)
    
light = False
line_1 = ""
line_2 = ""
gpio = False
toggleMode = False
toggleTimer = False
stopModeTimer = False
verbose = False
    
for option, argument in myopts:     
    if option in ('-l', '--light'):  # turn backlight on
        light = True
    elif option in ('-1', '--line1'):  # first line of LCD
        line_1 = argument
    elif option in ('-2', '--line2'):  # second line of LCD
        line_2 = argument
    elif option in ('-g', '--gpio'):  # button 11 - light LCD
        gpio = argument
    elif option in ('-v', '--verbose'):  # verbose output
        verbose = True
    elif option in ('-h', '--help'):  # display help text
        usage(0)

if verbose:
    i = 1
    print "\n+++ Script run with:"
    for option, argument in myopts:     
        print "        Option %s: %s" % (i, option)
        print "        Argument %s: %s" % (i, argument)
        i += 1

# connect to database
cnx = db_connect(verbose)

# buttons
if gpio:
    print
    if gpio == "11":
        light = True
        if verbose:
            print "+++ Button 1 pressed, pin %s" % gpio
    elif gpio == "25":
        toggleMode = True
        light = True
        if verbose:
            print "+++ Button 2 pressed, pin %s" % gpio
    elif gpio == "7":
        toggleTimer = True
        light = True
        if verbose:
            print "+++ Button 3 pressed, pin %s" % gpio
    elif gpio == "8":
        stopModeTimer = True
        light = True
        if verbose:
            print "+++ Button 4 pressed, pin %s" % gpio
    else:
        onError(3, "No action for gpio %s" % gpio)

#load lcd
if light:
    lcd, lcd_wake_time, lcd_columns  = initialize_lcd(verbose)

# get first temperature
temp_query = "SELECT id, name, value FROM sensors LIMIT 1"
cursor = db_create_cursor(cnx)
temp_results = db_query(cursor, temp_query, verbose)
temp_id = temp_results[0][0]
temp_name = temp_results[0][1].strip()
temp_value = temp_results[0][2]
if verbose:
    print "\n+++ First temp: %s, ID: %s, Value: %s degrees" % (temp_name, temp_id, temp_value) 
db_close_cursor(cnx, cursor)

# get first mode
mode_query = "SELECT id, name, value FROM modes LIMIT 1"
cursor = db_create_cursor(cnx)
mode_results = db_query(cursor, mode_query, verbose)
mode_id = mode_results[0][0]
mode_name = mode_results[0][1]
mode_value = mode_results[0][2]
if verbose:
    print "+++ First mode: %s, ID: %s, Value: %s" % (mode_name, mode_id, mode_value)
db_close_cursor(cnx, cursor)
    
# get first timer
timer_query = "SELECT id, name, duration, value FROM timers LIMIT 1"
cursor = db_create_cursor(cnx)
timer_results = db_query(cursor, timer_query, verbose)
timer_id = timer_results[0][0]
timer_name = timer_results[0][1]
timer_duration = timer_results[0][2]
timer_value = timer_results[0][3]
if verbose:
    print "+++ First timer: %s, ID: %s, Value: %s min" % (timer_name, timer_id, timer_value)
db_close_cursor(cnx, cursor)
    
    
# toggle mode
if toggleMode:
    if verbose:
        print "\n+++ Toggling mode..."
    if not mode_value:
        if verbose:
            print "+++ Setting mode '%s' active..." % mode_name
        toggleMode_query = "UPDATE modes SET value = '1' WHERE id = '%s'" % mode_id
        mode_value = True
    else:
        if verbose:
            print "+++ Setting mode '%s' inactive..." % mode_name
        toggleMode_query = "UPDATE modes SET value = '0' WHERE id = '%s'" % mode_id
        mode_value = False
    cursor = db_create_cursor(cnx)
    db_query(cursor, toggleMode_query, verbose)
    db_close_cursor(cnx, cursor)

# toggle timer
if toggleTimer:
    if verbose:
        print "\n+++ Toggling timer..."
    if timer_value == 0:
        if verbose:
            print "+++ Starting timer '%s'..." % timer_name
        toggleTimer_query = "UPDATE timers SET value = '%s' WHERE id = '%s'" % (timer_duration, timer_id)
        timer_value = timer_duration
    else:
        if verbose:
            print "+++ Stopping timer '%s'..." % timer_name
        toggleTimer_query = "UPDATE timers SET value = '0' WHERE id = '%s'" % timer_id
        timer_value = 0
    cursor = db_create_cursor(cnx)
    db_query(cursor, toggleTimer_query, verbose)
    db_close_cursor(cnx, cursor)

# stop mode and timer
if stopModeTimer:
    if verbose:
        print "\n+++ Stopping mode and timer..."
    if mode_value:
        if verbose:
            print "+++ Setting mode '%s' inactive..." % mode_name
        stopMode_query = "UPDATE modes SET value = '0' WHERE id = '%s'" % mode_id
        mode_value = False
        cursor = db_create_cursor(cnx)
        db_query(cursor, stopMode_query, verbose)
        db_close_cursor(cnx, cursor)
    if timer_value != 0:
        if verbose:
            print "+++ Stopping timer '%s'..." % timer_name
        stopTimer_query = "UPDATE timers SET value = '0' WHERE id = '%s'" % timer_id
        timer_value = 0
        cursor = db_create_cursor(cnx)
        db_query(cursor, stopTimer_query, verbose)
        db_close_cursor(cnx, cursor)
     
# check and run schedules
timeNow = datetime.now()
activeNow, nextEvent = process_schedules(cursor, cnx, timeNow, False)
    
# what to write to lcd
if not line_1:
    day = remove_leading_zero(timeNow.strftime('%d'))
    month = remove_leading_zero(timeNow.strftime('%m'))
    hour = remove_leading_zero(timeNow.strftime('%H'))
    minute = timeNow.strftime('%m')
    line_1 = "%s/%s %s:%s %s" % (day, month, hour, minute, temp_value)
if not line_2:    
    if mode_value:
        line_2 = "%s" % (activeNow[0]['setPoint'])
    elif timer_value != 0:
        line_2 = "%s -%sm" % (activeNow[0]['setPoint'], timer_value)
    else:
        line_2 = "%s" % (activeNow[0]['setPoint'])
    #    #line_2 = random_chars()
    #    line_2 = str(temp_value)

# print to lcd
if light:   
    # clear screen and turn backlight on
    lcd.clear()
    lcd.set_backlight(1)
    if verbose:
        print "\n--- Backlight ON"
    
    # print to LCD
    print_to_LCD(lcd, 0, 0, "1", line_1, lcd_columns, verbose)
    print_to_LCD(lcd, 0, 1, "2", line_2, lcd_columns, verbose)

    if verbose:
        print "\n--- Wait %ss..." % lcd_wake_time
    time.sleep(lcd_wake_time)
        
    # clear screen and turn backlight off.
    lcd.clear()
    lcd.set_backlight(0)
    if verbose:
        print "\n--- Backlight OFF"
        
if verbose:
    print "\n+++ Active schedules:"
    active_schedules(cursor, cnx, verbose)
    print "\n+++ Active devices:"
    active_devices(cursor, cnx, verbose)

# close db
db_disconnect(cnx, verbose)




