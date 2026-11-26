<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>EcoPoint - Nova Mensagem do Fale Conosco</title>
    <style>
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            background-color: #f1f5f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 620px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header-cell {
            background: linear-gradient(135deg, #1e3a1a 0%, #2f693a 100%);
            padding: 32px 28px;
            text-align: center;
        }
        .brand-badge {
            display: inline-block;
            background-color: #d4eead;
            color: #1e3a1a;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        .header-title {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .header-subtitle {
            color: #e2f0d9;
            font-size: 14px;
            margin: 8px 0 0;
        }
        .body-cell {
            padding: 32px 28px;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 24px;
        }
        .info-row {
            padding: 6px 0;
            font-size: 14px;
        }
        .info-label {
            color: #64748b;
            font-weight: 600;
            display: inline-block;
            min-width: 80px;
        }
        .info-value {
            color: #0f172a;
            font-weight: 600;
        }
        .message-box {
            background-color: #f4f9f2;
            border-left: 4px solid #2f693a;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0 28px;
        }
        .message-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e3a1a;
            margin: 0 0 10px;
        }
        .message-content {
            font-size: 15px;
            line-height: 1.6;
            color: #334155;
            white-space: pre-wrap;
            word-break: break-word;
            margin: 0;
        }
        .btn-reply {
            display: inline-block;
            background: linear-gradient(135deg, #2f693a 0%, #1e3a1a 100%);
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            text-align: center;
        }
        .footer-cell {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 24px 28px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.5;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0 !important;
                border-radius: 0 !important;
                border: none !important;
            }
            .header-cell, .body-cell, .footer-cell {
                padding: 24px 20px !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header-cell">
            <span class="brand-badge">EcoPoint Suporte</span>
            <h1 class="header-title">Nova Mensagem Recebida</h1>
            <p class="header-subtitle">Enviada através do formulário Fale Conosco da plataforma</p>
        </div>

        <!-- Body -->
        <div class="body-cell">
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Remetente:</span>
                    <span class="info-value">{{ $nome }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">E-mail:</span>
                    <span class="info-value">
                        <a href="mailto:{{ $email }}" style="color: #2f693a; text-decoration: none;">{{ $email }}</a>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Assunto:</span>
                    <span class="info-value">{{ $assunto }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Data/Hora:</span>
                    <span class="info-value" style="color: #64748b; font-weight: normal;">{{ $dataEnvio }}</span>
                </div>
            </div>

            <div class="message-box">
                <p class="message-title">Conteúdo da Mensagem:</p>
                <p class="message-content">{{ $mensagem }}</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="mailto:{{ $email }}?subject=Re:%20{{ rawurlencode($assunto) }}%20-%20EcoPoint" class="btn-reply">
                    Responder para {{ $nome }}
                </a>
                <p style="font-size: 12px; color: #64748b; margin-top: 10px;">
                    Ao clicar no botão ou responder este e-mail, sua resposta irá diretamente para <strong>{{ $email }}</strong>.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-cell">
            <p style="margin: 0 0 6px;">
                <strong>EcoPoint</strong> — Mapeamento e Destinação Sustentável de Livros e Apostilas
            </p>
            <p style="margin: 0;">
                Este e-mail foi gerado automaticamente pelo sistema EcoPoint para a caixa de suporte: 
                <a href="mailto:ecopointssuporte@gmail.com" style="color: #2f693a; text-decoration: none;">ecopointssuporte@gmail.com</a>
            </p>
        </div>
    </div>
</body>
</html>
