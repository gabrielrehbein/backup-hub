export function Container({ children, className }: { children: React.ReactNode; className?: string }) {
    return (
        <main className={`min-h-screen bg-slate-100 p-6 ${className ?? ""}`}>
            <div className="mx-auto max-w-7xl space-y-6">
                {children}
            </div>
        </main>
    );
}