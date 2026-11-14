<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao EcoPoint</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #2d3748;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f4f6fa;
            padding: 30px 15px;
            box-sizing: border-box;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #0618b9 0%, #04108a 100%);
            padding: 32px 28px;
            text-align: center;
            color: #ffffff;
        }
        .brand-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.05em;
            margin: 0;
            color: #ffffff;
            text-transform: uppercase;
        }
        .brand-title span {
            color: #76C1C3;
        }
        .brand-slogan {
            font-size: 11px;
            letter-spacing: 0.12em;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 6px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .body-content {
            padding: 32px 30px;
            line-height: 1.6;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            margin-top: 0;
            margin-bottom: 14px;
        }
        .text {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 20px;
        }
        .credentials-card {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 10px;
            padding: 20px;
            margin: 24px 0;
        }
        .credentials-title {
            font-size: 13px;
            font-weight: 700;
            color: #0618b9;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 0;
            margin-bottom: 14px;
        }
        .credential-item {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .credential-item:last-child {
            margin-bottom: 0;
        }
        .credential-label {
            font-weight: 600;
            color: #4a5568;
            display: inline-block;
            width: 130px;
        }
        .credential-value {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            background-color: #ffffff;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-weight: 600;
        }
        .btn-wrapper {
            text-align: center;
            margin: 30px 0 20px;
        }
        .btn {
            display: inline-block;
            background-color: #0618b9;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            padding: 13px 32px;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            box-shadow: 0 4px 12px rgba(6, 24, 185, 0.25);
        }
        .alert-box {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #92400e;
            margin-top: 24px;
            line-height: 1.5;
        }
        .footer {
            background-color: #f8fafc;
            padding: 22px 28px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            line-height: 1.6;
        }
        .footer a {
            color: #0618b9;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- HEADER -->
            <div class="header">
                <div class="brand-title">Eco<span>Point</span></div>
                <div class="brand-slogan">Seu livro, no próximo ponto</div>
            </div>

            <!-- BODY CONTENT -->
            <div class="body-content">
                <h1 class="greeting">Olá, {{ $nome }}!</h1>
                <p class="text">
                    Sua instituição foi cadastrada com sucesso como organização parceira na plataforma <strong>EcoPoint</strong>.
                </p>
                <p class="text">
                    A partir de agora, você pode cadastrar e gerenciar seus pontos de coleta de livros escolares e didáticos, acompanhar métricas e receber doações da comunidade.
                </p>

                <!-- CREDENTIALS BOX -->
                <div class="credentials-card">
                    <div class="credentials-title">Seus Dados de Acesso ao Sistema</div>
                    
                    <div class="credential-item">
                        <span class="credential-label">E-mail de Login:</span>
                        <span class="credential-value">{{ $email }}</span>
                    </div>

                    <div class="credential-item">
                        <span class="credential-label">Senha Temporária:</span>
                        <span class="credential-value">{{ $senhaTemporaria }}</span>
                    </div>
                </div>

                <!-- CTA BUTTON -->
                <div class="btn-wrapper">
                    <a href="{{ url('/login') }}" class="btn" target="_blank">
                        Acessar a Plataforma &rarr;
                    </a>
                </div>

                <!-- SECURITY NOTICE -->
                <div class="alert-box">
                    <strong>Importante:</strong> Por motivos de segurança, recomendamos que você altere sua senha logo após o primeiro acesso à plataforma.
                </div>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <p style="margin: 0 0 6px 0;">
                    Este é um e-mail automático enviado pelo sistema <strong>EcoPoint</strong>.
                </p>
                <p style="margin: 0;">
                    Em caso de dúvidas ou suporte, entre em contato através de <a href="mailto:contato@ecopoint.com">contato@ecopoint.com</a>.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
