<?php

namespace App\Listeners;

use App\Comment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentsHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event, $comment)
    {
        $comment = $comment[0];

        return $this->sendMail($comment);
    }

    protected function sendMail(Comment $comment)
    {
        $to[] = $comment->commentable->author->email;

        if ($comment->parent) {
            $to[] = $comment->parent->author->email;
        }

        $to = array_unique($to);
        $subject = 'New Comment';

        return \Mail::send('emails.new-comment', compact('comment'), function ($m) use ($to, $subject) {
            $m->to($to)->subject($subject);
        });

    }
}
