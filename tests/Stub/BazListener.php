<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests\Stub;

use Amp\Future;
use Labrador\AsyncEvent\Autowire\AutowiredListener;
use Labrador\AsyncEvent\Event;
use Labrador\AsyncEvent\Listener;
use Labrador\AsyncEvent\ListenerRemovableBasedOnHandleCount;
use Labrador\CompositeFuture\CompositeFuture;

#[AutowiredListener('something')]
class BazListener implements Listener, ListenerRemovableBasedOnHandleCount {

    public function handle(Event $event) : Future|CompositeFuture|null {
        return Future::complete('baz');
    }

    public function handleLimit() : int {
        return 1;
    }
}
