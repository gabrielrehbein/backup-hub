"use client";

import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Title } from "@/app/components/Title";
import { BackupRiskService } from "@/src/modules/backup/services/backup-risk.service";
import { BackupRiskType } from "@/src/modules/backup/types/backup-risk-type";
import { CircleCheckIcon, CircleXIcon } from "lucide-react";
import { redirect, useParams } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function BackupDetailsPage() {
    const params = useParams<{ id: string }>();
    const id = params.id;
    const [backup, setBackup] = useState<any | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [backupsByInstance, setBackupByInstance] = useState<[]>([]);
    const [backupRisks, setBackupRisks] = useState<BackupRiskType[]>([]);

    useEffect(() => {
        const backupRiskService = new BackupRiskService();
        const fetchBackupRisks = async () => {
            try {
                if (backup) {
                    const risks = await backupRiskService.getRisksByBackupId(backup.id);
                    setBackupRisks(risks);
                }
            } catch (error) {
                toast.error("Erro ao carregar os riscos do backup: " + error);
            }
        };

        fetchBackupRisks();
    }, [backup]);

    const fetchBackupByInstance = async (backup: any) => {
        try {
            const response = await fetch(
                `http://localhost:8000/api/backups/by-instance/${backup.system_instance_id}`,
                {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                        "Accept": "application/json",
                    },
                }
            )

            const data = await response.json();
            console.log(data.data);
            setBackupByInstance(data.data);

        } catch (error) {
            console.error("Erro ao carregar os detalhes do backup:", error);
        }
    }

    useEffect(() => {
        const fetchBackupDetails = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/backups/instance/${id}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                        "Accept": "application/json",
                    },
                });


                if (!response.ok) {
                    throw new Error("Erro ao carregar os detalhes do backup");
                }

                const data = await response.json();
                console.log("Resposta da API:", data);
                console.log("Detalhes do backup:", data.data);

                setBackup(data.data);
                fetchBackupByInstance(data.data)
            } catch (error) {
                console.error("Erro ao carregar os detalhes do backup:", error);
            } finally {
                setLoading(false);
            }
        };

        fetchBackupDetails();
    }, [params.id]);

    const handleOnLongPath = (path: string) => {
        if (path.length > 20) {
            return path.substring(0, 20) + "...";
        }
        return path;
    }

    if (loading) {
        return <div>Carregando...</div>;
    }

    if (!backup) {
        return <div>Backup não encontrado.</div>;
    }

    function handleOnClick(backup){
        redirect(`/admin/backups/${backup.id}`)
    }

    return (
        <Container>
            <Header username={""} />
            <section className="w-full flex flex-col gap-6">


                <div className="flex justify-between p-8 bg-white rounded-md">

                    <div className="flex flex-col gap-4 w-full">
                        <Title title={`Detalhes do backup`} />
                        <p><strong>ID:</strong> {backup.id}</p>
                        <p><strong>Cliente:</strong> {backup.client_name}</p>
                        <p><strong>Tamanho:</strong> {backup.size} {backup.size_type.toUpperCase()}</p>
                        <p><strong>IP de origem:</strong> {backup.source_ip}</p>
                        <p><strong>Risco:</strong> {backup.risk}</p>
                        <p><strong>Gerado em:</strong> {new Date(backup.generated_at).toLocaleString()}</p>
                        <p><strong>Criado em:</strong> {new Date(backup.created_at).toLocaleString()}</p>
                        <p><strong>Última atualização:</strong> {new Date(backup.updated_at).toLocaleString()}</p>
                    </div>
                    <div className="flex flex-col gap-4 w-full">
                        <Title title="Riscos vinculados" />
                        {backupRisks.length === 0 ? (
                            <p>Nenhum risco encontrado.</p>
                        ) : (
                            <table className="w-full text-sm text-left">
                                <thead className="border-b border-gray-200 text-gray-500">
                                    <tr>
                                        <th className="px-4 py-3 font-medium">Risco</th>
                                        <th className="px-4 py-3 font-medium">Tipo</th>
                                        <th className="px-4 py-3 font-medium">Fator</th>
                                        <th className="px-4 py-3 font-medium">Ativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {backupRisks.map((risk, index) => (
                                        <tr key={index} className="border-b border-gray-100 hover:bg-gray-200">
                                            <td className="px-6 py-4 font-medium text-slate-800">{risk.risk.name}</td>
                                            <td className="px-6 py-4 font-medium text-slate-800">{risk.type === "time" ? "Tempo" : "Tamanho"}</td>
                                            <td className="px-6 py-4 font-medium text-slate-800">{risk.type === "time" ? `${risk.delay_in_minutes} min` : `${risk.size_loss_percent}%`}</td>
                                            <td className="px-6 py-4 font-medium text-slate-800">{risk.is_active ? <CircleCheckIcon color="#1ccc0f" size={"20px"} /> : <CircleXIcon color="#cb1a1a" size={"20px"} />}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}

                    </div>
                </div>
                <div className="flex-col  p-8 bg-white rounded-md">
                    <Title title={`Backups da mesma instância: ${backupsByInstance!.length}`}/>
                    <table className="w-full text-sm text-left mt-4">
                        <thead className="border-b border-gray-200 text-gray-500">

                            <tr>
                                <th className="px-4 py-3 font-medium">
                                    ID
                                </th>
                                <th className="px-4 py-3 font-medium">
                                    Cliente
                                </th>

                                <th className="px-4 py-3 font-medium">
                                    Sistema
                                </th>

                                <th className="px-4 py-3 font-medium">
                                    Gerado em
                                </th>

                                <th className="px-4 py-3 font-medium">
                                    Tamanho
                                </th>

                                <th className="px-6 py-3 font-medium text-slate-500">
                                    IP de origem
                                </th>

                                <th className="px-6 py-3 font-medium text-slate-500">
                                    Caminho do arquivo
                                </th>

                                <th className="px-4 py-3 font-medium">
                                    Risco
                                </th>

                                <th className="px-4 py-3 font-medium">
                                    Remoto
                                </th>
                            </tr>

                        </thead>

                        <tbody>
                            {backupsByInstance!.length === 0 ? (
                                <tr>
                                    <td colSpan={6} className="px-6 py-4 text-slate-500">
                                        Nenhum backup encontrado.
                                    </td>
                                </tr>
                            ) : (
                                backupsByInstance!.map((backup, index) => (
                                    <tr
                                        key={backup.id}
                                        onClick={() => handleOnClick(backup)}
                                        className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"

                                    >
                                        <td className="px-6 py-4 font-medium text-slate-800">
                                            {backup.id}
                                        </td>
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
                                            {handleOnLongPath(backup.file_path)}
                                        </td>

                                        <td className="px-6 py-4 text-xs text-slate-500">
                                            {backup.risk}
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
        </Container>
    );
}