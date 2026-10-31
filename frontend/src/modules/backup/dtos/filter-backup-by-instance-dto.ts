export enum RiskTypeEnum {
    TIME = "time",
    SIZE = "size"
}

export class FilterLastBackupByInstanceDTO {
    constructor(
        public readonly planId: string | null,
        public readonly clientId: string | null,
        public readonly riskName: string | null,
        public readonly riskType: RiskTypeEnum | null,
        public readonly generatedAtStart: number | null,
        public readonly generatedAtEnd: number | null,
        public readonly minSize: number | null,
        public readonly maxSize: number | null
    ) {}

    public static fromObject(data: Record<string, any>): FilterLastBackupByInstanceDTO {
        return new FilterLastBackupByInstanceDTO(
            data.plan_id ?? null,
            data.client_id ?? null,
            data.risk_id ?? null,
            data.type ? RiskTypeEnum[data.type as keyof typeof RiskTypeEnum] : null,
            data.generated_at_start ?? null,
            data.generated_at_end ?? null,
            data.min_size ?? null,
            data.max_size ?? null
        );
    }

    public toObject(): Record<string, any> {
        return {
            plan_id: this.planId,
            client_id: this.clientId,
            risk_name: this.riskName,
            risk_type: this.riskType,
            generated_at_start: this.generatedAtStart,
            generated_at_end: this.generatedAtEnd,
            min_size: this.minSize,
            max_size: this.maxSize,
        };
    }
}