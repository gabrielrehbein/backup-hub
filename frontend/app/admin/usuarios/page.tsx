"use client"

import { Button } from "@/app/components/Button"
import { Container } from "@/app/components/Container"
import Header from "@/app/components/Header"
import { Input } from "@/app/components/Input"
import { PlusIcon, SearchIcon } from "lucide-react"
import { UserRoutes } from "@/src/modules/user/routes/user-routes"
import { redirect } from "next/navigation"
import { PublicUserType } from "@/src/modules/user/types/public-user-type"
import { useEffect, useState } from "react"
import { UserService } from "@/src/modules/user/services/users.service"

export default function UserPage(){
    const [users, setUsers] = useState<Array<PublicUserType>>([])

    useEffect(
        () => {
            const fetchUsers = async () => {
                const userService = new UserService();
                const users = await userService.getUsers();
                setUsers(users);
            }
            fetchUsers();
        }, 
    [])

    return (
        <div>

        <Container>
            <Header />
            <h1 className="text-2xl font-bold">Usuários</h1>
            <div className="flex justify-end">
                <Button variant="primary" onClick={() => { redirect(UserRoutes.CREATE) }}> <PlusIcon /></Button>
            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">
                        <tr>
                            <th className="px-4 py-3 font-medium">ID</th>
                            <th className="px-4 py-3 font-medium">Nome</th>
                            <th className="px-4 py-3 font-medium">E-mail</th>
                            <th className="px-4 py-3 font-medium">Telefone</th>
                            <th className="px-4 py-3 font-medium">Tipo</th>
                        </tr>
                    </thead>

                    <tbody>
                        {users.map((user) => (
                            <tr key={user.id} className="border-b border-gray-200">
                                <td className="px-4 py-3">{user.id}</td>
                                <td className="px-4 py-3">{user.name}</td>
                                <td className="px-4 py-3">{user.email}</td>
                                <td className="px-4 py-3">{user.phone}</td>
                                <td className="px-4 py-3">{user.role}</td>
                            </tr>
                        ))}

                    </tbody>
                </table>
            </div>
        </Container>
        </div>
    )
}