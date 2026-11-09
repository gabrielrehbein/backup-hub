"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { Input } from "@/app/components/Input";
import { Title } from "@/app/components/Title";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { PlanType } from "@/src/modules/client/types/plan-type";
import { NotificationRoutes } from "@/src/modules/notification/routes/notification-routes";
import { NotificationService } from "@/src/modules/notification/services/notification.service";
import { NotificationType } from "@/src/modules/notification/types/notification-type";

import { useParams, useRouter } from "next/navigation";
import { FormEvent, useEffect, useState } from "react";
import { toast } from "react-toastify";


export default function NotificationDetailsPage() {
    const params = useParams<{ id: string }>();
    const router = useRouter();

    const id = params.id;

    const [notification, setNotification] = useState<NotificationType>();

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if (!id) return;
        const fetchNotificationDetails = async () => {
            try {
                const notificationService = new NotificationService();
                const data = await notificationService.getNotificationById(Number(id));
                setNotification(data.data);
            } catch (error) {
                toast.error(
                    "Erro ao carregar os detalhes da notificação: "+
                    error
                );
            } finally {
                setLoading(false);
            }
        };
        fetchNotificationDetails();
    }, [id]);

  

    if (loading) {
        return (
            <Container>
                <p className="text-slate-600">
                    Carregando notificação...
                </p>
            </Container>
        );
    }

    if (!notification) {
        return (
            <Container>
                <div className="flex flex-col gap-4">
                    <h1 className="text-2xl font-bold text-slate-900">
                        Notificação não encontrada
                    </h1>

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

    return (
        <Container>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <Title title="Detalhes da Notificação" />

                <form
                    className="flex flex-col gap-4"
                >   
                    <Input  name="id" defaultValue={notification.id} label="ID" disabled/>

                    <Input  name="name" defaultValue={notification.type} label="Tipo" disabled/>
                    <Input  name="name" defaultValue={notification.title} label="Título" disabled/>
                    <Input  name="name" defaultValue={notification.to} label="Para" disabled/>
                    <div className="w-full flex flex-col gap-2">
                        <label htmlFor="content" className="text-sm font-semibold text-slate-700 flex gap-1">
                            Conteúdo
                            <span className="text-red-500">*</span>
                        </label>
                        <textarea
                            id="content"
                            name="content"
                            defaultValue={notification.content}
                            disabled
                            className={`border w-full bg-gray-200 cursor-not-allowed border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent `}
                        />
                    </div>
                    <Input  name="name" defaultValue={notification.notification_config_id} label="ID Configuração" disabled/>
                    <Input  name="name" defaultValue={new Date(notification.created_at).toLocaleString()} label="Criado em" disabled/>
                    <Input name="name" defaultValue={new Date(notification.updated_at).toLocaleString()} label="Atualizado em" disabled/>
                </form>

            </div>
            <Button
                type="button"
                variant="secondary"
                size="large"
                onClick={() => router.push(NotificationRoutes.LIST)}
            >
                Voltar
            </Button>
        </Container>
    );
}