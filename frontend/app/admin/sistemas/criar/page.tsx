"use client";

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import { redirect } from "next/navigation";
import { useEffect, useState } from "react";


export default function SystemForm() {
    const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [categories, setCategories] = useState<any[]>([]);
    const [categoryId, setCategoryId] = useState("");

    useEffect(() => {
        const fetchCategoryId = async () => {
            try {
                const response = await fetch(`http://localhost:8000/api/categories`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${localStorage.getItem("backup-hub-token") || ""}`,
                    },
                });
                const data = await response.json();
                console.log("Categorias:", data);
                setCategories(data.data);
            } catch (error) {
                console.error("Erro ao buscar a categoria:", error);
            }
        };

        fetchCategoryId();
    }, []);

    const handleSubmit = async (e: React.SubmitEvent) => {
        e.preventDefault();

        const systemData = {
            name,
            description,
            category_id: categoryId,
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

                <div className="flex flex-col gap-2">
                    <label htmlFor="category_id">Categoria</label>
                    <select name="category_id" onChange={(e) => setCategoryId(e.target.value)} className="border border-gray-300 rounded-md p-2">
                        <option value="" disabled selected>Selecione uma Categoria</option>
                        {categories.map((category) => (
                            <option key={category.id} value={category.id}>
                                {category.name}
                            </option>
                        ))}
                    </select>
                </div>

                <Button
                    type="submit"
                    variant="primary"
                    size="large"
                >
                    Criar Sistema
                </Button>
            </form>
            <Button
                onClick={() => { redirect('/admin') }}
                variant="secondary"
                size="large"


            >
                Voltar
            </Button>
        </Container>
    );
}