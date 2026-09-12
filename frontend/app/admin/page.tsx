"use client";

import Header from '../components/Header';
import { Container } from '../components/Container';
import { Button } from '../components/Button';
import { CircleUserRoundIcon, DatabaseBackupIcon, HardDriveIcon, MonitorCogIcon, SquareChartGanttIcon, UsersRoundIcon } from 'lucide-react';
import { useAuth } from '@/modules/auth/providers/AuthProvider';
import { redirect } from 'next/navigation';

export default function AdminPage() {
    const isAdmin = useAuth().isAdmin;
    if(!isAdmin) {
        redirect('/dashboard');
    }
    return (
        <Container>
            <Header />
            <div className='flex flex-col gap-4'>
                <div className='flex justify-between gap-4'>
                    <Button size='large'>
                        Usuários
                        <CircleUserRoundIcon />
                    </Button>
                    <Button size='large'>
                        Clientes
                        <UsersRoundIcon />
                    </Button>
                    <Button size='large'>
                        Sistemas
                        <MonitorCogIcon />
                    </Button>
                </div>

                <div className='flex justify-between gap-4'>
                    <Button size='large'>
                        Instancias
                        <HardDriveIcon />
                    </Button>

                    <Button size='large'>
                        Plano
                        <SquareChartGanttIcon />
                    </Button>
                </div>
                <div className='flex justify-between gap-4'>
                    <Button size='large'>
                        Backup
                        <DatabaseBackupIcon />
                    </Button>
                </div>

            </div>
        </Container>
    )
}
