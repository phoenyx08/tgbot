<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/{token}", name="home")
     */
    public function index(String $token, Request $request, LoggerInterface $logger, HttpClientInterface $client)
    {
        // Thick controller
        // On request we get chat id from the Update and send it back
        // to the user
        // example curl request:
        // curl -X POST -H "Content-Type: application/json" -d '{"update_id":"123","message":{"message_id":"321", "chat":{"id":012345678}}}' http://127.0.0.1:8000/123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
        $botToken = $_ENV['BOT_TOKEN'];
        if ($botToken != $token) {
            throw new NotFoundHttpException();
        }
        $content = $request->getContent();
        $logger->info($content);
        // https://core.telegram.org/bots/api#update
        $update = json_decode($content);
        //$updateId = $update->update_id;
        $message = $update->message;
        // https://core.telegram.org/bots/api#message
        $messageChat = $message->chat;
        // https://core.telegram.org/bots/api#chat
        $chatId = $messageChat->id;

        $encodedMessage = urlencode('Your chat id is ' . (string)$chatId);

        $response = $client->request(
            'GET',
            'https://api.telegram.org/bot' . $botToken . '/sendMessage?chat_id='. $chatId . '&text=' . $encodedMessage);
        $responseContent = $response->getContent();

        return $this->json([
            'chat_id' => $chatId,
            'response_content' => $responseContent,
        ]);
    }
}
