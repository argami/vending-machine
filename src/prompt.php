<?php

require_once './vendor/autoload.php';

use vending\ui\ConsoleUI;

$console = new ConsoleUI();
$console->setDefaultValues();
$console->start();
