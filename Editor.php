<?php

namespace helpers;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class Editor extends InputWidget
{
  public $preset;
  
  public $config = [];
  
  public function init()
  {
        parent::init(); 
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
        
        EditorAsset::register($view);
        KCAsset::register($view);
      
        $js[] = "<script>CKEDITOR.replace('#$id');</script>";
	//$js[] = '<script>CKEDITOR.dtd.$removeEmpty["span"] = false;</script>';
        
        $view->registerJs(implode("\n", $js));
  }
}
