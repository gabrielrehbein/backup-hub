"use client";

import { Container } from "@/app/components/Container";
import { useState } from "react";


export default function SystemForm() {
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [category, setCategory] = useState("");

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const systemData = {
            name,
            description,
            category,
        };

        try {
            const response = await fetch("http://localhost:8000/api/systems", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                },
                body: JSON.stringify(systemData),
            });


            const data = await response.json();
            
            return data;
        } catch (error) {
            console.error("Erro ao criar o sistema:", error);
        }
    }

    return (
        <Container>
        <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
            <div className="flex flex-col gap-2">
                <label htmlFor="name">Nome do Sistema</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Nome do Sistema"
                    required
                    className="border border-gray-300 rounded-md p-2"
                    onChange={(e) => setName(e.target.value)}
                />
            </div>

            <div className="flex flex-col gap-2">
                <label htmlFor="description">Descrição</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Descrição do Sistema"
                    required
                    className="border border-gray-300 rounded-md p-2"
                    onChange={(e) => setDescription(e.target.value)}
                />
            </div>

            <select name="category" onChange={(e) => setCategory(e.target.value)} className="border border-gray-300 rounded-md p-2">
                <option value="erp">ERP</option>
                <option value="crm">CRM</option>
            </select>

            <button
                type="submit"
                className="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600 transition-colors"
            >
                Criar Sistema
            </button>
        </form>
        </Container>
    );
}