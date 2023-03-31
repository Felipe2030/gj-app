<?php include_once "actions/finaceiro/getAction.php"; ?>

<div class="container">
    <div class="relatorio">
        <h1>Listagem de Financeiro</h1>
    </div>
    <form method="GET">
        <select name="busca" id="busca">
            <option value="01">Janeiro</option>
            <option value="02">Fevereiro</option>
            <option value="03">Março</option>
            <option value="04">Abril</option>
            <option value="05">Maio</option>
            <option value="06">Junho</option>
            <option value="07">Julho</option>
            <option value="08">Agosto</option>
            <option value="09">Setembro</option>
            <option value="10">Outubro</option>
            <option value="11">Novembro</option>
            <option value="12">Dezembro</option>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Numero</th>
                <th>Status</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Ganho</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($data)): ?>
        <?php foreach ($data as $key => $row): ?>
            <tr>
                <td><?=$row["id"]?></td>
                <td><?=$row["numero"]?></td>
                <td><?=$row["status"]?></td>
                <td><?=$row["nome_categoria"]?></td>
                <td><?=$row["nome_fornecedor"]?></td>
                <td><?="R$ ".$row["ganho_entrega"]?></td>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="container_financeiro">
        <div class="card_ordens">
            <h1>Total de ordens geradas</h1>
            <span><?=$total_itens?></span>
        </div>
        <div class="card_ordens">
            <h1>Total de ganhos</h1>
            <span>R$ <?=$total_ganhos?></span>
        </div>
    </div>
</div>

<script>
    var data     = new Date();
    var mes      = String(data.getMonth() + 1).padStart(2, '0');
    var urlAtual = window. location. href;
    var urlClass = new URL(urlAtual);
    var busca    = urlClass.searchParams.get("busca")

    document.querySelectorAll("#busca option").forEach((op) => {
        if(!!busca){
            if(op.value == busca){ op.selected = true; }
        }else{
            if(op.value == mes){ op.selected = true; }
        }
    })
</script>