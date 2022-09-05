<?php

namespace App\Jobs;

use App\Models\TopProgrammingRepo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreGithubResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $githubResponse;

    protected $language;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($githubResponse , $language)
    {
        $this->githubResponse = $githubResponse;

        $this->language = $language;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $githubResponse = json_decode($this->githubResponse , true);
        foreach($githubResponse['items'] as $item)
        {
            TopProgrammingRepo::firstOrCreate([
                'repo_name' => $item['full_name']
            ],[

                'repo_name' => $item['full_name'],
                'programming_lagnuage' => $this->language,
                'github_url'           => $item['html_url'],
                'description'          => array_key_exists('description' , $item) ? $item['description'] :  ''
            ]);
        }
    }
}
