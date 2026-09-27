"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { InstanceService } from "@/src/modules/system/services/instances.service";
import { EyeClosedIcon, EyeIcon, RefreshCwIcon, RotateCcwKeyIcon } from "lucide-react";

import { useParams, useRouter } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function InstanceDetailsPage() {
    const params = useParams<{ id: string }>();

    const router = useRouter();
    const id = params?.id;

    const [loading, setLoading] = useState(true);
    const [instance, setInstance] = useState<any>(null);
    const [apiKey, setApiKey] = useState<string>("A chave de API somente é visivel quando cria-la ou atualiza-la.");
    const [visible, setVisible] = useState(false);

    function handleOnRefreshApiKey(e: React.SubmitEvent) {
        e.preventDefault();
        async function refreshApiKey() {
            try {
                const instanceService = new InstanceService();
                const response = await instanceService.refreshApiKey(id);
                setApiKey(response.data.new_api_key)
                toast.success("Chave de API da instância atualizada com sucesso!")
                toast.info("Lembre-se de atualizar suas integrações.")
            } catch (error) {
                console.error("Erro ao carregar instância:", error);
                toast.error("Erro ao carregar os detalhes da instância.");
            }
        }
        refreshApiKey();
    }

    const handleCopyApiKey = () => {
        if (apiKey) {
            navigator.clipboard.writeText(apiKey);
            toast.info("Chave de API copiada para a área de transferência!");
        }
    };

    useEffect(() => {
        if (!id) return;

        async function fetchInstance(instanceId: string) {
            try {
                setLoading(true);
                const instanceService = new InstanceService();
                const response = await instanceService.getIntanceById(instanceId);

                // Ajuste caso a sua API retorne os dados envelopados em `response.data`
                setInstance(response.data || response);
            } catch (error) {
                console.error("Erro ao carregar instância:", error);
                toast.error("Erro ao carregar os detalhes da instância.");
            } finally {
                setLoading(false);
            }
        }

        fetchInstance(id);
    }, [id]);


    if (loading) {
        return (
            <Container>
                <div className="p-8 text-center text-slate-600">
                    Carregando detalhes da instância...
                </div>
            </Container>
        );
    }

    if (!instance) {
        return (
            <Container>
                <div className="p-8 text-center text-slate-600">
                    <p className="mb-4">Instância não encontrada.</p>
                    <Button variant="secondary" onClick={() => router.push("/admin")}>
                        Voltar
                    </Button>
                </div>
            </Container>
        );
    }

    return (
        <Container>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8 mx-auto mt-8 bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">
                    Detalhes da Instância
                </h1>

                <form className="flex flex-col gap-4">
                    <div className="flex gap-4">
                        <Input
                            label="Chave de API"
                            value={apiKey}
                            readOnly
                            disabled
                            type={visible ? "text" : "password"}
                        />
                        <Button className="place-self-end" size="small" type="button" onClick={() => setVisible(!visible)}>
                            {visible ? <EyeIcon /> : <EyeClosedIcon />}
                        </Button>
                        <Button size="small" className=" place-self-end" type="button" onClick={(e) => (handleOnRefreshApiKey(e))}>
                            <RotateCcwKeyIcon />
                        </Button>
                    </div>
                    <Input
                        label="Versão"
                        value={instance?.version || "N/A"}

                    />
                    <Input
                        label="Cliente"
                        value={instance?.client?.client_name || "N/A"}
                        readOnly
                    />
                    <Input
                        label="Sistema"
                        value={instance?.system?.system_name || "N/A"}
                        readOnly
                    />
                </form>
            </div>

            <div className="mt-4">
                <Button
                    type="button"
                    variant="secondary"
                    size="large"
                    onClick={() => router.push("/admin")}
                >
                    Voltar
                </Button>
            </div>
        </Container>
    );
}