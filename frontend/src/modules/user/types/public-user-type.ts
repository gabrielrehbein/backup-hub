export type PublicUserType = {
    id: number;
    name: string;
    email: string;
    role: "default" | "admin";
    phone: string;
    createdAt: Date;
    updatedAt: Date;
};