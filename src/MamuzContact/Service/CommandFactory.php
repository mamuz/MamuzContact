<?php

namespace MamuzContact\Service;

use MamuzContact\Mapper\Db\Command as CommandMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \MamuzContact\Feature\CommandInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        /** @var \Zend\EventManager\EventManagerInterface $eventManager */
        $eventManager = $serviceLocator->get('EventManager');

        $queryMapper = new CommandMapper($entityManager);
        $queryService = new Command($queryMapper);
        $queryService->setEventManager($eventManager);

        return $queryService;
    }
}
