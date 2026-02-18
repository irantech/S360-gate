<?php
/**
 * This file is completely optional and you can use it to manage the scopes for future.
 * At first following variables should be set to use in web services.
 *
 * @author Mojtaba Rahbari <mrahbari@infotech-co.com | mojtaba.rahbari@gmail.com>
 * @copyright &copy; from 2015 Infotech International Co.
 * @version 1.0.0
 * @date 2016/06/01 18:56:11 PM
 */

// Start the session
session_start();
$sessionId = session_id() . "ep";

$_SESSION[$sessionId]['GET'] = isset($_SESSION[$sessionId]['GET']) ? array_merge($_SESSION[$sessionId]['GET'], (array)$_GET) : (array)$_GET;
$_SESSION[$sessionId]['POST'] = isset($_SESSION[$sessionId]['POST']) ? array_merge($_SESSION[$sessionId]['POST'], (array)$_POST) : (array)$_POST;

/*
echo "<br>SESSION:<pre>";
print_r($_SESSION);
echo "</pre><hr>";

echo "<br>POST:<pre>";
print_r($_POST);
echo "</pre><hr>";

echo "<br>GET:<pre>";
print_r($_GET);
echo "</pre><hr>";*/
