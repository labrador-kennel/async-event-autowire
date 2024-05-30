<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire\Tests\Stub;

use Amp\Future;
use Labrador\AsyncEvent\Autowire\AutowiredListener;
use Labrador\AsyncEvent\Event;
use Labrador\AsyncEvent\Listener;
use Labrador\CompositeFuture\CompositeFuture;

#[AutowiredListener('something')]
final class BarListener implements Listener {

    public function handle(Event $event) : Future|CompositeFuture|null {
        return Future::complete('bar');
    }

}
