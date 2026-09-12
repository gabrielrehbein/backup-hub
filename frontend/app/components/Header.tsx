"use client";

import { LogOutIcon } from "lucide-react";
import { Button } from "./Button";
import { redirect } from "next/navigation";
import { AuthService } from "@/modules/auth/services/auth.service";
import { useAuth } from "@/modules/auth/providers/AuthProvider";

type HeaderProps = {
    username?: string;
};

export default function Header({ username }: HeaderProps) {

    const { isAdmin } = useAuth();
    console.log("isAdmin:", isAdmin);

    async function handleLogout() {
        const authService = new AuthService();
        await authService.logout();
        redirect("/auth/login");
    }

    async function handleAdmin() {
        redirect("/admin");
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
            <div className="flex items-center gap-6">
                {isAdmin && (
                    
                <Button
                        variant="primary"
                        size="medium"
                        onClick={handleAdmin}
                    >
                        Admin
                </Button>
                )}
                <Button
                    variant="danger"
                    size="medium"
                    onClick={handleLogout}
                >
                    Sair
                    <LogOutIcon size={20}/>
                </Button>
            </div>
        </header>
    );
}