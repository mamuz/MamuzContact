<?php

namespace MamuzContactTest\Service;

use MamuzContact\Service\CommandFactory;

class CommandFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new CommandFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $objectManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($objectManager);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('MamuzContact\Feature\CommandInterface', $service);
    }
}
