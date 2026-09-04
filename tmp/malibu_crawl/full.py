import re,os,json,html,sys
OUT=os.path.dirname(os.path.abspath(__file__))
def strip(t):
    t=re.sub(r'(?is)<(script|style)[^>]*>.*?</\1>',' ',t)
    t=re.sub(r'(?s)<[^>]+>','\n',t); t=html.unescape(t)
    L=[re.sub(r'[ \t\xa0]+',' ',l).strip() for l in t.split('\n')]
    out=[]
    for l in L:
        if l and (not out or l!=out[-1]): out.append(l)
    return '\n'.join(out)
os.makedirs(os.path.join(OUT,'txt'),exist_ok=True)
for f in sorted(os.listdir(OUT)):
    if not f.endswith('.html'): continue
    h=open(os.path.join(OUT,f),encoding='utf-8').read()
    t=strip(h)
    open(os.path.join(OUT,'txt',f+'.txt'),'w',encoding='utf-8').write(t)
    # images
    imgs=[]
    for m in re.findall(r'(?:src|data-src|href)="((?:/files/|https://malibuhotel\.com\.vn/files/)[^"]+\.(?:jpg|jpeg|png|webp|avif))"',h,re.I):
        m=m.replace('https://malibuhotel.com.vn','')
        if m not in imgs: imgs.append(m)
    open(os.path.join(OUT,'txt',f+'.imgs'),'w',encoding='utf-8').write('\n'.join(imgs))
    print(f, len(t), len(imgs))
