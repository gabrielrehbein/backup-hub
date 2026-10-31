"use client";

import { createContext, useCallback, useContext, useEffect, useState } from "react";
import { AuthService } from "../services/auth.service";
import type { PublicUserType } from "../../user/types/public-user-type";

type AuthContextType = {
    user: PublicUserType | null;
    isAdmin: boolean;
    // true enquanto o usuário ainda está sendo buscado na API
    loading: boolean;
    // recarrega o usuário (chamar depois do login e do logout)
    refresh: () => Promise<void>;
};

const AuthContext = createContext<AuthContextType>({
    user: null,
    isAdmin: false,
    loading: true,
    refresh: async () => {},
});

export function AuthProvider({ children }: { children: React.ReactNode }) {
    const [user, setUser] = useState<PublicUserType | null>(null);
    const [loading, setLoading] = useState(true);

    // busca o usuário na API e só altera o estado depois da resposta
    const fetchUser = useCallback(
        () => new AuthService().getAuthUser().then((authUser) => authUser ?? null).catch(() => null),
        [],
    );

    useEffect(() => {
        let active = true;
        fetchUser().then((authUser) => {
            if (!active) return;
            setUser(authUser);
            setLoading(false);
        });
        return () => {
            active = false;
        };
    }, [fetchUser]);

    const refresh = useCallback(async () => {
        setLoading(true);
        setUser(await fetchUser());
        setLoading(false);
    }, [fetchUser]);

    return (
        <AuthContext.Provider value={{ user, isAdmin: user?.role === "admin", loading, refresh }}>
            {children}
        </AuthContext.Provider>
    );
}

export function useAuth() {
    return useContext(AuthContext);
}
