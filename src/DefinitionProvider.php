<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProvider as AnnotatedContainerDefinitionProvider;
use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProviderContext;
use Labrador\AsyncEvent\AmpEventEmitter;
use Labrador\AsyncEvent\EventEmitter;
use Labrador\AsyncEvent\EventFactory;
use Labrador\AsyncEvent\StandardEventFactory;
use function Cspray\AnnotatedContainer\service;
use function Cspray\Typiphy\objectType;

class DefinitionProvider implements AnnotatedContainerDefinitionProvider {

    public function consume(DefinitionProviderContext $context) : void {
        service($context, objectType(EventEmitter::class));
        service($context, objectType(AmpEventEmitter::class));
        service($context, objectType(EventFactory::class));
        service($context, objectType(StandardEventFactory::class));
    }

}
