<?php

namespace MamuzContactTest\Form;

use MamuzContact\Form\CreateFactory;

class CreateFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CreateFactory */
    protected $fixture;

    protected function setUp()
    {
        date_default_timezone_set('Europe/Berlin');
        $this->fixture = new CreateFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $metadata = \Mockery::mock('Doctrine\Common\Persistence\Mapping\ClassMetadata')->shouldIgnoreMissing();
        $metadata->shouldReceive('getAssociationNames')->andReturn(array());
        $metadata->shouldReceive('getFieldNames')->andReturn(array());
        $objectManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->shouldReceive('getClassMetadata')->andReturn($metadata);

        $element = \Mockery::mock('Zend\Form\ElementInterface');
        $element->shouldReceive('getName')->andReturn('foo');

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($objectManager);
        $sm->shouldReceive('get')->with('Config')->andReturn(array('captcha' => $element));

        $form = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Form\FormInterface', $form);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $metadata = \Mockery::mock('Doctrine\Common\Persistence\Mapping\ClassMetadata')->shouldIgnoreMissing();
        $metadata->shouldReceive('getAssociationNames')->andReturn(array());
        $metadata->shouldReceive('getFieldNames')->andReturn(array());
        $objectManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->shouldReceive('getClassMetadata')->andReturn($metadata);

        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($objectManager);
        $sm->shouldReceive('get')->with('Config')->andReturn(array());

        $form = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\Form\FormInterface', $form);
    }
}
