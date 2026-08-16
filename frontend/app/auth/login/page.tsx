import { Container } from "../../components/Container";
import { LoginForm } from "@/modules/auth/components/LoginForm";


export default function LoginPage() {
    return (
        <Container className="flex items-center justify-center min-h-screen ">
                <div className="rounded-xl border border-slate-200 bg-white shadow-sm p-6 w-150 ">
                    <h1 className="text-2xl mb-4 text-slate-900">Entrar</h1>
                    <LoginForm />
                </div>
        </Container>
    );
}