<?php

namespace App\Shared\Utils;


enum ResourceEnum: string
{
    case SYSTEM = 'Sistema';
    case SYSTEM_INSTANCE = 'Instancia do Sistema';
    case CLIENT = 'Cliente';
    case USER = 'Usuário';
    case RISK = 'Risco';
    case PLAN = 'Plano';
    case BACKUP = 'Backup';
    case BACKUP_RISK = 'Risco de Backup';
    case NOTIFICATION = 'Notificação';
    case NOTIFICATION_DELIVERY = 'Entrega de Notificação';
    case NOTIFICATION_CHANNEL = 'Canal de Notificação';
}
