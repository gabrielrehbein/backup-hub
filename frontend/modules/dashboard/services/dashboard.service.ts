export class DashboardService {
    public async getMetrics() {
        const sizeType = "mb";

        const response = await fetch(`http://localhost:8000/api/dashboard/metrics?return_in_size_type=${sizeType}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });
        const data = await response.json();
        console.log('Dashboard metrics response:', data);
        return data;
    }
}