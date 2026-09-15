import { SearchIcon } from "lucide-react";
import { Button } from "./Button";

type InputProps = {
    label: string;
} & React.InputHTMLAttributes<HTMLInputElement>;

export function Input({ label, type, placeholder, value, onChange, ...props }: InputProps) {
    return (
        <div className="flex w-full gap-2 justify-center items-center">
            <div className="w-full flex flex-col gap-2">
                
                {label && 
                <label htmlFor="input" className="text-sm font-medium text-gray-700">{label}</label>}
                <div className="flex gap-2 w-full justify-between">
                    <input
                        id="input"
                        type={type}
                        placeholder={placeholder}
                        value={value}
                        onChange={onChange}
                        className="border w-full border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <div>
                        <Button size="small">
                            <SearchIcon />
                        </Button>
                    </div>
                </div>
            </div>


        </div>
    )
}