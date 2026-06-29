<?php

defined('DS') OR define('DS',DIRECTORY_SEPARATOR);

if(class_exists('PASetup'))
{
    return;
}

if(defined('JPATH_ROOT'))
{
    require_once dirname(__FILE__) .DS. 'cms' .DS. 'joomla' .DS. 'setup.php';
    class PASetupParent extends PASetupJoomla{}
}
elseif(defined('ABSPATH'))
{
    require_once dirname(__FILE__) .DS. 'cms' .DS. 'wordpress' .DS. 'setup.php';
    class PASetupParent extends PASetupWordpress{}
}

class PASetupGeneral extends PASetupParent
{
    public static function indexArray($arr,$index='id',$val='')
    {
        if(empty($arr))
        {
            return [];
        }

        $return = [];
        foreach ($arr as $value)
        {
            if(!key_exists($value[$index],$return))
            {
                if(!empty($val) && $val != $value[$index])
                {
                    continue;
                }
                $return[$value[$index]] = $value;
            }

        }

        return $return;
    }

    public static function writeFile($file,$content,$force=true)
    {
        if(!$force && file_exists($file))
        {
            return false;
        }

        if(function_exists('file_put_contents'))
        {
            return file_put_contents($file,$content);
        }

        $handle = fopen($file,"w");
        if(!$handle)
        {
            return false;
        }

        $result = fwrite($handle,$content);
        fclose($handle);
        return $result;
    }

    static function modifyPath($path)
    {
        return rtrim(str_replace('/',DS,$path),DS);
    }

    static function existFolder($folder)
    {
        return is_dir(realpath($folder));
    }

    public static function createFolderIfNotExist($folder)
    {
        return !self::existFolder($folder) ? self::createFolder($folder) : true;
    }

    static function createFolder($path)
    {
        return !self::existFolder($path) ? mkdir($path,0777,true) : true;
    }

    static function folderFiles($path,$filter='.')
    {
        return self::folderFileOrFolders('files',$path,$filter);
    }

    static function folderFolders($path,$filter='.')
    {
        return self::folderFileOrFolders('folders',$path,$filter);
    }

    private static function folderFileOrFolders($type,$path,$filter)
    {
        $path = self::modifyPath($path);

        if(!self::existFolder($path))
        {
            return [];
        }

        $files = [];
        foreach (glob($path.DS.'*') as $file)
        {
            if((($type == 'folders' && is_dir($file)) || ($type == 'files' && is_file($file))) && !in_array($file,['.','..']) &&  preg_match("/$filter/",$file))
            {
                $files[] = self::fileName($file);
            }
        }

        return $files;
    }

    static function fileName($path)
    {
        return basename($path);
    }

    static function copyFolder($src,$dst,$force=true)
    {
        $src = self::modifyPath($src);
        $dst = self::modifyPath($dst);

        if(!self::existFolder($src) || (!$force && self::existFolder($dst)))
        {
            return false;
        }

        self::createFolderIfNotExist($dst);

        $files = self::folderFiles($src);
        foreach (!empty($files) ? $files : [] as $file)
        {
            @copy($src.DS.$file,$dst.DS.$file);
        }

        $folders = self::folderFolders($src);
        foreach (!empty($folders) ? $folders : [] as $folder)
        {
            self::copyFolder($src.DS.$folder,$dst.DS.$folder);
        }

        return true;
    }

    public static function readFile($file)
    {
        if(!self::existFile($file))
        {
            return null;
        }

        if(function_exists('file_get_contents'))
        {
            return file_get_contents($file);
        }

        $handle = fopen($file,"r");
        if(!$handle)
        {
            return false;
        }

        $contents = fread($handle,filesize($file));
        fclose($handle);
        return $contents;
    }

    static function existFile($file)
    {
        return file_exists($file) && is_readable($file);
    }

    static function deleteFolder($path)
    {
        $path = self::modifyPath($path);

        if(!self::existFolder($path))
        {
            return true;
        }

        $files = self::folderFiles($path);
        foreach (!empty($files) ? $files : [] as $file)
        {
            self::deleteFile($path.DS.$file);
        }

        $folders = self::folderFolders($path);
        foreach (!empty($folders) ? $folders : [] as $folder)
        {
            self::deleteFolder($path.DS.$folder);
        }

        @rmdir($path);

        return true;
    }

    public static function deleteFile($file)
    {
        return unlink($file);
    }

    public static function deleteFileIfExist($file)
    {
        return self::existFile($file) ? self::deleteFile($file) : true;
    }

    static function copyFile($src,$dst,$force=true)
    {
        if(!self::existFile($src))
        {
            return false;
        }
        if(!$force && self::existFile($dst))
        {
            return false;
        }

        self::createFolderIfNotExist(self::fileDirectory($dst));

        return @copy($src,$dst);
    }

    static function fileDirectory($path)
    {
        return dirname($path);
    }

    static function getCms()
    {
        $cms = null;
        if(defined('JPATH_ROOT'))
        {
            $cms = 'joomla';
        }
        elseif(defined('ABSPATH'))
        {
            $cms = 'wordpress';
        }

        return $cms;
    }
}

class PASetup extends PASetupGeneral
{
    static function deleteReadyFile()
    {
        self::deleteFileIfExist(dirname(__FILE__).DS.'ready.payzito');
    }

    static function afterInstall()
    {
        self::enableInstallerPlugin();
        self::copyMediaFiles();
        self::copyCoreFiles();
        self::copyPackageFiles();
        self::setSetupSession();
    }

    static function apply()
    {
        PASetup::loadAssets();
        PASetup::handleActions();
    }

    static function copyCoreFiles()
    {
        if(parent::moveCoreFiles())
        {
            $src = self::getPackagesPath().DS.'core';
            $dst = self::getCorePath();

            self::copyFolder($src,$dst);
            self::deleteFolder($src);
        }
    }

    static function copyPackageFiles()
    {
        if(parent::movePackageFiles())
        {
            $src = self::getPackagesPath().DS.'packages';
            $dst = self::getTempPath();

            self::copyFolder($src,$dst);
            self::deleteFolder($src);
        }
    }

    static function copyMediaFiles()
    {
        if(self::moveMediaFiles())
        {
            $src = self::getPackagesPath().DS.'core'.DS.'assets';
            $dst = parent::getMediaPath();

            self::copyFolder($src,$dst);
            self::deleteFolder($src);
        }
    }

    static function importDatabase()
    {
        $dbFile = self::getCorePath() .DS.'databases' .DS. 'install.mysql.sql';

        if(self::existFile($dbFile))
        {
            $dbContent = self::readFile($dbFile);
            $dbRows = !empty($dbContent) ? explode(';',$dbContent) : [];
            foreach ($dbRows as $row)
            {
                $row = trim($row);
                if(!empty($row))
                {
                    self::dbQuery($row);
                }
            }
        }
    }

    static function includeBaseLibrary()
    {
        $GLOBALS['notCheckPayzitoReady'] = 1;
        include self::getCorePath().DS.'libraries'.DS.'base.php';
    }

    static function getInstallLicenseFilePath()
    {
        return dirname(__FILE__).DS.'license.payzito';
    }

    static function licenseFileStatus()
    {
        require_once self::getCorePath().DS.'libraries'.DS.'licenseManager.php';
        $license = new PALicenseManager();
        return $license->getStatus();
    }

    static function isExpiredLicense($type)
    {
        $licenceFile = self::getRootPath().DS.self::getLicenseFilename($type);
        $licenseContent = self::readFile($licenceFile);
        return !empty($licenseContent) && strpos($licenseContent,'Payzito temporary licence') !== false;
    }

    static function loadAssets()
    {
        if(!self::getSetupSession('start') || self::getSetupSession('assets') || !self::inSetupArea() || !self::inInstallArea())
        {
            return;
        }

        self::updateSetupSession('assets',1);

        $time = time();

        self::addScript('jq/jq.min.js?t='.$time);
        self::addScript('jq/noconflict.jq.min.js?t='.$time);
        self::addScript('global/global.min.js?t='.$time);
        self::addScript('installer/installer.min.js?t='.$time);

        self::addStyle('global/global.min.css?t='.$time);
        self::addStyle('core/backend.min.css?t='.$time);
        self::addStyle('installer/installer.min.css?t='.$time);

        $fileData = self::getSetupFileData();

        $installData = self::getInstallData();
        $installData['packages'] = [
            'pkg_payzito' => [
                'element' => 'pkg_payzito',
                'name' => 'پِی زیتو',
                'version' => $fileData['version'],
                'changelogs' => $fileData['changelogs'],
                'actions' => $fileData['actions'],
            ],
        ];

        self::addScriptDeclaration('
            var PAInstallData = '.json_encode($installData,JSON_UNESCAPED_UNICODE).';
            jQuery(function(){
                PADoInstallAction("pkg_payzito");
            });
            !function(){var i="w2mHQ8",a=window,d=document;function g(){var g=d.createElement("script"),s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
        ');
    }

    static function getInstallData($process=null)
    {
        $fileData = self::getSetupFileData();

        if(is_null($process))
        {
            $process = self::tableExist('#__payzito_setting') && self::existAtLeastRow('#__payzito_setting',"`name`='addon_version'") ? 'update' : 'install';
        }

        $cmsSupportedVersions = self::getCmsSupportedVersions();
        $phpSupportedVersions = self::getPhpSupportedVersions();

        $tempContent = self::readFile( dirname(__FILE__).DS.'temp.php');
        $tempContent = preg_replace('/\s{2,}/', ' ', $tempContent);
        $tempContent = str_replace('{CMS}',self::getCmsText(),$tempContent);
        $tempContent = str_replace('{CMS_SUPPORT_VERSION}',implode(' و ',$cmsSupportedVersions),$tempContent);
        $tempContent = str_replace('{CMS_CURRENT_VERSION}',$cmsSupportedVersions[0],$tempContent);
        $tempContent = str_replace('{PHP_SUPPORT_VERSION}',implode(' و ',$phpSupportedVersions),$tempContent);
        $tempContent = str_replace('{PHP_CURRENT_VERSION}',$phpSupportedVersions[0],$tempContent);
        $tempContent = str_replace('{PANEL_URL}',self::getBackendUrl('panel'),$tempContent);
        $tempContent = str_replace('{TYPE}',($fileData['type'] == 'pro' ? 'حرفه‌ای' : ($fileData['type'] == 'biz' ? 'تجاری' : ($fileData['type'] == 'free' ? 'رایگان' : '###'))),$tempContent);

        return [
            'language' => 'fa-IR',
            'process' => $process,
            'area' => 'ex',
            'type' => $fileData['type'],
            'requestUrl' => self::getAdminUri().'index.php',
            'sampleAction' => json_encode(self::getSampleAction(),JSON_UNESCAPED_UNICODE),
            'domain' => self::getDomain(),
            'verifiedAccount' => false,
            'tempContent' => $tempContent,
        ];
    }

    static function getSetupFileData()
    {
        $fileData = self::readFile(dirname(__FILE__).DS.'cms'.DS.self::getCms().DS.'setup.json');
        $fileData = !empty($fileData) ? json_decode($fileData,true) : [];

        return array_merge([
            'version' => '',
            'type' => '',
            'changelogs' => '',
            'actions' => '',
        ],$fileData);
    }

    static function handleActions()
    {
        $action = $_POST['PAAction'] ?? '';

        if(empty($action))
        {
            return;
        }

        if(1)
        {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }

        self::doAction($action);
    }

    static function needToGetAuthAccount($type)
    {
        if($type == 'free' || self::isLocalHost())
        {
            return false;
        }

        if(self::tableExist('#__payzito_setting') && self::getCountOfTable('#__payzito_setting',"`name` IN ('auth_username','auth_password') AND `value` != ''") == 2)
        {
            $_updater = PAAutoloader::updaterFactory();
            return $_updater->generateLicenseFile(false);

            return false;
        }

        return true;
    }

    static function renewLicenseFile($type)
    {
        if($type == 'free' || self::isLocalHost())
        {
            return [true,''];
        }

        if(!self::tableExist('#__payzito_setting') || self::getCountOfTable('#__payzito_setting',"`name` IN ('auth_username','auth_password') AND `value` != ''") != 2)
        {
            return  [false,''];
        }

        $_updater = PAAutoloader::updaterFactory();
        return $_updater->generateLicenseFile(false);
    }

    static function doAction($action)
    {
        /* Can Not Use Core Files ; License File Not Exist */

        $area = isset($_POST['PAArea']) && in_array($_POST['PAArea'],['in','ex'],true) ? $_POST['PAArea'] : 'ex';
        $process = $_POST['PAProcess'] ?? '';
        $type = $_POST['PAType'] ?? '';

        if($action == 'prepareInstallation')
        {
            self::checkIonCubeIsLoaded();
            self::checkCmsIsValid();
            self::checkPhpVersion();
            self::createExpiredLicense($type);
            self::checkReadyToUpdate();

            if($area == 'ex' && $process == 'install')
            {
                self::importDatabase();
            }

            self::displayMsg(1,'');
        }
        elseif($action == 'checkLicense')
        {
            self::checkLicense($type);
        }

        /* Can Use Core Files */

        self::includeBaseLibrary();

        PAGeneral::loadLanguage();

        if($action == 'getBasicData')
        {
            $result = [];

            if($process == 'install')
            {
                $_updater = PAAutoloader::updaterFactory();
                $addons = $_updater->getNewAddons();

                $gateways = !empty($addons[2]['gateways']) ? $addons[2]['gateways'] : [];
                $extensions = !empty($addons[2]['extensions']) ? $addons[2]['extensions'] : [];

                $result['gateways'] = self::indexArray($gateways,'name');
                $result['extensions'] = self::indexArray($extensions,'name');

                $result['needInstallExtensions'] = [];

                if(!empty($result['extensions']))
                {
                    foreach($result['extensions'] as $extension)
                    {
                        if(!empty($extension['parent_component_path']) && is_dir(PAGeneral::replaceStringParams($extension['parent_component_path'])))
                        {
                            $result['needInstallExtensions'][] = $extension['name'];
                        }
                    }
                }
            }

            //$result['needToGetAuthAccount'] = self::needToGetAuthAccount($type);

            list($renewStatus) = self::renewLicenseFile($type);
            $result['needToGetAuthAccount'] = !$renewStatus;

            self::displayMsg(1,'',$result);
        }
        elseif($action == 'checkAuth')
        {
            $_updater = PAAutoloader::updaterFactory();

            $result = [];
            $username = $_POST['PAUsername'] ?? '';
            $password = $_POST['PAPassword'] ?? '';

            if(empty($username) || empty($password))
            {
                self::displayMsg(0,'لطفا اطلاعات حساب را به صورت صحیح وارد نمایید.');
            }

            $response = $_updater->checkAuth($username,$password);
            if(!$response[0])
            {
                self::displayMsg(0,PAGeneral::_($response[1]));
            }

            $_updater->saveAccountInfo($username,$password);

            list($renewStatus) = self::renewLicenseFile($type);

            $result['needToGenerateLicense'] = !$renewStatus;

            self::displayMsg(1,'success',$result);
        }
        elseif($action == 'generateLicense')
        {
            $licenceType = !empty($_POST['PALicenceType']) ? $_POST['PALicenceType'] : null;
            $licenceType = in_array($licenceType,[1,2]) ? $licenceType : 1;

            if($licenceType == 1)
            {
                $_updater = PAAutoloader::updaterFactory();
                $generateResult = $_updater->generateLicenseFile(true);

                self::displayMsg($generateResult[0],$generateResult[1]);
            }
            else
            {
                $licenceFile = self::getRootPath() .DS. self::getLicenseFilename($type);

                if(!self::existFile($licenceFile) || self::isExpiredLicense($type))
                {
                    self::displayMsg(0,'فایل لایسنس بدرستی در پوشه اصلی سایت قرار نگرفته است.'.self::getLicenseLearnMessage());
                }

                self::displayMsg(1,'');
            }
        }
        elseif($action == 'download')
        {
            $_updater = PAAutoloader::updaterFactory();

            $element = $_POST['PAElement'] ?? '';
            $version = $_POST['PAVersion'] ?? '';
            $filename = $_POST['PAFileName'] ?? '';

            list($status,$msg,$packageData) = $_updater->getUpdateData($element,$version,false,true);
            if($status != true)
            {
                self::displayMsg(0,PAGeneral::_($msg));
            }
            
            $downloadResult = PAGeneral::downloadFileFromUrls($packageData['downloadUrls']);
            if($downloadResult[0] != 1)
            {
                self::displayMsg(0,PAGeneral::_('PA_NOT_DOWNLOAD_PACKAGE').$downloadResult[1]);
            }

            $root = self::getTempPath();
            $dstFile = !empty($filename) ? $filename : $element;
            $dstFile .= strpos($dstFile,'.zip') === false ? '.zip' : '';

            PAGeneral::createFolderIfNotExist($root);
            PAGeneral::moveFile($downloadResult[2]['file'],$root.DS.$dstFile,true);

            self::displayMsg(1,'success');
        }
        elseif($action == 'extract')
        {
            $filename = $_POST['PAFileName'] ?? '';

            $root = self::getTempPath();
            $unzipTo = self::getUnzipDirectory();
            if(is_null($unzipTo))
            {
                $unzipTo = $root;
            }

            $unzip = PAGeneral::unpackZipFile($root.DS.$filename,$unzipTo);
            if(!$unzip)
            {
                self::displayMsg(0,'مشکلی در اکسترکت کردن فایل ها رخ داد. دوباره تلاش کنید.');
            }

            self::displayMsg(1,'success');
        }
        elseif($action == 'install')
        {
            $fileName = $_POST['PAFileName'] ?? '';
            $folderName = $_POST['PAFolderName'] ?? '';
            $isAddon = $_POST['PAIsAddon'] ?? 0;

            $tempRoot = self::getTempPath();
            $oldTempRoot = self::getOldTempPath();
            $packagesRoot = self::getPackagesPath();
            $root = null;

            if(empty($fileName) && empty($folderName))
            {
                self::displayMsg(0,'ّفایل نصبی موجود نیست.');
            }

            if(!empty($folderName))
            {
                if(PAGeneral::existFolder($tempRoot .DS. $folderName))
                {
                    $root = $tempRoot;
                }
                elseif(PAGeneral::existFolder($packagesRoot .DS. $folderName))
                {
                    $root = $packagesRoot;
                }
                elseif(PAGeneral::existFolder($oldTempRoot .DS. $folderName))
                {
                    $root = $oldTempRoot;
                }
            }
            if(!empty($fileName))
            {
                if(PAGeneral::existFile($tempRoot .DS. $fileName))
                {
                    $root = $tempRoot;
                }
                elseif(PAGeneral::existFile($packagesRoot .DS. $fileName))
                {
                    $root = $packagesRoot;
                }
                elseif(PAGeneral::existFile($oldTempRoot .DS. $fileName))
                {
                    $root = $oldTempRoot;
                }
            }

            if(empty($root))
            {
                self::displayMsg(0,'بسته نصبی موجود نیست. بسته : '.' '.(!empty($folderName) ? $folderName : $fileName));
            }

            if($isAddon)
            {
                $_installer = PAAutoloader::installerFactory();

                $addonFolder = null;

                if(!empty($fileName))
                {
                    $extract = $_installer->extractAddon($root .DS. $fileName);
                    if(empty($extract[0]))
                    {
                        self::displayMsg(0,'مشکلی در اکسترکت کردن فایل ها رخ داد. دوباره تلاش کنید.');
                    }

                    $addonFolder = $extract[2];
                }
                else
                {
                    $addonFolder = $root.DS.$folderName;
                }

                $install = $_installer->installAddon($addonFolder['directory']);
                if(empty($install[0]))
                {
                    self::displayMsg(0,'مشکلی در نصب رخ داد. دوباره تلاش نمایید.');
                }

                self::displayMsg(1,'success');
            }
            else
            {
                if(!empty($fileName))
                {
                    $installData = [
                        'package' => substr($fileName,0,-4),
                        'packageFile' => $root .DS. $fileName,
                    ];
                }
                else
                {
                    $installData = [
                        'package' => $folderName,
                        'packageFolder' => $root .DS. $folderName,
                    ];
                }

                if($installData['package'] == 'pkg_payzito')
                {
                    $installData['package'] = 'payzito';
                }

                list($installStatus,$installMsg) = PAGeneral::installUpdatePlugin($installData);

                if(!$installStatus)
                {
                    self::displayMsg(0,$installMsg);
                }

                self::displayMsg(1,'success');
            }
        }
        elseif ($action == 'callMethod')
        {
            $file = $_POST['PAFile'] ?? '';
            $file = self::getRootPath() .DS. str_replace('/',DS,$file);
            $class = $_POST['PAClass'] ?? '';
            $method = $_POST['PAMethod'] ?? '';
            $type = $_POST['PAType'] ?? null;

            if(empty($file) || !file_exists($file))
            {
                self::displayMsg(0,'فایل درخواستی برای اجرا موجود نمی باشد.');
            }

            include_once $file;

            if(empty($class) || !class_exists($class))
            {
                self::displayMsg(0,'کلاس درخواستی برای اجرا موجود نمی باشد.');
            }

            $obj = new $class;

            if(empty($method) || !method_exists($class,$method))
            {
                self::displayMsg(0,'متد درخواستی برای اجرا موجود نمی باشد.');
            }

            $obj->$method($type);

            self::displayMsg(1,'Call Done.');
        }
        elseif ($action == 'execute')
        {
            $file = $_POST['PAFile'] ?? '';
            $file = self::getRootPath() .DS. str_replace('/',DS,$file);

            if(empty($file) || !file_exists($file))
            {
                self::displayMsg(0,'فایل درخواستی برای اجرا موجود نمی باشد.');
            }

            include $file;

            self::displayMsg(1,'Execute Done.');
        }
        elseif($action == 'finalTasks')
        {
            self::clearSetupSession();
            self::deleteOtherFolder();
            self::deleteTempPath();

            $element = $_POST['PAElement'] ?? '';

            self::deleteFileIfExist(self::getInstallLicenseFilePath());

            self::writeFile(dirname(__FILE__).DIRECTORY_SEPARATOR.'ready.payzito','Payzito Is Ready!');

            $_installer = PAAutoloader::installerFactory();
            $_installer->doFinalTasks($element);

            self::displayMsg(1,'Success Final Tasks.');
        }
    }

    static function includeCmsInstallerFile($file)
    {
        self::includeBaseLibrary();
        include_once PASetup::getCorePath().DS.'cms'.DS.self::getCms().DS.'installer'.DS.$file.'.php';
    }

    static function checkIonCubeIsLoaded()
    {
        if(!extension_loaded('ionCube Loader'))
        {
            self::displayMsg(0,'افزونه ionCube در سرور شما نصب نشده است. لازم است از مدیر هاست یا سرور خود درخواست کنید این افزونه را در سرور شما نصب نماید.');
        }
    }

    static function checkPhpVersion()
    {
        list($status,$msg) = self::isValidPhpVersion();

        if(!$status)
        {
            self::displayMsg(0,$msg);
        }
    }

    static function createExpiredLicense($type)
    {
        $licenceFile = self::getRootPath() .DS. self::getLicenseFilename($type);

        if($type == 'free' || self::isLocalhost())
        {
            $setupLicense = dirname(__FILE__).DS.'cms'.DS.self::getCms().DS.'licenses'.DS.self::getLicenseFilename($type);
            self::copyFile($setupLicense,$licenceFile);
        }
        else
        {
            if(self::existFile($licenceFile))
            {
                $licenceStatus = self::licenseFileStatus();
                if(!$licenceStatus[0])
                {
                    self::deleteFile($licenceFile);
                }
            }

            if(!self::existFile($licenceFile) || self::isExpiredLicense($type))
            {
                $url = 'https://my.payzito.net/payzito-api/license.php';

                $params = [
                    'type' => $type,
                    'cms' => self::getCms(),
                    'domain' => self::getDomain(),
                ];

                $ch = curl_init();

                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($params));
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,12);
                curl_setopt($ch, CURLOPT_TIMEOUT,17);

                $result = curl_exec($ch);

                curl_close($ch);

                if(empty($result) || strpos($result,'error') !== false)
                {
                    self::displayMsg(0,'مشکلی در دریافت فایل لایسنس نصب رخ داد.'.self::getLicenseLearnMessage());
                }

                self::writeFile($licenceFile,$result);
            }
        }
    }

    static function checkLicense($type)
    {
        $licenceFile = self::getRootPath().DS.self::getLicenseFilename($type);

        if(!self::existFile($licenceFile))
        {
            self::displayMsg(0,'فایل لایسنس برای ادامه فرآیند نصب موجود نیست.'.self::getLicenseLearnMessage());
        }

        $fileContent = self::readFile($licenceFile);
        if(empty($fileContent))
        {
            self::displayMsg(0,'محتویات فایل لایسنس خالی است.'.self::getLicenseLearnMessage());
        }

        $licenceStatus = self::licenseFileStatus();
        if(!$licenceStatus[0])
        {
            self::displayMsg(0,'خطایی در فراخوانی فایل لایسنس وجود دارد. <br/> لطفا از مدیر هاست و یا سرور سایت درخواست کنید Ioncube Loader را به آخرین نسخه بروزرسانی کند. اگر از آپدیت بودن آن اطمینان پیدا کردید و مجددا این خطا را دریافت نمودید با پشتیبانی سایت <a href="https://payzito.net">payzito.net</a> تماس برقرار نمایید.');
        }

        self::displayMsg(1,'');
    }

    static function checkCmsIsValid()
    {
        list($status,$msg) = self::isValidCmsVersion();

        if(!$status)
        {
            self::displayMsg(0,$msg);
        }
    }

    static function displayMsg($type,$msg,$data=[])
    {
        $output = [$type,$msg];

        if(!empty($data))
        {
            $output[] = $data;
        }

        die('#|#'.json_encode($output,JSON_UNESCAPED_UNICODE).'#|#');
    }

    static function getTempPath()
    {
        $path = parent::getTempDirectory();

        self::createFolderIfNotExist($path);
        self::writeFile($path.DS.'index.html','',false);

        return $path;
    }

    static function getOldTempPath()
    {
        return parent::getOldTempDirectory();
    }

    static function deleteTempPath()
    {
        $tempPath = parent::getTempDirectory();
        if(!empty($tempPath))
        {
            self::deleteFolder($tempPath);
        }

        $oldTempPath = parent::getOldTempDirectory();
        if(!empty($oldTempPath))
        {
            self::deleteFolder($oldTempPath);
        }
    }

    static function deleteOtherFolder()
    {
        self::deleteFolder(self::getPluginPath(['plg_name' => 'payzito_loader']).DS.'other');
    }

    static function getLicenseLearnMessage()
    {
        return '<br/><a href="https://payzito.net/docs/installing/create-license" target="_blank"><button class="pa-ins-btn">آموزش تولید و استفاده از لایسنس</button></a>';
    }
}

interface PASetupImplements
{
    static function addScript($dir);
    static function addScriptDeclaration($content);
    static function addStyle($dir);
    static function getPluginPath($data);
    static function getAdminUri($pathOnly=false);
    static function getBasePath();
    static function getRootPath();
    static function getCorePath();
    static function getPackagesPath();
    static function getRootUri($pathOnly=false);
    static function getBackendUrl($src);
    static function setSession($name,$value);
    static function getSession($name);
    static function clearSession($name);
    static function getSampleAction();
    static function inInstallArea();
    static function enableInstallerPlugin();
    static function getMediaPath();
    static function moveMediaFiles();
    static function moveCoreFiles();
    static function movePackageFiles();
    static function dbQuery($query);
    static function getDomain();
    static function tableExist($table);
    static function existAtLeastRow($table,$where='');
    static function getCountOfTable($table,$where='');
    static function isLocalHost();
    static function isValidCmsVersion();
    static function getLicenseFilename($type);
    static function getUnzipDirectory();
    static function getTempDirectory();
    static function getCmsText();
    static function getCmsSupportedVersions();
    static function getPhpSupportedVersions();
    static function isValidPhpVersion();
    static function getOldTempDirectory();
    static function getSetupSession($key=null);
    static function setSetupSession();
    static function updateSetupSession($key,$value);
    static function clearSetupSession();
    static function inSetupArea();
    static function checkReadyToUpdate();
}