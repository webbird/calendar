<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalendarTest extends TestCase
{
    public function testwithTimezone_validTZ()
    {
        $tz = "Europe/Berlin";
        $d = new \webbird\Calendar\Calendar();
        $d->withTimezone($tz);
        $this->assertEquals(
            $tz,
            $d->getTimezone()
        );
    }

    public function testwithTimezone_invalidTZ()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new \webbird\Calendar\Calendar();
        $d->withTimezone('invalid');
    }   // end function testwithTimezone_invalidTZ()

    public function testresetTimezone()
    {
        $tz = "Europe/Berlin";
        $d = new \webbird\Calendar\Calendar();
        $d->withTimezone($tz);
        $this->assertEquals(
            $tz,
            $d->getTimezone()
        );
        $d->resetTimezone();
        $this->assertEquals(
            $d->getTimezone(),
            ini_get('date.timezone')
        );
    }

    public function testaddEvent()
    {
        $d = new \webbird\Calendar\Calendar();
        $this->assertTrue(
            $d->addEvent( new \webbird\Calendar\Event(
                title: 'Some event',
                startdate: new \DateTime(),
                enddate: new \DateTime()
            ))
        );
    }

    public function testrenderAs()
    {
        $d = new \webbird\Calendar\Calendar();
        $o = $d->renderAs('dayview');
        $this->assertIsObject($o);
        $this->assertEquals(
            'dayview',
            $d->getRenderType()
        );
    }



    public function xtestwithLocale_validLC()
    {
        $lc = "de-DE";
        $d = new \webbird\Calendar();
        $d->withLocale($lc);
        $this->assertEquals(
            $lc,
            setlocale(LC_TIME, 0)
        );
    }

    public function xtestwithLocale_invalidLC()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new \webbird\Calendar\Calendar();
        $d->withLocale('invalid');
    }

    /**
     *
     * @access public
     * @return
     **/
    public function xtesttoday()
    {
        $d = new \webbird\Calendar();
        $this->assertInstanceOf(\DateTime::class, $d->today());
    }   // end function testtoday()

}