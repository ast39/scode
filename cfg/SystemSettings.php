<?php
/**
 * Created by PhpStorm.
 * User: Alexandr Statut
 * Date: 22.07.2019
 * Time: 14:05
 */

namespace cfg;


class SystemSettings {

    # кодировка сайта
    public static $charset = 'utf-8';

    # протокол сайта
    public static $protocol = 'https';

    # сайт в каталоге
    public static $site_dir = '';

    # экстренно остановить сайт
    public static $site_stop = false;

    # мультиязычный сайт
    public static $multi_lang = false;

    # вкл / выкл вывод ошибок
    public static $production = true;

    # вкл / выкл дебаг информации
    public static $debug = true;

    # логирование посещений сайта
    public static $log_visits = true;

    # логирование ошибок сайта
    public static $log_errors = true;

    # страница авторизации
    public static $login_page = 'login';

    # url для доступа в админку
    public static $admin_partition = 'site_admin/';

    # язык сайта по умолчанию
    public static $def_lang = 'ru';

    # страница ( класс ) по умолчанию
    public static $def_page = 'home';

    # метод, запускаемый автоматически в каждом классе ( странице )
    public static $def_method = 'index';

    # имя массива сессии с данными
    public static $session_array = 'sc';

    # время жизни сессионной куки
    public static $session_set_cookie_params = 7200;

    # максимальный размер загружаемых файлов (в МБ)
    public static $max_upload_size = 8;

    # рутовый доступ к админке сайта
    public static $root_login    = 'root';
    public static $root_password = '';

    # авторизационные данные клиента к админке сайта
    public static $admin_login    = 'admin';
    public static $admin_password = '';

    # права доступа к создаваемым каталогам
    public static $dir_access = 0755;
    
    # метка авторизации на сайте
    public static $user_auth_mark = '_auth_user_';
    
    # метка авторизации в админке
    public static $admin_auth_mark = '_auth_admin_';
    
    # метка авторизации под рутом
    public static $root_auth_mark = '_auth_root_';

    # почта для отправки писем о падении сайта, запросов к БД и т.д.
    public static $admin_mail = 'admin.sc@gmail.com';

    # почта для отправки писем от пользователей сайта.
    public static $public_mail = 'support.sc@gmail.com';
    
    # время кэширования
    public static $cache_time = 3600;

    # массив языковых версий сайта
    public static $site_langs = [
        'ru',
        'en'
    ];

}

?>