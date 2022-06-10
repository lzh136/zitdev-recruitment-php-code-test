<?php

namespace App\Service;

use Test\Service\ProductHandlerTest;

/**
 * Class ProductHandler
 */
class ProductHandler
{
    private $Products;

    private $Conditions = []; //过滤条件


    /**
     * 计算商品总金额
     */
    public function getTotalPrice($Products)
    {
        $this->Products = $Products;
        return array_sum(array_column($this->Products,'price'));
    }

    /**
     * 把商品以金额（由大至小）排序，并按照对应种类进行筛选
     */
    public function getProductsByType($Products)
    {
        $this->Products =$Products;

        $this->productsFilter([
            'type' => [
                'operation'=> 'eq',
                'value' => 'Dessert'
            ],
            'price' => [
                'operation'=> 'egt',
                'value' => '35'
            ],
        ])->orderBy('price','desc');
        return $this->Products;
    }

    /**
     * 创建日期转化为  unix timestamp
     */
    public function changeTimeFormat($Products)
    {
        $this->Products = $Products;
        $this->productsErgodic([
            'create_at'=>function($create_at){
                return strtotime($create_at);
            }
        ]);
        return $this->Products;
    }


    /**
     * 商品排序器
     */
    private function orderBy($column,$arg)
    {
        $price = array_column($this->Products,$column);
        array_multisort($price,$arg == 'asc'? SORT_ASC : SORT_DESC,$this->Products);
        return $this;
    }

    /**
     * 商品过滤器
     */
    private function productsFilter($Conditions)
    {
        $this->Conditions = $Conditions;
        $this->Products = array_filter($this->Products,array($this,"_productsFilter"));
        return $this;
    }

    /**
     * 商品属性格式转换
     */
    private function productsErgodic($changes)
    {
        foreach($this->Products as &$item){
            foreach($changes as $key=>$change){
                $func = $change;
                $item[$key] = $func($item[$key]);
            }
        }
    }


    private function _productsFilter($Product)
    {
        $result = 1;
        //类型过滤
        foreach($this->Conditions as $key=>$condition){
            //判断非法字段
            if(!array_key_exists($key,$Product)) exit($key.'是非法过滤字段');
            switch ($condition['operation']){
                case 'eq' :
                    if(!($this->Conditions[$key]['value'] == $Product[$key])) $result = 0;
                    break;
                case 'neq' :
                    if(!($this->Conditions[$key]['value'] != $Product[$key])) $result = 0;
                    break;
                case 'gt' :
                    if(!($this->Conditions[$key]['value'] < $Product[$key])) $result = 0;
                    break;
                case 'egt' :
                    if(!($this->Conditions[$key]['value'] <= $Product[$key])) $result = 0;
                    break;
                case 'it' :
                    if(!($this->Conditions[$key]['value'] > $Product[$key])) $result = 0;
                    break;
                case 'eit' :
                    if(!($this->Conditions[$key]['value'] >= $Product[$key])) $result = 0;
                    break;
                default :
                    break;
            }
        }
        return $result;
    }
}