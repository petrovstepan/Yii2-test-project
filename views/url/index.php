<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

?>


<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'query') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>


<?php if (count($searches) > 0): ?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Автор</th> <th>Url</th> <th>Ключевое слово</th> <th>Результат</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($searches as $s): ?>
        <tr>
            <td><?=Html::encode($s->user->name)?></td>
            <td><?=$s->url->url?></td>
            <td><?=Html::encode($s->query)?></td>
            <td><?=Html::encode($s->result)?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

