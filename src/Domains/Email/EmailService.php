<?php

namespace kosuha606\VirtualAdmin\Domains\Email;

use kosuha606\VirtualModel\VirtualModelManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Email
 */
class EmailService
{
    /**
     * @param EmailDTO $emailDTO
     * @throws \Exception
     */
    public function send(EmailDTO $emailDTO)
    {
        $mail = VirtualModelManager::getEntity(Email::class)::create([
            'to_email' => $emailDTO->getToEmail(),
            'from_email' => $emailDTO->getFromEmail(),
            'bcc' => $emailDTO->getBcc(),
            'subject' => $emailDTO->getSubject(),
            'body' => $emailDTO->getBody(),
        ])->send();
    }
}