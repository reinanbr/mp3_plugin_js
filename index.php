<?php
// Permite solicitações de qualquer origem
header("Access-Control-Allow-Origin: *");

// Permite os métodos que podem ser usados na solicitação
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permite os cabeçalhos que podem ser usados na solicitação
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Verifica se a requisição é uma requisição prévia (preflight request)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Finaliza a requisição aqui, pois é apenas um pedido de permissão
    exit(0);
}

// Configuração do cabeçalho para garantir que o PHP sirva o arquivo de áudio corretamente.
header('Content-Type: audio/mpeg');

// Verifica se um parâmetro 'file' foi passado na URL
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = 'mp3/' . $file;

    // Verifica se o arquivo existe
    if (file_exists($filepath)) {
        // Força o download do arquivo de áudio
        header('Content-Disposition: inline; filename="' . $file . '"');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        http_response_code(404);
        echo "Arquivo não encontrado!";
        exit;
    }
} else {
    http_response_code(400);
    echo "Parâmetro de arquivo não fornecido!";
    exit;
}
?>
