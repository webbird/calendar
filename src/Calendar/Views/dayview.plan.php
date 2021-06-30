<div class="mobile-wrapper">
    <header class="header">
        <div class="container">
            <?php if($c->title): ?><span><?=$c->title?></span><?php endif; ?>
            <?php if($c->subtitle): ?><h1><?=$c->subtitle?></h1><?php endif; ?>
        </div>
    </header>

    <section id="today-box">
        <a href="<?=$c->uribase?>?year=<?=$current->year?>&month=<?=$current->month?>&day=<?=$current->day?>&np=previous" style="justify-self:center;align-self:center;"><span class="triangle-left"></span></a>
        <span class="today-box">
            <span class="breadcrumb"><?=$current->localeDayOfWeek?></span>
            <h3 class="date-title"><?=$current->day.'. '.$current->localeMonth.' '.$current->year?></h3>
        </span>
        <a href="<?=$c->uribase?>?year=<?=$current->year?>&month=<?=$current->month?>&day=<?=$current->day?>&np=next" style="justify-self:center;align-self:center;"><span class="triangle-right"></span></a>
    </section>

    <section class="upcoming-events">
    <div class="container">
    <div class="events-wrapper">
<?php $events = $c->getEventsForDay($current); if($events): foreach($events as $e): ?>
            <div class="event">
               <h4 class="event__point"><?=$e->startdate->isoFormat('HH:mm')?></h4>
               <p class="event__description">
                  <?=$e->title?>
               </p>
               <?php if($e->description): echo $e->description; endif; ?>
            </div>
<?php endforeach; endif; ?>
         </div>
      </div>
   </section>
</div>
<?php include_once __DIR__.'/defaultcss.php'; ?>