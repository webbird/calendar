<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class EventTest extends TestCase
{
    public function testConstructor_valid()
    {
        $e = new \webbird\Calendar\Event(
            title: 'Event Constructor Test',
            startdate: new \DateTime(),
            enddate: new \DateTime()
        );
        $this->assertInstanceOf(\webbird\Calendar\Event::class,$e);
    }

    public function testConstructor_missingParams()
    {
        $this->expectException(ArgumentCountError::class);
        $e = new \webbird\Calendar\Event(
            title: 'Event Constructor Test'
        );
    }

    public function testConstructorWithOptionalParams_valid()
    {
        $e = new \webbird\Calendar\Event(
            title: 'Event Constructor Test',
            startdate: new \DateTime(),
            enddate: new \DateTime(),
            description: 'Description',
            image: 'https://...'
        );
        $this->assertInstanceOf(\webbird\Calendar\Event::class,$e);
    }

}