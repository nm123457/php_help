<?php
include "coreFunctions.php";
?>

<head>
	<meta charset="iso 8859-2">
	<meta name="Krutilla Zsolt" content="Web programozás">
	<title>Web programozás</title>
	<link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>
<header>Web programozás</header>

<body>
	<?php
	if (SessionFunctions::getUserLogin() != null) {
		print("<section><h2>Bejelentkezve mint: <i><b>" . SessionFunctions::getUserFullName() . "</b></i>");
		print("<button onclick=\"document.location='logout.php'\" class='sajatGombKilep'>Kijelentkezés</button></h2></section>");
	?>
		<nav>
			<?php
			switch (SessionFunctions::getAccess()) {
				case "admin":
					print("<button onclick=\"document.location='./admin/felhasznaloAdd.php'\">Új felhasználó</button>");
					print("<button onclick=\"document.location='./admin/felhasznalok.php'\">Loginok</button>");
					print("<button onclick=\"document.location='./admin/userAdmin.php'\">Felhasználók</button>");
					print("<button onclick=\"document.location='export.php'\">Exportálás</button>");
					break;
				case "vip":
					print("<button onclick=\"document.location='webprog.php'\">VIP oldal</button>");
					break;
			}
			print("<button onclick=\"document.location='letoltesek.php'\">Letöltések</button>");
		} else {
			?>
			<nav>
			<?php
			print("<button onclick=\"document.location='login.php'\">Bejelentkezés</button>");
		} ?>
			</nav>
			<br><br><br>
			<div>
				<h1>Web programozás</h1>
				<p style="
			color: black;
			font-size: 1.5rem;
			text-decoration: none;">A labor 10 alkalmával egy kész webalkalmazást veszünk át.</p><br>
				<h2>Oldal használata</h2>
				<p style="
		color: black;
		font-size: 1.5rem;
		text-decoration: none;">A felületet bejelentkezés után lehet használni, felhasználónév és jelszó megadását követően. A felhasználókat felvenni kizárólag adminisztrátori jogosultsággal van lehetőség,
					azaz az oldal szerepköröket különböztet meg, melyek külön-külön funkciókkal rendelkeznek.
				</p>
			</div>
</body>