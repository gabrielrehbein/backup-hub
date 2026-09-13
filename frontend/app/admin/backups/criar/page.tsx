"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { set } from "date-fns";
import { EyeClosedIcon, EyeIcon } from "lucide-react";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

export default function BackupForm() {
    const [apiKey, setApiKey] = useState("");
    const [size, setSize] = useState("");
    const [sizeType, setSizeType] = useState("kb");
    const [generatedAt, setGeneratedAt] = useState("");
    const [sourceIp, setSourceIp] = useState("");
    const [isLocal, setIsLocal] = useState(false);
    const [filePath, setFilePath] = useState("");
    const [visible, setVisible] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);



    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const backupData = {
            size: size,
            size_type: sizeType,
            generated_at: generatedAt,
            source_ip: sourceIp,
            is_local: isLocal,
            file_path: filePath,
            version: "1.0.0",
        };

        try {
            setIsSubmitting(true);
            console.log("API KEY:", apiKey);
            console.log("BACKUP DATA:", backupData);
            const response = await fetch("http://localhost:8000/api/backups", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-API-KEY": apiKey,
                },
                body: JSON.stringify(backupData),
            });
            setIsSubmitting(false);

            if (!response.ok) {
                throw new Error(response.statusText);
            }

            const data = await response.json();
            toast.success("Backup enviado com sucesso!");
            console.log("Backup enviado com sucesso:", data);
        } catch (error) {
            setIsSubmitting(false);
            toast.error("Algo deu errado ao enviar o backup.");
            console.error("Erro ao enviar o backup:", error);
        }
    }

        

    return (
        <div>
            
        <Container>
        <Header></Header>
            <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-white rounded-lg shadow-md">
                <h1 className="text-2xl font-bold text-slate-900">Enviar Backup Teste</h1>
                <form className="flex flex-col gap-4" onSubmit={handleSubmit} method="POST">
                    <div className="flex flex-col gap-2">
                        <label htmlFor="api_key" className="text-sm font-semibold text-slate-700">
                            Chave de API
                        </label>
                        <div className="flex gap-2 w-full">
                            <input type={visible ? "text" : "password"} 
                            name="api_key"
                            id="api_key"
                            required
                            placeholder="Insira sua chave de API"
                            onChange={(e) => setApiKey(e.target.value)}
                            className="border w-full border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                            <Button size="small" type="button" onClick={() => setVisible(!visible)}>
                                {visible ? <EyeIcon /> : <EyeClosedIcon />}
                            </Button>
                        </div>
                    </div>
                    <div className="flex flex-col gap-2">
                        <label htmlFor="generated_at" className="text-sm font-semibold text-slate-700">
                            Gerado em
                        </label>
                        <input
                            type="datetime-local"
                            id="generated_at"
                            name="generated_at"
                            required
                            onChange={(e) => setGeneratedAt(e.target.value)}
                            className="border border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <div className="flex gap-2 justify-between">
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="size" className="text-sm font-semibold text-slate-700">
                                Tamanho
                            </label>
                            <input
                                type="text"
                                id="size"
                                required
                                placeholder="100000"
                                name="size"
                                onChange={(e) => setSize(e.target.value)}
                                className="border h-10 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="size_type" className="text-sm font-semibold text-slate-700">
                                Unidade
                            </label>
                            <select
                                name="size_type"
                                id="size_type"
                                required
                                onChange={(e) => setSizeType(e.target.value)}
                                className="border h-10  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="kb">KB</option>
                                <option value="mb">MB</option>
                                <option value="gb">GB</option>
                            </select>
                        </div>

                    </div>
                    <div className="flex gap-2 justify-between">
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="source_ip" className="text-sm font-semibold text-slate-700">
                                IP de origem
                            </label>
                            <input
                                type="text"
                                id="source_ip"
                                required
                                placeholder="192.168.0.10"
                                name="source_ip"
                                onChange={(e) => setSourceIp(e.target.value)}
                                className="border  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <label htmlFor="is_local" className="text-sm font-semibold text-slate-700">
                                Realizado de forma
                            </label>
                            <select
                                name="is_local"
                                required
                                id="is_local_type"
                                onChange={(e) => setIsLocal(e.target.value === "local")}
                                className="border h-10  border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="local">Local</option>
                                <option value="remote">Remota</option>
                            </select>
                        </div>

                    </div>
                    <div className="flex flex-col gap-2 w-full">
                        <label htmlFor="size" className="text-sm font-semibold text-slate-700">
                            Caminho do arquivo
                        </label>
                        <input
                            type="text"
                            id="file_path"
                            name="file_path"
                            required
                            placeholder="C://meus_backups/backup.zip"
                            onChange={(e) => setFilePath(e.target.value)}
                            className="border mb-4 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                    </div>

                    <Button
                        type="submit"
                        variant={!isSubmitting ? "primary" : "ghost"}
                        size="large"
                        disabled={isSubmitting}
                    >
                        Enviar Backup
                    </Button>
                </form>
            </div>
            <Button
                onClick={() => { redirect('/admin') }}
                variant="secondary"
                size="large"
            >
                Voltar
            </Button>
        </Container>
        </div>
    );
}

