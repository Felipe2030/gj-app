<?php include_once "actions/ordens/getAction.php"; ?>

<div class="container">
    <div class="relatorio">
        <h1>Listagem de Ordem</h1>
        <a href="actions/ordens/relatorioAction.php" download="relatorio.xls">Relatório</a>
    </div>
    <form method="GET">
        <input type="text" name="busca" placeholder="Buscar">
        <button type="submit">Buscar</button>
        <button type="button" onclick="openModal()" style="background: #4CAF50;">Cadastrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Status</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!!$data): ?>
        <?php foreach ($data as $key => $row): ?>
            <tr>
                <td><?=$row["id"]?></td>
                <td><?=$row["numero"]?></td>
                <td><?=$row["status"]?></td>
                <td><?=$row["categorias"]?></td>
                <td>
                    <button type="button" onclick="openModalVisualizar(<?=$row['id']?>)">Visualizar</button>
                    <button type="button" onclick="openModalEdit(<?=$row['id']?>)">Editar</button>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    
    <?php
        for ($i = 1; $i <= $total_paginas; $i++) {
            echo "<a class='paginacao' href='home.php?pagina=$i";
            if (isset($_GET['busca'])) { echo "&busca=" . $_GET['busca']; } echo "'>$i</a> ";
        }
    ?>


    <div id="myModalVisualizar" class="modal">
		<!-- Conteúdo do modal -->
		<div class="modal-content">
			<span class="close" onclick="closeModalVisualizar()">&times;</span>
			<h2>Visualizar Ordem</h2>
			<form id="form_ordem">
				<label for="nome">Numero:</label>
				<input type="text" id="numero_vi" name="numero" disabled><br>

                <label for="nome">Categorias:</label>
				<input type="text" id="categoria_vi" name="categoria" disabled><br>

                <label for="nome">Andamentos:</label>
                <div id="listagem"></div>
			</form>
		</div>
	</div>

    <div id="myModal" class="modal">
		<!-- Conteúdo do modal -->
		<div class="modal-content">
			<span class="close" onclick="closeModal()">&times;</span>
			<h2>Cadastrar Ordem</h2>
			<form id="ordemForm" method="POST">
				<label for="nome">Numero:</label>
				<input type="text" id="numero" name="numero"><br>

				<label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Em andamento">Em andamento</option>
                    <option value="Ausente">Ausente</option>
                    <option value="Concluido">Concluido</option>
                    <option value="Cancelado">Cancelado</option>
                </select><br>

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria">
                    <option value="Cartão">Cartão</option>
                    <option value="Shopee">Shopee</option>
                </select><br>
				
				<button type="submit">Cadastrar</button>
			</form>
		</div>
	</div>

    <div id="myModalEdit" class="modal">
		<!-- Conteúdo do modal -->
		<div class="modal-content">
			<span class="close" onclick="closeModalEdit()">&times;</span>
			<h2>Editar Ordem</h2>
			<form id="ordemFormEditar" method="POST">
                <input type="hidden" name="id" id="idOrdem">
				<label for="nome">Numero:</label>
				<input type="text" id="numero_ed" name="numero"><br>

				<label for="status">Status:</label>
                <select name="status" id="status_ed">
                    <option value="Em andamento">Em andamento</option>
                    <option value="Ausente">Ausente</option>
                    <option value="Concluido">Concluido</option>
                    <option value="Cancelado">Cancelado</option>
                </select><br>

                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria_ed">
                    <option value="Cartão">Cartão</option>
                    <option value="Shopee">Shopee</option>
                </select><br>
				
				<button type="submit">Editar</button>
			</form>
		</div>
	</div>
</div>

<script>

     // Função para abrir o modal de cadastro
    async function openModalVisualizar(id) {
        const response = await fetch(`./actions/ordens/getIdGeralAction.php?id=${id}`,{ method: "GET" });
        const person   = await response.json();

        document.querySelector("#numero_vi").value = person[0].numero;
        document.querySelector("#categoria_vi").value = person[0].categorias;
        
        let listagem   = ""

        person.forEach((e) => {
            listagem += `<li>Status: ${e.status} - Data: ${e.data}</li>`;
        });
       
        document.querySelector("#listagem").innerHTML = listagem;

        document.getElementById("myModalVisualizar").style.display = "block";
    }

    // Função para fechar o modal de cadastro
    function closeModalVisualizar() {
        document.getElementById("myModalVisualizar").style.display = "none";
    }


    // Função para abrir o modal de cadastro
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    // Função para fechar o modal de cadastro
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    // Função para abrir o modal de cadastro
    async function openModalEdit(id) {
        const response = await fetch(`./actions/ordens/getIdAction.php?id=${id}`,{ method: "GET" });
        const person   = await response.json();
      
        document.querySelector("#idOrdem").value = person.id;
        document.querySelector("#numero_ed").value = person.numero;

        document.querySelectorAll("#status_ed option").forEach((op) => {
            if(op.value == person.status){
                op.selected = true;
            }
        })

        document.querySelectorAll("#categoria_ed option").forEach((op) => {
            if(op.value == person.categorias){
                op.selected = true;
            }
        })
        
        document.getElementById("myModalEdit").style.display = "block";
    }

    // Função para fechar o modal de cadastro
    function closeModalEdit() {
        document.getElementById("myModalEdit").style.display = "none";
    }

    const formulario = document.querySelector("#ordemForm");

    formulario.addEventListener("submit",async (event) => {
        event.preventDefault();
        const data     = new FormData(formulario);
        const response = await fetch("./actions/ordens/createActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        window.location.href = "home.php";
    })

    const ordemFormEditar = document.querySelector("#ordemFormEditar");
    ordemFormEditar.addEventListener("submit",async (event) => {
        event.preventDefault();
        const data     = new FormData(ordemFormEditar);
        const response = await fetch("./actions/ordens/updateActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        window.location.href = "home.php";
    })
</script>