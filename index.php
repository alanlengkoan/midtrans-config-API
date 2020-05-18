<?php

$url    = '';
$data   = file_get_contents($url);
$result = json_decode($data, true);

echo 'Hello boys';