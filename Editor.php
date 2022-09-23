<?php

namespace helpers;

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
        $this->registerPlugin();
  }
  
  public function registerPlugin()
  {
        $js = [];  
        $view = $this->getView();
        $id = $this->options['id'];
        
        EditorAsset::register($view);
        KCAsset::register($view);
      
        $js[] = "\n"."<script>CKEDITOR.replace('#$id');</script>"."\n";
	$js[] = '<script>CKEDITOR.dtd.$removeEmpty["span"] = false;</script>';
        echo $out;
  }
}
