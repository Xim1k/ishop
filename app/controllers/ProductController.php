<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.11.2018
 * Time: 23:14
 */

namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Product;
use ishop\App;

class ProductController extends AppController
{
    public function viewAction(){
        $alias = $this->route['alias'];
        $product = \R::findOne('product', "alias = ? AND status = '1'", [$alias]);
        if(!$product){
            throw new \Exception('Страница не найдена', 404);
        }
        $this->setMeta($product['title'], $product['description'], $product['keywords']);

        //хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

        //запись в куки запрошенного товара
        $p_model = new Product();
        $p_model->setRecentlyViewed($product->id);

        //просмотренные товары
        $r_viewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if($r_viewed){
            $recentlyViewed = \R::find('product', 'id IN ('.\R::genSlots($r_viewed).') LIMIT 3', $r_viewed);
        }

        //связанные товары
        $related = \R::getAll("SELECT * FROM related_product JOIN product ON product.id = related_product.related_id WHERE related_product.product_id = ?", [$product->id]);

        //модификации
        $mods = \R::findAll('modification', 'product_id = ?', [$product->id]);

        //галерея
        $gallery = \R::findAll('gallery', "product_id = ?", [$product['id']]);
        $this->set(compact('related', 'product', 'gallery', 'recentlyViewed','breadcrumbs', 'mods'));
    }
}