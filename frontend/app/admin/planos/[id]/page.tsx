"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { PlanType } from "@/src/modules/client/types/plan-type";

import { useParams, useRouter } from "next/navigation";
import { FormEvent, useEffect, useState } from "react";
import { toast } from "react-toastify";


export default function ClientDetailsPage() {
    const params = useParams<{ id: string }>();
    const router = useRouter();

    const id = params.id;

    const [plan, setPlan] = useState<PlanType>();

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);

    useEffect(() => {
        if (!id) return;
        const fetchPlanDetails = async () => {
            try {
                const planService = new PlanService();
                const planData = await planService.getPlanById(id);
                setPlan(planData);
            } catch (error) {
                toast.error(
                    "Erro ao carregar os detalhes do cliente: "+
                    error
                );
            } finally {
                setLoading(false);
            }
        };
        fetchPlanDetails();
    }, [id]);

  

    if (loading) {
        return (
            <Container>
                <p className="text-slate-600">
                    Carregando plano...
                </p>
            </Container>
        );
    }

    if (!plan) {
        return (
            <Container>
                <div className="flex flex-col gap-4">
                    <h1 className="text-2xl font-bold text-slate-900">
                        Plano não encontrado
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
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">
                    Detalhes do Plano
                </h1>

                <form
                    className="flex flex-col gap-4"
                >
                    <div className="flex flex-col gap-2">
                        <Input  name="name" defaultValue={plan.name} label="Nome" disabled/>
                    </div>

                    <div className="flex flex-col gap-2">
                        <Input  name="description" defaultValue={plan.description ?? ""} label="Descrição" required={false} disabled/>
                    </div>

                </form>


            </div>
            <Button
                type="button"
                variant="secondary"
                size="large"
                onClick={() => router.push("/admin/planos")}
            >
                Voltar
            </Button>
        </Container>
    );
}