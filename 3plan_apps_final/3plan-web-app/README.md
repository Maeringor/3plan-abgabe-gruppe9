# 3plan-web-app

Das ist die Readme Datei für die 3plan Webapp, welche im Rahmen des Projektes, im Wirtschaftsinformatikgang der THM, erstellt wurde.

# Conventions

## HTML CSS JavaScript

Dateinamen und Ordnernamen werden klein geschrieben und dürfen keine Sonderzeichen (außer _) beinhalten. >**full_file_name; design.css; product.html**
<br>

Schachtelt Seiten in HTML sinnvoll. section umschließt immer eine abgetrennte Area auf einer Seite (Hauptseite: Hero-Section, Our Offer Section, Products Section). In den Sections sind dann div Logiken verschachtelt. So viele divs wie nötig, aber so wenig wie möglich verwenden.
<br>

Javascript Variablen immer in camelCase schreiben. Lieber längere Namen nehmen, die etwas sinnvoll beschreiben.

Bei Css verscuhen wir so viele Klassen wie möglich mehrfach zu verwenden (Zentrale Designs werden in die design.css geschrieben, wie Farben oder Fonts mit Größen).

## PHP
Dateinamen und Ordnernamen werden klein geschrieben und dürfen keine Sonderzeichen (außer _) beinhalten. >**full_file_name; product.php login_dao.php**
<br>

Variablen werden mit _ getrennt. Lieber längere Namen nehmen, die etwas sinnvoll beschreiben.
<br>

Für jeden Service wird eine eigene php Datei angelegt. Services sind z.B. Änderungen an der Datenbank oder Login Registrieren etc. Solche Funktionalitäten dürfen auf keinen Fall in der html Seite liegen (Bsp: login.php besitzt eine dazugehörige login_dao.php).