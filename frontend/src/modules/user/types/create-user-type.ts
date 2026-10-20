
export type CreateUserType = {
    name: string;
    email: string;
    phone: string;
    role: "default" | "admin";
    password: string;
};