import re,os,json,html
OUT=os.path.dirname(os.path.abspath(__file__))
def strip(t):
    t=re.sub(r'(?is)<(script|style)[^>]*>.*?</\1>',' ',t)
    t=re.sub(r'(?s)<[^>]+>','\n',t); t=html.unescape(t)
    L=[re.sub(r'[ \t\xa0]+',' ',l).strip() for l in t.split('\n')]
    out=[];
    for l in L:
        if l and l not in out[-1:]: out.append(l)
    return '\n'.join(out)
res={}
for f in sorted(os.listdir(OUT)):
    if not f.endswith('.html'): continue
    h=open(os.path.join(OUT,f),encoding='utf-8').read()
    # region: after the booking-modal block, before newsletter/footer
    s=h.find('</nav>');  s=h.find('offer-detail') if s<0 else s
    for marker in ['mb-10 mb-lg-32','offer-detail','<main','</nav>']:
        i=h.find(marker)
        if i>0: s=i; break
    e=len(h)
    for marker in ['HƠN THẾ NỮA','H&#416;N TH&#7870;','MORE OFFER','<footer','newsletter']:
        j=h.find(marker,s)
        if j>0: e=min(e,j)
    b=h[s:e]
    imgs=[]
    for m in re.findall(r'(?:src|data-src)="((?:/files/|https://malibuhotel\.com\.vn/files/)[^"]+\.(?:jpg|jpeg|png|webp|avif))"',b,re.I):
        m=m.replace('https://malibuhotel.com.vn','')
        if m not in imgs: imgs.append(m)
    res[f]={"images":imgs,"text":strip(b)[:9000]}
json.dump(res,open(os.path.join(OUT,'extracted2.json'),'w',encoding='utf-8'),ensure_ascii=False,indent=1)
for k,v in res.items(): print(f"{k}: {len(v['images'])} imgs, {len(v['text'])} chars")
