<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width,initial-scale=1" name="viewport">
        <title>Combinatorics</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body onload="startGame()">
        <?
            if($_POST){
                include "combinatorics.php";
                $marbles = strip_tags($_POST['marbles']);
                $holes = strip_tags($_POST['holes']);
                $filename = strip_tags($_POST['filename']);
                $combinatorics = new Combinatorics($marbles, $holes, $filename);
                $errorMsg = $combinatorics->getErrorMsg();
            }
        ?>
        <div class="container">
            <h1>Введите данные</h1>
            <?php echo $errorMsg; ?>
            <div class="jumbotron">
                <form method="POST">
                    <div class="form-group">
                        <label>Количество фишек: </label>
                        <input type="number" class="form-control" name="marbles" value="<?php echo $marbles?>" />
                    </div>
                    <div class="form-group">
                        <label>Количество ячеек: </label>
                        <input type="number" class="form-control" name="holes" value="<?php echo $holes?>"/>
                    </div>
                    <div class="form-group">
                        <label>Название файла: </label>
                        <input type="text" class="form-control" name="filename" value="<?php echo $filename?>" />
                    </div>
                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </body>
</html>
