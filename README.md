# Application permettant de faire du SSE (Server Sent Event)

## Démarrage du projet
Utiliser le docker-compose.yml qui : 
- démarre une base de donnée postgres
- démarre un mercure hub

Le mercure hub local est maintenant accessible [à cette adresse](http://localhost:3000)

J'utilise le bundle symfony/mercure-bundle pour communiquer avec le hub de mercure

installer le bundle avec la commande

```
composer require mercure
```

[voir ProductController](./src/Controller/ProductController.php) 

## Utilisation
Il faut maintenant démarrer le [server client](./sse-client)
Pour générer un message SSE, il faut créer un produit dans cette démo

Pour cela faire un POST - http://localhost:8080/products