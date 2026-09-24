"use client";




export default function Header() {

    return (
        <header className="flex items-center justify-between mb-6 ">
            <div>
                <h1 className="text-4xl text-slate-100 font-bold">
                    Sistema Gerador de Backup (SGB)
                </h1>


                <p className="mt-1 text-sm text-slate-300">
                    Sistema responsável por gerar backups (fake)
                </p>
            </div>
            
        </header>
    );
}