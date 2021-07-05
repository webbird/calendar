<div class="calendar-container <?=$this->e($c->getTheme())?>">
    <div class="calendar-header">
        <h1><?= $dt->localeMonth . ' ' . $dt->year ?> </p>
    </div>
    <div class="calendar grid" style="grid-template-columns:80% auto">
        <table aria-label="Bookings for this month" role="presentation">
            <thead>
                <tr>
                    <td></td>
<?php foreach ($period as $date): ?>
                    <td><span><?=$date->day?></span></td>
<?php endforeach; ?>
                </tr>
                <tr>
                    <td></td>
<?php foreach ($period as $date): ?>
                    <td class="seasoncolor" style="background-color:<?=$c->getSeasonForDate($date)->getColor()?>"></th>
<?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
<?php foreach($c->getProperties(true) as $i => $p): ?>
                <tr>
                    <td class="property"><?=$p->getName()?></td>
<?php foreach ($period as $date): ?>
                    <td>
<?php
if($p->hasBookingForDay($date)):
    $e = $p->getBookingsForDay($date);
    foreach($e as $i => $b):
?>
                        <div class="free <?=$b->getStatus()->getCssclass()?><?php if((count($e)>1 && $i>=1) || $b->isFirstDay($date)): ?> bot-right-half<?php endif; if($b->isLastDay($date)): ?> top-left-half<?php endif; ?>" style="background-color:<?=$b->getStatus()->getColor()?>"></div>
<?php
    endforeach;
endif; ?>
                    </td>
<?php endforeach; ?>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>
<?php if($c->legendEnabled()===true): ?>
        <div class="legend right">
<?php foreach($c->getSeasons() as $s): ?>
			<span class="legenditem" title="<?=$s->startdate->isoFormat('DD.MM.YYYY').' - '.$s->enddate->isoFormat('DD.MM.YYYY')?>">
                <span class="color" style="background-color: <?=$s->getColor()?>"></span>
                <p><?=$s->getTitle()?></p>
            </span>
<?php endforeach; ?>
<?php foreach($c->getStatus() as $s): ?>
			<span class="legenditem">
                <span class="color" style="background-color:<?=$s->getColor()?>"></span>
                <p><?=$s->getTitle()?></p>
            </span>
<?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
</div>

<?php include_once __DIR__.'/defaultcss.php'; ?>