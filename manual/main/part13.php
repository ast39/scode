<div class="p-3 mb-2 bg-secondary text-white">Вспомогательные классы <code><a class="text-warning" href="/manual/index.php?part=<?= $_GET['part'] ?>">\helpers</a></code></div>
<?php if (isset($_GET['add'])): ?>
    <?php include_once __DIR__ . "/../dir13/part" . $_GET['add'] . ".php"; ?>
<?php else: ?>
    <table class="table">
        <tbody>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1301">\helper\DataBuilder</a></code></td>
            <td class="text-left">Класс работы с данными</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1302">\helper\Censure</a></code></td>
            <td class="text-left">Класс цензуры текста</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1303">\helper\Crypt</a></code></td>
            <td class="text-left">Класс шифрования / дешифрования</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1304">\helper\CSV</a></code></td>
            <td class="text-left">Класс получения / записи данных в CSV файлы</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1305">\helper\Date</a></code></td>
            <td class="text-left">Класс работы с датой и временем</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1307">\helper\RegExp</a></code></td>
            <td class="text-left">Класс для валидации по <code>RegExp</code></td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1308">\helper\Request</a></code></td>
            <td class="text-left">Класс для безопасного получения <code>Request</code> данных</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1309">\helper\Session</a></code></td>
            <td class="text-left">Класс для простой работы с сессией</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1310">\helper\Text</a></code></td>
            <td class="text-left">Класс для работы с текстом</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1311">\helper\Validator</a></code></td>
            <td class="text-left">Класс валидации по <code>filter_var()</code></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>