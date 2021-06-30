<div class="calendar-container <?=$this->e($c->getTheme())?>">
    <div class="calendar-header">
        <h1><?= $dt->localeMonth ?></h1>
        <p><?= $dt->year ?> </p>
    </div>
    <div class="calendar">
        <?php foreach($daynames as $day): ?>
        <span class="day-name"><?=$day?></span>
        <?php endforeach; $row = 2; foreach ($period as $date): $events = $c->getEventsForDay($date); ?>
        <span class="day<?php if($date->month != $dt->month): echo ' day--disabled'; endif; if(count($events)): echo ' active'; endif; ?>" style="grid-row:<?=$row?>;grid-column:<?=$date->dayOfWeekIso?>;">
            <?php if($c->hasEvent($date)): ?>
            <input type="radio" id="tab<?=$date->day?>" name="tabGroup" class="tab" />
            <?php endif; ?>
            <label for="tab<?=$date->day?>"><?=$date->day?></label>
        </span>
        <?php if($date->dayOfWeekIso==7): $row++; endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="schedule">
<?php foreach ($period as $date): if($c->hasEvent($date)): ?>
        <div id="tab-content<?=$date->day?>" class="tab-content">
            <div class="schedule-list">
<?php $events = $c->getEventsForDay($date); if($events): foreach($events as $e): ?>
    			<div class="schedule-item">
    				<div class="time">
    					<span><?=$e->startdate->hour?></span>
    				</div>
    				<div class="description">
    					<div class="description-header"><?=$e->title?></div>
                        <?php if($e->description): ?>
    					<div class="description-content">
    						<p><?=$e->description?></p>
    					</div>
                        <?php endif; ?>
    				</div>
    			</div>
<?php endforeach; endif; ?>
    		</div>
        </div>
<?php endif; endforeach; ?>
    </div>

<?php include_once __DIR__.'/defaultcss.php'; ?>

<?php if($c->getLayout()): ?>
<script charset=utf-8 type="text/javascript">
//<![CDATA[

    [].forEach.call( document.querySelectorAll('input.tab'), function(el) {
        el.addEventListener('click', function(e) {
            let day = el.id.replace("tab","");
            [].forEach.call( document.querySelectorAll('.tab-content'), function(inner) {
                inner.style.display = "none";
            }, false);
//console.log("day: "+day, document.querySelector("#tab-content"+day));
            document.querySelector("#tab-content"+day).style.display = "block";
        }, false);
    });
//]]>
</script>
<?php endif; ?>