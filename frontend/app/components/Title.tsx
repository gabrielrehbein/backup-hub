type HeadingProps = {
  title: string;
} & React.InputHTMLAttributes<HTMLHeadingElement>; ;

export function Title({title}: HeadingProps) {
  return (
    <h1 className="text-2xl font-bold text-slate-900">{title}</h1>
  );
}