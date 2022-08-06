<div class="p-3 pl-5 mb-2 bg-secondary text-white">Работа с почтой</div>

<div class="alert alert-warning mb-2">Не забудьте перед началом работы выполнить команду <code>composer install</code> в консоли</div>

<div class="text-secondary bg-light border font-weight-normal p-1 pl-5 mb-2">\cfg\mail.php</div>
<div class="code_block mb-2">
    <ol>
        <li>
            <span class="line_code"><span class="keywords">require_once</span>(<span class="variable">__DIR__</span> . '/../vendor/autoload.php') <span class="variable">or die</span>(<span class="data">'Vendor autoload file is missing'</span>);</span>
        </li>
        <li></li>
        <li>
            <span class="line_code"><span class="variable">$config_mail</span> = [</span>
        </li>
        <li class="tab1">
            <span class="line_code"><span class="data">'test'</span> => [</span>
        </li>
        <li class="tab2">
            <span class="line_code">'transport' => <span class="data">'smtp'</span>,</span>
        </li>
        <li class="tab2">
            <span class="line_code">'host' => <span class="data">'smtp.mail.ru'</span>,</span>
        </li>
        <li class="tab2">
            <span class="line_code">'port' => <span class="data">465</span></span>
        </li>
        <li class="tab2">
            <span class="line_code">'encryption' => <span class="data">'ssl'</span>,</span>
        </li>
        <li class="tab2">
            <span class="line_code">'username' => <span class="data">'user@test.com'</span>,</span>
        </li>
        <li class="tab2">
            <span class="line_code">'password'  => <span class="data">'neversay'</span>,</span>
        </li>
        <li class="tab2">
            <span class="line_code">'timeout'   => <span class="data">null</span>,</span>
        </li>
        <li>
            <span class="line_code">'auth_mode' => <span class="data">null</span>,</span>
        </li class="tab2">
        <li>
            <span class="line_code">'from' => <span class="data">'user@test.com'</span></span>
        </li>
        <li class="tab2">
            <span class="line_code">'from_name' => <span class="data">'test user'</span></span>
        </li>
        <li class="tab1">
            <span class="line_code">],</span>
        </li>
        <li>
            <span class="line_code">];</span>
        </li>
        <li></li>
        <li>
            <span class="line_code"><span class="variable">$mailer</span> = [];</span>
        </li>
        <li></li>
        <li>
            <span class="line_code"><span class="keywords">foreach</span> (<span class="variable">$config_mail</span> <span class="keywords">as</span> <span class="variable">$name</span> <span class="keywords">=><span class="keywords"> <span class="variable">$box</span>) {</span>
        </li>
        <li></li>
        <li class="tab1">
            <span class="line_code"><span class="variable">$transport</span> = (<span class="keywords">new</span> <span class="class">\Swift_SmtpTransport</span>(
        </li>
        <li class="tab2">
            <span class="variable">$box[<span class="data">'host'</span>]</span>,
        </li>
        <li class="tab2">
            <span class="variable">$box[<span class="data">'port'</span>]</span>,
        </li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$box[<span class="data">'encryption'</span>]</span>))</span>
        </li>
        <li class="tab2">
            <span class="line_code">-><span class="method">setUsername</span>(<span class="variable">$box[<span class="data">'user'</span>]</span>)</span>
        </li>
        <li class="tab2">
            <span class="line_code">-><span class="method">setPassword</span>(<span class="variable">$box[<span class="data">'password'</span>]</span>)</span>
        </li>
        <li class="tab2">
            <span class="line_code">-><span class="method">setAuthMode</span>(<span class="variable">$box[<span class="data">'auth_mode'</span>]</span>);</span>
        </li>
        <li></li>
        <li class="tab1">
            <span class="line_code"><span class="variable">$mailer[<span class="data">$name</span>]</span> = <span class="keywords">new</span> <span class="class">Swift_Mailer</span>(<span class="variable">$transport</span>);</span>
        </li>
        <li class="tab1">
            <span class="line_code"><span class="variable">$mailer[<span class="data">$name</span>]</span>->user_cfg = <span class="variable">$box</span>;</span>
        </li>
        <li>
            <span class="line_code">}</span>
        </li>
        <li></li>
        <li>
            <span class="line_code"><span class="keywords">return</span> <span class="variable">$mailer</span>;</span>
        </li>
    </ol>
</div>

<div class="text-secondary bg-light border font-weight-normal p-1 pl-5 mb-2">Контроллер</div>
<div class="code_block mb-2">
    <ol>
        <li>
            <span class="line_code"><span class="keywords">class</span> Name <span class="keywords">extends</span> <span class="class">Controller</span> {</span>
        </li>
        <li></li>
        <li class="tab1">
            <span class="line_code"><span class="keywords">public function</span> <span class="method">__construct()</span></span>
        </li>
        <li class="tab1">
            <span class="line_code">{</span>
        </li>
        <li class="tab2">
            <span class="line_code"><span class="class">parent</span>::<span class="method">__construct()</span>;</span>
        </li>
        <li class="tab1">
            <span class="line_code">}</span>
        </li>
        <li>
            <span class="line_code"></span>
        </li>
        <li class="tab1">
            <span class="line_code"><span class="keywords">public function</span> <span class="method">index()</span></span>
        </li>
        <li class="tab1">
            <span class="line_code">{</span>
        </li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$mailer_factory</span> = <span class="keywords">include</span> <span class="variable">ROOT</span> . 'cfg/mail.php';</span>
        </li>
        <li></li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$mailer</span> = <span class="variable">$mailer_factory[<span class="data">'test'</span>]</span>;</span>
        </li>
        <li></li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$message</span> = <span class="keywords">new</span> <span class="class">\Swift_Message()</span>;</span>
        </li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$message</span></span>
        </li>
        <li class="tab3">
            <span class="line_code">-><span class="method">setSubject(<span class="data">'Subject'</span>)</span></span>
        </li>
        <li class="tab3">
            <span class="line_code">-><span class="method">setFrom([<span class="variable">$mailer->user_cfg[<span class="data">'from'</span></span>] => <span class="variable">$mailer->user_cfg[<span class="data">'from_name'</span></span>]])</span></span>
        </li>
        <li class="tab3">
            <span class="line_code">-><span class="method">addTo(<span class="data">'friend@gmail.com'</span>, <span class="data">'My friend'</span>)</span></span>
        </li>
        <li class="tab3">
            <span class="line_code">-><span class="method">setBody(<span class="data">'Hello, my friend!'</span>)</span>;</span>
        </li>
        <li></li>
        <li class="tab2">
            <span class="line_code"><span class="variable">$mailer</span>->send(<span class="variable">$message</span>);</span>
        </li>
        <li class="tab1">
            <span class="line_code">}</span>
        </li>
        <li>
            <span class="line_code">}</span>
        </li>
    </ol>
</div>

<div class="alert alert-warning mb-2">Подробная инструкция о работе с модулем <a href="https://symfony.ru/doc/current/mailer.html#id7" target="_blank">тут</a></div>
