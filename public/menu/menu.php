<? //$parent = isset($category['childs']);?>
<li>
    <a href="category/<?=$category['alias'];?>"><?=$category['title'];?></a>
    <?if(isset($category['childs'])):?>
        <ul>
            <?=$this->getMenuHtml($category['childs']);?>
        </ul>
    <?endif;?>
</li>
