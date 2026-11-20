<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bem-vindo ao EcoPoint - Seus dados de acesso</title>
    <style>
        body, table, td, a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
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

        .btn-primary:hover {
            background-color: #04108a !important;
            box-shadow: 0 6px 18px rgba(6, 24, 185, 0.35) !important;
        }

        /* Responsive */
        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                margin: 0 auto !important;
                border-radius: 0 !important;
            }
            .header-cell {
                padding: 30px 20px 20px !important;
            }
            .body-cell {
                padding: 24px 20px !important;
            }
            .credential-col {
                display: block !important;
                width: 100% !important;
                margin-bottom: 8px !important;
            }
            .credential-value-col {
                display: block !important;
                width: 100% !important;
            }
            .step-item {
                display: block !important;
                width: 100% !important;
                margin-bottom: 12px !important;
            }
            .btn-primary {
                width: 100% !important;
                box-sizing: border-box !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9;">

    <div style="display: none; font-size: 1px; color: #f1f5f9; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        Suas credenciais de acesso ao EcoPoints chegaram! Acesse o painel da sua ONG e comece a cadastrar pontos de coleta.
    </div>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; min-width: 100%;">
        <tr>
            <td align="center" style="padding: 36px 16px;">

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" class="email-container" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); border: 1px solid #e2e8f0;">

                    <tr>
                        <td height="6" style="background: linear-gradient(90deg, #2E6930 0%, #2B7A9B 50%, #0618b9 100%); line-height: 6px; font-size: 6px;">&nbsp;</td>
                    </tr>

]                    <tr>
                        <td align="center" class="header-cell" style="padding: 40px 36px 26px; background-color: #ffffff; text-align: center;">
                            <a href="{{ url('/') }}" target="_blank" style="text-decoration: none; display: inline-block;">
                                <img src="{{ isset($message) ? $message->embed(public_path('img/logo-ecopoints.png')) : asset('img/logo-ecopoints.png') }}"
                                     alt="EcoPoints - Seu livro, no próximo ponto."
                                     width="240"
                                     style="max-width: 240px; width: 100%; height: auto; display: block; margin: 0 auto; border: 0;" />
                            </a>
                            <div style="margin-top: 14px;">
                                <span style="display: inline-block; background-color: #ecfdf5; color: #047857; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 5px 14px; border-radius: 20px; border: 1px solid #a7f3d0;">
                                    🌱 Rede Oficial de ONGs Parceiras
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 36px;">
                            <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 0;" />
                        </td>
                    </tr>

                    <tr>
                        <td class="body-cell" style="padding: 32px 36px 36px; line-height: 1.6;">

                            <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 12px 0; line-height: 1.3;">
                                Olá, <span style="color: #2B7A9B;">{{ $nome }}</span>! 👋
                            </h1>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 16px 0; line-height: 1.65;">
                                É com imensa satisfação que damos as boas-vindas à sua instituição como parceira oficial da plataforma <strong>EcoPoint</strong>.
                            </p>
                            <p style="font-size: 15px; color: #475569; margin: 0 0 26px 0; line-height: 1.65;">
                                A partir de hoje, sua ONG conta com um canal direto para divulgar seus pontos de coleta de livros didáticos e materiais escolares, conectar-se com milhares de doadores conscientes e expandir o impacto social e ecológico na sua região.
                            </p>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%); border: 1.5px solid #cbd5e1; border-radius: 12px; margin: 0 0 28px 0;">
                                <tr>
                                    <td style="padding: 22px 24px;">

                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="padding-bottom: 14px; border-bottom: 1px solid #e2e8f0;">
                                                    <span style="font-size: 12px; font-weight: 800; color: #0618b9; text-transform: uppercase; letter-spacing: 0.08em; display: inline-block;">
                                                        🔑 Seus Dados de Acesso ao Painel
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 14px;">
                                            <tr>
                                                <td width="130" class="credential-col" style="font-size: 13px; font-weight: 700; color: #64748b; vertical-align: middle;">
                                                    E-mail de Login:
                                                </td>
                                                <td class="credential-value-col" style="vertical-align: middle;">
                                                    <div style="background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 12px; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; font-size: 14px; font-weight: 600; color: #0f172a; word-break: break-all;">
                                                        {{ $email }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
                                            <tr>
                                                <td width="130" class="credential-col" style="font-size: 13px; font-weight: 700; color: #64748b; vertical-align: middle;">
                                                    Senha Temporária:
                                                </td>
                                                <td class="credential-value-col" style="vertical-align: middle;">
                                                    <div style="background-color: #ecfdf5; border: 1.5px dashed #10b981; border-radius: 6px; padding: 7px 12px; font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; font-size: 15px; font-weight: 800; color: #047857; letter-spacing: 0.04em; word-break: break-all;">
                                                        {{ $senhaTemporaria }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        <div style="margin-top: 12px; font-size: 12px; color: #64748b; font-style: italic;">
                                            💡 Dica: copie a senha exatamente como exibida acima (respeitando maiúsculas e minúsculas).
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0 32px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/login') }}" target="_blank" class="btn-primary" style="display: inline-block; background: linear-gradient(135deg, #0618b9 0%, #2B7A9B 100%); color: #ffffff !important; font-size: 15px; font-weight: 800; text-decoration: none; padding: 15px 38px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 14px rgba(6, 24, 185, 0.28); text-align: center;">
                                            Acessar o Painel da ONG &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 22px; margin-bottom: 26px;">
                                <div style="font-size: 13px; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 14px;">
                                    🚀 Primeiros Passos na Plataforma
                                </div>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 14px; color: #334155; line-height: 1.5;">
                                            <strong style="color: #0618b9;">1. Entre na plataforma:</strong> Utilize o seu e-mail cadastrado e a senha temporária fornecida acima.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 14px; color: #334155; line-height: 1.5;">
                                            <strong style="color: #2B7A9B;">2. Atualize sua senha:</strong> No seu primeiro acesso, acerte sua senha para uma credencial pessoal e segura.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 14px; color: #2E6930;">
                                            <strong style="color: #2E6930;">3. Cadastre seus Pontos de Coleta:</strong> Adicione endereços físicos e os tipos de materiais aceitos para que a comunidade possa encontrá-los no mapa.
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 6px; margin-bottom: 26px;">
                                <tr>
                                    <td style="padding: 12px 16px; font-size: 13px; color: #92400e; line-height: 1.55;">
                                        <strong>⚠️ Aviso de Segurança:</strong> A equipe do EcoPoint nunca solicitará suas credenciais de acesso por WhatsApp, redes sociais ou telefone. Altere sua senha temporária logo após o primeiro login.
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; text-align: center;">
                                <tr>
                                    <td style="padding: 14px 18px; font-size: 13px; color: #64748b; line-height: 1.5;">
                                        Dúvidas ou dificuldades no acesso? Responda a este e-mail ou fale conosco através de <a href="mailto:contato@ecopoint.com" style="color: #2B7A9B; font-weight: 700; text-decoration: none;">contato@ecopoint.com</a>.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="background-color: #0f172a; padding: 28px 30px; text-align: center; color: #94a3b8; font-size: 12px; line-height: 1.6;">
                            <div style="font-size: 14px; font-weight: 800; color: #ffffff; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 4px;">
                                Eco<span style="color: #76C1C3;">Points</span>
                            </div>
                            <div style="font-size: 11px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;">
                                Seu livro, no próximo ponto.
                            </div>
                            <p style="margin: 0 0 6px 0; color: #94a3b8; font-size: 12px;">
                                Este é um e-mail automático gerado pela plataforma <strong>EcoPoint</strong>.
                            </p>
                            <p style="margin: 0; color: #64748b; font-size: 11px;">
                                &copy; {{ date('Y') }} EcoPoints. Todos os direitos reservados. Conectando educação e reciclagem sustentável.
                            </p>
                        </td>
                    </tr>

                </table>
       
            </td>
        </tr>
    </table>

</body>
</html>
