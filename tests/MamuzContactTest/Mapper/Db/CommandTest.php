<?php

namespace MamuzContactTest\Mapper\Db;

use MamuzContact\EventManager\Event;
use MamuzContact\Mapper\Db\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Command */
    protected $fixture;

    /** @var \Doctrine\Common\Persistence\ObjectManager | \Mockery\MockInterface */
    protected $entityManager;

    /** @var \MamuzContact\Entity\Contact | \Mockery\MockInterface */
    protected $entity;

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \Zend\EventManager\ResponseCollection | \Mockery\MockInterface */
    protected $reponseCollection;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzContact\Entity\Contact');
        $this->entityManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');

        $this->fixture = new Command($this->entityManager);

        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $this->fixture->setEventManager($this->eventManager);

        $this->reponseCollection = \Mockery::mock('Zend\EventManager\ResponseCollection')->shouldIgnoreMissing();
    }

    protected function prepareEventManagerForPersist($stopped = false)
    {
        $this->reponseCollection->shouldReceive('stopped')->once()->andReturn($stopped);

        $this->eventManager->shouldReceive('trigger')->once()->with(
            Event::PRE_PERSISTENCE,
            $this->fixture,
            array('contact' => $this->entity)
        )->andReturn($this->reponseCollection);
    }

    public function testImplementingCommandInterface()
    {
        $this->assertInstanceOf('MamuzContact\Feature\CommandInterface', $this->fixture);
    }

    public function testPersist()
    {
        $this->prepareEventManagerForPersist(false);
        $this->entityManager->shouldReceive('persist')->with($this->entity);
        $this->entityManager->shouldReceive('flush');

        $this->eventManager->shouldReceive('trigger')->once()->with(
            Event::POST_PERSISTENCE,
            $this->fixture,
            array('contact' => $this->entity)
        );

        $this->assertSame($this->entity, $this->fixture->persist($this->entity));
    }

    public function testPersistWithStoppingEvent()
    {
        $this->prepareEventManagerForPersist(true);
        $this->assertSame($this->entity, $this->fixture->persist($this->entity));
    }
}
