<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 17:15
 */

namespace Woddp\Notemenu\main;


use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class Notemenu
{

    protected $session;
    protected $config;

    private $root = "";
    private $namespace = "";
    private $files = [];

    public static  function getMenu($rootPath,$path,$namespace){
        return (new Notemenu())->getBulidMenu($rootPath,$path,$namespace);
    }

    /**
     * @param $rootPath
     * @param $path
     * @param $namespace
     * @return array
     * @throws \ReflectionException
     */
    public function getBulidMenu($rootPath,$path,$namespace)
    {
       $this->namespace=$namespace;
       $fiels= $this->analyseFiles($path);
        foreach ($fiels as $file){
            $className=ucfirst(str_replace($rootPath.DIRECTORY_SEPARATOR,'',$file));
            $className=str_replace(".php","",$className);
            $class=new \ReflectionClass($className);
            $classDocComment=$class->getDocComment();

            $controller=str_replace($this->namespace.DIRECTORY_SEPARATOR,'',$className);
            $result=$this->analyseParame($classDocComment,$controller);
            if(!empty($result)){
                $data[]=$result;
            }
            $methods=$class->getMethods();
            foreach ($methods as $method){
                if($method->class==$className){
                    $action=$method->name;
                    $controller=str_replace($this->namespace.DIRECTORY_SEPARATOR,'',$method->class);
                    if(strpos($action,'__')===false){
                        $docComment=$method->getDocComment();
                        $result=$this->analyseParame($docComment,$controller,$action);
                        if(!empty($result)){
                            $data[]=$result;
                        }
                    }
                }
            }
        }
        return $data;
    }
    /**
     * 获取文件
     * @param $path
     * @return array
     * @throws \Exception
     */
    private function analyseFiles($path)
    {
        $filesArr = $this->analyseFolders($path);
            foreach ($filesArr as $path){
                if(is_file($path)){
                    array_push($this->files,$path);
                }
                if(is_dir($path)){
                    $this->analyseFiles($path);
                }
            }
            return $this->files;
    }

    /**
     * 获取目录
     * @param $path
     * @return array
     * @throws \Exception
     */
    private function analyseFolders($path)
    {
        $this->root = $path;
        if (!is_dir($path)) {
            throw  new \Exception("目录不存在！");
        }
        $paths = scandir($path);
        $paths=array_map(function ($path){
            return  $this->root.DIRECTORY_SEPARATOR.$path;
        },$paths);
        $files = array_splice($paths, 2, count($paths));
        return $files;
    }

    private  function  analyseParame($comment,$controller="",$action=""){
         $pattern="/@adminMenu\(([\s\S]*)\)/i";
         $arr=[];
         preg_match($pattern,$comment,$arr);
         $parames=null;
         if(isset($arr[1])) {
             $parameDoc = str_replace("*", '', $arr[1]);
             $parameDocEvev="return array({$parameDoc});";
             try{
                 $parameDocArr=eval($parameDocEvev);
             }catch (\Exception $e){
                 throw  new \Exception($e->getMessage());
             }
             $parameDocArr['controller']=$controller;
             if(!empty($action)){
                 $parameDocArr['action']=$action;
             }
             extract($parameDocArr);
             $name=isset($name)?$name:'';
             $idName=isset($idName)?$idName:'';
             $controller=isset($controller)?$controller:'';
             $action=isset($action)?$action:'';
             $parent=isset($parent)?$parent:'';
             $display=isset($display)?$display:'';
             $order=isset($order)?$order:'';
             $icon=isset($icon)?$icon:'';
             $remark=isset($remark)?$remark:'';
             $hasView=isset($hasView)?$hasView:'';
             $request=isset($request)?$request:'';
             $param=isset($param)?$param:'';
//             if(empty($idName)){
//                 throw  new \Exception("菜单idName必须赋值！");
//             }
             $parames=new MenuModel($name,$idName,$controller,$action,$parent,$display,$hasView,$order,$icon,$remark,$request,$param);
         }
         return $parames;
    }
}