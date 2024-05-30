<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Labrador\AsyncEvent\Autowire\AutowiredListener;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Labrador\AsyncEvent\Autowire\AutowiredListener
 */
class ListenerServiceTest extends TestCase {

    public function testProfilesDefaultsToEmpty() : void {
        $subject = new AutowiredListener('event-name');

        self::assertSame([], $subject->getProfiles());
    }

    public function testProfilesRespectsProvidedValues() : void {
        $subject = new AutowiredListener('event-name', profiles: ['foo', 'bar']);

        self::assertSame(['foo', 'bar'], $subject->getProfiles());
    }

    public function testNameDefaultsToNull() : void {
        $subject = new AutowiredListener('event-name');

        self::assertNull($subject->getName());
    }

    public function testNameRespectsProvidedValue() : void {
        $subject = new AutowiredListener('event-name', name: 'my-listener');

        self::assertSame('my-listener', $subject->getName());
    }

    public function testIsPrimaryAlwaysFalse() : void {
        $subject = new AutowiredListener('event-name');

        self::assertFalse($subject->isPrimary());
    }
}
