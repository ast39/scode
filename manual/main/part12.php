<div class="p-3 mb-2 bg-secondary text-white">Системные библиотеки <code><a class="text-warning" href="/manual/index.php?part=<?= $_GET['part'] ?>">\core</a></code></div>
<?php if (isset($_GET['add'])): ?>
    <?php include_once __DIR__ . "/../dir12/part" . $_GET['add'] . ".php"; ?>
<?php else: ?>
    <table class="table">
        <tbody>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1201">\core\Benchmark</a></code></td>
            <td class="text-left">Класс для профилирования времени загрузки разных частей приложения</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1202">\core\Buffer</a></code></td>
            <td class="text-left">Класс для хранения и переноса информации</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1203">\core\Cacher</a></code></td>
            <td class="text-left">Класс для кэширования информации</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1204">\core\Component</a></code></td>
            <td class="text-left">Класс, запускающий компонент</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1205">\core\Controller</a></code></td>
            <td class="text-left">Основной класс, запускающий выполнение страницы</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1206">\core\Lang</a></code></td>
            <td class="text-left">Класс вывода нужной языковой переменной</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1207">\core\Log</a></code></td>
            <td class="text-left">Класс работы с логированием</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1208">\core\Route</a></code></td>
            <td class="text-left">Класс работы с URL</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1210">\core\SiteIndexing</a></code></td>
            <td class="text-left">Класс определения юера, браузера, устройства и т.д.</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1214">\core\SystemMessage</a></code></td>
            <td class="text-left">Класс работы с уведомлениями</td>
        </tr>
        <tr>
            <td class="text-left"><code><a class="text-primary" href="/manual/index.php?part=<?= $_GET['part'] ?>&add=1211">\core\SoapNative</code></td>
            <td class="text-left">Класс для расширения работы с Soap Client</td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>