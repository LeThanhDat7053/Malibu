import re,os,json,html
OUT=os.path.dirname(os.path.abspath(__file__))
h=open(os.path.join(OUT,"rooms-and-suites.html.html"),encoding="utf-8").read()
body=h.split('class="roomSuiteAll',1)[1]
anchors=[(m.start(),m.group(1)) for m in re.finditer(r'id="carouselImgRoomControls_(\d+)"',body)]
rooms=[]
for k,(pos,rid) in enumerate(anchors):
    end=anchors[k+1][0] if k+1<len(anchors) else pos+40000
    c=body[pos:end]
    imgs=[]
    for m in re.findall(r'src="(/files/hotels/[^"]+)"',c):
        if m not in imgs: imgs.append(m)
    name=re.search(r'<h2[^>]*>(.*?)</h2>',c,re.S)
    desc=re.search(r'<p class="lead[^"]*">(.*?)</p>',c,re.S)
    facs=re.findall(r'<p>([^<]{2,80})</p>',c)
    cl=lambda s: html.unescape(re.sub(r'\s+',' ',re.sub(r'<[^>]+>','',s))).strip() if s else ''
    rooms.append({"id":rid,"name":cl(name.group(1) if name else ''),
        "desc":cl(desc.group(1) if desc else ''),
        "facilities":[cl(f) for f in facs],"images":imgs})
json.dump(rooms,open(os.path.join(OUT,"rooms.json"),"w",encoding="utf-8"),ensure_ascii=False,indent=1)
for r in rooms:
    print(f"{r['id']:>4} {r['name']:<22} | {r['desc']:<48} | {r['facilities']} | {len(r['images'])} imgs")
