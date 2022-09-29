<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap4\Html;

$urlParams = $generator->generateUrlParams();

/** @var yii\web\View $this */
/** @var yii\gii\generators\crud\Generator $generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$pks = $model::primaryKey();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var <?= ltrim($generator->modelClass, '\\') ?> $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    
<?php //** Var $count indicates how many fields per column ?>
<?php $count = intdiv(count($generator->getColumnNames()) , $generator->getColumnNumber()); ?>
<?php $c = $count; ?>

<?= "<div class='container'>\n"?>  
<?= "<?php " ?>$form = ActiveForm::begin(); ?>
<?= "<div class='row row-cols-".$generator->getColumnNumber()."'>\n"?>
    
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        if ($c == $count) {
            echo "<div class='col'>\n";
            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
            $c--;
        } elseif ($c < $count && $c > 0) {
            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
            $c--;
        } elseif ($c == 0) {
            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n" ;
            echo "</div>"."\n";
            $c = $count;
        }
    }
}
?><br>
    <?= "<?= Html::submitButton('Guardar', ['class' => 'btn btn-sm btn-primary',
             'name' => 'action', 'value' => 'save']) ?> " . "\n" ?>
    <?= '<?php if ($model->' . $pks[0] .') { ?>' . "\n" ?>
    <?= '<?= Html::submitButton("Eliminar", ["class" => "btn btn-sm btn-danger",
             "name" => "action",  "value" => "delete",
             "onclick" => "confirm(\'Desea eliminar permanentemente este registro?\')"]) ?>' . "\n" ?>
    <?= '<?php } ?>'."\n" ?>
    <?= "<?= Html::a('Volver', 'index' , ['class' => 'btn btn-sm btn-secondary']) ?>" ?>
<?= "</div></div>" ?>
<?= "<?php " ?>ActiveForm::end(); ?>
<?= "</div></div></div>\n" ?>
