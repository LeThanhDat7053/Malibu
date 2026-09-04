import re,os,json,html
OUT=os.path.dirname(os.path.abspath(__file__))
def strip(t):
    t=re.sub(r'(?is)<(script|style)[^>]*>.*?</\1>',' ',t)
    t=re.sub(r'(?s)<[^>]+>',' ',t)
    t=html.unescape(t)
    return re.sub(r'[ \t\xa0]+',' ',re.sub(r'\n\s*\n+','\n',t)).strip()

def main_block(h):
    # content sits between 'mb-10 mb-lg-32' wrapper and 'MORE OFFER'/'blogs-container'
    i=h.find('mb-10 mb-lg-32')
    if i<0: i=h.find('<div class="offer-detail">')
    j=h.find('MORE OFFER',i)
    if j<0: j=h.find('blogs-container',i)
    if j<0: j=i+40000
    return h[i:j]

res={}
for f in sorted(os.listdir(OUT)):
    if not f.endswith('.html'): continue
    h=open(os.path.join(OUT,f),encoding='utf-8').read()
    b=main_block(h)
    imgs=sorted(set(re.findall(r'(?:src|data-src)="(/files/[^"]+\.(?:jpg|jpeg|png|webp|avif))"',b,re.I)))
    txt=strip(b)
    res[f]={"images":imgs,"text":txt[:6000]}
json.dump(res,open(os.path.join(OUT,'extracted.json'),'w',encoding='utf-8'),ensure_ascii=False,indent=1)
for k,v in res.items():
    print(f"{k}: {len(v['images'])} imgs, {len(v['text'])} chars")
