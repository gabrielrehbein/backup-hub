"use client";

import { Button } from "@/app/components/Button";

import { EyeClosedIcon, EyeIcon } from "lucide-react";
import { useEffect, useState } from "react";
import { toast } from "react-toastify";

type BackupFormProps = {
    apiKey: string
}

export function BackupForm({ apiKey }: BackupFormProps) {
    const [size, setSize] = useState("");
    const [sizeType, setSizeType] = useState("kb");
    const [generatedAt, setGeneratedAt] = useState(() => {
        const now = new Date();
    
        const offset = now.getTimezoneOffset();
        const localDate = new Date(now.getTime() - offset * 60000);
    
        return localDate.toISOString().slice(0, 16);
    });
    const [sourceIp, setSourceIp] = useState("");
    const [isLocal, setIsLocal] = useState(true);
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
            const data = await response.json();
            if (!response.ok) {
                setIsSubmitting(false);
                toast.error(data.message);
                console.error("Erro ao enviar o backup:", data.message);
                return;
            }


            toast.success("Backup enviado com sucesso!");
            console.log("Backup enviado com sucesso:", data);
        } catch (error) {
            console.error("Erro ao enviar o backup:", error);
        } finally {
            setSize("");
            setSizeType("kb");
            setGeneratedAt("");
            setSourceIp("");
            setIsLocal(true);
            setFilePath("");
            setVisible(false);
            setIsSubmitting(false);
        }
    }

    function handleOnChangeIsLocal(e: React.ChangeEvent<HTMLSelectElement>) {
        const value = e.target.value;
        setIsLocal(value === "local");
        console.log("isLocal:", isLocal);
    }
    return (
        <form className="flex flex-col gap-4" onSubmit={handleSubmit} method="POST">
            <div className="flex flex-col gap-2">
                <label htmlFor="api_key" className="text-sm font-semibold text-slate-200">
                    Chave de API
                </label>
                <div className="flex gap-2 w-full">
                    <input type={visible ? "text" : "password"}
                        autoComplete="off"
                        value={apiKey}
                        name="api_key"
                        id="api_key"
                        required
                        disabled
                        placeholder="Insira sua chave de API"
                        className="border w-full text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
                    <Button size="small" type="button" onClick={() => setVisible(!visible)}>
                        {visible ? <EyeIcon /> : <EyeClosedIcon />}
                    </Button>
                </div>
            </div>
            <div className="flex flex-col gap-2">
                <label htmlFor="generated_at" className="text-sm font-semibold text-slate-200">
                    Gerado em
                </label>
                <input
                    type="datetime-local"
                    id="generated_at"
                    name="generated_at"
                    required
                    autoComplete="off"
                    value={generatedAt}
                    onChange={(e) => setGeneratedAt(e.target.value)}
                    className="border text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                />
            </div>

            <div className="flex gap-2 justify-between">
                <div className="flex flex-col gap-2 w-full">
                    <label htmlFor="size" className="text-sm font-semibold text-slate-200">
                        Tamanho
                    </label>
                    <input
                        type="text"
                        id="size"
                        required
                        autoComplete="off"
                        placeholder="100000"
                        name="size"
                        onChange={(e) => setSize(e.target.value)}
                        className="border h-10 text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    />
                </div>
                <div className="flex flex-col gap-2 w-full">
                    <label htmlFor="size_type" className="text-sm font-semibold text-slate-200">
                        Unidade
                    </label>
                    <select
                        name="size_type"
                        id="size_type"
                        required
                        autoComplete="off"
                        onChange={(e) => setSizeType(e.target.value)}
                        className="border h-10 text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="kb">KB</option>
                        <option value="mb">MB</option>
                        <option value="gb">GB</option>
                    </select>
                </div>

            </div>
            <div className="flex gap-2 justify-between">
                <div className="flex flex-col gap-2 w-full">
                    <label htmlFor="source_ip" className="text-sm font-semibold text-slate-200">
                        IP de origem
                    </label>
                    <input
                        type="text"
                        id="source_ip"
                        required
                        autoComplete="off"
                        placeholder="192.168.0.10"
                        name="source_ip"
                        onChange={(e) => setSourceIp(e.target.value)}
                        className="border text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    />
                </div>
                <div className="flex flex-col gap-2 w-full">
                    <label htmlFor="is_local" className="text-sm font-semibold text-slate-200">
                        Realizado de forma
                    </label>
                    <select
                        name="is_local"
                        required
                        autoComplete="off"
                        id="is_local_type"
                        onChange={(e) => handleOnChangeIsLocal(e)}
                        className="border h-10 text-slate-100 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="local">Local</option>
                        <option value="remote">Remota</option>
                    </select>
                </div>

            </div>
            <div className="flex flex-col gap-2 w-full">
                <label htmlFor="size" className="text-sm font-semibold text-slate-200">
                    Caminho do arquivo
                </label>
                <input
                    type="text"
                    autoComplete="off"
                    id="file_path"
                    name="file_path"
                    required
                    placeholder="C://meus_backups/backup.zip"
                    onChange={(e) => setFilePath(e.target.value)}
                    className="border text-slate-100 mb-4 border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
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
    );
}