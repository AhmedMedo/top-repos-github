<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Jobs\StoreGithubResponseJob;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UpdateTopProgrammingListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:top-repos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $languages = ['php', 'java', 'javascript', 'python'];

        foreach($languages as $language)
        {
            $stack = HandlerStack::create();
            $stack->push($this->interceptResponse($language));

            $client = new Client();
            $client->get('https://api.github.com/search/repositories', [
                'max_retry_attempts' => 5,
                'retry_on_status'    => [503,429,404,500],
                'max_allowable_timeout_secs'=>30,
                'handler' => $stack,
                'http_errors'=>false,
                'query' =>[
                    'q' => $language,
                    'per_page' => 50
                ]
            ]);

            sleep(2);
        }

    }

    function interceptResponse($language)
    {
        return function (callable $handler) use ($language) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler ,$language) {
                $promise = $handler($request, $options);
                return $promise->then(
                    function (ResponseInterface $response) use ($language) {

                        if($response->getStatusCode() == Response::HTTP_OK)
                        {
                            dispatch(new StoreGithubResponseJob($response->getBody()->getContents() , $language));
                        }
                        else{

                            Log::channel('github')->error('Error in request for github status code: '.$response->getStatusCode().' response body :' . $response->getBody()->getContents());
                        }

                        return $response;
                    }
                );
            };
        };

    }
}
