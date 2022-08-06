<h4 class="mt-3 pl-3"><?= $this->langLine('visitlog_head') ?></h4>
<hr />

<div id="accordion">
    <?php foreach ($this->buffer->logs as $k => $v): ?>
        <div class="card mt-3">
            <div class="card-header" id="heading_<?= $k ?>">
                <h5 class="mb-0"><button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse_<?= $k ?>" aria-expanded="false" aria-controls="collapseOne"><?= $k ?></button></h5>
            </div>
            <div id="collapse_<?= $k ?>" class="collapse" aria-labelledby="heading_<?= $k ?>" data-parent="#accordion">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->langLine('visitlog_t1') ?></th>
                                <th scope="col"><?= $this->langLine('visitlog_t2') ?></th>
                                <th scope="col"><?= $this->langLine('visitlog_t3') ?></th>
                                <th scope="col"><?= $this->langLine('visitlog_t4') ?></th>
                                <th scope="col"><?= $this->langLine('visitlog_t5') ?></th>
                                <th scope="col"><?= $this->langLine('visitlog_t6') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($v)): ?>
                                <tr>
                                    <td colspan="6"><div class="p-2 bg-secondary text-white text-center rounded"><?= $this->langLine('visitlog_err_1') ?></div></td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($v as $val):?>
                                    <tr>
                                        <td><?= $val['Time'] ?></td>
                                        <td><?= $val['Visitor'] ?></td>
                                        <td><?= $val['Browser'] ?></td>
                                        <td><?= $val['OS'] ?></td>
                                        <td><?= $val['Ip'] ?></td>
                                        <td><?= $val['Url'] ?></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>