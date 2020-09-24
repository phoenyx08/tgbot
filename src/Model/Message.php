<?php


namespace App\Model;

/**
 * Class Message.
 * Represents Update object according to Telegram Bot API
 * @see https://core.telegram.org/bots/api#message
 * @package App\Model
 */
class Message
{
    /** @var Chat $chat The chat to which the message belongs */
    private $chat;

    /**
     * Message constructor.
     * @param $message
     */
    public function __construct($message) {
        $this->chat = new Chat($message->chat);
    }

    /**
     * @return mixed
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * @param mixed $chat
     */
    public function setChat($chat): void
    {
        $this->chat = $chat;
    }
}