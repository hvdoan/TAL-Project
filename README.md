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

**Où** :          <br>Dans le dossier `/Model/Message.class.php` implémentation des methods `addNotifyUser()`et `unsetNotifyUser()` permettant d'ajouter et de retirer les users de la liste d'envoie qui se fait par la method `notify()` qui appelle `sendNotificationMail()` se trouvant dans `/Model/User.class.php` demandant un objet Message et un objet User et envoyant un mail à l'aide de PHPMailer au User passé en paramètre.<br>

**Pourquoi** : <br>L'Observer nous permet d'envoyer facilement un mail à la personne qui recoit une réponse a un des ses commentaires dans les forums du site, ce qui lui permet d'aller répondre directement.<br><br>


### Iterator

**Utilisation** : <br>Facilite le parcours d'une collection. Exemple d'utilisation : parcours de la collection des pages pour la génération d'un SiteMap<br>

**Où** :          <br>Dans le dossier `/Core/Iterator/PageIterator.php`, on l'appel dans le `/Controller/config.class.php` dans la méthode SiteMapGeneration() generation (ligne 172)<br>

**Pourquoi** : <br>L'iterator permet de faciliter l'ensemble des données d'un modèle chargé et évite les erreurs lors de boucle dans le code. Cela ajoute aussi de la flexibilité au code.<br><br>
