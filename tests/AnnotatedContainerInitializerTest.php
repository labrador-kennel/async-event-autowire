<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Labrador\AsyncEvent\Autowire\Initializer;
use Labrador\AsyncEvent\Autowire\Observer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Labrador\AsyncEvent\Autowire\Initializer
 */
final class AnnotatedContainerInitializerTest extends TestCase {

    public function testGetPackageName() : void {
        $actual = (new Initializer())->getPackageName();

        self::assertSame('labrador-kennel/async-event', $actual);
    }

    public function testGetScanDirectories() : void {
        $actual = (new Initializer())->getRelativeScanDirectories();

        self::assertSame(['src'], $actual);
    }

    public function testGetObservers() : void {
        $actual = (new Initializer())->getObserverClasses();

        self::assertSame([Observer::class], $actual);
    }

    public function testGetDefinitionProvider() : void {
        $actual = (new Initializer())->getDefinitionProviderClass();

        self::assertNull($actual);
    }
}
