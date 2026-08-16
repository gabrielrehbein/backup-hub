"use client";

import { useState } from "react";
import { toast } from "react-toastify";

export function LoginForm() {

    const [error, setError] = useState<string[]>([]);

    async function handleSubmit(event: React.SubmitEvent<HTMLFormElement>) {
        event.preventDefault();
        toast.info("Função de login não implementada. Por favor, implemente a lógica de autenticação.");
    }
    

    return (
        <form onSubmit={handleSubmit}>
            <input type="email" placeholder="E-mail" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" />
            <input type="password" placeholder="Senha" className="border border-slate-300 text-slate-900 rounded p-2 w-full mb-4" />
            <button type="submit" className="bg-blue-500 hover:bg-blue-600 cursor-pointer transition text-white rounded p-2 w-full">Entrar</button>
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