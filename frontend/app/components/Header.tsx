"use client";

import { LogOutIcon } from "lucide-react";
import { Button } from "./Button";
import { redirect } from "next/navigation";

export default function Header() {
    return (
        <header className="flex items-center justify-between mb-6">
            <div>
                <h1 className="text-4xl font-bold text-slate-900">
                    Backup Hub Dashboard
                </h1>

                <p className="mt-1 text-sm text-slate-500">
                    Visão geral dos backups monitorados
                </p>
            </div>
            <div>
                <Button
                    variant="danger"
                    size="medium"
                    onClick={() => {
                        redirect("/auth/login");
                    }}
                >
                    Sair
                    <LogOutIcon />
                </Button>
            </div>
        </header>
    );
}