import { Dashboard } from "../types/metrics.types";

export async function getMockDashboardData(): Promise<Dashboard> {
    return {
        summary: {
            total_clients: 645,
            total_backups: 43244,
            risk_backups: 45,
            backups_generated_today: 5,
        },

        riskDistribution: [
            { name: "Low", level: 1, quantity: 20 },
            { name: "Medium", level: 2, quantity: 15 },
            { name: "High", level: 3, quantity: 10 },
            { name: "Critical", level: 4, quantity: 5 },
        ],

        riskByType: [
            {
                type: "TIME",
                quantity: 30,
            },
            {
                type: "SIZE",
                quantity: 15,
            },
        ],

        recentBackups: {
            local: [
                {
                    clientName: "Center Aço",
                    generatedAt: new Date(),
                    fileSize: 374,
                    sizeUnit: "MB",
                    ipSource: "192.168.1.1",
                    filePath: "C:\\MC_Copia",
                    isLocal: true,
                },
            ],

            remote: [
                {
                    clientName: "Center Mix",
                    generatedAt: new Date(),
                    fileSize: 123,
                    sizeUnit: "MB",
                    ipSource: "192.168.1.2",
                    filePath: "/home/1529_centermix/CENTER_MIX",
                    isLocal: false,
                },
            ],
        },

        backupsGeneratedToday: {
            byHour: [
                { hour: 0, quantity: 0 },
                { hour: 1, quantity: 4 },
                { hour: 2, quantity: 2 },
                { hour: 3, quantity: 2 },
                { hour: 4, quantity: 4 },
                { hour: 5, quantity: 3 },
                { hour: 6, quantity: 2 },
                { hour: 7, quantity: 5 },
                { hour: 8, quantity: 1 },
                { hour: 9, quantity: 2 },
                { hour: 10, quantity: 1 },
                { hour: 11, quantity: 1 },
                { hour: 12, quantity: 3 },
                { hour: 13, quantity: 0 },
                { hour: 14, quantity: 4 },
                { hour: 15, quantity: 0 },
                { hour: 16, quantity: 8 },
                { hour: 17, quantity: 6 },
                { hour: 18, quantity: 3 },
                { hour: 19, quantity: 3 },
                { hour: 20, quantity: 0 },
                { hour: 21, quantity: 2 },
                { hour: 22, quantity:  1},
                { hour: 23, quantity: 0 },
            ],
            total: 65,
        },
        clientsWithMostBackupRiskByPlan: [
            {
                planName: "Platina",
                clients: [
                    {
                        clientName: "Mercado Krolow",
                        riskQuantity: 12,
                    },
                    {
                        clientName: "Empel",
                        riskQuantity: 9,
                    },
                ],
            },

            {
                planName: "Bronze",
                clients: [
                    {
                        clientName: "Love Mackup",
                        riskQuantity: 2,
                    },
                    {
                        clientName: "Transportes Munchow",
                        riskQuantity: 1,
                    },
                ],
            },
        ],
    };
}