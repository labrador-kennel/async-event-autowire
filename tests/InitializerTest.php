<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Labrador\AsyncEvent\Autowire\DefinitionProvider;
use Labrador\AsyncEvent\Autowire\Initializer;
use Labrador\AsyncEvent\Autowire\RegisterAutowiredListener;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Labrador\AsyncEvent\Autowire\Initializer
 */
final class InitializerTest extends TestCase {

    public function testGetPackageName() : void {
        $actual = (new Initializer())->packageName();

        self::assertSame('labrador-kennel/async-event', $actual);
    }

    public function testGetScanDirectories() : void {
        $actual = (new Initializer())->relativeScanDirectories();

        self::assertEmpty($actual);
    }

    public function testGetDefinitionProvider() : void {
        $actual = (new Initializer())->definitionProviderClass();

        self::assertSame(DefinitionProvider::class, $actual);
    }
}
