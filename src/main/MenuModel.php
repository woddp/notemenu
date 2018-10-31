<?php
namespace Woddp\Notemenu\main;
class MenuModel{
    public $name='';
    public $idName='';
    public $controller="";
    public $action='';
    public $parent='';
    public $display='';
    public $order='';
    public $icon='';
    public $remark='';

    public function __construct($name="",$idName="",$controller="",$action="",$parent="",$display="",$order="",$icon="",$remark=""){
        $this->name=$name;
        $this->idName=$idName;
        $this->controller=$controller;
        $this->action=$action;
        $this->parent=$parent;
        $this->display=$display;
        $this->order=$order;
        $this->remark=$remark;
    }
}