<?php

namespace Plugin\PurchaseButton\Controller;


use Symfony\Component\Routing\Annotation\Route;


class CartController extends \Eccube\Controller\CartController
{
    /**
     * カートへ商品を追加する
     *
     * @Route(
     *     path="/purchase_button/cart/add/{productClassId}",
     *     name="purchase_button_cart_add",
     *     methods={"PUT"},
     *     requirements={
     *          "productClassId": "\d+"
     *     }
     * )
     */
    public function add($productClassId)
    {
        /** @var ProductClass $ProductClass */
        $ProductClass = $this->productClassRepository->find($productClassId);

        if (null === $ProductClass) {
            return $this->redirectToRoute('cart');
        }

        $this->cartService->addProduct($ProductClass, 1);

        // カートを取得して明細の正規化を実行
        $Carts = $this->cartService->getCarts();
        $this->execPurchaseFlow($Carts);

        return $this->redirectToRoute('cart');
    }
}
