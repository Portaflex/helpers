<?php

namespace helpers\editor;

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
    
  }
  
  public function registerAssets()
  {
      $view = $this->getView();
      $id = $this->options['id'];
      
      $out .= "<script>CKEDITOR.replace(".$op['id'].", {toolbar: '$preset', height: $height, width: '$width'})</script>"."\n";
	    $out .= '<script>CKEDITOR.dtd.$removeEmpty["span"] = false;</script>';
  }
}
