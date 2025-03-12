<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceGatherer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceWiringListener;
use Labrador\AsyncEvent\Emitter;

final class RegisterAutowiredListener extends ServiceWiringListener {

    protected function wireServices(AnnotatedContainer $container, ServiceGatherer $gatherer) : void {
        $emitter = $container->get(Emitter::class);
        assert($emitter instanceof Emitter);

        foreach ($gatherer->servicesWithAttribute(AutowiredListener::class) as $fromServiceDefinition) {
            $attribute = $fromServiceDefinition->definition()->attribute();
            assert($attribute instanceof AutowiredListener);

            $emitter->register($attribute->eventName, $fromServiceDefinition->service());
        }

        unset($listenerAndDefinition);
    }
}
