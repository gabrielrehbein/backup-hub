export type PublicUserType = {
    id: number;
    name: string;
    email: string;
    role: "default" | "admin";
    createdAt: Date;
    updatedAt: Date;
};