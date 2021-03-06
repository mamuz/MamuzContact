<?php

namespace MamuzContact;

use Zend\ModuleManager\Feature;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements
    Feature\ConfigProviderInterface,
    Feature\InitProviderInterface
{
    public function init(ModuleManagerInterface $modules)
    {
        $modules->loadModule('DoctrineModule');
        $modules->loadModule('DoctrineORMModule');
        $modules->loadModule('TwbBundle');

        if ($modules instanceof ModuleManager) {
            $this->addDomainManager($modules);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    private function addDomainManager(ModuleManager $modules)
    {
        /** @var \Zend\ServiceManager\ServiceLocatorInterface $sm */
        $sm = $modules->getEvent()->getParam('ServiceManager');
        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');

        $serviceListener->addServiceManager(
            'MamuzContact\DomainManager',
            'contact_domain',
            'MamuzContact\DomainManager\ProviderInterface',
            'getContactDomainConfig'
        );
    }
}
