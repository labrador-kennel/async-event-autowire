<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Amp\PHPUnit\AsyncTestCase;
use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\Bootstrap;
use Labrador\AsyncEvent\AmpEventEmitter;
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

        $emitter = $container->get(EventEmitter::class);

        self::assertInstanceOf(AmpEventEmitter::class, $emitter);
        self::assertCount(5, $emitter->getListeners('something'));
    }

    public function testOneTimeRemovalRespected() : void {
        $container = $this->getContainer();

        $emitter = $container->get(EventEmitter::class);

        self::assertInstanceOf(AmpEventEmitter::class, $emitter);

        $first = $emitter->emit(new StandardEvent('something', new \stdClass()))->await();
        sort($first);
        self::assertSame(['bar', 'baz', 'foo', 'qux', 'zee'], array_values($first));

        $second = $emitter->emit(new StandardEvent('something', new \stdClass()))->await();
        sort($second);
        self::assertSame(['bar', 'foo', 'qux'], array_values($second));
    }
}
