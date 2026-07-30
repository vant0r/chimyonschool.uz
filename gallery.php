<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — INFRATUZILMA / GALEREYA (gallery.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

try {
    $items = db()->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
    $cats  = db()->query("SELECT DISTINCT kategoriya FROM gallery ORDER BY kategoriya ASC")->fetchAll(PDO::FETCH_COLUMN);
} catch (Throwable $ex) {
    $items = $cats = [];
}

$page_title = 'Infratuzilma';
$page_desc  = 'Chimyon School zamonaviy sinflari, laboratoriyalari, sport va dam olish maskanlari galereyasi.';
$active     = 'gallery';
require __DIR__ . '/includes/header.php';
?>
<style>
.filters{display:flex;justify-content:center;flex-wrap:wrap;gap:10px;margin-bottom:44px}
.filters button{background:#fff;border:1.5px solid var(--gray-300);color:var(--navy-700);font-size:14px;font-weight:600;padding:10px 20px;border-radius:50px;cursor:pointer;transition:.3s;text-transform:capitalize}
.filters button:hover{border-color:var(--navy-800)}
.filters button.active{background:var(--navy-800);color:#fff;border-color:var(--navy-800)}
.masonry{columns:3;column-gap:20px}
.m-item{break-inside:avoid;margin-bottom:20px;position:relative;border-radius:14px;overflow:hidden;cursor:pointer;box-shadow:var(--shadow-sm)}
.m-item img{width:100%;display:block;transition:transform .6s}
.m-item::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(6,21,48,.6),transparent 55%);opacity:0;transition:.4s}
.m-item:hover img{transform:scale(1.07)}
.m-item:hover::after{opacity:1}
.m-cap{position:absolute;left:16px;bottom:14px;color:#fff;font-weight:600;z-index:2;opacity:0;transform:translateY(10px);transition:.4s;text-transform:capitalize}
.m-item:hover .m-cap{opacity:1;transform:translateY(0)}
/* Lightbox */
.lb{position:fixed;inset:0;background:rgba(6,12,26,.94);z-index:2000;display:none;align-items:center;justify-content:center;padding:24px}
.lb.open{display:flex}
.lb img{max-width:92vw;max-height:86vh;border-radius:12px;box-shadow:0 30px 80px rgba(0,0,0,.6)}
.lb .close{position:absolute;top:22px;right:26px;background:none;border:none;color:#fff;font-size:40px;cursor:pointer;line-height:1}
.lb .nav{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.1);border:none;color:#fff;width:54px;height:54px;border-radius:50%;font-size:26px;cursor:pointer;transition:.3s}
.lb .nav:hover{background:var(--gold-500);color:var(--navy-900)}
.lb .prev{left:24px}.lb .next{right:24px}
@media (max-width:900px){.masonry{columns:2}}
@media (max-width:560px){.masonry{columns:1}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Zamonaviy o'quv muhiti</h1>
        <p data-aos="fade-up" data-aos-delay="100">Farzandingiz kun bo'yi vaqt o'tkazadigan xavfsiz, qulay va zamonaviy makonlar.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Infratuzilma</div>
    </div>
</header>

<section class="section">
    <div class="container">
        <?php if ($items): ?>
            <div class="filters" data-aos="fade-up">
                <button class="active" data-filter="all">Barchasi</button>
                <?php foreach ($cats as $c): ?>
                    <button data-filter="<?= e($c) ?>"><?= e($c) ?></button>
                <?php endforeach; ?>
            </div>
            <div class="masonry" id="masonry">
                <?php foreach ($items as $i => $g): $url = upload_url($g['rasm']); ?>
                    <div class="m-item" data-cat="<?= e($g['kategoriya']) ?>" data-src="<?= e($url) ?>" data-aos="fade-up" data-aos-delay="<?= ($i%3)*70 ?>">
                        <img src="<?= e($url) ?>" alt="Chimyon School — <?= e($g['kategoriya']) ?>" loading="lazy">
                        <span class="m-cap"><?= e($g['kategoriya']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="center section-sub">Galereya rasmlari tez orada qo'shiladi.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Lightbox -->
<div class="lb" id="lightbox" aria-hidden="true">
    <button class="close" id="lbClose" aria-label="Yopish">&times;</button>
    <button class="nav prev" id="lbPrev" aria-label="Oldingi">&#8249;</button>
    <img src="" alt="Katta rasm" id="lbImg">
    <button class="nav next" id="lbNext" aria-label="Keyingi">&#8250;</button>
</div>

<script>
(function(){
    // Filtrlash
    var btns = document.querySelectorAll('.filters button');
    var items = Array.prototype.slice.call(document.querySelectorAll('.m-item'));
    btns.forEach(function(b){
        b.addEventListener('click', function(){
            btns.forEach(function(x){ x.classList.remove('active'); });
            b.classList.add('active');
            var f = b.getAttribute('data-filter');
            items.forEach(function(it){
                it.style.display = (f === 'all' || it.getAttribute('data-cat') === f) ? '' : 'none';
            });
        });
    });

    // Lightbox
    var lb = document.getElementById('lightbox');
    var lbImg = document.getElementById('lbImg');
    var visible = function(){ return items.filter(function(it){ return it.style.display !== 'none'; }); };
    var current = 0;
    function open(idx){
        var vis = visible();
        current = idx;
        lbImg.src = vis[current].getAttribute('data-src');
        lb.classList.add('open');
        lb.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
    }
    function close(){ lb.classList.remove('open'); lb.setAttribute('aria-hidden','true'); document.body.style.overflow=''; }
    function move(dir){ var vis = visible(); current = (current + dir + vis.length) % vis.length; lbImg.src = vis[current].getAttribute('data-src'); }
    items.forEach(function(it){ it.addEventListener('click', function(){ open(visible().indexOf(it)); }); });
    document.getElementById('lbClose').addEventListener('click', close);
    document.getElementById('lbPrev').addEventListener('click', function(){ move(-1); });
    document.getElementById('lbNext').addEventListener('click', function(){ move(1); });
    lb.addEventListener('click', function(e){ if (e.target === lb) close(); });
    document.addEventListener('keydown', function(e){
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') move(-1);
        if (e.key === 'ArrowRight') move(1);
    });
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
