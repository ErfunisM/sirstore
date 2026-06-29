<?php

defined('DS') OR define('DS',DIRECTORY_SEPARATOR);


if(!empty($GLOBALS['payzitoLibrariesIncluded']))
{
    return;
}

if(!isset($GLOBALS['notCheckPayzitoReady']))
{
    $readyFile = realpath(dirname(__FILE__).DS.'..'.DS.'setup'.DS.'ready.payzito');
    if(!$readyFile || !file_exists($readyFile))
    {
        return;
    }
}

$GLOBALS['payzitoLibrariesIncluded'] = true;

require_once dirname(__FILE__).DS.'licenseManager.php';

$license = new PALicenseManager();
if(!$license->isValid())
{
    return;
}

require_once dirname(__FILE__).DS.'init.php';