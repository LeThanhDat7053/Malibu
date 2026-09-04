# -*- coding: utf-8 -*-
"""Đo kích thước thật của các ảnh ứng viên làm banner."""
import concurrent.futures as cf
import json
import os
import ssl
import struct
import urllib.request

CTX = ssl.create_default_context()
CTX.check_hostname = False
CTX.verify_mode = ssl.CERT_NONE
UA = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"}
CDN = "https://malibuhotel.com.vn"


def dimensions(data):
    if data[:8] == b"\x89PNG\r\n\x1a\n":
        w, h = struct.unpack(">II", data[16:24])
        return w, h
    i = 2
    while i < len(data) - 9:
        if data[i] != 0xFF:
            i += 1
            continue
        marker = data[i + 1]
        if marker in (0xC0, 0xC1, 0xC2, 0xC3):
            h, w = struct.unpack(">HH", data[i + 5:i + 9])
            return w, h
        seg = struct.unpack(">H", data[i + 2:i + 4])[0]
        i += 2 + seg
    return 0, 0


def probe(path):
    url = CDN + path
    try:
        req = urllib.request.Request(url, headers=UA)
        data = urllib.request.urlopen(req, timeout=45, context=CTX).read()
        w, h = dimensions(data)
        return path, w, h, len(data)
    except Exception as e:
        return path, 0, 0, -1


def main():
    crawl = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))),
                         "malibu_crawl")
    paths = set()
    gallery = json.load(open(os.path.join(crawl, "gallery.json"), encoding="utf-8"))
    for key, items in gallery.items():
        paths.update(items)
    for r in json.load(open(os.path.join(crawl, "rooms.json"), encoding="utf-8")):
        paths.update(r["images"])
    txt = os.path.join(crawl, "txt")
    for f in os.listdir(txt):
        if f.endswith(".imgs"):
            paths.update(x for x in open(os.path.join(txt, f)).read().split() if x)

    results = []
    with cf.ThreadPoolExecutor(max_workers=10) as ex:
        for path, w, h, size in ex.map(probe, sorted(paths)):
            if w:
                results.append((w * h, w, h, size, path))
    results.sort(reverse=True)
    print("%d ảnh đo được. Ảnh lớn nhất, ưu tiên tỉ lệ ngang:" % len(results))
    for area, w, h, size, path in results:
        if w >= 1400 and w / h >= 1.3:
            print("  %4dx%-4d  %5.2f  %6.0f KB  %s" % (w, h, w / h, size / 1024, path))


if __name__ == "__main__":
    main()
