"use client";

import { Button } from "@/app/components/Button"
import { Container } from "@/app/components/Container"
import Header from "@/app/components/Header"
import { Input } from "@/app/components/Input"
import { Select } from "@/app/components/Select";
import { BackupRoutes } from "@/src/modules/backup/routes/backup-routes";
import { CircleCheckIcon, CircleXIcon, PlusIcon, SearchIcon } from "lucide-react"
import { redirect, useRouter } from "next/navigation"

import { useEffect, useState } from "react"

export default function ListBackups() {
    const [backups, setBackups] = useState<any[]>([]);
    const [clients, setClients] = useState<any[]>([]);
    const [clientId, setClientId] = useState<number | null>(null);

    const router = useRouter();

    useEffect(() => {
        const fetchBackups = async () => {
            try {
                const response = await fetch("http://localhost:8000/api/backups/instances/latest?return_in_size_type=mb", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                        "Accept": "application/json",
                    },
                });
                if (!response.ok) {
                    console.log("FQDWQDWQDQ", await response.json());
                    throw new Error("Erro ao carregar os backups");
                }

                const data = await response.json();
                setBackups(data.data);
            } catch (error) {
                console.error("Erro ao carregar os backups:", error);
            }
        };

        fetchBackups();
    }, []);

    const loadClients = async () => {
        try {
            const response = await fetch("http://localhost:8000/api/clients", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    "Accept": "application/json",
                },
            });

            if (!response.ok) {
                throw new Error("Erro ao carregar os clientes");
            }

            const data = await response.json();
            setClients(data.data || []);

            // Define o primeiro cliente como padrão se existir

        } catch (error) {
            console.error("Erro ao carregar os clientes:", error);
        }
    };

    useEffect(() => {
        loadClients();
    }, []);


    const handleOnLongPath = (path: string) => {
        if (path.length > 20) {
            return path.substring(0, 20) + "...";
        }
        return path;
    }

    return (
        <Container>
            <Header />
            <div className="flex gap-8 items-center">
                <form className="flex gap-4 items-end w-full">
                    <div className="flex gap-2">
                        <Input label="Inicio" required={false} type="datetime-local"/>
                        <Input label="Fim" required={false} type="datetime-local"/>
                    </div>
                    <div className="flex gap-2">
                        <Input label="Tamanho mínimo" required={false} type="number"/>
                        <Input label="Tamanho máximo" required={false} type="number"/>
                    </div>
                    <div className="flex gap-2">
                        <Select label="Cliente" value={""} onChange={(e) => setClientId(Number(e.target.value))}>
                        <option value="">Todos</option>
                            {
                                clients.map((client) => (
                                    <option key={client.id} value={client.id}>{client.name}</option>
                                ))
                            }
                        </Select>
                    </div>
                    <Button size="small">
                        <SearchIcon />
                    </Button>
                </form>
                <Button variant="primary" onClick={() => { redirect(BackupRoutes.CREATE) }}> <PlusIcon /></Button>
            </div>
            <div>
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
                                    className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                                    onClick={() => router.push(`/admin/backups/${backup.id}`)}
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
        </Container>
    )
}