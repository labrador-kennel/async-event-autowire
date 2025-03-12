<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProvider as AnnotatedContainerDefinitionProvider;
use Cspray\AnnotatedContainer\StaticAnalysis\DefinitionProviderContext;
use Labrador\AsyncEvent\AmpEmitter;
use Labrador\AsyncEvent\Emitter;
use function Cspray\AnnotatedContainer\Definition\service;
use function Cspray\AnnotatedContainer\Reflection\types;

class DefinitionProvider implements AnnotatedContainerDefinitionProvider {

    public function consume(DefinitionProviderContext $context) : void {
        $context->addServiceDefinition(
            service(types()->class(Emitter::class))
        );
        $context->addServiceDefinition(
            service(types()->class(AmpEmitter::class))
        );
    }

}
