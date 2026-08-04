<?php
/**
 * =====================================================================
 * CHIMYON SCHOOL — NARXLAR (pricing.php)
 * =====================================================================
 */
require_once __DIR__ . '/config/config.php';

$page_title = 'Narxlar';
$page_desc  = 'Chimyon School o\'quv to\'lovlari, tariflari, chegirmalari va qulay to\'lov shartlari.';
$active     = 'pricing';
require __DIR__ . '/includes/header.php';
?>
<style>
.price-grid{grid-template-columns:repeat(3,1fr);align-items:stretch}
.price{display:flex;flex-direction:column;position:relative;overflow:visible}
.price.featured{border:2px solid var(--primary);box-shadow:var(--shadow-md);transform:translateY(-10px)}
.price .ribbon{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--primary);color:var(--dark);font-size:12.5px;font-weight:700;letter-spacing:.05em;padding:7px 18px;border-radius:50px;text-transform:uppercase}
.price h3{font-size:20px;color:var(--dark);margin-bottom:6px}
.price .desc{color:var(--gray-500);font-size:14px;margin-bottom:20px}
.price .amount{font-family:'Playfair Display',serif;font-size:40px;font-weight:800;color:var(--dark);line-height:1}
.price .amount small{font-size:15px;color:var(--gray-500);font-weight:400;font-family:'Inter'}
.price .per{color:var(--gray-500);font-size:13.5px;margin-bottom:24px}
.price ul{margin-bottom:28px;flex:1}
.price li{display:flex;gap:10px;align-items:flex-start;padding:9px 0;font-size:14.5px;color:var(--gray-700);border-bottom:1px solid var(--gray-100)}
.price li svg{flex:0 0 18px;color:var(--primary);margin-top:2px}
.price .btn{width:100%}
.disc-grid{grid-template-columns:repeat(3,1fr)}
.disc{display:flex;gap:16px;align-items:flex-start}
.disc .n{font-family:'Playfair Display',serif;font-size:34px;font-weight:800;color:var(--primary);line-height:1}
.disc h4{font-size:17px;color:var(--dark);margin-bottom:4px}
.disc p{font-size:14px;color:var(--gray-500)}
.faq{max-width:760px;margin:0 auto}
.faq-item{background:#fff;border:1px solid var(--gray-100);border-radius:14px;margin-bottom:14px;overflow:hidden;box-shadow:var(--shadow-sm)}
.faq-q{width:100%;text-align:left;background:none;border:none;padding:20px 24px;font-size:16px;font-weight:600;color:var(--dark);cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px;font-family:'Inter'}
.faq-q span.ic{flex:0 0 24px;width:24px;height:24px;border-radius:50%;background:var(--cream);color:var(--primary);display:grid;place-items:center;transition:.3s;font-size:20px}
.faq-item.open .faq-q span.ic{transform:rotate(45deg);background:var(--primary);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease;color:var(--gray-600);font-size:14.5px}
.faq-a div{padding:0 24px 20px}
@media (max-width:992px){.price-grid,.disc-grid{grid-template-columns:1fr}.price.featured{transform:none}}
</style>

<header class="page-hero">
    <div class="container">
        <h1 data-aos="fade-up">Narxlar va shartlar</h1>
        <p data-aos="fade-up" data-aos-delay="100">Shaffof narxlar, qulay to'lov shartlari va oilalar uchun chegirmalar.</p>
        <div class="crumbs"><a href="index.php">Bosh sahifa</a> &nbsp;/&nbsp; Narxlar</div>
    </div>
</header>

<!-- PRICING TIERS -->
<section class="section">
    <div class="container">
        <div class="grid price-grid">
            <?php
            $check = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>';
            $plans = [
                ['Boshlang\'ich', 'Sinflar 1–4', '1 800 000', false, ['Kuniga 5 ta dars', 'Ikki mahal ovqat', '2 ta to\'garak (bepul)', 'Kichik guruhlar (15 tagacha)', 'Kunduzgi nazorat']],
                ['O\'rta', 'Sinflar 5–9', '2 200 000', true, ['Kuniga 6–7 ta dars', 'Ikki mahal ovqat', '3 ta to\'garak (bepul)', 'Ingliz tili kuchaytirilgan', 'Individual maslahat', 'Psixolog nazorati']],
                ['Yuqori', 'Sinflar 10–11', '2 600 000', false, ['Chuqurlashtirilgan dasturlar', 'Ikki mahal ovqat', 'IELTS/SAT tayyorlov', 'Kasb yo\'nalishi maslahati', 'Olimpiada tayyorlovi', 'Oliygohga kirish yordami']],
            ];
            foreach ($plans as $i => $p): ?>
                <div class="card price <?= $p[3] ? 'featured' : '' ?>" data-aos="fade-up" data-aos-delay="<?= $i*100 ?>">
                    <?php if ($p[3]): ?><span class="ribbon">Ommabop</span><?php endif; ?>
                    <h3><?= e($p[0]) ?></h3>
                    <div class="desc"><?= e($p[1]) ?></div>
                    <div class="amount"><?= e($p[2]) ?> <small>so'm</small></div>
                    <div class="per">oyiga / bir o'quvchi</div>
                    <ul>
                        <?php foreach ($p[4] as $f): ?>
                            <li><?= $check ?><span><?= e($f) ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="admission.php" class="btn <?= $p[3] ? 'btn-gold' : 'btn-navy' ?>">Ariza qoldirish</a>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="center" style="margin-top:26px;color:var(--gray-500);font-size:14px">* Narxlar taxminiy bo'lib, aniq ma'lumot uchun biz bilan bog'laning. Bir martalik ro'yxatdan o'tish to'lovi alohida.</p>
    </div>
</section>

<!-- DISCOUNTS -->
<section class="section features">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Imtiyozlar</span>
            <h2 class="section-title">Chegirmalar tizimi</h2>
        </div>
        <div class="grid disc-grid" style="margin-top:52px">
            <?php
            $discs = [
                ['10%', 'Aka-uka / opa-singil', 'Bir oiladan ikki va undan ortiq farzand o\'qisa.'],
                ['15%', 'Yillik to\'lov', 'To\'lov bir yillik oldindan amalga oshirilsa.'],
                ['100%', 'Iqtidorli o\'quvchilar', 'Olimpiada g\'oliblari uchun maxsus grant.'],
            ];
            foreach ($discs as $i => $d): ?>
                <div class="card disc" data-aos="fade-up" data-aos-delay="<?= $i*100 ?>">
                    <div class="n"><?= e($d[0]) ?></div>
                    <div><h4><?= e($d[1]) ?></h4><p><?= e($d[2]) ?></p></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="section">
    <div class="container">
        <div class="center" data-aos="fade-up">
            <span class="eyebrow">Savol-javob</span>
            <h2 class="section-title">Ko'p beriladigan savollar</h2>
        </div>
        <div class="faq" style="margin-top:48px" data-aos="fade-up">
            <?php
            $faqs = [
                ['To\'lovni qanday amalga oshirish mumkin?', 'To\'lovni oylik yoki yillik tarzda naqd, plastik karta yoki bank o\'tkazmasi orqali amalga oshirishingiz mumkin.'],
                ['Ovqatlanish narxga kiritilganmi?', 'Ha, barcha tariflarda ikki mahal sog\'lom ovqatlanish o\'quv to\'loviga kiritilgan.'],
                ['Sinov muddati bormi?', 'Ha, farzandingiz uchun 1 haftalik sinov davri mavjud. Bu davrda maktab muhiti bilan tanishasiz.'],
                ['To\'garaklar uchun alohida to\'lov kerakmi?', 'Tarifga kiritilgan to\'garaklar bepul. Qo\'shimcha maxsus yo\'nalishlar uchun alohida narx belgilanadi.'],
            ];
            foreach ($faqs as $f): ?>
                <div class="faq-item">
                    <button class="faq-q"><?= e($f[0]) ?><span class="ic">+</span></button>
                    <div class="faq-a"><div><?= e($f[1]) ?></div></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('.faq-q').forEach(function(q){
    q.addEventListener('click', function(){
        var item = q.parentElement;
        var ans = item.querySelector('.faq-a');
        var isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(function(it){
            it.classList.remove('open');
            it.querySelector('.faq-a').style.maxHeight = null;
        });
        if (!isOpen){ item.classList.add('open'); ans.style.maxHeight = ans.scrollHeight + 'px'; }
    });
});
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
