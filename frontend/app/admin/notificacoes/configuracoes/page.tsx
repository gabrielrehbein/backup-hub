"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { NotificationRoutes } from "@/src/modules/notification/routes/notification-routes";
import { NotificationService } from "@/src/modules/notification/services/notification.service";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function NotificationPage() {

    const [emailForNotifications, setEmailForNotifications] = useState<string>('');

    useEffect(() => {
        async function fetchNotificationConfig() {
            const notificationService = new NotificationService();
            const config = await notificationService.getNotificationConfig();
            if (config && config.data && config.data.email) {
                setEmailForNotifications(config.data.email);
            }
        }
        fetchNotificationConfig();
    }, []);

    const handleOnSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();
        const notificationService = new NotificationService();
        try {
            const response = await notificationService.saveNotificationConfig({ email: emailForNotifications });
            console.log('Response from saveNotificationConfig:', response);
            if (response) {
                toast.success(response.message || "Configuração de notificação salva com sucesso.");
            } else {
                toast.error(response.message || "Erro ao salvar a configuração de notificação.");
            }
        } catch (error) {
            console.error("Erro ao salvar a configuração de notificação:", error);
            toast.error("Erro ao salvar a configuração de notificação.");
        }
    }


    return (
        <Container>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8 mx-auto mt-8 bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">
                    Configuração de Notificações
                </h1>

                <form className="flex flex-col gap-4" onSubmit={handleOnSubmit}>

                    <Input
                        label="E-mail para notificações do sistema"
                        placeholder="Digite o e-mail para receber notificações"
                        type="email"
                        onChange={(e) => setEmailForNotifications(e.target.value)}
                        value={emailForNotifications}
                    />
                    <Button
                        type="submit"
                        variant="primary"
                        size="large"

                    >
                        Salvar Configuração
                    </Button>

                </form>
            </div>

            <div className="mt-4">
                <Button
                    type="button"
                    variant="secondary"
                    size="large"
                    onClick={() => redirect(NotificationRoutes.LIST)}
                >
                    Voltar
                </Button>
            </div>
        </Container>
    );
}