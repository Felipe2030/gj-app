<style>
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f5f5f5;
    padding: 10px 20px;
}

.logo img {
    height: 10px;
}

header a {
    color: #333;
    font-weight: 600;
    font-size: 0.8em;
    cursor: pointer;
}

nav {
  background-color: #333;
  color: #fff;
  text-align: left;
  padding: 10px;
}

nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

nav ul li {
  display: inline-block;
}

nav ul li a {
  color: #fff;
  text-decoration: none;
  padding: 10px;
}

nav ul li a:hover {
  background-color: #555;
}

</style>
<header>
  <div class="logo">
    <img style="width: 60px;" src="./assets/img/logo.png" alt="Logo">
  </div>
  <a onclick="logout()">Sair</a>
</header>

<nav>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="financeiro.php">Financeiro</a></li>
      <li><a href="usuarios.php">Usuarios</a></li>
    </ul>
</nav>

<script>
  async function logout(){
    const response = await fetch("./actions/usuarios/logoutAction.php",{ method: "GET" });
    const person = await response.json();
    if(person.status) window.location.href = "index.php";
  }
</script>