"use client";

import { Button } from "@/app/components/Button";
import { LogIn, LogInIcon } from "lucide-react";
import { redirect } from "next/navigation";
import { useState } from "react";
import { toast } from "react-toastify";

export function LoginForm() {

    const [error, setError] = useState<string[]>([]);

    async function handleSubmit(event: React.SubmitEvent<HTMLFormElement>) {
        event.preventDefault();
        redirect("/dashboard");
    }
    

    return (
        <form onSubmit={handleSubmit}>
            <input required type="email" placeholder="E-mail" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" />
            <input required type="password" placeholder="Senha" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" />
            <Button type="submit" size="medium" variant="primary" className="w-full flex items-center justify-center gap-2">
                Entrar
                <LogIn color="white"/>
            </Button>

            {error.length > 0 && (
                <div className="mt-4 text-red-500">
                    {error.map((err, index) => (
                        <p key={index}>{err}</p>
                    ))}
                </div>
            )}
        </form>
    )
}