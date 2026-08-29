"use client";

import { getMockDashboardData } from "@/modules/dashboard/mocks/dashboard.mock";
import { Dashboard } from "@/modules/dashboard/types/metrics.types";
import { Container } from "../components/Container";
import Header from "../components/Header";
import { SummaryCard } from "@/modules/dashboard/components/SummaryCard";
import { BackupsTodayChart } from "@/modules/dashboard/components/BackupsTodayChart";
import { ClientsRiskByPlan } from "@/modules/dashboard/components/ClientsRiskByPlan";
import { RecentBackups } from "@/modules/dashboard/components/RecentBackups";
import { useEffect, useState } from "react";
import { AuthService } from "@/modules/auth/services/auth.service";
import { PublicUserType } from "@/modules/user/types/public-user-type";
import { redirect } from "next/navigation";
import { DashboardService } from "@/modules/dashboard/services/dashboard.service";
import { DatabaseXIcon, TimerIcon } from "lucide-react";



export default function DashboardPage() {
    const [dashboard, setDashboard] = useState<Dashboard | null>(null);
    const [user, setUser] = useState<PublicUserType | null>(null);

    useEffect(() => {
        const fetchData = async () => {

            const dashboardService = new DashboardService();
            const metrics = await dashboardService.getMetrics();
            setDashboard(metrics.data);

            const authService = new AuthService();
            const user = await authService.getAuthUser();

            !user && redirect("/auth/login");

            setUser(user);

        };
        fetchData();
    }, []);



    return (
        <Container>

            <Header username={user?.name} />

            <section className="w-full flex flex-col gap-6">
                <h2 className="text-2xl text-slate-900 ml-2">Resumo</h2>
                <div className="flex gap-6">
                    <SummaryCard
                        title="Total de clientes"
                        value={dashboard?.summary.total_clients || 0}
                        description="Clientes monitorados"
                        size="large"
                    />

                    <SummaryCard
                        title="Total de backups"
                        value={dashboard?.summary.total_backups || 0}
                        description="Backups registrados"
                        size="large"
                    />

                    <SummaryCard
                        title="Backups em risco"
                        value={dashboard?.summary.risk_backups || 0}
                        description="Necessitam atenção"
                        size="large"
                        type="danger"
                    />
                </div>

                <div className="flex gap-6">
                    
                    <SummaryCard
                        title="Sem risco"
                        value={600}
                        description="Backups sem risco"
                        size="large"
                        type="success"
                    />

                    <SummaryCard
                        title="Risco baixo"
                        value={
                            dashboard?.riskDistribution.find(
                                risk => risk.name.toLowerCase() === "low"
                            )?.quantity || 0
                        }
                        description="Backups com baixo risco"
                        size="large"
                        type="info"
                    />

                    <SummaryCard
                        title="Risco médio"
                        value={
                            dashboard?.riskDistribution.find(
                                risk => risk.name.toLowerCase() === "medium"
                            )?.quantity || 0
                        }
                        description="Backups com médio risco"
                        size="large"
                        type="warning"
                    />

                    <SummaryCard
                        title="Risco alto"
                        value={
                            dashboard?.riskDistribution.find(
                                risk => risk.name.toLowerCase() === "high"
                            )?.quantity || 0
                        }
                        description="Backups com alto risco"
                        size="large"
                        type="danger"
                    />
                </div>                

            </section>

           <section className="w-full flex flex-col gap-6">
                <h2 className="text-2xl text-slate-900 ml-2">Risco por tipo</h2>
                <div className="flex gap-6 w-full justify-between">
                    <SummaryCard 
                        title={dashboard?.riskByType[0].type.toUpperCase() === "SIZE" ? "Tamanho" : "N/A"}
                        value={dashboard?.riskByType[0].quantity ?? 0}
                        description="Riscos por tamanho"
                        size="large"
                        icon={<DatabaseXIcon size={"80px"} opacity={0.2}/>}
                    />
                    <SummaryCard 
                        title={dashboard?.riskByType[1].type.toUpperCase() === "TIME" ? "Tempo" : "N/A"}
                        value={dashboard?.riskByType[1].quantity ?? 0}
                        description="Riscos por tempo"
                        size="large"
                        icon={<TimerIcon size={"80px"} opacity={0.2}/>}
                    />
                </div>
           </section>

            <section className="w-full flex flex-col gap-6">
                {dashboard && (
                    <BackupsTodayChart
                        backupsGeneratedToday={dashboard.backupsGeneratedToday}
                    />
                )}
            </section>

            <section className="w-full flex flex-col gap-6">
                <ClientsRiskByPlan
                    plans={dashboard?.clientsWithMostBackupRiskByPlan || []}
                />
            </section>


            <RecentBackups
                backups={dashboard?.recentBackups.local || []}
                backupsType="local"
            />

            <RecentBackups
                backups={dashboard?.recentBackups.remote || []}
                backupsType="remote"
            />

        </Container>
    );
}



