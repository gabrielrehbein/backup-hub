"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { CreatePlanDto } from "@/src/modules/client/dtos/create-plan-dto";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { redirect } from "next/navigation";
import { useState } from "react";
import { toast } from "react-toastify";

export default function ClientForm() {

    const [name, setName] = useState("");
    const [description, setDescription] = useState("");

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const planDTO = new CreatePlanDto(name, description);

        try {
            const planService = new PlanService();
            await planService.createPlan(planDTO);
            toast.success("Plano criado com sucesso!");
        }
        catch (error) {
            toast.error(error.message);
        }

    }


    return (
        <Container>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">Criar Plano</h1>
                <form className="flex flex-col gap-4" onSubmit={handleSubmit}>

                    <Input
                        label="Nome"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Nome do plano"
                        onChange={(e) => setName(e.target.value)}
                    />

                    <Input
                        label="Descrição"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Descrição do plano"
                        required={false}
                        onChange={(e) => setDescription(e.target.value)}
                    />

                    <Button
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        Criar Plano
                    </Button>
                </form>
            </div>
            <Button
                onClick={() => {redirect('/admin')}}
                variant="secondary"
                size="large"
            >
                Voltar
            </Button>
        </Container>
    );
}

