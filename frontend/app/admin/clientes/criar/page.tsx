"use client";

import { Container } from "@/app/components/Container";
import { set } from "date-fns";
import { useEffect, useState } from "react";

export default function ClientForm() {
    const [plans, setPlans] = useState<any[]>([]);
    const [planId, setPlanId] = useState("");
    const [name, setName] = useState("");
    const [externalId, setExternalId] = useState("");

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const clientData = {
            name,
            external_id: externalId,
            plan_id: planId
        };

        try {
            const response = await fetch("http://localhost:8000/api/clients", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                },
                body: JSON.stringify(clientData),
            });

            if (!response.ok) {
                throw new Error("Erro ao criar o cliente");
            }

            const data = await response.json();
            console.log("Cliente criado com sucesso:", data);
        } catch (error) {
            console.error("Erro ao criar o cliente:", error);
        }
    }


    const loadPlans = async () => {
        try {
            const response = await fetch("http://localhost:8000/api/plans", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    "Accept": "application/json",
                },
            });

            if (!response.ok) {
                throw new Error("Erro ao carregar os planos");
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Erro ao carregar os planos:", error);
        }
    }
    useEffect(() => {
    loadPlans().then(data => {
        if (data && data.data) {
            setPlans(data.data);
        }
    });
}, []);

    return (
        <Container>
        <div className="flex flex-col gap-4">
            <h1 className="text-2xl font-bold text-slate-900">Criar Cliente</h1>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div className="flex flex-col gap-2">
                    <label htmlFor="name" className="text-sm font-semibold text-slate-700">
                        Nome
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Nome do cliente"
                        onChange={(e) => setName(e.target.value)}
                        className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>
                <div className="flex flex-col gap-2">
                    <label htmlFor="external_id" className="text-sm font-semibold text-slate-700">
                        ID Externo
                    </label>
                    <input
                    type="text"
                    id="external_id"
                    name="external_id"
                    placeholder="ID Externo do cliente"
                    onChange={(e) => setExternalId(e.target.value)}
                    className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
                </div>
                <div className="flex flex-col gap-2">
                    <label htmlFor="plan" className="text-sm font-semibold text-slate-700">
                        Plano
                    </label>
                    <select
    value={planId}
    onChange={(e) => setPlanId(e.target.value)}
    name="plan"
    id="plan"
    className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
>
    <option value="">Selecione um plano</option>

    {plans.map((plan) => (
        <option key={plan.id} value={plan.id}>
            {plan.name}
        </option>
    ))}
</select>
                </div>
                
                <button
                    type="submit"
                    className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
                >
                    Criar Cliente
                </button>
            </form>
        </div>
        </Container>
    );
}
                
                