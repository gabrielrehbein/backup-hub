"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Input } from "@/app/components/Input";
import { Title } from "@/app/components/Title";
import { ClientRoutes } from "@/src/modules/client/routes/client-routes";
import { PlanRoutes } from "@/src/modules/client/routes/plan-routes";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { PlanType } from "@/src/modules/client/types/plan-type";
import { CircleCheckIcon, CircleXIcon, PlusIcon, SearchIcon } from "lucide-react";
import { redirect, useRouter } from "next/navigation";

import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function ListPlans() {
    const [plans, setPlans] = useState<PlanType[]>([]);


    const router = useRouter();
    useEffect(() => {
        const fetchClients = async () => {
            const planService = new PlanService();
            try {
                const plansData = await planService.getPlans();
                setPlans(plansData);
            } catch (error) {
                toast.error("Erro ao buscar planos:" + error);
            }
        };

        fetchClients();
    }, []);



    return (
        <Container>
            <Header />
            <Title title="Planos" />
            <div className="flex justify-end">
                <Button
                    size="medium"
                    onClick={() => router.push(PlanRoutes.CREATE)}
                    className="mb-4 flex items-center gap-2"
                >
                    <PlusIcon size={16} />
                </Button>
            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th className="px-4 py-3 font-medium">ID</th>
                            <th className="px-4 py-3 font-medium">Nome</th>
                        </tr>
                    </thead>

                    <tbody>
                        {plans.map((plan) => (
                            <tr
                                key={plan.id}
                                onClick={() => router.push(PlanRoutes.DETAIL(plan.id))}
                                className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                            >
                                <td className="px-4 py-3">{plan.id}</td>
                                <td className="px-4 py-3">{plan.name}</td>

                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        </Container>
    );
}