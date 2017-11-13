<?php

namespace Tests\Functional;

class ConfigPageTest extends BaseTestCase
{
    /**
     * Test that the index route returns a rendered response containing the text 'SlimFramework' but not a greeting
     */
    public function testGetConfigPage()
    {
        $response = $this->runApp('GET', '/config');

        $this->assertEquals(200, $response->getStatusCode());
        $response = json_decode($response->getBody());
        $this->assertTrue(is_object($response));
        $this->assertTrue(isset($response->player));
    }


    /**
     * Test that the index route won't accept a post request
     */
    public function testConfigPagePostNotAllowed()
    {
        $response = $this->runApp('POST', '/config', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}