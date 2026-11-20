# Reponses TP 5 - PHP PDO

- Nom : SLIKOU
- Prenom : AISSA
- Groupe : G3
- Etablissement : FSSM

## Partie 1 : creation de la base

J'ai importe le fichier `creation_base.sql` dans phpMyAdmin. Il cree la base
`gestion_etudiants` et la table `etudiants` avec 3 exemples.

Le CNE et l'adresse e-mail sont uniques pour eviter d'avoir deux fois le meme etudiant.

## Partie 2 : connexion PDO

Le DSN contient le serveur, le port, le nom de la base et l'encodage.

J'ai utilise `PDO::ERRMODE_EXCEPTION` pour voir les erreurs et `PDO::FETCH_ASSOC`
pour recuperer les colonnes avec leurs noms.

Le bloc `try/catch` sert a afficher un message si la connexion ne marche pas.

## Partie 3 : ajout d'un etudiant

Le formulaire est traite seulement avec la methode POST. Les donnees sont nettoyees
avec `trim()` puis verifiees avant l'insertion.

La requete preparee protege contre l'injection SQL. `bindValue()` permet de donner
une valeur a chaque parametre. Si la date est vide j'envoie `NULL`.

`lastInsertId()` donne l'identifiant du dernier etudiant ajoute.

Le code 1062 correspond a un doublon, par exemple un CNE deja utilise.

## Partie 4 : affichage

`query()` est suffisante quand la requete ne contient pas de valeur saisie par
l'utilisateur. `fetchAll()` recupere tous les etudiants dans un tableau.

La fonction `e()` protege les valeurs avant de les afficher dans le HTML.

## Partie 5 : bonus

Pour le filtre j'ai utilise une requete preparee avec `bindParam()`.

La suppression se fait en POST et pas en GET, parce qu'elle modifie la base.
`rowCount()` permet de verifier si une ligne a vraiment ete supprimee.

## Petite conclusion

PDO permet de se connecter a MySQL et d'executer des requetes plus facilement.
Les requetes preparees sont importantes pour la securite de l'application.

Je n'ai pas ajoute de protection CSRF pour la suppression et le message d'erreur
de connexion affiche encore le detail technique.
