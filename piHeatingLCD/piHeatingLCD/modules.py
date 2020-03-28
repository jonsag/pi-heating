#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import os, sys, MySQLdb, time, datetime

import Adafruit_CharLCD as LCD

from ConfigParser import ConfigParser

config = ConfigParser()  # define config file
config.read("%s/config.ini" % os.path.dirname(os.path.realpath(__file__)))  # read config file

unicode_degree_sign = config.get('misc', 'unicode_degree_sign').strip(" ")


def onError(errorCode, extra):
    print "\nError %s" % errorCode
    if errorCode in (1, 12):
        print extra
        usage(errorCode)
    elif errorCode == 2:
        print "No options given"
        usage(errorCode)
    elif errorCode in (3, 4, 5, 7, 8, 9, 10, 11, 13):
        print extra
        sys.exit(errorCode)
    elif errorCode in (6, 14):
        print extra
        return

        
def usage(exitCode):
    print "\nUsage:"
    print "----------------------------------------"
    print "%s -1 <text line 1> -2 <text line 2>" % sys.argv[0]
    print "\nMisc options:"
    print "-v    verbose output"
    print "-h    prints this"

    sys.exit(exitCode)


def db_connect(verbose):
    if verbose:
        print "\n+++ Connecting to db..."
    dbconfig = ConfigParser()
    dbconfig.read('/home/pi/bin/piHeatingHub/config/config.ini')

    servername = dbconfig.get('db', 'server')
    username = dbconfig.get('db', 'user')
    password = dbconfig.get('db', 'password')
    dbname = dbconfig.get('db', 'database')

    cnx = MySQLdb.connect(host=servername, user=username, passwd=password, db=dbname, charset='utf8')
    # cnx.autocommit(True)

    return cnx


def db_create_cursor(cnx):
    cursor = cnx.cursor()
    
    return cursor


def db_close_cursor(cnx, cursor):
    cursor.close()
    cnx.commit()


def db_disconnect(cnx, verbose):
    if verbose:
        print "\n+++ Disconnecting from db..."
    cnx.close()


def db_query(cursor, query, verbose):
    cursor.execute(query)
    results = cursor.fetchall()
    
    return results


def db_update(cursor, query, verbose):
    cursor.execute(query)
    results = cursor.fetchall()
    
    return results


def initialize_lcd(verbose):
    if verbose:
        print "+++ Initializing LCD..."

    # read config for LCD
    lcd_rs = int(config.get('lcd', 'lcd_rs').strip(" "))
    lcd_en = int(config.get('lcd', 'lcd_en').strip(" "))
    lcd_d4 = int(config.get('lcd', 'lcd_d4').strip(" "))
    lcd_d5 = int(config.get('lcd', 'lcd_d5').strip(" "))
    lcd_d6 = int(config.get('lcd', 'lcd_d6').strip(" "))
    lcd_d7 = int(config.get('lcd', 'lcd_d7').strip(" "))
    lcd_backlight = int(config.get('lcd', 'lcd_backlight').strip(" "))

    lcd_columns = int(config.get('lcd', 'lcd_columns').strip(" "))
    lcd_rows = int(config.get('lcd', 'lcd_rows').strip(" "))
    
    lcd_wake_time = int(config.get('lcd', 'lcd_wake_time').strip(" "))
    
    # Initialize the LCD using the pins from config
    lcd = LCD.Adafruit_CharLCD(lcd_rs, lcd_en, lcd_d4, lcd_d5, lcd_d6, lcd_d7,
                           lcd_columns, lcd_rows, lcd_backlight)
    
    return lcd, lcd_wake_time, lcd_columns


def remove_leading_zero(string):
    if len(string) == 2:
        string = string.lstrip('0')
        
    return string


def degree_sign(lcd, cursor, row):
    # degree symbol
    lcd.create_char(1, [0b01100,
                        0b10010,
                        0b10010,
                        0b01100,
                        0b00000,
                        0b00000,
                        0b00000,
                        0b00000])
    
    lcd.set_cursor(cursor, row)
    
    lcd.message("\x01")
    
    return lcd

    
def hourglass_symbol(lcd, cursor, row):
    # hourglass
    lcd.create_char(2, [0b11111,
                        0b10001,
                        0b01110,
                        0b00100,
                        0b01010,
                        0b10001,
                        0b11111,
                        0b00000])
    
    lcd.set_cursor(cursor, row)
    
    lcd.message("\x02")
    
    return lcd


def infinity_symbol(lcd, cursor, row):
    # infinity
    lcd.create_char(3, [0b00000,
                        0b00000,
                        0b01010,
                        0b10101,
                        0b10101,
                        0b01010,
                        0b00000,
                        0b00000])
    
    lcd.set_cursor(cursor, row)
    
    lcd.message("\x03")
    
    return lcd


def print_to_LCD(lcd, cursor, row, line, message, lcd_columns, verbose):

    t = u"\u00b0"  # degree sign
    inf = u"\u221e"  # infinity symbol
    
    orig_length = len(message)
    if verbose:
        print "\nLine %s: '%s'" % (line, message)
        print "+++ Length: %s" % orig_length
    # else:
    #    print "%s" % (message)
        
    spaces = lcd_columns - orig_length
    
    if spaces > 0:
        message = message.ljust(16, ' ')
    if verbose:
        print "+++ Added %s space(s)" % spaces
    
    if t in message or inf in message:  # message contains special characters        
        message_list = list(message)
        for char in message_list:
            lcd.set_cursor(cursor, row)  # insert text at column and row
            if char == t:
                lcd = degree_sign(lcd, cursor, row)  # print degree sign
            elif char == inf:
                # lcd.message('e')
                lcd = infinity_symbol(lcd, cursor, row)  # print infinity sign
            else:
                lcd.message(char)
            cursor += 1

    else:    
        lcd.set_cursor(cursor, row)  # insert text at column and row
        lcd.message(message)
        
    if len(message) > lcd_columns:
        if verbose:
            print "--- Scrolling"
        for i in range(lcd_columns - orig_length):
            time.sleep(0.5)
            lcd.move_left()
            
            
def random_chars():
    import string
    import random
    
    count = random.randint(1, 16)
    
    message = ""
    for number in range(1, count):
        message = message + random.choice(string.letters)
        
    return message

    
def active_schedules(cursor, cnx, verbose):
    # Find devices that have active schedules
    cursor = db_create_cursor(cnx)
    query = "SELECT active, device_id, name  FROM schedules INNER JOIN sched_device ON schedules.id = sched_device.sched_id WHERE active = 1;"
    results_devices = db_update(cursor, query, verbose)
    db_close_cursor(cnx, cursor)
    
    for result in results_devices:
        DEVICE_ACTIVE = bool(result[0])
        DEVICE_ID = result[1] 
        DEVICE_NAME = result[2]
        if verbose:
            if DEVICE_ACTIVE:
                active = "active"
            else:
                active = "inactive"
            print "Schedule %s %s: %s" % (DEVICE_ID, DEVICE_NAME, active)

    
def active_devices(cursor, cnx, verbose):
    # find active devices
    cursor = db_create_cursor(cnx)
    query = ("SELECT name, pin, active_level, value, d_id FROM devices WHERE active_level IS NOT NULL;")
    results_devices = db_query(cursor, query, verbose)
    db_close_cursor(cnx, cursor)
    
    for result in results_devices:
        DEVICE_NAME = result[0]
        DEVICE_PIN = result[1]
        DEVICE_ACTIVE_LEVEL = bool(result[2])
        DEVICE_VALUE = bool(result[3])
        DEVICE_ID = result[4]
        
        if DEVICE_ACTIVE_LEVEL:
            active = "high"
        else:
            active = "low"
        
        if DEVICE_VALUE:
            value = "set"
        else:
            value = "not set"
        
        if 1 - (DEVICE_ACTIVE_LEVEL ^ DEVICE_VALUE):
            pin = "active"
        else:
            pin = "inactive"    
        
        if verbose:    
            print "Device %s %s, Pin %s, Active %s, Value %s, Pin %s" % (DEVICE_ID, DEVICE_NAME,
                                                                           DEVICE_PIN,
                                                                           active,
                                                                           value,
                                                                           pin)


def process_schedules(cursor, cnx, now, process, verbose):
    conclusions = []
    activeNow = []
    
    DOW = now.weekday()
    
    if verbose:
        print "\nTime: %s " % (str(now.hour) + ":" + str(now.minute))
    
    # connect to database
    cnx = db_connect(verbose)
    
    # Check schedule time and date
    cursor = db_create_cursor(cnx)
    query = ("SELECT * FROM schedules WHERE enabled ='1'")
    results_schedules = db_query(cursor, query, verbose)
    db_close_cursor(cnx, cursor)
    
    for result in results_schedules:
        SCHED_TEST_TIME = False
        SCHED_TEST_DAY = False
        SCHED_TEST_SENSORS = False
        SCHED_TEST_MODES = False
        SCHED_TEST_TIMERS = False
        
        SCHED_ID = str(result[0])
        SCHED_NAME = str(result[1])
        SCHED_START = result[2]
        SCHED_END = result[3]
        
        SCHED_MON = result[4]
        SCHED_TUE = result[5]
        SCHED_WED = result[6]
        SCHED_THU = result[7]
        SCHED_FRI = result[8]
        SCHED_SAT = result[9]
        SCHED_SUN = result[10]
        
        scheduleActive = result[11]
        
        if verbose:
            print "\nSchedule %s: %s" % (SCHED_ID, SCHED_NAME)
            print "----------------------------------------"
        
        SCHED_START_HOUR, start_remainder = divmod(SCHED_START.seconds, 3600)
        SCHED_START_MINUTE, start_sec = divmod(start_remainder, 60)
        
        SCHED_END_HOUR, stop_remainder = divmod(SCHED_END.seconds, 3600)
        SCHED_END_MINUTE, stop_sec = divmod(stop_remainder, 60)
        
        SCHED_START_STR = str(SCHED_START_HOUR) + ":" + str(SCHED_START_MINUTE)
        SCHED_END_STR = str(SCHED_END_HOUR) + ":" + str(SCHED_END_MINUTE)
        SCHED_NOW_STR = str(now.hour) + ":" + str(now.minute)
        
        TIME_NOW = datetime.datetime.strptime(SCHED_NOW_STR, "%H:%M")
        TIME_START = datetime.datetime.strptime(SCHED_START_STR, "%H:%M")
        TIME_END = datetime.datetime.strptime(SCHED_END_STR, "%H:%M")
        MIN_TO_START = TIME_NOW - TIME_START
        MIN_TO_END = TIME_END - TIME_NOW
        
        minToStart = MIN_TO_START.total_seconds() / 60
        minToEnd = MIN_TO_END.total_seconds() / 60
    
        if (MIN_TO_START.total_seconds() > 0 and MIN_TO_END.total_seconds() > 0):
            SCHED_TEST_TIME = True
        else:
            SCHED_TEST_TIME = False
          
        if verbose:
            print "Start time: %s, End time: %s, Test time: %s" % (SCHED_START_STR,
                                                                   SCHED_END_STR,
                                                                   SCHED_TEST_TIME)
            
        if (SCHED_MON and DOW == 0):
            SCHED_TEST_DAY = True
        elif(SCHED_TUE and DOW == 1):
            SCHED_TEST_DAY = True
        elif(SCHED_WED and DOW == 2):
            SCHED_TEST_DAY = True
        elif(SCHED_THU and DOW == 3):
            SCHED_TEST_DAY = True
        elif(SCHED_FRI and DOW == 4):
            SCHED_TEST_DAY = True
        elif(SCHED_SAT and DOW == 5):
            SCHED_TEST_DAY = True
        elif(SCHED_SUN and DOW == 6):
            SCHED_TEST_DAY = True
        else:
            SCHED_TEST_DAY = False
            
        if verbose:
            if SCHED_TEST_DAY:
                print "+++ Schedule is active today"
                print "Will start in %s" % MIN_TO_START
                print "Will stop in %s" % MIN_TO_END
        
        # Check sensor values
        if verbose:
            print "---------- Sensors ----------"
        cursor = db_create_cursor(cnx)
        query = "SELECT * FROM sensors INNER JOIN sched_sensor ON sensors.id=sched_sensor.sensor_id AND sched_sensor.sched_id='" + SCHED_ID + "'"
        results_sensors = db_query(cursor, query, verbose)
        db_close_cursor(cnx, cursor)    
        
        SCHED_TEST_SENSORS = True
        
        for result in results_sensors:
            if (result[4] != None):
                SENSOR_VALUE = float(result[4])
                SENSOR_TEST = str(result[9])
                TEST_VALUE = float(result[10])
                
                setPoint = TEST_VALUE
        
            if (SENSOR_TEST == '<' and SENSOR_VALUE < TEST_VALUE):
                if verbose:
                    print "+++ %s < %s" % (SENSOR_VALUE, TEST_VALUE)
                TEST = True
            elif(SENSOR_TEST == '=' and SENSOR_VALUE == TEST_VALUE):
                if verbose:
                    print "+++ %s = %s" % (SENSOR_VALUE, TEST_VALUE)
                TEST = True
            elif(SENSOR_TEST == '!' and SENSOR_VALUE != TEST_VALUE):
                if verbose:
                    print "+++ %s != %s" % (SENSOR_VALUE, TEST_VALUE)
                TEST = True
            elif(SENSOR_TEST == '>' and SENSOR_VALUE > TEST_VALUE):
                if verbose:
                    print "+++ %s < %s" % (SENSOR_VALUE, TEST_VALUE)
                TEST = True
            else:
                TEST = False
        
            if TEST == False:
                SCHED_TEST_SENSORS = False
            
            if SCHED_TEST_SENSORS and verbose:
                # print "Sensor value: %s" % SENSOR_VALUE
                # print "Sensor test: %s" % SENSOR_TEST
                # print "Test value: %s" % TEST_VALUE
                print "Schedule test sensors: %s" % SCHED_TEST_SENSORS
                
        # Check modes
        if verbose:
            print "---------- Modes ----------"
        
        cursor = db_create_cursor(cnx)
        query = "SELECT * FROM modes INNER JOIN sched_mode ON modes.id=sched_mode.mode_id AND sched_mode.sched_id='" + SCHED_ID + "'"
        results_modes = db_query(cursor, query, verbose)
        db_close_cursor(cnx, cursor)
        
        SCHED_TEST_MODES = True
         
        for result in results_modes:
            MODE_VALUE = bool(result[2])
            MODE_TEST = str(result[6])
            TEST_VALUE = bool(result[7])
          
            if (MODE_VALUE == TEST_VALUE):
                if verbose:
                    print "+++ %s == %s" % (MODE_VALUE, TEST_VALUE)
                TEST = True
            else:
                TEST = False
                
            if not TEST:
                SCHED_TEST_MODES = False
          
            if SCHED_TEST_MODES and verbose:
                # print "Mode value: %s" % MODE_VALUE
                # print "Mode test: %s" % MODE_TEST
                # print "Test value: %s" % TEST_VALUE
                print "Schedule test modes: %s" % SCHED_TEST_MODES
    
        # Check timers
        if verbose:
            print "---------- Timers ----------"
        
        cursor = db_create_cursor(cnx)
        query = "SELECT timers.value, sched_timer.value FROM timers INNER JOIN sched_timer ON timers.id = sched_timer.timer_id AND sched_timer.sched_id ='" + SCHED_ID + "'"
        results_timers = db_query(cursor, query, verbose)
        db_close_cursor(cnx, cursor)
          
        SCHED_TEST_TIMERS = True
         
        for result in results_timers:
            TIMER_VALUE = result[0]
            TEST_VALUE = result[1]
          
            if (TEST_VALUE and TIMER_VALUE > 0):
                if verbose:
                    print "+++ Test value set, and timer value > 0"
                TEST = True
            elif (not TEST_VALUE and TIMER_VALUE == 0):  # # Thanks to Alan Riley for spotting this.
                if verbose:
                    print "+++ Test value not set, and timer value == 0"
                TEST = True
            else:
                TEST = False
            
            if not TEST:
                SCHED_TEST_TIMERS = False
        
            if verbose:
                # print "Timer value: %s" % TIMER_VALUE
                # print "Test value: %s" % TEST_VALUE
                print "Schedule test timers: %s" % SCHED_TEST_TIMERS
              
                # print "Schedule test time: %s" % SCHED_TEST_TIME
                # print "Schedule test day: %s" % SCHED_TEST_DAY
                # print "Schedule test sensors: %s" % SCHED_TEST_SENSORS
                # print "Schedule test modes: %s" % SCHED_TEST_MODES
                # print "Schedule test timers: %s" % SCHED_TEST_TIMERS     
        
        # check if schedule is active
        
        if process:  # should we really set devices
            if (SCHED_TEST_TIME 
                and SCHED_TEST_DAY
                and SCHED_TEST_SENSORS 
                and SCHED_TEST_MODES 
                and SCHED_TEST_TIMERS):
                if verbose:
                    print "\nActivate schedule"
                scheduleActive = True    
                query = ("UPDATE schedules SET active = 1 WHERE id ='" + SCHED_ID + "'")
            else:
                if verbose:
                    print "\nDeactivate schedule"
                sheduleActive = False
                query = ("UPDATE schedules SET active = 0 WHERE id ='" + SCHED_ID + "'")
            
            cursor = db_create_cursor(cnx)
            results_timers = db_update(cursor, query, verbose)
            db_close_cursor(cnx, cursor)
            
        conclusions.append({'scheduleID': SCHED_ID,
                            'scheduleName': SCHED_NAME,
                            'minToStart': minToStart,
                            'minToEnd': minToEnd,
                            'testToday': SCHED_TEST_DAY,
                            'setPoint': setPoint,
                            'sensorCalls': SCHED_TEST_SENSORS,
                            'modeCalls': SCHED_TEST_MODES,
                            'timerCalls': SCHED_TEST_TIMERS,
                            'scheduleActive': scheduleActive})
            
        cursor = db_create_cursor(cnx)
        results_timers = db_update(cursor, query, verbose)
        db_close_cursor(cnx, cursor)
        
    # verbose = True    
    for conclusion in conclusions:
        if verbose:
            print "\nSchedule %s: %s\n--------------------" % (conclusion['scheduleID'], conclusion['scheduleName']) 
            print "Active today: %s" % conclusion['testToday']
            print "Minutes to start: %s" % conclusion['minToStart']
            print "Minutes to end: %s" % conclusion['minToEnd']
            # print "Set point: %s" % conclusion['setPoint']
            # print "Sensor calls: %s" % conclusion['sensorCalls']
            # print "Mode calls: %s" % conclusion['modeCalls']
            # print "Timer calls: %s" % conclusion['timerCalls']
            # print "Device active: %s" % conclusion['deviceActive']
        
        if conclusion['testToday'] and conclusion['modeCalls'] and conclusion['timerCalls']:
            activeNow.append(conclusion)
        
    if verbose:
        print        
    
    for schedule in activeNow:
        if verbose:
            print "+++ Schedule %s: %s is active" % (schedule['scheduleID'], schedule['scheduleName'])
            print "+++ Trying to reach %s degrees" % schedule['setPoint']
            if schedule['scheduleActive']:
                print "+++ Schedule is activated"
            else:
                print "+++ Schedule is not activated"
            print
            
    return activeNow

