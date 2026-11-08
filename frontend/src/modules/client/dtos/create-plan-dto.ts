export class CreatePlanDto {
    name: string;
    description: string;

    constructor(name: string, description: string) {
        this.name = name;
        this.description = description;
    }

    public toJson(): string {
        return JSON.stringify({
            name: this.name,
            description: this.description,
        });
    }
}