<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests;

use Cspray\AnnotatedContainer\Definition\ContainerDefinitionBuilder;
use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProviderContext;
use Labrador\AsyncEvent\AmpEventEmitter;
use Labrador\AsyncEvent\Autowire\DefinitionProvider;
use Labrador\AsyncEvent\EventEmitter;
use Labrador\AsyncEvent\EventFactory;
use Labrador\AsyncEvent\StandardEventFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Labrador\AsyncEvent\Autowire\DefinitionProvider
 */
class DefinitionProviderTest extends TestCase {

    private ContainerDefinitionBuilder $builder;
    private DefinitionProvider $subject;
    private DefinitionProviderContext $context;

    protected function setUp() : void {
        $this->builder = ContainerDefinitionBuilder::newDefinition();
        $this->subject = new DefinitionProvider();
        $this->context = new class implements DefinitionProviderContext {
            private ContainerDefinitionBuilder $builder;

            public function getBuilder() : ContainerDefinitionBuilder {
                return $this->builder;
            }

            public function setBuilder(ContainerDefinitionBuilder $containerDefinitionBuilder) : void {
                $this->builder = $containerDefinitionBuilder;
            }
        };
        $this->context->setBuilder($this->builder);
    }

    private function doesContextHaveService(string $service) : bool {
        $hasService = false;
        foreach ($this->context->getBuilder()->getServiceDefinitions() as $serviceDefinition) {
            if ($serviceDefinition->getType()->getName() === $service) {
                $hasService = true;
                break;
            }
        }
        return $hasService;
    }

    public static function expectedServiceProvider() : array {
        return [
            EventEmitter::class => [EventEmitter::class],
            AmpEventEmitter::class => [AmpEventEmitter::class],
            EventFactory::class => [EventFactory::class],
            StandardEventFactory::class => [StandardEventFactory::class],
        ];
    }

    /**
     * @param string $service
     * @return void
     * @dataProvider expectedServiceProvider
     */
    public function testExpectedServiceAddedToDefinitions(string $service) : void {
        $this->subject->consume($this->context);

        self::assertTrue($this->doesContextHaveService($service));
    }

}