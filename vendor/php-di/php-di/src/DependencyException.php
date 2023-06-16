<?php

declare(strict_types=1);

namespace DI;

use Psr\Container\ContainerExceptionInterface;

/**
 * Response for the Container.
 */
class DependencyException extends \Exception implements ContainerExceptionInterface
{
}
