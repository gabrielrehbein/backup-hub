"use client";

import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { BoltIcon } from "lucide-react";

export default function RiskPage() {
    return (
        <Container>
            <Header />
            <div className="flex flex-col gap-4">
                <div className="flex justify-between gap-4">
                    <h1 className="text-2xl font-bold">Riscos</h1>
                </div>
                <div className="flex justify-between gap-4">
                    <button
                        className="relative cursor-pointer w-full border-2 border-blue-600/40 bg-white shadow-sm rounded-lg p-4 hover:bg-blue-50 transition"
                        onClick={() => console.log("Configurar risco: Baixo")}
                    >
                        <span className="absolute top-2 left-2">
                            <BoltIcon />
                        </span>
                        <h2 className="text-lg font-semibold text-blue-600">Baixo</h2>
                        <p className="text-sm text-gray-500">Clique para configurar o risco baixo</p>
                    </button>
                    <button
                        className="relative w-full cursor-pointer border-2 border-yellow-600/40 bg-white shadow-sm rounded-lg p-4 hover:bg-yellow-50 transition"
                        onClick={() => console.log("Configurar risco: Médio")}
                    >
                        <span className="absolute top-2 left-2 ">
                            <BoltIcon />
                        </span>
                        <h2 className="text-lg font-semibold text-yellow-600">Médio</h2>
                        <p className="text-sm text-gray-500">Clique para configurar o risco médio</p>
                    </button>
                    <button
                        className="relative w-full cursor-pointer border-2 border-red-600/40 bg-white shadow-sm rounded-lg p-4 hover:bg-red-50 transition"
                        onClick={() => console.log("Configurar risco: Alto")}
                    >
                        <span className="absolute top-2 left-2">
                            <BoltIcon />
                        </span>
                        <h2 className="text-lg font-semibold text-red-600">Alto</h2>
                        <p className="text-sm text-gray-500">Clique para configurar o risco alto</p>
                    </button>
                </div>
            </div>
        </Container>
    );
}