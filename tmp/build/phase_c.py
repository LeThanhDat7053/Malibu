# -*- coding: utf-8 -*-
"""Phase C: dịch vụ/tiện ích, địa điểm lân cận, thư viện ảnh."""
import json
import os

import lib
import services_data as S
from lib import row

NOW = "2026-09-04 08:00:00"
GALLERY_JSON = os.path.join(
    os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
    "malibu_crawl", "gallery.json")


def html(blocks):
    """[(tiêu đề, đoạn văn)] -> HTML. Tiêu đề rỗng nghĩa là chỉ có đoạn văn."""
    out = ['<div class="service-detail">']
    for head, body in blocks:
        if head:
            out.append("<h3>%s</h3>" % head)
        if body:
            out.append("<p>%s</p>" % body)
    out.append("</div>")
    return "".join(out)


def apply(sql):
    # ------------------------------------------------ dịch vụ / tiện ích
    svc, svc_tr = [], []
    for s in S.SERVICES:
        svc.append(row(
            s["id"], s["name_vi"], s["desc_vi"], html(s["body_vi"]),
            0, "contact", None, S.CDN + s["image"], None,
            "published", NOW, NOW,
        ))
        svc_tr.append(row(
            "en_US", s["id"], s["name_en"], s["desc_en"], html(s["body_en"]), None,
        ))
    sql = lib.replace(sql, "ht_services", svc)
    sql = lib.replace(sql, "ht_services_translations", svc_tr)
    sql = lib.autoinc(sql, "ht_services", len(S.SERVICES) + 1)

    # ------------------------------------------------ địa điểm lân cận
    plc, plc_tr = [], []
    for p in S.PLACES:
        content_vi = html([("", p["desc_vi"]),
                           ("Khoảng cách", p["dist_vi"] + " từ The Malibu Hotel.")])
        content_en = html([("", p["desc_en"]),
                           ("Distance", p["dist_en"] + " from The Malibu Hotel.")])
        plc.append(row(p["id"], p["name_vi"], p["dist_vi"], p["desc_vi"], content_vi,
                       S.CDN + p["image"], "published", NOW, NOW))
        plc_tr.append(row("en_US", p["id"], p["name_en"], p["dist_en"],
                          p["desc_en"], content_en))
    sql = lib.replace(sql, "ht_places", plc)
    sql = lib.replace(sql, "ht_places_translations", plc_tr)
    sql = lib.autoinc(sql, "ht_places", len(S.PLACES) + 1)

    # ------------------------------------------------ thư viện ảnh
    pool = json.load(open(GALLERY_JSON, encoding="utf-8"))
    gal, gal_tr, meta, meta_tr = [], [], [], []
    for order, (gid, key, nvi, nen, dvi, den) in enumerate(S.GALLERIES):
        urls = [S.CDN + p for p in pool.get(key, [])]
        if not urls:
            print("  ! thư viện %s không có ảnh" % key)
        gal.append(row(gid, nvi, "<p>%s</p>" % dvi, 1 if order < 4 else 0, order,
                       urls[0] if urls else None, 1, "published", NOW, NOW))
        gal_tr.append(row("en_US", gid, nen, "<p>%s</p>" % den))
        images = json.dumps([{"img": u, "description": ""} for u in urls],
                            ensure_ascii=False)
        meta.append(row(gid, images, gid, "Botble\\Gallery\\Models\\Gallery", NOW, NOW))
        meta_tr.append(row("en_US", gid, images))
    sql = lib.replace(sql, "galleries", gal)
    sql = lib.replace(sql, "galleries_translations", gal_tr)
    sql = lib.replace(sql, "gallery_meta", meta)
    sql = lib.replace(sql, "gallery_meta_translations", meta_tr)
    last = S.GALLERIES[-1][0] + 1
    sql = lib.autoinc(sql, "galleries", last)
    sql = lib.autoinc(sql, "gallery_meta", last)
    return sql


if __name__ == "__main__":
    sql = lib.load(lib.DST)
    lib.save(apply(sql))
    print("Phase C xong: %d dịch vụ, %d địa điểm, %d thư viện ảnh"
          % (len(S.SERVICES), len(S.PLACES), len(S.GALLERIES)))
