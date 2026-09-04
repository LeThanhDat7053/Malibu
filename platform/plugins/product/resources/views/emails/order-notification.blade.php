<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng mới #{{ $order->order_number }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #eef2f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #eef2f7;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">

                    {{-- Primary accent top bar --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0E4D97 0%, #083A72 100%); height: 6px; font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>

                    {{-- Header --}}
                    <tr>
                        <td style="padding: 40px 40px 24px; text-align: center; background: #f0f4f9;">
                            <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #0E4D97 0%, #083A72 100%); display: inline-block; line-height: 64px; text-align: center; margin-bottom: 16px;">
                                <span style="font-size: 28px; color: #fff;">&#9993;</span>
                            </div>
                            <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #1a1a2e; letter-spacing: 0.5px;">ĐƠN HÀNG MỚI</h1>
                            <p style="margin: 8px 0 0; font-size: 15px; color: #0E4D97; font-weight: 600; letter-spacing: 1px;">#{{ $order->order_number }}</p>
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding: 0 40px;">
                            <div style="border-bottom: 2px solid #0E4D97; height: 1px;"></div>
                        </td>
                    </tr>

                    {{-- Introduction --}}
                    <tr>
                        <td style="padding: 24px 40px 8px;">
                            <p style="margin: 0; font-size: 15px; color: #555; line-height: 1.6;">
                                Bạn nhận được một đơn hàng mới từ website. Vui lòng xem chi tiết bên dưới:
                            </p>
                        </td>
                    </tr>

                    {{-- Customer Information --}}
                    <tr>
                        <td style="padding: 16px 40px 8px;">
                            <h3 style="margin: 0 0 12px; font-size: 14px; font-weight: 700; color: #0E4D97; text-transform: uppercase; letter-spacing: 2px;">&#9670; Thông tin khách hàng</h3>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #d0dbe8; border-radius: 8px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Khách hàng</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600; border-bottom: 1px solid #d0dbe8;">{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Email</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; border-bottom: 1px solid #d0dbe8;">{{ $order->customer_email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Số điện thoại</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600;">{{ $order->customer_phone }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Order Details --}}
                    <tr>
                        <td style="padding: 24px 40px 8px;">
                            <h3 style="margin: 0 0 12px; font-size: 14px; font-weight: 700; color: #0E4D97; text-transform: uppercase; letter-spacing: 2px;">&#9670; Chi tiết đơn hàng</h3>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #d0dbe8; border-radius: 8px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Sản phẩm</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600; border-bottom: 1px solid #d0dbe8;">{{ $product->name }} &times; {{ $quantity }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Tổng tiền</td>
                                    <td style="padding: 14px 20px; font-size: 18px; font-weight: 700; color: #0E4D97; border-bottom: 1px solid #d0dbe8;">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                </tr>
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Thời gian đặt</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; border-bottom: 1px solid #d0dbe8;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if ($order->customer_note)
                                <tr>
                                    <td style="padding: 14px 20px; width: 140px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Ghi chú</td>
                                    <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-style: italic; line-height: 1.6;">{{ $order->customer_note }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    {{-- Footer note --}}
                    <tr>
                        <td style="padding: 32px 40px 16px; text-align: center;">
                            <div style="border-top: 1px solid #d0dbe8; padding-top: 20px;">
                                <p style="margin: 0; font-size: 13px; color: #999; line-height: 1.6;">
                                    Đây là email tự động từ hệ thống đặt hàng.<br>
                                    Vui lòng xử lý đơn hàng trong thời gian sớm nhất.
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- Primary accent bottom bar --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0E4D97 0%, #083A72 100%); height: 4px; font-size: 0; line-height: 0;">&nbsp;</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
