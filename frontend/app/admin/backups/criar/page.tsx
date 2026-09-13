"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { set } from "date-fns";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";

export default function BackupForm() {
    const [systemInstances, setSystemInstances] = useState<any[]>([]);
    const [systemInstanceId, setSystemInstanceId] = useState("");
    const [size, setSize] = useState("");
    const [sizeType, setSizeSize] = useState("kb");
    const [generatedAt, setGeneratedAt] = useState("");
    const [sourceIp, setSourceIp] = useState("");
    const [isLocal, setIsLocal] = useState(false);
    const [filePath, setFilePath] = useState("");
    const [version, setVersion] = useState("");

    useEffect(() => {
        const fetchSystemInstances = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/instances`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    },
                });
                const data = await response.json();
                console.log("Instancias:", response);
                setSystemInstances(data.data);
            } catch (error) {
                console.error("Erro ao buscar as instancias:", error);
            }
        };

        fetchSystemInstances();
    }, []);

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const backupData = {
            system_instance_id: systemInstanceId,
            size: size,
            size_type: sizeType ?? "kb",
            generated_at: generatedAt,
            source_ip: sourceIp,
            is_local: isLocal,
            file_path: filePath,
            version: "1.0.0",
        };
    }

        

    return (
        <div>
            
        <Container>
        <Header></Header>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">Enviar Backup Teste</h1>
                <form className="flex flex-col gap-4" onSubmit={() => null}>
                    <div className="flex flex-col gap-2">
                        <label htmlFor="plan" className="text-sm font-semibold text-slate-700">
                            Instancia
                        </label>
                        <select
                            value={systemInstanceId}
                            onChange={(e) => setSystemInstanceId(e.target.value)}
                            name="system_instance"
                            id="system_instance"
                            className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Selecione uma instancia</option>

                            {systemInstances.map((instances) => (
                                <option key={instances.id} value={instances.id}>
                                    {instances.client.client_name} - {instances.system.system_name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="flex flex-col gap-2">
                        <label htmlFor="generated_at" className="text-sm font-semibold text-slate-700">
                            Gerado em
                        </label>
                        <input
                            type="datetime-local"
                            id="generated_at"
                            name="generated_at"
                            onChange={(e) => setGeneratedAt(e.target.value)}
                            className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <div className="flex gap-2 justify-between">
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="size" className="text-sm font-semibold text-slate-700">
                                Tamanho
                            </label>
                            <input
                                type="text"
                                id="size"
                                name="size"
                                onChange={(e) => setSize(e.target.value)}
                                className="border h-10 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="size_type" className="text-sm font-semibold text-slate-700">
                                Unidade
                            </label>
                            <select
                                name="size_type"
                                id="size_type"
                                className="border h-10  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="kb">KB</option>
                                <option value="mb">MB</option>
                                <option value="gb">GB</option>
                            </select>
                        </div>

                    </div>
                    <div className="flex gap-2 justify-between">
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="source_ip" className="text-sm font-semibold text-slate-700">
                                IP de origem
                            </label>
                            <input
                                type="text"
                                id="source_ip"
                                name="source_ip"
                                onChange={() => (null)}
                                className="border  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="is_local" className="text-sm font-semibold text-slate-700">
                                Realizado de forma
                            </label>
                            <select
                                name="is_local"
                                id="is_local_type"
                                className="border h-10  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="local">Local</option>
                                <option value="remote">Remota</option>
                            </select>
                        </div>

                    </div>
                    <div className="flex flex-col gap-2 w-full">
                        <label htmlFor="size" className="text-sm font-semibold text-slate-700">
                            Caminho do arquivo
                        </label>
                        <input
                            type="text"
                            id="file_path"
                            name="file_path"
                            onChange={() => (null)}
                            className="border  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <Button
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        Enviar Backup
                    </Button>
                </form>
            </div>
            <Button
                onClick={() => { redirect('/admin') }}
                variant="secondary"
                size="large"

                className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
            >
                Voltar
            </Button>
        </Container>
        </div>
    );
}

