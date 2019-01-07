<?php
use kouosl\theme\helpers\Html;
use kouosl\theme\widgets\Portlet;


$this->title = 'Update forum';
$data['title'] = Html::encode($this->title);
$this->params['breadcrumbs'][] = $this->title;


$this->params['pageTitle'] 	= $this->title;
$this->params['pageDesc'] 	= 'describes the forum features';

$data['model']          = $model;
$data['uploadImage']    = $uploadImage;
$formView	            = $this->render('_form',$data);

Portlet::begin(['title' => $this->title, 'icon' => 'glyphicon glyphicon-cog']);

    echo $this->render('update', ['formView' => $formView]);

Portlet::end();