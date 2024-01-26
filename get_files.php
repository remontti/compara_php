<?php
if (isset($_GET['directory'])) {
    $directory = $_GET['directory'];
    $files = glob($directory . '/*');
    
    // Função de comparação para ordenar os arquivos por data de modificação (mais novo primeiro)
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    $fileNames = array_map('basename', $files);
    echo json_encode($fileNames);
} else {
    echo "Diretório não especificado.";
}
?>

