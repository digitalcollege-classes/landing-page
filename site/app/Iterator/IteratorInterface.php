<?php

declare(strict_types=1);

namespace App\Iterator;

/**
 * Interface Iterator
 * 
 * Define a interface para percorrer uma coleção de elementos
 */
interface IteratorInterface
{
    /**
     * Retorna o elemento atual da coleção
     * 
     * @return mixed
     */
    public function current(): mixed;

    /**
     * Move o ponteiro interno para o próximo elemento
     * 
     * @return void
     */
    public function next(): void;

    /**
     * Retorna a chave do elemento atual
     * 
     * @return int
     */
    public function key(): int;

    /**
     * Verifica se a posição atual é válida
     * 
     * @return bool
     */
    public function valid(): bool;

    /**
     * Reinicia o iterador para o início
     * 
     * @return void
     */
    public function rewind(): void;
}
