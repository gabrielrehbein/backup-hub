
type SummaryCardProps = {
    title: string;
    value: number;
    description: string;
    type?: "danger" | "info" | "success" | "warning";
    size?: "small" | "medium" | "large";
};

export function SummaryCard({
    title,
    value,
    description,
    type,
    size = "small",
}: SummaryCardProps) {
    return (
        <div
            className={`rounded-xl border border-slate-200 bg-white shadow-sm ${
                size === "small"
                    ? "w-1/5 p-5"
                    : size === "medium"
                        ? "w-1/4 p-6"
                        : "w-1/3 p-8"
            }`}
        >
            <p className="text-sm font-medium text-slate-500">
                {title}
            </p>

            <p
                className={`mt-2 text-3xl font-bold ${
                    type === "danger"
                        ? "text-red-600"
                        : type === "info"
                            ? "text-blue-600"
                            : type === "success"
                                ? "text-green-600"
                                : type === "warning"
                                    ? "text-yellow-600"
                                    : "text-slate-900"
                }`}
            >
                {value.toLocaleString("pt-BR")}
            </p>

            <p className="mt-1 text-xs text-slate-400">
                {description}
            </p>
        </div>
    );
}