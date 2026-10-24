type HeadingProps = {
  title: string;
} & React.InputHTMLAttributes<HTMLHeadingElement>; ;

export function Title({title, ...props}: HeadingProps) {
  return (
    <h1 {...props} className="text-2xl font-bold text-slate-900" >{title}</h1>
  );
}