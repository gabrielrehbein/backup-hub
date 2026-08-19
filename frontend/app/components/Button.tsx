"use client";

type ButtonProps = {
    children: React.ReactNode;
    className?: string;
    variant?: "primary" | "secondary" | "danger";
    size?: "small" | "medium" | "large";
} & React.ButtonHTMLAttributes<HTMLButtonElement>;

export function Button({ children, className, variant = "primary", size = "medium", disabled, ...props }: ButtonProps) {
    let baseClasses = "cursor-pointer transition text-white rounded px-4 py-2 font-bold flex items-center gap-2 justify-center";
    let sizeClasses = "";
    let variantClasses = "";

    switch (variant) {
        case "primary":
            variantClasses = "bg-blue-500 hover:bg-blue-700";
            break;
        case "secondary":
            variantClasses = "bg-gray-500 hover:bg-gray-700";
            break;
        case "danger":
            variantClasses = "bg-red-500 hover:bg-red-700";
            break;
    }

    switch (size) {
        case "small":
            sizeClasses = "w-12  text-sm";
            break;
        case "medium":
            sizeClasses = "w-22 text-base";
            break;
        case "large":
            sizeClasses = "w-full text-lg";
            break;
    }

    let disabledClasses = "";

    if (disabled) {
        disabledClasses = "bg-slate-400 hover:bg-slate-400 cursor-not-allowed";
    }


    return (
        <button
            className={`${baseClasses} ${variantClasses} ${sizeClasses} ${disabledClasses}`}
            disabled={disabled}
            {...props}
        >
            {children}
        </button>
    );
}