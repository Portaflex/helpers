<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/** @var yii\web\View $this */
/** @var yii\gii\generators\crud\Generator $generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\filters\VerbFilter;

class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    public $d;
    
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
    <?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    <?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                <?php foreach ($pks as $pk): ?>
                <?= "'$pk' => SORT_DESC,\n" ?>
                <?php endforeach; ?>
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    <?php endif; ?>
    }

    public function actionEdit()
    {
        $model = new <?= $modelClass ?>;
        
        if ($data = $this->request->post()) {
            if ($data['<?= $modelClass ?>']['<?= $pks[0] ?>'] != '') {
                $model = <?= $modelClass ?>::findOne($data['<?= $modelClass ?>']['<?= $pks[0] ?>']);
                if ($data['action'] == 'save') {
                    $model->load($data);
                    $model->save();
                } elseif ($data['action'] == 'delete') {
                    $model->delete();
                    return $this->redirect('index');
                }    
            } if ($data['<?= $modelClass ?>']['<?= $pks[0] ?>'] == '') {
                $model->loadDefaultValues();
                $model->load($data);
                $model->save();
            }
        }
        if ($data = $this->request->get()) {
            if (isset ($data['<?= $pks[0] ?>'])) {
                $model = <?= $modelClass ?>::findOne($data['<?= $pks[0] ?>']);
            }
        }
        $this->d['model'] = $model;
        return $this->render('edit', $this->d);
    }
}
