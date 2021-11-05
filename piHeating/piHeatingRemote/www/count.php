<?php

$sensorfile = '/home/pi/bin/piHeatingRemote/configs/sensors';

$sensors = file( $sensorfile, FILE_SKIP_EMPTY_LINES );

$count = count( $sensors );

print_r ( $count );
