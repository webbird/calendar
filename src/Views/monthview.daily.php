<div class="calendar-container <?=$this->e($c->getTheme())?>">
    <div class="calendar-base">
        <div class="calendar-days">
            <div class="year"><?=$current->year?></div>
            <a href="<?=$c->uribase?>?year=<?=$current->year-1?>&month=<?=$current->month?>&day=<?=$current->day?>"><span class="triangle-left"></span></a>
            <a href="<?=$c->uribase?>?year=<?=$current->year+1?>&month=<?=$current->month?>&day=<?=$current->day?>"><span class="triangle-right"></span></a>
            <div class="months">
<?php $monthperiod = \Carbon\CarbonPeriod::create(date('y').'-01-01', '1 month', date('y').'-12-01'); foreach ($monthperiod as $mdt): ?>
                <a href="<?=$c->uribase?>?year=<?=$current->year?>&month=<?=$mdt->month?>&day=<?=$current->day?>" class="month-hover<?php if($mdt->month == $current->month): ?> month-color<?php endif; ?>"><?=$mdt->shortLocaleMonth?></a>
<?php endforeach; ?>
            </div>
            <hr class="month-line" />
            <div class="days">
<?php foreach($daynames as $day): ?>
                <span class="day-name"><?=$day?></span>
<?php endforeach; $row = 2; foreach ($period as $date): ?>
                <span class="day<?php if($date->month != $dt->month): echo ' day--disabled'; endif; if($date == $today): echo ' today'; endif; if($date == $current): echo ' current'; endif; ?>" style="grid-row:<?=$row?>;grid-column:<?=$date->dayOfWeekIso?>;">
<?php
    if($c->hasEvent($date)):
        $events = $c->getEventsForDay($date);
        foreach($events as $e):
            echo '<span class="event-indicator tooltip"';
            if($e->color): echo ' style="background-color:'.$e->color.'"'; endif;
            if($e->title): echo ' data-tooltip="'.$e->title.'"'; endif;
            echo '></span>';
        endforeach;
    endif;
?>
                    <a href="<?=$c->uribase?>?year=<?=$date->year?>&month=<?=$date->month?>&day=<?=$date->day?>"><?=$date->day?></a>
                </span>
                <?php if($date->dayOfWeekIso==7): $row++; endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <!-- days -->
        <div class="calendar-left">
            <div class="num-date" id="thisday-num"><?=$current->day?></div>
            <div class="day" id="thisday-name"><?=$current->localeDayOfWeek?></div>
            <div class="current-events">
<?php if($c->hasEvent($current)): ?>
                <div id="tab-content<?=$current->day?>" class="tab-content" style="display: grid">
<?php $events = $c->getEventsForDay($current); if($events): foreach($events as $e): ?>
            <?=$e->startdate->format('h:i')?>
                <span title="<?=$e->description?>"><?=$e->title?></span>
<?php endforeach; endif; ?>
                </div>
<?php endif; ?>
            </div>
        </div>

    </div>
</div>
<!-- container -->

<?php include_once __DIR__.'/defaultcss.php'; ?>