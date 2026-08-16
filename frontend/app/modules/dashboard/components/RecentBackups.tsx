import { formatDate } from "date-fns";
import { Backup } from "../types/metrics.types";

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
                                Local
                            </th>
                        </tr>

                    </thead>

                    <tbody className="divide-y divide-slate-100">

                        {backups.map((backup, index) => (

                            <tr
                                key={`${backup.clientName}-${index}`}
                                className="hover:bg-slate-50"
                            >

                                <td className="px-6 py-4 font-medium text-slate-800">
                                    {backup.clientName}
                                </td>

                                <td className="px-6 py-4 text-slate-500">
                                    {formatDate(backup.generatedAt, "dd/MM/yyyy 'às' HH'h'mm")}
                                </td>

                                <td className="px-6 py-4 text-slate-700">
                                    {backup.fileSize} {backup.sizeUnit}
                                </td>

                                <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                    {backup.ipSource}
                                </td>

                                <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                    {backup.filePath}
                                </td>

                                <td className="px-6 py-4 text-slate-700">
                                    {backup.isLocal ? "Local" : "Remoto"}
                                </td>

                            </tr>

                        ))}

                    </tbody>

                </table>

            </div>

        </section>
    );
}