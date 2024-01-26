<!DOCTYPE html>
<html>
<head>
    <title>Comparador de Arquivos</title>
<style>
body {
    background-color: #212121;
    color: #BDBDBD;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #424242;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    color: #fff;
}

.compare-form {
    text-align: center;
}

.compare-form h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
}

.select-box {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit-button {
    background-color: #007BFF;
    color: #fff;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
     text-decoration: none;
}

.submit-button1 {
    background-color: #FF8F00;
    color: #fff;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
     text-decoration: none;
}


.submit-button:hover {
    background-color: #0056b3;
}

</style>

</head>
<body>
    <div class="container">
        <form method="post" action="compare_files.php" class="compare-form">
            <h1>Comparar Arquivos</h1>
            <div class="form-group">
                <label for="directory">Escolha uma pasta:</label>
                <select name="directory" id="directory" class="select-box">
                    <option value="null">Escolha</option>
                    <?php
                        function listDirectories($dir) {
                            $dirs = glob($dir . '/*', GLOB_ONLYDIR);
                            foreach ($dirs as $subdir) {
                                echo "<option value='" . $subdir . "'>" . $subdir . "</option>";
                                listDirectories($subdir); // Chamada recursiva para listar subdiretórios
                            }
                        }
                        listDirectories('/var/pure-ftpd');
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="file1">Mais antigo:</label>
                <select name="file1" id="file1" class="select-box">
                </select>
            </div>
            <div class="form-group">
                <label for="file2">Mais recente:</label>
                <select name="file2" id="file2" class="select-box">
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Comparar" class="submit-button">
            </div>
        </form>
<a href="./pure-ftpd/" class="submit-button1">Ira para arquivos</a>
    </div>

    <script>
        document.getElementById('directory').addEventListener('change', function() {
            var directory = this.value;
            var fileSelect1 = document.getElementById('file1');
            var fileSelect2 = document.getElementById('file2');

            // Limpar as seleções anteriores
            fileSelect1.innerHTML = '';
            fileSelect2.innerHTML = '';

            // Requisição AJAX para obter os arquivos da pasta
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_files.php?directory=' + directory, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var files = JSON.parse(xhr.responseText);
                    files.forEach(function(file) {
                        var option = document.createElement('option');
                        option.value = file;
                        option.textContent = file;
                        fileSelect1.appendChild(option);
                        fileSelect2.appendChild(option.cloneNode(true));
                    });
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>

