<?php

namespace MamuzContact\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\Mvc\Controller\AbstractController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('MamuzContact\DomainManager');

        /** @var \MamuzContact\Feature\CommandInterface $commandService */
        $commandService = $domainManager->get('MamuzContact\Service\Command');

        /** @var ServiceLocatorInterface $fem */
        $fem = $domainManager->get('FormElementManager');

        /** @var \Zend\Form\FormInterface $createForm */
        $createForm = $fem->get('MamuzContact\Form\Create');

        return new CommandController($commandService, $createForm);
    }
}
