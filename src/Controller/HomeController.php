<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/{token}", name="home")
     */
    public function index(String $token, Request $request, LoggerInterface $logger)
    {
        // Thick controller
        // On request we get chat id from the Update and send it back
        // to the user
        // example curl request:
        // curl -X POST -H "Content-Type: application/json" -d '{"update_id":"123","message":{"message_id":"321", "chat":{"id":12345}}}' http://127.0.0.1:8000/123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
        $botToken = $_ENV['BOT_TOKEN'];
        if ($botToken != $token) {
            throw new NotFoundHttpException();
        }
        $content = $request->getContent();
        // https://core.telegram.org/bots/api#update
        $update = json_decode($content);
        $updateId = $update->update_id;
        $message = $update->message;
        // https://core.telegram.org/bots/api#message
        $messageId = $message->message_id;
        $messageChat = $message->chat;
        // https://core.telegram.org/bots/api#chat
        $chatId = $messageChat->id;
        //$text = $message->text;

        $logger->info($content);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
            'update_id' => $updateId,
            'message_id' => $messageId,
            'chat_id' => $chatId,
        ]);
    }
}
