import { getMockDashboardData } from "@/modules/dashboard/mocks/dashboard.mock";
import { Dashboard } from "@/modules/dashboard/types/metrics.types";
import { Container } from "../components/Container";
import Header from "../components/Header";
import { SummaryCard } from "@/modules/dashboard/components/SummaryCard";
import { BackupsTodayChart } from "@/modules/dashboard/components/BackupsTodayChart";
import { ClientsRiskByPlan } from "@/modules/dashboard/components/ClientsRiskByPlan";
import { RecentBackups } from "@/modules/dashboard/components/RecentBackups";



export default async function DashboardPage() {
    const dashboard: Dashboard = await getMockDashboardData();

    return (
        <Container>

            <Header />

            <section className="w-full flex flex-col gap-6">

                <div className="flex gap-6">
                    <SummaryCard
                        title="Total de clientes"
                        value={dashboard.summary.total_clients}
                        description="Clientes monitorados"
                        size="large"
                    />

                    <SummaryCard
                        title="Total de backups"
                        value={dashboard.summary.total_backups}
                        description="Backups registrados"
                        size="large"
                    />

                    <SummaryCard
                        title="Backups em risco"
                        value={dashboard.summary.risk_backups}
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
                            dashboard.riskDistribution.find(
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
                            dashboard.riskDistribution.find(
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
                            dashboard.riskDistribution.find(
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

                <BackupsTodayChart backupsGeneratedToday={dashboard.backupsGeneratedToday}/>

                <ClientsRiskByPlan
                    plans={dashboard.clientsWithMostBackupRiskByPlan}
                />

            </section>


            <RecentBackups
                backups={dashboard.recentBackups.local}
                backupsType="local"
            />

            <RecentBackups
                backups={dashboard.recentBackups.remote}
                backupsType="remote"
            />

        </Container>
    );
}



