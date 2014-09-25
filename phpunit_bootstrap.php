<?php
/* 
 * E-detalj's Billmate API
 * PHPUnit Bootstrap
 * 
 * @author Johan Henriksson
 */
require_once __DIR__ . '/lib/autoload.php';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

/* Include Library */
require_once(__DIR__ . '/webshop/util/Constants.php');
require_once(__DIR__ . '/webshop/util/Functions.php');
require_once(__DIR__ . '/webshop/util/Exceptions.php');
?>
