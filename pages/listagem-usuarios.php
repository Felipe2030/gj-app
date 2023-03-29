<?php include_once "actions/usuarios/getAction.php"; ?>

<div class="container">
    <h1>Listagem de Usuário</h1>

    <form method="GET">
        <input type="text" name="busca" placeholder="Buscar">
        <button type="submit">Buscar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $key => $row): ?>
            <tr>
                <td><?=$row["id"]?></td>
                <td><?=$row["email"]?></td>
                <td><button type="button" onclick="openModal(<?=$row['id']?>)">Editar</button></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php
        for ($i = 1; $i <= $total_paginas; $i++) {
            echo "<a class='paginacao' href='usuarios.php?pagina=$i";
            if (isset($_GET['busca'])) { echo "&busca=" . $_GET['busca']; } echo "'>$i</a> ";
        }
    ?>

    <div id="myModal" class="modal">
		<!-- Conteúdo do modal -->
		<div class="modal-content">
			<span class="close" onclick="closeModal()">&times;</span>
			<h2>Editar Usuário</h2>
			<form id="usuarioForm" method="POST">
                <input type="hidden" name="id" id="idUsuario">
                
				<label for="email">Email:</label>
				<input type="email" id="email" name="email"><br>

				<label for="senha">Senha:</label>
				<input type="password" id="senha" name="password"><br>

				<button type="submit">Editar</button>
			</form>
		</div>
	</div>
</div>

<script>
    // Função para abrir o modal de cadastro
    async function openModal(id) {
        const response = await fetch(`./actions/usuarios/getIdAction.php?id=${id}`,{ method: "GET" });
        const person   = await response.json();
      
        document.querySelector("#idUsuario").value = person.id;
        document.querySelector("#email").value = person.email;
        document.querySelector("#senha").value = person.abc;
        document.getElementById("myModal").style.display = "block";
    }

    // Função para fechar o modal de cadastro
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    const formulario = document.querySelector("#usuarioForm");
    formulario.addEventListener("submit",async (event) => {
        event.preventDefault();
        const data     = new FormData(formulario);
        const response = await fetch("./actions/usuarios/updateActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        window.location.href = "usuarios.php";
    })
</script>