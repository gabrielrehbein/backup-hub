"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { Select } from "@/app/components/Select";
import { set } from "date-fns";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

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

            if(response.status === 422) {
                const errorData = await response.json();
                const errorMessage = errorData.message || "Erro de validação.";
                toast.error(errorMessage);
                console.error("Erro de validação:", errorData);
                return;
            }
            if(response.status === 400) {
                const errorData = await response.json();
                const errorMessage = errorData.message || "Erro de requisição.";
                toast.error(errorMessage);
                console.error("Erro de requisição:", errorData);
                return;
            }

            if (!response.ok) {
                throw new Error("Erro ao criar o cliente");
            }

            const data = await response.json();
            toast.success("Cliente criado com sucesso!");
            console.log("Cliente criado com sucesso:", data);
        } catch (error) {
            toast.error("Algo deu errado.");
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
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">Criar Cliente</h1>
                <form className="flex flex-col gap-4" onSubmit={handleSubmit}>

                    <Input
                        label="Nome"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Nome do cliente"
                        onChange={(e) => setName(e.target.value)}
                        className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />

                    <Input
                        label="ID Externo"
                        type="text"
                        id="external_id"
                        name="external_id"
                        placeholder="ID Externo do cliente"
                        onChange={(e) => setExternalId(e.target.value)}
                        className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />

                    <div className="flex flex-col gap-2">

                        <Select
                        required
                            label="Plano"
                            value={planId}
                            onChange={(e) => setPlanId(e.target.value)}
                            name="plan"
                            id="plan"
                            className="w-full"
                            
                        >
                            <option value="">Selecione um plano</option>

                            {plans.map((plan) => (
                                <option key={plan.id} value={plan.id}>
                                    {plan.name}
                                </option>
                            ))}
                        </Select>
                    </div>

                    <Button
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        Criar Cliente
                    </Button>
                </form>
            </div>
            <Button
                onClick={() => {redirect('/admin')}}
                variant="secondary"
                size="large"

                className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
            >
                Voltar
            </Button>
        </Container>
    );
}

