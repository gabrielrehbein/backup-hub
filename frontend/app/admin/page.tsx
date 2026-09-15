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
                    <Button size='large' onClick={() => redirect('/admin/users/criar')}>
                        Usuários
                        <CircleUserRoundIcon />
                    </Button>
                    <Button size='large' onClick={() => redirect('/admin/clientes')}>
                        Clientes
                        <UsersRoundIcon />
                    </Button>
                    <Button size='large' onClick={() => redirect('/admin/sistemas/criar')}>
                        Sistemas
                        <MonitorCogIcon />
                    </Button>
                </div>

                <div className='flex justify-between gap-4'>
                    <Button size='large' onClick={() => redirect('/admin/instancias/criar')}>
                        Instancias
                        <HardDriveIcon />
                    </Button>

                    <Button size='large' onClick={() => redirect('/admin/planos/criar')}>
                        Plano
                        <SquareChartGanttIcon />
                    </Button>
                </div>
                <div className='flex justify-between gap-4'>
                    <Button size='large' onClick={() => redirect('/admin/backups/criar')}>
                        Backup
                        <DatabaseBackupIcon />
                    </Button>
                </div>

            </div>
        </Container>
    )
}
