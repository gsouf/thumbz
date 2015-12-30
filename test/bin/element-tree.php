#!/usr/bin/php
<?php

include __DIR__ . '/../../vendor/autoload.php';


$treeBuilder = new  \UForm\Doc\ElementTreeBuilder([
    __DIR__ . '/../../src/UForm/Form' => 'UForm\Form'
]);

$tree = $treeBuilder->getTree();


$it = new RecursiveIteratorIterator( new \UForm\Doc\ElementTreeRecursiveIterator($tree));

$str = "";

foreach($it as $nodeInfo){

    /* @var $nodeInfo \UForm\Doc\NodeInfo */

    $str .=  str_repeat("·  ", $it->getDepth());

    if($nodeInfo->hasNext()){
        $str .=  "├─";
    }else{
        $str .=  "└─";
    }

    if($nodeInfo->node->hasChildren()){
        $str .=  "─┬";
    }else{
        $str .=  "─ ";
    }

    $str .=  $nodeInfo->node->getClassName();

    $types = $nodeInfo->node->getSelfSemanticTypes();
    if(count($types) > 0){
        $str .= "\033[32m ";
        foreach($types as $t){
            $str .= $t->getName();
        }
        $str .= "\033[0m";
    }

    if($nodeInfo->node->implementsDrawable()){
        $str .= "\033[36m Drawable\033[0m";
    }

    foreach($nodeInfo->node->getRenderOptions() as $renderOption){
        $str .= "\033[33m " . $renderOption->getName() . "\033[0m";
    }

    $str .=  PHP_EOL;
}

echo $str;
