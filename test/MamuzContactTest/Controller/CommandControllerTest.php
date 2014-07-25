<?php

namespace MamuzContactTest\Controller;

use MamuzContact\Controller\CommandController;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

class CommandControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Zend\Mvc\Controller\AbstractActionController */
    protected $fixture;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var RouteMatch */
    protected $routeMatch;

    /** @var MvcEvent */
    protected $event;

    /** @var \MamuzContact\Feature\CommandInterface | \Mockery\MockInterface */
    protected $commandInterface;

    /** @var \Zend\Form\FormInterface | \Mockery\MockInterface */
    protected $formInterface;

    /** @var \Zend\Mvc\Controller\Plugin\PostRedirectGet | \Mockery\MockInterface */
    protected $prg;

    /** @var string */
    protected $uri = 'foo';

    protected function setUp()
    {
        $this->commandInterface = \Mockery::mock('MamuzContact\Feature\CommandInterface');
        $this->formInterface = \Mockery::mock('Zend\Form\FormInterface');

        $this->fixture = new CommandController($this->commandInterface, $this->formInterface);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $router = HttpRouter::factory();

        $this->request->setRequestUri($this->uri);
        $this->prg = \Mockery::mock('Zend\Mvc\Controller\Plugin\PostRedirectGet');
        $pluginManager = \Mockery::mock('Zend\Mvc\Controller\PluginManager')->shouldIgnoreMissing();
        $pluginManager->shouldReceive('get')->with('prg', null)->andReturn($this->prg);

        $this->fixture->setPluginManager($pluginManager);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->fixture->setEvent($this->event);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testCreateActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'create');
        $this->prg->shouldReceive('__invoke')->with($this->uri, true)->andReturn(false);

        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateActionCanBeAccessedAfterPost()
    {
        $responseInterface = \Mockery::mock('Zend\Stdlib\ResponseInterface');
        $this->routeMatch->setParam('action', 'create');
        $this->prg->shouldReceive('__invoke')->with($this->uri, true)->andReturn($responseInterface);

        $result = $this->fixture->dispatch($this->request);
        $this->assertSame($responseInterface, $result);
    }

    public function testCreateActionWithInvalidPost()
    {
        $postData = new \Zend\Stdlib\Parameters(array('foo', 'baz'));
        $this->prg->shouldReceive('__invoke')->with($this->uri, true)->andReturn($postData);
        $this->routeMatch->setParam('action', 'create');
        $this->formInterface->shouldReceive('setData')->with($postData)->andReturn($this->formInterface);
        $this->formInterface->shouldReceive('isValid')->andReturn(false);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateActionWithValidPost()
    {
        $contact = \Mockery::mock('MamuzContact\Entity\Contact');
        $postData = new \Zend\Stdlib\Parameters(array('foo', 'baz'));
        $this->prg->shouldReceive('__invoke')->with($this->uri, true)->andReturn($postData);
        $this->routeMatch->setParam('action', 'create');
        $this->formInterface->shouldReceive('setData')->with($postData)->andReturn($this->formInterface);
        $this->formInterface->shouldReceive('isValid')->andReturn(true);
        $this->formInterface->shouldReceive('getData')->andReturn($contact);
        $this->commandInterface->shouldReceive('persist')->with($contact);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertSame($contact, $result->getVariables()['contact']);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
