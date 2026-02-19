<?php

declare(strict_types=1);

namespace App\Iterator;

/**
 * Classe ModelIterator
 * 
 * Implementação concreta do Iterator para percorrer coleções de Models
 */
class ModelIterator implements IteratorInterface
{
    /**
     * @var array Coleção de elementos
     */
    private array $collection;

    /**
     * @var int Posição atual do iterador
     */
    private int $position = 0;

    /**
     * Construtor
     * 
     * @param array $collection Coleção de elementos a ser iterada
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
        $this->position = 0;
    }

    /**
     * Retorna o elemento atual da coleção
     * 
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    /**
     * Move o ponteiro interno para o próximo elemento
     * 
     * @return void
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Retorna a chave do elemento atual
     * 
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Verifica se a posição atual é válida
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    /**
     * Reinicia o iterador para o início
     * 
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Retorna o número total de elementos na coleção
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->collection);
    }
}
