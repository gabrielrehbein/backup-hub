"use client";

import { LogOutIcon } from "lucide-react";
import { Button } from "./Button";
import { redirect } from "next/navigation";
import { AuthService } from "@/modules/auth/services/auth.service";

type HeaderProps = {
    username?: string;
};

export default function Header({ username }: HeaderProps) {

    async function handleLogout() {
        const authService = new AuthService();
        await authService.logout();
        redirect("/auth/login");
    }

    return (
        <header className="flex items-center justify-between mb-6">
            <div>
                <h1 className="text-4xl font-bold text-slate-900">
                    Backup Hub Dashboard
                </h1>
                {username && (
                    <p className="text-sm text-slate-500">
                        Bem-vindo, <span className="font-semibold">{username}</span>
                    </p>
                )}

                <p className="mt-1 text-sm text-slate-500">
                    Visão geral dos backups monitorados
                </p>
            </div>
            <div>
                <Button
                    variant="danger"
                    size="medium"
                    onClick={handleLogout}
                >
                    Sair
                    <LogOutIcon />
                </Button>
            </div>
        </header>
    );
}