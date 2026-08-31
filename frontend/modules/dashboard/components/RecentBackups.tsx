import { formatDate } from "date-fns";
import { Backup } from "../types/metrics.types";
import { CircleCheckIcon, CircleXIcon } from "lucide-react";

type RecentBackupsProps = {
    backups: Backup[];
    backupsType: "local" | "remote";
}

export function RecentBackups({
    backups,
    backupsType
}: RecentBackupsProps) {
    return (
        <section className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div className="border-b border-slate-200 p-6">

                <h2 className="font-semibold text-slate-900">
                    Últimos 10 Backups {backupsType === "local" ? "Local" : "Remoto"}
                </h2>


            </div>

            <div className="">

                <table className="w-full text-left text-sm">

                    <thead className="bg-slate-50">

                        <tr>
                            <th className="px-6 py-3 font-medium text-slate-500">
                                Cliente
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Sistema
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Gerado em
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Tamanho
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                IP de origem
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Caminho do arquivo
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Remoto
                            </th>
                        </tr>

                    </thead>

                    <tbody className="divide-y divide-slate-100">
                        {backups.length === 0 ? (
                            <tr>
                                <td colSpan={6} className="px-6 py-4 text-slate-500">
                                    Nenhum backup encontrado.
                                </td>
                            </tr>
                        ) : (
                            backups.map((backup, index) => (
                                <tr
                                    key={`${backup.client_name}-${index}`}
                                    className="hover:bg-slate-50"
                                >
                                    <td className="px-6 py-4 font-medium text-slate-800">
                                        {backup.client_name}
                                    </td>
                                    <td className="px-6 py-4 font-medium text-slate-800">
                                        {backup.system_name}
                                    </td>

                                    <td className="px-6 py-4 text-slate-500">
                                        {backup.generated_at ? new Date(backup.generated_at).toLocaleString() : 'sem data'}
                                    </td>

                                    <td className="px-6 py-4 text-slate-700">
                                        {backup.size} {backup.size_type.toUpperCase()}
                                    </td>

                                    <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                        {backup.source_ip}
                                    </td>

                                    <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                        {backup.file_path}
                                    </td>

                                    <td className="px-6 py-4 text-slate-700">
                                        {backup.is_local ? <CircleXIcon color="#cb1a1a" size={"20px"} /> : <CircleCheckIcon color="#1ccc0f" size={"20px"}/>}
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>

                </table>

            </div>

        </section>
    );
}