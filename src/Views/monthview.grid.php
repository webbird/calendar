<div class="calendar-container <?=$this->e($c->getTheme())?>">
    <div class="calendar-header">
        <h1><?= $dt->localeMonth ?></h1>
        <p><?= $dt->year ?> </p>
    </div>
    <div class="calendar">
        <?php foreach($daynames as $day): ?>
        <span class="day-name"><?=$day?></span>
        <?php endforeach; $row = 2; foreach ($period as $date): $events = $c->getEventsForDay($date); ?>
        <span class="day<?php if($date->month != $dt->month): echo ' day--disabled'; endif; if(count($events)): echo ' active'; endif; ?>" style="grid-row:<?=$row?>;grid-column:<?=$date->dayOfWeekIso?>;"><?=$date->day?></span>
        <?php if($date->dayOfWeekIso==7): $row++; endif; ?>
        <?php endforeach; ?>
<?php
    switch($c->getLayout()):
        case 'boostrap':
            foreach ($period as $date):
                $events = $c->getEventsForDay($date);
                if($events):
                    foreach($events as $e):
?>
        <section class="task task--<?=$e->color?>" style="grid-area:<?=$e->startdate->weekNumberInMonth+1?>/<?=$e->startdate->dayOfWeekIso?>/<?=$e->enddate->weekNumberInMonth+1?>/<?=$e->enddate->dayOfWeekIso+1?>">
            <?=$e->title?>
        </section>
<?php
                    endforeach;
                endif;
            endforeach;
            break;
        case 'saminou':
            $categories = $c->getEventCategories();
            if(!empty($categories)):
?>
        <div class="schedule">
            <ul class="tabs">
<?php
                foreach($categories as $cat):
?>
                    <li class="tab"><a href="#"><?=$cat?></a></li>
<?php
                endforeach;
?>
            </ul>
        </div>
<?php
            endif;
            break;
    endswitch;
?>
    </div>
</div>

<?php if($c->getLayout()): ?>
<script charset=utf-8 type="text/javascript">
//<![CDATA[
    document.addEventListener('DOMContentLoaded', function() {
      let css = document.createElement('link');
      css.rel = "stylesheet";
      css.href = "<?=$this->e($c->getLayout())?>.css";
      css.type = "text/css";
      css.media = "screen,projection,print";
      document.body.appendChild(css);
    });
//]]>
</script>
<?php endif; ?>