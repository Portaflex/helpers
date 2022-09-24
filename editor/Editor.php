<?php

namespace helpers\editor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Editor extends InputWidget
{
  public $toolbar;
  
  public function init()
  {
        parent::init();
        if ($this->toolbar === null)
        {
            $this->toolbar = 'Consulta';
        }
  }
  
  public function run()
  {
        if ($this->hasModel()) {
            $out = Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $out = Html::textarea($this->name, $this->value, $this->options);
        }
        echo $out;
        
        $this->registerPlugin();
  }
  
  public function registerPlugin()
  {
        $js = [];  
        $view = $this->getView();
        $id = $this->options['id'];
        $toolbar = $this->toolbar;
        
        EditorAsset::register($view);
        ConfigAsset::register($view);
      
        $js[] = "CKEDITOR.replace('$id', {toolbar:'$toolbar', skin: 'kama'});";
        //$js[] = 'CKEDITOR.dtd.$removeEmpty["span"] = false;';
        
        $view->registerJs(implode("\n", $js));
  }
}
