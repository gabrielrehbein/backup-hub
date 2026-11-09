"use client";

import Header from '../components/Header';
import { Container } from '../components/Container';
import { Button } from '../components/Button';
import { BellRingIcon, BoltIcon, CircleUserRoundIcon, DatabaseBackupIcon, GaugeIcon, HardDriveIcon, MonitorCogIcon, SquareChartGanttIcon, UsersRoundIcon } from 'lucide-react';
import { redirect } from 'next/navigation';
import { UserRoutes } from '@/src/modules/user/routes/user-routes';
import { ClientRoutes } from '@/src/modules/client/routes/client-routes';
import { SystemRoutes } from '@/src/modules/system/routes/system-routes';
import { InstanceRoutes } from '@/src/modules/system/routes/instance-routes';
import { PlanRoutes } from '@/src/modules/client/routes/plan-routes';
import { BackupRoutes } from '@/src/modules/backup/routes/backup-routes';
import { DashboardRoutes } from '@/src/modules/dashboard/routes/dashboard-routes';
import { RiskRoutes } from '@/src/modules/risk/routes/risk-routes';
import { NotificationRoutes } from '@/src/modules/notification/routes/notification-routes';

export default function AdminPage() {
    return (
        <Container>
            <Header />
            <div className='flex flex-col gap-4'>
                <div className='flex justify-between gap-4'>
                    <Button size='large' onClick={() => redirect(UserRoutes.LIST)}>
                        Usuários
                        <CircleUserRoundIcon />
                    </Button>
                    <Button size='large' onClick={() => redirect(ClientRoutes.LIST)}>
                        Clientes
                        <UsersRoundIcon />
                    </Button>
                    <Button size='large' onClick={() => redirect(SystemRoutes.CREATE)}>
                        Sistemas
                        <MonitorCogIcon />
                    </Button>
                </div>

                <div className='flex justify-between gap-4'>
                    <Button size='large' onClick={() => redirect(InstanceRoutes.LIST)}>
                        Instancias
                        <HardDriveIcon />
                    </Button>

                    <Button size='large' onClick={() => redirect(PlanRoutes.LIST)}>
                        Plano
                        <SquareChartGanttIcon />
                    </Button>

                    <Button size='large' onClick={() => redirect(RiskRoutes.LIST)}>
                        Riscos
                        <BoltIcon />
                    </Button>
                </div>
                <div className='flex justify-between gap-4'>
                    <Button size='large' onClick={() => redirect(NotificationRoutes.LIST)}>
                        Notificações
                        <BellRingIcon />
                    </Button>
                    <Button size='large' onClick={() => redirect(DashboardRoutes.LIST)}>
                        Dashboard
                        <GaugeIcon />
                    </Button>
                </div>

            </div>
        </Container>
    )
}
