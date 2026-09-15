"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { set } from "date-fns";
import { is } from "date-fns/locale";
import { useParams, useRouter } from "next/navigation";
import { FormEvent, useEffect, useState } from "react";

type Plan = {
    id: number;
    name: string;
};

type Client = {
    id: number;
    name: string;
    external_id: string;
    plan: Plan;
    is_active: boolean;
};

export default function ClientDetailsPage() {
    const params = useParams<{ id: string }>();
    const router = useRouter();

    const id = params.id;

    const [client, setClient] = useState<Client | null>(null);
    const [plans, setPlans] = useState<Plan[]>([]);

    const [name, setName] = useState("");
    const [externalId, setExternalId] = useState("");
    const [planId, setPlanId] = useState("");
    const [isActive, setIsActive] = useState<boolean>();

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);

    const getToken = () => {
        return localStorage.getItem("backup-hub-token") || "";
    };

    const fetchClientDetails = async () => {
        try {
            const response = await fetch(
                `http://localhost:8000/api/clients/${id}`,
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                }
            );

            if (!response.ok) {
                throw new Error(
                    "Erro ao carregar os detalhes do cliente"
                );
            }

            const data = await response.json();
            const clientData: Client = data.data;

            setClient(clientData);
            setName(clientData.name);
            setExternalId(clientData.external_id);
            setPlanId(String(clientData.plan.id));
            setIsActive(clientData.is_active);
        } catch (error) {
            console.error(
                "Erro ao carregar os detalhes do cliente:",
                error
            );
        } finally {
            setLoading(false);
        }
    };

    const loadPlans = async () => {
        try {
            const response = await fetch(
                "http://localhost:8000/api/plans",
                {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                }
            );

            if (!response.ok) {
                throw new Error("Erro ao carregar os planos");
            }

            const data = await response.json();

            setPlans(data.data);
        } catch (error) {
            console.error("Erro ao carregar os planos:", error);
        }
    };

    useEffect(() => {
        if (!id) return;

        fetchClientDetails();
        loadPlans();
    }, [id]);

    const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        setSaving(true);

        const clientData = {
            name,
            external_id: externalId,
            plan_id: Number(planId),
            is_active: isActive,
        };

        try {
            const response = await fetch(
                `http://localhost:8000/api/clients/${id}`,
                {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                    body: JSON.stringify(clientData),
                }
            );

            if (!response.ok) {
                throw new Error("Erro ao editar o cliente");
            }

            const data = await response.json();

            setClient(data.data);

            console.log("Cliente editado com sucesso:", data);
        } catch (error) {
            console.error("Erro ao editar o cliente:", error);
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async () => {
        const confirmed = window.confirm(
            "Tem certeza que deseja deletar este cliente?"
        );

        if (!confirmed) return;

        try {
            const response = await fetch(
                `http://localhost:8000/api/clients/${id}`,
                {
                    method: "DELETE",
                    headers: {
                        Authorization: `Bearer ${getToken()}`,
                        Accept: "application/json",
                    },
                }
            );

            if (!response.ok) {
                throw new Error("Erro ao deletar o cliente");
            }

            router.push("/admin");
        } catch (error) {
            console.error("Erro ao deletar o cliente:", error);
        }
    };

    if (loading) {
        return (
            <Container>
                <p className="text-slate-600">
                    Carregando cliente...
                </p>
            </Container>
        );
    }

    if (!client) {
        return (
            <Container>
                <div className="flex flex-col gap-4">
                    <h1 className="text-2xl font-bold text-slate-900">
                        Cliente não encontrado
                    </h1>

                    <Button
                        type="button"
                        variant="secondary"
                        size="large"
                        onClick={() => router.push("/admin")}
                    >
                        Voltar
                    </Button>
                </div>
            </Container>
        );
    }

    return (
        <Container>
            <div className="flex flex-col gap-6">
                <h1 className="text-2xl font-bold text-slate-900">
                    Detalhes do Cliente
                </h1>

                <form
                    className="flex flex-col gap-4"
                    onSubmit={handleSubmit}
                >
                    <div className="flex flex-col gap-2">
                        <label
                            htmlFor="name"
                            className="text-sm font-semibold text-slate-700"
                        >
                            Nome
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value={name}
                            placeholder="Nome do cliente"
                            onChange={(e) => setName(e.target.value)}
                            className="rounded-md border border-slate-300 p-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div className="flex flex-col gap-2">
                        <label
                            htmlFor="external_id"
                            className="text-sm font-semibold text-slate-700"
                        >
                            ID Externo
                        </label>

                        <input
                            type="text"
                            id="external_id"
                            name="external_id"
                            value={externalId}
                            placeholder="ID Externo do cliente"
                            onChange={(e) =>
                                setExternalId(e.target.value)
                            }
                            className="rounded-md border border-slate-300 p-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div className="flex flex-col gap-2">
                        <label
                            htmlFor="plan"
                            className="text-sm font-semibold text-slate-700"
                        >
                            Plano
                        </label>

                        <select
                            id="plan"
                            name="plan"
                            value={planId}
                            onChange={(e) => setPlanId(e.target.value)}
                            className="rounded-md border border-slate-300 p-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            {plans.map((plan) => (
                                <option
                                    key={plan.id}
                                    value={plan.id}
                                >
                                    {plan.name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="flex flex-col gap-2">
                        <label
                            htmlFor="plan"
                            className="text-sm font-semibold text-slate-700"
                        >
                            Status
                        </label>

                        <select
                            id="plan"
                            name="plan"
                            value={isActive ? "true" : "false"}
                            onChange={(e) => setIsActive(e.target.value == "true")}
                            className="rounded-md border border-slate-300 p-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                                <option
                                    value="true"
                                >
                                    Ativo
                                </option>

                                <option
                                    value="false"
                                >
                                    Não Ativo
                                </option>

                        </select>
                    </div>

                    <Button
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        {saving ? "Salvando..." : "Editar Cliente"}
                    </Button>
                </form>

                <div className="flex flex-col gap-3">
                    <Button
                        type="button"
                        variant="danger"
                        size="large"
                        onClick={handleDelete}
                    >
                        Deletar Cliente
                    </Button>

                    <Button
                        type="button"
                        variant="secondary"
                        size="large"
                        onClick={() => router.push("/admin")}
                    >
                        Voltar
                    </Button>
                </div>
            </div>
        </Container>
    );
}