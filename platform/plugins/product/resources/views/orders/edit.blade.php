@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ trans('plugins/product::product.order_detail', ['number' => $order->order_number]) }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ trans('plugins/product::product.customer_info') }}</h5>
                    <table class="table table-bordered">
                        <tr><th>{{ trans('plugins/product::product.customer_name') }}</th><td>{{ $order->customer_name }}</td></tr>
                        <tr><th>{{ trans('plugins/product::product.customer_email') }}</th><td>{{ $order->customer_email }}</td></tr>
                        <tr><th>{{ trans('plugins/product::product.customer_phone') }}</th><td>{{ $order->customer_phone }}</td></tr>
                        @if($order->customer_note)
                        <tr><th>{{ trans('plugins/product::product.customer_note') }}</th><td>{{ $order->customer_note }}</td></tr>
                        @endif
                        @if($order->service_date)
                        <tr><th>{{ trans('plugins/product::product.service_date') }}</th><td>{{ $order->service_date->format('d/m/Y') }}</td></tr>
                        @endif
                        @if($order->service_time)
                        <tr><th>{{ trans('plugins/product::product.service_time') }}</th><td>{{ \Carbon\Carbon::parse($order->service_time)->format('H:i') }}</td></tr>
                        @endif
                        <tr><th>{{ trans('plugins/product::product.order_date') }}</th><td>{{ $order->created_at->format('d/m/Y H:i') }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>{{ trans('plugins/product::product.order_details') }}</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>{{ trans('plugins/product::product.product_name') }}</th><th>{{ trans('plugins/product::product.price') }}</th><th>{{ trans('plugins/product::product.quantity') }}</th><th>{{ trans('plugins/product::product.subtotal') }}</th></tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->product_price, 0, ',', '.') }} VND</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->product_price * $item->quantity, 0, ',', '.') }} VND</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">{{ trans('plugins/product::product.total_amount') }}</th>
                                <th>{{ number_format($order->total_amount, 0, ',', '.') }} VND</th>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="{{ route('product-order.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">{{ trans('plugins/product::product.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                <option value="processing" @selected($order->status === 'processing')>Processing</option>
                                <option value="completed" @selected($order->status === 'completed')>Completed</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('plugins/product::product.update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
