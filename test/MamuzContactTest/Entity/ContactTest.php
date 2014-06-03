<?php

namespace MamuzContactTest\Entity;

use MamuzContact\Entity\Contact;

class MamuzContactTest extends \PHPUnit_Framework_TestCase
{
    /** @var Contact */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Contact;
    }

    public function testClone()
    {
        $createdAt = new \DateTime;
        $this->fixture->setId(12);
        $this->fixture->setCreatedAt($createdAt);
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($createdAt, $clone->getCreatedAt());
        $this->assertEquals($createdAt, $clone->getCreatedAt());
    }

    public function testMutateAndAccessCreatedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
        $expected = new \DateTime;
        $result = $this->fixture->setCreatedAt($expected);
        $this->assertSame($expected, $this->fixture->getCreatedAt());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessFromEmail()
    {
        $expected = 'foo';
        $result = $this->fixture->setFromEmail($expected);
        $this->assertSame($expected, $this->fixture->getFromEmail());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessId()
    {
        $expected = 'foo';
        $result = $this->fixture->setId($expected);
        $this->assertSame($expected, $this->fixture->getId());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessMessage()
    {
        $expected = 'foo';
        $result = $this->fixture->setMessage($expected);
        $this->assertSame($expected, $this->fixture->getMessage());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessSubject()
    {
        $expected = 'foo';
        $result = $this->fixture->setSubject($expected);
        $this->assertSame($expected, $this->fixture->getSubject());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessReplied()
    {
        $this->assertFalse($this->fixture->isReplied());
        $result = $this->fixture->setReplied(true);
        $this->assertTrue($this->fixture->isReplied());
        $this->assertSame($result, $this->fixture);
    }

    public function testArrayRepresentation()
    {
        $this->fixture->setId(12);
        $this->fixture->setFromEmail('email');
        $this->fixture->setSubject('subject');
        $this->fixture->setMessage('message');

        $this->assertSame(
            array(
                'From'    => 'email',
                'Subject' => 'subject',
                'Message' => 'message',
            ),
            $this->fixture->toArray()
        );
    }
}
