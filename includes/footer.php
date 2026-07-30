<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — Umumiy FOOTER + global JS
 * =====================================================================
 */
$S = get_settings();
?>
<!-- ======================= FOOTER ======================= -->
<footer class="footer">
    <style>
    .footer{background:var(--navy-900);color:rgba(255,255,255,.75);padding:72px 0 28px;position:relative;overflow:hidden}
    .footer::before{content:"";position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent,var(--gold-500),transparent)}
    .footer-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1.3fr;gap:40px;margin-bottom:48px}
    .footer h4{color:#fff;font-size:18px;margin-bottom:20px}
    .footer .logo{margin-bottom:18px}
    .footer p{font-size:14.5px;line-height:1.7}
    .footer-links a{display:block;padding:7px 0;font-size:14.5px;transition:color .25s,padding-left .25s}
    .footer-links a:hover{color:var(--gold-400);padding-left:6px}
    .footer-contact li{display:flex;gap:12px;margin-bottom:14px;font-size:14.5px;align-items:flex-start}
    .footer-contact svg{flex:0 0 18px;margin-top:3px;color:var(--gold-500)}
    .socials{display:flex;gap:12px;margin-top:20px}
    .socials a{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:rgba(255,255,255,.08);transition:.3s}
    .socials a:hover{background:var(--gold-500);color:var(--navy-900);transform:translateY(-4px)}
    .footer-bottom{border-top:1px solid rgba(255,255,255,.1);padding-top:24px;display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;font-size:13.5px;color:rgba(255,255,255,.55)}
    @media (max-width:900px){.footer-grid{grid-template-columns:1fr 1fr;gap:32px}}
    @media (max-width:560px){.footer-grid{grid-template-columns:1fr}.footer-bottom{flex-direction:column;text-align:center}}
    </style>
    <div class="container">
        <div class="footer-grid">
            <div>
                <a href="index.php" class="logo">
                    <span class="logo-mark">C</span>
                    <span class="logo-txt"><b>Chimyon School</b><span>Xususiy maktab</span></span>
                </a>
                <p>Farzandingiz kelajagi uchun zamonaviy, sifatli va nufuzli ta'lim maskani. Bilim, tarbiya va muvaffaqiyat bir joyda.</p>
                <div class="socials">
                    <a href="<?= e($S['telegram'] ?? '#') ?>" aria-label="Telegram" target="_blank" rel="noopener">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/></svg>
                    </a>
                    <a href="<?= e($S['instagram'] ?? '#') ?>" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                    </a>
                </div>
            </div>
            <div>
                <h4>Sahifalar</h4>
                <div class="footer-links">
                    <a href="about.php">Maktab haqida</a>
                    <a href="education.php">Ta'lim dasturi</a>
                    <a href="teachers.php">O'qituvchilar</a>
                    <a href="gallery.php">Infratuzilma</a>
                </div>
            </div>
            <div>
                <h4>Havolalar</h4>
                <div class="footer-links">
                    <a href="pricing.php">Narxlar</a>
                    <a href="news.php">Yangiliklar</a>
                    <a href="admission.php">Qabul / Ariza</a>
                    <a href="contact.php">Aloqa</a>
                </div>
            </div>
            <div>
                <h4>Bog'lanish</h4>
                <ul class="footer-contact">
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg><span><?= e($S['manzil'] ?? '') ?></span></li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.13.96.36 1.9.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0122 16.92z"/></svg><a href="tel:<?= e(str_replace(' ', '', $S['telefon'] ?? '')) ?>"><?= e($S['telefon'] ?? '') ?></a></li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 6L2 7"/></svg><a href="mailto:<?= e($S['email'] ?? '') ?>"><?= e($S['email'] ?? '') ?></a></li>
                    <li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><span><?= e($S['ish_vaqti'] ?? '') ?></span></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; <?= date('Y') ?> Chimyon School. Barcha huquqlar himoyalangan.</span>
            <span>Zamonaviy ta'lim &mdash; ishonchli kelajak.</span>
        </div>
    </div>
</footer>

<!-- ======================= GLOBAL JS ======================= -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
(function(){
    'use strict';

    // ---- AOS init (scroll-reveal) ----
    if (window.AOS) AOS.init({ duration:800, easing:'ease-out-cubic', once:true, offset:80 });

    // ---- Navigatsiya scroll effekti ----
    var nav = document.getElementById('mainNav');
    function onScroll(){
        if (window.scrollY > 40) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    }
    window.addEventListener('scroll', onScroll, { passive:true });
    onScroll();

    // ---- Mobil menyu ----
    var burger = document.getElementById('burger');
    var mobileMenu = document.getElementById('mobileMenu');
    var overlay = document.getElementById('overlay');
    function toggleMenu(open){
        burger.classList.toggle('open', open);
        mobileMenu.classList.toggle('open', open);
        overlay.classList.toggle('open', open);
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        mobileMenu.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.style.overflow = open ? 'hidden' : '';
    }
    burger.addEventListener('click', function(){ toggleMenu(!mobileMenu.classList.contains('open')); });
    overlay.addEventListener('click', function(){ toggleMenu(false); });
    mobileMenu.querySelectorAll('a').forEach(function(a){ a.addEventListener('click', function(){ toggleMenu(false); }); });

    // ---- Tugmalarda ripple effekt ----
    document.querySelectorAll('.btn').forEach(function(btn){
        btn.addEventListener('click', function(e){
            var r = document.createElement('span');
            r.className = 'ripple';
            var rect = btn.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            r.style.width = r.style.height = size + 'px';
            r.style.left = (e.clientX - rect.left - size/2) + 'px';
            r.style.top = (e.clientY - rect.top - size/2) + 'px';
            btn.appendChild(r);
            setTimeout(function(){ r.remove(); }, 600);
        });
    });

    // ---- Counter animatsiya (statistika raqamlari) ----
    var counters = document.querySelectorAll('[data-count]');
    if (counters.length){
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if (!entry.isIntersecting) return;
                var el = entry.target;
                var target = parseFloat(el.getAttribute('data-count'));
                var suffix = el.getAttribute('data-suffix') || '';
                var dur = 1800, start = null;
                function step(ts){
                    if (!start) start = ts;
                    var p = Math.min((ts - start) / dur, 1);
                    var eased = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.floor(eased * target).toLocaleString('ru-RU') + suffix;
                    if (p < 1) requestAnimationFrame(step);
                    else el.textContent = target.toLocaleString('ru-RU') + suffix;
                }
                requestAnimationFrame(step);
                io.unobserve(el);
            });
        }, { threshold:.5 });
        counters.forEach(function(c){ io.observe(c); });
    }
})();
</script>
</body>
</html>
