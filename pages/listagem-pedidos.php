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
                <th style="text-align: center;">ID</th>
                <th>Numero</th>
                <th>Status</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!!$data): ?>
        <?php foreach ($data as $key => $row): ?>
            <tr class="checkout">
                <td style="padding: 0px;width: 50px;"><button class="btnIndex"><?=$row["id"]?></button></td>
                <td><?=$row["numero"]?></td>
                <td><?=$row["status"]?></td>
                <td><?=$row["categorias"]?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    
    <div class="container_update">
        <div class="container_paginacao">
            <?php
                for ($i = 1; $i <= $total_paginas; $i++) {
                    echo "<a class='paginacao' href='home.php?pagina=$i";
                    if (isset($_GET['busca'])) { echo "&busca=" . $_GET['busca']; } echo "'>$i</a> ";
                }
            ?>
        </div>
        <div class="container_status_all">
            <form id="ordemStatusAll" method="POST">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Em andamento">Em andamento</option>
                    <option value="Ausente">Ausente</option>
                    <option value="Concluido">Concluido</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
                <button type="submit">Salvar</button>
            </form>
            <button style="background: #4CAF50;" type="button" id="modalVisualisar">Visualizar</button>
            <button style="background: #333;" type="button" id="modalEditar">Editar</button>
            <button style="background: red;" type="button" id="btnApagar">Apagar</button>
        </div>
    </div>

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

                <label for="nome">Fornecedor:</label>
				<input type="text" id="fornecedor_vi" name="fornecedor" disabled><br>

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

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <label for="categoria">Categoria:</label>
                    <div>
                        <button style="width: 32px;" type="button" id="criarCategoria">+</button>
                        <button style="width: 32px; background: red;" type="button" id="deletarCategoria">-</button>
                        <button style="width: 46px;" class="d-none" id="salvarCategoria" type="button">salvar</button>
                    </div>
                </div>

                <input id="inputCriarCategoria" class="d-none" type="text" placeholder="Digite uma categoria">

                <select name="categoria" id="categoria">
                    <?php foreach ($categirias as $key => $categiria): ?>
                        <option value="<?=$categiria['id']?>"><?=$categiria['nome']?></option>
                    <?php endforeach; ?>
                </select><br>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <label for="categoria">Fornecedor:</label>
                    <div>
                        <button style="width: 32px;" type="button" id="criarFornecedor">+</button>
                        <button style="width: 32px; background: red;" type="button" id="deletarFornecedor">-</button>
                        <button style="width: 46px;" class="d-none" id="salvarFornecedor" type="button">salvar</button>
                    </div>
                </div>

                <input id="inputCriarFornecedorNome" class="d-none" type="text" placeholder="Digite nome do fornecedor">
                <input id="inputCriarFornecedorGanho" class="d-none" type="text" placeholder="Digite ganho da entrega">

                <select name="fornecedor" id="fornecedor">
                    <?php foreach ($fornecedores as $key => $fornecedor): ?>
                        <option value="<?=$fornecedor['id']?>"><?=$fornecedor['nome']?></option>
                    <?php endforeach; ?>
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
                    <?php foreach ($categirias as $key => $categiria): ?>
                        <option value="<?=$categiria['id']?>"><?=$categiria['nome']?></option>
                    <?php endforeach; ?>
                </select><br>

                <label for="fornecedor">Fornecedor:</label>
                <select name="fornecedor" id="fornecedor_ed">
                    <?php foreach ($fornecedores as $key => $fornecedor): ?>
                        <option value="<?=$fornecedor['id']?>"><?=$fornecedor['nome']?></option>
                    <?php endforeach; ?>
                </select><br>
				
				<button type="submit">Editar</button>
			</form>
		</div>
	</div>
</div>

<script>
    let criarCategoria      = document.querySelector("#criarCategoria");
    let inputCriarCategoria = document.querySelector("#inputCriarCategoria");
    let salvarCategoria     = document.querySelector("#salvarCategoria");
    let deletarCategoria    = document.querySelector("#deletarCategoria");

    deletarCategoria.onclick = async () => {
        let id = document.querySelector("#categoria option").value;
        let data = new FormData();
        data.append("id", id);

        const response = await fetch("./actions/categorias/deletarActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        if(person.status) window.location.href = "home.php"
    }

    criarCategoria.onclick = () => {
        salvarCategoria.classList.remove("d-none");
        criarCategoria.classList.add("d-none");
        inputCriarCategoria.classList.remove("d-none");
        deletarCategoria.classList.add("d-none");
    }

    salvarCategoria.onclick = async () => {
        salvarCategoria.classList.add("d-none");
        criarCategoria.classList.remove("d-none");
        inputCriarCategoria.classList.add("d-none");
        deletarCategoria.classList.remove("d-none");

        let nome = inputCriarCategoria.value;

        const data = new FormData();
        data.append("nome", nome);

        const response = await fetch("./actions/categorias/createActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        if(person.status) window.location.href = "home.php";
    }

    let criarFornecedor = document.querySelector("#criarFornecedor");
    let inputCriarFornecedorNome = document.querySelector("#inputCriarFornecedorNome");
    let inputCriarFornecedorGanho = document.querySelector("#inputCriarFornecedorGanho");
    let salvarFornecedor = document.querySelector("#salvarFornecedor");
    let deletarFornecedor = document.querySelector("#deletarFornecedor");

    deletarFornecedor.onclick = async () => {
        let id = document.querySelector("#fornecedor option").value;
        let data = new FormData();
        data.append("id", id);

        const response = await fetch("./actions/fornecedor/deletarActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        if(person.status) window.location.href = "home.php"
    }

    criarFornecedor.onclick = () => {
        salvarFornecedor.classList.remove("d-none");
        criarFornecedor.classList.add("d-none");
        inputCriarFornecedorNome.classList.remove("d-none");
        inputCriarFornecedorGanho.classList.remove("d-none");
        deletarFornecedor.classList.add("d-none");
    }

    salvarFornecedor.onclick = async () => {
        salvarFornecedor.classList.add("d-none");
        criarFornecedor.classList.remove("d-none");
        inputCriarFornecedorNome.classList.add("d-none");
        inputCriarFornecedorGanho.classList.add("d-none");
        deletarFornecedor.classList.remove("d-none");

        let nome  = inputCriarFornecedorNome.value;
        let ganho = inputCriarFornecedorGanho.value;
    

        const data = new FormData();
        data.append("nome", nome);
        data.append("ganho", ganho);

        const response = await fetch("./actions/fornecedor/createActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        if(person.status) window.location.href = "home.php";
    }

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

        document.querySelectorAll("#fornecedor_ed option").forEach((op) => {
            if(op.value == person.fornecedor){
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

    let checkouts = document.querySelectorAll(".checkout");

    checkouts.forEach(checkout => {
        checkout.addEventListener("click", (event) => {
            let btn = checkout.querySelector("button");
            btn.classList.toggle("active");
        })
    });

    let formOrdemStatusAll = document.querySelector("#ordemStatusAll");

    formOrdemStatusAll.addEventListener("submit", async (event) => {
        event.preventDefault();

        let ids = [];
        let data = new FormData(formOrdemStatusAll);
        let checkouts = document.querySelectorAll(".checkout .active");
        
        if(checkouts.length == 0){
            alert("Seleciona uma ou mais ordem");
            return;
        } 

        checkouts.forEach(checkout => { ids.push(checkout.innerText); });
        data.append("ids",JSON.stringify(ids));
        
        const response = await fetch("./actions/ordens/updateAllActions.php",{ method: "POST", body: data });
        const person   = await response.json();
        alert(person.message);
        window.location.href = "home.php";
    })

   let modalVisualisar = document.querySelector("#modalVisualisar");
   let modalEditar = document.querySelector("#modalEditar");
   let btnApagar  = document.querySelector("#btnApagar");

   modalVisualisar.onclick = () => {
    let checkout = document.querySelectorAll(".checkout .active");

    if(checkout.length == 0){
        alert("Seleciona uma ordem");
        return;
    } 

    if(checkout.length > 1){
        alert("Seleciona somente uma ordem");
        return;
    } 

    openModalVisualizar(checkout[0].innerText);
   }

   modalEditar.onclick = () => {
    let checkout = document.querySelectorAll(".checkout .active");

    if(checkout.length == 0){
        alert("Seleciona uma ordem");
        return;
    } 

    if(checkout.length > 1){
        alert("Seleciona somente uma ordem");
        return;
    } 


    openModalEdit(checkout[0].innerText);
   }

   btnApagar.onclick = async () => {
        let ids = [];
        let data = new FormData();
        let checkouts = document.querySelectorAll(".checkout .active");

        if(checkouts.length == 0){
            alert("Seleciona uma ou mais ordem");
            return;
        } 

        if (confirm("Voce está apagando ordens!") == true) {
            checkouts.forEach(checkout => { ids.push(checkout.innerText); });
            data.append("ids",JSON.stringify(ids));
            
            const response = await fetch("./actions/ordens/deletarAllActions.php",{ method: "POST", body: data });
            const person   = await response.json();
            alert(person.message);
            window.location.href = "home.php";
        }
   }
</script>