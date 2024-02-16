<?php

namespace App\Mail;

use App\Models\Car;
use App\Models\Demnad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailDemnad extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    public function __construct(
        public Demnad $demnad,
        public User $user
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {


        return new Envelope(
            subject: 'Thông báo về bài đăng tin cần mua xe của bạn',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->demnad->status == 1) {
            $reason = 'Chúc mừng bạn, tin mua của bạn đã được chúng tôi phê duyệt thành công! Cảm ơn sự tin tưởng và ủng hộ của bạn với DRIVCO.';
        } else {
            $reason = 'Xin lỗi bạn, tin mua của bạn đã không được chúng tôi phê duyệt. Vì lý do: ' . $this->demnad->reason . 
            '.Cảm ơn sự tin tưởng và ủng hộ của bạn với DRIVCO.';
        }

        return new Content(
            view: 'mail.mail-demnad',
            with: [
                'reason' => $reason
            ]

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
