<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests\Stub;

use Amp\Future;
use Labrador\AsyncEvent\AbstractListenerProvider;
use Labrador\AsyncEvent\Autowire\ListenerRemoval;
use Labrador\AsyncEvent\Autowire\ListenerService;
use Labrador\AsyncEvent\StandardEvent;

#[ListenerService(ListenerRemoval::AfterOneEvent)]
final class ZeeListenerProvider extends AbstractListenerProvider {

    public function __construct() {
        parent::__construct(
            ['something'],
            $this->handle(...)
        );
    }

    public function handle(StandardEvent $event) : Future {
        return Future::complete('zee');
    }

}