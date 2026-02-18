# Padrão Builder — Onde aplicar neste projeto

## O que é o padrão Builder?

O Builder separa a **construção** de um objeto complexo da sua **representação**.
Em vez de atribuir propriedades uma a uma (ou passar um construtor com muitos
parâmetros), você usa uma classe auxiliar que acumula os dados e entrega o
objeto pronto via `build()`.

```
Client  →  Builder (setters encadeados)  →  build()  →  Product (Model)
```

### Quando vale a pena usar?

| Situação | Justificativa |
|---|---|
| Objeto com muitas propriedades | Evita longas atribuições espalhadas |
| Propriedades opcionais | Defaults centralizados no builder, não no model |
| Lógica na criação | Ex: hash de senha, formatação de URL, geração de slug |
| Testes | Facilita criar objetos de fixture com valores controlados |

---

## Mapa do projeto

```
app/Model/
├── AbstractModel.php     — base de todos os models
├── Usuario.php           — 4 campos + lógica de hash de senha  ← ALTA prioridade
├── Palestrante.php       — 3 campos                            ← MÉDIA prioridade
├── Palestra.php          — 4 campos                            ← MÉDIA prioridade
└── Patrocinadores.php    — 7 campos (3 opcionais)              ← JÁ IMPLEMENTADO
```

---

## 1. `Patrocinadores` — JÁ IMPLEMENTADO

**Arquivo:** [`app/Builder/PatrocinadoresBuilder.php`](../app/Builder/PatrocinadoresBuilder.php)

**Por que foi o primeiro candidato?**
Tem 7 propriedades, sendo 3 opcionais (`urlFacebook`, `urlInstagram`, `urlWebSite`).
Sem o builder, qualquer criação manual obriga a preencher todos os campos mesmo
que estejam vazios.

### Sem o builder

```php
$p = new Patrocinadores();
$p->nome           = 'Ypioca';
$p->descricao      = 'Fábrica do líquido sagrado';
$p->tipoPatrocinio = 'Ouro';
$p->urlLogo        = 'https://...';
$p->urlFacebook    = '';   // precisa setar mesmo vazio
$p->urlInstagram   = '';   // precisa setar mesmo vazio
$p->urlWebSite     = '';   // precisa setar mesmo vazio
```

### Com o builder

```php
use App\Builder\PatrocinadoresBuilder;

$patrocinador = (new PatrocinadoresBuilder())
    ->setNome('Ypioca')
    ->setDescricao('Fábrica do líquido sagrado')
    ->setTipoPatrocinio('Ouro')
    ->setUrlLogo('https://br.thebar.com/ypioca...')
    ->setUrlFacebook('https://www.facebook.com/ypiocaoficialbr')
    ->setUrlInstagram('https://www.instagram.com/ypiocaoficialbr/')
    ->setUrlWebSite('https://www.br.thebar.com/')
    ->build();
```

Patrocinador sem redes sociais — os campos opcionais ficam com `''` por padrão:

```php
$patrocinador = (new PatrocinadoresBuilder())
    ->setNome('Patrocinador Anônimo')
    ->setDescricao('Contribuidor master')
    ->setTipoPatrocinio('Prata')
    ->setUrlLogo('https://...')
    ->build(); // urlFacebook, urlInstagram, urlWebSite ficam ''
```

---

## 2. `Usuario` — ALTA PRIORIDADE

**Model:** [`app/Model/Usuario.php`](../app/Model/Usuario.php)

**Por que é prioridade alta?**
O `UsuarioController` mistura responsabilidades: lê `$_POST`, faz hash da senha
e salva — tudo no mesmo método. O builder centralizaria a **lógica de criação**
(incluindo o `password_hash`) fora do controller.

### Problema atual em `UsuarioController::add()`

```php
// app/Controller/UsuarioController.php — linhas 18-23
$usuario = new Usuario();
$usuario->nome  = $_POST['nome'];
$usuario->email = $_POST['email'];
$usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // lógica aqui!

$usuario->insert();
```

O `password_hash` está no controller — se um segundo lugar criar um `Usuario`
(ex: API, CLI, teste), a lógica precisará ser duplicada.

### Builder proposto: `UsuarioBuilder`

**Caminho sugerido:** `app/Builder/UsuarioBuilder.php`

```php
<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Usuario;

class UsuarioBuilder
{
    private string $nome;
    private string $email;
    private string $senhaHash;
    private string $endereco = '';

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // O builder encapsula o password_hash — o controller não precisa saber disso
    public function setSenha(string $senhaEmTexto): static
    {
        $this->senhaHash = password_hash($senhaEmTexto, PASSWORD_DEFAULT);
        return $this;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function build(): Usuario
    {
        $usuario          = new Usuario();
        $usuario->nome    = $this->nome;
        $usuario->email   = $this->email;
        $usuario->senha   = $this->senhaHash;
        $usuario->endereco = $this->endereco;

        return $usuario;
    }
}
```

### Controller simplificado com o builder

```php
// UsuarioController::add() — depois do builder
$usuario = (new UsuarioBuilder())
    ->setNome($_POST['nome'])
    ->setEmail($_POST['email'])
    ->setSenha($_POST['senha'])  // hash feito dentro do builder
    ->build();

$usuario->insert();
```

**Ganho:** o controller deixa de conhecer `PASSWORD_DEFAULT`. Se a estratégia
de hash mudar, só o `UsuarioBuilder` precisa ser alterado.

---

## 3. `Palestrante` — MÉDIA PRIORIDADE

**Model:** [`app/Model/Palestrante.php`](../app/Model/Palestrante.php)

**Por que é média prioridade?**
Apenas 3 campos obrigatórios (`nome`, `email`, `especialidade`). O ganho imediato
é menor, mas o builder se justifica conforme o model crescer (foto, bio, redes
sociais de palestrantes, etc.) e para padronizar a forma de criar objetos no projeto.

### Builder proposto: `PalestranteBuilder`

**Caminho sugerido:** `app/Builder/PalestranteBuilder.php`

```php
<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Palestrante;

class PalestranteBuilder
{
    private string $nome;
    private string $email;
    private string $especialidade;

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setEspecialidade(string $especialidade): static
    {
        $this->especialidade = $especialidade;
        return $this;
    }

    public function build(): Palestrante
    {
        $palestrante                = new Palestrante();
        $palestrante->nome          = $this->nome;
        $palestrante->email         = $this->email;
        $palestrante->especialidade = $this->especialidade;

        return $palestrante;
    }
}
```

### Uso

```php
$palestrante = (new PalestranteBuilder())
    ->setNome('Ada Lovelace')
    ->setEmail('ada@example.com')
    ->setEspecialidade('Algoritmos')
    ->build();
```

---

## 4. `Palestra` — MÉDIA PRIORIDADE

**Model:** [`app/Model/Palestra.php`](../app/Model/Palestra.php)

**Por que é média prioridade?**
4 campos obrigatórios. O builder começa a valer mais quando a `Palestra` precisar
vincular o `Palestrante` por ID/objeto — evitando inconsistências de tipo.

### Builder proposto: `PalestraBuilder`

**Caminho sugerido:** `app/Builder/PalestraBuilder.php`

```php
<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Palestra;

class PalestraBuilder
{
    private string $titulo;
    private string $palestrante;
    private string $descricao;
    private string $horario;

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setPalestrante(string $palestrante): static
    {
        $this->palestrante = $palestrante;
        return $this;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setHorario(string $horario): static
    {
        $this->horario = $horario;
        return $this;
    }

    public function build(): Palestra
    {
        $palestra              = new Palestra();
        $palestra->titulo      = $this->titulo;
        $palestra->palestrante = $this->palestrante;
        $palestra->descricao   = $this->descricao;
        $palestra->horario     = $this->horario;

        return $palestra;
    }
}
```

### Uso

```php
$palestra = (new PalestraBuilder())
    ->setTitulo('Clean Architecture na prática')
    ->setPalestrante('Ada Lovelace')
    ->setDescricao('Como estruturar projetos PHP sem frameworks pesados')
    ->setHorario('10:00')
    ->build();
```

---

## Resumo: mapa de implementação

| Prioridade | Builder | Model | Motivação principal |
|---|---|---|---|
| Feito | `PatrocinadoresBuilder` | `Patrocinadores` | 7 campos, 3 opcionais |
| Alta | `UsuarioBuilder` | `Usuario` | Centraliza `password_hash` |
| Média | `PalestranteBuilder` | `Palestrante` | Padronização, escalabilidade |
| Média | `PalestraBuilder` | `Palestra` | Padronização, escalabilidade |

## Estrutura final da pasta `Builder`

```
app/Builder/
├── PatrocinadoresBuilder.php   ← implementado
├── UsuarioBuilder.php          ← próximo passo recomendado
├── PalestranteBuilder.php
└── PalestraBuilder.php
```

---

## Convenções adotadas neste projeto

- Todos os setters retornam `static` para suportar herança e encadeamento
- Campos opcionais recebem valor padrão (`''`) na declaração da propriedade do builder
- Lógica de criação (ex: hash, formatação) fica **no builder**, nunca no controller
- O `build()` sempre retorna o tipo concreto do model (`Patrocinadores`, `Usuario`, etc.)
