<?php $i = 1; ?>
<?php foreach ($models as $model) { ?>
    <?php if (($i + 3) % 4 === 0) echo '<li class="post-slider__item row">'; ?>
    <article class="post-slider__article<?= ($model->id === $lastModel->id) ? ' post-slider__article_last' : '' ?> col-md-6" data-id="<?= $model->id ?>">
        <?= $this->renderFile('@app/views/about/post/_item.php', [
            'model' => $model,
        ]) ?>
    </article>
    <?php if ($i % 4 === 0) echo '</li>'; ?>
    <?php $i++; ?>
<?php } ?>
