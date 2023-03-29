<?php
    session_start();
    if(isset($_SESSION['usuario'])):
        header('Location: home.php');
    endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="card">
        <div class="card-header">
            <img src="./assets/img/logo.png" alt="">
            <p>Bem-vindo! Faça login ou cadastre-se.</p>
            
            <div class="buttons">
                <a href="#" id="btn-login">Login</a>
                <a href="#" id="btn-cadastro">Cadastro</a>
            </div>
        </div>
        
        <form id="form-login">
            <h2>Login</h2>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="password">
            <input type="submit" value="Entrar">
        </form>
        
        <form id="form-cadastro">
            <h2>Cadastro</h2>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="password">
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <script>
        const btnLogin = document.getElementById('btn-login');
        const btnCadastro = document.getElementById('btn-cadastro');
        const formLogin = document.getElementById('form-login');
        const formCadastro = document.getElementById('form-cadastro');

        btnLogin.addEventListener('click', () => {
            formLogin.style.display = 'block';
            formCadastro.style.display = 'none';
        });

        btnCadastro.addEventListener('click', () => {
            formCadastro.style.display = 'block';
            formLogin.style.display = 'none';
        });

        formLogin.addEventListener("submit",async (event) => {
            event.preventDefault();
            const data = new FormData(formLogin);
            const response = await fetch("./actions/usuarios/loginAction.php",{ method: "POST", body: data });
            const person = await response.json();
            if(!person.status) alert(person.message);
            else window.location.href = "home.php";
        })

        formCadastro.addEventListener("submit",async (event) => {
            event.preventDefault();
            const data = new FormData(formCadastro);
            const response = await fetch("./actions/usuarios/createActions.php",{ method: "POST", body: data });
            const person = await response.json();
            alert(person.message);
        })
    </script>
</body>
</html>