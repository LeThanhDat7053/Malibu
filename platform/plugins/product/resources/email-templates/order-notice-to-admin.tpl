{{ header }}

<div class="bb-main-content">
    <table class="bb-box" cellpadding="0" cellspacing="0" style="border: none; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
        <tbody>
            <!-- Primary accent top bar -->
            <tr>
                <td style="background: linear-gradient(135deg, #0E4D97 0%, #083A72 100%); height: 6px; font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>

            <!-- Header section -->
            <tr>
                <td style="padding: 36px 48px 24px 48px; text-align: center; background: #f0f4f9;">
                    <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #1a1a2e; letter-spacing: 0.5px;">ĐƠN HÀNG MỚI</h1>
                    <p style="margin: 8px 0 0 0; font-size: 15px; color: #0E4D97; font-weight: 600; letter-spacing: 1px;">#{{ order_number }}</p>
                </td>
            </tr>

            <!-- Divider -->
            <tr>
                <td style="padding: 0 48px;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td style="border-bottom: 2px solid #0E4D97; height: 1px; font-size: 0; line-height: 0;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Introduction -->
            <tr>
                <td style="padding: 24px 48px 8px 48px;">
                    <p style="margin: 0; font-size: 15px; color: #555; line-height: 1.6;">
                        Bạn nhận được một đơn hàng mới từ website. Vui lòng xem chi tiết bên dưới:
                    </p>
                </td>
            </tr>

            <!-- Customer Information -->
            <tr>
                <td style="padding: 16px 48px 8px 48px;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td style="padding-bottom: 12px;">
                                <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #0E4D97; text-transform: uppercase; letter-spacing: 2px;">
                                    &#9670; Thông tin khách hàng
                                </h3>
                            </td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #d0dbe8; border-radius: 8px; overflow: hidden;">
                        {% if customer_name %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Khách hàng</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600; border-bottom: 1px solid #d0dbe8;">{{ customer_name }}</td>
                        </tr>
                        {% endif %}
                        {% if customer_email %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Email</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; border-bottom: 1px solid #d0dbe8;">{{ customer_email }}</td>
                        </tr>
                        {% endif %}
                        {% if customer_phone %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Số điện thoại</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600;">{{ customer_phone }}</td>
                        </tr>
                        {% endif %}
                    </table>
                </td>
            </tr>

            <!-- Order Details -->
            <tr>
                <td style="padding: 24px 48px 8px 48px;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td style="padding-bottom: 12px;">
                                <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #0E4D97; text-transform: uppercase; letter-spacing: 2px;">
                                    &#9670; Chi tiết đơn hàng
                                </h3>
                            </td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #d0dbe8; border-radius: 8px; overflow: hidden;">
                        {% if product_name %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Sản phẩm</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600; border-bottom: 1px solid #d0dbe8;">{{ product_name }} &times; {{ quantity }}</td>
                        </tr>
                        {% endif %}
                        {% if total_amount %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Tổng tiền</td>
                            <td style="padding: 14px 20px; font-size: 18px; font-weight: 700; color: #0E4D97; border-bottom: 1px solid #d0dbe8;">{{ total_amount }}</td>
                        </tr>
                        {% endif %}
                        {% if service_date %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Ngày sử dụng</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-weight: 600; border-bottom: 1px solid #d0dbe8;">{{ service_date }}{% if service_time %} &mdash; {{ service_time }}{% endif %}</td>
                        </tr>
                        {% endif %}
                        {% if order_date %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #d0dbe8;">Thời gian đặt</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; border-bottom: 1px solid #d0dbe8;">{{ order_date }}</td>
                        </tr>
                        {% endif %}
                        {% if customer_note %}
                        <tr>
                            <td style="padding: 14px 20px; width: 160px; background: #f0f4f9; color: #666; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Ghi chú</td>
                            <td style="padding: 14px 20px; color: #1a1a2e; font-size: 15px; font-style: italic; line-height: 1.6;">{{ customer_note }}</td>
                        </tr>
                        {% endif %}
                    </table>
                </td>
            </tr>

            <!-- Footer note -->
            <tr>
                <td style="padding: 32px 48px 16px 48px; text-align: center;">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td style="border-top: 1px solid #d0dbe8; padding-top: 20px;">
                                <p style="margin: 0; font-size: 13px; color: #999; line-height: 1.6;">
                                    Đây là email tự động từ hệ thống đặt hàng.<br>
                                    Vui lòng xử lý đơn hàng trong thời gian sớm nhất.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Primary accent bottom bar -->
            <tr>
                <td style="background: linear-gradient(135deg, #0E4D97 0%, #083A72 100%); height: 4px; font-size: 0; line-height: 0;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>

{{ footer }}
