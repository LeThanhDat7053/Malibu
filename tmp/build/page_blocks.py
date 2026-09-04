# -*- coding: utf-8 -*-
"""Bộ khối dựng nội dung trang, an toàn với bộ lọc HTML của Botble.

Ràng buộc đã kiểm chứng bằng cách chạy thật BaseHelper::clean():
- Thẻ (h2, h3, table, section, hr...) và thuộc tính `class` được giữ nguyên
  -> bố cục dùng class Bootstrap 5.0.2 của theme.
- CSS inline chỉ giữ: color, background-color, border, border-color, padding*,
  margin*, font-*, text-align, width, height, max-width, line-height,
  list-style, text-decoration.
- BỊ LOẠI: display, flex, gap, border-radius, box-shadow, background-image,
  letter-spacing, border-left/right/top/bottom.
  -> bo góc dùng `rounded-3`, viền trái dùng `border-start border-4`,
     flex dùng `d-flex`. KHÔNG có `fw-semibold` (Bootstrap 5.1+).
"""

ORANGE = "#e4762c"
NAVY = "#16192c"
CREAM = "#faf7f2"
LINE = "#ece4d8"
MUTED = "#6b7280"
BODY = "#4b5563"


def container(*blocks):
    """Bọc nội dung trong container của theme."""
    return ('<div class="container pt-60 pb-70">%s</div>'
            % "".join(b for b in blocks if b))


def hero(image, eyebrow, title, lead=None):
    parts = ['<div class="mb-5">']
    if image:
        parts.append('<img src="%s" alt="%s" class="img-fluid rounded-3 w-100 mb-4">'
                     % (image, title))
    if eyebrow:
        parts.append('<p class="text-uppercase mb-1" style="color:%s;font-size:13px">%s</p>'
                     % (ORANGE, eyebrow))
    parts.append('<h1 class="text-uppercase fw-bold mb-3" style="color:%s;font-size:34px">%s</h1>'
                 % (NAVY, title))
    if lead:
        parts.append('<p class="lead mb-0" style="color:%s;line-height:1.85">%s</p>'
                     % (MUTED, lead))
    parts.append("</div>")
    return "".join(parts)


def stats(items):
    """[(số, nhãn)] -> hàng số liệu nổi bật."""
    cells = []
    for value, label in items:
        cells.append(
            '<div class="col-6 col-md-3">'
            '<div class="p-4 rounded-3 h-100 text-center" '
            'style="background-color:%s;border:1px solid %s">'
            '<p class="fw-bold mb-1" style="color:%s;font-size:30px;line-height:1.1">%s</p>'
            '<p class="mb-0" style="color:%s;font-size:13px">%s</p>'
            "</div></div>" % (CREAM, LINE, ORANGE, value, NAVY, label)
        )
    return '<div class="row g-3 mb-5">%s</div>' % "".join(cells)


def heading(text, level=2):
    size = 24 if level == 2 else 19
    return ('<h%d class="text-uppercase fw-bold mb-3 mt-5" '
            'style="color:%s;font-size:%dpx">%s</h%d>'
            % (level, NAVY, size, text, level))


def prose(paragraphs):
    return "".join(
        '<p class="mb-3" style="line-height:1.95;color:%s">%s</p>' % (BODY, p)
        for p in paragraphs)


def section(title, paragraphs, level=2):
    return heading(title, level) + prose(paragraphs)


def highlight(title, items):
    lis = "".join('<li class="mb-2" style="line-height:1.85;color:%s">%s</li>' % (BODY, i)
                  for i in items)
    return (
        '<div class="p-4 rounded-3 mb-5 mt-4 border-start border-4" '
        'style="background-color:%s;border-color:%s">'
        '<p class="text-uppercase fw-bold mb-3" style="color:%s;font-size:13px">%s</p>'
        '<ul class="mb-0" style="padding-left:18px">%s</ul>'
        "</div>" % (CREAM, ORANGE, NAVY, title, lis)
    )


def cards(items, per_row=2):
    """[(ảnh, tiêu đề, mô tả, nhãn phụ)] -> lưới thẻ."""
    col = "col-md-6" if per_row == 2 else "col-md-4"
    cells = []
    for image, title, text, meta in items:
        media = ""
        if image:
            media = ('<img src="%s" alt="%s" class="img-fluid w-100 mb-3 rounded-3">'
                     % (image, title))
        meta_html = ""
        if meta:
            meta_html = ('<p class="text-uppercase mb-2" style="color:%s;font-size:11px">%s</p>'
                         % (ORANGE, meta))
        cells.append(
            '<div class="%s">'
            '<div class="p-3 rounded-3 h-100" style="background-color:#fff;border:1px solid %s">'
            "%s%s"
            '<h3 class="fw-bold mb-2" style="color:%s;font-size:19px">%s</h3>'
            '<p class="mb-0" style="color:%s;line-height:1.8;font-size:15px">%s</p>'
            "</div></div>" % (col, LINE, media, meta_html, NAVY, title, BODY, text)
        )
    return '<div class="row g-4 mb-5">%s</div>' % "".join(cells)


def steps(items):
    """[(tiêu đề, mô tả)] -> các bước có đánh số."""
    rows = []
    for i, (title, text) in enumerate(items, start=1):
        rows.append(
            '<div class="d-flex mb-4">'
            '<div class="text-center" style="width:44px;min-width:44px">'
            '<span class="fw-bold" style="color:%s;font-size:26px">%02d</span>'
            "</div>"
            '<div style="padding-left:16px">'
            '<h3 class="fw-bold mb-1" style="color:%s;font-size:17px">%s</h3>'
            '<p class="mb-0" style="color:%s;line-height:1.85">%s</p>'
            "</div></div>" % (ORANGE, i, NAVY, title, BODY, text)
        )
    return '<div class="mb-5">%s</div>' % "".join(rows)


def definitions(items):
    """[(thuật ngữ, giải thích)] -> danh sách định nghĩa, dùng cho trang pháp lý.

    Đường kẻ dùng class `border-bottom` của Bootstrap chứ không phải CSS inline:
    thuộc tính `border-bottom` bị HTMLPurifier loại (chỉ `border` được giữ).
    Class này khai `!important` nên không đổi màu kẻ được, giữ mặc định #dee2e6.
    """
    rows = []
    for term, text in items:
        rows.append(
            '<div class="mb-3 pb-3 border-bottom">'
            '<p class="fw-bold mb-1" style="color:%s;font-size:16px">%s</p>'
            '<p class="mb-0" style="color:%s;line-height:1.85">%s</p>'
            "</div>" % (NAVY, term, BODY, text)
        )
    return '<div class="mb-5">%s</div>' % "".join(rows)


def cta(title, note, links):
    """links: [(nhãn, href)]"""
    items = "".join(
        '<p class="mb-2"><a href="%s" style="color:%s;text-decoration:none;font-size:18px">'
        "<strong>%s</strong></a></p>" % (href, ORANGE, label)
        for label, href in links)
    return (
        '<div class="p-4 p-md-5 rounded-3 text-center" style="background-color:%s">'
        '<h2 class="text-uppercase fw-bold text-white mb-2" style="font-size:21px">%s</h2>'
        '<p class="mb-4" style="color:#b9bdc9">%s</p>'
        "%s</div>" % (NAVY, title, note, items)
    )


def note(text):
    return ('<p class="mb-0 mt-4" style="color:%s;font-size:14px;line-height:1.8">%s</p>'
            % (MUTED, text))
