<?php
try {
    // Connexion à la base de données
    $connexion = new PDO(
        'mysql:host=localhost;dbname=senkou',
        'senkou',
        'eA)U)dloot4X-aaW'
    );
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_POST["enviar"])) {

    if (!empty($_POST['nome']) && !empty($_POST['sobre_nome']) && !empty($_POST['email']) && !empty($_POST['empresa'])) {
        $nome = htmlspecialchars($_POST['nome']);
        $sobre_nome = htmlspecialchars($_POST['sobre_nome']);
        $email = htmlspecialchars($_POST['email']);
        $empresa = htmlspecialchars($_POST['empresa']);

        if (strlen($nome) > 50 || strlen($sobre_nome) > 50) {
            $mensagem = "Seu nome ou sobrenome é muito longo, por favor tente novamente.";
        } else {
            // Vérifier si l'email existe déjà
            $verif = $connexion->prepare("SELECT id FROM users WHERE email = ?");
            $verif->execute([$email]);

            if ($verif->rowCount() > 0) {
                $mensagem = "Desculpe, este endereço de e-mail já foi utilizado para nos enviar uma mensagem.";
            } else {
                // Insertion des données
                $insertion = $connexion->prepare("INSERT INTO users (nome, sobre_nome, email, empresa) VALUES (?, ?, ?, ?)");
                $insertion->execute([$nome, $sobre_nome, $email, $empresa]);
                $mensagem = "A sua mensagem foi enviada com sucesso.";
            }
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }

    echo $mensagem;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

 <style>
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: #fff;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.4s ease;
        }
        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        .success { background-color: #4CAF50; }
        .error { background-color: #FF0000; }
    </style>
</head>
<link rel="stylesheet" href="style.css">
<body>

<?php if (!empty($mensagem)) : ?>
    <div id="notif" class="notification <?php echo (strpos($mensagem, 'sucesso') !== false) ? 'success' : 'error'; ?>">
        <?php echo $mensagem; ?>
    </div>
    <script>
        const notif = document.getElementById("notif");
        notif.classList.add("show");
        setTimeout(() => {
            notif.classList.remove("show");
        }, 4000); // disparaît après 4 secondes
    </script>
    <?php endif; ?>


  <!-- Bouton centré -->
  <button class="menu-btn" id="menuBtn">Menu</button>

  <!-- Menu -->
  <div class="menu" id="menu">
    <a href="#index.html">INICIO</a>
  </div>

  <script>
    const menuBtn = document.getElementById("menuBtn");
    const menu = document.getElementById("menu");
    const links = menu.querySelectorAll("a");

    // ouvrir / fermer au clic
    menuBtn.addEventListener("click", () => {
      menu.classList.toggle("active");
    });

    // fermer après clic sur un lien
    links.forEach(link => {
      link.addEventListener("click", () => {
        menu.classList.remove("active");
      });
    });
  </script>

    <section id="form1">
  <form action="formulario.php" method="post" autocomplete="off">
    <label for="nome">Nome </label>
    <input type="text" id="nome" name="nome" required>
       
    <label for="sobre_nome"> Sobre Nome</label>
    <input type="text" id="sobre_nome" name="sobre_nome" required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" required>

    <label for="empresa">Empresa</label>
    <input type="text" id="empresa" name="empresa">

    <button type="submit" name="enviar">Enviar</button>
      <p style="font-size: 12px; color: #666; margin-top: 10px;">
     
    
  
      
   Ao clicar em "Enviar", você concorda que utilizemos suas informações para entrar em contato com você.
    
  </p>
  </form>
</section>

</body>
</html>