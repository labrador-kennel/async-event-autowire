<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Amp\PHPUnit\AsyncTestCase;
use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\Bootstrap;
use Labrador\AsyncEvent\AmpEmitter;
use Labrador\AsyncEvent\AmpEventEmitter;
use Labrador\AsyncEvent\Emitter;
use Labrador\AsyncEvent\Event;
use Labrador\AsyncEvent\EventEmitter;
use Labrador\AsyncEvent\StandardEvent;

/**
 * @covers \Labrador\AsyncEvent\Autowire\Observer
 */
class ObserverTest extends AsyncTestCase {

    private function getContainer() : AnnotatedContainer {
        return (new Bootstrap())->bootstrapContainer();
    }

    public function testEmitOneTime() : void {
        $container = $this->getContainer();

        $emitter = $container->get(Emitter::class);

        self::assertInstanceOf(AmpEmitter::class, $emitter);
        self::assertCount(3, $emitter->listeners('something'));
    }

    public function testOneTimeRemovalRespected() : void {
        $container = $this->getContainer();

        $emitter = $container->get(Emitter::class);

        self::assertInstanceOf(AmpEmitter::class, $emitter);

        $event = $this->getMockBuilder(Event::class)->getMock();
        $event->expects($this->any())->method('name')->willReturn('something');
        $event->expects($this->any())->method('payload')->willReturn(new \stdClass());
        $event->expects($this->any())->method('triggeredAt')->willReturn(new \DateTimeImmutable());

        $first = $emitter->emit($event)->await();
        sort($first);
        self::assertSame(['bar', 'baz', 'foo'], array_values($first));

        $second = $emitter->emit($event)->await();
        sort($second);
        self::assertSame(['bar', 'foo'], array_values($second));
    }
}
