<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\MethodPayment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Table;
use App\Models\ToppingGroup;
use App\Models\Toppings;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as ResHTTP;

class SaleController extends Controller
{
    protected $store_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->store_id = request()->user()->store_id;
            return $next($request);
        });
    }

    public function index()
    {
       
        return view('Sale.table.index');
    }
    public function choose_product($id)
    {
        $payment_method = MethodPayment::storeId($this->store_id)->get();
        $table = Table::find($id); 
        return view('Sale.home.index', compact('table','payment_method'));
    }
    public function category()
    {
        $categories = CategoryProduct::storeId($this->store_id)->where('status', CategoryProduct::STATUS_ACTIVE)->get();
        return view('Sale.home.category', compact('categories'));
    }
    public function payment()
    {
        $search = request('search' ,'');
        $condition = request('total' ,'');
        $current_day = now()->format('Y-m-d');
        $active = Promotion::STATUS_ACTIVE;
        
        $type = request('type', 'add');
        $rowId = request('rowId', '');
        if($rowId != ''){
            $item = Cart::get($rowId);
            $qty = $type == 'add' ? $item->qty + 1 : $item->qty - 1;
            
            Cart::update($rowId, ['qty' => $qty]);
        }
        $sql = "SELECT promotions.value, promotions.type_value, promotions.id FROM promotions LEFT JOIN stores ON promotions.store_id = stores.id WHERE 
        promotions.store_id = ".$this->store_id." AND promotions.status LIKE '$active'
        AND promotions.code = '$search'  AND  '$current_day' BETWEEN (promotions.start) AND promotions.`end` 
        ";
        $promotion = \DB::select($sql);
        return Response::json([
            'status' => ResHTTP::HTTP_OK,
            'promotion' => $promotion,
            'payment' => view('Sale.home.payment', compact('promotion',))->render(),
            'cart' => view('Sale.home.cart')->render(),
            
        ]);
    }
    public function product()   
    {
        $products = Product::whereHas('category', function ($q) {
            $q->storeId($this->store_id);
        })->where('status', Product::STATUS_ACTIVE)->get();
        return view('Sale.home.product', compact('products'));
    }
    public function area()
    {
        $areas = Area::storeId($this->store_id)->where('status', Area::STATUS_ACTIVE)->get();
        return view('Sale.table.area', compact('areas'));
    }

    public function table()
    {
        $tables = Table::whereHas('area', function ($q) {
            $q->storeId($this->store_id);
        })->where('status', Table::STATUS_ACTIVE)->get();
        return view('Sale.table.table', compact('tables'));
    }
    public function detail($id)
    {
        $topping_group = ToppingGroup::storeId($this->store_id)->where('status', ToppingGroup::STATUS_ACTIVE)->get();
        $group_id = array();
        foreach ($topping_group as $val) {
            $group_id[] = $val->id;
        }
        $toppings = Toppings::groupId($group_id)->where('status', Toppings::STATUS_ACTIVE)->get();
        $product = Product::find($id);
        return view('Sale.home.modal_add', compact('product', 'toppings'))->render();
    }

    public function add_cart(Request $request)
    {
        $data['id'] = $request->id;
        $data['name'] = $request->name;
        $data['qty'] = $request->quantity;
        $data['price'] = $request->price;
        $data['options']['image'] = $request->image;  
        $data['options']['topping'] = $request->addon;
        Cart::add($data);
        
        return Response::json([
            'status' => ResHTTP::HTTP_OK,
            'message'=>'Thêm mới thành công',
            'type' => 'success',
            'data' => view('Sale.home.cart')->render(),
        ]);
    }

    public function cart()
    {
        return view('Sale.home.cart')->render();
    }

  

    public function delete_cart($rowId)
    {
        Cart::remove($rowId);
        return Response::json([
            'status' => ResHTTP::HTTP_OK,

        ]);
    }
    public function destroy()
    {
        Cart::destroy();
        return Response::json([
            'status' => ResHTTP::HTTP_OK,
            'data' => 'Đã hủy giỏ hàng'
        ]);
    }
    public function order(){
        
    }
    public function acceptPayment()
    {
        $table_id = request('table', null);
        $customer_id = request('customer', null);
        $promotion_id = request('promotion', null);
        $discount = request('discount', null);
        $type_discount = request('type_discount', null);
        $discount_total = request('discount_total', null);
        $total = request('total', 0);
        $sub_total = request('sub_total', 0);
        $payment_method = request('payment_method',null);
        $cart = Cart::content();
        $order = Order::create([
            'staff_id' => auth()->user()->id,
            'store_id' => $this->store_id,
            'sub_total' => Cart::total(),
            'total' => $total,
            'customer_id' => $customer_id,
            'table_id' => $table_id,
            'promotion_id' => $promotion_id,
            'discount' => $discount,
            'discount_type' => $type_discount,
            'discount_total' => $discount_total,
            'sub_total' =>$sub_total,
            'method_payment_id' => $payment_method,
        ]);
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_name' => $item->name,
                'quantity' => $item->qty,
                'price' => $item->price,
                'toppings' => json_encode($item->options),
                'total' => $item->subtotal
            ]);
        }
        $order->status = Order::STATUS_FINISH;
        $order->save();
        $table = Table::find($table_id);
        $table->status_order = Table::STATUS_ORDER_UN_ACTIVE;
        $table->order_id = $order->id;
        $table->update();
        Cart::destroy();
        return Response::json([
            'status' => ResHTTP::HTTP_OK,
            'payment' => view('Sale.home.payment')->render(),
            'new_item' => '<li class="list-group-item d-flex justify-content-between align-items-center">
                ' . $order->code . '
                <span class="badge bg-primary rounded-pill">
                    ' . number_format($order->total) . '
                </span>
            </li>'
        ]);
    }
    public function saveOrder()
    {
        $table_id = request('table', null);
        $customer_id = request('customer', null);
        $promotion_id = request('promotion', null);
        $discount = request('discount', null);
        $type_discount = request('type_discount', null);
        $discount_total = request('discount_total', null);
        $total = request('total', 0);
        $sub_total = request('sub_total', 0);
        $customer_name = request('customer_name','');
        $cart = Cart::content();
        $order = Order::create([
            'staff_id' => auth()->user()->id,
            'store_id' => $this->store_id,
            'sub_total' => Cart::total(),
            'total' => $total,
            'customer_id' => $customer_id,
            'table_id' => $table_id,
            'promotion_id' => $promotion_id,
            'discount' => $discount,
            'discount_type' => $type_discount,
            'discount_total' => $discount_total,
            'sub_total' =>$sub_total,
            'customer_name' =>$customer_name
        ]);
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_name' => $item->name,
                'quantity' => $item->qty,
                'price' => $item->price,
                'toppings' => json_encode($item->options),
                'total' => $item->subtotal
            ]);
        }
        $order->status = Order::STATUS_TMP;
        $order->save();
        $table = Table::find($table_id);
        $table->status_order = Table::STATUS_ORDER_ACTIVE;
        $table->order_id = $order->id;
        $table->update();
        // Cart::destroy();
        return redirect()->route('sale.index')->with('success', 'Cập nhật thành công');
    }   
    public function customer()
    {
        $search = request('phone','');
        $customer = Customer::storeId($this->store_id)->where('status',Customer::STATUS_ACTIVE)->where('phone','like',$search)->first();
        return $customer;
    }

    
}