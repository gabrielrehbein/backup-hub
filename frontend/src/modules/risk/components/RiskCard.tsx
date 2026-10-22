"use client";

import Link from "next/link";
import { RiskType } from "../types/risk-type";
import { BoltIcon } from "lucide-react";
import { PlanService } from "../../client/services/plans.service";
import { useEffect, useState } from "react";


export default function RiskCard({ risk }: { risk: RiskType }) {
    const [planName, setPlanName] = useState<string>("");
    let riskClasses = "";

    if (risk.name.toLowerCase() === "baixo") {
        riskClasses = "border-blue-200 hover:bg-blue-100/50";
    }
    else if (risk.name.toLowerCase() === "medio") {
        riskClasses = "border-yellow-200 hover:bg-yellow-100/50";
    }
    else if (risk.name.toLowerCase() === "alto") {
        riskClasses = "border-red-200 hover:bg-red-100/50 ";
    }

    useEffect(() => {
        const fetchPlanName = async () => {
            try {
                const planService = new PlanService();
                const plan = await planService.getPlanById(risk.plan_id);
                setPlanName(plan?.name ?? "Plano desconhecido");
            } catch (error) {
                console.error("Erro ao buscar plano:", error);
            }
        };
        fetchPlanName();
    }, [risk.plan_id]);

    return (
        <Link
            key={risk.id}
            href={`/admin/riscos/${risk.id}`}
            className={`relative cursor-pointer w-[30%] bg-white  border shadow-sm rounded-lg p-4 transition ${riskClasses} flex flex-col justify-center items-center`}
        >
            <span className="absolute top-2 left-2">
                <BoltIcon />
            </span>
            <h2 className="text-lg font-semibold text-gray-900">{risk.name} ({planName})</h2>
            <p className="text-sm text-gray-500">Clique para configurar o risco {risk.name}</p>
        </Link>
    );
}