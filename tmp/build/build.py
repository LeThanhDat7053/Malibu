# -*- coding: utf-8 -*-
"""Chạy toàn bộ các phase từ dump gốc -> travellink_malibu.sql."""
import importlib
import sys

import lib

PHASES = ["phase_a", "phase_b", "phase_c", "phase_d", "phase_e", "phase_f", "phase_g", "phase_h", "phase_i"]


def main(only=None):
    sql = lib.load()
    print("dump gốc: %.2f MB" % (len(sql) / 1048576))
    for name in PHASES:
        if only and name not in only:
            continue
        try:
            mod = importlib.import_module(name)
        except ModuleNotFoundError:
            print("  (bỏ qua %s - chưa viết)" % name)
            continue
        out = mod.apply(sql)
        sql = out[0] if isinstance(out, tuple) else out
        print("  %s -> %.2f MB" % (name, len(sql) / 1048576))
    lib.save(sql)
    print("đã ghi %s (%.2f MB)" % (lib.DST, len(sql) / 1048576))


if __name__ == "__main__":
    main(sys.argv[1:] or None)
