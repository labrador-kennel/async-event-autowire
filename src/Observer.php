<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceGatherer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceWiringObserver;
use Labrador\AsyncEvent\Emitter;
use Labrador\AsyncEvent\Listener;

final class Observer extends ServiceWiringObserver {

    protected function wireServices(AnnotatedContainer $container, ServiceGatherer $gatherer) : void {
        $emitter = $container->get(Emitter::class);
        assert($emitter instanceof Emitter);

        foreach ($gatherer->getServicesWithAttribute(AutowiredListener::class) as $fromServiceDefinition) {
            $attribute = $fromServiceDefinition->getDefinition()->getAttribute();
            assert($attribute instanceof AutowiredListener);

            $emitter->register($attribute->eventName, $fromServiceDefinition->getService());
        }

        unset($listenerAndDefinition);
    }
}
