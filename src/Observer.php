<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\AnnotatedContainer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceGatherer;
use Cspray\AnnotatedContainer\Bootstrap\ServiceWiringObserver;
use Labrador\AsyncEvent\EventEmitter;
use Labrador\AsyncEvent\Listener;
use Labrador\AsyncEvent\ListenerProvider;
use Labrador\AsyncEvent\OneTimeListener;

final class Observer extends ServiceWiringObserver {

    protected function wireServices(AnnotatedContainer $container, ServiceGatherer $gatherer) : void {
        $emitter = $container->get(EventEmitter::class);
        assert($emitter instanceof EventEmitter);

        /** @var Listener $listener */
        foreach ($gatherer->getServicesForType(Listener::class) as $listenerAndDefinition) {
            $listener = $listenerAndDefinition->getService();
            $autowire = $listenerAndDefinition->getDefinition()->getAttribute();

            assert($listener instanceof Listener);

            if ($autowire instanceof ListenerService &&
                    $autowire->getListenerRemoval() === ListenerRemoval::AfterOneEvent) {
                $listener = new OneTimeListener($listener);
            }

            $emitter->register($listener);
        }

        unset($listenerAndDefinition);

        foreach ($gatherer->getServicesForType(ListenerProvider::class) as $providerAndDefinition) {
            $provider = $providerAndDefinition->getService();
            $autowire = $providerAndDefinition->getDefinition()->getAttribute();

            assert($provider instanceof ListenerProvider);

            if ($autowire instanceof ListenerService &&
                $autowire->getListenerRemoval() === ListenerRemoval::AfterOneEvent) {
                $provider = new class($provider) implements ListenerProvider {

                    public function __construct(
                        private readonly ListenerProvider $provider
                    ) {}

                    public function getListener() : Listener {
                        return new OneTimeListener($this->provider->getListener());
                    }

                };
            }

            $emitter->register($provider);
        }
    }
}
