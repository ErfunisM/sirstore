<?php

defined('PA_EXEC') OR die('Payzito Restricted Access');

if(file_exists(dirname(__FILE__).DS.'handler.php'))
{
    include 'handler.php';
}