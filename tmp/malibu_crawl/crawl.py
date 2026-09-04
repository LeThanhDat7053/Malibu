import urllib.request, ssl, json, os, re, time
BASE="https://malibuhotel.com.vn"
OUT=os.path.dirname(os.path.abspath(__file__))
ctx=ssl.create_default_context(); ctx.check_hostname=False; ctx.verify_mode=ssl.CERT_NONE
def get(path):
    url=path if path.startswith("http") else BASE+path
    req=urllib.request.Request(url, headers={"User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64)"})
    with urllib.request.urlopen(req, timeout=60, context=ctx) as r:
        return r.read().decode("utf-8","replace")

BLOGS=["Malibu-Package","billiard-foosball","carrina-restaurant","conference","entertainment",
"free-upgrade","gift-shop","kid-zone","long-stay","m-gym","m-pool","m-spa",
"malibu-mackage-vungtau","private-laundry","the-lux-coffee","vela-restaurant"]
PAGES=["page/about","page/banquet-menu","page/careers","page/conference","page/contact","page/dine",
"page/entertainment","page/gather","page/hotel-faqs","page/malibu-group","page/offer.html",
"page/restaurant","page/tien-nghi.html","page/wedding","gallery.html","rooms-and-suites.html",
"one-hotel.html"]
for rt in ["PREMIER","DIAMOND","SUITE","PRESIDENT"]:
    PAGES.append("rooms-and-suites.html?roomType="+rt)

targets=[("blog/"+b) for b in BLOGS]+PAGES+[""]
for t in targets:
    name=(t or "home").replace("/","_").replace("?","_").replace("=","_")+".html"
    p=os.path.join(OUT,name)
    if os.path.exists(p) and os.path.getsize(p)>1000: print("skip",name); continue
    try:
        html=get("/"+t if t else "/")
        open(p,"w",encoding="utf-8").write(html)
        print("ok",name,len(html))
    except Exception as e:
        print("ERR",t,e)
    time.sleep(0.3)
