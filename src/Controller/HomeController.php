<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, LoggerInterface $logger)
    {
        $content = $request->getContent();
        $update = json_decode($content);
        $updateId = $update->update_id;
        $message = $update->message;
        $messageId = $message->message_id;
        $text = $message->text;

        $logger->info($content);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
            'update_id' => $updateId,
            'message_id' => $messageId,
            'text' => $text,
        ]);
    }
}
