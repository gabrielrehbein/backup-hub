export class NotificationRoutes {
  static readonly LIST = '/admin/notificacoes';
  static readonly DETAIL = (id: number) => `/admin/notificacoes/${id}`;
  static readonly CONFIGURATION = '/admin/notificacoes/configuracoes';
}

