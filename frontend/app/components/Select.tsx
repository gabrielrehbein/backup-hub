
type InputProps = {
    label?: string;
    children: React.ReactNode;
} & React.InputHTMLAttributes<HTMLInputElement>;

export function Select({ children, label, value, onChange, ...props }: InputProps) {
    const disabledClasses = props.disabled ? 'bg-gray-200 cursor-not-allowed' : '';
    return (
        <div className="flex w-full gap-2 justify-center items-center">
            <div className="w-full flex flex-col gap-2">

                {
                label &&
                    <label htmlFor="input" className="text-sm font-semibold text-slate-700 flex gap-1">
                        {label}{props.required && <span className="text-red-500">*</span>}
                    </label>
                }
                <div className="flex gap-2 w-full justify-between">
                    <select
                        value={value}
                        onChange={onChange}
                        name={props.name}
                        id={props.id}
                        className={`border border-slate-300 w-full rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent ${disabledClasses}`}
                        {...props}
                   >
                        {children}
                    </select>
                </div>
            </div>


        </div>


    )
}