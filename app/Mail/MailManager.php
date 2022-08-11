<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailManager extends Mailable
{
    use Queueable, SerializesModels;

    protected string $title = 'Title';
    protected string $subject = 'Define a subject';
    protected string $content = 'Define a long text content for your email body.';
    protected string $type = 'simple';


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {

            $this->title = $data['title'];
            $this->subject = $data['subject'];
            $this->content = $data['content'];
            $this->type = $data['type'];
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.' . $this->type)
            ->with([
                'title' => $this->title,
                'subject' => $this->subject,
                'content' => $this->content,
            ]);
    }
}
