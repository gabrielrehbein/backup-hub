"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Title } from "@/app/components/Title";
import { useRouter } from "next/navigation";
import { BoltIcon } from "lucide-react";

import { useEffect, useState } from "react";
import { toast } from "react-toastify";
import { NotificationService } from "@/src/modules/notification/services/notification.service";
import { NotificationRoutes } from "@/src/modules/notification/routes/notification-routes";
import { NotificationType } from "@/src/modules/notification/types/notification-type";

export default function NotificationsPage() {
    const [notifications, setNotifications] = useState<NotificationType[]>([]);


    const router = useRouter();
    useEffect(() => {
        const fetchNotifications = async () => {
            const notificationService = new NotificationService();
            try {
                const data = await notificationService.getNotifications();
                setNotifications(data.data);
            } catch (error) {
                toast.error("Erro ao buscar notificações:" + error);
            }
        };

        fetchNotifications();
    }, []);



    return (
        <Container>
            <Header />
            <Title title="Notificações" />
            <div className="flex justify-end">
                <Button
                    size="medium"
                    onClick={() => router.push(NotificationRoutes.CONFIGURATION)}
                    className="mb-4 flex items-center gap-2"
                >
                    <BoltIcon size={16} />
                </Button>
            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th className="px-4 py-3 font-medium">ID</th>
                            <th className="px-4 py-3 font-medium">Tipo</th>
                            <th className="px-4 py-3 font-medium">Título</th>
                            <th className="px-4 py-3 font-medium">Para</th>
                            <th className="px-4 py-3 font-medium">ID Configuração</th>
                            <th className="px-4 py-3 font-medium">Criado em</th>
                        </tr>
                    </thead>

                    <tbody>
                        {notifications.map((notification) => (
                            <tr
                                key={notification.id}
                                onClick={() => router.push(NotificationRoutes.DETAIL(notification.id))}
                                className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                            >
                                <td className="px-4 py-3">{notification.id}</td>
                                <td className="px-4 py-3">{notification.type}</td>
                                <td className="px-4 py-3">{notification.title}</td>
                                <td className="px-4 py-3">{notification.to}</td>
                                <td className="px-4 py-3">{notification.notification_config_id}</td>
                                <td className="px-4 py-3">{new Date(notification.created_at).toLocaleString()}</td>
                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        </Container>
    );
}