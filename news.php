<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — YANGILIKLAR RO'YXATI (news.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

$perPage = 6;
$page    = max(1, (int)($_GET['p'] ?? 1));
$offset  = ($page - 1) * $perPage;

try {
    $total = (int) db()->query("SELECT COUNT(*) FROM news WHERE holat='chop_etilgan'")->fetchColumn();
    $stmt  = db()->prepare("SELECT * FROM news WHERE holat='chop_etilgan' ORDER BY sana DESC LIMIT :lim OFFSET :off");
    // PDO::PARAM_INT bilan bind qilish to'g'ri ishlatiladi
    $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $news = $stmt->fetchAll();
} catch (Throwable $ex) {
    $news = []; $total = 0;
}
$pages = max(1, (int)ceil($total / $perPage));

$page_title = 'Yangiliklar';
$page_desc  = 'Chimyon School yangiliklari, tadbirlari va e\'lonlari bilan tanishing.';
$active     = 'news';
require __DIR__ . '/includes/header.php';
?>
<style>
.n-grid{grid-template-columns:repeat(3,1fr)}
.n-card{padding:0;overflow:hidden;display:flex;flex-direction:column}
.n-card .ph{height:210px;overflow:hidden}
.n-card .ph img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.n-card:hover .ph img{transform:scale(1.07)}
.n-body{padding:26px;display:flex;flex-direction:column;flex:1}
.n-date{font-size:13px;color:var(--primary);font-weight:600;margin-bottom:10px}
.n-body h3{font-size:19px;color:var(--dark);margin-bottom:10px;line-height:1.3}
.n-body p{color:var(--gray-500);font-size:14.5px;margin-bottom:18px;flex:1}
.n-more{color:var(--secondary);font-weight:600;font-size:14px;display:inline-flex;gap:6px;align-items:center;transition:gap .3s}
.n-card:hover .n-more{gap:12px}
.pager{display:flex;justify-content:center;gap:8px;margin-top:52px}
.pager a,.pager span{min-width:44px;height:44px;padding:0 12px;border-radius:11px;display:grid;place-items:center;font-weight:600;font-size:14.5px;border:1.5px solid var(--gray-300);color:var(--secondary);transition:.25s}
.pager a:hover{border-color:var(--dark);background:var(--dark);color:#fff}
.pager .cur{background:var(--primary);border-color:var(--primary);color:var(--dark)}
@media (max-width:992px){.n-grid{grid-template-columns:1fr 1fr}}
@media (max-width:560px){.n-grid{grid-template-columns:1fr}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Yangiliklar</h1>
        <p data-aos="fade-up" data-aos-delay="100">Maktab hayoti, tadbirlar va muhim e'lonlardan xabardor bo'lib turing.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Yangiliklar</div>
    </div>
</header>

<section class="section">
    <div class="container">
        <?php if ($news): ?>
            <div class="grid n-grid">
                <?php foreach ($news as $i => $n): ?>
                    <article class="card n-card" data-aos="fade-up" data-aos-delay="<?= ($i%3)*80 ?>">
                        <a href="news-single.php?id=<?= (int)$n['id'] ?>" class="ph">
                            <img src="<?= upload_url($n['rasm']) ?>" alt="<?= e($n['sarlavha']) ?>" loading="lazy">
                        </a>
                        <div class="n-body">
                            <div class="n-date"><?= e(uz_date($n['sana'])) ?></div>
                            <h3><?= e($n['sarlavha']) ?></h3>
                            <p><?= e($n['qisqa_tavsif']) ?></p>
                            <a href="news-single.php?id=<?= (int)$n['id'] ?>" class="n-more">Batafsil o'qish
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($pages > 1): ?>
                <nav class="pager" aria-label="Sahifalar">
                    <?php if ($page > 1): ?><a href="?p=<?= $page-1 ?>">&laquo;</a><?php endif; ?>
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span class="cur"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?p=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($page < $pages): ?><a href="?p=<?= $page+1 ?>">&raquo;</a><?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <p class="center section-sub">Hozircha yangiliklar mavjud emas. Tez orada qo'shiladi.</p>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
