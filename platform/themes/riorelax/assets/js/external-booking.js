document.addEventListener('DOMContentLoaded', function () {
    // Link dat phong lay tu Theme Options > Booking button (the meta o layouts/base).
    // Bo trong thi cac nut dat phong khong dan di dau — theme khong con dia chi cung nao.
    function readMeta(name) {
        var meta = document.querySelector('meta[name="' + name + '"]');
        return meta ? (meta.getAttribute('content') || '').trim() : '';
    }

    function openBooking() {
        var url = readMeta('mlb-booking-url');

        if (!url) {
            return false;
        }

        if (readMeta('mlb-booking-new-tab') === '0') {
            window.location.href = url;
        } else {
            window.open(url, '_blank', 'noopener');
        }

        return true;
    }

    // Dung chung cho popup banner va bat ky cho nao can mo trang dat phong
    window.mlbOpenBooking = openBooking;
    window.mlbBookingUrl = function () {
        return readMeta('mlb-booking-url');
    };

    // Moi form dat phong cua theme: chan gui di roi mo link da cau hinh.
    // Chua cau hinh thi bam khong co chuyen gi xay ra.
    document.querySelectorAll('.form-booking').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            openBooking();
        });
    });
});
