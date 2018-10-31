<?php
namespace Woddp\Notemenu\main;
class MenuModel{
    public $name='';//名称
    public $idName='';//标识
    public $controller="";//控制器
    public $action='';//方法
    public $parent='';//父标识
    public $display='';//是否显示
    public $order='';//排序
    public $icon='';//图标
    public $hasView='';//是否有底部菜单
    public $remark='';//备注

    public function __construct($name="",$idName="",$controller="",$action="",$parent="",$display="",$hasView="",$order="",$icon="",$remark=""){
        $this->name=$name;
        $this->idName=$idName;
        $this->controller=$controller;
        $this->action=$action;
        $this->parent=$parent;
        $this->display=$display;
        $this->order=$order;
        $this->icon=$icon;
        $this->hasView=$hasView;
        $this->remark=$remark;
    }
}