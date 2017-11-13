<?php

namespace Tests\Functional;

class GamePageTest extends BaseTestCase
{
    
    function inValidDataProvider()
    {
        return [
            [[['','']], 'Invalid rows'], 
            [['some tainted input'], 'Invalid rows'], 
            [[['',''],['','',''],['','','']], 'Invalid cols'], 
            [[['x','x','9'],['o','',''],['o','','']], 'Invalid players'],
        ];

    }

    /**
     * Test that the route won't accept a post request with invalid rows
     * @dataProvider inValidDataProvider
     */
    public function testInvalidBoardPost($input, $output)
    {
        $response = $this->runApp('POST', '/move', $input);
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertContains($output, (string)$response->getBody());
    }


    public function validDataProvider()
    {
        return [
            [[['x','',''],['','',''],['','','']], '[1,1,"o",""]'], //best turn for o
            [[['','',''],['x','',''],['','','']], '[0,0,"o",""]'], //best turn for o

            [[['x','x','x'],['o','',''],['o','','']], '[1,1,"o","x"]'], //player won (horzontal)
            [[['o','o','x'],['o','x','o'],['x','','']], '[1,2,"o","x"]'], //player won (forward slash)
            [[['x','o','o'],['o','x','o'],['','','x']], '[0,2,"o","x"]'], //player won (backward slash)
            
            [[['x','o','x'],['x','o',''],['o','','']], '[1,2,"o","o"]'], //bot going to win (vertical)
            [[['x','x','o'],['x','o',''],['','','']], '[0,2,"o","o"]'], //bot going to win (backward slash)
            [[['o','x','x'],['x','o',''],['','','']], '[2,2,"o","o"]'], //bot going to win (forward slash)
            
            [[['x','o','x'],['x','o','o'],['o','x','x']], '[-1,-1,"o",""]'], //draw game

        ];
    }


    /**
     * @dataProvider validDataProvider
     */
    public function testValidBoardPost($input, $output)
    {
        $response = $this->runApp('POST', '/move', $input);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($output, (string)$response->getBody());
    }

}