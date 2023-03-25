<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests\Stub;

use Amp\Future;
use Closure;
use Labrador\AsyncEvent\AbstractListenerProvider;
use Labrador\AsyncEvent\Autowire\ListenerService;
use Labrador\AsyncEvent\StandardEvent;

#[ListenerService]
final class QuxListenerProvider extends AbstractListenerProvider {

    public function __construct() {
        parent::__construct(
            ['something'],
            $this->handle(...)
        );
    }

    public function handle(StandardEvent $event) : Future {
        return Future::complete('qux');
    }

}
