<?php

declare(strict_types=1);

namespace App\Iterator;

/**
 * Interface IteratorAggregate
 * 
 * Define a interface para objetos que podem criar iteradores
 */
interface IteratorAggregateInterface
{
    /**
     * Cria e retorna um iterador para a coleção
     * 
     * @return IteratorInterface
     */
    public function getIterator(): IteratorInterface;
}
