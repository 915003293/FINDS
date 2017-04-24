<?php
/**
 * Created by PhpStorm.
 * User: Jax
 * Date: 2017/4/11
 * Time: 16:57
 */
namespace Think\Template\TagLib;
use Think\Template\TagLib;
/**
 * Find标签库解析类
 */
class Find extends TagLib {
    protected $tags = array(
        'type'=>array('attr'=>'tid,pid'),
    );
    public function _type($tag,$content){

    }

}
