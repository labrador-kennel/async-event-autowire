<?php declare(strict_types=1);

namespace Labrador\AsyncEvent\Autowire;

use Cspray\AnnotatedContainer\Attribute\ServiceAttribute;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class AutowiredListener implements ServiceAttribute {

    /**
     * @param list<string> $profiles
     * @param string|null $name
     */
    public function __construct(
        public readonly string $eventName,
        private readonly array $profiles = [],
        private readonly ?string $name = null
    ) {
    }

    public function profiles() : array {
        return  $this->profiles;
    }

    public function isPrimary() : bool {
        return false;
    }

    public function name() : ?string {
        return $this->name;
    }
}
