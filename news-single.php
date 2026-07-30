<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — BITTA YANGILIK (news-single.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

$id = (int)($_GET['id'] ?? 0);
$item = null;
try {
    if ($id) {
        $stmt = db()->prepare("SELECT * FROM news WHERE id = ? AND holat='chop_etilgan' LIMIT 1");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
    }
    $related = [];
    if ($item) {
        $r = db()->prepare("SELECT * FROM news WHERE holat='chop_etilgan' AND id <> ? ORDER BY sana DESC LIMIT 3");
        $r->execute([$id]);
        $related = $r->fetchAll();
    }
} catch (Throwable $ex) {
    $item = null; $related = [];
}

// Topilmasa — yangiliklar ro'yxatiga
if (!$item) {
    http_response_code(404);
    $page_title = 'Yangilik topilmadi';
    $active = 'news';
    require __DIR__ . '/includes/header.php';
    echo '<header class="page-hero"><div class="container"><h1>Yangilik topilmadi</h1><p>Ushbu yangilik mavjud emas yoki o\'chirilgan.</p><div class="crumbs"><a href="news.php">&larr; Yangiliklarga qaytish</a></div></div></header>';
    echo '<section class="section"><div class="container center"><a href="news.php" class="btn btn-navy">Barcha yangiliklar</a></div></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$page_title = $item['seo_title'] ?: $item['sarlavha'];
$page_desc  = $item['seo_description'] ?: mb_substr(strip_tags($item['qisqa_tavsif'] ?? ''), 0, 155);
$active     = 'news';
require __DIR__ . '/includes/header.php';
?>
<style>
.article-hero{position:relative;padding:calc(var(--nav-h) + 60px) 0 60px;background:linear-gradient(135deg,var(--navy-900),var(--navy-700));color:#fff}
.article-hero::after{content:"";position:absolute;inset:0;background:radial-gradient(circle at 85% 15%,rgba(212,175,55,.16),transparent 55%)}
.article-hero .container{position:relative;z-index:2;max-width:820px}
.article-hero .date{color:var(--gold-300);font-weight:600;font-size:14px;margin-bottom:14px;display:block}
.article-hero h1{font-size:clamp(28px,4.5vw,46px);line-height:1.15;text-wrap:balance}
.article-hero .crumbs{margin-top:18px}
.article-wrap{max-width:820px;margin:0 auto}
.article-cover{border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);margin:-90px auto 44px;position:relative;z-index:5}
.article-cover img{width:100%;max-height:460px;object-fit:cover}
.article-body{font-size:17px;line-height:1.8;color:var(--gray-700)}
.article-body p{margin-bottom:20px}
.article-body h2,.article-body h3{color:var(--navy-800);margin:28px 0 12px}
.article-body img{border-radius:12px;margin:20px 0}
.article-lead{font-size:19px;color:var(--navy-700);font-weight:500;padding-left:20px;border-left:3px solid var(--gold-500);margin-bottom:28px}
.share{display:flex;align-items:center;gap:12px;margin:40px 0;padding-top:26px;border-top:1px solid var(--gray-100)}
.share span{font-weight:600;color:var(--navy-800);font-size:14px}
.share a{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:var(--cream);color:var(--navy-700);transition:.3s}
.share a:hover{background:var(--gold-500);color:var(--navy-900);transform:translateY(-3px)}
.rel-grid{grid-template-columns:repeat(3,1fr)}
.rel-card{padding:0;overflow:hidden}
.rel-card .ph{height:170px;overflow:hidden}
.rel-card .ph img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.rel-card:hover .ph img{transform:scale(1.07)}
.rel-body{padding:22px}
.rel-body .d{font-size:12.5px;color:var(--gold-500);font-weight:600;margin-bottom:8px}
.rel-body h4{font-size:16.5px;color:var(--navy-800);line-height:1.35}
@media (max-width:900px){.article-cover{margin-top:-60px}.rel-grid{grid-template-columns:1fr}}
</style>

<header class="article-hero">
    <div class="container">
        <span class="date"><?= e(uz_date($item['sana'])) ?></span>
        <h1><?= e($item['sarlavha']) ?></h1>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; <a href="news.php">Yangiliklar</a></div>
    </div>
</header>

<section class="section">
    <div class="container">
        <div class="article-wrap">
            <?php if (!empty($item['rasm'])): ?>
                <div class="article-cover" data-aos="fade-up">
                    <img src="<?= upload_url($item['rasm']) ?>" alt="<?= e($item['sarlavha']) ?>">
                </div>
            <?php endif; ?>

            <?php if (!empty($item['qisqa_tavsif'])): ?>
                <p class="article-lead"><?= e($item['qisqa_tavsif']) ?></p>
            <?php endif; ?>

            <div class="article-body">
                <?php
                // matn admin panelidan HTML sifatida saqlanadi.
                // Faqat xavfsiz teglarga ruxsat beramiz (XSS himoyasi).
                $allowed = '<p><br><b><strong><i><em><u><ul><ol><li><h2><h3><h4><blockquote><a><img>';
                echo strip_tags($item['matn'] ?? '', $allowed);
                ?>
            </div>

            <div class="share">
                <span>Ulashish:</span>
                <?php $url = rawurlencode(SITE_URL . '/news-single.php?id=' . (int)$item['id']); $t = rawurlencode($item['sarlavha']); ?>
                <a href="https://t.me/share/url?url=<?= $url ?>&text=<?= $t ?>" target="_blank" rel="noopener" aria-label="Telegram">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/></svg>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                </a>
            </div>

            <a href="news.php" class="n-more" style="color:var(--navy-700);font-weight:600;display:inline-flex;gap:8px;align-items:center">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
                Barcha yangiliklar
            </a>
        </div>
    </div>
</section>

<?php if ($related): ?>
<section class="section features">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Yana o'qing</span>
            <h2 class="section-title">Boshqa yangiliklar</h2>
        </div>
        <div class="grid rel-grid" style="margin-top:48px">
            <?php foreach ($related as $i => $r): ?>
                <a class="card rel-card" href="news-single.php?id=<?= (int)$r['id'] ?>" data-aos="fade-up" data-aos-delay="<?= $i*90 ?>">
                    <div class="ph"><img src="<?= upload_url($r['rasm']) ?>" alt="<?= e($r['sarlavha']) ?>" loading="lazy"></div>
                    <div class="rel-body">
                        <div class="d"><?= e(uz_date($r['sana'])) ?></div>
                        <h4><?= e($r['sarlavha']) ?></h4>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
