"use client";

import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { CircleCheckIcon, CircleXIcon } from "lucide-react";
import { useParams } from "next/navigation";
import { useEffect, useState } from "react";

export default function BackupDetailsPage() {
    const params = useParams<{ id: string }>();
    const id = params.id;
    const [backup, setBackup] = useState<any | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [backupsByInstance, setBackupByInstance] = useState<[]>([]);

    const fetchBackupByInstance = async (backup: any) => {
        try {
            const response = await fetch(
                `http://localhost:8000/api/backups/by-instance/${backup.system_instance_id}`,
                {method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    "Accept": "application/json",
                },}
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

    return (
        <Container>
            <Header username={""} />
            <section className="w-full flex flex-col gap-6">
                <h2 className="text-2xl text-slate-900 ml-2">Detalhes do Backup</h2>
                <div className="flex flex-col gap-4">
                    <p><strong>ID:</strong> {backup.id}</p>
                    <p><strong>Cliente:</strong> {backup.client_name}</p>
                    <p><strong>Tamanho:</strong> {backup.file_size_kb} MB</p>
                    <p><strong>Risco:</strong> {backup.risk}</p>
                    <p><strong>Criado em:</strong> {new Date(backup.created_at).toLocaleString()}</p>
                    <p><strong>Última atualização:</strong> {new Date(backup.updated_at).toLocaleString()}</p>
                </div>
                <div>
                    <h2>Backups dessa instancia</h2>
                    <table className="w-full text-sm text-left">
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
                                    key={`${backup.client_name}-${index}`}
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