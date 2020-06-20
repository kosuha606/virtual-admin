<?php

namespace kosuha606\VirtualAdmin\Domains\Email;

use kosuha606\VirtualModel\VirtualModel;

/**
 * @package kosuha606\VirtualAdmin\Domains\Email
 */
class Email extends VirtualModel
{
    const KEY = 'email';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'id',
            'to_email',
            'from_email',
            'bcc',
            'subject',
            'body',
        ];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function send()
    {
        $ids = $this->save();

        return parent::send($ids);
    }
}