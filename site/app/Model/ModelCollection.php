<?php

declare(strict_types=1);

namespace App\Model;

use App\Iterator\ModelIterator;
use App\Iterator\IteratorInterface;

/**
 * Classe ModelCollection
 * 
 * Representa uma coleção de models que pode ser iterada
 */
class ModelCollection
{
    /**
     * @var array Coleção de models
     */
    private array $models;

    /**
     * Construtor
     * 
     * @param array $models Array de models
     */
    public function __construct(array $models = [])
    {
        $this->models = $models;
    }

    /**
     * Adiciona um model à coleção
     * 
     * @param mixed $model
     * @return void
     */
    public function add($model): void
    {
        $this->models[] = $model;
    }

    /**
     * Remove um model da coleção
     * 
     * @param int $index
     * @return void
     */
    public function remove(int $index): void
    {
        if (isset($this->models[$index])) {
            unset($this->models[$index]);
            $this->models = array_values($this->models);
        }
    }

    /**
     * Retorna o model em uma posição específica
     * 
     * @param int $index
     * @return mixed|null
     */
    public function get(int $index): mixed
    {
        return $this->models[$index] ?? null;
    }

    /**
     * Retorna o número de models na coleção
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->models);
    }

    /**
     * Verifica se a coleção está vazia
     * 
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->models);
    }

    /**
     * Retorna todos os models como array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return $this->models;
    }

    /**
     * Cria e retorna um iterador para a coleção
     * 
     * @return IteratorInterface
     */
    public function getIterator(): IteratorInterface
    {
        return new ModelIterator($this->models);
    }

    /**
     * Aplica um filtro na coleção e retorna uma nova coleção filtrada
     * 
     * @param callable $callback
     * @return ModelCollection
     */
    public function filter(callable $callback): ModelCollection
    {
        return new ModelCollection(array_filter($this->models, $callback));
    }

    /**
     * Aplica uma transformação em cada elemento da coleção
     * 
     * @param callable $callback
     * @return ModelCollection
     */
    public function map(callable $callback): ModelCollection
    {
        return new ModelCollection(array_map($callback, $this->models));
    }

    /**
     * Retorna o primeiro elemento da coleção
     * 
     * @return mixed|null
     */
    public function first(): mixed
    {
        return $this->models[0] ?? null;
    }

    /**
     * Retorna o último elemento da coleção
     * 
     * @return mixed|null
     */
    public function last(): mixed
    {
        return end($this->models) ?: null;
    }
}
