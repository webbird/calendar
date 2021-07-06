<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class EventTest extends TestCase
{
    static string $title = 'Event Constructor Test';
    
    public function testConstructor_valid()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $this->assertInstanceOf(\webbird\Calendar\Event::class,$e);
    }

    public function testConstructor_missingParams()
    {
        $this->expectException(ArgumentCountError::class);
        new \webbird\Calendar\Event(
            title: self::$title
        );
    }

    public function testConstructorWithOptionalParams_valid()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime(),
            description: 'Description',
            image: 'https://via.placeholder.com/150'
        );
        $this->assertInstanceOf(\webbird\Calendar\Event::class,$e);
    }
    
    public function testIsFirstDay_true()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $this->assertTrue($e->isFirstDay(new \DateTime()));
    }
    
    public function testIsFirstDay_false()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $dt = new \DateTime();
        $dt->add(new \DateInterval('P1D'));
        $this->assertFalse($e->isFirstDay($dt));
    }

    public function testIsLastDay_true()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $this->assertTrue($e->isLastDay(new \DateTime()));
    }
    
    public function testIsLastDay_false()
    {
        $e = new \webbird\Calendar\Event(
            title: self::$title,
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $dt = new \DateTime();
        $dt->add(new \DateInterval('P1D'));
        $this->assertFalse($e->isLastDay($dt));
    }
}