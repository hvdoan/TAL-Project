# TAL-Project

## Design Patterns

### Singleton

**Utilisation** : <br>Instance unique de PDO et fichier de log.<br>

**Où** :          <br>Pour PDO dans le dossier `/Core/PDO.class.php` pour la déclaration du singleton et dans `/Core/Sql.class.php` ligne 13 pour son utilisation.<br>
                      Pour le logger, dans le dossier `/Core/Logger.class.php` pour la déclaration et un exemple d'utilisation à la ligne 81 dans /Controller/User.class.php<br>
                      
**Pourquoi** : <br>Le singleton permet de n'avoir qu'une seul instance d'une class, ce qui dans le cas du PDO évite d'ouvrir une connexion à la base de données a chaque requêtes. Pour le Logger, cela permet d'éviter des erreurs 500, en évitant d'ouvrir un fichier déjà ouvert auparavant.<br><br>


### Query Builder

**Utilisation** : <br>Fabrication rapide et facile des query SQL<br>

**Où** :          <br>Dans le dossier `/Core/QueryBuilder.class.php` pour l'interface avec les method a implémenter. Dans `/Core/MySqlBuilder.class.php` on retrouve l’implémentation de l'interface QueryBuilder avec toutes les méthodes pour une BDD avec MySql. On retoruve des cas d'utilisation dans le fichier `/Core/Sql.class.php` dans la fonction save ligne 39. La fonction save peut être utilisé a partir des models, ce qui fait de sfonctions générique pour sauvegarder des données. Un cas plus spécifique avec des orderBy ou des leftJoin est présent dans `Controller/Admin.class.php` lignes 70 à 82.<br>

**Pourquoi** : <br>Le QueryBuilder nous permet de changer facilement entrent différents SGBD comme par exemple MySql et PostGreSql qui n'ont pas forcément les mêmes syntaxe. Il suffit juste de modifier les appels a la classe MySql a la classe PostGreSql sans avoir a toucher au query.<br><br>


### Observer

**Utilisation** : <br>Permet l'envoie de mail en cas de réponse a un message dans le forum<br>

**Où** :          <br><br>

**Pourquoi** : <br>L'Observer nous permet d'envoyer facilement un mail à la personne qui recoit une réponse a un des ses commentaires dans les forums du site, ce qui lui permet d'aller répondre directement.<br><br>


### Iterator

**Utilisation** : <br><br>

**Où** :          <br><br>

**Pourquoi** : <br><br><br>
