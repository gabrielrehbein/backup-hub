<?php

namespace App\Modules\Systems\Enums;

enum SystemCategoryEnum: string
{
    case ERP = 'erp';
    case CRM = 'crm';
    case ACCOUNTING = 'accounting';
    case HUMAN_RESOURCES = 'human_resources';
    case FINANCIAL = 'financial';
    case ECOMMERCE = 'ecommerce';
    case DATABASE = 'database';
    case FILE_SERVER = 'file_server';
    case EMAIL = 'email';
    case BACKUP = 'backup';
    case MONITORING = 'monitoring';
    case OTHER = 'other';
}
