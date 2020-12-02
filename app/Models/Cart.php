<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $products;//商品群
    public $totalQty = 0;//總數量
    public $totalPrice = 0;//總價格

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->products = $oldCart->products;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }
    public function add($product, $id)
    {
        //儲存商品 (數量,價格,商品資料(名字、價格等等))
        $storedProduct = ['qty'=>0, 'price'=>$product->price, 'product'=>$product];

        //確認購物車是否有商品
        if ($this->products) {
            // 確認購物車是否已有此商品
            // 如果有 則讓storedProduct等於該商品
            if (array_key_exists($id, $this->products)) {
                $storedProduct = $this->products[$id];
            }
        }
        //儲存商品數量增加
        $storedProduct['qty']++;
        //儲存商品價格 = 商品價格 * 商品數量
        $storedProduct['price'] = $product->price * $storedProduct['qty'];
        // 更新商品群
        $this->products[$id] = $storedProduct;
        // 更新購物車總數量
        $this->totalQty++;
        // 更新購物車總價格
        $this->totalPrice += $product->price;
    }

    public function increaseByOne($id)
    {
        // 從商品群取得符合$id的商品
        // 商品數量增加1
        $this->products[$id]['qty']++;
        // 更新商品價格
        $this->products[$id]['price'] += $this->products[$id]['product']['price'];
        // 更新購物車總數量
        $this->totalQty++;
        // 更新購物車總價格
        $this->totalPrice += $this->products[$id]['product']['price'];
    }

    public function decreaseByOne($id)
    {
        // 從商品群取得符合$id的商品
        // 商品數量減少1
        $this->products[$id]['qty']--;
        // 更新商品價格
        $this->products[$id]['price'] -= $this->products[$id]['product']['price'];
        // 更新購物車總數量
        $this->totalQty--;
        // 更新購物車總價格
        $this->totalPrice -= $this->products[$id]['product']['price'];
        // 如果商品數量少於1，刪除該商品
        if ($this->products[$id]['qty'] < 1) {
            unset($this->products[$id]);
        }
    }
    public function removeProduct($id)
    {
        // 從商品群取得符合$id的商品
        // 更新購物車總數量
        $this->totalQty -= $this->products[$id]['qty'];

        // 更新購物車金額
        $this->totalPrice -= $this->products[$id]['price'];
        // 取消該商品
        unset($this->products[$id]);
    }
}
