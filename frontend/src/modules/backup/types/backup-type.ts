type SizeType = "mb" | "kb" | "gb"


export type BackupType = {
    id: number;
    size: number;
    risk: number;
    size_type: SizeType;
    generated_at: string;
    source_ip: string;
    is_local: boolean;
    system_instance_id: number;
    client_name: string;
    system_name: string;
    version: string;
    file_path: string;
};