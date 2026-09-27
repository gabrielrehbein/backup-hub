"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { InstanceRoutes } from "@/src/modules/system/routes/instance-routes";
import { InstanceService } from "@/src/modules/system/services/instances.service";
import { PlusIcon } from "lucide-react";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";

export default function InstancePage(){
    const [instances, setInstances] = useState<any[]>([]);
    useEffect(() => {
        async function fetchInstances(){
            const instanceService = new InstanceService();
            const data = await instanceService.getInstances();
            setInstances(data.data);
        }
        fetchInstances();
    }, []);
    return ( 
        <Container>
            <Header />
            <div className="flex gap-8 items-center">
                <Button variant="primary" onClick={() => { redirect(InstanceRoutes.CREATE) }}> <PlusIcon /></Button>
            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th className="px-4 py-3 font-medium">ID</th>
                            <th className="px-4 py-3 font-medium">Cliente</th>
                            <th className="px-4 py-3 font-medium">Sistema</th>
                            <th className="px-4 py-3 font-medium">Versão</th>
                        </tr>
                    </thead>

                    <tbody>
                        {instances.map((instance) => (
                            <tr
                                key={instance.id}
                                onClick={() => redirect(InstanceRoutes.DETAIL.replace("{id}", instance.id))}
                                className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                            >
                                <td className="px-4 py-3">{instance.id}</td>
                                <td className="px-4 py-3">{instance.client.client_name}</td>
                                <td className="px-4 py-3">{instance.system.system_name}</td>
                                <td className="px-4 py-3">{instance.version}</td>
                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        </Container>
    );
}