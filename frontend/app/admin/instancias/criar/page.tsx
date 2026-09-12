"use client";

import { Container } from "@/app/components/Container";
import { useEffect, useState } from "react";

export default function InstanciaForm() {
    const [clients, setClients] = useState<any[]>([]);
    const [clientId, setClientId] = useState("");
    const [systems, setSystems] = useState<any[]>([]);
    const [systemId, setSystemId] = useState("");
    const [version, setVersion] = useState("");

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

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        const instanceData = {
            client_id: clientId,
            system_id: systemId,
            version,
        };
        console.log("Dados da instância a serem enviados:", instanceData);
        try {
            const response = await fetch("http://localhost:8000/api/system-instances", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                },
                body: JSON.stringify(instanceData),
            });

            if (!response.ok) {
                throw new Error("Erro ao criar a instância");
            }

            const data = await response.json();
            console.log("Instância criada com sucesso:", data);
        } catch (error) {
            console.error("Erro ao criar a instância:", error);
        }
    };

    return (
        <Container>
            <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                <div className="flex flex-col gap-2">
                    <label htmlFor="version">Versão</label>
                    <input
                        type="text"
                        id="version"
                        name="version"
                        placeholder="Versão do Sistema"
                        required
                        className="border border-gray-300 rounded-md p-2"
                        value={version}
                        onChange={(e) => setVersion(e.target.value)}
                    />
                </div>

                <div className="flex flex-col gap-2">
                    <label htmlFor="client">Cliente</label>
                    <select
                        id="client"
                        name="client"
                        value={clientId}
                        onChange={(e) => setClientId(e.target.value)}
                        className="border border-gray-300 rounded-md p-2"
                    >

                        {clients.map((client: any) => (
                            <option key={client.id} value={client.id}>
                                {client.name}
                            </option>
                        ))}
                    </select>
                </div>

                <div className="flex flex-col gap-2">
                    <label htmlFor="system">Sistema</label>
                    <select
                        id="system"
                        name="system"
                        value={systemId}
                        onChange={(e) => setSystemId(e.target.value)}
                        className="border border-gray-300 rounded-md p-2"
                    >
                        <option value="" disabled>Selecione um sistema</option>
                        {systems.map((system: any) => (
                            <option key={system.id} value={system.id}>
                                {system.name}
                            </option>
                        ))}
                    </select>
                </div>

                <button
                    type="submit"
                    className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
                >
                    Criar Sistema
                </button>
            </form>
        </Container>
    );
}