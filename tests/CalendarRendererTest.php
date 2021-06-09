<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalendarRendererTest extends TestCase
{
    public function testwithLocale_validLC()
    {
        $lc = "de-DE";
        $d = new \webbird\Calendar();
        $d->withLocale($lc);
        $this->assertEquals(
            $lc,
            setlocale(LC_TIME, 0)
        );
    }

    public function testwithLocale_invalidLC()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new \webbird\Calendar();
        $d->withLocale('invalid');
    }
}