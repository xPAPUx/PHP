<?php
    session_start(); 
    unset($_SESSION["ok"]);

    // Verificar si se envió el formulario
    if (isset($_POST['send'])) {

        // Verificar si se envió un archivo
        if (isset($_FILES['image'])) {

            $file = $_FILES['image'];

            // Verificar si el archivo es de tipo JPG
            if ($file['type'] === 'image/jpeg' || $file['type'] === 'image/jpg') {
                $tmpDirectory = 'tmp/';
                $imagesDirectory = 'images/';

                // Mover el archivo a la carpeta temporal
                $tmpFilePath = $tmpDirectory . $file['name'];
                move_uploaded_file($file['tmp_name'], $tmpFilePath);

                $_SESSION["upload"] = "done";
                $_SESSION["tmpFilePaht"] = $tmpFilePath;
                $_SESSION["finalFilePath"] = $imagesDirectory . $file['name'];
                header('Location: index.php');
                
            } else {

                $_SESSION["ok"] = "error";   
                unset($_SESSION["upload"]);
                unset($_SESSION["tmpFilePaht"]);
                unset($_SESSION["finalFilePath"]); 

                header('Location: index.php');

            }

        } else {

            $_SESSION["ok"] = "error_2";  
            unset($_SESSION["upload"]);
            unset($_SESSION["tmpFilePaht"]);
            unset($_SESSION["finalFilePath"]); 

            header('Location: index.php');
        }
    }

    if (isset($_POST['cancel'])) {

        unlink($_SESSION["tmpFilePaht"]);
        unset($_SESSION["upload"]);
        unset($_SESSION["tmpFilePaht"]);
        unset($_SESSION["finalFilePath"]);
        unset($_SESSION["ok"]);
        
        header('Location: index.php');

    }

    if (isset($_POST['confirm'])) {
        
        copy($_SESSION["tmpFilePaht"], $_SESSION["finalFilePath"]);    
        unlink($_SESSION["tmpFilePaht"]);

        $_SESSION["ok"] = "success";
        unset($_SESSION["upload"]);
        unset($_SESSION["tmpFilePaht"]);
        unset($_SESSION["finalFilePath"]);

        header('Location: index.php');

    }
?>