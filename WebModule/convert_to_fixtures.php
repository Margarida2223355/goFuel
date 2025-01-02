<?php

// Caminhos dos arquivos
$inputFile = 'C:\wamp64\www\Fork\goFuel\WebModule\datatotests.sql'; // Caminho do dump SQL
$outputDir = 'C:\wamp64\www\Fork\goFuel\WebModule\frontend\tests\_data'; // Diretório onde os fixtures serão salvos

// Definir nomes das colunas para cada tabela
$tableColumns = [
    'user' => ['id', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'status', 'created_at', 'updated_at'],
    'user_info' => ['id', 'user_id', 'nif', 'name', 'address', 'postal_code', 'phone', 'latitude', 'longitude'],
    'categories' => ['id', 'name', 'parent_id'],
    'client_station' => ['client_id', 'station_id'],
    'invoice_lines' => ['id', 'invoice_id', 'item_id', 'quantity', 'price'],
    'invoice_states' => ['id', 'name'],
    'invoices' => ['id', 'client_id', 'state_id', 'date', 'total', 'station_id', 'code'],
    'items' => ['id', 'name', 'category_id', 'price', 'stock'],
    'manager_station' => ['manager_id', 'station_id'],
    'station_items' => ['station_id', 'item_id', 'price', 'stock', 'active'],
    'station_users' => ['station_id', 'user_id'],
    'stations' => ['id', 'name', 'address', 'postal_code', 'manager_id', 'phone', 'active'],
    'subcategories' => ['id', 'name', 'category_id', 'active'],
];

// Criar diretório de saída, se necessário
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

// Ler conteúdo do arquivo SQL
$sqlContent = file_get_contents($inputFile);

// Regex para encontrar INSERT statements
$regex = '/INSERT INTO `(\w+)` VALUES \((.*?)\);/s';
preg_match_all($regex, $sqlContent, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {
    $tableName = $match[1];
    $values = $match[2];

    // Verificar se a tabela tem definição de colunas
    if (!isset($tableColumns[$tableName])) {
        echo "Colunas não definidas para a tabela: $tableName. Pulei...\n";
        continue;
    }

    $columns = $tableColumns[$tableName];

    // Separar múltiplos valores
    $rows = explode('),(', trim($values, '()'));

    // Processar cada linha para extrair os valores
    $data = [];
    foreach ($rows as $row) {
        $values = array_map(function ($value) {
            $value = trim($value, "'");
            if ($value === 'NULL') {
                return null;
            }
            return is_numeric($value) ? (float)$value : $value;
        }, explode(',', $row));

        // Associar valores às colunas
        $record = array_combine($columns, $values);
        $data[] = $record;
    }

    // Gerar conteúdo do arquivo fixture no formato desejado
    $fixtureContent = "<?php\n\nreturn " . var_export($data, true) . ";\n";

    // Ajustar formatação do array para o padrão PHP (array associativo por registro)
    $fixtureContent = preg_replace("/\d+ => /", '', $fixtureContent); // Remover índices numéricos
    $fixtureContent = str_replace("array (", '[', $fixtureContent); // Substituir "array (" por "["
    $fixtureContent = str_replace(")", "]", $fixtureContent); // Substituir ")" por "]"

    // Salvar fixture no arquivo
    $fixtureFile = $outputDir . '/' . ucfirst($tableName) . 'Fixture.php';
    file_put_contents($fixtureFile, $fixtureContent);

    echo "Fixture para a tabela `{$tableName}` criada: {$fixtureFile}\n";
}

echo "Conversão concluída!\n";
