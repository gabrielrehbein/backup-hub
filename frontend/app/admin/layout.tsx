"use client";

import { useEffect } from "react";
import { useRouter } from "next/navigation";
import { useAuth } from "@/src/modules/auth/providers/AuthProvider";


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


    if (loading || !isAdmin) {
        return (
            <div className="flex flex-1 items-center justify-center text-slate-500">
                Carregando...
            </div>
        );
    }

    return <>{children}</>;
}
