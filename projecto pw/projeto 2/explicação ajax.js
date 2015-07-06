//para reduzir a palavra XMLHttpRequest()
var xhr = new XMLHttpRequest();

//m�todo pra enviar por get
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
0 : L'objet XHR a �t� cr��, mais pas initialis� (la m�thode open() n'a pas encore �t� appel�e).
1 : La m�thode open() a �t� appel�e, mais la requ�te n'a pas encore �t� envoy�e par la m�thode send().
2 : La m�thode send() a �t� appel�e et toutes les informations ont �t� envoy�es au serveur.
3 : Le serveur traite les informations et a commenc� � renvoyer les donn�es. Tous les en-t�tes des fichiers ont �t� re�us.
4 : Toutes les donn�es ont �t� r�ceptionn�es.

//verifica��o
De cette mani�re, notre code ne s'ex�cutera que lorsque la requ�te aura termin� son travail. 
Toutefois, m�me si la requ�te a termin� son travail, cela ne veut pas forc�ment dire qu'elle l'a men� � bien, 
pour cela nous allons devoir consulter le statut de la requ�te gr�ce � la propri�t� status. 
Cette derni�re renvoie le code correspondant � son statut, comme le fameux 404 pour les fichiers non-trouv�s. 
Le statut qui nous int�resse est le 200, qui signifie que tout s'est bien pass� :


xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        // Votre code...
    }
};

//tratamento dos dados
Une fois la requ�te termin�e, il vous faut r�cup�rer les donn�es obtenues. Ici, deux possibilit�s s'offrent � vous :
	- Les donn�es sont au format XML, vous pouvez alors utiliser la propri�t� responseXML qui permet de parcourir 
	l'arbre DOM des donn�es re�ues.
	- Les donn�es sont dans un format autre que le XML, il vous faut alors utiliser la propri�t� responseText qui 
	vous fourni toutes les donn�es sous forme d'une cha�ne de caract�res. C'est � vous qu'incombe la t�che de faire 
	d'�ventuelles conversions, par exemple avec un objet JSON : 
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