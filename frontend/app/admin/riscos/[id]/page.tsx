"use client"

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Input } from "@/app/components/Input";
import { Select } from "@/app/components/Select";
import { Title } from "@/app/components/Title";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { PlanType } from "@/src/modules/client/types/plan-type";
import { RiskService } from "@/src/modules/risk/services/risks.service";
import { RiskType } from "@/src/modules/risk/types/risk-type";
import { redirect, useParams } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function RiskDetailPage() {
    const params = useParams<{ id: string }>();
    const defaultRisk: RiskType = {
        id: '',
        name: '',
        description: null,
        level: 0,
        notifiable: false,
        max_delay_limit_in_minutes: 0,
        max_size_loss_in_percent: 0,
        plan_id: '',
        createda_at: '',
        updated_at: ''
    };

    const defaultPlan: PlanType = {
        id: '',
        name: '',
        created_at: '',
        updated_at: ''
    };
    const [plan, setPlan] = useState<PlanType>(defaultPlan);
    const [risk, setRisk] = useState<RiskType>(defaultRisk);


    useEffect(() => {
        const fetchPlans = async () => {
            const planService = new PlanService();
            try {
                const plansData = await planService.getPlanById(risk.plan_id);
                setPlan(plansData);
            } catch (error) {
                toast.error("Erro ao buscar planos: " + error.message);
            }
        }
        fetchPlans();
    }, [risk.plan_id]);

    useEffect(() => {
        const fetchRisk = async () => {
            const riskService = new RiskService();
            try {
                const riskData = await riskService.getRiskById(params.id);
                setRisk(riskData);
                console.log(riskData)
            } catch (error) {
                toast.error("Erro ao buscar risco: " + error.message);
            }
            
        }
        fetchRisk();
    }, [params.id]);

    const handleSubmit = (e: React.SubmitEvent) => {
        e.preventDefault();
        const updateRisk = async () => {
            const riskService = new RiskService();
            try {
                const updatedRisk = await riskService.updateRisk(risk.id, {
                    description: risk.description,
                    notifiable: risk.notifiable,
                    max_delay_limit_in_minutes: risk.max_delay_limit_in_minutes,
                    max_size_loss_in_percent: risk.max_size_loss_in_percent
                });
                setRisk(updatedRisk);
                toast.success("Risco atualizado com sucesso!");
            } catch (error) {
                toast.error("Erro ao atualizar risco: " + error.message);
            }
        }
        updateRisk();
    }

    return (
        <div>
            <Container>
                <Header />
                <Title title={`Detalhes do Risco ${risk?.name}`} />
                <form className="flex flex-col gap-4" onSubmit={handleSubmit}>

                        <Input
                            label="Nome"
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Nome do Risco"
                            required
                            className="border border-gray-300 rounded-md p-2"
                            value={risk?.name}
                            disabled
                        />

                    <div className="flex gap-2">

                        <Input
                            label="Notificável"
                            type="checkbox"
                            id="notifiable"
                            autoComplete="off"
                            name="notifiable"
                            required
                            checked={risk?.notifiable}
                            onChange={(e) => setRisk(risk => ({ ...risk, notifiable: e.target.checked } as RiskType))}
                        />


                            <Input
                                type="number"
                                id="max_delay_limit_in_minutes"
                                name="max_delay_limit_in_minutes"
                                placeholder="60"
                                required
                                label="Máximo de atraso (minutos)"
                                value={risk?.max_delay_limit_in_minutes}
                                onChange={(e) => setRisk(risk => ({ ...risk, max_delay_limit_in_minutes: parseInt(e.target.value) } as RiskType))}
                            />

                            <Input
                                type="number"
                                id="max_delay_limit_in_minutes"
                                name="max_delay_limit_in_minutes"
                                placeholder="10"
                                required
                                label="Máximo de perda (%)"
                                value={risk?.max_size_loss_in_percent}
                                onChange={(e) => setRisk(risk => ({ ...risk, max_size_loss_in_percent: parseInt(e.target.value) } as RiskType))}
                            />

                    </div>

                    <div className="flex gap-2">
                        <Input
                            label="Level"
                            id="level"
                            name="level"
                            required
                            disabled
                            readOnly
                            value={risk?.level}
                        />

                        <Select name="plan" label="Plano" disabled >
                            <option key={plan.id} value={plan.id} selected={plan.id === risk?.plan_id}>
                                {plan.name}
                            </option>
                        </Select>
                    </div>

    
    
                    <Button
                        className="mt-4"
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        Alterar Risco
                    </Button>
                </form>
                <Button
                    onClick={() => { redirect('/admin') }}
                    variant="secondary"
                    size="large"
                >
                    Voltar
                </Button>
            </Container>
        </div>
    );
}