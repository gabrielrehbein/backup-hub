"use client"

import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";
import { Input } from "@/app/components/Input";
import { Select } from "@/app/components/Select";
import { UserService } from "@/src/modules/user/services/users.service";
import { CreateUserType } from "@/src/modules/user/types/create-user-type";
import { redirect } from "next/navigation";
import { useState } from "react";
import { toast } from "react-toastify";

export default function CreateUserPage() {

    const [name, setName] = useState("");
    const [password, setPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");
    const [role, setRole] = useState<"default"|"admin">("default");


    const handleSubmit = (e: React.SubmitEvent) => {
        e.preventDefault();
        async function createUser() {
            const erros = validarSenha();
            if (erros.length > 0) {
                erros.forEach((erro) => {
                    toast.error(erro);
                });
                return;
            }
            const userService = new UserService();
            const user: CreateUserType = {
                name,
                password,
                email,
                phone,
                role
            };
            try{
                const data = await userService.createUser(user);
                if (data) {
                    toast.success("Usuário criado com sucesso:", data);
                } else {
                    toast.error("Failed to create user");
                }
            }
            catch (error) {
                toast.error("Erro ao criar usuário: " + error.message);
            }
                
        }
        createUser();
    
    }

    const validarSenha = () => {
        const erros = [];
        if (password.length < 8){
            erros.push("A senha deve ter pelo menos 8 caracteres.");
        }
        if (password !== confirmPassword){
            console.log("Password: ", password);
            console.log("Confirm Password: ", confirmPassword);
            erros.push("As senhas não coincidem.");
        }
        return erros;
    }



    return (
        <div>
            <Container>
                <Header />
                <h1 className="text-2xl font-bold">Criar Usuário</h1>
                <form className="flex flex-col gap-4" onSubmit={handleSubmit}>
                    <div className="flex flex-col gap-2">
                        <Input
                            label="Nome"
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Nome do Usuário"
                            required
                            className="border border-gray-300 rounded-md p-2"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                        />
                    </div>
                    <div className="flex gap-2">
                        <div className="flex flex-col gap-2 w-full">
                            <Input
                                label="E-mail"
                                type="text"
                                id="email"
                                name="email"
                                autoComplete="off"
                                placeholder="email@email.com"
                                required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                            />
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <Input
                                type="text"
                                id="phone"
                                name="phone"
                                placeholder="51999000000"
                                required
                                label="Telefone"
                                value={phone}
                                onChange={(e) => setPhone(e.target.value)}
                            />
                        </div>
                    </div>
                    <div className="flex gap-2">
                        <div className="flex flex-col gap-2 w-full">
                            <Input
                                label="Senha"
                                type="password"
                                id="password"
                                autoComplete="off"
                                name="password"
                                placeholder="Senha do Usuário"
                                required
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                            {password && validarSenha().map((erro, index) => (
                                <span key={index} className="text-red-500 text-sm">{erro}</span>
                            ))}
                        </div>
                        <div className="flex flex-col gap-2 w-full">
                            <Input
                                label="Confirmar Senha"
                                type="password"
                                autoComplete="off"
                                id="confirm-password"
                                name="confirm-password"
                                placeholder="Confirmar Senha do Usuário"
                                required
                                value={confirmPassword}
                                onChange={(e) => setConfirmPassword(e.target.value)}
                            />
                        </div>
                    </div>
    
    
                    <div className="flex flex-col gap-2">
                        <Select name="role" label="Tipo" onChange={(e) => setRole(e.target.value as "default"|"admin")}>
                            <option value="default">Padrão</option>
                            <option value="admin">Administrador</option>
                        </Select>
                    </div>
    
                    <Button
                        className="mt-12"
                        type="submit"
                        variant="primary"
                        size="large"
                    >
                        Criar Usuário
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
        </div>
    )
}