<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalendarTest extends TestCase
{
    public function testConstructor_valid()
    {
        $c = new \webbird\Calendar\Calendar();
        $this->assertInstanceOf(\webbird\Calendar\Calendar::class,$c);
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
    
    public function testgetEventCategories()
    {
        $c = new \webbird\Calendar\Calendar();
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: 'Some event (heute vor 5 Tagen, Dauer 2 Tage)',
                startdate: \Carbon\Carbon::now()->addDays(-5)->addHours(4)->minute(0),
                enddate: \Carbon\Carbon::now()->addDays(-3)->minute(0),
                description: 'Description of some event',
                color: 'blue',
                category: 'Category1'
            )
        );
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: 'Some other event (heute vor 5 Tagen)',
                startdate: \Carbon\Carbon::now()->addDays(-5)->minute(0),
                enddate: \Carbon\Carbon::now()->addDays(-5)->minute(0),
                description: 'Description of some other event',
                color: '#0c0',
                category: 'Category2'
            )
        );
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: 'Today\'s Event (heute)',
                startdate: \Carbon\Carbon::now()->hour(12)->minute(0),
                enddate: \Carbon\Carbon::now()->hour(15)->minute(0),
                description: 'Description of some other event',
                color: 'yellow',
                category: 'Category2'
            )
        );
        $r = $c->getEventCategories();
        $this->assertIsArray($r);
        $this->assertContains('Category1', $r);
        $this->assertContains('Category2', $r);
    }
    
    public function testgetEventCount()
    {
        $c = new \webbird\Calendar\Calendar();
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '1',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '2',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '3',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $this->assertEquals(3, $c->getEventCount(\Carbon\Carbon::now()));
    }
    
    public function testgetEventsForDay()
    {
        $c = new \webbird\Calendar\Calendar();
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '1',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '2',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $r = $c->getEventsForDay(\Carbon\Carbon::now());
        $this->assertIsArray($r);
        $this->assertInstanceOf(\webbird\Calendar\Event::class,$r[0]);
        $this->assertCount(2,$r);
    }
    
    public function testhasEvent()
    {
        $c = new \webbird\Calendar\Calendar();
        $c->addEvent(
            new \webbird\Calendar\Event(
                title: '1',
                startdate: \Carbon\Carbon::now(),
                enddate: \Carbon\Carbon::now()
            )
        );
        $this->assertTrue($c->hasEvent(\Carbon\Carbon::now()));
    }
    
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

}