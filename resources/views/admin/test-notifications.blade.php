@extends('layouts.admin')

@section('title', 'Test des Notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">🧪 Test des Notifications</h1>
            </div>
            
            <!-- Configuration Status -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">📧 Configuration Email</h5>
                        </div>
                        <div class="card-body" id="email-config">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Chargement...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">📱 Configuration WhatsApp</h5>
                        </div>
                        <div class="card-body" id="whatsapp-config">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Chargement...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Test des demandes -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">🚛 Sélectionner une demande pour tester</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="demandes-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Référence</th>
                                            <th>Client</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Marchandise</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($demandes as $demande)
                                        <tr>
                                            <td>{{ $demande->id }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </td>
                                            <td>{{ $demande->user->name }}</td>
                                            <td>{{ $demande->user->email }}</td>
                                            <td>
                                                <span class="badge {{ $demande->user->telephone ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $demande->user->telephone ?? 'Non renseigné' }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($demande->marchandise, 30) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="testAll({{ $demande->id }})">
                                                        📧📱 Tout tester
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-sm" onclick="testEmail({{ $demande->id }})">
                                                        📧 Email
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-sm" onclick="testWhatsApp({{ $demande->id }})" 
                                                            {{ $demande->user->telephone ? '' : 'disabled' }}>
                                                        📱 WhatsApp
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Résultats des tests -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">📊 Résultats des Tests</h5>
                        </div>
                        <div class="card-body" id="test-results">
                            <p class="text-muted">Aucun test effectué pour le moment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Charger la configuration au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    loadConfiguration();
});

// Charger la configuration
function loadConfiguration() {
    fetch('/admin/test/config')
        .then(response => response.json())
        .then(data => {
            displayEmailConfig(data.email);
            displayWhatsAppConfig(data.whatsapp);
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('email-config').innerHTML = '<div class="alert alert-danger">Erreur de chargement</div>';
            document.getElementById('whatsapp-config').innerHTML = '<div class="alert alert-danger">Erreur de chargement</div>';
        });
}

// Afficher la configuration Email
function displayEmailConfig(config) {
    const html = `
        <div class="row">
            <div class="col-6"><strong>Status:</strong></div>
            <div class="col-6">${config.status}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>Host:</strong></div>
            <div class="col-6">${config.host || 'N/A'}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>Port:</strong></div>
            <div class="col-6">${config.port || 'N/A'}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>Username:</strong></div>
            <div class="col-6">${config.username || 'Non configuré'}</div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <button class="btn btn-outline-info btn-sm" onclick="testEmailConnection()">
                    🔌 Tester Connexion
                </button>
            </div>
        </div>
    `;
    document.getElementById('email-config').innerHTML = html;
}

// Afficher la configuration WhatsApp
function displayWhatsAppConfig(config) {
    const html = `
        <div class="row">
            <div class="col-12"><strong>Méthode Active:</strong> <span class="badge badge-primary">${config.active_method}</span></div>
        </div>
        <div class="row mt-2">
            <div class="col-6"><strong>Twilio:</strong></div>
            <div class="col-6">${config.twilio.status}</div>
        </div>
        <div class="row">
            <div class="col-6"><strong>CallMeBot:</strong></div>
            <div class="col-6">${config.callmebot.status}</div>
        </div>
    `;
    document.getElementById('whatsapp-config').innerHTML = html;
}

// Test complet (Email + WhatsApp)
function testAll(demandeId) {
    showLoading();
    fetch(`/admin/test/notifications/${demandeId}`)
        .then(response => response.json())
        .then(data => displayTestResult(data, 'Test Complet'))
        .catch(error => displayError(error));
}

// Test Email uniquement
function testEmail(demandeId) {
    showLoading();
    fetch(`/admin/test/email/${demandeId}`)
        .then(response => response.json())
        .then(data => displayTestResult(data, 'Test Email'))
        .catch(error => displayError(error));
}

// Test WhatsApp uniquement
function testWhatsApp(demandeId) {
    showLoading();
    fetch(`/admin/test/whatsapp/${demandeId}`)
        .then(response => response.json())
        .then(data => displayTestResult(data, 'Test WhatsApp'))
        .catch(error => displayError(error));
}

// Test connexion email
function testEmailConnection() {
    showLoading();
    fetch('/admin/test/email-connection')
        .then(response => response.json())
        .then(data => displayTestResult(data, 'Test Connexion Email'))
        .catch(error => displayError(error));
}

// Afficher le résultat du test
function displayTestResult(data, testType) {
    const timestamp = new Date().toLocaleTimeString();
    const alertClass = data.status === 'success' ? 'alert-success' : 'alert-danger';
    
    let html = `
        <div class="alert ${alertClass}">
            <h6><strong>${testType}</strong> - ${timestamp}</h6>
            <p><strong>Status:</strong> ${data.status}</p>
            <p><strong>Message:</strong> ${data.message}</p>
    `;
    
    if (data.results) {
        html += `
            <div class="mt-2">
                <strong>Résultats détaillés:</strong>
                <ul class="mb-0">
                    ${data.results.email !== undefined ? `<li>Email: ${data.results.email ? '✅ Envoyé' : '❌ Échec'}</li>` : ''}
                    ${data.results.whatsapp !== undefined ? `<li>WhatsApp: ${data.results.whatsapp ? '✅ Envoyé' : '❌ Échec'}</li>` : ''}
                    ${data.results.errors && data.results.errors.length > 0 ? `<li class="text-danger">Erreurs: ${data.results.errors.join(', ')}</li>` : ''}
                </ul>
            </div>
        `;
    }
    
    html += '</div>';
    
    document.getElementById('test-results').innerHTML = html + document.getElementById('test-results').innerHTML;
}

// Afficher les erreurs
function displayError(error) {
    const timestamp = new Date().toLocaleTimeString();
    const html = `
        <div class="alert alert-danger">
            <h6><strong>Erreur</strong> - ${timestamp}</h6>
            <p>${error.message || 'Erreur inconnue'}</p>
        </div>
    `;
    
    document.getElementById('test-results').innerHTML = html + document.getElementById('test-results').innerHTML;
}

// Afficher le chargement
function showLoading() {
    const html = `
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <div class="spinner-border spinner-border-sm mr-2" role="status"></div>
                <span>Test en cours...</span>
            </div>
        </div>
    `;
    
    document.getElementById('test-results').innerHTML = html + document.getElementById('test-results').innerHTML;
}
</script>
@endsection