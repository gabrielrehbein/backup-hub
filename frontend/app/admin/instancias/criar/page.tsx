"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Input } from "@/app/components/Input";
import { Select } from "@/app/components/Select";
import { CopyIcon, EyeClosedIcon, EyeIcon } from "lucide-react";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function InstanciaForm() {
    const [clients, setClients] = useState<any[]>([]);
    const [clientId, setClientId] = useState("");
    const [systems, setSystems] = useState<any[]>([]);
    const [systemId, setSystemId] = useState("");
    const [version, setVersion] = useState("");
    const [visible, setVisible] = useState(false);

    const [apiKey, setApiKey] = useState<string | null>(null);

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
            if (data.data?.length > 0) {
                setClientId(data.data[0].id);
            }
            // Define o primeiro cliente como padrão se existir

        } catch (error) {
            console.error("Erro ao carregar os clientes:", error);
        }
    };

    const handleCopyApiKey = () => {
        if (apiKey) {
            navigator.clipboard.writeText(apiKey);
            toast.info("Chave de API copiada para a área de transferência!");
        }
    };

    const loadSystems = async () => {
        try {
            const response = await fetch("http://localhost:8000/api/systems", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    "Accept": "application/json",
                },
            });

            if (!response.ok) {
                throw new Error("Erro ao carregar os sistemas");
            }

            const data = await response.json();
            setSystems(data.data || []);

            // Define o primeiro sistema como padrão se existir
            if (data.data?.length > 0) {
                setSystemId(data.data[0].id);
            }
        } catch (error) {
            console.error("Erro ao carregar os sistemas:", error);
        }
    };

    useEffect(() => {
        loadSystems();
        loadClients();
    }, []);

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const instanceData = {
            client_id: clientId,
            system_id: systemId,
            version,
        };
        console.log("Dados da instância a serem enviados:", instanceData);
        try {
            const response = await fetch("http://localhost:8000/api/instances", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                },
                body: JSON.stringify(instanceData),
            });

            const data = await response.json();
            if (!response.ok) {
                console.log(data);
                toast.error(data.message || "Erro ao criar a instância.");
            }

            setApiKey(data.data.api_key);
            toast.success(data.message || "Instância criada com sucesso!");
            console.log("Instância criada com sucesso:", data);
        } catch (error) {
            
            console.error("Erro ao criar a instância:", error);
        }
    };

    return (
        <Container>
            <Header />
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
            <h1 className="text-2xl font-bold text-slate-900">Criar Instancia</h1>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <Input 
                    label="Versão"
                    type="text"
                    id="version"
                    name="version"
                    placeholder="Versão do Sistema"
                    value={version}
                    onChange={(e) => setVersion(e.target.value)}
                />

                <Select 
                    label="Cliente"
                    required
                    type="text"
                    id="client"
                    name="client"
                    placeholder="Versão do Sistema"
                    value={clientId}
                    onChange={(e) => setClientId(e.target.value)}
                >
                        {clients.map((client: any) => (
                            <option key={client.id} value={client.id}>
                                {client.name}
                            </option>
                        ))}
                </Select>


                <Select
                    label="Sistema"
                    id="system"
                    name="system"
                    value={systemId}
                    required
                    onChange={(e) => setSystemId(e.target.value)}
                >
                    {systems.map((system: any) => (
                        <option key={system.id} value={system.id}>
                            {system.name}
                        </option>
                    ))}
                </Select>

                {apiKey && (
                    <div className="flex gap-2 items-end">
                        <div className="flex-col gap-2 w-full">
                            <label htmlFor="api_key" className="text-sm font-semibold text-slate-700 mb-2">
                                Chave de API
                            </label>
                            <div className="flex gap-2 w-full">
                                <input type={visible ? "text" : "password"}
                                    name="api_key"
                                    id="api_key"
                                    readOnly
                                    disabled
                                    value={apiKey || ""}
                                    onChange={(e) => setApiKey(e.target.value)}
                                    className="border w-full border-slate-300 rounded-md p-2 bg-gray-200" />
                                <Button size="small" type="button" onClick={() => setVisible(!visible)}>
                                    {visible ? <EyeIcon /> : <EyeClosedIcon />}
                                </Button>
                            </div>
                        </div>
                        <Button size="medium" className="h-10 cursor-copy" type="button" onClick={handleCopyApiKey}>
                        <CopyIcon size={15}/>
                        
                        </Button>
                    </div>
                )}

                <Button
                    type="submit"
                    variant="primary"
                    size="large"
                    className="mt-6"
                >
                    Criar Instancia
                </Button>
            </form>
            </div>
                        <Button
                            onClick={() => {redirect('/admin')}}
                            variant="secondary"
                            size="large"
            
                            className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
                        >
                            Voltar
                        </Button>
        </Container>
    );
}