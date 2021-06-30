<div class="container">
  <div class="calendar <?=$this->e($c->getTheme())?>">
    <div class="calendar_header">
      <div class="header_month">
        <a href="<?=$c->uribase?>?year=<?=$current->year-1?>&month=<?=$current->month?>&day=<?=$current->day?>" style="justify-self:start;"><span class="triangle-left"></span></a>
        <span style="justify-self:center"><?=$current->localeMonth ?></span>
        <a href="<?=$c->uribase?>?year=<?=$current->year+1?>&month=<?=$current->month?>&day=<?=$current->day?>" style="justify-self:end;"><span class="triangle-right"></span></a>
      </div>
      <p class="header_days">
<?php $period = \Carbon\CarbonPeriod::create($current->copy()->startOfMonth(), $current->copy()->endOfMonth()); foreach ($period as $date): ?>
        <a href="<?=$c->uribase?>?year=<?=$current->year?>&month=<?=$current->month?>&day=<?=$date->day?>"<?php if($c->hasEvent($date)): ?> class="withevents"<?php endif; ?>><?=$date->day?></a>
<?php endforeach; ?>
      </p>
    </div>
    <div class="calendar_plan">
      <div class="cl_plan">
        <div class="cl_title"><?=$current->localeDayOfWeek?></div>
        <div class="cl_copy"><?=$current->day.'. '.$current->localeMonth.' '.$current->year?></div>
      </div>
    </div>
    <div class="calendar_events">
<?php $events = $c->getEventsForDay($current); if($events): foreach($events as $e): ?>
      <div class="event_item">
        <div class="ei_Dot dot_active"></div>
        <div class="ei_Time"><?=$e->startdate->isoFormat('HH:mm')?></div>
        <div class="ei_Title"><?=$e->title?></div>
        <div class="ei_Details">
<?php if($e->description): echo $e->description; endif; ?>
        </div>
      </div>
<?php endforeach; endif; ?>
    </div>
  </div>
</div>

<?php include_once __DIR__.'/defaultcss.php'; ?>