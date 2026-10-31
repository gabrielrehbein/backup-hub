"use client";

import { getMockDashboardData } from "@/src/modules/dashboard/mocks/dashboard.mock";
import { Dashboard } from "@/src/modules/dashboard/types/metrics.types";
import { Container } from "../components/Container";
import Header from "../components/Header";
import { SummaryCard } from "@/src/modules/dashboard/components/SummaryCard";
import { BackupsTodayChart } from "@/src/modules/dashboard/components/BackupsTodayChart";
import { ClientsRiskByPlan } from "@/src/modules/dashboard/components/ClientsRiskByPlan";
import { RecentBackups } from "@/src/modules/dashboard/components/RecentBackups";
import { useEffect, useState } from "react";
import { AuthService } from "@/src/modules/auth/services/auth.service";
import { PublicUserType } from "@/src/modules/user/types/public-user-type";
import { redirect } from "next/navigation";
import { DashboardService } from "@/src/modules/dashboard/services/dashboard.service";
import { CircleCheckIcon, CircleXIcon, DatabaseXIcon, TimerIcon } from "lucide-react";
import { PaginetedBackupType } from "@/src/modules/backup/types/paginated-backup-type";
import { BackupService } from "@/src/modules/backup/services/backup.service";



export default function DashboardPage() {
    const INITIAL_PAGINATED_BACKUPS: PaginetedBackupType = {
        message: "",
        data: [],
        first_page_url: "",
        from: 0,
        last_page: 0,
        last_page_url: "",
        links: [{
            url: "",
            label: "",
            page: 0,
            active: false
        }],
        next_page_url: "",
        path: "",
        per_page: 0,
        prev_page_url: "",
        to: 0,
        total: 0,
    };
    const [dashboard, setDashboard] = useState<Dashboard | null>(null);
    const [user, setUser] = useState<PublicUserType | null>(null);
    const [paginetedBackups, setPaginetedBackups] = useState<PaginetedBackupType>(INITIAL_PAGINATED_BACKUPS);
    const backups = paginetedBackups.data;
    useEffect(() => {
        const fetchBackups = async () => {
            const backupService = new BackupService();
            const backups = await backupService.getAllBackups();
            setPaginetedBackups(backups);
        }

        fetchBackups();
    }, [])

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


    function getQuantityByRisk(name: string) {
        if (!dashboard) return 0
        if (!dashboard.riskDistribution) return 0

        return dashboard.riskDistribution.find(
            risk => risk.name.toLowerCase() === name.toLowerCase()
        )?.quantity ?? 0
    }
    { console.log("paginat_backups", paginetedBackups.data) }
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
                        value={
                            getQuantityByRisk("sem risco")
                        }
                        description="Backups sem risco"
                        size="large"
                        type="success"
                    />

                    <SummaryCard
                        title="Risco baixo"
                        value={
                            getQuantityByRisk("baixo")
                        }
                        description="Backups com baixo risco"
                        size="large"
                        type="info"
                    />

                    <SummaryCard
                        title="Risco médio"
                        value={
                            getQuantityByRisk("medio")
                        }
                        description="Backups com médio risco"
                        size="large"
                        type="warning"
                    />

                    <SummaryCard
                        title="Risco alto"
                        value={
                            getQuantityByRisk("alto")
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
                    {dashboard?.riskByType.map((risk, index) => (
                        <SummaryCard
                            key={index}
                            title={risk.type.toUpperCase() === "TIME" ? "Tempo" : risk.type.toUpperCase() === "SIZE" ? "Tamanho" : "Tempo"}
                            value={risk.quantity ?? 0}
                            description={`Riscos por ${risk.type.toUpperCase() === "TIME" ? "tempo" : risk.type.toUpperCase() === "SIZE" ? "tamanho" : "Tempo"}`}
                            size="large"
                            icon={risk.type.toUpperCase() === "TIME" ? <TimerIcon size={"80px"} opacity={0.2} /> :
                                risk.type.toUpperCase() === "SIZE" ? <DatabaseXIcon size={"80px"} opacity={0.2} /> : null}
                        />
                    ))}
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

            {backups.length > 0 && (

                <section className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div className="border-b border-slate-200 p-6">

                        <h2 className="font-semibold text-slate-900">
                            Backups
                        </h2>


                    </div>

                    <div className="">

                        <table className="w-full text-left text-sm">

                            <thead className="bg-slate-50">

                                <tr>
                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Cliente
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Sistema
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Gerado em
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Tamanho
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        IP de origem
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Caminho do arquivo
                                    </th>

                                    <th className="px-6 py-3 font-medium text-slate-500">
                                        Remoto
                                    </th>
                                </tr>

                            </thead>

                            <tbody className="divide-y divide-slate-100">
                                {backups.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="px-6 py-4 text-slate-500">
                                            Nenhum backup encontrado.
                                        </td>
                                    </tr>
                                ) : (
                                    backups.map((backup, index) => (
                                        <tr
                                            key={`${backup.client_name}-${index}`}
                                            className="hover:bg-slate-50"
                                        >
                                            <td className="px-6 py-4 font-medium text-slate-800">
                                                {backup.client_name}
                                            </td>
                                            <td className="px-6 py-4 font-medium text-slate-800">
                                                {backup.system_name}
                                            </td>

                                            <td className="px-6 py-4 text-slate-500">
                                                {backup.generated_at ? new Date(backup.generated_at).toLocaleString() : 'sem data'}
                                            </td>

                                            <td className="px-6 py-4 text-slate-700">
                                                {backup.size} {backup.size_type.toUpperCase()}
                                            </td>

                                            <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                                {backup.source_ip}
                                            </td>

                                            <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                                {backup.file_path}
                                            </td>

                                            <td className="px-6 py-4 text-slate-700">
                                                {backup.is_local ? <CircleXIcon color="#cb1a1a" size={"20px"} /> : <CircleCheckIcon color="#1ccc0f" size={"20px"} />}
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>

                        </table>

                    </div>

                </section>
            )}


        </Container>
    );
}



