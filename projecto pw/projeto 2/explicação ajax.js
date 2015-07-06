//para reduzir a palavra XMLHttpRequest()
var xhr = new XMLHttpRequest();

//método pra enviar por get
var value1 = encodeURIComponent(value1),
    value2 = encodeURIComponent(value2);

xhr.open('GET', 'http://mon_site_web.com/ajax.php?param1=' + value1 + '1&param2=' + value2); 

//em vez de 
xhr.open('GET', 'http://mon_site_web.com/ajax.php?param1=valeur1&param2=valeur2');

//enviar por post
xhr.open('POST', 'http://mon_site_web.com/ajax.php');
xhr.send('param1=valeur1&param2=valeur2');

//enviar por post mas especificar que vem de um formulario
xhr.open('POST', 'http://mon_site_web.com/ajax.php');
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send('param1=valeur1&param2=valeur2');

//estado dos pedidos
0 : L'objet XHR a été créé, mais pas initialisé (la méthode open() n'a pas encore été appelée).
1 : La méthode open() a été appelée, mais la requête n'a pas encore été envoyée par la méthode send().
2 : La méthode send() a été appelée et toutes les informations ont été envoyées au serveur.
3 : Le serveur traite les informations et a commencé à renvoyer les données. Tous les en-têtes des fichiers ont été reçus.
4 : Toutes les données ont été réceptionnées.

//verificação
De cette manière, notre code ne s'exécutera que lorsque la requête aura terminé son travail. 
Toutefois, même si la requête a terminé son travail, cela ne veut pas forcément dire qu'elle l'a mené à bien, 
pour cela nous allons devoir consulter le statut de la requête grâce à la propriété status. 
Cette dernière renvoie le code correspondant à son statut, comme le fameux 404 pour les fichiers non-trouvés. 
Le statut qui nous intéresse est le 200, qui signifie que tout s'est bien passé :


xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // Votre code...
    }
};

//tratamento dos dados
Une fois la requête terminée, il vous faut récupérer les données obtenues. Ici, deux possibilités s'offrent à vous :
	- Les données sont au format XML, vous pouvez alors utiliser la propriété responseXML qui permet de parcourir 
	l'arbre DOM des données reçues.
	- Les données sont dans un format autre que le XML, il vous faut alors utiliser la propriété responseText qui 
	vous fourni toutes les données sous forme d'une chaîne de caractères. C'est à vous qu'incombe la tâche de faire 
	d'éventuelles conversions, par exemple avec un objet JSON : 
		var response = JSON.parse(xhr.responseText);
		
//exemplo ficheiro xml

<?xml version="1.0" encoding="utf-8"?>
<table>

  <line>
    <cel>Ligne 1 - Colonne 1</cel>
    <cel>Ligne 1 - Colonne 2</cel>
    <cel>Ligne 1 - Colonne 3</cel>
  </line>

  <line>
    <cel>Ligne 2 - Colonne 1</cel>
    <cel>Ligne 2 - Colonne 2</cel>
    <cel>Ligne 2 - Colonne 3</cel>
  </line>

  <line>
    <cel>Ligne 3 - Colonne 1</cel>
    <cel>Ligne 3 - Colonne 2</cel>
    <cel>Ligne 3 - Colonne 3</cel>
  </line>

</table>
//recuperar todos os elementos cel
var cels = xhr.responseXML.getElementsByTagName('cel');