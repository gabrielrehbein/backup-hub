"use client";

type ButtonProps = {
    children: React.ReactNode;
    variant?: "primary" | "secondary" | "danger" | "ghost";
    size?: "small" | "medium" | "large";
} & React.ButtonHTMLAttributes<HTMLButtonElement>;

export function Button({ children, variant = "primary", size = "medium", disabled, ...props }: ButtonProps) {
    const baseClasses = "cursor-pointer transition text-white rounded px-4 py-2 font-bold flex items-center gap-2 justify-center";
    let sizeClasses = "";
    let variantClasses = "";

    switch (variant) {
        case "primary":
            variantClasses = "bg-indigo-500 hover:bg-indigo-700";
            break;
        case "secondary":
            variantClasses = "bg-mist-950 hover:bg-black/60";
            break;
        case "danger":
            variantClasses = "bg-red-500 hover:bg-red-700";
            break;
        case "ghost":
            variantClasses = "bg-gray-200 text-gray-800";
            break;
    }

    switch (size) {
        case "small":
            sizeClasses = "w-12  text-sm";
            break;
        case "medium":
            sizeClasses = "w-26 text-base";
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
        {...props}
            className={`${baseClasses} ${variantClasses} ${sizeClasses} ${disabledClasses} ${props.className || ""}`}
            disabled={disabled}

        >
            {children}
        </button>
    );
}