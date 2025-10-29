<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Bienvenue') }} - {{ __('NIF CARGO - Transport & Logistique') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e6f2ff 0%, #f0f8ff 100%);
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        
        .container:hover {
            transform: translateY(-5px);
        }
        
        .header {
            background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #64b5f6, #bbdefb);
        }
        
        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .logo-subtitle {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
        }
        
        .content {
            padding: 30px;
        }
        
        .greeting {
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .highlight-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .credentials-box {
            background-color: #f5fbff;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
        }
        
        .credentials-title {
            color: #1565c0;
            margin-bottom: 15px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .credential-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }
        
        .credential-icon {
            width: 40px;
            height: 40px;
            background-color: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #1565c0;
        }
        
        .password {
            font-family: 'Courier New', monospace;
            background-color: #f5f5f5;
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #1565c0;
        }
        
        .warning-box {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        
        .warning-icon {
            color: #ff9800;
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #2196f3 0%, #0d47a1 100%);
            color: white;
            padding: 14px 35px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
            letter-spacing: 0.5px;
        }
        
        .button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
        }
        
        .features {
            margin: 30px 0;
        }
        
        .features-title {
            color: #1565c0;
            margin-bottom: 20px;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .features-list {
            list-style: none;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px 15px;
            background-color: #f8fdff;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .feature-item:hover {
            background-color: #e3f2fd;
            transform: translateX(5px);
        }
        
        .feature-icon {
            width: 36px;
            height: 36px;
            background-color: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #1565c0;
            flex-shrink: 0;
        }
        
        .footer {
            background-color: #f5f9ff;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e3f2fd;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1565c0;
            font-weight: 500;
        }
        
        .copyright {
            font-size: 14px;
            color: #78909c;
            margin-top: 20px;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 15px;
            }
            
            .credential-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .credential-icon {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">NIF CARGO</div>
            <div class="logo-subtitle">{{ __('NIF CARGO - Transport & Logistique') }}</div>
            <h2>{{ __('Bienvenue') }} {{ __('Mon Compte') }} !</h2>
        </div>
        
        <div class="content">
            <div class="greeting">
                <p>{{ __('Hello!') }} <strong>{{ $client_name }}</strong>,</p>
            </div>
            
            <div class="highlight-box">
                <p><i class="fas fa-trophy" style="color: #ffc107; margin-right: 8px;"></i> <strong>{{ __('Opération réussie !') }}</strong> {{ __('Votre partenaire de confiance pour tous vos besoins de transport') }}.</p>
            </div>
            
            <p>{{ __('Votre partenaire de confiance pour tous vos besoins de transport') }}.</p>
            
            <div class="credentials-box">
                <div class="credentials-title">
                    <i class="fas fa-key"></i>
                    <span>{{ __('Connexion') }} :</span>
                </div>
                
                <div class="credential-item">
                    <div class="credential-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <strong>{{ __('Email') }} :</strong> {{ $email }}
                    </div>
                </div>
                
                <div class="credential-item">
                    <div class="credential-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <strong>{{ __('Password') }} :</strong> 
                        <span class="password">{{ $password }}</span>
                    </div>
                </div>
            </div>
            
            <div class="warning-box">
                <div class="warning-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <p><strong>{{ __('Information') }} :</strong> {{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                </div>
            </div>
            
            <div class="button-container">
                <a href="{{ $login_url }}" class="button">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                    {{ __('Connexion') }}
                </a>
            </div>
            
            <div class="features">
                <div class="features-title">
                    <i class="fas fa-rocket"></i>
                    <span>{{ __('Nos Services') }}</span>
                </div>
                
                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <span>{{ __('Suivre un Colis') }}</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <span>{{ __('Mes Demandes') }}</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-file-download"></i>
                        </div>
                        <span>{{ __('Files') }}</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <span>{{ __('Notifications') }}</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <span>{{ __('Contact') }}</span>
                    </li>
                </ul>
            </div>
            
            <p>{{ __('NIF CARGO est votre partenaire de confiance pour tous vos besoins de transport et de logistique au Togo et dans la région.') }}</p>
        </div>
        
        <div class="footer">
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span>+228 99 25 25 31 / +229 96 36 46 07 / +226 05 79 13 10</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>contact@nifgroupecargo.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Totsi, Lomé - Togo</span>
                </div>
            </div>
            
            <div class="copyright">
                © {{ date('Y') }} NIF CARGO - Transport et Logistique
            </div>
        </div>
    </div>
</body>
</html>