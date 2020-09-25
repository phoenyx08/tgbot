<?php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
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
     * Sends Chat Id.
     *
     * Sends chat Id to the chat specified in the parameter chatId
     *
     * @param int $chatId Id of the chat which will be sent as well as a direction of the message
     * @return string Content of the response received from the Telegram service
     * @throws Exception
     */
    public function sendChatId(int $chatId) {
        $message = urlencode('Your chat id is ' . (string)$chatId);
        try {
            return $this->sendMessage($chatId, $message);
        } catch (ClientExceptionInterface $e) {
            throw new Exception('Client exception: ' . $e->getMessage());
        } catch (RedirectionExceptionInterface $e) {
            throw new Exception('Redirection exception: ' . $e->getMessage());
        } catch (ServerExceptionInterface $e) {
            throw new Exception('Server exception: ' . $e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new Exception('Transport exception: ' . $e->getMessage());
        }
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