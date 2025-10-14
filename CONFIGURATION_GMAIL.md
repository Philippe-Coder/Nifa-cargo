# 📧 Configuration Gmail pour l'envoi d'emails

## Étape 1 : Créer un mot de passe d'application Gmail

### 1. Activer la validation en deux étapes
1. Allez sur https://myaccount.google.com/security
2. Cliquez sur **"Validation en deux étapes"**
3. Suivez les instructions pour l'activer (si ce n'est pas déjà fait)

### 2. Générer un mot de passe d'application
1. Retournez sur https://myaccount.google.com/security
2. Cliquez sur **"Mots de passe des applications"**
3. Sélectionnez **"Autre (nom personnalisé)"**
4. Tapez : `NIF Cargo Laravel`
5. Cliquez sur **"Générer"**
6. **Copiez le mot de passe de 16 caractères** (ex: `abcd efgh ijkl mnop`)

## Étape 2 : Configurer le fichier .env

Ouvrez le fichier `.env` à la racine du projet et modifiez ces lignes :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=abcdefghijklmnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="votre-email@gmail.com"
MAIL_FROM_NAME="NIF Cargo"
```

**Remplacez :**
- `votre-email@gmail.com` par votre adresse Gmail
- `abcdefghijklmnop` par le mot de passe d'application généré (sans espaces)

## Étape 3 : Vider le cache de configuration

Exécutez cette commande dans le terminal :

```bash
php artisan config:clear
```

## Étape 4 : Tester l'envoi d'email

### Option 1 : Via l'interface admin
1. Connectez-vous en tant qu'admin
2. Ouvrez une demande de transport
3. Changez le statut d'une étape
4. Le client devrait recevoir un email

### Option 2 : Via la route de test
Visitez dans votre navigateur (connecté) :
```
http://127.0.0.1:8000/test-notification/3
```
(Remplacez `3` par l'ID d'un utilisateur)

## 📱 Configuration WhatsApp (CallMeBot)

### Enregistrer votre numéro WhatsApp

1. **Ajoutez le contact CallMeBot** dans WhatsApp :
   - Numéro : `+34 644 24 95 07`
   - Nom : CallMeBot

2. **Envoyez ce message exact** :
   ```
   I allow callmebot to send me messages
   ```

3. **Vous recevrez une réponse** avec votre clé API (ex: `123456`)

4. **Mettez à jour la clé API** dans le fichier :
   `app/Services/NotificationService.php` ligne 212 :
   ```php
   'apikey'=> 'VOTRE_CLE_API'  // Remplacez par votre clé
   ```

### Format du numéro de téléphone

Le numéro doit être au format international **sans le +** :
- ✅ Correct : `22890688653`
- ❌ Incorrect : `+22890688653` ou `90688653`

## ✅ Vérification

### Les notifications utilisent automatiquement :
- ✅ **Email** : `$user->email` (enregistré lors de l'inscription)
- ✅ **Téléphone** : `$user->telephone` (enregistré lors de l'inscription)
- ✅ **Nom** : `$user->name` (pour personnaliser les messages)

### Code de vérification dans NotificationService.php :

```php
// Ligne 255 : Récupération de l'utilisateur
$user = $demande->user;

// Ligne 178 : Envoi email à l'adresse enregistrée
$mail->to($user->email)

// Ligne 210 : Envoi WhatsApp au numéro enregistré
'phone' => $user->telephone
```

## 🔍 Dépannage

### Les emails ne partent pas ?
1. Vérifiez que le mot de passe d'application est correct (sans espaces)
2. Vérifiez que la validation en deux étapes est activée sur Gmail
3. Consultez les logs : `storage/logs/laravel.log`
4. Exécutez : `php artisan config:clear`

### Les WhatsApp ne partent pas ?
1. Vérifiez que le numéro est enregistré sur CallMeBot
2. Vérifiez le format du numéro (sans le +)
3. Vérifiez que la clé API est correcte
4. Consultez les logs : `storage/logs/laravel.log`

### Voir les notifications en base de données
```sql
SELECT * FROM notifications ORDER BY created_at DESC LIMIT 10;
```

Les colonnes importantes :
- `statut` : `en_attente`, `envoyee`, ou `echouee`
- `erreur` : Message d'erreur si échec
- `type` : `email` ou `whatsapp`

## 📝 Notes importantes

- Les notifications sont envoyées **automatiquement** à chaque changement de statut d'étape
- Les informations (email, téléphone) sont **récupérées depuis la table users**
- Tous les envois sont **loggés** dans `storage/logs/laravel.log`
- Les notifications sont **sauvegardées** dans la table `notifications`
