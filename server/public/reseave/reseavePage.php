<?php

$departure_time = date('Y/m/d h:i', strtotime('+' . 1 . 'day ' . ((2 / 2) + 6) . ':' . ((6 % 2) * 30)));

echo $departure_time;