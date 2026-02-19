<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplos de Iterator Pattern</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        h2 {
            color: #4CAF50;
            margin-top: 30px;
        }
        .example {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .code {
            background: #f4f4f4;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 10px 0;
            overflow-x: auto;
        }
        .result {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .item {
            padding: 8px;
            margin: 5px 0;
            background: #fff;
            border-left: 3px solid #2196F3;
            padding-left: 15px;
        }
        .stats {
            background: #fff3e0;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            font-weight: bold;
        }
        pre {
            margin: 0;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <h1>🔄 Design Pattern: Iterator - Exemplos Práticos</h1>
    <p>Demonstração do padrão Iterator implementado no projeto</p>

    <?php
    require_once __DIR__ . '/../../../vendor/autoload.php';

    use App\Model\Palestra;
    use App\Model\Palestrante;
    use App\Model\Usuario;
    use App\Model\ModelCollection;

    try {
    ?>

    <!-- EXEMPLO 1: Iteração Básica -->
    <div class="example">
        <h2>📋 Exemplo 1: Iteração Básica com Iterator</h2>
        <p>Obtendo todas as palestras e iterando com o padrão Iterator:</p>
        
        <div class="code">
            <pre>
                $palestras = Palestra::allAsCollection();
                $iterator = $palestras->getIterator();

                $iterator->rewind();
                while ($iterator->valid()) {
                    $palestra = $iterator->current();
                    echo $palestra->titulo;
                    $iterator->next();
                }
            </pre>
        </div>

        <div class="result">
            <div class="stats">Total de palestras: <?php 
                $palestras = Palestra::allAsCollection();
                echo $palestras->count(); 
            ?></div>
            
            <?php
            $iterator = $palestras->getIterator();
            $iterator->rewind();
            while ($iterator->valid()) {
                $palestra = $iterator->current();
                echo "<div class='item'>";
                echo "<strong>{$palestra->titulo}</strong><br>";
                echo "Palestrante: {$palestra->palestrante} | Horário: {$palestra->horario}";
                echo "</div>";
                $iterator->next();
            }
            ?>
        </div>
    </div>

    <!-- EXEMPLO 2: Métodos de Acesso -->
    <div class="example">
        <h2>🎯 Exemplo 2: Métodos de Acesso da Coleção</h2>
        <p>Usando métodos utilitários: first(), last(), get():</p>
        
        <div class="code">
            <pre>
                $palestrantes = Palestrante::allAsCollection();
                $primeiro = $palestrantes->first();
                $ultimo = $palestrantes->last();
                $especifico = $palestrantes->get(2);
            </pre>
        </div>

        <div class="result">
            <?php
            $palestrantes = Palestrante::allAsCollection();
            
            $primeiro = $palestrantes->first();
            if ($primeiro) {
                echo "<div class='item'><strong>Primeiro:</strong> {$primeiro->nome} - {$primeiro->especialidade}</div>";
            }
            
            $ultimo = $palestrantes->last();
            if ($ultimo) {
                echo "<div class='item'><strong>Último:</strong> {$ultimo->nome} - {$ultimo->especialidade}</div>";
            }
            
            $especifico = $palestrantes->get(2);
            if ($especifico) {
                echo "<div class='item'><strong>Posição 2:</strong> {$especifico->nome} - {$especifico->especialidade}</div>";
            }
            
            echo "<div class='stats'>Total de palestrantes: {$palestrantes->count()}</div>";
            ?>
        </div>
    </div>

    <!-- EXEMPLO 3: Filtrar Coleção -->
    <div class="example">
        <h2>🔍 Exemplo 3: Filtrar Coleção</h2>
        <p>Aplicando filtros para obter subconjuntos de dados:</p>
        
        <div class="code">
            <pre>
                $palestrantes = Palestrante::allAsCollection();

                $filtrados = $palestrantes->filter(function($p) {
                    return stripos($p->especialidade, 'PHP') !== false;
                });
            </pre>
        </div>

        <div class="result">
            <p><strong>Palestrantes com especialidade em PHP:</strong></p>
            <?php
            $palestrantes = Palestrante::allAsCollection();
            
            $filtrados = $palestrantes->filter(function($p) {
                return stripos($p->especialidade, 'PHP') !== false;
            });
            
            echo "<div class='stats'>Encontrados: {$filtrados->count()} palestrantes</div>";
            
            $iterator = $filtrados->getIterator();
            $iterator->rewind();
            while ($iterator->valid()) {
                $p = $iterator->current();
                echo "<div class='item'>{$p->nome} - {$p->especialidade}</div>";
                $iterator->next();
            }
            ?>
        </div>
    </div>

    <!-- EXEMPLO 4: Transformar com Map -->
    <div class="example">
        <h2>🔄 Exemplo 4: Transformar com Map</h2>
        <p>Transformando elementos da coleção:</p>
        
        <div class="code">
            <pre>
                $usuarios = Usuario::allAsCollection();

                $emails = $usuarios->map(function($u) {
                    return $u->email;
                });
            </pre>
        </div>

        <div class="result">
            <p><strong>Lista de emails dos usuários:</strong></p>
            <?php
            $usuarios = Usuario::allAsCollection();
            
            $emails = $usuarios->map(function($u) {
                return $u->email;
            });
            
            $iterator = $emails->getIterator();
            $iterator->rewind();
            $count = 1;
            while ($iterator->valid()) {
                echo "<div class='item'>{$count}. {$iterator->current()}</div>";
                $iterator->next();
                $count++;
            }
            ?>
        </div>
    </div>

    <!-- EXEMPLO 5: Iteração Manual Controlada -->
    <div class="example">
        <h2>⚙️ Exemplo 5: Iteração Manual com Controle</h2>
        <p>Controle fino sobre a iteração com key() e valid():</p>
        
        <div class="code">
            <pre>
                $usuarios = Usuario::allAsCollection();
                $iterator = $usuarios->getIterator();

                $iterator->rewind();
                $limit = 5;
                $count = 0;

                while ($iterator->valid() && $count < $limit) {
                    $user = $iterator->current();
                    echo "Posição {$iterator->key()}: {$user->nome}";
                    $iterator->next();
                    $count++;
                }
            </pre>
        </div>

        <div class="result">
            <p><strong>Primeiros 5 usuários:</strong></p>
            <?php
            $usuarios = Usuario::allAsCollection();
            $iterator = $usuarios->getIterator();
            
            $iterator->rewind();
            $limit = 5;
            $count = 0;
            
            while ($iterator->valid() && $count < $limit) {
                $user = $iterator->current();
                echo "<div class='item'>Posição {$iterator->key()}: <strong>{$user->nome}</strong> ({$user->email})</div>";
                $iterator->next();
                $count++;
            }
            
            echo "<div class='stats'>Mostrados: $count de {$usuarios->count()} usuários</div>";
            ?>
        </div>
    </div>

    <!-- EXEMPLO 6: Criar e Manipular Coleção -->
    <div class="example">
        <h2>➕ Exemplo 6: Criar e Manipular Coleção Personalizada</h2>
        <p>Criando uma coleção customizada e manipulando elementos:</p>
        
        <div class="code">
            <pre>
                $collection = new ModelCollection();

                // Adicionar elementos
                $collection->add($item1);
                $collection->add($item2);

                // Iterar
                $iterator = $collection->getIterator();
                while ($iterator->valid()) {
                    // processar
                    $iterator->next();
                }
            </pre>
        </div>

        <div class="result">
            <?php
            $collection = new ModelCollection();
            
            // Pegar alguns palestrantes para a coleção customizada
            $todosPalestrantes = Palestrante::allAsCollection();
            $iter = $todosPalestrantes->getIterator();
            
            $iter->rewind();
            $added = 0;
            while ($iter->valid() && $added < 3) {
                $collection->add($iter->current());
                $iter->next();
                $added++;
            }
            
            echo "<div class='stats'>Coleção criada com {$collection->count()} elementos</div>";
            
            $customIterator = $collection->getIterator();
            $customIterator->rewind();
            while ($customIterator->valid()) {
                $item = $customIterator->current();
                echo "<div class='item'>✓ {$item->nome} - {$item->especialidade}</div>";
                $customIterator->next();
            }
            ?>
        </div>
    </div>

    <!-- EXEMPLO 7: Combinando Operações -->
    <div class="example">
        <h2>🎨 Exemplo 7: Combinando Filter e Map</h2>
        <p>Encadeando operações para transformações complexas:</p>
        
        <div class="code">
            <pre>
                $palestras = Palestra::allAsCollection();

                $resultado = $palestras
                    ->filter(fn($p) => strpos($p->horario, '09:00') !== false)
                    ->map(fn($p) => $p->titulo . ' - ' . $p->palestrante);
            </pre>
        </div>

        <div class="result">
            <p><strong>Palestras que começam às 09:00:</strong></p>
            <?php
            $palestras = Palestra::allAsCollection();
            
            $resultado = $palestras
                ->filter(function($p) {
                    return strpos($p->horario, '09:00') !== false;
                })
                ->map(function($p) {
                    return $p->titulo . ' por ' . $p->palestrante;
                });
            
            echo "<div class='stats'>Encontradas: {$resultado->count()} palestras</div>";
            
            $iterator = $resultado->getIterator();
            $iterator->rewind();
            while ($iterator->valid()) {
                echo "<div class='item'>{$iterator->current()}</div>";
                $iterator->next();
            }
            ?>
        </div>
    </div>

    <?php
    } catch (\Exception $e) {
        echo "<div style='background: #ffebee; padding: 20px; border-radius: 4px; color: #c62828;'>";
        echo "<strong>Erro:</strong> " . htmlspecialchars($e->getMessage());
        echo "</div>";
    }
    ?>

    <div style="margin-top: 40px; padding: 20px; background: #e3f2fd; border-radius: 8px;">
        <h2>📚 Resumo dos Benefícios do Iterator Pattern</h2>
        <ul>
            <li>✅ Encapsulamento da estrutura interna da coleção</li>
            <li>✅ Interface uniforme para percorrer diferentes tipos de coleções</li>
            <li>✅ Múltiplos iteradores podem operar na mesma coleção simultaneamente</li>
            <li>✅ Suporte a operações de transformação (filter, map)</li>
            <li>✅ Controle fino sobre a iteração com métodos como rewind(), valid(), key()</li>
        </ul>
    </div>

    <div style="margin-top: 20px; text-align: center; color: #666;">
        <p>Design Pattern Iterator - Implementação Completa ✨</p>
    </div>
</body>
</html>