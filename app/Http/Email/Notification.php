<?php

namespace App\Http\Email;

use App\Http\Enums\Operations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Notification extends Mailable
{
    use Queueable, SerializesModels;
    public string $start;
    public string $end;
    public Operations $operation;
    public string $email;

    public function __construct($start, $end, $email, $operation)
    {
        $this->start = $start;
        $this->end = $end;
        $this->email = $email;
        $this->operation = $operation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->operation == Operations::Notification) {
        return $this->subject('Your Subject')
            ->view('template.notification',[
                'start' => $this->start,
                'end' => $this->end,
                'email' => $this->email,
                'operation' => $this->operation
            ]);
        }
        if ($this->operation == Operations::Approving) {
            return $this->subject('Your Subject')
                ->view('template.approving',[
                    'start' => $this->start,
                    'end' => $this->end,
                    'email' => $this->email,
                    'operation' => $this->operation
                ]);
        }

        abort(404);
    }
}

