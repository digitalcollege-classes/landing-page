# 🏗️ Padrão Builder - Guia de Implementação

## 📋 Índice

- [O que é o Padrão Builder?](#o-que-é-o-padrão-builder)
- [Benefícios da Aplicação](#benefícios-da-aplicação)
- [Quando Usar](#quando-usar)
- [Quando NÃO Usar](#quando-não-usar)
- [Oportunidades no Projeto](#oportunidades-no-projeto)
- [Guia de Implementação](#guia-de-implementação)
- [Exemplos Práticos](#exemplos-práticos)
- [Checklist de Implementação](#checklist-de-implementação)

---

## 🎯 O que é o Padrão Builder?

O **Builder Pattern** é um padrão de design criacional que permite construir objetos complexos passo a passo. Ele separa a construção de um objeto complexo de sua representação, permitindo que o mesmo processo de construção crie diferentes representações.

### Problema que Resolve

```php
// ❌ SEM Builder: Código confuso e propenso a erros
$patrocinador = new Patrocinadores();
$patrocinador->nome = $_POST['nome'];
$patrocinador->descricao = $_POST['descricao'];
$patrocinador->tipoPatrocinio = $_POST['tipo'];
$patrocinador->urlLogo = $_POST['logo'];
$patrocinador->urlFacebook = $_POST['facebook'];
$patrocinador->urlInstagram = $_POST['instagram'];
$patrocinador->urlWebSite = $_POST['website'];
// E se esquecermos um campo? Objeto em estado inválido!
```

```php
// ✅ COM Builder: Fluente, validado e seguro
$patrocinador = PatrocinadorBuilder::create()
    ->withNome($_POST['nome'])
    ->withDescricao($_POST['descricao'])
    ->withTipoPatrocinio($_POST['tipo'])
    ->withLogo($_POST['logo'])
    ->withRedesSociais(
        facebook: $_POST['facebook'],
        instagram: $_POST['instagram'],
        website: $_POST['website']
    )
    ->build(); // ← Valida antes de criar
```

---

## ✨ Benefícios da Aplicação

### 1. 🎨 **Código Mais Legível**

**Antes:**
```php
$sql = "SELECT * FROM usuarios WHERE email = ? AND status = ? AND created_at > ? ORDER BY nome ASC LIMIT 10";
```

**Depois:**
```php
Usuario::query()
    ->where('email', '=', $email)
    ->where('status', '=', 'active')
    ->where('created_at', '>', $date)
    ->orderBy('nome', 'ASC')
    ->limit(10)
    ->get();
```

### 2. 🔒 **Validação Automática**

O Builder pode validar dados durante a construção:

```php
$usuario = UsuarioBuilder::create()
    ->withNome('')  // ← Builder lança exceção: nome obrigatório
    ->withEmail('email-invalido')  // ← Builder lança exceção: email inválido
    ->build();
```

### 3. 🛡️ **Objetos Sempre em Estado Válido**

Evita objetos parcialmente construídos:

```php
// ❌ Problema: Objeto em estado inválido
$patrocinador = new Patrocinadores();
$patrocinador->nome = 'Empresa X';
// Esquecemos outros campos obrigatórios!
$patrocinador->insert(); // ← Erro no banco

// ✅ Com Builder: build() só retorna se TUDO estiver válido
$patrocinador = PatrocinadorBuilder::create()
    ->withNome('Empresa X')
    ->build(); // ← Exceção: campos obrigatórios faltando
```

### 4. 🔄 **Reutilização de Código**

```php
// Criar uma base comum e reutilizar
$queryBase = Usuario::query()
    ->where('status', '=', 'active')
    ->where('deleted_at', 'IS NULL');

// Reutilizar em diferentes contextos
$admins = $queryBase->where('role', '=', 'admin')->get();
$users = $queryBase->where('role', '=', 'user')->limit(50)->get();
```

### 5. 🧪 **Facilita Testes**

```php
// Criar objetos de teste facilmente
$usuarioTeste = UsuarioBuilder::create()
    ->withNome('João Teste')
    ->withEmail('joao@teste.com')
    ->withSenha('senha123')
    ->build();
```

### 6. 📝 **Documentação Viva**

O código se auto-documenta:

```php
// Fica claro o que cada método faz
Schema::create('produtos')
    ->id()                          // ← Cria ID auto-incremento
    ->string('nome', 255)           // ← VARCHAR(255)
    ->decimal('preco', 10, 2)       // ← DECIMAL(10,2)
    ->text('descricao')             // ← TEXT
    ->timestamps()                  // ← created_at, updated_at
    ->execute();
```

### 7. 🚀 **Manutenibilidade**

Mudanças ficam centralizadas no Builder:

```php
// Adicionar validação de CPF em um único lugar
class UsuarioBuilder
{
    public function withCpf(string $cpf): self
    {
        if (!$this->validarCpf($cpf)) {
            throw new InvalidArgumentException('CPF inválido');
        }
        $this->cpf = $cpf;
        return $this;
    }
}
```

### 8. 💡 **Autocomplete no IDE**

IDEs modernos oferecem autocomplete para métodos do Builder:

```php
$usuario->with... // ← IDE sugere: withNome(), withEmail(), withSenha()
```

---

## 🎯 Quando Usar

### ✅ Use Builder Quando:

1. **Objetos com Muitos Parâmetros** (> 4)
   ```php
   // Difícil de lembrar a ordem
   new Patrocinador('Nome', 'Desc', 'Tipo', 'Logo', 'FB', 'IG', 'Web');
   
   // Claro e explícito
   PatrocinadorBuilder::create()
       ->withNome('Nome')
       ->withDescricao('Desc')
       // ...
   ```

2. **Parâmetros Opcionais**
   ```php
   Usuario::query()
       ->where('status', '=', 'active')
       ->limit(10);  // ← orderBy é opcional
   ```

3. **Processo de Criação Complexo**
   ```php
   MigrationBuilder::createTable('users')
       ->addPrimaryKey()
       ->addTimestamps()
       ->addSoftDeletes()
       ->addIndexes(['email', 'status']);
   ```

4. **Validação Durante Construção**
   ```php
   UsuarioBuilder::create()
       ->withEmail($email)  // ← Valida formato
       ->withCpf($cpf)      // ← Valida CPF
       ->withSenha($senha)  // ← Valida complexidade
   ```

5. **Múltiplas Representações do Mesmo Objeto**
   ```php
   $queryBase = Usuario::query()->where('status', 'active');
   $adminQuery = clone $queryBase->where('role', 'admin');
   $userQuery = clone $queryBase->where('role', 'user');
   ```

---

## ⚠️ Quando NÃO Usar

### ❌ NÃO Use Builder Quando:

1. **Objetos Simples** (≤ 3 parâmetros)
   ```php
   // Não vale a pena
   new Categoria('nome', 'slug', 'ativo');
   
   // Builder seria overhead desnecessário
   CategoriaBuilder::create()->withNome()->withSlug()->withAtivo();
   ```

2. **Performance Crítica**
   - Builder adiciona overhead mínimo
   - Para loops de milhares de objetos, considere alternativas

3. **Objetos Imutáveis Simples**
   ```php
   // Value Object simples não precisa
   new Email('user@example.com');
   ```

---

## 🎯 Oportunidades no Projeto

### 1. Query Builder (Prioridade ALTA ⭐⭐⭐)

**Onde aplicar**: `AbstractModel` e todas as queries do banco

**Impacto**: Todo o sistema de banco de dados

**Exemplo**:
```php
// Atual
$result = $pdo->query("SELECT * FROM usuarios WHERE status = 'active'");

// Com Builder
$usuarios = Usuario::query()
    ->where('status', '=', 'active')
    ->orderBy('nome')
    ->get();
```

---

### 2. Model Builder (Prioridade ALTA ⭐⭐⭐)

**Onde aplicar**: `Patrocinadores`, `Usuario`, `Palestrante`

**Impacto**: Controllers e testes

**Exemplo**:
```php
// Atual
$patrocinador = new Patrocinadores();
$patrocinador->nome = $_POST['nome'];
$patrocinador->descricao = $_POST['descricao'];
// ... 5+ linhas

// Com Builder
$patrocinador = PatrocinadorBuilder::create()
    ->fromArray($_POST)
    ->validate()
    ->build();
```

---

### 3. Migration Builder (Prioridade MÉDIA ⭐⭐)

**Onde aplicar**: Sistema de migrations

**Impacto**: Criação de tabelas e migrations

**Exemplo**:
```php
// Atual
$sql = "CREATE TABLE produtos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL
)";

// Com Builder
Schema::create('produtos')
    ->id()
    ->string('nome')
    ->execute();
```

---

### 4. Response Builder (Prioridade MÉDIA ⭐⭐)

**Onde aplicar**: Métodos `getAll()` dos controllers

**Impacto**: APIs e respostas JSON

**Exemplo**:
```php
// Atual
header('Content-type: application/json');
echo json_encode($usuarios);

// Com Builder
Response::json()
    ->data($usuarios)
    ->status(200)
    ->send();
```

---

### 5. Validator Builder (Prioridade BAIXA ⭐)

**Onde aplicar**: Validação de formulários

**Impacto**: Validações nos controllers

**Exemplo**:
```php
// Atual
if (empty($_POST['nome'])) throw new Exception();

// Com Builder
Validator::make($_POST)
    ->required('nome')
    ->email('email')
    ->validate();
```

---

## 📚 Guia de Implementação

### Passo 1: Escolha o Builder a Implementar

**Recomendação**: Comece pelo **Query Builder**

**Motivo**:
- Maior impacto no projeto
- Usado em todos os Models
- Base para outros builders

---

### Passo 2: Crie a Estrutura Base

#### 2.1. Query Builder Base

```php
<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOStatement;

class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private array $wheres = [];
    private array $bindings = [];
    private ?string $orderBy = null;
    private ?int $limit = null;
    private ?int $offset = null;
    private array $selects = ['*'];
    
    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }
    
    /**
     * Define os campos a serem selecionados
     */
    public function select(array $columns): self
    {
        $this->selects = $columns;
        return $this;
    }
    
    /**
     * Adiciona condição WHERE
     */
    public function where(string $column, string $operator, mixed $value): self
    {
        $this->wheres[] = "{$column} {$operator} ?";
        $this->bindings[] = $value;
        return $this;
    }
    
    /**
     * Adiciona ORDER BY
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = "{$column} {$direction}";
        return $this;
    }
    
    /**
     * Adiciona LIMIT
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * Adiciona OFFSET
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * Constrói a query SQL
     */
    private function buildSql(): string
    {
        $sql = "SELECT " . implode(', ', $this->selects) . " FROM {$this->table}";
        
        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(' AND ', $this->wheres);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }
        
        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }
        
        if ($this->offset) {
            $sql .= " OFFSET {$this->offset}";
        }
        
        return $sql;
    }
    
    /**
     * Executa a query e retorna resultados
     */
    public function get(string $class = null): array
    {
        $sql = $this->buildSql();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        
        if ($class) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $class);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna primeiro resultado
     */
    public function first(string $class = null): ?array
    {
        $this->limit(1);
        $results = $this->get($class);
        
        return $results[0] ?? null;
    }
    
    /**
     * Conta registros
     */
    public function count(): int
    {
        $this->selects = ['COUNT(*) as total'];
        $result = $this->get();
        
        return (int) $result[0]['total'];
    }
}
```

---

### Passo 3: Integre com AbstractModel

```php
<?php

declare(strict_types=1);

namespace App\Model;

use App\Connection\DatabaseConnection;
use App\Database\QueryBuilder;

abstract class AbstractModel
{
    protected static string $table;

    /**
     * Retorna todos os registros
     */
    public static function all(): array
    {
        return static::query()->get(static::class);
    }
    
    /**
     * Inicia um Query Builder
     */
    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::db(), static::$table);
    }
    
    /**
     * Retorna conexão com banco
     */
    public static function db(): \PDO
    {
        return DatabaseConnection::open();
    }
}
```

---

### Passo 4: Use nos Models

```php
<?php

declare(strict_types=1);

namespace App\Model;

class Usuario extends AbstractModel
{
    protected static string $table = 'usuarios';

    public int $id;
    public string $nome;
    public string $email;
    public string $senha;
    
    /**
     * Busca usuários ativos
     */
    public static function ativos(): array
    {
        return static::query()
            ->where('status', '=', 'active')
            ->orderBy('nome', 'ASC')
            ->get(static::class);
    }
    
    /**
     * Busca usuário por email
     */
    public static function findByEmail(string $email): ?self
    {
        return static::query()
            ->where('email', '=', $email)
            ->first(static::class);
    }
    
    /**
     * Busca usuários com paginação
     */
    public static function paginate(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        return static::query()
            ->limit($perPage)
            ->offset($offset)
            ->get(static::class);
    }
}
```

---

### Passo 5: Use nos Controllers

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Usuario;

class UsuarioController extends AbstractController
{
    public function list(): void
    {
        // Busca usuários ativos ordenados
        $usuarios = Usuario::query()
            ->where('status', '=', 'active')
            ->orderBy('nome', 'ASC')
            ->limit(50)
            ->get(Usuario::class);

        $this->view('usuarios/list', [
            'usuarios' => $usuarios,
        ]);
    }
    
    public function search(): void
    {
        $termo = $_GET['q'] ?? '';
        
        // Busca por nome ou email
        $usuarios = Usuario::query()
            ->where('nome', 'LIKE', "%{$termo}%")
            ->orWhere('email', 'LIKE', "%{$termo}%")
            ->limit(20)
            ->get(Usuario::class);

        $this->view('usuarios/search', [
            'usuarios' => $usuarios,
            'termo' => $termo,
        ]);
    }
}
```

---

## 💼 Exemplos Práticos

### Exemplo 1: Model Builder para Patrocinadores

```php
<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Patrocinadores;
use InvalidArgumentException;

class PatrocinadorBuilder
{
    private ?string $nome = null;
    private ?string $descricao = null;
    private ?string $tipoPatrocinio = null;
    private ?string $urlLogo = null;
    private ?string $urlFacebook = null;
    private ?string $urlInstagram = null;
    private ?string $urlWebSite = null;
    
    public static function create(): self
    {
        return new self();
    }
    
    public function withNome(string $nome): self
    {
        if (empty($nome)) {
            throw new InvalidArgumentException('Nome é obrigatório');
        }
        $this->nome = $nome;
        return $this;
    }
    
    public function withDescricao(string $descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }
    
    public function withTipoPatrocinio(string $tipo): self
    {
        $tiposValidos = ['ouro', 'prata', 'bronze'];
        
        if (!in_array(strtolower($tipo), $tiposValidos)) {
            throw new InvalidArgumentException('Tipo de patrocínio inválido');
        }
        
        $this->tipoPatrocinio = $tipo;
        return $this;
    }
    
    public function withLogo(string $url): self
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('URL do logo inválida');
        }
        $this->urlLogo = $url;
        return $this;
    }
    
    public function withRedesSociais(
        ?string $facebook = null,
        ?string $instagram = null,
        ?string $website = null
    ): self {
        $this->urlFacebook = $facebook;
        $this->urlInstagram = $instagram;
        $this->urlWebSite = $website;
        return $this;
    }
    
    public function fromArray(array $data): self
    {
        if (isset($data['nome'])) {
            $this->withNome($data['nome']);
        }
        
        if (isset($data['descricao'])) {
            $this->withDescricao($data['descricao']);
        }
        
        if (isset($data['tipo'])) {
            $this->withTipoPatrocinio($data['tipo']);
        }
        
        if (isset($data['logo'])) {
            $this->withLogo($data['logo']);
        }
        
        $this->withRedesSociais(
            facebook: $data['facebook'] ?? null,
            instagram: $data['instagram'] ?? null,
            website: $data['website'] ?? null
        );
        
        return $this;
    }
    
    public function build(): Patrocinadores
    {
        // Valida campos obrigatórios
        if (!$this->nome) {
            throw new InvalidArgumentException('Nome é obrigatório');
        }
        
        $patrocinador = new Patrocinadores();
        $patrocinador->nome = $this->nome;
        $patrocinador->descricao = $this->descricao ?? '';
        $patrocinador->tipoPatrocinio = $this->tipoPatrocinio ?? 'bronze';
        $patrocinador->urlLogo = $this->urlLogo ?? '';
        $patrocinador->urlFacebook = $this->urlFacebook ?? '';
        $patrocinador->urlInstagram = $this->urlInstagram ?? '';
        $patrocinador->urlWebSite = $this->urlWebSite ?? '';
        
        return $patrocinador;
    }
}
```

**Uso no Controller**:

```php
public function add(): void
{
    if (empty($_POST)) {
        $this->view('patrocinadores/add');
        return;
    }
    
    try {
        $patrocinador = PatrocinadorBuilder::create()
            ->fromArray($_POST)
            ->build();
        
        $patrocinador->insert();
        
        echo "Patrocinador cadastrado com sucesso!";
    } catch (InvalidArgumentException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
```

---

### Exemplo 2: Response Builder

```php
<?php

declare(strict_types=1);

namespace App\Http;

class ResponseBuilder
{
    private mixed $data = null;
    private int $status = 200;
    private string $message = '';
    private array $errors = [];
    private array $headers = [];
    
    public static function json(): self
    {
        $instance = new self();
        $instance->headers['Content-Type'] = 'application/json';
        return $instance;
    }
    
    public function data(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }
    
    public function status(int $status): self
    {
        $this->status = $status;
        return $this;
    }
    
    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }
    
    public function errors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }
    
    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }
    
    public function send(): void
    {
        http_response_code($this->status);
        
        foreach ($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
        
        $response = [
            'success' => $this->status >= 200 && $this->status < 300,
            'status' => $this->status,
        ];
        
        if ($this->message) {
            $response['message'] = $this->message;
        }
        
        if ($this->data !== null) {
            $response['data'] = $this->data;
        }
        
        if (!empty($this->errors)) {
            $response['errors'] = $this->errors;
        }
        
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
```

**Uso no Controller**:

```php
public function getAll(): void
{
    $usuarios = Usuario::query()
        ->where('status', '=', 'active')
        ->get(Usuario::class);

    ResponseBuilder::json()
        ->data($usuarios)
        ->status(200)
        ->message('Usuários recuperados com sucesso')
        ->send();
}
```

---

## ✅ Checklist de Implementação

### Query Builder

- [ ] Criar classe `QueryBuilder` em `site/app/Database/`
- [ ] Implementar métodos: `select()`, `where()`, `orderBy()`, `limit()`, `offset()`
- [ ] Implementar métodos de execução: `get()`, `first()`, `count()`
- [ ] Adicionar método `query()` em `AbstractModel`
- [ ] Testar com `Usuario::query()->where()->get()`
- [ ] Adicionar suporte a `JOIN`
- [ ] Adicionar suporte a `GROUP BY`
- [ ] Adicionar suporte a `HAVING`
- [ ] Documentar uso no README

### Model Builder

- [ ] Criar pasta `site/app/Builder/`
- [ ] Criar `PatrocinadorBuilder` como exemplo
- [ ] Implementar validações nos métodos `with*()`
- [ ] Implementar método `fromArray()`
- [ ] Implementar método `build()`
- [ ] Atualizar `PatrocinadorController` para usar Builder
- [ ] Criar Builders para outros Models conforme necessário
- [ ] Escrever testes

### Migration Builder

- [ ] Criar classe `SchemaBuilder`
- [ ] Implementar métodos de colunas: `id()`, `string()`, `integer()`, etc
- [ ] Implementar método `execute()`
- [ ] Atualizar template do `create-migration.php`
- [ ] Documentar uso

### Response Builder

- [ ] Criar classe `ResponseBuilder` em `site/app/Http/`
- [ ] Implementar métodos: `data()`, `status()`, `message()`, `errors()`
- [ ] Implementar método `send()`
- [ ] Atualizar controllers para usar ResponseBuilder
- [ ] Padronizar formato de resposta JSON

---

## 📖 Recursos Adicionais

### Livros
- **"Design Patterns: Elements of Reusable Object-Oriented Software"** - Gang of Four
- **"Head First Design Patterns"** - Eric Freeman

### Artigos
- [Refactoring.Guru - Builder Pattern](https://refactoring.guru/design-patterns/builder)
- [SourceMaking - Builder Pattern](https://sourcemaking.com/design_patterns/builder)

### Vídeos
- Procure por "Builder Pattern PHP" no YouTube

---

## 🎯 Conclusão

O padrão Builder traz benefícios significativos para o projeto:

- ✅ **Código mais limpo e legível**
- ✅ **Validação automática**
- ✅ **Objetos sempre válidos**
- ✅ **Facilita testes**
- ✅ **Melhora manutenibilidade**

**Comece Agora**:
1. Implemente o **Query Builder** primeiro
2. Use em 2-3 Models como prova de conceito
3. Se funcionar bem, expanda para outros builders
4. Documente os padrões adotados

---

**Autor**: Documentação gerada para o projeto Landing Page Conference  
**Data**: Fevereiro 2026  
**Versão**: 1.0
