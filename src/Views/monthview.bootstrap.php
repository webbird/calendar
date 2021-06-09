<div class="calendar-container <?=$this->e($c->getTheme())?>">
    <div class="calendar-header">
        <h1><?= $dt->localeMonth ?></h1>
        <p><?= $dt->year ?> </p>
    </div>
    <div class="calendar">
        <?php foreach($daynames as $day): ?>
        <span class="day-name"><?=$day?></span>
        <?php endforeach; $row = 2; foreach ($period as $date): ?>
        <span class="day<?php if($date->month != $dt->month): echo ' day--disabled'; endif; ?>" style="grid-row:<?=$row?>;grid-column:<?=$date->dayOfWeekIso?>;"><?=$date->day?></span>
        <?php if($date->dayOfWeekIso==7): $row++; endif; ?>
        <?php endforeach; ?>
        <?php foreach ($period as $date): $events = $c->getEventsForDay($date); if($events): foreach($events as $e): ?>
        <section class="task task--<?=$e->color?>" style="grid-area:<?=$e->startdate->weekNumberInMonth+1?>/<?=$e->startdate->dayOfWeekIso?>/<?=$e->enddate->weekNumberInMonth+1?>/<?=$e->enddate->dayOfWeekIso+1?>">
            <?=$e->title?>
        </section>
        <?php endforeach; endif; endforeach; ?>
    </div>
</div>

<?php include_once __DIR__.'/defaultcss.php'; ?>