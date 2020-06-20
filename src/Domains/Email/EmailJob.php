<?php

namespace kosuha606\VirtualAdmin\Domains\Email;

use kosuha606\VirtualAdmin\Domains\Queue\QueueJobInterface;
use kosuha606\VirtualModelHelppack\ServiceManager;

/**
 * @package kosuha606\VirtualAdmin\Domains\Email
 */
class EmailJob implements QueueJobInterface
{
    /**
     * @param array $arguments
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function run($arguments = [])
    {
        $dto = (new EmailDTO())
            ->setFromEmail($arguments['from_email'])
            ->setToEmail($arguments['to_email'])
            ->setBody($arguments['body'])
            ->setSubject($arguments['subject'])
        ;

        if (isset($arguments['bcc'])) {
            $dto->setBcc($arguments['bcc']);
        }

        $emailService = ServiceManager::getInstance()->get(EmailService::class);
        $emailService->send($dto);
    }
}