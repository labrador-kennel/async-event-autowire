<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProvider as AnnotatedContainerDefinitionProvider;
use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProviderContext;
use Labrador\AsyncEvent\AmpEmitter;
use Labrador\AsyncEvent\Emitter;
use function Cspray\AnnotatedContainer\service;
use function Cspray\Typiphy\objectType;

class DefinitionProvider implements AnnotatedContainerDefinitionProvider {

    public function consume(DefinitionProviderContext $context) : void {
        service($context, objectType(Emitter::class));
        service($context, objectType(AmpEmitter::class));
    }

}
