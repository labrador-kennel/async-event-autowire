<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Amp\PHPUnit\AsyncTestCase;
use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\Bootstrap;
use Cspray\AnnotatedContainer\ContainerFactory\PhpDiContainerFactory;
use Labrador\AsyncEvent\AmpEmitter;
use Labrador\AsyncEvent\Autowire\RegisterAutowiredListener;
use Labrador\AsyncEvent\Emitter;
use Labrador\AsyncEvent\Event;

/**
 * @covers \Labrador\AsyncEvent\Autowire\RegisterAutowiredListener
 */
class RegisterAutowiredListenerTest extends AsyncTestCase {

    private function getContainer() : AnnotatedContainer {
        $emitter = new \Cspray\AnnotatedContainer\Event\Emitter();
        $emitter->addListener(new RegisterAutowiredListener());
        return Bootstrap::fromAnnotatedContainerConventions(
            new PhpDiContainerFactory($emitter),
            $emitter
        )->bootstrapContainer();
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
