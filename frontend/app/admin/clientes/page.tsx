"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Input } from "@/app/components/Input";
import { CircleCheckIcon, CircleXIcon, PlusIcon, SearchIcon } from "lucide-react";
import { redirect, useRouter } from "next/navigation";

import { useEffect, useState } from "react";

export default function ListClients() {
    const [clients, setClients] = useState<any[]>([]);
    const router = useRouter();
    useEffect(() => {
        const fetchClients = async () => {
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
                setClients(data.data);
            } catch (error) {
                console.error("Erro ao carregar os clientes:", error);
            }
        };

        fetchClients();
    }, []);

    return (
        <Container>
            <Header />
            <div className="flex gap-8 items-center">
                <form className="flex gap-2 items-center w-full">
                    <Input label="" className="w-full" type="text" placeholder="Busque o nome do cliente" />

                    <Button size="small">
                        <SearchIcon />
                    </Button>
                </form>
                <Button variant="primary" onClick={() => { redirect("/admin/clientes/criar") }}> <PlusIcon /></Button>
            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th className="px-4 py-3 font-medium">ID</th>
                            <th className="px-4 py-3 font-medium">ID Externo</th>
                            <th className="px-4 py-3 font-medium">Nome</th>
                            <th className="px-4 py-3 font-medium">Plano</th>
                            <th className="px-4 py-3 font-medium">Ativo</th>
                        </tr>
                    </thead>

                    <tbody>
                        {clients.map((client) => (
                            <tr
                                key={client.id}
                                onClick={() => router.push(`/admin/clientes/${client.id}`)}
                                className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                            >
                                <td className="px-4 py-3">{client.id}</td>
                                <td className="px-4 py-3 text-gray-500">{client.external_id}</td>
                                <td className="px-4 py-3">{client.name}</td>
                                <td className="px-4 py-3">{client.plan.name}</td>
                                <td className="px-4 py-3">
                                    {!client.is_active ? (
                                        <CircleXIcon size={20} color="#cb1a1a" />
                                    ) : (
                                        <CircleCheckIcon size={20} color="#1ccc0f" />
                                    )}
                                </td>
                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        </Container>
    );
}