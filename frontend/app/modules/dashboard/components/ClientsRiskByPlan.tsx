import { Dashboard } from "../types/metrics.types";


type ClientsRiskByPlanProps = {
    plans: Dashboard["clientsWithMostBackupRiskByPlan"];
}

export function ClientsRiskByPlan({
    plans,
}: ClientsRiskByPlanProps) {
    return (
        <div className="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div className="mb-6">
                <h2 className="font-semibold text-slate-900">
                    Clientes com mais riscos All-Time
                </h2>

                <p className="mt-1 text-sm text-slate-500">
                    Agrupados por plano
                </p>
            </div>

            <div className="space-y-6">

                {plans.map((plan) => (

                    <div key={plan.planName}>

                        <h3 className="mb-3 text-sm font-semibold text-slate-700">
                            {plan.planName}
                        </h3>

                        <div className="space-y-2">

                            {plan.clients.map((client) => (

                                <div
                                    key={client.clientName}
                                    className="flex items-center justify-between rounded-lg bg-slate-50 px-4 py-3"
                                >
                                    <span className="text-sm text-slate-700">
                                        {client.clientName}
                                    </span>

                                    <span className="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                        {client.riskQuantity} riscos
                                    </span>
                                </div>

                            ))}

                        </div>

                    </div>

                ))}

            </div>

        </div>
    );
}