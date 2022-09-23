<?php

namespace helpers\editor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Editor extends InputWidget
{
  public $preset;
  
  public $config = [];
  
  public function init()
  {
        parent::init(); 
        $this->config['customConfig'] = 'config.js';
        $this->config['toolbar'] = 'Consulta';
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
        $config = $this->config ? Json::encode($this->config) : '{}';
        
        EditorAsset::register($view);
        KCAsset::register($view);
      
        $js[] = "CKEDITOR.replace('$id', $config);";
	$js[] = 'CKEDITOR.dtd.$removeEmpty["span"] = false;';
        
        $view->registerJs(implode("\n", $js));
  }
}
