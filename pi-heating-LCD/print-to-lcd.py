#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

import getopt, sys, time

from datetime import datetime

from modules import initialize_lcd, onError, usage

try:
    myopts, args = getopt.getopt(sys.argv[1:],
                                 'vh',
                                 ['verbose', 'help'])

except getopt.GetoptError as e:
    onError(1, str(e))
    
if len(sys.argv) == 1:  # no options passed
    onError(2, 2)
    
for option, argument in myopts:
    if option in ('-v', '--verbose'):  # verbose output
        verbose = True
    elif option in ('-h', '--help'):  # display help text
        usage(0)
    
#load lcd
lcd = initialize_lcd()

# clear screen and turn backlight on
lcd.clear()
lcd.set_backlight(1)

# display time
lcd.message(datetime.now().strftime('%b %d  %H:%M\n'))
time.sleep(5.0)

# clear screen and turn backlight off.
lcd.clear()
lcd.set_backlight(0)









