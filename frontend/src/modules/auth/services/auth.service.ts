import type { LoginDTO } from '../DTOs/login.dto';
import type { PublicUserType } from '../../user/types/public-user-type';

export class AuthService {
    protected readonly baseUrl = 'http://localhost:8000/api';

    public async login(loginDTO: LoginDTO): Promise<boolean> {
       
        try {
        const response = await fetch(`${this.baseUrl}/tokens/create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(loginDTO),
        });

        const data = await response.json();

        localStorage.setItem('backup-hub-token', await data.data.token || '');

        return response.ok;
        } catch (error) {
            console.error('Login error:', error);
            return false;
        }
    }

    public async logout(): Promise<boolean> {
        const response = await fetch(`${this.baseUrl}/tokens/delete`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('backup-hub-token') || ''}`,
            },
        });

        console.log('Logout response:', response);

        localStorage.removeItem('backup-hub-token');
        return response.ok;
    }

    public async getAuthUser(): Promise<PublicUserType | null> {
        const token = localStorage.getItem('backup-hub-token');

        if (!token) {
            return null;
        }
        const response = await fetch(`${this.baseUrl}/users/auth/me`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
        });


        const data = await response.json();

        console.log('User data:', response);

        return data.data;

    }
}