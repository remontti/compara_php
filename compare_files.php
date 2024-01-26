<!DOCTYPE html>
<html>
<head>
<title>Comparar</title>
<style>
body {
    background-color: #212121;
    color: #BDBDBD;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    width: 50%;
    vertical-align: top;
}

h2 {
    margin-bottom: 10px;
}

pre {
    white-space: pre-wrap;
    padding: 10px;
    border: 1px solid #ccc;
}

span.added {
    background-color: #00E676;
    color: #444;
}

span.removed {
    background-color: #C62828;
    color: #FFEBEE;
}

</style>
</head>
<body>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['directory'], $_POST['file1'], $_POST['file2'])) {
            $directory = $_POST['directory'];
            $file1 = $directory . '/' . $_POST['file1'];
            $file2 = $directory . '/' . $_POST['file2'];

            if (file_exists($file1) && file_exists($file2)) {
                // Lê o conteúdo dos arquivos
                $content1 = file_get_contents($file1);
                $content2 = file_get_contents($file2);

                // Extrai as chaves e valores de ambos os arquivos
                $data1 = [];
                $data2 = [];

                function extractKeyValuePairs($content) {
                    $pairs = [];
                    $lines = explode("\n", $content);
                    foreach ($lines as $line) {
                        list($key, $value) = explode('=', $line, 2);
                        $pairs[trim($key)] = trim($value);
                    }
                    return $pairs;
                }

                $data1 = extractKeyValuePairs($content1);
                $data2 = extractKeyValuePairs($content2);

                // Encontra as diferenças entre os conjuntos de chaves e valores
                $differences1 = array_diff_assoc($data1, $data2);
                $differences2 = array_diff_assoc($data2, $data1);

                // Exibe as diferenças e os itens iguais
                echo '<table>';
                echo '<tr>';
                echo '<td>';
                echo '<h2>' . htmlspecialchars($_POST['file1']) . '</h2>';
                echo '<pre>';
                foreach ($data1 as $key => $value) {
                    if (isset($differences1[$key])) {
                        echo '<span><span class="removed">- ' . $key . ' ' . htmlspecialchars($differences1[$key]) . '</span></span>' . PHP_EOL;
                    } else {
                        echo $key . ' ' . htmlspecialchars($value) . PHP_EOL;
                    }
                }
                echo '</pre>';
                echo '</td>';

                echo '<td>';
                echo '<h2>' . htmlspecialchars($_POST['file2']) . '</h2>';
                echo '<pre>';
                foreach ($data2 as $key => $value) {
                    if (isset($differences2[$key])) {
                        echo '<span><span class="added">+ ' . $key . ' ' . htmlspecialchars($differences2[$key]) . '</span></span>' . PHP_EOL;
                    } else {
                        echo $key . ' ' . htmlspecialchars($value) . PHP_EOL;
                    }
                }
                echo '</pre>';
                echo '</td>';

                echo '</tr>';
                echo '</table>';
            } else {
                echo "Um ou ambos os arquivos não foram encontrados no diretório.";
            }
        } else {
            echo "Por favor, selecione uma pasta e dois arquivos para comparar.";
        }
    }
    ?>
</body>
</html>
