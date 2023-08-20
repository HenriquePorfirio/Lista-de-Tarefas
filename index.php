<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lista de Tarefa</title>
</head>

<body>
    <h1>Lista de Tarefas</h1>

    <form method="post">
        <input type="text" name="tarefa" placeholder="Digite uma nova tarefa" required>
        <input type="date" name="data_conclusao">
        <button type="submit">Adicionar</button>
    </form>

</body>
</html>

    <?php
    session_start(); 


    if (!isset($_SESSION["tarefas"])) {
        $_SESSION["tarefas"] = [];
    }
    if (!isset($_SESSION["tarefas_concluidas"])) {
        $_SESSION["tarefas_concluidas"] = [];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["tarefa"])) {
            $novaTarefa = $_POST["tarefa"];
            $dataConclusao = $_POST["data_conclusao"];
            $novaTarefa .= " - Concluir até: " . $dataConclusao;
            $_SESSION["tarefas"][] = $novaTarefa;
        }
    }

    if (!empty($_SESSION["tarefas"])) {
        echo "<h2>Tarefas Pendentes:</h2>";
        echo "<form method='post'>";
        foreach ($_SESSION["tarefas"] as $indice => $tarefa) {
            echo "<label>";
            echo "<input type='checkbox' name='concluida[]' value='$indice'>";
            echo "$tarefa";
            echo "</label><br>";
        }
        echo "<button type='submit' name='marcar_concluidas'>Marcar Concluídas</button>";
        echo "</form>";
    }

    if (isset($_POST["marcar_concluidas"])) {
        if (!empty($_POST["concluida"])) {
            $tarefasMarcadas = $_POST["concluida"];
            foreach ($tarefasMarcadas as $indice) {
                if (isset($_SESSION["tarefas"][$indice])) {
                    $tarefaConcluida = $_SESSION["tarefas"][$indice];
                    $_SESSION["tarefas_concluidas"][] = $tarefaConcluida;
                    unset($_SESSION["tarefas"][$indice]); 
                }
            }
        }
    }

    if (!empty($_SESSION["tarefas_concluidas"])) {
        echo "<h2>Tarefas Concluídas:</h2>";
        echo "<ul>";
        foreach ($_SESSION["tarefas_concluidas"] as $tarefaConcluida) {
            echo "<li>$tarefaConcluida</li>";
        }
        echo "</ul>";
    }

    ?>

</body>
</html>



