# 📱 Configuration WhatsApp 360dialog - NIF CARGO

## 🎯 **Status Actuel**
✅ **API Key configurée** : `1V643QZ5YXTZBYF4KK91G56QMGECWV8D`  
✅ **URL Sandbox** : `https://waba-sandbox.360dialog.io`  
✅ **Format API** : Compatible WhatsApp Cloud API (Meta)  

## 📋 **Configuration .env**
```env
# Configuration 360dialog
WHATSAPP_360_API_KEY=1V643QZ5YXTZBYF4KK91G56QMGECWV8D
WHATSAPP_360_BASE_URL=https://waba-sandbox.360dialog.io
```

## 🔧 **Résolution des Problèmes**

### ❌ Erreur: "Forbidden: can only send to your verified number"
**Cause** : En mode sandbox, vous ne pouvez envoyer qu'à votre numéro vérifié.

**Solutions** :
1. **Vérifiez votre numéro** sur la plateforme 360dialog
2. **Utilisez votre numéro vérifié** pour les tests
3. **Passez en production** pour envoyer à tous les numéros

### ❌ Erreur: "The parameter messaging_product is required"
**Cause** : L'API 360dialog utilise le format Meta WhatsApp Cloud API.

**✅ Solution appliquée** :
```php
$payload = [
    'messaging_product' => 'whatsapp',  // ← Paramètre requis
    'to' => $phone,
    'type' => 'text',
    'text' => [
        'body' => $message
    ]
];
```

## 🧪 **Tests**

### **Test Local**
```
URL: http://127.0.0.1:8000/test-whatsapp?phone=+VOTRE_NUMERO_VERIFIE
```

### **Test Production**
```
URL: https://nifgroupecargo.com/test-whatsapp?phone=+VOTRE_NUMERO_VERIFIE
```

## 📞 **Vérification de Numéro**

### **Étapes pour vérifier votre numéro** :
1. Connectez-vous sur le portail 360dialog
2. Allez dans "Phone Numbers" ou "Numéros"
3. Ajoutez votre numéro WhatsApp
4. Suivez la procédure de vérification (OTP)
5. Attendez l'approbation

### **Numéros recommandés à vérifier** :
- Votre numéro personnel WhatsApp
- Le numéro WhatsApp de l'entreprise
- Un numéro de test dédié

## 🚀 **Mise en Production**

### **Pour passer du Sandbox à la Production** :
1. **Complétez la vérification business** sur 360dialog
2. **Mettez à jour l'URL** :
   ```env
   WHATSAPP_360_BASE_URL=https://waba-v1.360dialog.io
   ```
3. **Obtenez l'API Key de production**
4. **Testez avec plusieurs numéros**

## 📊 **Monitoring et Logs**

### **Logs de succès** :
```
✅ Email envoyé avec succès à email@example.com
📱 Utilisation 360dialog pour WhatsApp dans NotificationService
📱 WhatsApp 360dialog envoyé avec succès à +228XXXXXXXX
```

### **Logs d'erreur** :
```
❌ Erreur WhatsApp 360dialog: Erreur 360dialog API: {"detail":"Forbidden: can only send to your verified number"}
```

## 🔄 **Fallback System**

Le système utilise un fallback intelligent :
1. **360dialog** (Priorité 1) ← Actuellement configuré
2. **Meta WhatsApp Cloud API** (Priorité 2)
3. **Twilio** (Priorité 3)
4. **CallMeBot** (Priorité 4)

## 🛠️ **Configuration Recommandée pour Production**

```env
# Production 360dialog
WHATSAPP_360_API_KEY=votre-cle-production
WHATSAPP_360_BASE_URL=https://waba-v1.360dialog.io

# Backup CallMeBot (gratuit)
CALLMEBOT_API_KEY=votre-cle-callmebot

# Normalisation numéros
DEFAULT_PHONE_COUNTRY_CODE=+228
```

---

**💡 Conseil** : Gardez CallMeBot configuré comme backup gratuit pour les tests et développement !