export class PlanRoutes {
  static readonly LIST = '/admin/planos';
  static readonly DETAIL = (planId: string) => `/admin/planos/${planId}`;
  static readonly CREATE = '/admin/planos/criar';
}

