<?php

defined('ABSPATH') OR die('Payzito Wordpress Restricted Access');

if(is_admin())
{
    class PAWordpressCmsInstaller
    {
        static function init()
        {
            register_activation_hook(self::getFilePath(),'PAWordpressCmsInstaller::activation');
            register_uninstall_hook(self::getFilePath(),'PAWordpressCmsInstaller::uninstall');
            add_filter('upgrader_post_install','PAWordpressCmsInstaller::afterInstall',10,3);

            add_action('admin_init',function(){
                PAWordpressCmsInstaller::apply();
            });
        }

        static function getFilePath()
        {
            return dirname(__FILE__).DS.'payzito.php';
        }

        static function includeSetupFile()
        {
            defined('PA_EXEC') OR define('PA_EXEC',true);
            require_once dirname(__FILE__).str_replace('/',DS,'/includes/setup/setup.php');
        }

        static function activation()
        {
            self::includeSetupFile();
            PASetup::afterInstall();
        }

        static function apply()
        {
            if(get_option('payzito_setup_ready',0) || isset($_POST['PAAction']))
            {
                self::includeSetupFile();
                PASetup::apply();
            }
        }

        static function uninstall()
        {
            self::includeSetupFile();
            PASetup::includeCmsInstallerFile('uninstall');
        }

        static function afterInstall($response,$extra,$result)
        {
            if(isset($result['destination_name']) && strpos($result['destination_name'],'payzito') !== false)
            {
                $name = $result['destination_name'];

                deactivate_plugins('/'.$name.'/'.$name.'.php');

                if($name == 'payzito')
                {
                    $file = dirname(__FILE__).DS.'includes'.DS.'setup'.DS.'ready.payzito';
                    if(file_exists($file))
                    {
                        @unlink($file);
                    }
                }
            }
        }
    }

    PAWordpressCmsInstaller::init();
}