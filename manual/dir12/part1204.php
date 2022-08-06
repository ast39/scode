<div class="p-3 mb-2 bg-light text-secondary border">Класс, запускающий компонент <code>\core\Component</code></div>
<div class="code-text border mb-2 p-2 pl-3 text-secondary">
    Сорсник компонента распологается в <code>project\controllers\components</code>
    <br />
    Шаблон компонента распологается в <code>project\templates\components</code>
</div>
<div class="code_block mb-2">
    <ol>
        <li>
            <span class="comment">// Подгрузить шаблон компонента</span>
        </li>
        <li>
            <span class="line_code"><span class="variable">$this</span>->loadTemplate():</span>
        </li>
        <li></li>
        <li>
            <span class="comment">// Подгрузить произвольный шаблон компонента</span>
        </li>
        <li>
            <span class="line_code"><span class="variable">$this</span>->loadTemplate(<span class="data">'test_tpl'</span>);</span>
        </li>
    </ol>
</div>
<div class="alert alert-warning mb-2">Вам доступны все методы основного контроллера <code>core\controller</code></div>