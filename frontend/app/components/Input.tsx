

type InputProps = {
    label?: string;
} & React.InputHTMLAttributes<HTMLInputElement>;

export function Input({ label, type, placeholder, value, onChange, ...props }: InputProps) {
    return (
        <div className="flex w-full gap-2 justify-center items-center">
            <div className="w-full flex flex-col gap-2">
                
                {label && 
                <label htmlFor="input" className="text-sm font-semibold text-slate-700 flex gap-1">{label}{props.required ?? <span className="text-red-500">*</span>}</label>}

                <input
                    id="input"
                    type={type}
                    placeholder={placeholder}
                    value={value}
                    onChange={onChange}
                    className="border w-full border-slate-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />

            </div>


        </div>
    )
}