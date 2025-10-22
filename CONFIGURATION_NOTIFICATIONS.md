# Configuration des Notifications - NIF CARGO

## 📧 Configuration Gmail SMTP

### 1. Activer l'authentification à 2 facteurs Gmail
1. Allez sur votre compte Google : https://myaccount.google.com
2. Sécurité → Authentification à 2 facteurs → Activer

### 2. Créer un mot de passe d'application
1. Sécurité → Authentification à 2 facteurs → Mots de passe d'applications
2. Sélectionner "Mail" → "Autre" → "Laravel NIF Cargo"
3. Copier le mot de passe généré (16 caractères)

### 3. Configuration .env
```env
# Configuration Email Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-application-16-caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="NIF CARGO - Transport & Logistique"
```

## 📱 Configuration WhatsApp (3 Options)

### Option 1: CallMeBot (GRATUIT - Recommandé pour débuter)

#### Avantages:
- ✅ Gratuit
- ✅ Simple à configurer
- ✅ Pas de validation métier

#### Étapes:
1. Ajouter ce numéro WhatsApp: +34 644 94 50 22
2. Envoyer le message: "I allow callmebot to send me messages"
3. Aller sur: https://www.callmebot.com/blog/free-api-whatsapp-messages/
4. Saisir votre numéro, récupérer votre API Key

#### Configuration .env:
```env
# CallMeBot WhatsApp (Gratuit)
CALLMEBOT_API_KEY=votre-cle-api-callmebot
```

### Option 2: Twilio (PAYANT mais très fiable)

#### Avantages:
- ✅ Très fiable
- ✅ API robuste
- ✅ Support professionnel

#### Étapes:
1. Créer compte sur: https://www.twilio.com
2. Console → Account → Account Info → Récupérer SID et Auth Token
3. Phone Numbers → Manage → WhatsApp → Request Access
4. Acheter un numéro WhatsApp (environ $1/mois)

#### Configuration .env:
```env
# Twilio WhatsApp (Payant)
TWILIO_SID=your-account-sid
TWILIO_AUTH_TOKEN=your-auth-token
TWILIO_WHATSAPP_NUMBER=whatsapp:+14155238886
```

### Option 3: WhatsApp Cloud API (Officiel Meta - RECOMMANDÉ ENTREPRISE)

#### Avantages clés:
- ✅ Officiel Meta, robuste et évolutif
- ✅ Peut envoyer à un numéro qui n'a jamais écrit (via Templates approuvés)
- ✅ Idéal pour notifications transactionnelles (suivi, mises à jour)

#### Étapes rapides:
1. Ouvrez https://business.facebook.com → Créez/ouvrez un Business
2. Allez sur https://developers.facebook.com → Créez une App → Ajoutez le produit WhatsApp
3. Dans WhatsApp → Obtenez: Phone Number ID, Temporary Token (remplacez par Permanent Token via System User)
4. Créez un Template (ex: `shipment_update`, langue `fr`) avec variables

#### Configuration .env:
```env
# WhatsApp Cloud API (Meta)
WHATSAPP_ACCESS_TOKEN=EAAG...  # Token permanent
WHATSAPP_PHONE_NUMBER_ID=123456789012345
WHATSAPP_TEMPLATE_NAME=shipment_update
WHATSAPP_TEMPLATE_LANG=fr
DEFAULT_PHONE_COUNTRY_CODE=+228
```

Note importante: Pour le premier message (pas de fenêtre 24h), vous DEVEZ utiliser un Template approuvé. Les messages texte libres fonctionnent quand l'utilisateur a écrit dans les dernières 24h.

## 🛠️ Test des Notifications

### 1. Créer un contrôleur de test
```bash
php artisan make:controller TestNotificationController
```

### 2. Route de test (déjà créée)
```
GET /admin/test-notifications/{demande}
```

### 3. Test Email seulement
```
GET /admin/test-email/{demande}
```

### 4. Test WhatsApp seulement
```
GET /admin/test-whatsapp/{demande}
```

## 📋 Recommandations par Budget

### Budget 0€ (Gratuit)
1. **Email**: Gmail SMTP (gratuit)
2. **WhatsApp**: CallMeBot (gratuit, 3000 msg/mois)

### Budget 10-50€/mois
1. **Email**: Gmail SMTP (gratuit)
2. **WhatsApp**: Twilio (~1€/mois + 0.005€/message)

### Budget >50€/mois
1. **Email**: Gmail SMTP ou SendGrid
2. **WhatsApp**: WhatsApp Business API (gratuit mais développement requis)

## 🔍 Dépannage

### Problèmes Email
- Vérifier les credentials Gmail
- Contrôler les logs Laravel: `storage/logs/laravel.log`
- Tester avec: `php artisan tinker` puis `Mail::raw('test', fn($m) => $m->to('email@test.com')->subject('Test'));`

### Problèmes WhatsApp
- Vérifier le format du numéro de téléphone
- S'assurer que l'API key est valide
- Contrôler les logs d'erreur

## 🚀 Déploiement

1. Mettre à jour le fichier `.env`
2. Redémarrer les queues: `php artisan queue:restart`
3. Vider les caches: `php artisan cache:clear`
4. Tester les notifications avec l'interface admin