# Créer des Categories
- Créer une nouvelle entité Category
    name:string:255:not_null
    createdAt:datetime_immutable:not_null
    color:string:6:null
- Générer le fichier de migration
- mettre à jour la DB
- Faire un nouveau controller CategoryController
- Dans ce controller, faire une fonction permettant d'insérer une categorie en base de données
- Dans ce controller, faire une nouvelle fonction pour afficher toutes les categories
- faire une fonction pour afficher le détail d'une catégorie

https://symfony.com/doc/current/index.html
php bin/console list make
php bin/console list doctrine