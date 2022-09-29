<?php
/**
 * This is the template for generating an action view file.
 */

/** @var yii\web\View $this */
/** @var yii\gii\generators\form\Generator $generator */

$class = str_replace('/', '-', trim($generator->viewName, '_'));
$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var ActiveForm $form */
<?= "?>" ?>

<div class="<?= $class ?>">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <?= "<div class='row row-cols-".$generator->getColumnNumber()."'>\n"?>

    <?php foreach ($generator->getModelAttributes() as $attribute): ?>
    <?= "<?= " ?>$form->field($model, '<?= $attribute ?>') ?>
    <?php endforeach; ?>

     <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Guardar') ?>, ['update', <?= $urlParams ?>], [
            'class' => 'btn btn-primary btn-sm']) ?>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Cancelar') ?>, ['index'], [
            'class' => 'btn btn-secondary btn-sm']) ?>
        <?= '<?php if ($model->' . $generator->getColumnNames()[0] . ') {'; ?>
        <?= "\n             echo Html::a(" . $generator->generateString('Borrar') . ", ['delete', ". $urlParams . "], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => " . $generator->generateString('Está seguro del borrado?') . ",
                    'method' => 'post'
                ]]); } ?>"
        ?>
    </p>
    <?= "<?php " ?>ActiveForm::end(); ?>

</div><!-- <?= $class ?> -->
