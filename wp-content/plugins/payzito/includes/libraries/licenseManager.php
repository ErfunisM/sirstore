<?php

if(!class_exists('PALicenseManager'))
{
    class PALicenseManager
    {
        function __construct()
        {
            $this->importSetupLibrary();
        }

        function isValid()
        {
            if($this->isBackend() && isset($_REQUEST['pa-reinstall']))
            {
                $GLOBALS['payzito_setup_ready'] = 1;

                PASetup::afterInstall();
                PASetup::apply();

                return false;
            }

            $status = $this->getStatus();
            if(!$status[0])
            {
                $this->displayMessage();
                return false;
            }

            return true;
        }

        function displayMessage()
        {
            $cms = $this->getCms();
            $msg = null;

            if($this->isBackend())
            {
                if(!$this->isGuest())
                {
                    if($cms == 'joomla')
                    {
                        $url = $this->getFullUrl();
                        $url .= (strpos($url,'?') === false ? '?' : '&').'pa-reinstall=1';

                        $msg = ' مشکلی درفراخوانی لایسنس پِی زیتو رخ داده است، برای عیب یابی و رفع مشکل بر روی دکمه مقابل کلیک کنید.'.'<a href="'.$url.'"><button class="btn btn-primary">بررسی و بازسازی لایسنس</button></a>';
                    }
                    elseif($cms == 'wordpress')
                    {
                        $url = get_admin_url().'plugins.php?pa-reinstall=1';

                        $msg = ' مشکلی درفراخوانی لایسنس پِی زیتو رخ داده است، برای عیب یابی و رفع مشکل بر روی دکمه مقابل کلیک کنید.'.'<a href="'.$url.'"><button class="button button-primary">بررسی و بازسازی لایسنس</button></a>';
                    }
                }
            }
            else
            {
                if(isset($_REQUEST['pa-page']))
                {
                    $msg = "مشکلی در فراخوانی افزونه دستیار پرداخت پِی زیتو رخ داده است، لطفا با پشتیبان سایت تماس حاصل نمایید، اگر مدیر سایت هستید برای رفع مشکل لطفا به بخش مدیریت افزونه دستیار پرداخت پِی زیتو مراجعه نمایید.";
                }
            }

            if($cms == 'joomla' && !empty($msg))
            {
                JFactory::getApplication()->enqueueMessage($msg,'warning');
            }
            elseif($cms == 'wordpress')
            {
                $html = '
                    <div class="notice notice-error is-dismissible wp-payzito-notify">
                        <p>'.$msg.'</p>    
                    </div>
                ';

                if(isset($_REQUEST['page']) && strpos($_REQUEST['page'],'payzito') !== false)
                {
                    $html .= '
                        <style>
                            .wp-payzito-notify{
                                background: #fff;
                                border: 2px solid #7127ea;
                                text-align: center;
                                border-radius: 5px;
                                margin: 10px auto;
                            }
                            .wp-payzito-notify p,
                            .wp-payzito-notify button{
                                font-family: tahoma;
                               font-size: 14px;
                            }
                            .wp-payzito-notify button{
                                margin-top: 15px;
                                background: #7127ea;
                                color: #fff;
                                border: 0;
                                line-height: 32px;
                                height: 32px;
                            }
                         </style>
                    ';
                    echo $html;
                }
                else
                {
                    $html .= '
                        <style>
                            .wp-payzito-notify{
                                border: 0;
                                background: #7127ea;
                                color: #fff;
                                position: relative;
                                padding-left: 68px;
                            }
                            .wp-payzito-notify a{
                                color: #fff !important;
                            }
                            .wp-payzito-notify .notice-dismiss:before{
                                color: #fff !important;
                            }
                            .wp-payzito-notify .wp-payzito-notify-tag{
                                background: #00000038;
                                color: #fff;
                                padding: 0 10px;
                                position: absolute;
                                top: 0;
                                bottom: 0;
                                font-size: 14px;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                cursor: pointer;
                                left: 0;
                                margin: 0;
                            }
                            html[dir="rtl"] .wp-payzito-notify{
                                padding-right: 68px;
                                padding-left: 0;
                            }
                            html[dir="rtl"] .wp-payzito-notify .wp-payzito-notify-tag{
                                right: 0;
                                left: auto;
                                padding-bottom: 5px;
                            }
                        </style>
                    ';
                    add_action( 'admin_notices',function() use ($html){
                        echo $html;
                    });
                }
            }
        }

        function getFullUrl()
        {
            if($this->getCms() == 'joomla')
            {
                $uri = JUri::getInstance();
                return $uri->toString();
            }
            elseif($this->getCms() == 'wordpress')
            {
                return '';
            }

            return false;
        }

        function getStatus()
        {
            static $status = null;

            if(!is_null($status))
            {
                return $status;
            }

            if($this->isExpiredLicense())
            {
                $status = [0,''];
            }
            else
            {
                ob_start();
                include dirname(__FILE__).DS.'licenseChecker.php';
                $output = ob_get_contents();
                ob_end_clean();

                if(!empty($output) && preg_match('/#\|#(.*)#\|#/',$output,$match))
                {
                    $result = json_decode($match[1],true);
                    if(!empty($result) && count($result) == 2)
                    {
                        $status = $result;
                    }
                }
            }

            if(is_null($status))
            {
                $status = [0,''];
            }

            return $status;
        }

        function getCms()
        {
            static $cms;
            if($cms)
            {
                return $cms;
            }

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

        function isGuest()
        {
            if(self::getCms() == 'joomla')
            {
                $user = JFactory::getUser();
                return $user->guest ? true : false;
            }
            elseif(self::getCms() == 'wordpress')
            {
                require_once (ABSPATH . WPINC . '/pluggable.php');
                return !is_user_logged_in() ? true : false;
            }

            return false;
        }

        function isBackend()
        {
            if(self::getCms() == 'joomla')
            {
                $app = JFactory::getApplication();

                if(version_compare(JVERSION,'4.0.0','>='))
                {
                    return $app->isClient('administrator');
                }
                else
                {
                    return $app->isAdmin();
                }
            }
            elseif(self::getCms() == 'wordpress')
            {
                return is_admin();
            }

            return false;
        }

        function importSetupLibrary()
        {
            require_once realpath(dirname(__FILE__).'/../setup/setup.php');
        }

        function isExpiredLicense()
        {
            $data = PASetup::getSetupFileData();
            return PASetup::isExpiredLicense($data['type']);
        }
    }
}