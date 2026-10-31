"use client";

import { Button } from "@/app/components/Button"
import { Container } from "@/app/components/Container"
import Header from "@/app/components/Header"
import { Input } from "@/app/components/Input"
import { Select } from "@/app/components/Select";
import { FilterLastBackupByInstanceDTO, RiskTypeEnum } from "@/src/modules/backup/dtos/filter-backup-by-instance-dto";
import { BackupService } from "@/src/modules/backup/services/backup.service";
import { BackupType } from "@/src/modules/backup/types/backup-type";
import { ClientType } from "@/src/modules/client/types/client-type";
import { ClientService } from "@/src/modules/client/services/clients.service";
import { PlanService } from "@/src/modules/client/services/plans.service";
import { PlanType } from "@/src/modules/client/types/plan-type";
import { RiskService } from "@/src/modules/risk/services/risks.service";
import { RiskType } from "@/src/modules/risk/types/risk-type";
import { ChevronLeftIcon, CircleCheckIcon, CircleXIcon, FunnelIcon, XIcon } from "lucide-react"
import { useRouter } from "next/navigation"

import { FormEvent, useEffect, useMemo, useState } from "react"
import { toast } from "react-toastify";
import { BackupRoutes } from "@/src/modules/backup/routes/backup-routes";

type FilterForm = {
    planId: string;
    clientId: string;
    riskName: string;
    riskType: string;
    generatedAtStart: string;
    generatedAtEnd: string;
    minSizeMb: string;
    maxSizeMb: string;
};

const EMPTY_FILTERS: FilterForm = {
    planId: "",
    clientId: "",
    riskName: "",
    riskType: "",
    generatedAtStart: "",
    generatedAtEnd: "",
    minSizeMb: "",
    maxSizeMb: "",
};

// A API trabalha com KB; o formulário, com MB.
const mbToKb = (value: string) => (value === "" ? null : Math.round(Number(value) * 1024));

// O input datetime-local vem sem fuso; converte para ISO (UTC) para a API.
const localDateToIso = (value: string) => (value === "" ? null : new Date(value).toISOString());

function toFilterDTO(form: FilterForm): FilterLastBackupByInstanceDTO {
    return FilterLastBackupByInstanceDTO.fromObject({
        plan_id: form.planId,
        client_id: form.clientId,
        risk_name: form.riskName,
        risk_type: form.riskType,
        generated_at_start: localDateToIso(form.generatedAtStart),
        generated_at_end: localDateToIso(form.generatedAtEnd),
        min_size: mbToKb(form.minSizeMb),
        max_size: mbToKb(form.maxSizeMb),
    });
}

function loadBackups(form: FilterForm): Promise<BackupType[]> {
    return new BackupService().getLastBackupByInstance(toFilterDTO(form), "mb");
}

function showLoadError(error: unknown) {
    toast.error("Erro ao carregar os backups: " + (error instanceof Error ? error.message : String(error)));
}

export default function ListBackups() {
    const [backups, setBackups] = useState<BackupType[]>([]);
    const [clients, setClients] = useState<ClientType[]>([]);
    const [plans, setPlans] = useState<PlanType[]>([]);
    const [risks, setRisks] = useState<RiskType[]>([]);
    const [filters, setFilters] = useState<FilterForm>(EMPTY_FILTERS);
    const [loading, setLoading] = useState(true);

    const router = useRouter();

    const applyFilters = async (form: FilterForm) => {
        setLoading(true);
        try {
            setBackups(await loadBackups(form));
        } catch (error) {
            showLoadError(error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        const fetchBackups = async () => {
            try {
                setBackups(await loadBackups(EMPTY_FILTERS));
            } catch (error) {
                showLoadError(error);
            } finally {
                setLoading(false);
            }
        };
        fetchBackups();
    }, []);

    // Os riscos são cadastrados por plano, então o mesmo nome pode se repetir.
    const riskNames = useMemo(
        () => Array.from(new Set(risks.map((risk) => risk.name))),
        [risks]
    );

    const updateFilter = (field: keyof FilterForm, value: string) => {
        setFilters((current) => ({ ...current, [field]: value }));
    };

    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        applyFilters(filters);
    };

    const handleClear = () => {
        setFilters(EMPTY_FILTERS);
        applyFilters(EMPTY_FILTERS);
    };

    useEffect(() => {
        const fetchRisks = async () => {
            const riskService = new RiskService();
            try {
                const risksData = await riskService.getRisks();
                setRisks(risksData);
            } catch (error) {
                toast.error("Erro ao carregar os riscos: " + error);
            }
        }
        fetchRisks();
    }, [])

    useEffect(() => {
        const fetchPlans = async () => {
            const planService = new PlanService();
            try {
                const plansData = await planService.getPlans();
                setPlans(plansData);
            } catch (error) {
                toast.error("Erro ao carregar os planos: " + error);
            }
        }
        fetchPlans();
    }, [])


    useEffect(() => {
        const fetchClients = async () => {
            const clientService = new ClientService();
            try {
                const clientsData = await clientService.getClients();
                setClients(clientsData);
            } catch (error) {
                toast.error("Erro ao carregar os clientes: " + error);
            }
        }
        fetchClients();
    }, []);


    const handleOnLongPath = (path: string) => {
        if (path.length > 20) {
            return path.substring(0, 20) + "...";
        }
        return path;
    }

    return (
        <Container>
            <Header />
            <div className="flex items-center justify-between mb-4">
                <h1 className="text-2xl font-bold">Backups</h1>
                <Button variant="secondary" size="small" onClick={() => history.back()}>
                    <ChevronLeftIcon />
                </Button>
            </div>
            <div className="flex-col gap-4">
                <form className="w-full flex flex-col gap-4" onSubmit={handleSubmit}>
                    <div className="flex w-full gap-4 items-end justify-between">

                        <Input label="Inicio" required={false} type="datetime-local"
                            value={filters.generatedAtStart}
                            onChange={(e) => updateFilter("generatedAtStart", e.target.value)} />
                        <Input label="Fim" required={false} type="datetime-local"
                            value={filters.generatedAtEnd}
                            onChange={(e) => updateFilter("generatedAtEnd", e.target.value)} />

                        <Input label="Tamanho mínimo (MB)" required={false} type="number" min={0} step="any"
                            value={filters.minSizeMb}
                            onChange={(e) => updateFilter("minSizeMb", e.target.value)} />
                        <Input label="Tamanho máximo (MB)" required={false} type="number" min={0} step="any"
                            value={filters.maxSizeMb}
                            onChange={(e) => updateFilter("maxSizeMb", e.target.value)} />
                    </div>

                    <div className="flex w-full gap-4 items-end justify-between">

                        <Select label="Plano" value={filters.planId} onChange={(e) => updateFilter("planId", e.target.value)}>
                            <option value="">Todos</option>
                            {
                                plans.map((plan) => (
                                    <option key={plan.id} value={plan.id}>{plan.name}</option>
                                ))
                            }
                        </Select>
                        <Select label="Cliente" value={filters.clientId} onChange={(e) => updateFilter("clientId", e.target.value)}>
                            <option value="">Todos</option>
                            {
                                clients.map((client) => (
                                    <option key={client.id} value={client.id}>{client.name}</option>
                                ))
                            }
                        </Select>
                        <Select label="Risco" value={filters.riskName} onChange={(e) => updateFilter("riskName", e.target.value)}>
                            <option value="">Todos</option>
                            {
                                riskNames.map((name) => (
                                    <option key={name} value={name}>{name}</option>
                                ))
                            }
                        </Select>
                        <Select label="Tipo do Risco" value={filters.riskType} onChange={(e) => updateFilter("riskType", e.target.value)}>
                            <option value="">Todos</option>
                            <option value={RiskTypeEnum.TIME}>Tempo</option>
                            <option value={RiskTypeEnum.SIZE}>Tamanho</option>
                        </Select>
                    </div>
                    <div className="flex gap-4 my-4">
                        <Button type="submit" variant="primary" size="large" disabled={loading}>
                            <FunnelIcon /> {loading ? "Filtrando..." : "Filtrar"}
                        </Button>
                        <Button type="button" variant="secondary" size="large" onClick={handleClear} disabled={loading}>
                            <XIcon /> Limpar
                        </Button>
                    </div>
                </form>

            </div>
            <div>
                <table className="w-full text-sm text-left">
                    <thead className="border-b border-gray-200 text-gray-500">

                        <tr>
                            <th className="px-4 py-3 font-medium">
                                ID
                            </th>
                            <th className="px-4 py-3 font-medium">
                                Cliente
                            </th>

                            <th className="px-4 py-3 font-medium">
                                Sistema
                            </th>

                            <th className="px-4 py-3 font-medium">
                                Gerado em
                            </th>

                            <th className="px-4 py-3 font-medium">
                                Tamanho
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                IP de origem
                            </th>

                            <th className="px-6 py-3 font-medium text-slate-500">
                                Caminho do arquivo
                            </th>

                            <th className="px-4 py-3 font-medium">
                                Risco
                            </th>

                            <th className="px-4 py-3 font-medium">
                                Remoto
                            </th>
                        </tr>

                    </thead>

                    <tbody>
                        {backups.length === 0 ? (
                            <tr>
                                <td colSpan={9} className="px-6 py-4 text-slate-500">
                                    {loading ? "Carregando..." : "Nenhum backup encontrado."}
                                </td>
                            </tr>
                        ) : (
                            backups.map((backup, index) => (
                                <tr
                                    key={`${backup.client_name}-${index}`}
                                    className="cursor-pointer border-b border-gray-100 hover:bg-gray-200"
                                    onClick={() => router.push(BackupRoutes.DETAIL(backup.id))}
                                >
                                    <td className="px-6 py-4 font-medium text-slate-800">
                                        {backup.id}
                                    </td>
                                    <td className="px-6 py-4 font-medium text-slate-800">
                                        {backup.client_name}
                                    </td>
                                    <td className="px-6 py-4 font-medium text-slate-800">
                                        {backup.system_name}
                                    </td>

                                    <td className="px-6 py-4 text-slate-500">
                                        {backup.generated_at ? new Date(backup.generated_at).toLocaleString() : 'sem data'}
                                    </td>

                                    <td className="px-6 py-4 text-slate-700">
                                        {backup.size} {backup.size_type.toUpperCase()}
                                    </td>

                                    <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                        {backup.source_ip}
                                    </td>

                                    <td className="px-6 py-4 font-mono text-xs text-slate-500">
                                        {handleOnLongPath(backup.file_path)}
                                    </td>

                                    <td className="px-6 py-4 text-xs text-slate-500">
                                        {backup.risk}
                                    </td>

                                    <td className="px-6 py-4 text-slate-700">
                                        {backup.is_local ? <CircleXIcon color="#cb1a1a" size={"20px"} /> : <CircleCheckIcon color="#1ccc0f" size={"20px"} />}
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>

                </table>
            </div>
        </Container>
    )
}