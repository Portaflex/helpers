/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'es';
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
 	config.toolbar_Consulta = [
            { name: 'insert', items : [ 'Image' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
            { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
            { name: 'styles', items : [ 'Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic' ] },
            { name: 'tools', items : [ 'Maximize'] }
	];
	
	config.toolbar = 'Factura';
 	config.toolbar_Factura = [
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
            { name: 'styles', items : [ 'Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor' ] },
            { name: 'basicstyles', items : [ 'Bold','Italic' ] },
	];
};
