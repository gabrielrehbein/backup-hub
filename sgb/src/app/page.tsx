
import { Button } from "@/app/components/Button";
import { Container } from "@/app/components/Container";
import Header from "@/app/components/Header";

import { redirect } from "next/navigation";
import { BackupForm } from "./components/BackupForm";


export default function Home() {

  return (
    <div>

      <Container>
        <Header></Header>
        <div className="flex flex-col gap-4 align-center justify-center w-full p-8  mx-auto mt-8  bg-mist-950 rounded-lg shadow-md">
          <h1 className="text-2xl font-bold text-slate-100">Enviar Backup Teste</h1>
          <BackupForm apiKey={process.env.BACKUP_HUB_API_KEY!}/>
        </div>

      </Container>
    </div>
  );
}

