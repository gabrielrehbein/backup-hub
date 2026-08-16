"use client";

import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";

import { Bar } from "react-chartjs-2";
import { BackupsGeneratedToday } from "../types/metrics.types";

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

type BackupsTodayChartProps = {
    backupsGeneratedToday: BackupsGeneratedToday;
};

export function BackupsTodayChart(props: BackupsTodayChartProps) {
    const data = {
        labels: props.backupsGeneratedToday.byHour.map(item => `${item.hour}H`),
        datasets: [
            {
                label: "Backups gerados hoje",
                data: props.backupsGeneratedToday.byHour.map(item => item.quantity),
                backgroundColor: "rgba(34, 197, 94, 0.7)",
                borderColor: "rgba(34, 197, 94, 1)",
                borderWidth: 1,
            },
        ],
    };

    const options = {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
            title: {
                display: true,
                text: "Backups gerados hoje",
            },
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                },
            },
        },
    };

    return (
        <div className="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm flex flex-col justify-between">
            <div className="border-b border-slate-200 p-6 flex items-center justify-between">
                <h2 className="font-semibold text-slate-900">Backups gerados hoje</h2>
                <p className="text-sm text-black">Total: <span className="font-bold ">{props.backupsGeneratedToday.total}</span></p>
            </div>

            <div className="p-6 m-auto">
                <Bar data={data} options={options} />
            </div>
        </div>
    );
}