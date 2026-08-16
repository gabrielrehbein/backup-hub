import { getMockDashboardData } from "../mocks/dashboard.mock";


export class DashboardService {
    public async getMetrics() {
        return await getMockDashboardData();
    }
}