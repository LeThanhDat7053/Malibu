<?php

namespace Botble\Product\Http\Controllers;

use Botble\Base\Facades\EmailHandler;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Product\Http\Requests\OrderRequest;
use Botble\Product\Models\Product;
use Botble\Product\Models\ProductCategory;
use Botble\Product\Models\ProductOrder;
use Botble\Product\Models\ProductOrderItem;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class PublicProductController extends Controller
{
    public function getBookedSlots(int $product_id, Request $request): JsonResponse
    {
        return response()->json([]);
    }
    public function getProducts(Request $request)
    {
        SeoHelper::setTitle(trans('plugins/product::product.name'));

        Theme::breadcrumb()->add(trans('plugins/product::product.name'), route('public.products'));

        $categories = ProductCategory::query()
            ->wherePublished()
            ->oldest('order')
            ->with(['products' => function ($query) {
                $query->wherePublished()->oldest('order')->latest();
            }])
            ->get();

        $allProducts = Product::query()
            ->wherePublished()
            ->with(['category'])
            ->latest()
            ->get();

        return Theme::scope('product.products', compact('categories', 'allProducts'))->render();
    }

    public function getProduct(string $key)
    {
        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix(Product::class));

        abort_unless($slug, 404);

        $product = Product::query()
            ->with(['category'])
            ->findOrFail($slug->reference_id);

        SeoHelper::setTitle($product->name)
            ->setDescription(Str::words($product->description, 120));

        Theme::breadcrumb()
            ->add(trans('plugins/product::product.name'), route('public.products'))
            ->add($product->name, $product->url);

        $relatedProducts = Product::query()
            ->wherePublished()
            ->where('category_id', $product->category_id)
            ->whereNot('id', $product->id)
            ->limit(4)
            ->get();

        return Theme::scope('product.product', compact('product', 'relatedProducts'))->render();
    }

    public function postOrder(OrderRequest $request, BaseHttpResponse $response)
    {
        $product = Product::query()->findOrFail($request->input('product_id'));

        // Check sale period availability
        if (! $product->isWithinSalePeriod()) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/product::product.sale_ended'));
        }

        $quantity = $request->integer('quantity', 1);
        $totalAmount = $product->price * $quantity;

        $serviceDate = $product->enable_booking ? $request->input('service_date') : null;
        $serviceTime = $product->enable_booking ? $request->input('service_time') : null;

        $order = ProductOrder::query()->create([
            'order_number' => 'PO-' . strtoupper(Str::random(8)),
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_note' => $request->input('customer_note'),
            'service_date' => $serviceDate,
            'service_time' => $serviceTime,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        ProductOrderItem::query()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => $quantity,
            'service_date' => $serviceDate,
            'service_time' => $serviceTime,
        ]);

        $product->increment('total_sold', $quantity);

        $serviceDateFormatted = $serviceDate ? \Carbon\Carbon::parse($serviceDate)->format('d/m/Y') : '';
        $serviceTimeFormatted = $serviceTime ?? '';

        // Send email notification via Botble email template system
        EmailHandler::setModule(PRODUCT_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'total_amount' => number_format($order->total_amount, 0, ',', '.') . ' VND',
                'customer_note' => $order->customer_note ?: '',
                'order_date' => $order->created_at->format('d/m/Y H:i'),
                'service_date' => $serviceDateFormatted,
                'service_time' => $serviceTimeFormatted,
            ])
            ->sendUsingTemplate('order-notice-to-admin');

        return $response
            ->setMessage(trans('plugins/product::product.order_success'))
            ->setNextUrl(route('public.products'));
    }
}
