# -*- coding: utf-8 -*-
"""Kiểm tra mọi URL ảnh trong dump Malibu có trả về 200 hay không."""
import concurrent.futures as cf
import re
import ssl
import sys
import urllib.request

import lib

CTX = ssl.create_default_context()
CTX.check_hostname = False
CTX.verify_mode = ssl.CERT_NONE
UA = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"}


def head(url):
    req = urllib.request.Request(url, headers=UA, method="HEAD")
    try:
        with urllib.request.urlopen(req, timeout=30, context=CTX) as r:
            return url, r.status, r.headers.get("Content-Type", "")
    except Exception as e:
        return url, getattr(e, "code", 0), str(e)[:60]


def main(path=None):
    sql = lib.load(path or lib.DST)
    urls = sorted(set(re.findall(r"https://[a-z0-9.\-]+/files/[^\\\"' )]+", sql)))
    urls = [u.replace("\\/", "/") for u in urls]
    print("Số URL ảnh duy nhất: %d" % len(urls))
    bad = []
    with cf.ThreadPoolExecutor(max_workers=12) as ex:
        for url, status, info in ex.map(head, urls):
            if status != 200 or not info.startswith("image"):
                bad.append((url, status, info))
    if bad:
        print("HỎNG (%d):" % len(bad))
        for u, s, i in bad:
            print("  %s  [%s] %s" % (u, s, i))
        return 1
    print("Tất cả ảnh đều trả về 200.")
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv[1] if len(sys.argv) > 1 else None))
