<!DOCTYPE html>

<html lang="pt-BR"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Backup em risco</title> </head>

<body style="margin: 0; padding: 0; background-color: #f4f7f9; font-family: Arial, Helvetica, sans-serif; color: #1f2937;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f7f9; padding: 30px 15px;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" border="0"
                   style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 10px; overflow: hidden;">

                <!-- Header -->
                <tr>
                    <td style="background-color: #2563EB; padding: 25px 30px; text-align: center;">
                        <h1 style="margin: 0; color: #ffffff; font-size: 24px;">
                            Backup Hub
                        </h1>
                        <p style="margin: 8px 0 0; color: #d1fae5; font-size: 14px;">
                            Sistema de monitoramento de backups
                        </p>
                    </td>
                </tr>

                <!-- Alert -->
                <tr>
                    <td style="padding: 30px;">

                        <div style="background-color: #fff7ed; border-left: 5px solid #f97316; padding: 15px 18px; margin-bottom: 25px;">
                            <h2 style="margin: 0 0 6px; color: #c2410c; font-size: 20px;">
                                Backup em risco
                            </h2>

                            <p style="margin: 0; color: #7c2d12; font-size: 14px;">
                                Foi identificado um risco relacionado a este backup.
                            </p>
                        </div>

                        <!-- Backup -->
                        <h3 style="margin: 0 0 15px; font-size: 17px; color: #111827;">
                            Informações do Backup
                        </h3>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0"
                               style="border-collapse: collapse; margin-bottom: 25px;">

                            <tr>
                                <td style="padding: 12px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 40%;">
                                    ID do Backup
                                </td>

                                <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">
                                    #{{ $backupRisk->backup->id }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 12px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; font-weight: bold;">
                                    Cliente
                                </td>

                                <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">
                                    #{{ $backupRisk->backup->instances->client->id }} | {{ $backupRisk->backup->instances->client->name }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 12px; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; font-weight: bold;">
                                    Tipo de risco
                                </td>

                                <td style="padding: 12px; border-bottom: 1px solid #e5e7eb;">
                                    {{ 
                                        match($backupRisk->type) {
                                            'time' => 'Tempo',
                                            'size' => 'Tamanho',
                                            default => 'Outro'
                                        } 
                                    }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 12px; background-color: #f9fafb; font-weight: bold;">
                                    Nível do risco
                                </td>

                                <td style="padding: 12px;">
                                    <span style="display: inline-block; padding: 6px 12px; background-color: #fee2e2; color: #b91c1c; border-radius: 20px; font-size: 13px; font-weight: bold;">
                                        {{ $backupRisk->risk->name }}
                                    </span>
                                </td>
                            </tr>

                        </table>

                        <!-- Message -->
                        <p style="margin: 0 0 10px; font-size: 14px; line-height: 1.6; color: #4b5563;">
                            Recomendamos verificar o backup e analisar a causa do risco identificado.
                        </p>

                        <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #4b5563;">
                            Este aviso foi gerado automaticamente pelo sistema de monitoramento do Backup Hub.
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">

                        <p style="margin: 0; color: #6b7280; font-size: 12px;">
                            Backup Hub — Monitoramento de Backups
                        </p>

                        <p style="margin: 6px 0 0; color: #9ca3af; font-size: 11px;">
                            Esta é uma mensagem automática. Não é necessário respondê-la.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body> </html>