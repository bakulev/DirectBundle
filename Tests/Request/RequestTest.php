<?php

namespace Ext\DirectBundle\Tests\Request;

use Ext\DirectBundle\Tests\TestTemplate;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Ext\DirectBundle\Request\Request as ExtRequest;

/**
 * Class RequestTest
 * @package Ext\DirectBundle\Tests\Request
 * @author Semyon Velichko <semyon@velichko.net>
 */
class RequestTest extends TestTemplate
{

    public function testExtractCalls()
    {
        $httpRequest = new HttpRequest(array(), array(), $this->getAttributes(), array(), array(), array(), $this->getJsonContent());
        $extRequest = new ExtRequest($httpRequest);

        $calls = $extRequest->extractCalls();

        $this->assertCount(2, $calls);
        foreach($calls as $Call)
            $this->assertInstanceOf('Ext\DirectBundle\Request\Call', $Call);
    }

    public function testExctractCallsByFormRequest()
    {
        $httpRequest = new HttpRequest(
            array(), $this->getPost(), $this->getAttributes(), array(), array(), array()
        );
        $extRequest = new ExtRequest($httpRequest);

        $calls = $extRequest->extractCalls();
        $this->assertCount(1, $calls);
        $this->assertInstanceOf('Ext\DirectBundle\Request\CallForm', $calls[0]);
    }

    public function testExctractCallsWithHttpSOEmu()
    {
        $httpRequest = new HttpRequest(array(), $this->getContent(), $this->getAttributes(), array(), array(), array(), $this->getJsonContent());
        $extRequest = new ExtRequest($httpRequest);

        $calls = $extRequest->extractCalls();

        $this->assertCount(2, $calls);
        foreach($calls as $Call)
            $this->assertInstanceOf('Ext\DirectBundle\Request\Call', $Call);
    }

    /**
     * @return array
     */
    public function getPost()
    {
        return array('extAction' => 'ExtDirect_Test',
            'extMethod' => 'testFormHandlerResponse',
            'extType' => 'rpc',
            'extTID' => rand(1, 10),
            'extUpload' => false,

            'id' => rand(1,99),
            'name' => 'Joker',
            'count' => rand(100,200)
        );
    }

    /**
     * @return array
     */
    private function getAttributes()
    {
        return array(
            '_controller' => 'Ext\DirectBundle\Controller\DirectController::routeAction',
            '_route' => 'ExtDirectBundle_route',
            '_route_params' => array()
        );
    }

    /**
     * @return array
     */
    private function getContent()
    {
        return array(
            array(
                'action' => 'ExtDirect_Test',
                'method' => 'testFirst',
                'data' => array(array('page' => rand(1,10), 'start' => rand(10,20), 'limit' => rand(100,9999))),
                'type' => 'rpc',
                'tid' => rand(1, 10)
            ),
            array(
                'action' => 'ExtDirect_Test',
                'method' => 'testSecond',
                'data' => array(array('page' => rand(1,10), 'start' => rand(10,20), 'limit' => rand(100,9999))),
                'type' => 'rpc',
                'tid' => rand(1, 10)
            )
        );
    }

    /**
     * @return string
     */
    private function getJsonContent()
    {
        return json_encode($this->getContent());
    }

}


