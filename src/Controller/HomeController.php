<?php

namespace App\Controller;

use App\Model\Update;
use App\Service\Messenger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Main endpoint of the application.
     *
     * Right now we check requested url, its token parameter should be the same
     * as bot-token. If they are not equal endpoint requrns 404. If the check is passed
     * we send chat Id back to the user.
     * example curl request:
     * curl -X POST -H "Content-Type: application/json" \
     * -d '{"update_id":"123","message":{"message_id":"321", "chat":{"id":012345678}}}' \
     * http://127.0.0.1:8000/123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11
     * @param String $token Token contained in the Telegram-service request
     * @param LoggerInterface $logger Injects PSR-logger service
     * @param Messenger $messenger Injects service, responsible for sending messages
     * @param Request $request Injects OOP-presendation of the request being sent to the endpoint
     *
     * @Route("/{token}", name="home")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(string $token, Request $request, LoggerInterface $logger, Messenger $messenger)
    {
        $botToken = $_ENV['BOT_TOKEN'];

        if ($botToken != $token) {
            throw new NotFoundHttpException();
        }

        $content = $request->getContent();
        $logger->info($content);
        $update = new Update($content);
        $message = $update->getMessage();
        $messageChat = $message->getChat();
        $chatId = $messageChat->getId();
        $responseContent = $messenger->sendChatId($chatId);
        $logger->info(json_encode($responseContent));

        return $this->json([
            'result' => 'ok',
        ]);
    }
}
