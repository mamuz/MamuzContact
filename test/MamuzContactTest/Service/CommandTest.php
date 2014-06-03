<?php

namespace MamuzContactTest\Service;

use MamuzContact\Service\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Command */
    protected $fixture;

    /** @var \MamuzContact\Feature\CommandInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \MamuzContact\Entity\Contact | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzContact\Entity\Contact');
        $this->mapper = \Mockery::mock('MamuzContact\Feature\CommandInterface');
        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface')->shouldIgnoreMissing();

        $this->fixture = new Command($this->mapper);
        $this->fixture->setEventManager($this->eventManager);
    }

    public function testImplementingCommandInterface()
    {
        $this->assertInstanceOf('MamuzContact\Feature\CommandInterface', $this->fixture);
    }

    public function testImplementingEventManagerAwareInterface()
    {
        $this->assertInstanceOf('Zend\EventManager\EventManagerAwareInterface', $this->fixture);
    }

    public function testPersist()
    {
        $this->eventManager->shouldReceive('trigger')->with(
            'persist.pre',
            $this->fixture,
            array($this->entity)
        );

        $this->mapper->shouldReceive('persist')->with($this->entity);

        $this->eventManager->shouldReceive('trigger')->with(
            'persist.post',
            $this->fixture,
            array($this->entity)
        );

        $this->assertSame($this->entity, $this->fixture->persist($this->entity));
    }
}
