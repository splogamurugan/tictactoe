<?php
use App\Server\Game;
use App\Server\Game\Config;
use App\Server\Game\Algorithm;
use App\Server\Board\Evaluator;
use App\Server\Board\Validator;

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/move', function(Request $request, Response $response, array $args) {
    $allPostPutVars = $request->getParsedBody();
    if (!is_array($allPostPutVars)) {
        throw new Exception('invalid input');
    }
    $gc = new Config();
    $be = new Evaluator($gc->get('blocks'));
    $g = new Game(
            new Validator($allPostPutVars, $gc), 
            new Algorithm($gc, $be), 
            $gc, 
            $be
        );
    $nextMove = $g->getNextMove();
    return json_encode($nextMove);
});

$app->get('/config', function(Request $request, Response $response, array $args) {
    $gc = new Config();
    return json_encode($gc->get());
});

$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.html', $args);
});