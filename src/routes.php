<?php

use Slim\Http\Request;
use Slim\Http\Response;

require_once __DIR__.'/app/server/init.php';
$app->post('/move', function(Request $request, Response $response, array $args) {
    $allPostPutVars = $request->getParsedBody();
    if (!is_array($allPostPutVars)) {
        throw new Exception('invalid input');
    }
    $gc = new GameConfig();
    $be = new BoardEvaluator($gc->get('blocks'));
    $g = new Game(
            $allPostPutVars, 
            new Algorithm($gc, $be), 
            $gc, 
            $be
        );
    $nextMove = $g->getNextMove();
    return json_encode($nextMove);
});

$app->get('/config', function(Request $request, Response $response, array $args) {
    $gc = new GameConfig();
    return json_encode($gc->get());
});

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.html', $args);
});