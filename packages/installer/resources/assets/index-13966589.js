(function () {
  const t = document.createElement('link').relList;
  if (t && t.supports && t.supports('modulepreload')) return;
  for (const a of document.querySelectorAll('link[rel="modulepreload"]')) n(a);
  new MutationObserver(a => {
    for (const r of a) if (r.type === 'childList') for (const h of r.addedNodes) h.tagName === 'LINK' && h.rel === 'modulepreload' && n(h);
  }).observe(document, { childList: !0, subtree: !0 });
  function s(a) {
    const r = {};
    return (
      a.integrity && (r.integrity = a.integrity),
      a.referrerPolicy && (r.referrerPolicy = a.referrerPolicy),
      a.crossOrigin === 'use-credentials'
        ? (r.credentials = 'include')
        : a.crossOrigin === 'anonymous'
        ? (r.credentials = 'omit')
        : (r.credentials = 'same-origin'),
      r
    );
  }
  function n(a) {
    if (a.ep) return;
    a.ep = !0;
    const r = s(a);
    fetch(a.href, r);
  }
})();
function Ze() {}
function Kl(l) {
  return l();
}
function gl() {
  return Object.create(null);
}
function Fe(l) {
  l.forEach(Kl);
}
function Ql(l) {
  return typeof l == 'function';
}
function Xl(l, t) {
  return l != l ? t == t : l !== t || (l && typeof l == 'object') || typeof l == 'function';
}
function Zl(l) {
  return Object.keys(l).length === 0;
}
function i(l, t) {
  l.appendChild(t);
}
function j(l, t, s) {
  l.insertBefore(t, s || null);
}
function k(l) {
  l.parentNode && l.parentNode.removeChild(l);
}
function $l(l, t) {
  for (let s = 0; s < l.length; s += 1) l[s] && l[s].d(t);
}
function o(l) {
  return document.createElement(l);
}
function Q(l) {
  return document.createElementNS('http://www.w3.org/2000/svg', l);
}
function U(l) {
  return document.createTextNode(l);
}
function c() {
  return U(' ');
}
function F(l, t, s, n) {
  return l.addEventListener(t, s, n), () => l.removeEventListener(t, s, n);
}
function e(l, t, s) {
  s == null ? l.removeAttribute(t) : l.getAttribute(t) !== s && l.setAttribute(t, s);
}
function es(l) {
  return Array.from(l.childNodes);
}
function K(l, t) {
  (t = '' + t), l.wholeText !== t && (l.data = t);
}
function T(l, t) {
  l.value = t ?? '';
}
function bl(l, t, s) {
  for (let n = 0; n < l.options.length; n += 1) {
    const a = l.options[n];
    if (a.__value === t) {
      a.selected = !0;
      return;
    }
  }
  (!s || t !== void 0) && (l.selectedIndex = -1);
}
function ts(l) {
  const t = l.querySelector(':checked');
  return t && t.__value;
}
let Et;
function dt(l) {
  Et = l;
}
const Ge = [],
  hl = [];
let Xe = [];
const vl = [],
  ls = Promise.resolve();
let Bt = !1;
function ss() {
  Bt || ((Bt = !0), ls.then(Gl));
}
function xt(l) {
  Xe.push(l);
}
const At = new Set();
let Qe = 0;
function Gl() {
  if (Qe !== 0) return;
  const l = Et;
  do {
    try {
      for (; Qe < Ge.length; ) {
        const t = Ge[Qe];
        Qe++, dt(t), is(t.$$);
      }
    } catch (t) {
      throw ((Ge.length = 0), (Qe = 0), t);
    }
    for (dt(null), Ge.length = 0, Qe = 0; hl.length; ) hl.pop()();
    for (let t = 0; t < Xe.length; t += 1) {
      const s = Xe[t];
      At.has(s) || (At.add(s), s());
    }
    Xe.length = 0;
  } while (Ge.length);
  for (; vl.length; ) vl.pop()();
  (Bt = !1), At.clear(), dt(l);
}
function is(l) {
  if (l.fragment !== null) {
    l.update(), Fe(l.before_update);
    const t = l.dirty;
    (l.dirty = [-1]), l.fragment && l.fragment.p(l.ctx, t), l.after_update.forEach(xt);
  }
}
function as(l) {
  const t = [],
    s = [];
  Xe.forEach(n => (l.indexOf(n) === -1 ? t.push(n) : s.push(n))), s.forEach(n => n()), (Xe = t);
}
const ns = new Set();
function os(l, t) {
  l && l.i && (ns.delete(l), l.i(t));
}
function rs(l, t, s, n) {
  const { fragment: a, after_update: r } = l.$$;
  a && a.m(t, s),
    n ||
      xt(() => {
        const h = l.$$.on_mount.map(Kl).filter(Ql);
        l.$$.on_destroy ? l.$$.on_destroy.push(...h) : Fe(h), (l.$$.on_mount = []);
      }),
    r.forEach(xt);
}
function ds(l, t) {
  const s = l.$$;
  s.fragment !== null &&
    (as(s.after_update), Fe(s.on_destroy), s.fragment && s.fragment.d(t), (s.on_destroy = s.fragment = null), (s.ctx = []));
}
function us(l, t) {
  l.$$.dirty[0] === -1 && (Ge.push(l), ss(), l.$$.dirty.fill(0)), (l.$$.dirty[(t / 31) | 0] |= 1 << t % 31);
}
function cs(l, t, s, n, a, r, h, v = [-1]) {
  const x = Et;
  dt(l);
  const f = (l.$$ = {
    fragment: null,
    ctx: [],
    props: r,
    update: Ze,
    not_equal: a,
    bound: gl(),
    on_mount: [],
    on_destroy: [],
    on_disconnect: [],
    before_update: [],
    after_update: [],
    context: new Map(t.context || (x ? x.$$.context : [])),
    callbacks: gl(),
    dirty: v,
    skip_bound: !1,
    root: t.target || x.$$.root,
  });
  h && h(f.root);
  let u = !1;
  if (
    ((f.ctx = s
      ? s(l, t.props || {}, (g, b, ...p) => {
          const B = p.length ? p[0] : b;
          return f.ctx && a(f.ctx[g], (f.ctx[g] = B)) && (!f.skip_bound && f.bound[g] && f.bound[g](B), u && us(l, g)), b;
        })
      : []),
    f.update(),
    (u = !0),
    Fe(f.before_update),
    (f.fragment = n ? n(f.ctx) : !1),
    t.target)
  ) {
    if (t.hydrate) {
      const g = es(t.target);
      f.fragment && f.fragment.l(g), g.forEach(k);
    } else f.fragment && f.fragment.c();
    t.intro && os(l.$$.fragment), rs(l, t.target, t.anchor, t.customElement), Gl();
  }
  dt(x);
}
class fs {
  $destroy() {
    ds(this, 1), (this.$destroy = Ze);
  }
  $on(t, s) {
    if (!Ql(s)) return Ze;
    const n = this.$$.callbacks[t] || (this.$$.callbacks[t] = []);
    return (
      n.push(s),
      () => {
        const a = n.indexOf(s);
        a !== -1 && n.splice(a, 1);
      }
    );
  }
  $set(t) {
    this.$$set && !Zl(t) && ((this.$$.skip_bound = !0), this.$$set(t), (this.$$.skip_bound = !1));
  }
}
function _l(l, t, s) {
  const n = l.slice();
  return (n[36] = t[s]), n;
}
function wl(l) {
  let t, s;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('path')),
        e(s, 'stroke-linecap', 'round'),
        e(s, 'stroke-linejoin', 'round'),
        e(s, 'd', 'M4.5 12.75l6 6 9-13.5'),
        e(t, 'xmlns', 'http://www.w3.org/2000/svg'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 24 24'),
        e(t, 'stroke-width', '1.5'),
        e(t, 'stroke', 'currentColor'),
        e(t, 'class', 'w-5 h-5');
    },
    m(n, a) {
      j(n, t, a), i(t, s);
    },
    d(n) {
      n && k(t);
    },
  };
}
function yl(l) {
  let t, s;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('path')),
        e(s, 'stroke-linecap', 'round'),
        e(s, 'stroke-linejoin', 'round'),
        e(s, 'd', 'M4.5 12.75l6 6 9-13.5'),
        e(t, 'xmlns', 'http://www.w3.org/2000/svg'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 24 24'),
        e(t, 'stroke-width', '1.5'),
        e(t, 'stroke', 'currentColor'),
        e(t, 'class', 'w-5 h-5');
    },
    m(n, a) {
      j(n, t, a), i(t, s);
    },
    d(n) {
      n && k(t);
    },
  };
}
function kl(l) {
  let t, s, n;
  return {
    c() {
      (t = o('div')),
        (s = o('h3')),
        (n = U(l[3])),
        e(s, 'class', 'text-sm font-medium text-green-800'),
        e(t, 'class', 'rounded-md bg-green-50 p-4 mb-6');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(s, n);
    },
    p(a, r) {
      r[0] & 8 && K(n, a[3]);
    },
    d(a) {
      a && k(t);
    },
  };
}
function xl(l) {
  let t, s, n;
  return {
    c() {
      (t = o('div')),
        (s = o('h3')),
        (n = U(l[1])),
        e(s, 'class', 'text-sm font-medium text-red-800'),
        e(t, 'class', 'rounded-md bg-red-50 p-4 mb-6');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(s, n);
    },
    p(a, r) {
      r[0] & 2 && K(n, a[1]);
    },
    d(a) {
      a && k(t);
    },
  };
}
function ms(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w = l[2] && jl();
  return {
    c() {
      (t = o('div')),
        (s = o('div')),
        (s.innerHTML = `<h1 class="text-lg font-medium leading-6 text-gray-900">We&#39;re almost done</h1>
        <p class="mt-1 text-sm text-gray-500">Please finalize the installation.</p>`),
        (n = c()),
        (a = o('div')),
        (a.innerHTML = `<div class="rounded-md bg-green-50 p-4"><div class="flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg></div>
            <div class="ml-3"><h3 class="text-sm font-medium text-green-800">Settings Updated!</h3>
              <div class="mt-2 text-sm text-green-700"><p>The settings has been updated. Please finalize the
                  installation.</p></div></div></div></div>`),
        (r = c()),
        (h = o('div')),
        (v = o('button')),
        (v.textContent = 'Start'),
        (x = c()),
        (f = o('button')),
        (u = U(`Finalize
          `)),
        w && w.c(),
        e(a, 'class', 'mt-6'),
        e(v, 'type', 'button'),
        e(
          v,
          'class',
          'rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2'
        ),
        e(f, 'type', 'button'),
        (f.disabled = g = l[2] || l[4]),
        e(
          f,
          'class',
          (b =
            'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 ' +
            (l[2] || l[4] ? 'opacity-80' : ''))
        ),
        e(h, 'class', 'flex justify-end border-t py-6'),
        e(t, 'class', 'space-y-6');
    },
    m(y, A) {
      j(y, t, A),
        i(t, s),
        i(t, n),
        i(t, a),
        i(t, r),
        i(t, h),
        i(h, v),
        i(h, x),
        i(h, f),
        i(f, u),
        w && w.m(f, null),
        p || ((B = [F(v, 'click', l[33]), F(f, 'click', l[10])]), (p = !0));
    },
    p(y, A) {
      y[2] ? w || ((w = jl()), w.c(), w.m(f, null)) : w && (w.d(1), (w = null)),
        A[0] & 20 && g !== (g = y[2] || y[4]) && (f.disabled = g),
        A[0] & 20 &&
          b !==
            (b =
              'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 ' +
              (y[2] || y[4] ? 'opacity-80' : '')) &&
          e(f, 'class', b);
    },
    d(y) {
      y && k(t), w && w.d(), (p = !1), Fe(B);
    },
  };
}
function ps(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w,
    y,
    A,
    N = l[5] && Object.keys(l[5]).length && l[5]['license.username'],
    D,
    O,
    _,
    S,
    H,
    M,
    P,
    q = l[5] && Object.keys(l[5]).length && l[5]['license.code'],
    xe,
    Z,
    W,
    ye,
    ve,
    te,
    V,
    I,
    Y,
    R,
    E,
    m,
    z,
    se = l[5] && Object.keys(l[5]).length && l[5]['database.host'],
    We,
    _e,
    Ae,
    $e,
    $,
    J,
    le,
    ee = l[5] && Object.keys(l[5]).length && l[5]['database.port'],
    et,
    ie,
    G,
    L,
    X,
    Ce,
    Nt,
    jt = l[5] && Object.keys(l[5]).length && l[5]['database.user'],
    Dt,
    Be,
    tt,
    It,
    ut,
    Me,
    Ut,
    Ct = l[5] && Object.keys(l[5]).length && l[5]['database.password'],
    Vt,
    Ee,
    lt,
    qt,
    ct,
    Oe,
    Ft,
    Mt = l[5] && Object.keys(l[5]).length && l[5]['database.name'],
    Rt,
    Ne,
    st,
    Wt,
    ft,
    Se,
    Yt,
    Ot = l[5] && Object.keys(l[5]).length && l[5]['database.socket'],
    Jt,
    mt,
    Kt,
    Qt,
    pt,
    Ye,
    gt,
    Gt,
    bt,
    ke,
    De,
    it,
    Xt,
    ht,
    Le,
    Zt,
    St = l[5] && Object.keys(l[5]).length && l[5]['account.name'],
    $t,
    Ie,
    at,
    el,
    vt,
    Te,
    tl,
    Lt = l[5] && Object.keys(l[5]).length && l[5]['account.username'],
    ll,
    Ue,
    nt,
    sl,
    _t,
    He,
    il,
    Tt = l[5] && Object.keys(l[5]).length && l[5]['account.email'],
    al,
    Ve,
    ot,
    nl,
    wt,
    Pe,
    ol,
    Ht = l[5] && Object.keys(l[5]).length && l[5]['account.password'],
    rl,
    qe,
    rt,
    dl,
    yt,
    ze,
    ul,
    Pt = l[5] && Object.keys(l[5]).length && l[5]['account.password_confirmation'],
    cl,
    Je,
    Ke,
    fl,
    je,
    ml,
    kt,
    zt,
    pl,
    ae = N && Cl(l),
    ne = q && Ml(l),
    oe = se && Ol(l),
    re = ee && Sl(l),
    de = jt && Ll(l),
    ue = Ct && Tl(l),
    ce = Mt && Hl(l),
    fe = Ot && Pl(l),
    Re = hs(l),
    me = St && Il(l),
    pe = Lt && Ul(l),
    ge = Tt && Vl(l),
    be = Ht && ql(l),
    he = Pt && Fl(l),
    we = l[4] && Rl();
  return {
    c() {
      (t = o('div')),
        (s = o('div')),
        (s.innerHTML = `<h1 class="text-lg font-medium leading-6 text-gray-900">Settings</h1>
        <p class="mt-1 text-sm text-gray-500">Please fill the information to proceed to next step.</p>`),
        (n = c()),
        (a = o('div')),
        (r = o('ol')),
        (h = o('li')),
        (v = o('div')),
        (x = o('h3')),
        (x.textContent = '1. Purchase Verification'),
        (f = c()),
        (u = o('div')),
        (g = o('div')),
        (b = o('div')),
        (p = o('label')),
        (p.textContent = 'Account Username'),
        (B = c()),
        (w = o('div')),
        (y = o('input')),
        (A = c()),
        ae && ae.c(),
        (D = c()),
        (O = o('div')),
        (_ = o('label')),
        (_.textContent = 'Purchase Code (License Key)'),
        (S = c()),
        (H = o('div')),
        (M = o('input')),
        (P = c()),
        ne && ne.c(),
        (xe = c()),
        (Z = o('li')),
        (W = o('div')),
        (ye = o('h3')),
        (ye.textContent = '2. Database Server Details'),
        (ve = c()),
        (te = o('div')),
        (V = o('div')),
        (I = o('div')),
        (Y = o('label')),
        (Y.textContent = 'Host'),
        (R = c()),
        (E = o('div')),
        (m = o('input')),
        (z = c()),
        oe && oe.c(),
        (We = c()),
        (_e = o('div')),
        (Ae = o('label')),
        (Ae.textContent = 'Port'),
        ($e = c()),
        ($ = o('div')),
        (J = o('input')),
        (le = c()),
        re && re.c(),
        (et = c()),
        (ie = o('div')),
        (G = o('label')),
        (G.textContent = 'Username'),
        (L = c()),
        (X = o('div')),
        (Ce = o('input')),
        (Nt = c()),
        de && de.c(),
        (Dt = c()),
        (Be = o('div')),
        (tt = o('label')),
        (tt.textContent = 'Password'),
        (It = c()),
        (ut = o('div')),
        (Me = o('input')),
        (Ut = c()),
        ue && ue.c(),
        (Vt = c()),
        (Ee = o('div')),
        (lt = o('label')),
        (lt.textContent = 'Database Name'),
        (qt = c()),
        (ct = o('div')),
        (Oe = o('input')),
        (Ft = c()),
        ce && ce.c(),
        (Rt = c()),
        (Ne = o('div')),
        (st = o('label')),
        (st.textContent = 'Socket'),
        (Wt = c()),
        (ft = o('div')),
        (Se = o('input')),
        (Yt = c()),
        fe && fe.c(),
        (Jt = c()),
        (mt = o('div')),
        (mt.innerHTML = `<div class="rounded-md bg-blue-50 p-4"><div class="flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></div>
                  <div class="flex-1 md:flex md:justify-between"><p class="ml-3 text-sm text-blue-700">You can edit these settings in your <code>.env</code> file
                      later.</p></div></div></div>`),
        (Kt = c()),
        Re && Re.c(),
        (Qt = c()),
        (pt = o('li')),
        (Ye = o('div')),
        (gt = o('h3')),
        (gt.textContent = '4. Create Admin Account'),
        (Gt = c()),
        (bt = o('div')),
        (ke = o('div')),
        (De = o('div')),
        (it = o('label')),
        (it.textContent = 'Full Name'),
        (Xt = c()),
        (ht = o('div')),
        (Le = o('input')),
        (Zt = c()),
        me && me.c(),
        ($t = c()),
        (Ie = o('div')),
        (at = o('label')),
        (at.textContent = 'Username'),
        (el = c()),
        (vt = o('div')),
        (Te = o('input')),
        (tl = c()),
        pe && pe.c(),
        (ll = c()),
        (Ue = o('div')),
        (nt = o('label')),
        (nt.textContent = 'Email Address'),
        (sl = c()),
        (_t = o('div')),
        (He = o('input')),
        (il = c()),
        ge && ge.c(),
        (al = c()),
        (Ve = o('div')),
        (ot = o('label')),
        (ot.textContent = 'Password'),
        (nl = c()),
        (wt = o('div')),
        (Pe = o('input')),
        (ol = c()),
        be && be.c(),
        (rl = c()),
        (qe = o('div')),
        (rt = o('label')),
        (rt.textContent = 'Confirm Password'),
        (dl = c()),
        (yt = o('div')),
        (ze = o('input')),
        (ul = c()),
        he && he.c(),
        (cl = c()),
        (Je = o('div')),
        (Ke = o('button')),
        (Ke.textContent = 'Start'),
        (fl = c()),
        (je = o('button')),
        (ml = U(`Next
          `)),
        we && we.c(),
        e(s, 'class', 'border-b pb-4'),
        e(x, 'class', 'text-sm font-semibold text-gray-800'),
        e(p, 'for', 'account-username'),
        e(p, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(y, 'type', 'text'),
        e(y, 'id', 'account-username'),
        e(y, 'name', 'account_username'),
        e(
          y,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(w, 'class', 'mt-1'),
        e(b, 'class', ''),
        e(_, 'for', 'purchase-code'),
        e(_, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(M, 'type', 'text'),
        e(M, 'id', 'purchase-code'),
        e(M, 'name', 'purchase_code'),
        e(
          M,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(H, 'class', 'mt-1'),
        e(O, 'class', ''),
        e(g, 'class', 'sm:grid sm:grid-cols-2 sm:items-start sm:gap-4'),
        e(u, 'class', 'space-y-6 sm:space-y-5 pl-4 pt-2'),
        e(v, 'class', 'relative'),
        e(h, 'class', 'py-5'),
        e(ye, 'class', 'text-sm font-semibold text-gray-800'),
        e(Y, 'for', 'database-host'),
        e(Y, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(m, 'type', 'text'),
        e(m, 'id', 'database-host'),
        e(m, 'name', 'database_host'),
        e(
          m,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(E, 'class', 'mt-1'),
        e(I, 'class', ''),
        e(Ae, 'for', 'database-port'),
        e(Ae, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(J, 'type', 'text'),
        e(J, 'id', 'database-port'),
        e(J, 'name', 'database_port'),
        e(
          J,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e($, 'class', 'mt-1'),
        e(_e, 'class', ''),
        e(G, 'for', 'database-username'),
        e(G, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Ce, 'type', 'text'),
        e(Ce, 'id', 'database-username'),
        e(Ce, 'name', 'database_username'),
        e(
          Ce,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(X, 'class', 'mt-1'),
        e(ie, 'class', ''),
        e(tt, 'for', 'database-password'),
        e(tt, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Me, 'type', 'password'),
        e(Me, 'id', 'database-password'),
        e(Me, 'name', 'database_password'),
        e(
          Me,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(ut, 'class', 'mt-1'),
        e(Be, 'class', ''),
        e(lt, 'for', 'database-name'),
        e(lt, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Oe, 'type', 'text'),
        e(Oe, 'id', 'database-name'),
        e(Oe, 'name', 'database_name'),
        e(
          Oe,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(ct, 'class', 'mt-1'),
        e(Ee, 'class', ''),
        e(st, 'for', 'database-socket'),
        e(st, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Se, 'type', 'text'),
        e(Se, 'id', 'database-socket'),
        e(Se, 'name', 'database_socket'),
        e(
          Se,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(ft, 'class', 'mt-1'),
        e(Ne, 'class', ''),
        e(V, 'class', 'sm:grid sm:grid-cols-2 sm:items-start sm:gap-4'),
        e(te, 'class', 'space-y-6 sm:space-y-5 pl-4 pt-2'),
        e(W, 'class', 'relative'),
        e(mt, 'class', 'pl-4 mt-6'),
        e(Z, 'class', 'py-5'),
        e(gt, 'class', 'text-sm font-semibold text-gray-800'),
        e(it, 'for', 'username-name'),
        e(it, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Le, 'type', 'text'),
        e(Le, 'id', 'username-name'),
        e(Le, 'name', 'username_name'),
        e(Le, 'class', 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm'),
        e(ht, 'class', 'mt-1'),
        e(De, 'class', 'col-span-full'),
        e(at, 'for', 'username-username'),
        e(at, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Te, 'type', 'text'),
        e(Te, 'id', 'username-username'),
        e(Te, 'name', 'username'),
        e(
          Te,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(vt, 'class', 'mt-1'),
        e(Ie, 'class', ''),
        e(nt, 'for', 'username-email'),
        e(nt, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(He, 'type', 'email'),
        e(He, 'id', 'username-email'),
        e(He, 'name', 'username_email'),
        e(
          He,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(_t, 'class', 'mt-1'),
        e(Ue, 'class', ''),
        e(ot, 'for', 'username-password'),
        e(ot, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(Pe, 'type', 'password'),
        e(Pe, 'id', 'username-password'),
        e(Pe, 'name', 'username_password'),
        e(
          Pe,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(wt, 'class', 'mt-1'),
        e(Ve, 'class', ''),
        e(rt, 'for', 'username-password-confirmation'),
        e(rt, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(ze, 'type', 'password'),
        e(ze, 'id', 'username-password-confirmation'),
        e(ze, 'name', 'database_password_confirmation'),
        e(
          ze,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(yt, 'class', 'mt-1'),
        e(qe, 'class', ''),
        e(ke, 'class', 'sm:grid sm:grid-cols-2 sm:items-start sm:gap-4'),
        e(bt, 'class', 'space-y-6 sm:space-y-5 pl-4 pt-2'),
        e(Ye, 'class', 'relative'),
        e(pt, 'class', 'py-5'),
        e(r, 'class', '-my-5 divide-y divide-gray-200'),
        e(a, 'class', 'mt-6 flow-root'),
        e(Ke, 'type', 'button'),
        e(
          Ke,
          'class',
          'rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2'
        ),
        e(je, 'type', 'button'),
        (je.disabled = l[4]),
        e(
          je,
          'class',
          (kt =
            'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-50 ' +
            (l[4] ? 'opacity-80' : ''))
        ),
        e(Je, 'class', 'flex justify-end border-t py-6'),
        e(t, 'class', 'space-y-6');
    },
    m(d, C) {
      j(d, t, C),
        i(t, s),
        i(t, n),
        i(t, a),
        i(a, r),
        i(r, h),
        i(h, v),
        i(v, x),
        i(v, f),
        i(v, u),
        i(u, g),
        i(g, b),
        i(b, p),
        i(b, B),
        i(b, w),
        i(w, y),
        T(y, l[7].license.username),
        i(b, A),
        ae && ae.m(b, null),
        i(g, D),
        i(g, O),
        i(O, _),
        i(O, S),
        i(O, H),
        i(H, M),
        T(M, l[7].license.code),
        i(O, P),
        ne && ne.m(O, null),
        i(r, xe),
        i(r, Z),
        i(Z, W),
        i(W, ye),
        i(W, ve),
        i(W, te),
        i(te, V),
        i(V, I),
        i(I, Y),
        i(I, R),
        i(I, E),
        i(E, m),
        T(m, l[7].database.host),
        i(I, z),
        oe && oe.m(I, null),
        i(V, We),
        i(V, _e),
        i(_e, Ae),
        i(_e, $e),
        i(_e, $),
        i($, J),
        T(J, l[7].database.port),
        i(_e, le),
        re && re.m(_e, null),
        i(V, et),
        i(V, ie),
        i(ie, G),
        i(ie, L),
        i(ie, X),
        i(X, Ce),
        T(Ce, l[7].database.user),
        i(ie, Nt),
        de && de.m(ie, null),
        i(V, Dt),
        i(V, Be),
        i(Be, tt),
        i(Be, It),
        i(Be, ut),
        i(ut, Me),
        T(Me, l[7].database.password),
        i(Be, Ut),
        ue && ue.m(Be, null),
        i(V, Vt),
        i(V, Ee),
        i(Ee, lt),
        i(Ee, qt),
        i(Ee, ct),
        i(ct, Oe),
        T(Oe, l[7].database.name),
        i(Ee, Ft),
        ce && ce.m(Ee, null),
        i(V, Rt),
        i(V, Ne),
        i(Ne, st),
        i(Ne, Wt),
        i(Ne, ft),
        i(ft, Se),
        T(Se, l[7].database.socket),
        i(Ne, Yt),
        fe && fe.m(Ne, null),
        i(Z, Jt),
        i(Z, mt),
        i(r, Kt),
        Re && Re.m(r, null),
        i(r, Qt),
        i(r, pt),
        i(pt, Ye),
        i(Ye, gt),
        i(Ye, Gt),
        i(Ye, bt),
        i(bt, ke),
        i(ke, De),
        i(De, it),
        i(De, Xt),
        i(De, ht),
        i(ht, Le),
        T(Le, l[7].account.name),
        i(De, Zt),
        me && me.m(De, null),
        i(ke, $t),
        i(ke, Ie),
        i(Ie, at),
        i(Ie, el),
        i(Ie, vt),
        i(vt, Te),
        T(Te, l[7].account.username),
        i(Ie, tl),
        pe && pe.m(Ie, null),
        i(ke, ll),
        i(ke, Ue),
        i(Ue, nt),
        i(Ue, sl),
        i(Ue, _t),
        i(_t, He),
        T(He, l[7].account.email),
        i(Ue, il),
        ge && ge.m(Ue, null),
        i(ke, al),
        i(ke, Ve),
        i(Ve, ot),
        i(Ve, nl),
        i(Ve, wt),
        i(wt, Pe),
        T(Pe, l[7].account.password),
        i(Ve, ol),
        be && be.m(Ve, null),
        i(ke, rl),
        i(ke, qe),
        i(qe, rt),
        i(qe, dl),
        i(qe, yt),
        i(yt, ze),
        T(ze, l[7].account.password_confirmation),
        i(qe, ul),
        he && he.m(qe, null),
        i(t, cl),
        i(t, Je),
        i(Je, Ke),
        i(Je, fl),
        i(Je, je),
        i(je, ml),
        we && we.m(je, null),
        zt ||
          ((pl = [
            F(y, 'input', l[13]),
            F(M, 'input', l[14]),
            F(m, 'input', l[15]),
            F(J, 'input', l[16]),
            F(Ce, 'input', l[17]),
            F(Me, 'input', l[18]),
            F(Oe, 'input', l[19]),
            F(Se, 'input', l[20]),
            F(Le, 'input', l[27]),
            F(Te, 'input', l[28]),
            F(He, 'input', l[29]),
            F(Pe, 'input', l[30]),
            F(ze, 'input', l[31]),
            F(Ke, 'click', l[32]),
            F(je, 'click', l[9]),
          ]),
          (zt = !0));
    },
    p(d, C) {
      C[0] & 128 && y.value !== d[7].license.username && T(y, d[7].license.username),
        C[0] & 32 && (N = d[5] && Object.keys(d[5]).length && d[5]['license.username']),
        N ? (ae ? ae.p(d, C) : ((ae = Cl(d)), ae.c(), ae.m(b, null))) : ae && (ae.d(1), (ae = null)),
        C[0] & 128 && M.value !== d[7].license.code && T(M, d[7].license.code),
        C[0] & 32 && (q = d[5] && Object.keys(d[5]).length && d[5]['license.code']),
        q ? (ne ? ne.p(d, C) : ((ne = Ml(d)), ne.c(), ne.m(O, null))) : ne && (ne.d(1), (ne = null)),
        C[0] & 128 && m.value !== d[7].database.host && T(m, d[7].database.host),
        C[0] & 32 && (se = d[5] && Object.keys(d[5]).length && d[5]['database.host']),
        se ? (oe ? oe.p(d, C) : ((oe = Ol(d)), oe.c(), oe.m(I, null))) : oe && (oe.d(1), (oe = null)),
        C[0] & 128 && J.value !== d[7].database.port && T(J, d[7].database.port),
        C[0] & 32 && (ee = d[5] && Object.keys(d[5]).length && d[5]['database.port']),
        ee ? (re ? re.p(d, C) : ((re = Sl(d)), re.c(), re.m(_e, null))) : re && (re.d(1), (re = null)),
        C[0] & 128 && Ce.value !== d[7].database.user && T(Ce, d[7].database.user),
        C[0] & 32 && (jt = d[5] && Object.keys(d[5]).length && d[5]['database.user']),
        jt ? (de ? de.p(d, C) : ((de = Ll(d)), de.c(), de.m(ie, null))) : de && (de.d(1), (de = null)),
        C[0] & 128 && Me.value !== d[7].database.password && T(Me, d[7].database.password),
        C[0] & 32 && (Ct = d[5] && Object.keys(d[5]).length && d[5]['database.password']),
        Ct ? (ue ? ue.p(d, C) : ((ue = Tl(d)), ue.c(), ue.m(Be, null))) : ue && (ue.d(1), (ue = null)),
        C[0] & 128 && Oe.value !== d[7].database.name && T(Oe, d[7].database.name),
        C[0] & 32 && (Mt = d[5] && Object.keys(d[5]).length && d[5]['database.name']),
        Mt ? (ce ? ce.p(d, C) : ((ce = Hl(d)), ce.c(), ce.m(Ee, null))) : ce && (ce.d(1), (ce = null)),
        C[0] & 128 && Se.value !== d[7].database.socket && T(Se, d[7].database.socket),
        C[0] & 32 && (Ot = d[5] && Object.keys(d[5]).length && d[5]['database.socket']),
        Ot ? (fe ? fe.p(d, C) : ((fe = Pl(d)), fe.c(), fe.m(Ne, null))) : fe && (fe.d(1), (fe = null)),
        Re.p(d, C),
        C[0] & 128 && Le.value !== d[7].account.name && T(Le, d[7].account.name),
        C[0] & 32 && (St = d[5] && Object.keys(d[5]).length && d[5]['account.name']),
        St ? (me ? me.p(d, C) : ((me = Il(d)), me.c(), me.m(De, null))) : me && (me.d(1), (me = null)),
        C[0] & 128 && Te.value !== d[7].account.username && T(Te, d[7].account.username),
        C[0] & 32 && (Lt = d[5] && Object.keys(d[5]).length && d[5]['account.username']),
        Lt ? (pe ? pe.p(d, C) : ((pe = Ul(d)), pe.c(), pe.m(Ie, null))) : pe && (pe.d(1), (pe = null)),
        C[0] & 128 && He.value !== d[7].account.email && T(He, d[7].account.email),
        C[0] & 32 && (Tt = d[5] && Object.keys(d[5]).length && d[5]['account.email']),
        Tt ? (ge ? ge.p(d, C) : ((ge = Vl(d)), ge.c(), ge.m(Ue, null))) : ge && (ge.d(1), (ge = null)),
        C[0] & 128 && Pe.value !== d[7].account.password && T(Pe, d[7].account.password),
        C[0] & 32 && (Ht = d[5] && Object.keys(d[5]).length && d[5]['account.password']),
        Ht ? (be ? be.p(d, C) : ((be = ql(d)), be.c(), be.m(Ve, null))) : be && (be.d(1), (be = null)),
        C[0] & 128 && ze.value !== d[7].account.password_confirmation && T(ze, d[7].account.password_confirmation),
        C[0] & 32 && (Pt = d[5] && Object.keys(d[5]).length && d[5]['account.password_confirmation']),
        Pt ? (he ? he.p(d, C) : ((he = Fl(d)), he.c(), he.m(qe, null))) : he && (he.d(1), (he = null)),
        d[4] ? we || ((we = Rl()), we.c(), we.m(je, null)) : we && (we.d(1), (we = null)),
        C[0] & 16 && (je.disabled = d[4]),
        C[0] & 16 &&
          kt !==
            (kt =
              'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-50 ' +
              (d[4] ? 'opacity-80' : '')) &&
          e(je, 'class', kt);
    },
    d(d) {
      d && k(t),
        ae && ae.d(),
        ne && ne.d(),
        oe && oe.d(),
        re && re.d(),
        de && de.d(),
        ue && ue.d(),
        ce && ce.d(),
        fe && fe.d(),
        Re && Re.d(),
        me && me.d(),
        pe && pe.d(),
        ge && ge.d(),
        be && be.d(),
        he && he.d(),
        we && we.d(),
        (zt = !1),
        Fe(pl);
    },
  };
}
function gs(l) {
  let t, s, n, a, r, h, v, x, f, u, g, b, p, B, w, y;
  function A(_, S) {
    return _[6] ? ys : ws;
  }
  let N = A(l),
    D = N(l),
    O = l[4] && Yl();
  return {
    c() {
      (t = o('div')),
        (s = o('div')),
        (s.innerHTML = `<h1 class="text-lg font-medium leading-6 text-gray-900">Server</h1>
        <p class="mt-1 text-sm text-gray-500">Let&#39;s check the server software versions and extensions.</p>`),
        (n = c()),
        (a = o('div')),
        D.c(),
        (r = c()),
        (h = o('div')),
        (v = o('button')),
        (v.textContent = 'Start'),
        (x = c()),
        (f = o('button')),
        (u = U(`Re-Check
          `)),
        O && O.c(),
        (b = c()),
        (p = o('button')),
        (B = U('Next')),
        e(s, 'class', 'border-b pb-4'),
        e(a, 'class', 'mt-6 flow-root'),
        e(v, 'type', 'button'),
        e(
          v,
          'class',
          'rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2'
        ),
        e(f, 'type', 'button'),
        (f.disabled = l[4]),
        e(
          f,
          'class',
          (g =
            'ml-3 rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 ' +
            (l[4] ? 'opacity-80' : ''))
        ),
        e(p, 'type', 'button'),
        (p.disabled = l[1]),
        e(
          p,
          'class',
          'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-50'
        ),
        e(h, 'class', 'flex justify-end border-t py-6'),
        e(t, 'class', 'space-y-6');
    },
    m(_, S) {
      j(_, t, S),
        i(t, s),
        i(t, n),
        i(t, a),
        D.m(a, null),
        i(t, r),
        i(t, h),
        i(h, v),
        i(h, x),
        i(h, f),
        i(f, u),
        O && O.m(f, null),
        i(h, b),
        i(h, p),
        i(p, B),
        w || ((y = [F(v, 'click', l[12]), F(f, 'click', l[8]), F(p, 'click', l[8])]), (w = !0));
    },
    p(_, S) {
      N === (N = A(_)) && D ? D.p(_, S) : (D.d(1), (D = N(_)), D && (D.c(), D.m(a, null))),
        _[4] ? O || ((O = Yl()), O.c(), O.m(f, null)) : O && (O.d(1), (O = null)),
        S[0] & 16 && (f.disabled = _[4]),
        S[0] & 16 &&
          g !==
            (g =
              'ml-3 rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 ' +
              (_[4] ? 'opacity-80' : '')) &&
          e(f, 'class', g),
        S[0] & 2 && (p.disabled = _[1]);
    },
    d(_) {
      _ && k(t), D.d(), O && O.d(), (w = !1), Fe(y);
    },
  };
}
function bs(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w,
    y,
    A,
    N,
    D,
    O,
    _ = ks(),
    S = l[4] && Jl();
  return {
    c() {
      (t = o('div')),
        (s = o('div')),
        (s.innerHTML = `<h1 class="text-lg font-medium leading-6 text-gray-900">Let&#39;s Install</h1>
        <p class="mt-1 text-sm text-gray-500">Let&#39;s get started by preparing the information that we will need to
          install the item.</p>`),
        (n = c()),
        (a = o('div')),
        (a.innerHTML = `<div class="flex"><div class="flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-800"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path></svg></div>
          <div class="ml-3"><h3 class="font-bold text-blue-800">Free support for 6 months</h3>
            <div class="mt-2 text-sm text-blue-700"><p>Each purchase comes with free support for 6 months.</p>
              <p class="mt-2">If you have purchased from Envato marketplace then please
                validate your purchase code at <a target="_blank" href="https://tecdiary.net/support">support portal</a> to add item to your supported list.</p>
              <p class="mt-2 font-bold">We don&#39;t offer email support, so please ask support questions at <a target="_blank" href="https://tecdiary.net/support">support portal</a>.</p></div></div></div>`),
        (r = c()),
        (h = o('div')),
        (v = o('ol')),
        (x = o('li')),
        (x.innerHTML = `<div class="relative"><h3 class="text-sm font-semibold text-gray-800">1. Server Requirements</h3>
              <p class="mt-1 pl-4 text-sm text-gray-600"><strong>PHP 8.1+</strong>, <strong>MySQL 8+</strong> or
                <strong>MariaDB 10.3+</strong></p></div>`),
        (f = c()),
        (u = o('li')),
        (u.innerHTML = `<div class="relative"><h3 class="text-sm font-semibold text-gray-800">2. Purchase Verification</h3>
              <p class="mt-1 pl-4 text-sm text-gray-600">We will need your account <strong>username</strong> and
                <strong>purchase code</strong> to verify your purchase.</p></div>`),
        (g = c()),
        (b = o('li')),
        (b.innerHTML = `<div class="relative"><h3 class="text-sm font-semibold text-gray-800">3. Database Server Details</h3>
              <p class="mt-1 pl-4 text-sm text-gray-600">We will need your database <strong>host</strong>,
                <strong>port</strong>, <strong>user</strong> and
                <strong>password</strong>
                to connect to your database.</p></div>`),
        (p = c()),
        _ && _.c(),
        (B = c()),
        (w = o('div')),
        (y = o('button')),
        (A = U(`Next
          `)),
        S && S.c(),
        e(s, 'class', 'border-b pb-4'),
        e(a, 'class', 'rounded-md bg-blue-50 p-4 mt-6'),
        e(x, 'class', 'py-5'),
        e(u, 'class', 'py-5'),
        e(b, 'class', 'py-5'),
        e(v, 'class', '-my-5 divide-y divide-gray-200'),
        e(h, 'class', 'mt-6 flow-root'),
        e(y, 'type', 'button'),
        (y.disabled = l[4]),
        e(
          y,
          'class',
          (N =
            'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-50 ' +
            (l[4] ? 'opacity-80' : ''))
        ),
        e(w, 'class', 'flex justify-end border-t py-6'),
        e(t, 'class', 'space-y-6');
    },
    m(H, M) {
      j(H, t, M),
        i(t, s),
        i(t, n),
        i(t, a),
        i(t, r),
        i(t, h),
        i(h, v),
        i(v, x),
        i(v, f),
        i(v, u),
        i(v, g),
        i(v, b),
        i(v, p),
        _ && _.m(v, null),
        i(t, B),
        i(t, w),
        i(w, y),
        i(y, A),
        S && S.m(y, null),
        D || ((O = F(y, 'click', l[8])), (D = !0));
    },
    p(H, M) {
      H[4] ? S || ((S = Jl()), S.c(), S.m(y, null)) : S && (S.d(1), (S = null)),
        M[0] & 16 && (y.disabled = H[4]),
        M[0] & 16 &&
          N !==
            (N =
              'ml-3 inline-flex justify-center rounded-md border border-transparent bg-gray-800 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:ring-offset-2 disabled:opacity-50 ' +
              (H[4] ? 'opacity-80' : '')) &&
          e(y, 'class', N);
    },
    d(H) {
      H && k(t), _ && _.d(), S && S.d(), (D = !1), O();
    },
  };
}
function jl(l) {
  let t, s, n;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('circle')),
        (n = Q('path')),
        e(s, 'cx', '8'),
        e(s, 'cy', '8'),
        e(s, 'r', '7'),
        e(s, 'stroke', 'currentColor'),
        e(s, 'stroke-opacity', '0.25'),
        e(s, 'stroke-width', '2'),
        e(s, 'vector-effect', 'non-scaling-stroke'),
        e(n, 'd', 'M15 8a7.002 7.002 0 00-7-7'),
        e(n, 'stroke', 'currentColor'),
        e(n, 'stroke-width', '2'),
        e(n, 'stroke-linecap', 'round'),
        e(n, 'vector-effect', 'non-scaling-stroke'),
        e(t, 'width', '64'),
        e(t, 'height', '64'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 16 16'),
        e(t, 'class', 'animate-spin w-5 h-5 ml-2');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(t, n);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Cl(l) {
  let t,
    s = l[5]['license.username'].join(', ').replace('license.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['license.username'].join(', ').replace('license.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Ml(l) {
  let t,
    s = l[5]['license.code'].join(', ').replace('license.code', 'license key').replace('UUID', 'key') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 &&
        s !== (s = a[5]['license.code'].join(', ').replace('license.code', 'license key').replace('UUID', 'key') + '') &&
        K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Ol(l) {
  let t,
    s = l[5]['database.host'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.host'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Sl(l) {
  let t,
    s = l[5]['database.port'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.port'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Ll(l) {
  let t,
    s = l[5]['database.user'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.user'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Tl(l) {
  let t,
    s = l[5]['database.password'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.password'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Hl(l) {
  let t,
    s = l[5]['database.name'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.name'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Pl(l) {
  let t,
    s = l[5]['database.socket'].join(', ').replace('database.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['database.socket'].join(', ').replace('database.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function hs(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w = l[5] && Object.keys(l[5]).length && l[5]['mail.driver'],
    y,
    A,
    N,
    D,
    O,
    _ = w && zl(l);
  function S(P, q) {
    if (P[7].mail.driver == 'smtp') return _s;
    if (P[7].mail.driver == 'sendmail') return vs;
  }
  let H = S(l),
    M = H && H(l);
  return {
    c() {
      (t = o('li')),
        (s = o('div')),
        (n = o('h3')),
        (n.textContent = '3. Mail Server Details'),
        (a = c()),
        (r = o('div')),
        (h = o('div')),
        (v = o('div')),
        (x = o('label')),
        (x.textContent = 'Mail Driver'),
        (f = c()),
        (u = o('div')),
        (g = o('select')),
        (b = o('option')),
        (b.textContent = 'SMTP'),
        (p = o('option')),
        (p.textContent = 'SendMail'),
        (B = c()),
        _ && _.c(),
        (y = c()),
        M && M.c(),
        (A = c()),
        (N = o('div')),
        (N.innerHTML = `<div class="rounded-md bg-blue-50 p-4"><div class="flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0zM8.25 9.75A.75.75 0 019 9h.253a1.75 1.75 0 011.709 2.13l-.46 2.066a.25.25 0 00.245.304H11a.75.75 0 010 1.5h-.253a1.75 1.75 0 01-1.709-2.13l.46-2.066a.25.25 0 00-.245-.304H9a.75.75 0 01-.75-.75zM10 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg></div>
                    <div class="flex-1 md:flex md:justify-between"><p class="ml-3 text-sm text-blue-700">You can edit these settings in your <code>.env</code> file
                        later.</p></div></div></div>`),
        e(n, 'class', 'text-sm font-semibold text-gray-800'),
        e(x, 'for', 'mail-driver'),
        e(x, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        (b.__value = 'smtp'),
        (b.value = b.__value),
        (p.__value = 'sendmail'),
        (p.value = p.__value),
        e(g, 'id', 'mail-driver'),
        e(g, 'name', 'mail_driver'),
        e(
          g,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        l[7].mail.driver === void 0 && xt(() => l[21].call(g)),
        e(u, 'class', 'mt-1'),
        e(v, 'class', ''),
        e(h, 'class', 'sm:grid sm:grid-cols-2 sm:items-start sm:gap-4'),
        e(r, 'class', 'space-y-6 sm:space-y-5 pl-4 pt-2'),
        e(s, 'class', 'relative'),
        e(N, 'class', 'pl-4 mt-6'),
        e(t, 'class', 'py-5');
    },
    m(P, q) {
      j(P, t, q),
        i(t, s),
        i(s, n),
        i(s, a),
        i(s, r),
        i(r, h),
        i(h, v),
        i(v, x),
        i(v, f),
        i(v, u),
        i(u, g),
        i(g, b),
        i(g, p),
        bl(g, l[7].mail.driver, !0),
        i(v, B),
        _ && _.m(v, null),
        i(h, y),
        M && M.m(h, null),
        i(t, A),
        i(t, N),
        D || ((O = F(g, 'change', l[21])), (D = !0));
    },
    p(P, q) {
      q[0] & 128 && bl(g, P[7].mail.driver),
        q[0] & 32 && (w = P[5] && Object.keys(P[5]).length && P[5]['mail.driver']),
        w ? (_ ? _.p(P, q) : ((_ = zl(P)), _.c(), _.m(v, null))) : _ && (_.d(1), (_ = null)),
        H === (H = S(P)) && M ? M.p(P, q) : (M && M.d(1), (M = H && H(P)), M && (M.c(), M.m(h, null)));
    },
    d(P) {
      P && k(t), _ && _.d(), M && M.d(), (D = !1), O();
    },
  };
}
function zl(l) {
  let t,
    s = l[5]['mail.driver'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.driver'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function vs(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v = l[5] && Object.keys(l[5]).length && l[5]['mail.path'],
    x,
    f,
    u = v && Al(l);
  return {
    c() {
      (t = o('div')),
        (s = o('label')),
        (s.textContent = 'Path'),
        (n = c()),
        (a = o('div')),
        (r = o('input')),
        (h = c()),
        u && u.c(),
        e(s, 'for', 'mail-path'),
        e(s, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(r, 'type', 'text'),
        e(r, 'id', 'mail-path'),
        e(r, 'name', 'mail_path'),
        e(
          r,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(a, 'class', 'mt-1'),
        e(t, 'class', '');
    },
    m(g, b) {
      j(g, t, b),
        i(t, s),
        i(t, n),
        i(t, a),
        i(a, r),
        T(r, l[7].mail.path),
        i(t, h),
        u && u.m(t, null),
        x || ((f = F(r, 'input', l[26])), (x = !0));
    },
    p(g, b) {
      b[0] & 128 && r.value !== g[7].mail.path && T(r, g[7].mail.path),
        b[0] & 32 && (v = g[5] && Object.keys(g[5]).length && g[5]['mail.path']),
        v ? (u ? u.p(g, b) : ((u = Al(g)), u.c(), u.m(t, null))) : u && (u.d(1), (u = null));
    },
    d(g) {
      g && k(t), u && u.d(), (x = !1), f();
    },
  };
}
function _s(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v = l[5] && Object.keys(l[5]).length && l[5]['mail.host'],
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w = l[5] && Object.keys(l[5]).length && l[5]['mail.port'],
    y,
    A,
    N,
    D,
    O,
    _,
    S,
    H = l[5] && Object.keys(l[5]).length && l[5]['mail.username'],
    M,
    P,
    q,
    xe,
    Z,
    W,
    ye,
    ve = l[5] && Object.keys(l[5]).length && l[5]['mail.password'],
    te,
    V,
    I = v && Bl(l),
    Y = w && El(l),
    R = H && Nl(l),
    E = ve && Dl(l);
  return {
    c() {
      (t = o('div')),
        (s = o('label')),
        (s.textContent = 'Host'),
        (n = c()),
        (a = o('div')),
        (r = o('input')),
        (h = c()),
        I && I.c(),
        (x = c()),
        (f = o('div')),
        (u = o('label')),
        (u.textContent = 'Port'),
        (g = c()),
        (b = o('div')),
        (p = o('input')),
        (B = c()),
        Y && Y.c(),
        (y = c()),
        (A = o('div')),
        (N = o('label')),
        (N.textContent = 'Username'),
        (D = c()),
        (O = o('div')),
        (_ = o('input')),
        (S = c()),
        R && R.c(),
        (M = c()),
        (P = o('div')),
        (q = o('label')),
        (q.textContent = 'Password'),
        (xe = c()),
        (Z = o('div')),
        (W = o('input')),
        (ye = c()),
        E && E.c(),
        e(s, 'for', 'mail-host'),
        e(s, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(r, 'type', 'text'),
        e(r, 'id', 'mail-host'),
        e(r, 'name', 'mail_host'),
        e(
          r,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(a, 'class', 'mt-1'),
        e(t, 'class', ''),
        e(u, 'for', 'mail-port'),
        e(u, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(p, 'type', 'text'),
        e(p, 'id', 'mail-port'),
        e(p, 'name', 'mail_port'),
        e(
          p,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(b, 'class', 'mt-1'),
        e(f, 'class', ''),
        e(N, 'for', 'mail-username'),
        e(N, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(_, 'type', 'text'),
        e(_, 'id', 'mail-username'),
        e(_, 'name', 'mail_username'),
        e(
          _,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(O, 'class', 'mt-1'),
        e(A, 'class', ''),
        e(q, 'for', 'mail-password'),
        e(q, 'class', 'block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2'),
        e(W, 'type', 'password'),
        e(W, 'id', 'mail-password'),
        e(W, 'name', 'mail_password'),
        e(
          W,
          'class',
          'block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:max-w-xs sm:text-sm'
        ),
        e(Z, 'class', 'mt-1'),
        e(P, 'class', '');
    },
    m(m, z) {
      j(m, t, z),
        i(t, s),
        i(t, n),
        i(t, a),
        i(a, r),
        T(r, l[7].mail.host),
        i(t, h),
        I && I.m(t, null),
        j(m, x, z),
        j(m, f, z),
        i(f, u),
        i(f, g),
        i(f, b),
        i(b, p),
        T(p, l[7].mail.port),
        i(f, B),
        Y && Y.m(f, null),
        j(m, y, z),
        j(m, A, z),
        i(A, N),
        i(A, D),
        i(A, O),
        i(O, _),
        T(_, l[7].mail.username),
        i(A, S),
        R && R.m(A, null),
        j(m, M, z),
        j(m, P, z),
        i(P, q),
        i(P, xe),
        i(P, Z),
        i(Z, W),
        T(W, l[7].mail.password),
        i(P, ye),
        E && E.m(P, null),
        te || ((V = [F(r, 'input', l[22]), F(p, 'input', l[23]), F(_, 'input', l[24]), F(W, 'input', l[25])]), (te = !0));
    },
    p(m, z) {
      z[0] & 128 && r.value !== m[7].mail.host && T(r, m[7].mail.host),
        z[0] & 32 && (v = m[5] && Object.keys(m[5]).length && m[5]['mail.host']),
        v ? (I ? I.p(m, z) : ((I = Bl(m)), I.c(), I.m(t, null))) : I && (I.d(1), (I = null)),
        z[0] & 128 && p.value !== m[7].mail.port && T(p, m[7].mail.port),
        z[0] & 32 && (w = m[5] && Object.keys(m[5]).length && m[5]['mail.port']),
        w ? (Y ? Y.p(m, z) : ((Y = El(m)), Y.c(), Y.m(f, null))) : Y && (Y.d(1), (Y = null)),
        z[0] & 128 && _.value !== m[7].mail.username && T(_, m[7].mail.username),
        z[0] & 32 && (H = m[5] && Object.keys(m[5]).length && m[5]['mail.username']),
        H ? (R ? R.p(m, z) : ((R = Nl(m)), R.c(), R.m(A, null))) : R && (R.d(1), (R = null)),
        z[0] & 128 && W.value !== m[7].mail.password && T(W, m[7].mail.password),
        z[0] & 32 && (ve = m[5] && Object.keys(m[5]).length && m[5]['mail.password']),
        ve ? (E ? E.p(m, z) : ((E = Dl(m)), E.c(), E.m(P, null))) : E && (E.d(1), (E = null));
    },
    d(m) {
      m && k(t),
        I && I.d(),
        m && k(x),
        m && k(f),
        Y && Y.d(),
        m && k(y),
        m && k(A),
        R && R.d(),
        m && k(M),
        m && k(P),
        E && E.d(),
        (te = !1),
        Fe(V);
    },
  };
}
function Al(l) {
  let t,
    s = l[5]['mail.path'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.path'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Bl(l) {
  let t,
    s = l[5]['mail.host'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.host'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function El(l) {
  let t,
    s = l[5]['mail.port'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.port'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Nl(l) {
  let t,
    s = l[5]['mail.username'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.username'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Dl(l) {
  let t,
    s = l[5]['mail.password'].join(', ').replace('mail.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['mail.password'].join(', ').replace('mail.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Il(l) {
  let t,
    s = l[5]['account.name'].join(', ').replace('account.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['account.name'].join(', ').replace('account.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Ul(l) {
  let t,
    s = l[5]['account.username'].join(', ').replace('account.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['account.username'].join(', ').replace('account.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Vl(l) {
  let t,
    s = l[5]['account.email'].join(', ').replace('account.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['account.email'].join(', ').replace('account.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function ql(l) {
  let t,
    s = l[5]['account.password'].join(', ').replace('account.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['account.password'].join(', ').replace('account.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Fl(l) {
  let t,
    s = l[5]['account.password_confirmation'].join(', ').replace('account.', '') + '',
    n;
  return {
    c() {
      (t = o('div')), (n = U(s)), e(t, 'class', 'mt-1 text-red-500 text-sm');
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 32 && s !== (s = a[5]['account.password_confirmation'].join(', ').replace('account.', '') + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Rl(l) {
  let t, s, n;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('circle')),
        (n = Q('path')),
        e(s, 'cx', '8'),
        e(s, 'cy', '8'),
        e(s, 'r', '7'),
        e(s, 'stroke', 'currentColor'),
        e(s, 'stroke-opacity', '0.25'),
        e(s, 'stroke-width', '2'),
        e(s, 'vector-effect', 'non-scaling-stroke'),
        e(n, 'd', 'M15 8a7.002 7.002 0 00-7-7'),
        e(n, 'stroke', 'currentColor'),
        e(n, 'stroke-width', '2'),
        e(n, 'stroke-linecap', 'round'),
        e(n, 'vector-effect', 'non-scaling-stroke'),
        e(t, 'width', '64'),
        e(t, 'height', '64'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 16 16'),
        e(t, 'class', 'animate-spin w-5 h-5 ml-2');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(t, n);
    },
    d(a) {
      a && k(t);
    },
  };
}
function ws(l) {
  let t;
  return {
    c() {
      (t = o('div')),
        (t.innerHTML = `<div class="flex"><div class="flex-shrink-0"><svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg></div>
              <div class="ml-3"><h3 class="text-sm font-medium text-green-800">Success</h3>
                <div class="mt-2 text-sm text-green-700"><p>Your server php version and extensions are fine. Please
                    proceed to settings.</p></div></div></div>`),
        e(t, 'class', 'rounded-md bg-green-50 p-4');
    },
    m(s, n) {
      j(s, t, n);
    },
    p: Ze,
    d(s) {
      s && k(t);
    },
  };
}
function ys(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g = l[6],
    b = [];
  for (let p = 0; p < g.length; p += 1) b[p] = Wl(_l(l, g, p));
  return {
    c() {
      (t = o('div')),
        (s = o('div')),
        (n = o('div')),
        (n.innerHTML =
          '<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"></path></svg>'),
        (a = c()),
        (r = o('div')),
        (h = o('h3')),
        (v = U(l[1])),
        (x = c()),
        (f = o('div')),
        (u = o('ul'));
      for (let p = 0; p < b.length; p += 1) b[p].c();
      e(n, 'class', 'flex-shrink-0'),
        e(h, 'class', 'text-sm font-medium text-red-800'),
        e(u, 'class', 'list-disc space-y-1 pl-5'),
        e(f, 'class', 'mt-2 text-sm text-red-700'),
        e(r, 'class', 'ml-3'),
        e(s, 'class', 'flex'),
        e(t, 'class', 'rounded-md bg-red-50 p-4');
    },
    m(p, B) {
      j(p, t, B), i(t, s), i(s, n), i(s, a), i(s, r), i(r, h), i(h, v), i(r, x), i(r, f), i(f, u);
      for (let w = 0; w < b.length; w += 1) b[w] && b[w].m(u, null);
    },
    p(p, B) {
      if ((B[0] & 2 && K(v, p[1]), B[0] & 64)) {
        g = p[6];
        let w;
        for (w = 0; w < g.length; w += 1) {
          const y = _l(p, g, w);
          b[w] ? b[w].p(y, B) : ((b[w] = Wl(y)), b[w].c(), b[w].m(u, null));
        }
        for (; w < b.length; w += 1) b[w].d(1);
        b.length = g.length;
      }
    },
    d(p) {
      p && k(t), $l(b, p);
    },
  };
}
function Wl(l) {
  let t,
    s = l[36] + '',
    n;
  return {
    c() {
      (t = o('li')), (n = U(s));
    },
    m(a, r) {
      j(a, t, r), i(t, n);
    },
    p(a, r) {
      r[0] & 64 && s !== (s = a[36] + '') && K(n, s);
    },
    d(a) {
      a && k(t);
    },
  };
}
function Yl(l) {
  let t, s, n;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('circle')),
        (n = Q('path')),
        e(s, 'cx', '8'),
        e(s, 'cy', '8'),
        e(s, 'r', '7'),
        e(s, 'stroke', 'currentColor'),
        e(s, 'stroke-opacity', '0.25'),
        e(s, 'stroke-width', '2'),
        e(s, 'vector-effect', 'non-scaling-stroke'),
        e(n, 'd', 'M15 8a7.002 7.002 0 00-7-7'),
        e(n, 'stroke', 'currentColor'),
        e(n, 'stroke-width', '2'),
        e(n, 'stroke-linecap', 'round'),
        e(n, 'vector-effect', 'non-scaling-stroke'),
        e(t, 'width', '64'),
        e(t, 'height', '64'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 16 16'),
        e(t, 'class', 'animate-spin w-5 h-5 ml-2');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(t, n);
    },
    d(a) {
      a && k(t);
    },
  };
}
function ks(l) {
  let t;
  return {
    c() {
      (t = o('li')),
        (t.innerHTML = `<div class="relative"><h3 class="text-sm font-semibold text-gray-800">4. Mail Server Details</h3>
                <div class="mt-1 pl-4 text-sm text-gray-600">We will need your mail server details, the driver options are
                  <ol class="pl-6"><li>SMTP: <strong>host</strong>, <strong>port</strong>,
                      <strong>user</strong>, <strong>password</strong> and
                      <strong>encryption</strong></li>
                    <li>SendMail: <strong>path</strong></li></ol>
                  <p class="mt-2">This is required so that system can send emails.</p></div></div>`),
        e(t, 'class', 'py-5');
    },
    m(s, n) {
      j(s, t, n);
    },
    d(s) {
      s && k(t);
    },
  };
}
function Jl(l) {
  let t, s, n;
  return {
    c() {
      (t = Q('svg')),
        (s = Q('circle')),
        (n = Q('path')),
        e(s, 'cx', '8'),
        e(s, 'cy', '8'),
        e(s, 'r', '7'),
        e(s, 'stroke', 'currentColor'),
        e(s, 'stroke-opacity', '0.25'),
        e(s, 'stroke-width', '2'),
        e(s, 'vector-effect', 'non-scaling-stroke'),
        e(n, 'd', 'M15 8a7.002 7.002 0 00-7-7'),
        e(n, 'stroke', 'currentColor'),
        e(n, 'stroke-width', '2'),
        e(n, 'stroke-linecap', 'round'),
        e(n, 'vector-effect', 'non-scaling-stroke'),
        e(t, 'width', '64'),
        e(t, 'height', '64'),
        e(t, 'fill', 'none'),
        e(t, 'viewBox', '0 0 16 16'),
        e(t, 'class', 'animate-spin w-5 h-5 ml-2');
    },
    m(a, r) {
      j(a, t, r), i(t, s), i(t, n);
    },
    d(a) {
      a && k(t);
    },
  };
}
function xs(l) {
  let t,
    s,
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w,
    y,
    A,
    N,
    D,
    O,
    _,
    S,
    H,
    M,
    P,
    q,
    xe,
    Z,
    W,
    ye,
    ve,
    te,
    V,
    I,
    Y,
    R,
    E,
    m,
    z,
    se,
    We,
    _e,
    Ae,
    $e,
    $ = l[0] > 2 && wl(),
    J = l[0] > 3 && yl(),
    le = l[3] && kl(l),
    ee = l[1] && xl(l);
  function et(L, X) {
    if (L[0] == 1) return bs;
    if (L[0] == 2) return gs;
    if (L[0] == 3) return ps;
    if (L[0] == 4) return ms;
  }
  let ie = et(l),
    G = ie && ie(l);
  return {
    c() {
      (t = c()),
        (s = o('nav')),
        (s.innerHTML = `<div class="mx-auto max-w-4xl px-2 sm:px-4 lg:px-8"><div class="flex h-16 justify-between"><div class="flex items-center px-2 lg:px-0"><div class="flex flex-shrink-0 items-center"><h2 class="font-bold text-2xl uppercase text-gray-200">Installation</h2></div></div>

      <div class="ml-4 flex items-center"><div class="ml-8 flex space-x-4"><a target="_blank" href="https://tecdiary.net/support" class="group transition-all flex items-center rounded-md py-2 px-3 text-sm font-medium text-white hover:bg-gray-700">Support
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-300 ml-2 transition-all hidden group-hover:block"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></a></div></div></div></div>`),
        (n = c()),
        (a = o('nav')),
        (r = o('div')),
        (h = o('ol')),
        (v = o('li')),
        (x = o('div')),
        (f = o('a')),
        (f.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>

            <span class="sr-only">Start</span>`),
        (u = c()),
        (g = o('li')),
        (b = o('div')),
        (p = Q('svg')),
        (B = Q('path')),
        (w = c()),
        (y = o('div')),
        $ && $.c(),
        (A = c()),
        (N = o('span')),
        (N.textContent = 'Server'),
        (O = c()),
        (_ = o('li')),
        (S = o('div')),
        (H = Q('svg')),
        (M = Q('path')),
        (P = c()),
        (q = o('div')),
        J && J.c(),
        (xe = c()),
        (Z = o('span')),
        (Z.textContent = 'Settings'),
        (ye = c()),
        (ve = o('li')),
        (te = o('div')),
        (V = Q('svg')),
        (I = Q('path')),
        (Y = c()),
        (R = o('span')),
        (E = U('Finalize')),
        (z = c()),
        (se = o('main')),
        le && le.c(),
        (We = c()),
        ee && ee.c(),
        (_e = c()),
        G && G.c(),
        (document.title = 'App Installer by Tecdiary'),
        e(s, 'class', 'bg-gray-900'),
        e(f, 'href', '#/'),
        e(f, 'class', 'text-gray-300 hover:text-gray-100'),
        e(x, 'class', 'flex items-center'),
        e(v, 'class', 'flex'),
        e(B, 'd', 'M.293 0l22 22-22 22h1.414l22-22-22-22H.293z'),
        e(p, 'class', 'h-full w-6 flex-shrink-0 text-gray-600'),
        e(p, 'preserveAspectRatio', 'none'),
        e(p, 'viewBox', '0 0 24 44'),
        e(p, 'fill', 'currentColor'),
        e(p, 'xmlns', 'http://www.w3.org/2000/svg'),
        e(p, 'aria-hidden', 'true'),
        e(N, 'class', 'cursor-default text-sm font-medium'),
        e(y, 'class', (D = 'flex items-center ml-4 gap-2 ' + (l[0] == 2 ? 'text-gray-300' : l[0] > 2 ? 'text-gray-400' : 'text-gray-500'))),
        e(b, 'class', 'flex items-center'),
        e(g, 'class', 'flex'),
        e(M, 'd', 'M.293 0l22 22-22 22h1.414l22-22-22-22H.293z'),
        e(H, 'class', 'h-full w-6 flex-shrink-0 text-gray-600'),
        e(H, 'preserveAspectRatio', 'none'),
        e(H, 'viewBox', '0 0 24 44'),
        e(H, 'fill', 'currentColor'),
        e(H, 'xmlns', 'http://www.w3.org/2000/svg'),
        e(H, 'aria-hidden', 'true'),
        e(Z, 'class', 'cursor-default text-sm font-medium'),
        e(q, 'class', (W = 'flex items-center ml-4 gap-2 ' + (l[0] == 3 ? 'text-gray-300' : l[0] > 3 ? 'text-gray-400' : 'text-gray-500'))),
        e(S, 'class', 'flex items-center'),
        e(_, 'class', 'flex'),
        e(I, 'd', 'M.293 0l22 22-22 22h1.414l22-22-22-22H.293z'),
        e(V, 'class', 'h-full w-6 flex-shrink-0 text-gray-600'),
        e(V, 'preserveAspectRatio', 'none'),
        e(V, 'viewBox', '0 0 24 44'),
        e(V, 'fill', 'currentColor'),
        e(V, 'xmlns', 'http://www.w3.org/2000/svg'),
        e(V, 'aria-hidden', 'true'),
        e(R, 'class', (m = 'cursor-default ml-4 text-sm font-medium ' + (l[0] == 4 ? 'text-gray-300' : 'text-gray-500'))),
        e(R, 'aria-current', 'page'),
        e(te, 'class', 'flex items-center'),
        e(ve, 'class', 'flex'),
        e(h, 'class', 'mx-auto inline-flex w-full max-w-4xl space-x-4 px-4 sm:px-6 lg:px-8'),
        e(r, 'class', 'flex justify-center mx-auto'),
        e(a, 'class', 'border-b border-gray-700 bg-gray-800 flex'),
        e(se, 'class', 'mx-auto max-w-2xl px-4 pt-6 pb-6 lg:pb-8');
    },
    m(L, X) {
      j(L, t, X),
        j(L, s, X),
        j(L, n, X),
        j(L, a, X),
        i(a, r),
        i(r, h),
        i(h, v),
        i(v, x),
        i(x, f),
        i(h, u),
        i(h, g),
        i(g, b),
        i(b, p),
        i(p, B),
        i(b, w),
        i(b, y),
        $ && $.m(y, null),
        i(y, A),
        i(y, N),
        i(h, O),
        i(h, _),
        i(_, S),
        i(S, H),
        i(H, M),
        i(S, P),
        i(S, q),
        J && J.m(q, null),
        i(q, xe),
        i(q, Z),
        i(h, ye),
        i(h, ve),
        i(ve, te),
        i(te, V),
        i(V, I),
        i(te, Y),
        i(te, R),
        i(R, E),
        j(L, z, X),
        j(L, se, X),
        le && le.m(se, null),
        i(se, We),
        ee && ee.m(se, null),
        i(se, _e),
        G && G.m(se, null),
        Ae || (($e = F(f, 'click', l[11])), (Ae = !0));
    },
    p(L, X) {
      L[0] > 2 ? $ || (($ = wl()), $.c(), $.m(y, A)) : $ && ($.d(1), ($ = null)),
        X[0] & 1 &&
          D !== (D = 'flex items-center ml-4 gap-2 ' + (L[0] == 2 ? 'text-gray-300' : L[0] > 2 ? 'text-gray-400' : 'text-gray-500')) &&
          e(y, 'class', D),
        L[0] > 3 ? J || ((J = yl()), J.c(), J.m(q, xe)) : J && (J.d(1), (J = null)),
        X[0] & 1 &&
          W !== (W = 'flex items-center ml-4 gap-2 ' + (L[0] == 3 ? 'text-gray-300' : L[0] > 3 ? 'text-gray-400' : 'text-gray-500')) &&
          e(q, 'class', W),
        X[0] & 1 &&
          m !== (m = 'cursor-default ml-4 text-sm font-medium ' + (L[0] == 4 ? 'text-gray-300' : 'text-gray-500')) &&
          e(R, 'class', m),
        L[3] ? (le ? le.p(L, X) : ((le = kl(L)), le.c(), le.m(se, We))) : le && (le.d(1), (le = null)),
        L[1] ? (ee ? ee.p(L, X) : ((ee = xl(L)), ee.c(), ee.m(se, _e))) : ee && (ee.d(1), (ee = null)),
        ie === (ie = et(L)) && G ? G.p(L, X) : (G && G.d(1), (G = ie && ie(L)), G && (G.c(), G.m(se, null)));
    },
    i: Ze,
    o: Ze,
    d(L) {
      L && k(t),
        L && k(s),
        L && k(n),
        L && k(a),
        $ && $.d(),
        J && J.d(),
        L && k(z),
        L && k(se),
        le && le.d(),
        ee && ee.d(),
        G && G.d(),
        (Ae = !1),
        $e();
    },
  };
}
function js(l, t, s) {
  let n = 1,
    a = null,
    r = !1,
    h = null,
    v = !1,
    x = null,
    f = null,
    u = {
      license: { username: null, code: null },
      account: { name: null, email: null, password: null, password_confirmation: null },
      database: { host: '127.0.0.1', port: 3306, user: null, password: null, socket: null },
      mail: { driver: 'smtp', host: null, port: null, username: null, password: null, path: null },
    };
  async function g() {
    s(4, (v = !0));
    let E = await fetch('/install/check', { method: 'POST', headers: { Accept: 'application/json', 'Content-Type': 'application/json' } });
    setTimeout(() => s(4, (v = !1)), 100);
    let m = await E.json();
    E.ok
      ? m.success
        ? (s(1, (a = null)), s(6, (f = null)), s(0, (n = 3)))
        : (s(1, (a = m.message)), s(6, (f = m.errors)), s(0, (n = 2)))
      : (s(6, (f = m.errors)), console.log(E, m));
  }
  async function b() {
    s(4, (v = !0));
    let E = JSON.stringify(u),
      m = await fetch('/install/save', {
        body: E,
        method: 'POST',
        headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
      });
    setTimeout(() => s(4, (v = !1)), 100);
    let z = await m.json();
    m.ok
      ? z.success
        ? (s(1, (a = null)), s(5, (x = null)), s(0, (n = 4)))
        : (s(1, (a = z.message)), s(5, (x = z.errors)))
      : (s(1, (a = z.message)), s(5, (x = z.errors)), window.scrollTo(0, 0), console.log(m, z));
  }
  async function p() {
    s(2, (r = !0));
    let E = await fetch('/install/finalize', {
      method: 'POST',
      body: JSON.stringify({ done: 'yes' }),
      headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
    });
    setTimeout(() => s(2, (r = !1)), 1500);
    let m = await E.json();
    E.ok
      ? m.success
        ? (s(1, (a = null)), s(5, (x = null)), (window.location.href = window.location.origin), setTimeout(window.location.reload, 300))
        : (s(1, (a = m.message)), s(5, (x = m.errors)))
      : (s(1, (a = m.message)), s(5, (x = m.errors)), console.log(E, m));
  }
  const B = () => s(0, (n = 1)),
    w = () => s(0, (n = 1));
  function y() {
    (u.license.username = this.value), s(7, u);
  }
  function A() {
    (u.license.code = this.value), s(7, u);
  }
  function N() {
    (u.database.host = this.value), s(7, u);
  }
  function D() {
    (u.database.port = this.value), s(7, u);
  }
  function O() {
    (u.database.user = this.value), s(7, u);
  }
  function __() {
    (u.database.password = this.value), s(7, u);
  }
  function S() {
    (u.database.name = this.value), s(7, u);
  }
  function H() {
    (u.database.socket = this.value), s(7, u);
  }
  function M() {
    (u.mail.driver = ts(this)), s(7, u);
  }
  function P() {
    (u.mail.host = this.value), s(7, u);
  }
  function q() {
    (u.mail.port = this.value), s(7, u);
  }
  function xe() {
    (u.mail.username = this.value), s(7, u);
  }
  function Z() {
    (u.mail.password = this.value), s(7, u);
  }
  function W() {
    (u.mail.path = this.value), s(7, u);
  }
  function ye() {
    (u.account.name = this.value), s(7, u);
  }
  function ve() {
    (u.account.username = this.value), s(7, u);
  }
  function te() {
    (u.account.email = this.value), s(7, u);
  }
  function V() {
    (u.account.password = this.value), s(7, u);
  }
  function I() {
    (u.account.password_confirmation = this.value), s(7, u);
  }
  return [
    n,
    a,
    r,
    h,
    v,
    x,
    f,
    u,
    g,
    b,
    p,
    B,
    w,
    y,
    A,
    N,
    D,
    O,
    _,
    S,
    H,
    M,
    P,
    q,
    xe,
    Z,
    W,
    ye,
    ve,
    te,
    V,
    I,
    () => s(0, (n = 1)),
    () => s(0, (n = 1)),
  ];
}
class Cs extends fs {
  constructor(t) {
    super(), cs(this, t, js, xs, Xl, {}, null, [-1, -1]);
  }
}
new Cs({ target: document.getElementById('app') });
