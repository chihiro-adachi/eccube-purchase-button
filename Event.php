<?php

namespace Plugin\PurchaseButton;

use Eccube\Entity\Product;
use Eccube\Event\TemplateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class Event implements EventSubscriberInterface
{
    /**
     * 商品編集画面に購入ボタンを追加する.
     *
     * @param TemplateEvent $event
     */
    public function onAdminProductEdit(TemplateEvent $event)
    {
        //$req->getBaseUrl()
        /** @var Product $Product */
        $Product = $event->getParameter('Product');

        if (null === $Product->getId()) {
            return;
        }

        $tag = $Product->hasProductClass()
            ? '@PurchaseButton/admin/tag_product_class.twig'
            : '@PurchaseButton/admin/tag.twig';

        $event->setParameter('purchase_button_tag', $tag);
        $event->addSnippet('@PurchaseButton/admin/product.twig');
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            '@admin/Product/product.twig' => 'onAdminProductEdit',
        ];
    }
}
