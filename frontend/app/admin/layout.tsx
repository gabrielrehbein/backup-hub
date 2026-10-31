"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/src/modules/auth/providers/AuthProvider";

// Protege todas as rotas dentro de /admin (/admin, /admin/clientes, /admin/usuarios...).
// É só uma proteção visual: quem garante a segurança são as policies da API (403).
export default function AdminLayout({ children }: { children: React.ReactNode }) {
    const { user, isAdmin, loading } = useAuth();
    const router = useRouter();

    useEffect(() => {
        if (loading) return;
        if (!user) {
            router.replace("/auth/login");
        } else if (!isAdmin) {
            router.replace("/dashboard");
        }
    }, [loading, user, isAdmin, router]);

    // não renderiza nada da área admin até confirmar que o usuário é admin
    if (loading || !isAdmin) {
        return (
            <div className="flex flex-1 items-center justify-center text-slate-500">
                Carregando...
            </div>
        );
    }

    return <>{children}</>;
}
