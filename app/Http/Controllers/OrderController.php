<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Notifications\Notified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController extends Controller
{
    public function index()
    {
        $this->authorize('looking_at_orders');

        $orders = Order::with('orderProducts')->get();

        return view('admin.pages.orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $order = auth()->user()->orders()->create([
                'contact_number' => $request->contact_no,
                'address' => $request->address,
            ]);

            foreach($request->products as $item)
            {
                $cart = auth()->user()->cartProducts()->where('id', $item['cart_product_id'])->first();
                $product = $cart->product;
                $color = $cart->color;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'color_id' => $color?->id,
                    'color_name' => $color?->name,
                ]);
            }

            auth()->user()->cartProducts()->delete();

            $norifyTo = User::where('role_id', User::ADMIN_IS)->get();
            foreach( $norifyTo as $user)
            {
                $user->notify(new Notified($order));
            }
            
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            dd($e->getMessage());
        }

        return redirect()->route('confirmed')->with('thank_you', 'Thanks for your order');
    }

    public function show($order)
    {
        $order = Order::findOrFail($order);
        //dd($order);
        $notification = auth()->user()->unreadNotifications()->where('id', request('notification_id'))->first();
        if($notification)
        {
            $notification->markAsRead();
        }
        
        return view('admin.pages.orders.show', compact('order'));
    }

    public function edit($order)
    {
        $this->authorize('looking_at_orders');

        $order = Order::findOrFail($order);
        return view('admin.pages.orders.edit', compact('order'));
    }

    public function update(Request $request, $orderId)
    {
        try 
        {
            DB::beginTransaction();

            $order = Order::findOrFail($orderId);
            $order->update([
                'status' => $request->status,
            ]);

            foreach ($request->products as $productId => $data) 
            {
                $orderProduct = OrderProduct::find($productId);

                if ($orderProduct) 
                {
                    $orderProduct->update([
                        'quantity' => $data['quantity'],
                    ]);
                }
            }

            DB::commit();
        }

        catch (\Exception $e) 
        {
            DB::rollBack();
            return back()->with('error', 'Failed to update the order. Please try again.');
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function confirmed()
    {
        $user = auth()->user();

        $order = Order::where('user_id', $user->id)->with('orderProducts')->first();

        return view('confirmed', compact('order'));
    }

    public function generateInvoicePdf($order)
    {
        $order = Order::findOrFail($order);

        $dompdf = new Dompdf();
        $html = view('invoice_pdf', compact('order'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('invoice.pdf');
    }

    public function cancel_order($order)
    {
        $this->authorize('looking_at_orders');
        //dd($order);
        $order = Order::findOrFail($order);

        $order->update(['status' => 4]);

        $order->orderProducts()->delete();
        $order->delete();

        return redirect()->route('orders.index')->with('info', 'Order Cancelled');
    }

    public function cancelled_orders()
    {
        $this->authorize('looking_at_orders');

        $orders = Order::onlyTrashed()->get();
        return view('admin.pages.orders.cancelled', compact('orders'));
    }

    public function restore($order)
    {
        $this->authorize('looking_at_orders');

        $order = Order::onlyTrashed()->find($order);
        //dd($order);
        $order->update(['status' => 0]);
        $order->orderProducts()->restore();
        $order->restore();
        return redirect()->route('cancelled_orders')->with('success', 'Order Restored Successfully');
    }

    public function delete($order)
    {
        $this->authorize('looking_at_orders');
        
        $order = Order::onlyTrashed()->find($order);

        $order->orderProducts()->forceDelete();
        $order->forceDelete();

        return redirect()->route('orders.index')->with('danger', 'Order Removed Permanently');
    }
}
