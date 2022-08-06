<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 14:05
 */

namespace cfg;


class Settings extends SystemSettings
{
    # конфиг для Телеграмм бота
    public static $telegram_cfg = [
        'test' => 'test'
    ];

    # списки чатов для телеграма
    public static $telegram_chats = [
        'test' => 'test'
    ];
}

?>