"use client";

import { Button } from "@/app/components/Button";
import { LogIn, LogInIcon } from "lucide-react";
import { redirect } from "next/navigation";
import { useState } from "react";
import { toast } from "react-toastify";
import { AuthService } from "../services/auth.service";

export function LoginForm() {

    const [email, setEmail] = useState<string>('');
    const [password, setPassword] = useState<string>('');
    const [loading, setLoading] = useState<boolean>(false);


    async function handleSubmit(event: React.SubmitEvent<HTMLFormElement>) {
        event.preventDefault();
        const authService = new AuthService();
        setLoading(true);
        const response = await authService.login({ email, password });
        setLoading(false);
        if(!response) {
            setLoading(false);
            toast.error("E-mail ou senha inválido(s)");
            return;
        }
        redirect("/dashboard");
    }
    

    return (
        <form onSubmit={handleSubmit}>
            <input required type="email" placeholder="E-mail" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" value={email} onChange={(e) => setEmail(e.target.value)} />
            <input required type="password" placeholder="Senha" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" value={password} onChange={(e) => setPassword(e.target.value)} />
            <Button  type="submit" size="large" variant="primary" className="flex items-center justify-center gap-2" disabled={loading}>
                Entrar
            </Button>


        </form>
    )
}