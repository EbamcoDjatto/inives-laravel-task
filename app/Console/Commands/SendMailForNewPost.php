<?php

namespace App\Console\Commands;

use App\Jobs\SendMail;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostCreated;
use Illuminate\Console\Command;

class SendMailForNewPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to users after new post in website';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Post::where('notify', 0)->chunk(10, function ($posts) {
            $posts->each(function ($post) {
                $users = $post->website->users;
                if ($users !== null) {
                    $users->each(function ($user) use ($post) {
                        $data = [
                            'email' => $user->email,
                            'title' => $post->title,
                            'description' => $post->description,
                        ];
                        SendMail::dispatch($data)->delay(1000);
                    });

                }
                Post::where('id', $post->id)->update(['notify' => true]);
            });
        });

    }
}
