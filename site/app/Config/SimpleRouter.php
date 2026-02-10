<?php

declare(strict_types=1);

namespace App\Config;

use App\Controller\ErrorController;

/**
 * Router simples baseado em convenção sobre configuração
 * 
 * Mapeia URLs automaticamente para controllers e métodos:
 * /admin/{entidade}/{acao} -> {Entidade}Controller::{metodo}()
 */
class SimpleRouter
{
	/**
	 * Mapa de ações para métodos dos controllers
	 */
	private const ACTION_MAP = [
		'cadastrar' => 'add',
		'editar' => 'edit',
		'excluir' => 'delete',
		'listar' => 'list',
		'api' => 'getAll',
	];

	/**
	 * Processa a requisição atual
	 */
	public function dispatch(): void
	{
		$url = $_SERVER['REQUEST_URI'];

		// Remove query string
		$url = strtok($url, '?');

		// Extrai partes da URL
		$partes = explode('/', trim($url, '/'));

		// Espera formato: admin/{entidade}/{acao}
		if (count($partes) < 3) {
			$this->notFound();
			return;
		}

		$entidade = $partes[1] ?? '';
		$acao = $partes[2] ?? '';

		// Mapeia entidade para controller
		$controllerName = $this->getControllerName($entidade);

		// Mapeia ação para método
		$method = $this->getMethodName($acao);

		// Verifica se controller e método existem
		if (!$this->isValid($controllerName, $method)) {
			$this->notFound();
			return;
		}

		// Executa o controller
		$controller = new $controllerName();
		$controller->$method();
	}

	/**
	 * Converte nome da entidade para nome do controller
	 * Ex: "usuarios" -> "App\Controller\UsuarioController"
	 */
	private function getControllerName(string $entidade): string
	{
		// Remove 's' do plural (simplificação)
		$singular = rtrim($entidade, 's');

		// Capitaliza primeira letra
		$className = ucfirst($singular) . 'Controller';

		return "App\\Controller\\{$className}";
	}

	/**
	 * Converte ação para nome do método
	 * Ex: "cadastrar" -> "add"
	 */
	private function getMethodName(string $acao): string
	{
		return self::ACTION_MAP[$acao] ?? $acao;
	}

	/**
	 * Verifica se controller e método existem
	 */
	private function isValid(string $controller, string $method): bool
	{
		return class_exists($controller) && method_exists($controller, $method);
	}

	/**
	 * Retorna erro 404
	 */
	private function notFound(): void
	{
		(new ErrorController())->notFound();
	}
}
