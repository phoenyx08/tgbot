<?php


namespace App\Model;


/**
 * Class Chat.
 * Represents Chat object according to Telegram Bot API
 * @see https://core.telegram.org/bots/api#chat
 * @package App\Model
 */
class Chat
{
    private $id;

    public function __construct($chat) {
        $this->id = $chat->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


}