<?php

namespace App\Middleware;

abstract class AbstractMiddleware
{
    protected ?AbstractMiddleware $next = null;

    public function setNext(AbstractMiddleware $next): AbstractMiddleware
    {
        $this->next = $next;
        return $next;
    }

    public function handle(array $request): bool
    {
        if ($this->next) {
            return $this->next->handle($request);
        }

        return true;
    }
}