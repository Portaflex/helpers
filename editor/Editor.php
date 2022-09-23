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
  }
}
