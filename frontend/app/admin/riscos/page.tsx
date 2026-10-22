"use client";

import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import RiskCard from "@/src/modules/risk/components/RiskCard";
import { RiskService } from "@/src/modules/risk/services/risks.service";
import { RiskType } from "@/src/modules/risk/types/risk-type";
import { BoltIcon } from "lucide-react";
import Link from "next/link";
import { useEffect, useState } from "react";

export default function RiskPage() {
    const [risks, setRisks] = useState<Array<RiskType>>([]);

    useEffect(() => {
        const fetchRisks = async () => {
            try {
                const riskService = new RiskService();
                const data = await riskService.getRisks();
                setRisks(data);
            } catch (error) {
                console.error("Erro ao buscar riscos:", error);
            }
        }
        fetchRisks();
    }, []);
    return (
        <Container>
            <Header />
            <div className="flex flex-col gap-4">
                <div className="flex justify-between gap-4">
                    <h1 className="text-2xl font-bold">Riscos</h1>
                </div>
                <div className="flex justify-between gap-4 flex-wrap">
                    {risks.map((risk) => (
                        <RiskCard key={risk.id} risk={risk} />
                    ))}
                </div>

            </div>
        </Container>
    );
}