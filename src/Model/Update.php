<?php


namespace App\Model;

/**
 * Class Update.
 * Represents Update object according to Telegram Bot API
 * @see https://core.telegram.org/bots/api#update
 * @package App\Model
 */
class Update
{
    /** @var Message $message The message contained in the update */
    private $message;

    /**
     * Update constructor.
     * @param string $content
     */
    public function __construct($content = '') {
        if (!empty($content)) {
            $update = json_decode($content);
            $this->message = new Message($update->message);
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}