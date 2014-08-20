<?php

namespace MamuzContactTest\Service;

use MamuzContact\Service\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Command */
    protected $fixture;

    /** @var \MamuzContact\Feature\CommandInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \MamuzContact\Entity\Contact | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzContact\Entity\Contact');
        $this->mapper = \Mockery::mock('MamuzContact\Feature\CommandInterface');

        $this->fixture = new Command($this->mapper);
    }

    public function testImplementingCommandInterface()
    {
        $this->assertInstanceOf('MamuzContact\Feature\CommandInterface', $this->fixture);
    }

    public function testPersist()
    {
        $this->mapper->shouldReceive('persist')->with($this->entity);
        $this->assertSame($this->entity, $this->fixture->persist($this->entity));
    }
}
