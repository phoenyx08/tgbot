<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Messenger
{
    private $client;
    private $botToken;

    /**
     * Messenger constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
        $this->botToken = $_ENV['BOT_TOKEN'];
    }

    /**
     * @param $chatId
     * @return string
     */
    public function sendChatId($chatId) {
        $message = urlencode('Your chat id is ' . (string)$chatId);
        return $this->sendMessage($chatId, $message);
    }

    /**
     * @param $chatId
     * @param $message
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function sendMessage($chatId, $message) {
        $response = $this->client->request(
            'GET',
            'https://api.telegram.org/bot' . $this->botToken . '/sendMessage?chat_id='. $chatId . '&text=' . $message);
        return $response->getContent();
    }
}