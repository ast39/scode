<style>
    .code-text {
        font-size: 13px;
    }
    .code_block {
        padding: 8px 16px;
        background-color: #fff;
        border: 0.5px solid #ddd;
        box-shadow: inset 47px 0 0 #fbfbfc, inset 48px 0 0 #ececf0;
        font-family: "Consolas","Bitstream Vera Sans Mono","Courier New",Courier,monospace!important;
        color: #333;
        font-size: 12px;
        display: block;
        line-height: 16px;
    }
    .code_block ol {
        margin: 0 0 0 -8px;
    }
    .code_block ol li {
        padding-left: 12px;
        color: #afafaf;
        line-height: 1.8em;
        list-style: decimal;
    }
    .code_block ol li .line_code {
        color: #212529 !important;
    }
    .code_block .comment {
        font-style: italic;
        color: #afafaf;
    }
    .code_block .keywords {
        font-weight: bold;
        color: #069;
    }
    .code_block .class {
        color: #008200;
    }
    .code_block .method {
        color: #ff1493;
    }
    .code_block .variable {
        color: #a70;
    }
    .code_block .data {
        color: blue;
    }
    .code_block li.tab1 {
        padding-left: 3em !important;
    }
    .code_block li.tab2 {
        padding-left: 6em !important;
    }
    .code_block li.tab3 {
        padding-left: 9em !important;
    }
    .code_block li.tab4 {
        padding-left: 12em !important;
    }
</style>

<h4 class="mt-3 pl-3"><?= $this->langLine('errorlog_head') ?></h4>
<hr />

<div id="accordion">
    <?php foreach ($this->buffer->logs as $day => $day_data): ?>
        <div class="card mt-3">
            <div class="card-header" id="heading_<?= $day ?>">
                <div class="p-0 m-0 bg-light text-secondary border"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_<?= $day ?>" aria-expanded="false" aria-controls="collapseOne"><?= $day ?></button></div>
            </div>
            <div id="collapse_<?= $day ?>" class="collapse" aria-labelledby="heading_<?= $k ?>" data-parent="#accordion">
                <div class="card-body">
                    <?php if (empty($day_data)): ?>
                        <div class="p-2 bg-secondary text-white text-center rounded"><?= $this->langLine('errorlog_err_1') ?></div>
                    <?php else: ?>
                        <?php foreach ($day_data as $data): ?>
                            <div class="code_block m-0 mb-2">
                                <ol>
                                    <li><span class="keywords">Tipe:</span> <span class="line_code"><?= $data['type'] ?></span></li>
                                    <li><span class="keywords">Time:</span> <span class="line_code"><?= $data['time'] ?></span></li>
                                    <li><span class="keywords">IP:</span> <span class="line_code"><?= $data['ip'] ?></span></li>
                                    <li><span class="keywords">Code:</span> <span class="line_code"><?= $data['code'] ?></span></li>
                                    <li><span class="keywords">File:</span> <span class="line_code"><?= $data['file'] ?></span></li>
                                    <li><span class="keywords">Line:</span> <span class="line_code"><?= $data['line'] ?></span></li>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data['trace'] as $row_1): ?>
                                        <li><span class="variable">Trace data <span class="class"><?= $i ?></span></span></li>
                                        <?php foreach ($row_1 as $key => $value): ?>
                                            <li class="tab1"><span class="data"><?= $key ?>:</span> <span class="line_code"><?= is_array($value) ? json_encode($value) : $value ?></span></li>
                                        <?php endforeach; ?>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>