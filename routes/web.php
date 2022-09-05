<?php

use Monolog\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Response;
use GuzzleHttp\MessageFormatter;
use App\Models\TopProgrammingRepo;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;
use App\Jobs\StoreGithubResponseJob;
use Illuminate\Support\Facades\Route;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $logger = new Logger('error');
    // $logger->pushHandler(new StreamHandler(storage_path() . '/logs/github.log'), Logger::ERROR);

    // $stack->push(
    //     Middleware::log(
    //         $logger,
    //         new MessageFormatter('{req_body} - {res_body} - {code}')
    //     )
    // );

    $languages = ['php', 'java', 'javascript', 'python'];
    $stack = HandlerStack::create();

    // $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {

        // if($response->getStatusCode() == Response::HTTP_OK)
        // {
        //     dispatch(new StoreGithubResponseJob($response->getBody()->getContents()));
        // }
        // else{

        //     Log::channel('github')->error('Error in request for github status code: '.$response->getStatusCode().' response body :' . $response->getBody()->getContents());
        // }
    //     return $response;
    // }));

    $client = new Client();
    $response = $client->get('https://api.github.com/search/repositories', [
        'max_retry_attempts' => 5,
        'retry_on_status'    => [503,429,404,500],
        'max_allowable_timeout_secs'=>30,
        'http_errors'=>false,
        'query' =>[
            'q' => 'java',
            'per_page' => 10
        ]

    ]);

    $githubResponse = json_decode($response->getBody()->getContents() , true);
    foreach($githubResponse['items'] as $item)
    {
        TopProgrammingRepo::firstOrCreate([
            'repo_name' => $item['full_name']
        ],[

            'repo_name' => $item['full_name'],
            'programming_lagnuage' => 'java',
            'github_url'           => $item['html_url'],
            'description'          => $item['description'],
        ]);
    }
});


