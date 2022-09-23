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
        ConfigAsset::register($view);
      
        $js[] = "CKEDITOR.editorConfig = function(config) {
                    config.language = 'es';
                    config.uiColor = '#ffffff';
                    config.filebrowserBrowseUrl = '/assets/kcfinder/browse.php?type=files';
                    config.filebrowserImageBrowseUrl = '/assets/kcfinder/browse.php?type=images';
                    config.filebrowserFlashBrowseUrl = '/assets/kcfinder/browse.php?type=flash';
                    config.filebrowserUploadUrl = '/assets/kcfinder/upload.php?type=files';
                    config.filebrowserImageUploadUrl = '/assets/kcfinder/upload.php?type=images';
                    config.filebrowserFlashUploadUrl = '/assets/kcfinder/upload.php?type=flash';

                    config.htmlEncodeOutput = false;
                    config.entities = true;
                    config.allowedContent = true;
                    config.enterMode = CKEDITOR.ENTER_BR;
                    config.forcePasteAsPlainText = true;

                    config.toolbar = 'DS';
                    config.toolbar_DS = [
                        { name: 'document', items: [ 'Source'] },
                            { name: 'clipboard', items: [ 'Cut', 'PasteText', 'PasteFromWord', 'Undo', 'Redo' ] },
                            { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                            '/',
                            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                            { name: 'insert', items: [ 'Image', 'Flash', 'Youtube', 'Glyphicons', 'Source', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                            { name: 'tools', items: [ 'Maximize'] },
                    ];

                    config.toolbar = 'Consulta';
                    config.toolbar_Consulta =
                    [
                            { name: 'insert', items : [ 'Image' ] },
                            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
                            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
                            { name: 'styles', items : [ 'Font','FontSize' ] },
                            { name: 'colors', items : [ 'TextColor' ] },
                            { name: 'basicstyles', items : [ 'Bold','Italic' ] },
                            { name: 'tools', items : [ 'Maximize'] }
                    ];

                    config.toolbar = 'Factura';
                    config.toolbar_Factura =
                    [
                            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
                            { name: 'styles', items : [ 'Font','FontSize' ] },
                            { name: 'colors', items : [ 'TextColor' ] },
                            { name: 'basicstyles', items : [ 'Bold','Italic' ] }
                    ];
                };";
        $js[] = "CKEDITOR.replace('$id', $config);";
	$js[] = 'CKEDITOR.dtd.$removeEmpty["span"] = false;';
        
        $view->registerJs(implode("\n", $js));
  }
}
