#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import getopt, sys, time

from datetime import datetime, timedelta

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
        light = True
        line_1 = argument
    elif option in ('-2', '--line2'):  # second line of LCD
        light = True
        line_2 = argument
    elif option in ('-g', '--gpio'):  # button 11 - light LCD
        light = True
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
    if verbose:
        print
    if gpio == "18":
        if verbose:
            print "+++ Button 1 pressed, pin %s" % gpio
    elif gpio == "23":
        toggleMode = True
        if verbose:
            print "+++ Button 2 pressed, pin %s" % gpio
    elif gpio == "24":
        toggleTimer = True
        if verbose:
            print "+++ Button 3 pressed, pin %s" % gpio
    elif gpio == "25":
        stopModeTimer = True
        if verbose:
            print "+++ Button 4 pressed, pin %s" % gpio
    else:
        onError(3, "No action for gpio %s" % gpio)

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
db_close_cursor(cnx, cursor)systemctl daemon-reload
    
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
    
# find schedules that are not active all the time
schedule_query = "SELECT id, name FROM schedules WHERE dow1='0' OR dow2='0' OR dow3='0' OR dow4='0' OR dow5='0' OR dow6='0' OR dow7='0'"
cursor = db_create_cursor(cnx)
schedule_results = db_query(cursor, schedule_query, verbose)
for row in schedule_results:
    if verbose:
        print "\n+++ Schedule %s: %s is intermittent" % (row[0], row[1])
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
activeNow = process_schedules(cursor, cnx, timeNow, True, False)  # (cursor, cnx, timeNow, process, verbose)

if activeNow:
    for schedule in activeNow:
        currentSetPoint = schedule['setPoint']
        if verbose:
            print "\n+++ Schedule %s: %s is active" % (schedule['scheduleID'], schedule['scheduleName'])
            print "    Trying to reach %s degrees" % schedule['setPoint']
            # if schedule['scheduleActive']:
            #    print "+++ Schedule is activated"
            # else:
            #    print "+++ Schedule is not activated"
            # print
else:
    if verbose:
        print "+++ No active schedules now"

# checkUpcoming = True
# if checkUpcoming:       
#    newSetpointFound = False 
#    timeForward = timeNow
#    nextSetPoint = -1
#    for minutes in range(1, 10080, 60): # calculate what will happen the next week
#        if newSetpointFound:
#            break
#        timeForward = timeNow + timedelta(minutes = minutes)
#        if verbose:
#            day = remove_leading_zero(timeForward.strftime('%d'))
#            month = remove_leading_zero(timeForward.strftime('%m'))
#            hour = timeForward.strftime('%H')
#            minute = timeForward.strftime('%M')
#            print "+++ Testing time: %s/%s %s:%s" % (day, month, hour, minute)
#        activeNext = process_schedules(cursor, cnx, timeForward, False, False)
#        for schedule in activeNext:
#            if verbose:
#                print "    Set point: %s" % schedule['setPoint']
#            if schedule['setPoint'] != currentSetPoint:
#                nextSetPoint = schedule['setPoint']
#                newSetpointFound = True
#                break

#    print "+++ Next set point: %s" % nextSetPoint

# what will happen next

if not mode_value:  # mode is not set

    if timer_value != 0:  # timer is active
        timerEnd = (timeNow + timedelta(minutes=timer_value)).strftime('%H:%M')
        # what would happen if timer_value == 0
        
    # are there any upcoming schedules
            
# what to write to lcd
t = u"\u00b0"  # degree sign
inf = u"\u221e"  # infinity symbol

if not line_1:
    day = remove_leading_zero(timeNow.strftime('%d'))
    month = remove_leading_zero(timeNow.strftime('%m'))
    hour = timeNow.strftime('%H')
    minute = timeNow.strftime('%M')
    line_1 = "%s/%s %s:%s %s%s" % (day, month, hour, minute, temp_value, t)
if not line_2:    
    if mode_value:
        line_2 = "^^ %s%s %s" % (int(activeNow[0]['setPoint']), t, inf)
    elif timer_value != 0:
        line_2 = "-> %s%s @%s" % (int(activeNow[0]['setPoint']), t, timerEnd)
    else:
        line_2 = "%s%s %s" % (int(activeNow[0]['setPoint']), t, inf)
    #    #line_2 = random_chars()
    #    line_2 = str(temp_value)

# print to lcd
if light:
    lcd, lcd_wake_time, lcd_columns = initialize_lcd(verbose)  # load lcd
    
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

