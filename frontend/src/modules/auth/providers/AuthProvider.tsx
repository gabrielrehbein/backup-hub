// AuthProvider.tsx

"use client";

import { createContext, useContext, useEffect, useState } from "react";
import { AuthService } from "../services/auth.service";


type AuthContextType = {
    isAdmin: boolean;
};

const AuthContext = createContext<AuthContextType>({
    isAdmin: false,
});

export function AuthProvider({
    children,
}: {
    children: React.ReactNode;
}) {
    const [isAdmin, setIsAdmin] = useState(false);

    useEffect(() => {
        async function loadUser() {
            const authService = new AuthService();
            const authUser = await authService.getAuthUser();

            setIsAdmin(authUser?.role === "admin");
        }

        loadUser();
    }, []);

    return (
        <AuthContext.Provider value={{ isAdmin }}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    return useContext(AuthContext);
}