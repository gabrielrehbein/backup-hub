export enum RiskTypeEnum {
    TIME = "time",
    SIZE = "size"
}


export class FilterLastBackupByInstanceDTO {
    constructor(
        public readonly planId: number | null = null,
        public readonly clientId: number | null = null,
        public readonly riskName: string | null = null,
        public readonly riskType: RiskTypeEnum | null = null,
        public readonly generatedAtStart: string | null = null,
        public readonly generatedAtEnd: string | null = null,
        public readonly minSize: number | null = null,
        public readonly maxSize: number | null = null,
        public readonly version: string | null = null
    ) {}

    public static fromObject(data: Record<string, unknown>): FilterLastBackupByInstanceDTO {
        const toNumber = (value: unknown) =>
            value === undefined || value === null || value === "" ? null : Number(value);
        const toText = (value: unknown) =>
            value === undefined || value === null || value === "" ? null : String(value);
        const riskType = Object.values(RiskTypeEnum).includes(data.risk_type as RiskTypeEnum)
            ? (data.risk_type as RiskTypeEnum)
            : null;

        return new FilterLastBackupByInstanceDTO(
            toNumber(data.plan_id),
            toNumber(data.client_id),
            toText(data.risk_name),
            riskType,
            toText(data.generated_at_start),
            toText(data.generated_at_end),
            toNumber(data.min_size),
            toNumber(data.max_size),
            toText(data.version)
        );
    }

    public toObject(): Record<string, string | number | null> {
        return {
            plan_id: this.planId,
            client_id: this.clientId,
            risk_name: this.riskName,
            risk_type: this.riskType,
            generated_at_start: this.generatedAtStart,
            generated_at_end: this.generatedAtEnd,
            min_size: this.minSize,
            max_size: this.maxSize,
            version: this.version
        };
    }

    /** Monta a query string ignorando filtros vazios. */
    public toQueryParams(): URLSearchParams {
        const params = new URLSearchParams();
        Object.entries(this.toObject()).forEach(([key, value]) => {
            if (value !== null && value !== "" && !Number.isNaN(value)) {
                params.append(key, String(value));
            }
        });
        return params;
    }
}
